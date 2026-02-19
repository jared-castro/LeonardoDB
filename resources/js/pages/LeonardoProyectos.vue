<template>
    <div class="dashboard">
        <nav class="navbar">
            <div class="navbar-content">
                <div class="logo-section">
                    <h1 class="logo">LeonardoDB</h1>
                </div>

                <div class="nav-menu">


<div class="nav-item" @click="irAAsistenteIA">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
        <path d="M8 10h.01M12 10h.01M16 10h.01"></path>
    </svg>
    <span>Asistente IA DB</span>
</div>




<div class="nav-item" @click="irAAPIKeys">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
        <polyline points="14 2 14 8 20 8"></polyline>
        <line x1="12" y1="18" x2="12" y2="12"></line>
        <line x1="9" y1="15" x2="15" y2="15"></line>
    </svg>
    <span>API Keys Config</span>
</div>


                </div>

                <div class="nav-actions">
                    <button class="btn-crear-diagrama" @click="abrirModal">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        <span>Crear Diagrama</span>
                    </button>

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
                            <div class="menu-item" @click="irAPreguntas">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                                    <line x1="12" y1="17" x2="12.01" y2="17"></line>
                                </svg>
                                <span>Soporte de Preguntas</span>
                            </div>

                            <div class="menu-divider"></div>

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
            <!-- Cargando -->
            <div v-if="cargandoProyectos" class="loading-container">
                <div class="loader"></div>
                <p>Cargando proyectos...</p>
            </div>

            <!-- Sin proyectos -->
            <div v-else-if="proyectos.length === 0" class="empty-state">
                <svg width="120" height="120" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                    <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                    <line x1="12" y1="22.08" x2="12" y2="12"></line>
                </svg>
                <h2>No hay bases de datos aún</h2>
                <p>Comienza creando tu primer diagrama de base de datos</p>
                <button class="btn-crear-primero" @click="abrirModal">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    Crear mi primera base de datos
                </button>
            </div>

            <!-- Grid de proyectos -->
            <div v-else class="proyectos-container">
                <div class="proyectos-header">
                    <h2>Mis Proyectos</h2>
                    <span class="total-proyectos">{{ proyectos.length }} {{ proyectos.length === 1 ? 'proyecto' : 'proyectos' }}</span>
                </div>

                <div class="proyectos-grid">
                    <div 
                        v-for="proyecto in proyectos" 
                        :key="proyecto.id_proyecto" 
                        class="proyecto-card"
                    >
                        <div class="card-header">
                            <div class="card-title" @click="irAProyecto(proyecto.id_proyecto)">
                                <h3>{{ proyecto.nombre }}</h3>
                                <span class="tag-sql">{{ proyecto.tipo_db || 'SQL' }}</span>
                            </div>
                            <button class="btn-opciones" @click="toggleMenuProyecto(proyecto.id_proyecto)">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="1"></circle>
                                    <circle cx="12" cy="5" r="1"></circle>
                                    <circle cx="12" cy="19" r="1"></circle>
                                </svg>
                            </button>

                            <!-- Menú de opciones -->
                            <div v-if="menuProyectoAbierto === proyecto.id_proyecto" class="opciones-menu">
                                <div class="opcion-item" @click="abrirModalEditar(proyecto)">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
    </svg>
    <span>Editar</span>
</div>
<div class="opcion-item" @click="abrirHistorial(proyecto)">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <polyline points="1 4 1 10 7 10"></polyline>
        <polyline points="23 20 23 14 17 14"></polyline>
        <path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 0 1 3.51 15"></path>
    </svg>
    <span>Historial</span>
</div>
                                <div class="opcion-item opcion-eliminar" @click="confirmarEliminar(proyecto)">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                </svg>
                                <span>Eliminar</span>
                            </div>
                            </div>
                        </div>

                        <div class="card-body" @click="irAProyecto(proyecto.id_proyecto)">
                            <p class="descripcion">{{ proyecto.descripcion }}</p>
                            <div class="card-footer">
    <span class="badge-estado" :class="obtenerColorEstado(proyecto.estado)">
        <svg v-if="proyecto.estado === 1" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
            <polyline points="22 4 12 14.01 9 11.01"></polyline>
        </svg>
        <svg v-else-if="proyecto.estado === 0" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="15" y1="9" x2="9" y2="15"></line>
            <line x1="9" y1="9" x2="15" y2="15"></line>
        </svg>
        <svg v-else-if="proyecto.estado === 2" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="20 6 9 17 4 12"></polyline>
        </svg>
        {{ obtenerTextoEstado(proyecto.estado) }}
    </span>
    
    <span class="fecha">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"></circle>
            <polyline points="12 6 12 12 16 14"></polyline>
        </svg>
        {{ formatearFecha(proyecto.fecha_modificacion || proyecto.fecha_registro) }}
    </span>
</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Crear Proyecto -->
        <div v-if="modalAbierto" class="modal-overlay" @click="cerrarModal">
            <div class="modal-container" @click.stop>
                <div class="modal-header">
                    <h3>Crear Nuevo Diagrama</h3>
                    <button class="btn-close" @click="cerrarModal">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Nombre del Proyecto</label>
                        <input 
                            type="text" 
                            v-model="proyecto.nombre" 
                            maxlength="250"
                            placeholder="Ingresa el nombre del proyecto"
                            class="form-input"
                        >
                        <span class="char-counter">{{ proyecto.nombre.length }}/250</span>
                    </div>

                    <div class="form-group">
                        <label>Descripción</label>
                        <textarea 
                            v-model="proyecto.descripcion" 
                            maxlength="250"
                            placeholder="Describe tu proyecto"
                            class="form-textarea"
                            rows="4"
                        ></textarea>
                        <span class="char-counter">{{ proyecto.descripcion.length }}/250</span>
                    </div>

                    <div class="form-group">
                        <label>Tipo de Base de Datos</label>
                        <div class="estado-buttons">
                            <button 
                                class="btn-estado"
                                :class="{ 'estado-activo': proyecto.tipo_db === 'MYSQL' }"
                                @click="proyecto.tipo_db = 'MYSQL'"
                                type="button"
                            >MYSQL</button>
                            <button 
                                class="btn-estado"
                                :class="{ 'estado-activo': proyecto.tipo_db === 'POSTGRED' }"
                                @click="proyecto.tipo_db = 'POSTGRED'"
                                type="button"
                            >POSTGRED</button>
                            <button 
                                class="btn-estado"
                                :class="{ 'estado-activo': proyecto.tipo_db === 'MONGODB' }"
                                @click="proyecto.tipo_db = 'MONGODB'"
                                type="button"
                            >MONGODB</button>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn-cancelar" @click="cerrarModal">Cancelar</button>
                    <button class="btn-crear" @click="crearProyecto" :disabled="cargando">
                        <span v-if="!cargando">Crear Proyecto</span>
                        <span v-else>Creando...</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Modal Confirmar Eliminación -->
<div v-if="modalEliminar" class="modal-overlay" @click="cerrarModalEliminar">
    <div class="modal-container modal-eliminar" @click.stop>
        <div class="modal-header">
            <h3>¿Eliminar Proyecto?</h3>
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
                ¿Estás seguro de que deseas eliminar el proyecto 
                <strong>"{{ proyectoAEliminar?.nombre }}"</strong>?
            </p>
            <p class="submensaje-eliminar">Esta acción no se puede deshacer.</p>
        </div>

        <div class="modal-footer">
            <button class="btn-cancelar" @click="cerrarModalEliminar">Cancelar</button>
            <button class="btn-eliminar" @click="eliminarProyecto" :disabled="eliminando">
                <span v-if="!eliminando">Eliminar</span>
                <span v-else>Eliminando...</span>
            </button>
        </div>
    </div>
</div>

<!-- Modal Historial -->
<div v-if="modalHistorial && proyectoHistorial" class="modal-overlay" @click="cerrarModalHistorial">
    <div class="modal-container modal-historial" @click.stop>
        <div class="modal-header">
            <div class="header-con-nombre">
                <h3>Historial del Proyecto</h3>
                <span class="nombre-proyecto">{{ proyectoHistorial.nombre }}</span>
            </div>
            <button class="btn-close" @click="cerrarModalHistorial">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>

        <div class="modal-body modal-body-horizontal">
            <!-- Sección Izquierda: Creación -->
            <div class="historial-columna">
                <div class="historial-header">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 2v20M2 12h20"></path>
                        <circle cx="12" cy="12" r="10"></circle>
                    </svg>
                    <h4>Creación</h4>
                </div>
                
                <div class="historial-info">
                    <div class="info-item">
                        <span class="info-label">Creado por</span>
                        <div class="usuario-info">
                            <span class="usuario-nombre">@{{ proyectoHistorial.creado_por?.usuario || 'Desconocido' }}</span>
                            <span class="usuario-email">{{ proyectoHistorial.creado_por?.correo || 'N/A' }}</span>
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <span class="info-label">Fecha</span>
                        <span class="info-value fecha-destacada">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                            {{ formatearFechaCompleta(proyectoHistorial.fecha_registro) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Divisor Vertical -->
            <div class="historial-divider-vertical"></div>

            <!-- Sección Derecha: Modificación -->
            <div class="historial-columna">
                <div class="historial-header">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                    </svg>
                    <h4>Última Modificación</h4>
                </div>
                
                <div v-if="proyectoHistorial.modificado_por" class="historial-info">
                    <div class="info-item">
                        <span class="info-label">Modificado por</span>
                        <div class="usuario-info">
                            <span class="usuario-nombre">@{{ proyectoHistorial.modificado_por.usuario }}</span>
                            <span class="usuario-email">{{ proyectoHistorial.modificado_por.correo }}</span>
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <span class="info-label">Fecha</span>
                        <span class="info-value fecha-destacada">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                            {{ formatearFechaCompleta(proyectoHistorial.fecha_modificacion) }}
                        </span>
                    </div>
                </div>
                
                <div v-else class="sin-modificaciones">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                    <p>Nadie ha modificado este proyecto</p>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button class="btn-cancelar" @click="cerrarModalHistorial">Cerrar</button>
        </div>
    </div>
</div>

<!-- Modal Editar Proyecto -->
<div v-if="modalEditar" class="modal-overlay" @click="cerrarModalEditar">
    <div class="modal-container" @click.stop>
        <div class="modal-header">
            <h3>Editar Proyecto</h3>
            <button class="btn-close" @click="cerrarModalEditar">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>

        <div class="modal-body">
            <div class="form-group">
                <label>Nombre del Proyecto</label>
                <input 
                    type="text" 
                    v-model="proyectoEditar.nombre" 
                    maxlength="250"
                    placeholder="Ingresa el nombre del proyecto"
                    class="form-input"
                >
                <span class="char-counter">{{ proyectoEditar.nombre.length }}/250</span>
            </div>

            <div class="form-group">
                <label>Descripción</label>
                <textarea 
                    v-model="proyectoEditar.descripcion" 
                    maxlength="250"
                    placeholder="Describe tu proyecto"
                    class="form-textarea"
                    rows="4"
                ></textarea>
                <span class="char-counter">{{ proyectoEditar.descripcion.length }}/250</span>
            </div>

            <div class="form-group">
                <label>Estado del Proyecto</label>
                <div class="estado-buttons">
                    <button 
                        class="btn-estado"
                        :class="{ 'estado-activo': proyectoEditar.estado === 1 }"
                        @click="proyectoEditar.estado = 1"
                    >
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                        Activo
                    </button>
                    
                    <button 
                        class="btn-estado"
                        :class="{ 'estado-inactivo': proyectoEditar.estado === 0 }"
                        @click="proyectoEditar.estado = 0"
                    >
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="15" y1="9" x2="9" y2="15"></line>
                            <line x1="9" y1="9" x2="15" y2="15"></line>
                        </svg>
                        Inactivo
                    </button>
                    
                    <button 
                        class="btn-estado"
                        :class="{ 'estado-finalizado': proyectoEditar.estado === 2 }"
                        @click="proyectoEditar.estado = 2"
                    >
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                        Finalizado
                    </button>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button class="btn-cancelar" @click="cerrarModalEditar">Cancelar</button>
            <button class="btn-crear" @click="editarProyecto" :disabled="editando">
                <span v-if="!editando">Guardar Cambios</span>
                <span v-else>Guardando...</span>
            </button>
        </div>
    </div>
</div>

        <!-- Alerta de éxito -->
        <div v-if="alertaExito" class="alerta-exito">
            <div class="alerta-contenido">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
                <span>{{ mensajeAlerta }}</span>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'DashboardLeonardo',
    data() {
        return {
            usuario: {},
            menuAbierto: false,
            modalAbierto: false,
            alertaExito: false,
            mensajeAlerta: '',
            cargando: false,
proyecto: {
    nombre: '',
    descripcion: '',
    tipo_db: 'MYSQL'
},
        proyectos: [],
        cargandoProyectos: true,
        menuProyectoAbierto: null,
        modalEliminar: false,
        proyectoAEliminar: null,
        eliminando: false,
        modalHistorial: false,
        proyectoHistorial: null,
        modalEditar: false,
        proyectoEditar: {
            id_proyecto: null,
            nombre: '',
            descripcion: '',
            estado: 1
        },
        editando: false
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
        this.cargarProyectos();
    } else {
        this.$router.push('/login');
    }

    document.addEventListener('click', this.cerrarMenuAlClickAfuera);
},
    methods: {
        toggleMenu() {
            this.menuAbierto = !this.menuAbierto;
        },
        cerrarMenuAlClickAfuera(event) {
            const userSection = this.$el.querySelector('.nav-actions');
            if (userSection && !userSection.contains(event.target)) {
                this.menuAbierto = false;
            }
        },
        abrirModal() {
            this.modalAbierto = true;
this.proyecto = {
    nombre: '',
    descripcion: '',
    tipo_db: 'MYSQL'
};
        },
        cerrarModal() {
            this.modalAbierto = false;
        },
        async crearProyecto() {
    if (!this.proyecto.nombre.trim() || !this.proyecto.descripcion.trim()) {
        this.mostrarAlerta('Por favor completa todos los campos');
        return;
    }

    this.cargando = true;

    try {
        const token = localStorage.getItem('token');
        const response = await axios.post(
            '/api/proyectos/crear',
{
    nombre: this.proyecto.nombre,
    descripcion: this.proyecto.descripcion,
    tipo_db: this.proyecto.tipo_db
},
            {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            }
        );

        this.cerrarModal();
        this.mostrarAlerta('Proyecto creado exitosamente');
        this.cargarProyectos();
        
    } catch (error) {
        console.error('Error al crear proyecto:', error);
        this.mostrarAlerta('Error al crear el proyecto');
    } finally {
        this.cargando = false;
    }
},
        async cargarProyectos() {
    this.cargandoProyectos = true;
    try {
        const token = localStorage.getItem('token');
        const response = await axios.get('/api/proyectos/ver', {
            headers: {
                'Authorization': `Bearer ${token}`
            }
        });
        
        this.proyectos = response.data.data;
    } catch (error) {
        console.error('Error al cargar proyectos:', error);
    } finally {
        this.cargandoProyectos = false;
    }
},

toggleMenuProyecto(idProyecto) {
    this.menuProyectoAbierto = this.menuProyectoAbierto === idProyecto ? null : idProyecto;
},

irAProyecto(idProyecto) {
    const proyecto = this.proyectos.find(p => p.id_proyecto === idProyecto);
    const tipo = proyecto?.tipo_db;
    if (tipo === 'POSTGRED') {
        this.$router.push(`/leonardodata2/${idProyecto}`);
    } else if (tipo === 'MONGODB') {
        this.$router.push(`/leonardodata3/${idProyecto}`);
    } else {
        this.$router.push(`/leonardodata/${idProyecto}`);
    }
},

formatearFecha(fecha) {
    if (!fecha) return 'Sin modificar';
    const date = new Date(fecha);
    return date.toLocaleDateString('es-ES', { 
        year: 'numeric', 
        month: 'short', 
        day: 'numeric' 
    });
},
confirmarEliminar(proyecto) {
    this.proyectoAEliminar = proyecto;
    this.modalEliminar = true;
    this.menuProyectoAbierto = null;
},

cerrarModalEliminar() {
    this.modalEliminar = false;
    this.proyectoAEliminar = null;
},

async eliminarProyecto() {
    if (!this.proyectoAEliminar) return;
    
    this.eliminando = true;
    
    try {
        const token = localStorage.getItem('token');
        await axios.delete(
            `/api/proyectos/eliminar/${this.proyectoAEliminar.id_proyecto}`,
            {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            }
        );
        
        this.cerrarModalEliminar();
        this.mostrarAlerta('Proyecto eliminado exitosamente');
        this.cargarProyectos();
        
    } catch (error) {
        console.error('Error al eliminar proyecto:', error);
        if (error.response && error.response.status === 404) {
            this.mostrarAlerta('No tienes permisos para eliminar este proyecto');
        } else {
            this.mostrarAlerta('Error al eliminar el proyecto');
        }
    } finally {
        this.eliminando = false;
    }
},

abrirHistorial(proyecto) {
    this.proyectoHistorial = proyecto;
    this.modalHistorial = true;
    this.menuProyectoAbierto = null;
},

cerrarModalHistorial() {
    this.modalHistorial = false;
    this.proyectoHistorial = null;
},

formatearFechaCompleta(fecha) {
    if (!fecha) return '';
    const date = new Date(fecha);
    return date.toLocaleString('es-ES', { 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
},

abrirModalEditar(proyecto) {
    this.proyectoEditar = {
        id_proyecto: proyecto.id_proyecto,
        nombre: proyecto.nombre,
        descripcion: proyecto.descripcion,
        estado: proyecto.estado
    };
    this.modalEditar = true;
    this.menuProyectoAbierto = null;
},

cerrarModalEditar() {
    this.modalEditar = false;
    this.proyectoEditar = {
        id_proyecto: null,
        nombre: '',
        descripcion: '',
        estado: 1
    };
},

async editarProyecto() {
    if (!this.proyectoEditar.nombre.trim() || !this.proyectoEditar.descripcion.trim()) {
        this.mostrarAlerta('Por favor completa todos los campos');
        return;
    }

    this.editando = true;

    try {
        const token = localStorage.getItem('token');
        await axios.put(
            `/api/proyectos/editar/${this.proyectoEditar.id_proyecto}`,
            {
                nombre: this.proyectoEditar.nombre,
                descripcion: this.proyectoEditar.descripcion,
                estado: this.proyectoEditar.estado
            },
            {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            }
        );

        this.cerrarModalEditar();
        this.mostrarAlerta('Proyecto actualizado exitosamente');
        this.cargarProyectos();
        
    } catch (error) {
        console.error('Error al editar proyecto:', error);
        if (error.response && error.response.status === 404) {
            this.mostrarAlerta('No tienes permisos para editar este proyecto');
        } else {
            this.mostrarAlerta('Error al actualizar el proyecto');
        }
    } finally {
        this.editando = false;
    }
},

obtenerTextoEstado(estado) {
    const estados = {
        0: 'Inactivo',
        1: 'Activo',
        2: 'Finalizado'
    };
    return estados[estado] || 'Desconocido';
},

obtenerColorEstado(estado) {
    const colores = {
        0: 'estado-inactivo',
        1: 'estado-activo',
        2: 'estado-finalizado'
    };
    return colores[estado] || '';
},
        mostrarAlerta(mensaje) {
            this.mensajeAlerta = mensaje;
            this.alertaExito = true;
            
            setTimeout(() => {
                this.alertaExito = false;
            }, 3000);
        },
        irAPreguntas() {
            this.menuAbierto = false;
            this.$router.push('/preguntasleonardo');
        },
irAAsistenteIA() {
    this.$router.push('/leonardoia');
},
irAAPIKeys() {
    this.$router.push('/leonardoapi');
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
    max-width: 1600px;
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
    flex: 1;
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

.btn-crear-diagrama {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    background: linear-gradient(135deg, #8b00ff, #0066ff);
    color: #ffffff;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(139, 0, 255, 0.4);
}

.btn-crear-diagrama:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(139, 0, 255, 0.6);
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

.menu-item svg {
    color: #8b00ff;
}

.menu-item span {
    font-size: 0.95em;
    font-weight: 500;
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

/* Modal Styles */
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
    max-width: 600px;
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
    padding: 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid rgba(139, 0, 255, 0.3);
}

.modal-header h3 {
    font-size: 1.8em;
    font-weight: 700;
    background: linear-gradient(135deg, #8b00ff, #0066ff, #ff0055);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
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

.form-group {
    margin-bottom: 25px;
    position: relative;
}

.form-group label {
    display: block;
    color: #ffffff;
    font-weight: 600;
    margin-bottom: 10px;
    font-size: 1em;
}

.form-input,
.form-textarea {
    width: 100%;
    padding: 15px;
    background: rgba(0, 0, 0, 0.5);
    border: 2px solid rgba(139, 0, 255, 0.3);
    border-radius: 10px;
    color: #ffffff;
    font-size: 1em;
    transition: all 0.3s ease;
    font-family: inherit;
}

.form-input:focus,
.form-textarea:focus {
    outline: none;
    border-color: #8b00ff;
    box-shadow: 0 0 15px rgba(139, 0, 255, 0.3);
}

.form-textarea {
    resize: vertical;
    min-height: 100px;
}

.char-counter {
    position: absolute;
    bottom: -20px;
    right: 0;
    font-size: 0.85em;
    color: #8b00ff;
}

.modal-footer {
    padding: 20px 30px 30px;
    display: flex;
    gap: 15px;
    justify-content: flex-end;
}

.btn-cancelar,
.btn-crear {
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

.btn-crear {
    background: linear-gradient(135deg, #8b00ff, #0066ff);
    color: #ffffff;
    box-shadow: 0 4px 15px rgba(139, 0, 255, 0.4);
}

.btn-crear:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(139, 0, 255, 0.6);
}

.btn-crear:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

/* Alerta de éxito */
.alerta-exito {
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
    border: 2px solid #00ff88;
    border-radius: 12px;
    padding: 20px 25px;
    display: flex;
    align-items: center;
    gap: 15px;
    box-shadow: 0 10px 40px rgba(0, 255, 136, 0.3);
}

.alerta-contenido svg {
    color: #00ff88;
    flex-shrink: 0;
}

.alerta-contenido span {
    color: #ffffff;
    font-weight: 600;
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

.dashboard-content {
    position: relative;
    z-index: 1;
    padding-top: 100px;
    max-width: 95%;
    margin: 0 auto;
    padding-left: 60px;
    padding-right: 60px;
    min-height: calc(100vh - 100px);
    padding-bottom: 40px;
}

.welcome-section {
    background: rgba(0, 0, 0, 0.6);
    border: 2px solid;
    border-image: linear-gradient(135deg, #8b00ff, #0066ff, #ff0055) 1;
    border-radius: 20px;
    padding: 40px;
    backdrop-filter: blur(10px);
    box-shadow: 0 0 40px rgba(139, 0, 255, 0.3);
}

.welcome-section h2 {
    font-size: 2.5em;
    font-weight: 900;
    background: linear-gradient(135deg, #8b00ff, #0066ff, #ff0055);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin: 0 0 10px 0;
}

.welcome-section p {
    color: #ffffff;
    opacity: 0.8;
    font-size: 1.1em;
    margin: 0;
}

@media (max-width: 1200px) {
    .nav-menu {
        display: none;
    }
}

@media (max-width: 768px) {
    .navbar-content {
        padding: 0 20px;
    }

    .logo {
        font-size: 1.4em;
    }

    .btn-crear-diagrama span {
        display: none;
    }

    .modal-container {
        width: 95%;
    }

    .dashboard-content {
        padding-left: 20px;
        padding-right: 20px;
    }

    .welcome-section h2 {
        font-size: 1.8em;
    }
}

/* Loading */
.loading-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 400px;
    gap: 20px;
}

.loader {
    width: 50px;
    height: 50px;
    border: 4px solid rgba(139, 0, 255, 0.3);
    border-top-color: #8b00ff;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

.loading-container p {
    color: #ffffff;
    font-size: 1.1em;
}

/* Empty State */
.empty-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 500px;
    text-align: center;
    padding: 40px;
}

.empty-state svg {
    color: #8b00ff;
    opacity: 0.5;
    margin-bottom: 30px;
}

.empty-state h2 {
    font-size: 2em;
    font-weight: 700;
    color: #ffffff;
    margin: 0 0 15px 0;
}

.empty-state p {
    color: #ffffff;
    opacity: 0.7;
    font-size: 1.1em;
    margin: 0 0 30px 0;
}

.btn-crear-primero {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 15px 30px;
    background: linear-gradient(135deg, #8b00ff, #0066ff);
    color: #ffffff;
    border: none;
    border-radius: 12px;
    font-weight: 600;
    font-size: 1em;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(139, 0, 255, 0.4);
}

.btn-crear-primero:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(139, 0, 255, 0.6);
}

/* Proyectos Grid */
.proyectos-container {
    max-height: calc(100vh - 150px);
    overflow-y: auto;
    padding-right: 10px;
}

.proyectos-container::-webkit-scrollbar {
    width: 8px;
}

.proyectos-container::-webkit-scrollbar-track {
    background: rgba(0, 0, 0, 0.3);
    border-radius: 10px;
}

.proyectos-container::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #8b00ff, #0066ff);
    border-radius: 10px;
}

/* Proyectos Grid */
.proyectos-container {
    max-height: calc(100vh - 150px);
    overflow-y: auto;
    padding-right: 10px;
}

.proyectos-container::-webkit-scrollbar {
    width: 8px;
}

.proyectos-container::-webkit-scrollbar-track {
    background: rgba(0, 0, 0, 0.3);
    border-radius: 10px;
}

.proyectos-container::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #8b00ff, #0066ff);
    border-radius: 10px;
}

.proyectos-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 25px;
    padding-bottom: 20px;
    justify-content: flex-start;
}

.proyecto-card {
    background: rgba(0, 0, 0, 0.7);
    border: 2px solid rgba(139, 0, 255, 0.3);
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
    height: fit-content;
    flex: 0 0 calc(20% - 20px); /* 5 por fila */
    min-width: 280px;
}

.proyecto-card:hover {
    border-color: #8b00ff;
    box-shadow: 0 8px 30px rgba(139, 0, 255, 0.4);
    transform: translateY(-3px);
}

.card-header {
    padding: 16px 18px;
    border-bottom: 1px solid rgba(139, 0, 255, 0.2);
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: relative;
    background: rgba(139, 0, 255, 0.05);
}

.card-title {
    flex: 1;
    display: flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
}

.card-title h3 {
    font-size: 1.1em;
    font-weight: 700;
    color: #ffffff;
    margin: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 200px;
}

.tag-sql {
    background: linear-gradient(135deg, #8b00ff, #0066ff);
    color: #ffffff;
    padding: 3px 10px;
    border-radius: 5px;
    font-size: 0.7em;
    font-weight: 600;
    white-space: nowrap;
}

.btn-opciones {
    background: none;
    border: none;
    color: #8b00ff;
    cursor: pointer;
    padding: 5px;
    border-radius: 6px;
    transition: all 0.3s ease;
    flex-shrink: 0;
}

.btn-opciones:hover {
    background: rgba(139, 0, 255, 0.2);
}

.opciones-menu {
    position: absolute;
    top: 45px;
    right: 15px;
    background: rgba(0, 0, 0, 0.98);
    border: 2px solid rgba(139, 0, 255, 0.5);
    border-radius: 8px;
    padding: 5px 0;
    min-width: 150px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.7);
    z-index: 100;
    animation: slideDown 0.2s ease;
}

.opcion-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 14px;
    color: #ffffff;
    cursor: pointer;
    transition: all 0.2s ease;
    font-size: 0.9em;
}

.opcion-item:hover {
    background: rgba(139, 0, 255, 0.2);
}

.opcion-item svg {
    color: #8b00ff;
    flex-shrink: 0;
}

.opcion-eliminar {
    color: #ff0055;
}

.opcion-eliminar svg {
    color: #ff0055;
}

.opcion-eliminar:hover {
    background: rgba(255, 0, 85, 0.2);
}

.card-body {
    padding: 16px 18px;
    cursor: pointer;
}

.descripcion {
    color: #ffffff;
    opacity: 0.8;
    font-size: 0.9em;
    margin: 0 0 15px 0;
    line-height: 1.5;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
    min-height: 60px;
}

.card-footer {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    padding-top: 10px;
    border-top: 1px solid rgba(139, 0, 255, 0.1);
}

.fecha {
    display: flex;
    align-items: center;
    gap: 6px;
    color: #8b00ff;
    font-size: 0.8em;
    font-weight: 500;
}

.fecha svg {
    opacity: 0.7;
    flex-shrink: 0;
}

@media (max-width: 1800px) {
    .proyecto-card {
        flex: 0 0 calc(25% - 19px); /* 4 por fila */
    }
}

@media (max-width: 1400px) {
    .proyecto-card {
        flex: 0 0 calc(33.333% - 17px); /* 3 por fila */
    }
}

@media (max-width: 1000px) {
    .proyecto-card {
        flex: 0 0 calc(50% - 12.5px); /* 2 por fila */
    }
}

@media (max-width: 650px) {
    .proyecto-card {
        flex: 0 0 100%; /* 1 por fila */
    }
    
    .dashboard-content {
        padding-left: 20px;
        padding-right: 20px;
    }
}

/* Modal Eliminar */
.modal-eliminar {
    max-width: 500px;
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

.mensaje-eliminar strong {
    color: #8b00ff;
}

.submensaje-eliminar {
    color: #ffffff;
    opacity: 0.7;
    font-size: 0.9em;
    text-align: center;
    margin: 0;
}

.btn-eliminar {
    padding: 12px 30px;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    border: none;
    font-size: 1em;
    background: linear-gradient(135deg, #ff0055, #cc0044);
    color: #ffffff;
    box-shadow: 0 4px 15px rgba(255, 0, 85, 0.4);
}

.btn-eliminar:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 0, 85, 0.6);
}

.btn-eliminar:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

/* Modal Historial */
.modal-historial {
    max-width: 800px;
}

.header-con-nombre {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.nombre-proyecto {
    font-size: 0.9em;
    color: #8b00ff;
    font-weight: 600;
}

.modal-body-horizontal {
    display: flex;
    gap: 0;
    padding: 25px 30px;
}

.historial-columna {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 18px;
}

.historial-header {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 2px solid rgba(139, 0, 255, 0.3);
}

.historial-header svg {
    color: #8b00ff;
    flex-shrink: 0;
}

.historial-header h4 {
    font-size: 1.1em;
    font-weight: 700;
    color: #ffffff;
    margin: 0;
}

.historial-info {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.info-item {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.info-label {
    font-size: 0.8em;
    color: #8b00ff;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.info-value {
    font-size: 0.95em;
    color: #ffffff;
    font-weight: 500;
}

.usuario-info {
    display: flex;
    flex-direction: column;
    gap: 4px;
    background: rgba(139, 0, 255, 0.1);
    padding: 10px 12px;
    border-radius: 8px;
    border-left: 3px solid #8b00ff;
}

.usuario-nombre {
    font-size: 1em;
    color: #ffffff;
    font-weight: 600;
}

.usuario-email {
    font-size: 0.85em;
    color: #8b00ff;
    opacity: 0.9;
}

.fecha-destacada {
    display: flex;
    align-items: center;
    gap: 8px;
    background: rgba(0, 102, 255, 0.1);
    padding: 8px 12px;
    border-radius: 8px;
    border-left: 3px solid #0066ff;
    font-size: 0.9em;
}

.fecha-destacada svg {
    color: #0066ff;
    flex-shrink: 0;
}

.historial-divider-vertical {
    width: 1px;
    background: linear-gradient(180deg, transparent, #8b00ff, transparent);
    margin: 0 25px;
}

.sin-modificaciones {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 30px 15px;
    text-align: center;
    background: rgba(139, 0, 255, 0.05);
    border-radius: 10px;
    border: 2px dashed rgba(139, 0, 255, 0.3);
    height: 100%;
}

.sin-modificaciones svg {
    color: #8b00ff;
    opacity: 0.5;
    margin-bottom: 12px;
}

.sin-modificaciones p {
    color: #ffffff;
    opacity: 0.7;
    font-size: 0.9em;
    margin: 0;
    font-style: italic;
}

@media (max-width: 768px) {
    .modal-body-horizontal {
        flex-direction: column;
    }
    
    .historial-divider-vertical {
        width: 100%;
        height: 1px;
        margin: 20px 0;
        background: linear-gradient(90deg, transparent, #8b00ff, transparent);
    }
    
    .modal-historial {
        max-width: 95%;
    }
}

/* Estados del Proyecto */
.estado-buttons {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}

.btn-estado {
    flex: 1;
    min-width: 140px;
    padding: 12px 20px;
    background: rgba(255, 255, 255, 0.05);
    border: 2px solid rgba(255, 255, 255, 0.1);
    border-radius: 10px;
    color: #ffffff;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.btn-estado:hover {
    background: rgba(255, 255, 255, 0.1);
    transform: translateY(-2px);
}

.btn-estado svg {
    flex-shrink: 0;
}

.btn-estado.estado-activo {
    background: rgba(0, 255, 136, 0.15);
    border-color: #00ff88;
    color: #00ff88;
    box-shadow: 0 4px 15px rgba(0, 255, 136, 0.3);
}

.btn-estado.estado-activo svg {
    color: #00ff88;
}

.btn-estado.estado-inactivo {
    background: rgba(255, 69, 58, 0.15);
    border-color: #ff453a;
    color: #ff453a;
    box-shadow: 0 4px 15px rgba(255, 69, 58, 0.3);
}

.btn-estado.estado-inactivo svg {
    color: #ff453a;
}

.btn-estado.estado-finalizado {
    background: rgba(0, 102, 255, 0.15);
    border-color: #0066ff;
    color: #0066ff;
    box-shadow: 0 4px 15px rgba(0, 102, 255, 0.3);
}

.btn-estado.estado-finalizado svg {
    color: #0066ff;
}

@media (max-width: 600px) {
    .estado-buttons {
        flex-direction: column;
    }
    
    .btn-estado {
        width: 100%;
    }
}

.card-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-top: 10px;
    border-top: 1px solid rgba(139, 0, 255, 0.1);
    flex-wrap: wrap;
    gap: 10px;
}

.badge-estado {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 0.75em;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.badge-estado svg {
    flex-shrink: 0;
}

.badge-estado.estado-activo {
    background: rgba(0, 255, 136, 0.15);
    color: #00ff88;
    border: 1px solid rgba(0, 255, 136, 0.3);
}

.badge-estado.estado-activo svg {
    color: #00ff88;
}

.badge-estado.estado-inactivo {
    background: rgba(255, 69, 58, 0.15);
    color: #ff453a;
    border: 1px solid rgba(255, 69, 58, 0.3);
}

.badge-estado.estado-inactivo svg {
    color: #ff453a;
}

.badge-estado.estado-finalizado {
    background: rgba(0, 102, 255, 0.15);
    color: #0066ff;
    border: 1px solid rgba(0, 102, 255, 0.3);
}

.badge-estado.estado-finalizado svg {
    color: #0066ff;
}

.fecha {
    display: flex;
    align-items: center;
    gap: 6px;
    color: #8b00ff;
    font-size: 0.8em;
    font-weight: 500;
}

.fecha svg {
    opacity: 0.7;
    flex-shrink: 0;
}
</style>