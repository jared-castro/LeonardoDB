<template>
    <div class="dashboard">
        <nav class="navbar">
            <div class="navbar-content">
                <div class="logo-section">
                    <h1 class="logo">LeonardoDB</h1>
                </div>

                <div class="nav-menu">
                    <div class="nav-item" @click="volverIA">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M19 12H5M12 19l-7-7 7-7"/>
                        </svg>
                        <span>Volver al Chat General</span>
                    </div>
                </div>

                <div class="nav-actions">
                    <div class="user-avatar" @click="toggleMenu">
                        <span>{{ inicialUsuario }}</span>
                    </div>

                    <div v-if="menuAbierto" class="dropdown-menu">
                        <div class="menu-header">
                            <div class="avatar-large">{{ inicialUsuario }}</div>
                            <div class="user-info">
                                <p class="user-nombre">{{ usuario.nombre }}</p>
                                <p class="user-username">@{{ usuario.usuario }}</p>
                            </div>
                        </div>

                        <div class="menu-divider"></div>

                        <div class="menu-items">
                            <div class="menu-item logout" @click="cerrarSesion">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                    <polyline points="16 17 21 12 16 7"></polyline>
                                    <line x1="21" y1="12" x2="9" y2="12"></line>
                                </svg>
                                <span>Cerrar Sesión</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <div class="background-art">
            <div class="circle circle1"></div>
            <div class="circle circle2"></div>
            <div class="circle circle3"></div>
            <div class="database-lines"></div>
        </div>

        <div class="main-layout">
            <div class="chat-container">
                <div class="chat-header">
                    <div class="header-info">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                        </svg>
                        <div>
                            <h2>{{ nombreProyecto }}</h2>
                            <p class="proyecto-subtitulo">Asistente especializado en este proyecto</p>
                        </div>
                    </div>
                    <button class="btn-limpiar" @click="limpiarChat" :disabled="mensajes.length === 0">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="3 6 5 6 21 6"></polyline>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                        </svg>
                        Limpiar Chat
                    </button>
                </div>

                <div class="chat-messages" ref="chatMessages">
                    <div v-if="mensajes.length === 0" class="mensaje-bienvenida">
                        <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="9" y1="9" x2="15" y2="9"></line>
                            <line x1="9" y1="15" x2="15" y2="15"></line>
                        </svg>
                        <h3>Asistente del Proyecto</h3>
                        <p>Tengo acceso completo a la estructura de tu base de datos. Pregúntame sobre optimizaciones, relaciones, índices o mejores prácticas.</p>
                    </div>

                    <div v-for="(mensaje, index) in mensajes" :key="index" class="mensaje" :class="mensaje.rol">
                        <div class="mensaje-avatar">
                            <span v-if="mensaje.rol === 'usuario'">{{ inicialUsuario }}</span>
                            <svg v-else width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                            </svg>
                        </div>
                        <div class="mensaje-contenido">
                            <div class="mensaje-texto">{{ mensaje.texto }}</div>
                        </div>
                    </div>

                    <div v-if="cargandoRespuesta" class="mensaje asistente">
                        <div class="mensaje-avatar">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                            </svg>
                        </div>
                        <div class="mensaje-contenido">
                            <div class="typing-indicator">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="chat-input-area">
                    <div class="input-wrapper">
                        <textarea 
                            v-model="mensajeInput"
                            placeholder="Pregunta sobre tu base de datos..."
                            rows="1"
                            @keydown.enter.prevent="enviarMensaje"
                            :disabled="!configValida || cargandoRespuesta"
                        ></textarea>
                        <button 
                            class="btn-enviar" 
                            @click="enviarMensaje"
                            :disabled="!configValida || cargandoRespuesta || !mensajeInput.trim()"
                        >
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="22" y1="2" x2="11" y2="13"></line>
                                <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                            </svg>
                        </button>
                    </div>
                    <div v-if="!configValida" class="advertencia-config">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="12"></line>
                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                        </svg>
                        Configura tu API de IA para usar el asistente
                    </div>
                </div>
            </div>

            <div class="sidebar-derecho">
                <div class="sidebar-section">
                    <div class="section-header">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                        </svg>
                        <h3>Estructura del Proyecto</h3>
                    </div>
                    <div class="section-content-estructura">
                        <div v-if="cargandoEstructura" class="loading-estructura">
                            <div class="mini-loader"></div>
                            <p>Cargando estructura...</p>
                        </div>

                        <div v-else-if="tablas.length === 0" class="sin-tablas">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="8" x2="12" y2="12"></line>
                                <line x1="12" y1="16" x2="12.01" y2="16"></line>
                            </svg>
                            <p>Este proyecto no tiene tablas</p>
                        </div>

                        <div v-else class="lista-tablas">
                            <div 
                                v-for="tabla in tablas" 
                                :key="tabla.id_tabla"
                                class="tabla-item"
                            >
                                <div class="tabla-header" @click="toggleTabla(tabla.id_tabla)">
                                    <div class="tabla-nombre">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                        </svg>
                                        <span>{{ tabla.nombre_tabla }}</span>
                                    </div>
                                    <svg 
                                        class="icono-toggle" 
                                        :class="{ 'rotado': tablaExpandida === tabla.id_tabla }"
                                        width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    >
                                        <polyline points="6 9 12 15 18 9"></polyline>
                                    </svg>
                                </div>

                                <div v-if="tablaExpandida === tabla.id_tabla" class="tabla-detalles">
                                    <div v-if="cargandoDetalles" class="loading-detalles">
                                        <div class="mini-loader"></div>
                                    </div>

                                    <div v-else>
                                        <div v-if="columnas.length > 0" class="seccion-detalles">
                                            <h5>Columnas</h5>
                                            <div class="lista-columnas">
                                                <div v-for="columna in columnas" :key="columna.id_columna" class="columna-item">
                                                    <div class="columna-nombre">{{ columna.nombre_columna }}</div>
                                                    <div class="columna-tipo">{{ columna.tipo_columna }}{{ columna.longitud_columna ? `(${columna.longitud_columna})` : '' }}</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div v-if="relaciones.length > 0" class="seccion-detalles">
                                            <h5>Relaciones</h5>
                                            <div class="lista-relaciones">
                                                <div v-for="relacion in relaciones" :key="relacion.id_relacion" class="relacion-item">
                                                    <div class="relacion-info">
                                                        <span class="relacion-columna">{{ relacion.columna_origen }}</span>
                                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                                            <polyline points="12 5 19 12 12 19"></polyline>
                                                        </svg>
                                                        <span class="relacion-destino">{{ relacion.tabla_destino }}.{{ relacion.columna_destino }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div v-if="indices.length > 0" class="seccion-detalles">
                                            <h5>Índices</h5>
                                            <div class="lista-indices">
                                                <div v-for="indice in indices" :key="indice.id_index" class="indice-item">
                                                    <div class="indice-nombre">{{ indice.nombre_index }}</div>
                                                    <div class="indice-tipo">{{ indice.tipo_index }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'LeonardoIA2',
    data() {
        return {
            usuario: {},
            menuAbierto: false,
            idProyecto: null,
            nombreProyecto: '',
            mensajeInput: '',
            mensajes: [],
            cargandoRespuesta: false,
            configValida: false,
            socket: null,
            tablas: [],
            columnas: [],
            relaciones: [],
            indices: [],
            cargandoEstructura: true,
            cargandoDetalles: false,
            tablaExpandida: null,
            reconectarIntervalo: null
        };
    },
    computed: {
        inicialUsuario() {
            return this.usuario.nombre ? this.usuario.nombre.charAt(0).toUpperCase() : 'U';
        }
    },
    async mounted() {
        const user = localStorage.getItem('user');
        if (user) {
            this.usuario = JSON.parse(user);
            this.idProyecto = this.$route.params.id;
            await this.verificarConfiguracion();
            await this.cargarProyecto();
            await this.cargarEstructura();
            if (this.configValida) {
                this.conectarWebSocket();
            }
        } else {
            this.$router.push('/login');
        }
    },
    beforeUnmount() {
        if (this.socket) {
            this.socket.close();
        }
        if (this.reconectarIntervalo) {
            clearInterval(this.reconectarIntervalo);
        }
    },
    methods: {
        toggleMenu() {
            this.menuAbierto = !this.menuAbierto;
        },

        async verificarConfiguracion() {
            try {
                const token = localStorage.getItem('token');
                const response = await axios.get('/api/chat/config', {
                    headers: { 'Authorization': `Bearer ${token}` }
                });
                this.configValida = response.data.success && response.data.data.tiene_config;
            } catch (error) {
                this.configValida = false;
            }
        },

        async cargarProyecto() {
            try {
                const token = localStorage.getItem('token');
                const response = await axios.get('/api/proyectos/ver', {
                    headers: { 'Authorization': `Bearer ${token}` }
                });
                const proyecto = response.data.data.find(p => p.id_proyecto == this.idProyecto);
                if (proyecto) {
                    this.nombreProyecto = proyecto.nombre;
                } else {
                    this.$router.push('/leonardoia');
                }
            } catch (error) {
                this.$router.push('/leonardoia');
            }
        },

        async cargarEstructura() {
            this.cargandoEstructura = true;
            try {
                const token = localStorage.getItem('token');
                const response = await axios.get(`/api/chat/proyecto/${this.idProyecto}/contexto`, {
                    headers: { 'Authorization': `Bearer ${token}` }
                });
                this.tablas = response.data.data.tablas || [];
            } catch (error) {
                this.tablas = [];
            } finally {
                this.cargandoEstructura = false;
            }
        },

        async toggleTabla(idTabla) {
            if (this.tablaExpandida === idTabla) {
                this.tablaExpandida = null;
                return;
            }

            this.tablaExpandida = idTabla;
            this.cargandoDetalles = true;

            try {
                const token = localStorage.getItem('token');
                
                const [columnasRes, relacionesRes, indicesRes] = await Promise.all([
                    axios.get(`/api/columnas/tabla/${idTabla}`, {
                        headers: { 'Authorization': `Bearer ${token}` }
                    }),
                    axios.get(`/api/relaciones/tabla/${idTabla}`, {
                        headers: { 'Authorization': `Bearer ${token}` }
                    }),
                    axios.get(`/api/indices/tabla/${idTabla}`, {
                        headers: { 'Authorization': `Bearer ${token}` }
                    })
                ]);

                this.columnas = columnasRes.data.data || [];
                this.relaciones = relacionesRes.data.data || [];
                this.indices = indicesRes.data.data || [];
            } catch (error) {
                this.columnas = [];
                this.relaciones = [];
                this.indices = [];
            } finally {
                this.cargandoDetalles = false;
            }
        },

        conectarWebSocket() {
            if (this.socket && this.socket.readyState === WebSocket.OPEN) {
                return;
            }

            this.socket = new WebSocket('ws://localhost:8080');

            this.socket.onopen = () => {
                if (this.reconectarIntervalo) {
                    clearInterval(this.reconectarIntervalo);
                    this.reconectarIntervalo = null;
                }
            };

            this.socket.onmessage = (event) => {
                const data = JSON.parse(event.data);

                if (data.type === 'ai_response') {
                    this.mensajes.push({
                        rol: 'asistente',
                        texto: data.message
                    });
                    this.cargandoRespuesta = false;
                    this.$nextTick(() => {
                        this.scrollToBottom();
                    });
                } else if (data.type === 'error') {
                    this.mensajes.push({
                        rol: 'asistente',
                        texto: 'Error: ' + data.message
                    });
                    this.cargandoRespuesta = false;
                } else if (data.type === 'typing') {
                    this.cargandoRespuesta = data.isTyping;
                } else if (data.type === 'history_cleared') {
                    this.mensajes = [];
                }
            };

            this.socket.onclose = () => {
                if (!this.reconectarIntervalo) {
                    this.reconectarIntervalo = setInterval(() => {
                        this.conectarWebSocket();
                    }, 3000);
                }
            };

            this.socket.onerror = () => {
                if (this.socket) {
                    this.socket.close();
                }
            };
        },

        enviarMensaje() {
            if (!this.mensajeInput.trim() || !this.configValida || this.cargandoRespuesta) return;

            const mensaje = this.mensajeInput.trim();
            this.mensajes.push({
                rol: 'usuario',
                texto: mensaje
            });

            this.mensajeInput = '';
            this.cargandoRespuesta = true;

            this.$nextTick(() => {
                this.scrollToBottom();
            });

            if (this.socket && this.socket.readyState === WebSocket.OPEN) {
                this.socket.send(JSON.stringify({
                    type: 'chat_message',
                    userId: this.usuario.id_usuario,
                    mensaje: mensaje,
                    proyectoId: this.idProyecto
                }));
            } else {
                this.cargandoRespuesta = false;
                this.mensajes.push({
                    rol: 'asistente',
                    texto: 'Error: No hay conexión con el servidor WebSocket'
                });
            }
        },

        limpiarChat() {
            if (this.socket && this.socket.readyState === WebSocket.OPEN) {
                this.socket.send(JSON.stringify({
                    type: 'clear_history',
                    userId: this.usuario.id_usuario,
                    proyectoId: this.idProyecto
                }));
                this.mensajes = [];
            }
        },

        scrollToBottom() {
            const container = this.$refs.chatMessages;
            if (container) {
                container.scrollTop = container.scrollHeight;
            }
        },

        volverIA() {
            this.$router.push('/leonardoia');
        },

        cerrarSesion() {
            localStorage.removeItem('token');
            localStorage.removeItem('user');
            this.$router.push('/login');
        }
    }
};
</script>


<style scoped>
.dashboard {
    min-height: 100vh;
    background: linear-gradient(135deg, #1a0033 0%, #000000 50%, #1a0033 100%);
    position: relative;
}

.navbar {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    background: rgba(0, 0, 0, 0.9);
    backdrop-filter: blur(10px);
    border-bottom: 2px solid;
    border-image: linear-gradient(90deg, #8b00ff, #0066ff, #ff0055) 1;
    z-index: 1000;
    box-shadow: 0 4px 20px rgba(139, 0, 255, 0.3);
}

.navbar-content {
    max-width: 100%;
    margin: 0 auto;
    padding: 0 40px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    height: 70px;
    gap: 30px;
}

.logo {
    font-size: 1.8em;
    font-weight: 900;
    background: linear-gradient(135deg, #8b00ff, #0066ff, #ff0055);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    letter-spacing: 1px;
    margin: 0;
}

.nav-menu {
    display: flex;
    gap: 10px;
}

.nav-item {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 16px;
    color: #ffffff;
    cursor: pointer;
    transition: all 0.3s ease;
    border-radius: 8px;
    font-size: 0.9em;
}

.nav-item:hover {
    background: rgba(139, 0, 255, 0.2);
}

.nav-item svg {
    color: #8b00ff;
    flex-shrink: 0;
}

.nav-actions {
    display: flex;
    align-items: center;
    gap: 15px;
    position: relative;
}

.user-avatar {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    background: linear-gradient(135deg, #8b00ff, #0066ff);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.user-avatar:hover {
    transform: scale(1.1);
    border-color: #ff0055;
    box-shadow: 0 0 20px rgba(139, 0, 255, 0.6);
}

.user-avatar span {
    color: #ffffff;
    font-size: 1.3em;
    font-weight: 700;
}

.dropdown-menu {
    position: absolute;
    top: 60px;
    right: 0;
    width: 300px;
    background: rgba(0, 0, 0, 0.95);
    border: 2px solid;
    border-image: linear-gradient(135deg, #8b00ff, #0066ff, #ff0055) 1;
    border-radius: 12px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(10px);
    animation: slideDown 0.3s ease;
}

.menu-header {
    padding: 20px;
    display: flex;
    gap: 15px;
    align-items: center;
}

.avatar-large {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: linear-gradient(135deg, #8b00ff, #0066ff);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ffffff;
    font-size: 1.5em;
    font-weight: 700;
    flex-shrink: 0;
}

.user-info {
    flex: 1;
    overflow: hidden;
}

.user-nombre {
    color: #ffffff;
    font-weight: 600;
    font-size: 1em;
    margin: 0 0 5px 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.user-username {
    color: #8b00ff;
    font-size: 0.9em;
    margin: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.menu-divider {
    height: 1px;
    background: linear-gradient(90deg, transparent, #8b00ff, transparent);
    margin: 0;
}

.menu-items {
    padding: 10px 0;
}

.menu-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 20px;
    color: #ffffff;
    cursor: pointer;
    transition: all 0.3s ease;
}

.menu-item:hover {
    background: rgba(139, 0, 255, 0.2);
}

.menu-item.logout {
    color: #ff0055;
}

.menu-item.logout svg {
    color: #ff0055;
}

.menu-item.logout:hover {
    background: rgba(255, 0, 85, 0.2);
}

.background-art {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 0;
    overflow: hidden;
}

.circle {
    position: absolute;
    border-radius: 50%;
    filter: blur(80px);
    animation: float 20s infinite ease-in-out;
    opacity: 0.4;
}

.circle1 {
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, #8b00ff 0%, #4b0082 100%);
    top: -100px;
    left: -100px;
}

.circle2 {
    width: 500px;
    height: 500px;
    background: radial-gradient(circle, #0066ff 0%, #003d99 100%);
    bottom: -150px;
    right: -150px;
}

.circle3 {
    width: 350px;
    height: 350px;
    background: radial-gradient(circle, #ff0055 0%, #990033 100%);
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

@keyframes float {
    0%, 100% {
        transform: translate(0, 0) scale(1);
    }
    33% {
        transform: translate(100px, -100px) scale(1.1);
    }
    66% {
        transform: translate(-50px, 100px) scale(0.9);
    }
}

.database-lines {
    position: absolute;
    width: 100%;
    height: 100%;
    background-image: 
        repeating-linear-gradient(0deg, transparent, transparent 50px, rgba(139, 0, 255, 0.1) 50px, rgba(139, 0, 255, 0.1) 51px),
        repeating-linear-gradient(90deg, transparent, transparent 50px, rgba(0, 102, 255, 0.1) 50px, rgba(0, 102, 255, 0.1) 51px);
}

/* LAYOUT PRINCIPAL */
.main-layout {
    position: relative;
    z-index: 1;
    display: flex;
    padding-top: 70px;
    height: 100vh;
    gap: 0;
}

/* CHAT CONTAINER */
.chat-container {
    flex: 1;
    display: flex;
    flex-direction: column;
    padding: 30px;
    overflow: hidden;
}

.chat-header {
    margin-bottom: 20px;
}

.header-info {
    display: flex;
    align-items: center;
    gap: 15px;
}

.header-info svg {
    color: #8b00ff;
}

.header-info h2 {
    font-size: 1.8em;
    font-weight: 700;
    background: linear-gradient(135deg, #8b00ff, #0066ff);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin: 0;
}

.chat-messages {
    flex: 1;
    overflow-y: auto;
    padding: 20px;
    background: rgba(0, 0, 0, 0.3);
    border-radius: 16px;
    border: 2px solid rgba(139, 0, 255, 0.2);
    margin-bottom: 20px;
}

.mensaje-bienvenida {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 60px 40px;
    height: 100%;
}

.mensaje-bienvenida svg {
    color: #8b00ff;
    opacity: 0.6;
    margin-bottom: 25px;
}

.mensaje-bienvenida h3 {
    font-size: 1.8em;
    font-weight: 700;
    color: #ffffff;
    margin: 0 0 15px 0;
}

.mensaje-bienvenida p {
    color: #ffffff;
    opacity: 0.7;
    font-size: 1.1em;
    margin: 0 0 10px 0;
    line-height: 1.6;
}

.sugerencia {
    color: #8b00ff !important;
    opacity: 1 !important;
    font-weight: 600;
    margin-top: 20px !important;
}

.chat-input-area {
    background: rgba(0, 0, 0, 0.5);
    border: 2px solid rgba(139, 0, 255, 0.3);
    border-radius: 16px;
    padding: 20px;
}

.input-wrapper {
    display: flex;
    gap: 15px;
    align-items: flex-end;
}

.input-wrapper textarea {
    flex: 1;
    padding: 15px;
    background: rgba(0, 0, 0, 0.5);
    border: 2px solid rgba(139, 0, 255, 0.3);
    border-radius: 12px;
    color: #ffffff;
    font-size: 1em;
    font-family: inherit;
    resize: none;
    min-height: 50px;
    max-height: 150px;
    transition: all 0.3s ease;
}

.input-wrapper textarea:focus {
    outline: none;
    border-color: #8b00ff;
    box-shadow: 0 0 15px rgba(139, 0, 255, 0.3);
}

.btn-enviar {
    padding: 15px 20px;
    background: linear-gradient(135deg, #8b00ff, #0066ff);
    border: none;
    border-radius: 12px;
    color: #ffffff;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(139, 0, 255, 0.4);
    flex-shrink: 0;
}

.btn-enviar:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(139, 0, 255, 0.6);
}

/* SIDEBAR DERECHO */
.sidebar-derecho {
    width: 350px;
    background: rgba(0, 0, 0, 0.6);
    border-left: 2px solid rgba(139, 0, 255, 0.3);
    padding: 30px 20px;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    gap: 25px;
}

.sidebar-derecho::-webkit-scrollbar {
    width: 6px;
}

.sidebar-derecho::-webkit-scrollbar-track {
    background: rgba(0, 0, 0, 0.3);
}

.sidebar-derecho::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #8b00ff, #0066ff);
    border-radius: 10px;
}

.sidebar-section {
    background: rgba(0, 0, 0, 0.4);
    border: 2px solid rgba(139, 0, 255, 0.2);
    border-radius: 12px;
    overflow: hidden;
}

.section-header {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 15px 18px;
    background: rgba(139, 0, 255, 0.1);
    border-bottom: 1px solid rgba(139, 0, 255, 0.2);
}

.section-header.activa {
    background: rgba(139, 0, 255, 0.2);
    border-color: #8b00ff;
}

.section-header svg {
    color: #8b00ff;
    flex-shrink: 0;
}

.section-header h3 {
    font-size: 1em;
    font-weight: 700;
    color: #ffffff;
    margin: 0;
    flex: 1;
}

.count-badge {
    background: linear-gradient(135deg, #8b00ff, #0066ff);
    color: #ffffff;
    padding: 3px 10px;
    border-radius: 12px;
    font-size: 0.8em;
    font-weight: 700;
}


.info-box {
    background: rgba(139, 0, 255, 0.1);
    border-left: 3px solid #8b00ff;
    padding: 15px;
    border-radius: 8px;
    margin: 15px;  /* ← AGREGAR: para compensar el padding que quitamos */
}

.info-box p {
    color: #ffffff;
    font-size: 0.9em;
    margin: 0 0 10px 0;
    line-height: 1.5;
}

.info-box p:last-child {
    margin-bottom: 0;
}

.hint {
    color: #8b00ff !important;
    font-weight: 600;
}

.loading-proyectos {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 12px;
    padding: 30px 15px;
    margin: 15px;  /* ← AGREGAR */
}

.mini-loader {
    width: 30px;
    height: 30px;
    border: 3px solid rgba(139, 0, 255, 0.3);
    border-top-color: #8b00ff;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

.loading-proyectos p {
    color: #ffffff;
    opacity: 0.7;
    font-size: 0.9em;
    margin: 0;
}

.sin-proyectos {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    padding: 30px 15px;
    margin: 15px;  /* ← AGREGAR */
}

.sin-proyectos svg {
    color: #8b00ff;
    opacity: 0.5;
    margin-bottom: 15px;
}

.sin-proyectos p {
    color: #ffffff;
    opacity: 0.7;
    font-size: 0.9em;
    margin: 0;
    font-style: italic;
}



.proyecto-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 15px;
    background: rgba(0, 0, 0, 0.3);
    border: 2px solid rgba(139, 0, 255, 0.2);
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.proyecto-item:hover {
    background: rgba(139, 0, 255, 0.15);
    border-color: #8b00ff;
    transform: translateX(5px);
}

.proyecto-item svg {
    color: #8b00ff;
    flex-shrink: 0;
}

.proyecto-item span {
    flex: 1;
    color: #ffffff;
    font-weight: 600;
    font-size: 0.95em;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.icono-ir {
    color: #8b00ff;
    opacity: 0.5;
    flex-shrink: 0;
}

.proyecto-item:hover .icono-ir {
    opacity: 1;
}

@media (max-width: 1200px) {
    .sidebar-derecho {
        width: 300px;
    }
}

@media (max-width: 968px) {
    .main-layout {
        flex-direction: column;
    }
    
    .sidebar-derecho {
        width: 100%;
        border-left: none;
        border-top: 2px solid rgba(139, 0, 255, 0.3);
        max-height: 400px;
    }
}

.lista-proyectos {
    display: flex;
    flex-direction: column;
    gap: 8px;
    max-height: 400px;
    overflow-y: auto;
    padding: 15px;  /* ← AGREGAR: padding interno para la lista */
    margin: 0;      /* ← AGREGAR: sin margen */
}

.lista-proyectos::-webkit-scrollbar {
    width: 6px;
}

.lista-proyectos::-webkit-scrollbar-track {
    background: rgba(0, 0, 0, 0.3);
    border-radius: 10px;
    margin: 10px 0;  /* ← AGREGAR: margen para que no toque los bordes */
}

.lista-proyectos::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #8b00ff, #0066ff);
    border-radius: 10px;
}

.lista-proyectos::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, #9b10ff, #1176ff);
}

.section-content {
    padding: 0px;
    padding-bottom: 10px; /* ← AGREGAR: reduce padding inferior del contenedor */
}

/* MENSAJES */
.mensajes-lista {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.mensaje-item {
    animation: slideIn 0.3s ease;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.mensaje-contenido {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.mensaje-usuario .mensaje-contenido {
    align-items: flex-end;
}

.mensaje-ia .mensaje-contenido {
    align-items: flex-start;
}

.mensaje-header {
    display: flex;
    align-items: center;
    gap: 10px;
}

.avatar-mensaje {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.usuario-avatar {
    background: linear-gradient(135deg, #8b00ff, #0066ff);
    color: #ffffff;
    font-weight: 700;
}

.ia-avatar {
    background: linear-gradient(135deg, #00ff88, #00cc6a);
}

.ia-avatar svg {
    color: #000000;
}

.mensaje-autor {
    font-weight: 700;
    color: #ffffff;
    font-size: 0.9em;
}

.mensaje-texto {
    background: rgba(0, 0, 0, 0.5);
    border: 2px solid rgba(139, 0, 255, 0.3);
    border-radius: 12px;
    padding: 15px 18px;
    color: #ffffff;
    line-height: 1.6;
    max-width: 80%;
}

.mensaje-usuario .mensaje-texto {
    background: linear-gradient(135deg, rgba(139, 0, 255, 0.3), rgba(0, 102, 255, 0.3));
    border-color: #8b00ff;
}

.mensaje-ia .mensaje-texto {
    background: rgba(0, 255, 136, 0.1);
    border-color: rgba(0, 255, 136, 0.3);
}

.codigo-sql,
.codigo {
    background: rgba(0, 0, 0, 0.7) !important;
    border: 1px solid #8b00ff;
    border-radius: 8px;
    padding: 15px;
    margin: 10px 0;
    overflow-x: auto;
    font-family: 'Courier New', monospace;
    color: #00ff88;
}

.inline-code {
    background: rgba(139, 0, 255, 0.2);
    padding: 2px 6px;
    border-radius: 4px;
    font-family: 'Courier New', monospace;
    color: #00ff88;
    font-size: 0.9em;
}

/* TYPING INDICATOR */
.mensaje-typing {
    display: flex;
    align-items: center;
    padding: 10px;
}

.typing-indicator {
    display: flex;
    gap: 5px;
    align-items: center;
    padding: 10px 15px;
    background: rgba(0, 255, 136, 0.1);
    border: 2px solid rgba(0, 255, 136, 0.3);
    border-radius: 20px;
}

.typing-indicator span {
    width: 8px;
    height: 8px;
    background: #00ff88;
    border-radius: 50%;
    animation: typing 1.4s infinite;
}

.typing-indicator span:nth-child(2) {
    animation-delay: 0.2s;
}

.typing-indicator span:nth-child(3) {
    animation-delay: 0.4s;
}

@keyframes typing {
    0%, 60%, 100% {
        transform: translateY(0);
        opacity: 0.7;
    }
    30% {
        transform: translateY(-10px);
        opacity: 1;
    }
}

/* ERROR */
.mensaje-error {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 15px;
    background: rgba(255, 0, 85, 0.1);
    border: 2px solid rgba(255, 0, 85, 0.3);
    border-radius: 12px;
    color: #ff0055;
}

.mensaje-error svg {
    flex-shrink: 0;
}

/* BOTÓN LIMPIAR */
.chat-header {
    margin-bottom: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.btn-limpiar {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 18px;
    background: rgba(255, 0, 85, 0.15);
    border: 2px solid #ff0055;
    border-radius: 10px;
    color: #ff0055;
    cursor: pointer;
    transition: all 0.3s ease;
    font-weight: 600;
    font-size: 0.9em;
}

.btn-limpiar:hover {
    background: rgba(255, 0, 85, 0.25);
    transform: translateY(-2px);
}

.chat-messages::-webkit-scrollbar {
    width: 8px;
}

.chat-messages::-webkit-scrollbar-track {
    background: rgba(0, 0, 0, 0.3);
    border-radius: 10px;
}

.chat-messages::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #8b00ff, #0066ff);
    border-radius: 10px;
}

.proyecto-desc {
    color: #ffffff;
    opacity: 0.7;
    font-size: 0.9em;
    margin: 5px 0 0 0;
}

.estructura-proyecto {
    padding: 0;
}

.lista-tablas {
    display: flex;
    flex-direction: column;
    gap: 10px;
    max-height: 600px;
    overflow-y: auto;
    padding: 15px;
}

.tabla-item {
    background: rgba(0, 0, 0, 0.4);
    border: 2px solid rgba(139, 0, 255, 0.2);
    border-radius: 10px;
    transition: all 0.3s ease;
    cursor: pointer;
}

.tabla-item:hover {
    border-color: #8b00ff;
    background: rgba(139, 0, 255, 0.05);
}

.tabla-header {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 15px;
}

.tabla-header svg {
    color: #8b00ff;
    flex-shrink: 0;
}

.tabla-nombre {
    flex: 1;
    color: #ffffff;
    font-weight: 600;
    font-size: 0.95em;
}

.icono-toggle {
    color: #8b00ff;
    transition: transform 0.3s ease;
}

.icono-toggle.rotado {
    transform: rotate(180deg);
}

.tabla-detalles {
    border-top: 1px solid rgba(139, 0, 255, 0.2);
    padding: 15px;
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.detalle-titulo {
    color: #8b00ff;
    font-size: 0.85em;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 8px;
}

.columnas-lista,
.relaciones-lista,
.indices-lista {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.columna-item {
    display: flex;
    justify-content: space-between;
    padding: 8px 12px;
    background: rgba(0, 0, 0, 0.3);
    border-radius: 6px;
    font-size: 0.85em;
}

.columna-nombre {
    color: #ffffff;
    font-weight: 600;
}

.columna-tipo {
    color: #0066ff;
    font-size: 0.9em;
}

.relacion-item,
.indice-item {
    padding: 8px 12px;
    background: rgba(0, 0, 0, 0.3);
    border-radius: 6px;
    color: #ffffff;
    font-size: 0.85em;
}

.loading-estructura,
.sin-tablas {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 12px;
    padding: 30px 15px;
    margin: 15px;
}

.mini-loader {
    width: 30px;
    height: 30px;
    border: 3px solid rgba(139, 0, 255, 0.3);
    border-top-color: #8b00ff;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

.loading-estructura p,
.sin-tablas p {
    color: #ffffff;
    opacity: 0.7;
    font-size: 0.9em;
    margin: 0;
}

.sin-tablas svg {
    color: #8b00ff;
    opacity: 0.5;
}

.btn-limpiar {
    background: transparent;
    border: 1px solid rgba(255, 255, 255, 0.1);
    color: #a8b3cf;
    padding: 8px 16px;
    border-radius: 8px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    transition: all 0.3s ease;
}

.btn-limpiar:hover:not(:disabled) {
    background: rgba(255, 255, 255, 0.05);
    border-color: rgba(255, 255, 255, 0.2);
    color: #fff;
}

.btn-limpiar:disabled {
    opacity: 0.4;
    cursor: not-allowed;
}

.chat-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 30px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
}
</style>