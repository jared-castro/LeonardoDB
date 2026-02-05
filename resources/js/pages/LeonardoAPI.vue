<template>
    <div class="dashboard">
        <nav class="navbar">
            <div class="navbar-content">
                <div class="logo-section">
                    <h1 class="logo">LeonardoDB</h1>
                </div>

                <div class="nav-menu">
                    <div class="nav-item" @click="volverDashboard">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                        <span>Dashboard</span>
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

        <div class="dashboard-content">
            <div class="config-container">
                <!-- Header -->
                <div class="config-header">
                    <div class="header-info">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                        <div>
                            <h2>Configuración API de IA</h2>
                            <p class="subtitulo">Conecta tu proveedor de IA para usar los servicios de LeonardoDB</p>
                        </div>
                    </div>
                </div>

                <!-- Información -->
                

                <!-- Formulario -->
                <div class="form-card">
    <div class="form-layout-horizontal">
        <!-- Columna Izquierda: Inputs -->
        <div class="form-column">
            <div class="form-group">
                <label>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                    </svg>
                    API Key
                </label>
                <input 
                    type="password" 
                    v-model="configuracion.api_key"
                    placeholder="sk-xxxxxxxxxxxxxxxxxxxxxxxx"
                    class="form-input"
                    :class="{ 'input-error': errores.api_key }"
                >
                <span v-if="errores.api_key" class="error-message">{{ errores.api_key[0] }}</span>
                <p class="input-hint">Tu clave API del proveedor de IA</p>
            </div>

            <div class="form-group">
                <label>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path>
                        <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>
                    </svg>
                    Endpoint / URL
                </label>
                <input 
                    type="url" 
                    v-model="configuracion.end_point"
                    placeholder="https://api.openai.com/v1"
                    class="form-input"
                    :class="{ 'input-error': errores.end_point }"
                >
                <span v-if="errores.end_point" class="error-message">{{ errores.end_point[0] }}</span>
                <p class="input-hint">URL base del API de tu proveedor</p>
            </div>

            <div class="form-group">
                <label>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="16 18 22 12 16 6"></polyline>
                        <polyline points="8 6 2 12 8 18"></polyline>
                    </svg>
                    Modelo
                </label>
                <input 
                    type="text" 
                    v-model="configuracion.modelo"
                    placeholder="gpt-4, claude-3-opus, gemini-pro"
                    class="form-input"
                    :class="{ 'input-error': errores.modelo }"
                >
                <span v-if="errores.modelo" class="error-message">{{ errores.modelo[0] }}</span>
                <p class="input-hint">Nombre del modelo de IA a utilizar</p>
            </div>

            <!-- Botones -->
            <div class="form-actions">
                <button 
                    class="btn-guardar" 
                    @click="guardarConfiguracion"
                    :disabled="guardando"
                >
                    <svg v-if="!guardando" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                        <polyline points="17 21 17 13 7 13 7 21"></polyline>
                        <polyline points="7 3 7 8 15 8"></polyline>
                    </svg>
                    <span v-if="!guardando">{{ tieneConfiguracion ? 'Actualizar' : 'Guardar' }}</span>
                    <span v-else>Guardando...</span>
                </button>

                <button 
                    v-if="tieneConfiguracion"
                    class="btn-eliminar" 
                    @click="confirmarEliminar"
                    :disabled="eliminando"
                >
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="3 6 5 6 21 6"></polyline>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                    </svg>
                    <span v-if="!eliminando">Eliminar</span>
                    <span v-else>Eliminando...</span>
                </button>
            </div>
        </div>

        <!-- Divisor Vertical -->
        <div class="divisor-vertical"></div>

        <!-- Columna Derecha: Ejemplos -->
        <div class="ejemplos-column">
            <h4>
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                    <line x1="12" y1="17" x2="12.01" y2="17"></line>
                </svg>
                Ejemplos de Configuración
            </h4>
            
            <div class="ejemplos-scroll">
                <div class="ejemplo-item">
                    <div class="ejemplo-header">
                        <strong>OpenAI</strong>
                        <span class="badge-popular">Popular</span>
                    </div>
                    <div class="ejemplo-detalle">
                        <span class="label">Endpoint:</span>
                        <code>https://api.openai.com/v1</code>
                    </div>
                    <div class="ejemplo-detalle">
                        <span class="label">Modelos:</span>
                        <span class="modelos">gpt-4, gpt-4-turbo, gpt-3.5-turbo</span>
                    </div>
                </div>

                <div class="ejemplo-item">
                    <div class="ejemplo-header">
                        <strong>Anthropic Claude</strong>
                        <span class="badge-recomendado">Recomendado</span>
                    </div>
                    <div class="ejemplo-detalle">
                        <span class="label">Endpoint:</span>
                        <code>https://api.anthropic.com</code>
                    </div>
                    <div class="ejemplo-detalle">
                        <span class="label">Modelos:</span>
                        <span class="modelos">claude-3-opus-20240229, claude-3-sonnet-20240229</span>
                    </div>
                </div>

                <div class="ejemplo-item">
                    <div class="ejemplo-header">
                        <strong>Google AI</strong>
                    </div>
                    <div class="ejemplo-detalle">
                        <span class="label">Endpoint:</span>
                        <code>https://generativelanguage.googleapis.com</code>
                    </div>
                    <div class="ejemplo-detalle">
                        <span class="label">Modelos:</span>
                        <span class="modelos">gemini-pro, gemini-1.5-pro</span>
                    </div>
                </div>

                <div class="ejemplo-item">
                    <div class="ejemplo-header">
                        <strong>Groq</strong>
                    </div>
                    <div class="ejemplo-detalle">
                        <span class="label">Endpoint:</span>
                        <code>https://api.groq.com/openai/v1</code>
                    </div>
                    <div class="ejemplo-detalle">
                        <span class="label">Modelos:</span>
                        <span class="modelos">llama-3.1-70b, mixtral-8x7b</span>
                    </div>
                </div>

                <div class="ejemplo-item">
                    <div class="ejemplo-header">
                        <strong>Mistral AI</strong>
                    </div>
                    <div class="ejemplo-detalle">
                        <span class="label">Endpoint:</span>
                        <code>https://api.mistral.ai/v1</code>
                    </div>
                    <div class="ejemplo-detalle">
                        <span class="label">Modelos:</span>
                        <span class="modelos">mistral-large, mistral-medium</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
            </div>
        </div>

        <!-- Modal Confirmar Eliminación -->
        <div v-if="modalEliminar" class="modal-overlay" @click="cerrarModalEliminar">
            <div class="modal-container modal-eliminar" @click.stop>
                <div class="modal-header">
                    <h3>¿Eliminar Configuración?</h3>
                    <button class="btn-close" @click="cerrarModalEliminar">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="advertencia-icon">
                        <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="12"></line>
                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                        </svg>
                    </div>
                    <p class="mensaje-eliminar">
                        ¿Estás seguro de que deseas eliminar tu configuración de API?
                    </p>
                    <p class="submensaje-eliminar">No podrás usar las funciones de IA hasta que configures una nueva.</p>
                </div>

                <div class="modal-footer">
                    <button class="btn-cancelar" @click="cerrarModalEliminar">Cancelar</button>
                    <button class="btn-eliminar-modal" @click="eliminarConfiguracion" :disabled="eliminando">
                        <span v-if="!eliminando">Eliminar</span>
                        <span v-else>Eliminando...</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Alerta -->
        <div v-if="alertaVisible" class="alerta" :class="alertaTipo">
            <div class="alerta-contenido">
                <svg v-if="alertaTipo === 'exito'" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
                <svg v-else width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
                <span>{{ alertaMensaje }}</span>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'LeonardoAPI',
    data() {
        return {
            usuario: {},
            menuAbierto: false,
            configuracion: {
                api_key: '',
                end_point: '',
                modelo: ''
            },
            errores: {},
            guardando: false,
            eliminando: false,
            tieneConfiguracion: false,
            modalEliminar: false,
            alertaVisible: false,
            alertaMensaje: '',
            alertaTipo: 'exito'
        };
    },
    computed: {
        inicialUsuario() {
            return this.usuario.nombre ? this.usuario.nombre.charAt(0).toUpperCase() : 'U';
        }
    },
    mounted() {
        const user = localStorage.getItem('user');
        if (user) {
            this.usuario = JSON.parse(user);
            this.cargarConfiguracion();
        } else {
            this.$router.push('/login');
        }
    },
    methods: {
        toggleMenu() {
            this.menuAbierto = !this.menuAbierto;
        },
        
        async cargarConfiguracion() {
            try {
                const token = localStorage.getItem('token');
                const response = await axios.get('/api/api-config/obtener', {
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                });

                if (response.data.success && response.data.data) {
                    this.configuracion = {
                        api_key: response.data.data.api_key,
                        end_point: response.data.data.end_point,
                        modelo: response.data.data.modelo
                    };
                    this.tieneConfiguracion = true;
                }
            } catch (error) {
                if (error.response && error.response.status === 404) {
                    this.tieneConfiguracion = false;
                } else {
                    console.error('Error al cargar configuración:', error);
                }
            }
        },

        async guardarConfiguracion() {
            this.errores = {};
            this.guardando = true;

            try {
                const token = localStorage.getItem('token');
                const response = await axios.post(
                    '/api/api-config/guardar',
                    this.configuracion,
                    {
                        headers: {
                            'Authorization': `Bearer ${token}`
                        }
                    }
                );

                if (response.data.success) {
                    this.tieneConfiguracion = true;
                    this.mostrarAlerta(response.data.message, 'exito');
                }
            } catch (error) {
                if (error.response && error.response.data.errors) {
                    this.errores = error.response.data.errors;
                }
                this.mostrarAlerta(
                    error.response?.data?.message || 'Error al guardar la configuración',
                    'error'
                );
            } finally {
                this.guardando = false;
            }
        },

        confirmarEliminar() {
            this.modalEliminar = true;
        },

        cerrarModalEliminar() {
            this.modalEliminar = false;
        },

        async eliminarConfiguracion() {
            this.eliminando = true;

            try {
                const token = localStorage.getItem('token');
                const response = await axios.delete('/api/api-config/eliminar', {
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                });

                if (response.data.success) {
                    this.configuracion = {
                        api_key: '',
                        end_point: '',
                        modelo: ''
                    };
                    this.tieneConfiguracion = false;
                    this.cerrarModalEliminar();
                    this.mostrarAlerta(response.data.message, 'exito');
                }
            } catch (error) {
                this.mostrarAlerta(
                    error.response?.data?.message || 'Error al eliminar la configuración',
                    'error'
                );
            } finally {
                this.eliminando = false;
            }
        },

        mostrarAlerta(mensaje, tipo = 'exito') {
            this.alertaMensaje = mensaje;
            this.alertaTipo = tipo;
            this.alertaVisible = true;

            setTimeout(() => {
                this.alertaVisible = false;
            }, 3000);
        },

        volverDashboard() {
            this.$router.push('/leonardoproyectos');
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

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
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

/* CONTENT */
.dashboard-content {
    position: relative;
    z-index: 1;
    padding-top: 100px;
    padding-bottom: 40px;
    max-width: 1400px;
    margin: 0 auto;
    padding-left: 40px;
    padding-right: 40px;
        max-height: calc(100vh - 70px); /* Altura máxima menos el navbar */
    overflow-y: auto; /* Agregar scroll vertical */
}

.dashboard-content::-webkit-scrollbar {
    width: 10px;
}

.dashboard-content::-webkit-scrollbar-track {
    background: rgba(0, 0, 0, 0.3);
    border-radius: 10px;
}

.dashboard-content::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #8b00ff, #0066ff);
    border-radius: 10px;
}

.dashboard-content::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, #a020ff, #0080ff);
}

.config-container {
    display: flex;
    flex-direction: column;
    gap: 25px;
}

.config-header {
    background: rgba(0, 0, 0, 0.6);
    border: 2px solid rgba(139, 0, 255, 0.3);
    border-radius: 16px;
    padding: 30px;
    backdrop-filter: blur(10px);
}

.header-info {
    display: flex;
    align-items: center;
    gap: 20px;
}

.header-info svg {
    color: #8b00ff;
    flex-shrink: 0;
}

.header-info h2 {
    font-size: 2em;
    font-weight: 700;
    background: linear-gradient(135deg, #8b00ff, #0066ff);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin: 0 0 8px 0;
}

.subtitulo {
    color: #ffffff;
    opacity: 0.7;
    font-size: 1em;
    margin: 0;
}

.info-card {
    background: rgba(0, 102, 255, 0.1);
    border: 2px solid rgba(0, 102, 255, 0.3);
    border-radius: 12px;
    padding: 20px;
    display: flex;
    gap: 15px;
}

.info-icon {
    flex-shrink: 0;
}

.info-icon svg {
    color: #0066ff;
}

.info-content h3 {
    font-size: 1.1em;
    font-weight: 700;
    color: #ffffff;
    margin: 0 0 10px 0;
}

.info-content p {
    color: #ffffff;
    opacity: 0.8;
    font-size: 0.95em;
    line-height: 1.6;
    margin: 0 0 8px 0;
}

.info-content p:last-child {
    margin-bottom: 0;
}

.info-note {
    color: #0066ff !important;
    opacity: 1 !important;
    font-weight: 600;
}

/* LAYOUT HORIZONTAL */
.form-card {
    background: rgba(0, 0, 0, 0.6);
    border: 2px solid rgba(139, 0, 255, 0.3);
    border-radius: 16px;
    padding: 30px;
    backdrop-filter: blur(10px);
}

.form-layout-horizontal {
    display: flex;
    gap: 30px;
    align-items: flex-start;
}

.form-column {
    flex: 1;
    min-width: 0;
}

.divisor-vertical {
    width: 2px;
    background: linear-gradient(180deg, transparent, #8b00ff, transparent);
    align-self: stretch;
}

.ejemplos-column {
    flex: 1;
    min-width: 0;
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.ejemplos-column h4 {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 1.1em;
    font-weight: 700;
    color: #ffffff;
    margin: 0;
    padding-bottom: 15px;
    border-bottom: 2px solid rgba(139, 0, 255, 0.2);
}

.ejemplos-column h4 svg {
    color: #8b00ff;
    flex-shrink: 0;
}

.ejemplos-scroll {
    display: flex;
    flex-direction: column;
    gap: 12px;
    max-height: 520px;
    overflow-y: auto;
    padding-right: 10px;
}

.ejemplos-scroll::-webkit-scrollbar {
    width: 6px;
}

.ejemplos-scroll::-webkit-scrollbar-track {
    background: rgba(0, 0, 0, 0.3);
    border-radius: 10px;
}

.ejemplos-scroll::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #8b00ff, #0066ff);
    border-radius: 10px;
}

.form-group {
    margin-bottom: 22px;
}

.form-group label {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #ffffff;
    font-weight: 600;
    margin-bottom: 10px;
    font-size: 1em;
}

.form-group label svg {
    color: #8b00ff;
    flex-shrink: 0;
}

.form-input {
    width: 100%;
    padding: 14px;
    background: rgba(0, 0, 0, 0.5);
    border: 2px solid rgba(139, 0, 255, 0.3);
    border-radius: 10px;
    color: #ffffff;
    font-size: 0.95em;
    transition: all 0.3s ease;
    font-family: inherit;
}

.form-input:focus {
    outline: none;
    border-color: #8b00ff;
    box-shadow: 0 0 15px rgba(139, 0, 255, 0.3);
}

.form-input.input-error {
    border-color: #ff0055;
}

.error-message {
    display: block;
    color: #ff0055;
    font-size: 0.85em;
    margin-top: 5px;
    font-weight: 500;
}

.input-hint {
    color: #8b00ff;
    font-size: 0.85em;
    margin-top: 5px;
    opacity: 0.8;
}

/* EJEMPLOS */
.ejemplo-item {
    background: rgba(0, 0, 0, 0.4);
    border: 2px solid rgba(139, 0, 255, 0.2);
    border-radius: 10px;
    padding: 15px;
    display: flex;
    flex-direction: column;
    gap: 10px;
    transition: all 0.3s ease;
}

.ejemplo-item:hover {
    border-color: #8b00ff;
    background: rgba(139, 0, 255, 0.05);
}

.ejemplo-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    padding-bottom: 8px;
    border-bottom: 1px solid rgba(139, 0, 255, 0.2);
}

.ejemplo-header strong {
    color: #ffffff;
    font-size: 0.95em;
    font-weight: 700;
}

.badge-popular,
.badge-recomendado {
    padding: 3px 10px;
    border-radius: 5px;
    font-size: 0.7em;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.badge-popular {
    background: linear-gradient(135deg, #ff0055, #cc0044);
    color: #ffffff;
}

.badge-recomendado {
    background: linear-gradient(135deg, #00ff88, #00cc6a);
    color: #000000;
}

.ejemplo-detalle {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.ejemplo-detalle .label {
    color: #8b00ff;
    font-size: 0.75em;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.ejemplo-detalle code {
    color: #0066ff;
    font-size: 0.85em;
    background: rgba(0, 102, 255, 0.1);
    padding: 6px 10px;
    border-radius: 6px;
    word-break: break-all;
    font-family: 'Courier New', monospace;
}

.ejemplo-detalle .modelos {
    color: #ffffff;
    opacity: 0.8;
    font-size: 0.85em;
    line-height: 1.4;
}

.form-actions {
    display: flex;
    gap: 12px;
    margin-top: 25px;
}

.btn-guardar,
.btn-eliminar {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 14px 25px;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.95em;
    cursor: pointer;
    transition: all 0.3s ease;
    border: none;
    justify-content: center;
}

.btn-guardar {
    flex: 1;
    background: linear-gradient(135deg, #8b00ff, #0066ff);
    color: #ffffff;
    box-shadow: 0 4px 15px rgba(139, 0, 255, 0.4);
}

.btn-guardar:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(139, 0, 255, 0.6);
}

.btn-guardar:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.btn-eliminar {
    background: rgba(255, 0, 85, 0.15);
    border: 2px solid #ff0055;
    color: #ff0055;
}

.btn-eliminar:hover:not(:disabled) {
    background: rgba(255, 0, 85, 0.25);
    transform: translateY(-2px);
}

.btn-eliminar:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

/* Modal */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.8);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 2000;
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

.modal-container {
    background: rgba(0, 0, 0, 0.95);
    border: 2px solid;
    border-image: linear-gradient(135deg, #8b00ff, #0066ff, #ff0055) 1;
    border-radius: 20px;
    width: 90%;
    max-width: 500px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
    animation: slideUp 0.3s ease;
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.modal-header {
    padding: 25px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid rgba(139, 0, 255, 0.3);
}

.modal-header h3 {
    font-size: 1.5em;
    font-weight: 700;
    color: #ffffff;
    margin: 0;
}

.btn-close {
    background: none;
    border: none;
    color: #ffffff;
    cursor: pointer;
    transition: all 0.3s ease;
    padding: 5px;
    border-radius: 8px;
}

.btn-close:hover {
    background: rgba(255, 0, 85, 0.2);
    color: #ff0055;
}

.modal-body {
    padding: 30px;
}

.advertencia-icon {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
}

.advertencia-icon svg {
    color: #ff0055;
}

.mensaje-eliminar {
    color: #ffffff;
    font-size: 1.1em;
    text-align: center;
    margin: 0 0 10px 0;
    line-height: 1.6;
}

.submensaje-eliminar {
    color: #ffffff;
    opacity: 0.7;
    font-size: 0.9em;
    text-align: center;
    margin: 0;
}

.modal-footer {
    padding: 20px 30px 30px;
    display: flex;
    gap: 15px;
    justify-content: flex-end;
}

.btn-cancelar,
.btn-eliminar-modal {
    padding: 12px 30px;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    border: none;
    font-size: 1em;
}

.btn-cancelar {
    background: rgba(255, 255, 255, 0.1);
    color: #ffffff;
}

.btn-cancelar:hover {
    background: rgba(255, 255, 255, 0.2);
}

.btn-eliminar-modal {
    background: linear-gradient(135deg, #ff0055, #cc0044);
    color: #ffffff;
    box-shadow: 0 4px 15px rgba(255, 0, 85, 0.4);
}

.btn-eliminar-modal:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 0, 85, 0.6);
}

.btn-eliminar-modal:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

/* Alertas */
.alerta {
    position: fixed;
    top: 100px;
    right: 30px;
    z-index: 3000;
    animation: slideInRight 0.3s ease;
}

@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(100px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.alerta-contenido {
    background: rgba(0, 0, 0, 0.95);
    border-radius: 12px;
    padding: 20px 25px;
    display: flex;
    align-items: center;
    gap: 15px;
}

.alerta.exito .alerta-contenido {
    border: 2px solid #00ff88;
    box-shadow: 0 10px 40px rgba(0, 255, 136, 0.3);
}

.alerta.exito svg {
    color: #00ff88;
}

.alerta.error .alerta-contenido {
    border: 2px solid #ff0055;
    box-shadow: 0 10px 40px rgba(255, 0, 85, 0.3);
}

.alerta.error svg {
    color: #ff0055;
}

.alerta-contenido span {
    color: #ffffff;
    font-weight: 600;
}

/* RESPONSIVE */
@media (max-width: 1024px) {
    .form-layout-horizontal {
        flex-direction: column;
    }

    .divisor-vertical {
        width: 100%;
        height: 2px;
        background: linear-gradient(90deg, transparent, #8b00ff, transparent);
    }

    .ejemplos-scroll {
        max-height: 300px;
    }
}

@media (max-width: 768px) {
    .dashboard-content {
        padding-left: 20px;
        padding-right: 20px;
    }

    .config-header {
        padding: 20px;
    }

    .header-info {
        flex-direction: column;
        align-items: flex-start;
    }

    .header-info h2 {
        font-size: 1.5em;
    }

    .form-card {
        padding: 20px;
    }

    .form-actions {
        flex-direction: column;
    }

    .btn-eliminar {
        order: 2;
    }

    .info-card {
        flex-direction: column;
    }
}


</style>