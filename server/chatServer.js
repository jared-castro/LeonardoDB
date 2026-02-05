const WebSocket = require('ws');
const axios = require('axios');
const mysql = require('mysql2/promise');
const path = require('path');

require('dotenv').config({ path: path.join(__dirname, '..', '.env') });

const wss = new WebSocket.Server({ port: 8080 });

const dbConfig = {
    host: process.env.DB_HOST || 'localhost',
    user: process.env.DB_USERNAME || 'root',
    password: process.env.DB_PASSWORD || '',
    database: process.env.DB_DATABASE || 'leonardodb'
};

const conversationHistory = new Map();

wss.on('connection', (ws) => {
    ws.on('message', async (message) => {
        try {
            const data = JSON.parse(message);
            const { type, userId, mensaje, proyectoId } = data;

            if (type === 'chat_message') {
                await handleChatMessage(ws, userId, mensaje, proyectoId);
            } else if (type === 'clear_history') {
                clearHistory(userId, proyectoId);
                ws.send(JSON.stringify({ 
                    type: 'history_cleared', 
                    success: true 
                }));
            }
        } catch (error) {
            ws.send(JSON.stringify({ 
                type: 'error', 
                message: 'Error procesando tu mensaje' 
            }));
        }
    });

    ws.on('close', () => {});
});

async function handleChatMessage(ws, userId, userMessage, proyectoId) {
    try {
        if (!userId || userId === 'undefined' || userId === 'null') {
            ws.send(JSON.stringify({ 
                type: 'error', 
                message: 'Error: Usuario no identificado' 
            }));
            return;
        }

        const apiConfig = await getUserApiConfig(userId);
        
        if (!apiConfig) {
            ws.send(JSON.stringify({ 
                type: 'error', 
                message: 'No tienes una API configurada' 
            }));
            return;
        }

        let projectContext = '';
        if (proyectoId) {
            projectContext = await getProjectContext(proyectoId);
        }

        const conversationKey = `${userId}_${proyectoId || 'general'}`;
        if (!conversationHistory.has(conversationKey)) {
            conversationHistory.set(conversationKey, []);
        }
        const history = conversationHistory.get(conversationKey);

        const systemMessage = `Eres un experto profesional en bases de datos, especializado en SQL y MySQL. Solo debes dar explicaciones, recomendaciones, soluciones y ejemplos relacionados con bases de datos, consultas, optimización, diseño de esquemas, índices, triggers, procedimientos almacenados y seguridad en bases de datos. No debes explicar temas que no estén relacionados con bases de datos. Si la consulta no es sobre bases de datos, responde con 'Lo siento, solo puedo ayudar con temas de bases de datos SQL/MySQL.'${projectContext ? `\n\n${projectContext}` : ''}`;

        const messages = [
            {
                role: "system",
                content: systemMessage
            },
            ...history.slice(-10),
            {
                role: "user",
                content: userMessage
            }
        ];

        ws.send(JSON.stringify({ 
            type: 'typing', 
            isTyping: true 
        }));

        const aiResponse = await callAIAPI(apiConfig, messages);

        history.push({ role: "user", content: userMessage });
        history.push({ role: "assistant", content: aiResponse });

        if (history.length > 20) {
            conversationHistory.set(conversationKey, history.slice(-20));
        }

        ws.send(JSON.stringify({ 
            type: 'ai_response', 
            message: aiResponse,
            userMessage: userMessage,
            timestamp: new Date().toISOString()
        }));

    } catch (error) {
        ws.send(JSON.stringify({ 
            type: 'error', 
            message: error.message || 'Error al procesar tu mensaje'
        }));
    }
}

async function callAIAPI(apiConfig, messages) {
    const { api_key, end_point, modelo } = apiConfig;

    try {
        let url = end_point;
        let headers = {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${api_key}`
        };
        
        let requestBody = {
            model: modelo,
            messages: messages,
            temperature: 0.7,
            max_tokens: 2000,
            stream: false
        };

        if (end_point.includes('anthropic.com')) {
            url = `${end_point}/v1/messages`;
            headers = {
                'Content-Type': 'application/json',
                'x-api-key': api_key,
                'anthropic-version': '2023-06-01'
            };
            
            const systemMessage = messages.find(m => m.role === 'system');
            const userMessages = messages.filter(m => m.role !== 'system');
            
            requestBody = {
                model: modelo,
                max_tokens: 2000,
                messages: userMessages,
                system: systemMessage ? systemMessage.content : ''
            };
        } else if (end_point.includes('googleapis.com') || end_point.includes('generativelanguage')) {
            url = `${end_point}/v1beta/models/${modelo}:generateContent?key=${api_key}`;
            headers = {
                'Content-Type': 'application/json'
            };
            
            const contents = messages.filter(m => m.role !== 'system').map(m => ({
                role: m.role === 'assistant' ? 'model' : 'user',
                parts: [{ text: m.content }]
            }));
            
            requestBody = {
                contents: contents,
                generationConfig: {
                    temperature: 0.7,
                    maxOutputTokens: 2000
                }
            };
        } else {
            if (!end_point.endsWith('/chat/completions') && 
                !end_point.endsWith('/v1') && 
                !end_point.includes('/chat/completions')) {
                url = end_point.endsWith('/') ? 
                    `${end_point}chat/completions` : 
                    `${end_point}/chat/completions`;
            } else if (end_point.endsWith('/v1')) {
                url = `${end_point}/chat/completions`;
            }
        }

        const response = await axios.post(url, requestBody, { 
            headers,
            timeout: 60000,
            validateStatus: function (status) {
                return status < 600;
            }
        });

        if (response.status >= 400) {
            let errorMessage = 'Error en la API';
            
            if (response.status === 401) {
                errorMessage = 'API Key inválida';
            } else if (response.status === 429) {
                errorMessage = 'Límite de peticiones excedido';
            } else if (response.data?.error?.message) {
                errorMessage = response.data.error.message;
            }
            
            throw new Error(errorMessage);
        }

        let aiResponse = '';

        if (response.data.content && Array.isArray(response.data.content)) {
            aiResponse = response.data.content
                .filter(item => item.type === 'text')
                .map(item => item.text)
                .join('\n');
        } else if (response.data.choices && response.data.choices[0]?.message?.content) {
            aiResponse = response.data.choices[0].message.content;
        } else if (response.data.candidates && response.data.candidates[0]?.content?.parts) {
            aiResponse = response.data.candidates[0].content.parts
                .map(part => part.text)
                .join('\n');
        } else if (response.data.response) {
            aiResponse = response.data.response;
        } else if (response.data.text) {
            aiResponse = response.data.text;
        } else if (response.data.message) {
            aiResponse = response.data.message;
        } else {
            throw new Error('Formato de respuesta no reconocido');
        }

        if (!aiResponse || aiResponse.trim() === '') {
            throw new Error('La API devolvió una respuesta vacía');
        }

        return aiResponse;

    } catch (error) {
        if (error.response) {
            let errorMsg = 'Error en la petición a la API';
            
            if (error.response.status === 401) {
                errorMsg = 'API Key inválida';
            } else if (error.response.status === 429) {
                errorMsg = 'Límite de peticiones excedido';
            } else if (error.response.data?.error?.message) {
                errorMsg = error.response.data.error.message;
            }
            
            throw new Error(errorMsg);
        } else if (error.code === 'ECONNREFUSED') {
            throw new Error('No se pudo conectar al servidor');
        } else if (error.code === 'ETIMEDOUT') {
            throw new Error('Tiempo de espera agotado');
        } else {
            throw new Error(error.message);
        }
    }
}

async function getUserApiConfig(userId) {
    const connection = await mysql.createConnection(dbConfig);
    try {
        const [rows] = await connection.execute(
            'SELECT api_key, end_point, modelo FROM leonardoapi WHERE id_usuario = ?',
            [userId]
        );
        return rows[0] || null;
    } finally {
        await connection.end();
    }
}

async function getProjectContext(proyectoId) {
    const connection = await mysql.createConnection(dbConfig);
    try {
        const [proyecto] = await connection.execute(
            'SELECT nombre, descripcion FROM proyectosleonardo WHERE id_proyecto = ?',
            [proyectoId]
        );

        if (!proyecto[0]) return '';

        const [tablas] = await connection.execute(
            'SELECT id_tabla, nombre_tabla, color_tabla FROM leonardotablas WHERE id_proyecto = ?',
            [proyectoId]
        );

        let estructuraJSON = {
            proyecto: {
                nombre: proyecto[0].nombre,
                descripcion: proyecto[0].descripcion || 'Sin descripción'
            },
            tablas: []
        };

        for (const tabla of tablas) {
            const [columnas] = await connection.execute(
                'SELECT id_columna, nombre_columna, tipo_columna, longitud_columna, nulo_columna, auto_incrementar, indice_tipo, descripcion_columna FROM leonardocolumna WHERE id_tabla = ?',
                [tabla.id_tabla]
            );

            const columnasIds = columnas.map(c => c.id_columna);

            let relaciones = [];
            if (columnasIds.length > 0) {
                const placeholders = columnasIds.map(() => '?').join(',');
                const [relacionesResult] = await connection.execute(
                    `SELECT r.id_relacion, r.id_columna_1, r.id_columna_2, r.color_relacion,
                            c1.nombre_columna as columna_origen, c2.nombre_columna as columna_destino,
                            t1.nombre_tabla as tabla_origen, t2.nombre_tabla as tabla_destino
                     FROM leonardorelacion r
                     LEFT JOIN leonardocolumna c1 ON r.id_columna_1 = c1.id_columna
                     LEFT JOIN leonardocolumna c2 ON r.id_columna_2 = c2.id_columna
                     LEFT JOIN leonardotablas t1 ON c1.id_tabla = t1.id_tabla
                     LEFT JOIN leonardotablas t2 ON c2.id_tabla = t2.id_tabla
                     WHERE r.id_columna_1 IN (${placeholders}) OR r.id_columna_2 IN (${placeholders})`,
                    [...columnasIds, ...columnasIds]
                );
                relaciones = relacionesResult;
            }

            const [indices] = await connection.execute(
                'SELECT id_index, id_columna FROM leonardorindex WHERE id_tabla = ?',
                [tabla.id_tabla]
            );

            estructuraJSON.tablas.push({
                nombre: tabla.nombre_tabla,
                color: tabla.color_tabla,
                columnas: columnas.map(col => ({
                    nombre: col.nombre_columna,
                    tipo: col.tipo_columna,
                    longitud: col.longitud_columna,
                    nulo: col.nulo_columna ? 'YES' : 'NO',
                    auto_increment: col.auto_incrementar || 'NO',
                    indice_tipo: col.indice_tipo,
                    descripcion: col.descripcion_columna
                })),
                relaciones: relaciones.map(rel => ({
                    columna_origen: rel.columna_origen,
                    tabla_origen: rel.tabla_origen,
                    columna_destino: rel.columna_destino,
                    tabla_destino: rel.tabla_destino
                })),
                indices: indices.map(idx => ({
                    id_columna: idx.id_columna
                }))
            });
        }

        const contextText = `CONTEXTO DEL PROYECTO:
Proyecto: "${proyecto[0].nombre}"
${proyecto[0].descripcion ? `Descripción: ${proyecto[0].descripcion}` : ''}

ESTRUCTURA COMPLETA:
${JSON.stringify(estructuraJSON, null, 2)}

INSTRUCCIONES:
1. Tienes acceso completo a la estructura de TODAS las tablas del proyecto
2. Usa EXACTAMENTE los nombres de tablas y columnas tal como aparecen en el JSON
3. Cuando pregunten por tablas, campos o relaciones, usa los datos del JSON
4. Para recomendaciones, analiza la estructura REAL en el JSON
5. Si preguntan por algo que no existe, indica qué tablas SÍ existen

TABLAS DISPONIBLES:
${estructuraJSON.tablas.map(t => `- ${t.nombre}`).join('\n')}
`;

        return contextText;
    } catch (error) {
        return '';
    } finally {
        await connection.end();
    }
}

function clearHistory(userId, proyectoId) {
    const conversationKey = `${userId}_${proyectoId || 'general'}`;
    conversationHistory.delete(conversationKey);
}

setInterval(() => {
    if (conversationHistory.size > 100) {
        const keys = Array.from(conversationHistory.keys());
        keys.slice(0, keys.length - 50).forEach(key => conversationHistory.delete(key));
    }
}, 30 * 60 * 1000);