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
                <p class="subtitle">Sistema de Gestión de Base de Datos</p>
            </div>

            <form @submit.prevent="submitForm" class="registro-form">
                <div class="form-group">
                    <label for="nombreCompleto">Nombre Completo</label>
                    <input 
                        type="text" 
                        id="nombreCompleto" 
                        v-model="form.nombreCompleto"
                        @input="validarNombre"
                        maxlength="50"
                        :class="{ valid: validaciones.nombreValido && form.nombreCompleto, invalid: validaciones.nombreError }"
                        required
                    >
                    <span class="error-message">{{ errores.nombre }}</span>
                </div>

                <div class="form-group">
                    <label for="usuario">Usuario</label>
                    <input 
                        type="text" 
                        id="usuario" 
                        v-model="form.usuario"
                        @input="validarUsuario"
                        maxlength="250"
                        :class="{ valid: validaciones.usuarioValido && form.usuario, invalid: validaciones.usuarioError }"
                        required
                    >
                    <span class="error-message">{{ errores.usuario }}</span>
                </div>

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
                        @input="validarContrasena"
                        :class="{ valid: validaciones.contrasenaValida && form.contrasena, invalid: validaciones.contrasenaError }"
                        required
                    >
                    <span class="error-message">{{ errores.contrasena }}</span>
                    <span class="info-message">Mínimo 6 caracteres, un número y un signo</span>
                </div>

                <div class="form-group">
                    <label for="confirmarContrasena">Confirmar Contraseña</label>
                    <input 
                        type="password" 
                        id="confirmarContrasena" 
                        v-model="form.confirmarContrasena"
                        @input="validarConfirmacion"
                        :class="{ valid: validaciones.confirmacionValida && form.confirmarContrasena, invalid: validaciones.confirmacionError }"
                        required
                    >
                    <span class="error-message" :class="{ success: validaciones.confirmacionValida && form.confirmarContrasena }">{{ errores.confirmar }}</span>
                </div>

                <button type="submit" class="submit-btn" :disabled="loading">
                    <span>{{ loading ? 'Registrando...' : 'Crear Cuenta' }}</span>
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path d="M4 10H16M16 10L10 4M16 10L10 16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>

                <div class="login-link">
                    <p>¿Ya tienes cuenta? <router-link to="/login">Inicia sesión aquí</router-link></p>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'Registro',
    data() {
        return {
            form: {
                nombreCompleto: '',
                usuario: '',
                correo: '',
                contrasena: '',
                confirmarContrasena: ''
            },
            errores: {
                nombre: '',
                usuario: '',
                correo: '',
                contrasena: '',
                confirmar: ''
            },
            validaciones: {
                nombreValido: false,
                nombreError: false,
                usuarioValido: false,
                usuarioError: false,
                correoValido: false,
                correoError: false,
                contrasenaValida: false,
                contrasenaError: false,
                confirmacionValida: false,
                confirmacionError: false
            },
            loading: false,
            notificacion: {
                mostrar: false,
                mensaje: '',
                tipo: 'success'
            }
        };
    },
    methods: {
        validarNombre() {
            const regex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]*$/;
            const valor = this.form.nombreCompleto;
            
            if (!regex.test(valor)) {
                this.form.nombreCompleto = valor.slice(0, -1);
                this.errores.nombre = 'Solo se permiten letras y espacios';
                this.validaciones.nombreError = true;
                this.validaciones.nombreValido = false;
            } else if (valor.length > 0) {
                this.errores.nombre = '';
                this.validaciones.nombreValido = true;
                this.validaciones.nombreError = false;
            } else {
                this.errores.nombre = '';
                this.validaciones.nombreValido = false;
                this.validaciones.nombreError = false;
            }
        },
        validarUsuario() {
            if (this.form.usuario.length > 0) {
                this.errores.usuario = '';
                this.validaciones.usuarioValido = true;
                this.validaciones.usuarioError = false;
            } else {
                this.errores.usuario = '';
                this.validaciones.usuarioValido = false;
                this.validaciones.usuarioError = false;
            }
        },
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
        validarContrasena() {
            const valor = this.form.contrasena;
            
            if (valor.length === 0) {
                this.errores.contrasena = '';
                this.validaciones.contrasenaValida = false;
                this.validaciones.contrasenaError = false;
                return;
            }
            
            const tieneNumero = /\d/.test(valor);
            const tieneSigno = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(valor);
            const longitudMinima = valor.length >= 6;
            
            if (!longitudMinima) {
                this.errores.contrasena = 'Debe tener al menos 6 caracteres';
                this.validaciones.contrasenaError = true;
                this.validaciones.contrasenaValida = false;
            } else if (!tieneNumero) {
                this.errores.contrasena = 'Debe contener al menos un número';
                this.validaciones.contrasenaError = true;
                this.validaciones.contrasenaValida = false;
            } else if (!tieneSigno) {
                this.errores.contrasena = 'Debe contener al menos un signo especial';
                this.validaciones.contrasenaError = true;
                this.validaciones.contrasenaValida = false;
            } else {
                this.errores.contrasena = '';
                this.validaciones.contrasenaValida = true;
                this.validaciones.contrasenaError = false;
            }
            
            this.validarConfirmacion();
        },
        validarConfirmacion() {
            const valorContrasena = this.form.contrasena;
            const valorConfirmar = this.form.confirmarContrasena;
            
            if (valorConfirmar.length === 0) {
                this.errores.confirmar = '';
                this.validaciones.confirmacionValida = false;
                this.validaciones.confirmacionError = false;
                return;
            }
            
            if (valorContrasena !== valorConfirmar) {
                this.errores.confirmar = 'Las contraseñas no coinciden';
                this.validaciones.confirmacionError = true;
                this.validaciones.confirmacionValida = false;
            } else {
                this.errores.confirmar = 'Las contraseñas coinciden';
                this.validaciones.confirmacionValida = true;
                this.validaciones.confirmacionError = false;
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
            
            const regexNombre = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/;
            if (!regexNombre.test(this.form.nombreCompleto) || this.form.nombreCompleto.trim().length === 0) {
                this.errores.nombre = 'Nombre completo inválido';
                this.validaciones.nombreError = true;
                esValido = false;
            }
            
            if (this.form.usuario.trim().length === 0) {
                this.errores.usuario = 'El usuario es obligatorio';
                this.validaciones.usuarioError = true;
                esValido = false;
            }
            
            const regexCorreo = /^[a-z0-9._-]+@[a-z0-9.-]+\.com$/;
            if (!regexCorreo.test(this.form.correo)) {
                this.errores.correo = 'Correo inválido (debe contener @ y .com)';
                this.validaciones.correoError = true;
                esValido = false;
            }
            
            const tieneNumero = /\d/.test(this.form.contrasena);
            const tieneSigno = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(this.form.contrasena);
            const longitudMinima = this.form.contrasena.length >= 6;
            
            if (!longitudMinima || !tieneNumero || !tieneSigno) {
                this.errores.contrasena = 'La contraseña no cumple los requisitos';
                this.validaciones.contrasenaError = true;
                esValido = false;
            }
            
            if (this.form.contrasena !== this.form.confirmarContrasena) {
                this.errores.confirmar = 'Las contraseñas no coinciden';
                this.validaciones.confirmacionError = true;
                esValido = false;
            }
            
            if (esValido) {
                this.loading = true;
                
                try {
                    const response = await axios.post('/api/register', {
                        nombreCompleto: this.form.nombreCompleto,
                        usuario: this.form.usuario,
                        correo: this.form.correo,
                        contrasena: this.form.contrasena,
                        confirmarContrasena: this.form.confirmarContrasena
                    });
                    
                    sessionStorage.setItem('registroExitoso', 'true');
                    this.$router.push('/login');
                    
                    this.form = {
                        nombreCompleto: '',
                        usuario: '',
                        correo: '',
                        contrasena: '',
                        confirmarContrasena: ''
                    };
                    this.errores = {
                        nombre: '',
                        usuario: '',
                        correo: '',
                        contrasena: '',
                        confirmar: ''
                    };
                    this.validaciones = {
                        nombreValido: false,
                        nombreError: false,
                        usuarioValido: false,
                        usuarioError: false,
                        correoValido: false,
                        correoError: false,
                        contrasenaValida: false,
                        contrasenaError: false,
                        confirmacionValida: false,
                        confirmacionError: false
                    };
                } catch (error) {
                    if (error.response && error.response.data.errors) {
                        const errors = error.response.data.errors;
                        if (errors.correo) {
                            this.errores.correo = 'Este correo ya está registrado';
                            this.validaciones.correoError = true;
                        }
                        if (errors.usuario) {
                            this.errores.usuario = 'Este usuario ya está registrado';
                            this.validaciones.usuarioError = true;
                        }
                    } else {
                        this.mostrarNotificacion('Error al registrar. Por favor intenta nuevamente.', 'error');
                    }
                } finally {
                    this.loading = false;
                }
            } else {
                this.mostrarNotificacion('Por favor, corrige los errores en el formulario', 'error');
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
    max-width: 1200px;
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
    display: grid;
    grid-template-columns: 1fr 2fr;
    gap: 40px;
    align-items: center;
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
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 20px;
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

.registro-form {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.form-group.full-width {
    grid-column: 1 / -1;
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

input::placeholder {
    color: rgba(255, 255, 255, 0.4);
}

.error-message {
    color: #ff0055;
    font-size: 0.85em;
    min-height: 20px;
    display: block;
    font-weight: 500;
    text-shadow: 0 0 10px rgba(255, 0, 85, 0.5);
}

.error-message.success {
    color: #00ff88;
    text-shadow: 0 0 10px rgba(0, 255, 136, 0.5);
}

.info-message {
    color: #0066ff;
    font-size: 0.8em;
    font-style: italic;
    opacity: 0.8;
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
    grid-column: 1 / -1;
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

@media (max-width: 900px) {
    .form-wrapper {
        grid-template-columns: 1fr;
        gap: 30px;
        padding: 30px 20px;
    }

    .registro-form {
        grid-template-columns: 1fr;
    }

    .logo {
        font-size: 2em;
    }

    .circle {
        filter: blur(60px);
    }

    .circle1, .circle2, .circle3 {
        width: 250px;
        height: 250px;
    }
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

.login-link {
    text-align: center;
    margin-top: 20px;
    grid-column: 1 / -1;
}

.login-link p {
    color: #ffffff;
    opacity: 0.8;
}

.login-link a {
    color: #8b00ff;
    text-decoration: none;
    font-weight: 600;
    transition: color 0.3s ease;
}

.login-link a:hover {
    color: #0066ff;
}
</style>