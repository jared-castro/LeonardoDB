<template>
    <div class="preguntas-leonardo">
        <div class="preguntas-container">
            <div class="preguntas-header">
                <div class="header-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg>
                </div>
                <h1 class="header-titulo">Preguntas Frecuentes</h1>
                <p class="header-subtitulo">Encuentra respuestas a las dudas más comunes sobre LeonardoDB</p>
            </div>

            <div class="preguntas-lista">
                <div 
                    v-for="(pregunta, index) in preguntas" 
                    :key="index"
                    class="pregunta-card"
                    :class="{ 'pregunta-abierta': preguntaAbierta === index }"
                >
                    <div class="pregunta-header" @click="togglePregunta(index)">
                        <div class="pregunta-numero">{{ index + 1 }}</div>
                        <h2 class="pregunta-titulo">{{ pregunta.titulo }}</h2>
                        <button class="btn-toggle">
                            <svg 
                                width="20" 
                                height="20" 
                                viewBox="0 0 24 24" 
                                fill="none" 
                                stroke="currentColor" 
                                stroke-width="2.5"
                                :style="{ transform: preguntaAbierta === index ? 'rotate(180deg)' : 'rotate(0deg)' }"
                            >
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </button>
                    </div>

                    <div v-show="preguntaAbierta === index" class="pregunta-contenido">
                        <div class="respuesta-texto">
                            <p>{{ pregunta.respuesta }}</p>
                        </div>

                        <div v-if="pregunta.imagenes && pregunta.imagenes.length > 0" class="respuesta-imagenes-grid">
                            <div 
                                v-for="(imagen, imgIndex) in pregunta.imagenes" 
                                :key="imgIndex"
                                class="respuesta-imagen-container"
                            >
                                <img 
                                    :src="imagen" 
                                    :alt="pregunta.titulo + ' - ' + (imgIndex + 1)"
                                    class="respuesta-imagen"
                                    @click="abrirImagenModal(imagen)"
                                />
                                <button class="btn-ampliar" @click="abrirImagenModal(imagen)">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="15 3 21 3 21 9"></polyline>
                                        <polyline points="9 21 3 21 3 15"></polyline>
                                        <line x1="21" y1="3" x2="14" y2="10"></line>
                                        <line x1="3" y1="21" x2="10" y2="14"></line>
                                    </svg>
                                    Ver imagen {{ imgIndex + 1 }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para imagen ampliada -->
        <div v-if="imagenModal" class="imagen-modal-overlay" @click="cerrarImagenModal">
            <div class="imagen-modal-container">
                <button class="btn-cerrar-modal" @click="cerrarImagenModal">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
                <img :src="imagenModal" alt="Imagen ampliada" class="imagen-modal" />
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'PreguntasLeonardo',
    data() {
        return {
            preguntaAbierta: null,
            imagenModal: null,
            preguntas: [
                {
                    titulo: '¿Qué es LeonardoDB?',
                    respuesta: 'LeonardoDB es una herramienta visual para diseñar bases de datos relacionales. Permite crear tablas, definir columnas, establecer relaciones y exportar el esquema en SQL o migraciones de Laravel.',
                    imagenes: ['/images/preguntas/pregunta0.png']
                },
                {
                    titulo: '¿Cómo creo un proyecto en LeonardoDB?',
                    respuesta: 'Para crear un proyecto en LeonardoDB tienes que darle clic a Crear Diagrama y después rellenar los campos de nombre y descripción y después darle a crear y listo después le das clic a tu proyecto y estarás en el',
                    imagenes: [
                    '/images/preguntas/pregunta1.png',
                    '/images/preguntas/pregunta1.1.png',
                    '/images/preguntas/pregunta1.2.png'
                    ]
                },
                {
                    titulo: '¿Cómo creo una tabla?',
                    respuesta: 'Dale clik a crear tabla, completa el campo nombre y dale crear y automaticamente se creara tu tabla',
                    imagenes: [
                        '/images/preguntas/pregunta2.png',
                        '/images/preguntas/pregunta2.1.png',
                        '/images/preguntas/pregunta2.2.png'
                    ]
                },
                {
                    titulo: '¿Cómo creo una columna?',
                    respuesta: 'Abre la tabla en el sidebar izquierdo, haz clic en "Agregar columna", completa los campos requeridos (nombre, descripción, tipo) y opcionalmente configura longitud, cotejamiento, índices y otras propiedades.',
                    imagenes: [
                        '/images/preguntas/pregunta3.png',
                        '/images/preguntas/pregunta3.1.png',
                        '/images/preguntas/pregunta3.2.png'
                    ]
                },
                {
                    titulo: '¿Cómo creo una relacion entre columnas?',
                    respuesta: 'haz clik en el puntito de la tabla a la cual se ara la relacion, arrastra y sueltalo en el puntito de la otra tabla la cual va estar relacionada, la flecha que apunte va ser la cual se le va a pasar la relacion',
                    imagenes: [
                        '/images/preguntas/pregunta4.png',
                        '/images/preguntas/pregunta4.1.png',
                        '/images/preguntas/pregunta4.2.png'
                    ]
                },
                {
                    titulo: '¿Cómo configuro mi IA para que funcione en leonardoDB?',
                    respuesta: 'haz clik en configurar API KEY agrega en el campo api la clave de tu IA apartir de tu provedor, en la url agrega el endpoint o url que ocupe ese provedor y por ultimo agrega el modelo de IA a ocupar y dale a guardar y ya podras tener tu IA configurada en LeonardoDB y podras hablar de mejoras y preguntas con SQL asi como preguntarle de tu DB',
                    imagenes: [
                        '/images/preguntas/pregunta5.png',
                        '/images/preguntas/pregunta5.1.png',
                        '/images/preguntas/pregunta5.2.png'
                    ]
                }
            ]
        };
    },
    methods: {
        togglePregunta(index) {
            if (this.preguntaAbierta === index) {
                this.preguntaAbierta = null;
            } else {
                this.preguntaAbierta = index;
            }
        },
        abrirImagenModal(imagen) {
            this.imagenModal = imagen;
        },
        cerrarImagenModal() {
            this.imagenModal = null;
        }
    }
};
</script>

<style scoped>
.preguntas-leonardo {
    width: 100%;
    height: 100vh;
    background: linear-gradient(135deg, #0a0a0a 0%, #1a1a2e 100%);
    overflow-y: auto;
    overflow-x: hidden;
}

.preguntas-leonardo::-webkit-scrollbar {
    width: 10px;
}

.preguntas-leonardo::-webkit-scrollbar-track {
    background: #1a1a1a;
}

.preguntas-leonardo::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #8b00ff 0%, #0066ff 100%);
    border-radius: 10px;
}

.preguntas-leonardo::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, #a020ff 0%, #0088ff 100%);
}

.preguntas-container {
    max-width: 1000px;
    margin: 0 auto;
    padding: 40px 20px 80px 20px;
}


.preguntas-header {
    text-align: center;
    margin-bottom: 40px;
    animation: fadeInDown 0.5s ease;
}

.header-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #8b00ff 0%, #0066ff 100%);
    border-radius: 16px;
    margin-bottom: 16px;
    box-shadow: 0 8px 24px rgba(139, 0, 255, 0.3);
}

.header-icon svg {
    color: white;
    width: 28px;
    height: 28px;
}

.header-titulo {
    font-size: 36px;
    font-weight: 700;
    background: linear-gradient(135deg, #8b00ff 0%, #0066ff 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 12px;
}

.header-subtitulo {
    font-size: 16px;
    color: #999;
    max-width: 600px;
    margin: 0 auto;
}


.preguntas-lista {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.pregunta-card {
    background: rgba(30, 30, 30, 0.8);
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid #333;
    transition: all 0.3s ease;
    animation: fadeInUp 0.4s ease backwards;
    backdrop-filter: blur(10px);
}

.pregunta-card:nth-child(1) { animation-delay: 0.05s; }
.pregunta-card:nth-child(2) { animation-delay: 0.1s; }
.pregunta-card:nth-child(3) { animation-delay: 0.15s; }
.pregunta-card:nth-child(4) { animation-delay: 0.2s; }
.pregunta-card:nth-child(5) { animation-delay: 0.25s; }
.pregunta-card:nth-child(6) { animation-delay: 0.3s; }
.pregunta-card:nth-child(7) { animation-delay: 0.35s; }
.pregunta-card:nth-child(8) { animation-delay: 0.4s; }

.pregunta-card:hover {
    border-color: rgba(139, 0, 255, 0.5);
    transform: translateX(4px);
    box-shadow: 0 4px 16px rgba(139, 0, 255, 0.2);
}

.pregunta-abierta {
    border-color: #8b00ff;
    box-shadow: 0 8px 24px rgba(139, 0, 255, 0.25);
    background: rgba(30, 30, 30, 0.95);
}

.pregunta-header {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 18px 20px;
    cursor: pointer;
    user-select: none;
}

.pregunta-numero {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    background: linear-gradient(135deg, #8b00ff 0%, #0066ff 100%);
    border-radius: 8px;
    color: white;
    font-weight: 700;
    font-size: 16px;
    flex-shrink: 0;
}

.pregunta-titulo {
    flex: 1;
    font-size: 17px;
    font-weight: 600;
    color: white;
    margin: 0;
}

.btn-toggle {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    background: rgba(139, 0, 255, 0.15);
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.2s ease;
    flex-shrink: 0;
}

.btn-toggle svg {
    color: #8b00ff;
    transition: transform 0.3s ease;
}

.btn-toggle:hover {
    background: rgba(139, 0, 255, 0.25);
}


.pregunta-contenido {
    padding: 0 20px 20px 20px;
    animation: slideDown 0.3s ease;
}

.respuesta-texto {
    margin-bottom: 16px;
    padding: 16px;
    background: rgba(42, 42, 42, 0.6);
    border-radius: 8px;
    border-left: 3px solid #8b00ff;
}

.respuesta-texto p {
    color: #ccc;
    font-size: 15px;
    line-height: 1.6;
    margin: 0;
}

.respuesta-imagenes-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 12px;
}

.respuesta-imagen-container {
    position: relative;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.4);
    border: 1px solid #333;
}

.respuesta-imagen {
    width: 100%;
    height: auto;
    display: block;
    cursor: pointer;
    transition: transform 0.3s ease;
}

.respuesta-imagen:hover {
    transform: scale(1.01);
}

.btn-ampliar {
    position: absolute;
    bottom: 12px;
    right: 12px;
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 8px 14px;
    background: rgba(139, 0, 255, 0.95);
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    backdrop-filter: blur(10px);
}

.btn-ampliar:hover {
    background: rgba(139, 0, 255, 1);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(139, 0, 255, 0.5);
}


.imagen-modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.95);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10000;
    padding: 40px;
    animation: fadeIn 0.3s ease;
    cursor: pointer;
}

.imagen-modal-container {
    position: relative;
    max-width: 90%;
    max-height: 90%;
    animation: zoomIn 0.3s ease;
}

.imagen-modal {
    max-width: 100%;
    max-height: 90vh;
    border-radius: 12px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
}

.btn-cerrar-modal {
    position: absolute;
    top: -50px;
    right: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 44px;
    height: 44px;
    background: rgba(255, 255, 255, 0.1);
    color: white;
    border: 2px solid rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.btn-cerrar-modal:hover {
    background: rgba(255, 0, 85, 0.8);
    border-color: rgba(255, 0, 85, 1);
    transform: scale(1.1);
}



@keyframes fadeInDown {
    from {
        opacity: 0;
        transform: translateY(-30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideDown {
    from {
        opacity: 0;
        max-height: 0;
    }
    to {
        opacity: 1;
        max-height: 1000px;
    }
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

@keyframes zoomIn {
    from {
        opacity: 0;
        transform: scale(0.8);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}


@media (max-width: 768px) {
    .preguntas-leonardo {
        padding: 20px 10px;
    }

    .header-titulo {
        font-size: 36px;
    }

    .header-subtitulo {
        font-size: 16px;
    }

    .pregunta-header {
        padding: 16px;
    }

    .pregunta-titulo {
        font-size: 16px;
    }

    .pregunta-numero {
        width: 32px;
        height: 32px;
        font-size: 14px;
    }

    .btn-ampliar {
        font-size: 12px;
        padding: 8px 12px;
    }
}
</style>