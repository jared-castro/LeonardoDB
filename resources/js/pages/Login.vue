<template>
    <div v-if="notificacion.mostrar" :class="['notificacion', notificacion.tipo]">
        <span>{{ notificacion.mensaje }}</span>
    </div>

    <div class="background-art">
        <div class="circle circle1"></div>
        <div class="circle circle2"></div>
        <div class="circle circle3"></div>
        <div class="database-lines"></div>
    </div>

    <div class="container">
        <div class="form-wrapper">
            <div class="logo-section">
                <h1 class="logo">LeonardoDB</h1>
                <p class="subtitle">Inicia Sesión</p>
            </div>

            <form @submit.prevent="submitForm" class="login-form">
                <div class="form-group">
                    <label for="correo">Correo Electrónico</label>
                    <input 
                        type="email" 
                        id="correo" 
                        v-model="form.correo"
                        @input="validarCorreo"
                        maxlength="250"
                        :class="{ valid: validaciones.correoValido && form.correo, invalid: validaciones.correoError }"
                        required
                    >
                    <span class="error-message">{{ errores.correo }}</span>
                </div>

                <div class="form-group">
                    <label for="contrasena">Contraseña</label>
                    <input 
                        type="password" 
                        id="contrasena" 
                        v-model="form.contrasena"
                        required
                    >
                    <span class="error-message">{{ errores.contrasena }}</span>
                </div>

                <button type="submit" class="submit-btn" :disabled="loading">
                    <span>{{ loading ? 'Iniciando sesión...' : 'Iniciar Sesión' }}</span>
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path d="M4 10H16M16 10L10 4M16 10L10 16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>

                <div class="registro-link">
                    <p>¿No tienes cuenta? <router-link to="/registro">Regístrate aquí</router-link></p>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'Login',
    data() {
        return {
            form: {
                correo: '',
                contrasena: ''
            },
            errores: {
                correo: '',
                contrasena: ''
            },
            validaciones: {
                correoValido: false,
                correoError: false
            },
            loading: false,
            notificacion: {
                mostrar: false,
                mensaje: '',
                tipo: 'success'
            }
        };
    },
    mounted() {
        const registroExitoso = sessionStorage.getItem('registroExitoso');
        if (registroExitoso === 'true') {
            this.mostrarNotificacion('¡Registro exitoso! Bienvenido a LeonardoDB', 'success');
            sessionStorage.removeItem('registroExitoso');
        }
    },
    methods: {
        validarCorreo() {
            this.form.correo = this.form.correo.toLowerCase();
            const valor = this.form.correo;
            const tieneArroba = valor.includes('@');
            const tieneCom = valor.includes('.com');
            
            if (valor.length === 0) {
                this.errores.correo = '';
                this.validaciones.correoValido = false;
                this.validaciones.correoError = false;
            } else if (!tieneArroba) {
                this.errores.correo = 'El correo debe contener @';
                this.validaciones.correoError = true;
                this.validaciones.correoValido = false;
            } else if (!tieneCom) {
                this.errores.correo = 'El correo debe contener .com';
                this.validaciones.correoError = true;
                this.validaciones.correoValido = false;
            } else {
                const regexCorreo = /^[a-z0-9._-]+@[a-z0-9.-]+\.com$/;
                if (regexCorreo.test(valor)) {
                    this.errores.correo = '';
                    this.validaciones.correoValido = true;
                    this.validaciones.correoError = false;
                } else {
                    this.errores.correo = 'Formato de correo inválido';
                    this.validaciones.correoError = true;
                    this.validaciones.correoValido = false;
                }
            }
        },
        mostrarNotificacion(mensaje, tipo = 'success') {
            this.notificacion.mensaje = mensaje;
            this.notificacion.tipo = tipo;
            this.notificacion.mostrar = true;
            
            setTimeout(() => {
                this.notificacion.mostrar = false;
            }, 4000);
        },
        async submitForm() {
            let esValido = true;
            
            const regexCorreo = /^[a-z0-9._-]+@[a-z0-9.-]+\.com$/;
            if (!regexCorreo.test(this.form.correo)) {
                this.errores.correo = 'Correo inválido';
                this.validaciones.correoError = true;
                esValido = false;
            }
            
            if (this.form.contrasena.length === 0) {
                this.errores.contrasena = 'La contraseña es obligatoria';
                esValido = false;
            }
            
            if (esValido) {
                this.loading = true;
                
                try {
                    const response = await axios.post('/api/login', {
                        correo: this.form.correo,
                        contrasena: this.form.contrasena
                    });
                    
                    localStorage.setItem('token', response.data.token);
                    localStorage.setItem('user', JSON.stringify(response.data.user));
                    
                    this.$router.push('/leonardoproyectos');
                } catch (error) {
                    if (error.response && error.response.status === 401) {
                        this.mostrarNotificacion('Credenciales incorrectas', 'error');
                    } else {
                        this.mostrarNotificacion('Error al iniciar sesión', 'error');
                    }
                } finally {
                    this.loading = false;
                }
            } else {
                this.mostrarNotificacion('Por favor, corrige los errores', 'error');
            }
        }
    }
};
</script>

<style scoped>
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
    animation-delay: 0s;
}

.circle2 {
    width: 500px;
    height: 500px;
    background: radial-gradient(circle, #0066ff 0%, #003d99 100%);
    bottom: -150px;
    right: -150px;
    animation-delay: 7s;
}

.circle3 {
    width: 350px;
    height: 350px;
    background: radial-gradient(circle, #ff0055 0%, #990033 100%);
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    animation-delay: 14s;
}

.database-lines {
    position: absolute;
    width: 100%;
    height: 100%;
    background-image: 
        repeating-linear-gradient(0deg, transparent, transparent 50px, rgba(139, 0, 255, 0.1) 50px, rgba(139, 0, 255, 0.1) 51px),
        repeating-linear-gradient(90deg, transparent, transparent 50px, rgba(0, 102, 255, 0.1) 50px, rgba(0, 102, 255, 0.1) 51px);
    animation: gridMove 30s linear infinite;
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

@keyframes gridMove {
    0% {
        transform: translate(0, 0);
    }
    100% {
        transform: translate(50px, 50px);
    }
}

.container {
    position: relative;
    z-index: 1;
    width: 100%;
    max-width: 500px;
}

.form-wrapper {
    background: rgba(0, 0, 0, 0.85);
    border: 2px solid;
    border-image: linear-gradient(135deg, #8b00ff, #0066ff, #ff0055) 1;
    border-radius: 20px;
    padding: 40px;
    backdrop-filter: blur(10px);
    box-shadow: 
        0 0 40px rgba(139, 0, 255, 0.3),
        0 0 80px rgba(0, 102, 255, 0.2),
        0 0 120px rgba(255, 0, 85, 0.1);
    animation: borderPulse 3s ease-in-out infinite;
}

@keyframes borderPulse {
    0%, 100% {
        box-shadow: 
            0 0 40px rgba(139, 0, 255, 0.3),
            0 0 80px rgba(0, 102, 255, 0.2),
            0 0 120px rgba(255, 0, 85, 0.1);
    }
    50% {
        box-shadow: 
            0 0 60px rgba(139, 0, 255, 0.5),
            0 0 100px rgba(0, 102, 255, 0.3),
            0 0 140px rgba(255, 0, 85, 0.2);
    }
}

.logo-section {
    text-align: center;
    margin-bottom: 35px;
}

.logo {
    font-size: 2.5em;
    font-weight: 900;
    background: linear-gradient(135deg, #8b00ff, #0066ff, #ff0055);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    text-shadow: 0 0 30px rgba(139, 0, 255, 0.5);
    margin-bottom: 10px;
    letter-spacing: 2px;
}

.subtitle {
    color: #ffffff;
    font-size: 0.9em;
    opacity: 0.8;
    font-weight: 300;
}

.login-form {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

label {
    color: #ffffff;
    font-weight: 600;
    font-size: 0.9em;
    letter-spacing: 0.5px;
}

input {
    padding: 14px 18px;
    background: rgba(255, 255, 255, 0.05);
    border: 2px solid rgba(139, 0, 255, 0.3);
    border-radius: 10px;
    color: #ffffff;
    font-size: 1em;
    transition: all 0.3s ease;
    outline: none;
}

input:focus {
    background: rgba(255, 255, 255, 0.08);
    border-color: #8b00ff;
    box-shadow: 0 0 20px rgba(139, 0, 255, 0.4);
}

input.valid {
    border-color: #00ff88;
    box-shadow: 0 0 15px rgba(0, 255, 136, 0.3);
}

input.invalid {
    border-color: #ff0055;
    background: rgba(255, 0, 85, 0.1);
    box-shadow: 0 0 15px rgba(255, 0, 85, 0.3);
}

.error-message {
    color: #ff0055;
    font-size: 0.85em;
    min-height: 20px;
    display: block;
    font-weight: 500;
    text-shadow: 0 0 10px rgba(255, 0, 85, 0.5);
}

.submit-btn {
    margin-top: 10px;
    padding: 16px 32px;
    background: linear-gradient(135deg, #8b00ff, #0066ff);
    color: #ffffff;
    border: none;
    border-radius: 12px;
    font-size: 1.1em;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    box-shadow: 0 4px 20px rgba(139, 0, 255, 0.4);
    position: relative;
    overflow: hidden;
}

.submit-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s ease;
}

.submit-btn:hover::before {
    left: 100%;
}

.submit-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 30px rgba(139, 0, 255, 0.6);
    background: linear-gradient(135deg, #9d00ff, #0077ff);
}

.submit-btn:active {
    transform: translateY(0);
}

.submit-btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.submit-btn svg {
    transition: transform 0.3s ease;
}

.submit-btn:hover svg {
    transform: translateX(5px);
}

.registro-link {
    text-align: center;
    margin-top: 20px;
}

.registro-link p {
    color: #ffffff;
    opacity: 0.8;
}

.registro-link a {
    color: #8b00ff;
    text-decoration: none;
    font-weight: 600;
    transition: color 0.3s ease;
}

.registro-link a:hover {
    color: #0066ff;
}

.notificacion {
    position: fixed;
    top: 30px;
    right: 30px;
    padding: 20px 30px;
    border-radius: 12px;
    font-weight: 600;
    z-index: 9999;
    animation: slideIn 0.4s ease-out;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
    backdrop-filter: blur(10px);
}

.notificacion.success {
    background: linear-gradient(135deg, rgba(0, 255, 136, 0.9), rgba(0, 200, 100, 0.9));
    color: #ffffff;
    border: 2px solid #00ff88;
    box-shadow: 0 0 30px rgba(0, 255, 136, 0.5);
}

.notificacion.error {
    background: linear-gradient(135deg, rgba(255, 0, 85, 0.9), rgba(200, 0, 60, 0.9));
    color: #ffffff;
    border: 2px solid #ff0055;
    box-shadow: 0 0 30px rgba(255, 0, 85, 0.5);
}

@keyframes slideIn {
    from {
        transform: translateX(400px);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@media (max-width: 600px) {
    .form-wrapper {
        padding: 30px 20px;
    }

    .logo {
        font-size: 2em;
    }
}
</style>