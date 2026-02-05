<template>
    <div class="leonardo-data">
        <nav class="navbar-data">
            <div class="navbar-content">
                <div class="proyecto-info">
                    <div class="icono-proyecto">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                        </svg>
                    </div>
                    <div class="proyecto-nombre">
                        <h1>{{ proyecto.nombre || 'Cargando...' }}</h1>
                    </div>
                </div>

                <div class="navbar-actions">
                    <div class="zoom-controls">
                        <button class="btn-zoom" @click="zoomOut" title="Alejar">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="8" y1="11" x2="14" y2="11"></line>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                        </button>
                        <span class="zoom-level">{{ zoomLevel }}%</span>
                        <button class="btn-zoom" @click="zoomIn" title="Acercar">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="11" y1="8" x2="11" y2="14"></line>
                                <line x1="8" y1="11" x2="14" y2="11"></line>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                        </button>
                        <button class="btn-zoom" @click="resetZoom" title="Restablecer zoom">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="1 4 1 10 7 10"></polyline>
                                <polyline points="23 20 23 14 17 14"></polyline>
                                <path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 0 1 3.51 15"></path>
                            </svg>
                        </button>
                    </div>

                    <button class="btn-crear-tabla" @click="mostrarModal = true">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="3" y1="9" x2="21" y2="9"></line>
                            <line x1="9" y1="21" x2="9" y2="9"></line>
                        </svg>
                        <span>Crear Tabla</span>
                    </button>

                    <div class="dropdown-exportar" v-click-outside="() => mostrarMenuExportar = false">
        <button class="btn-exportar" @click="mostrarMenuExportar = !mostrarMenuExportar">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                <polyline points="7 10 12 15 17 10"></polyline>
                <line x1="12" y1="15" x2="12" y2="3"></line>
            </svg>
            <span>Exportar BD</span>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="chevron-down">
                <polyline points="6 9 12 15 18 9"></polyline>
            </svg>
        </button>

        <div v-if="mostrarMenuExportar" class="menu-exportar">
            <button class="menu-exportar-opcion" @click="exportarBaseDatos">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="12" y1="18" x2="12" y2="12"></line>
                    <line x1="9" y1="15" x2="15" y2="15"></line>
                </svg>
                Exportar Base de Datos
            </button>
<button class="menu-exportar-opcion" @click="mostrarCanvaSQL">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
        <line x1="9" y1="9" x2="15" y2="9"></line>
        <line x1="9" y1="13" x2="15" y2="13"></line>
        <line x1="9" y1="17" x2="13" y2="17"></line>
    </svg>
    Mostrar Canvas SQL
</button>

<button class="menu-exportar-opcion" @click="abrirCanvasLaravel">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                <polyline points="2 17 12 22 22 17"></polyline>
                <polyline points="2 12 12 17 22 12"></polyline>
            </svg>
            Mostrar Migraciones Laravel
        </button>
        </div>
    </div>

                    

                    <button class="btn-salir" @click="salirDelProyecto">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                        <span>Salir del Proyecto</span>
                    </button>
                </div>
            </div>
        </nav>

        <!-- Panel SQL Canvas -->
<div :class="['sql-canvas-panel', { 'sql-canvas-abierto': mostrarCanvasSQL }]">
    <div class="sql-canvas-header">
        <div class="sql-canvas-titulo">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="16 18 22 12 16 6"></polyline>
                <polyline points="8 6 2 12 8 18"></polyline>
            </svg>
            <h3>SQL Preview</h3>
            <span class="sql-canvas-badge">{{ proyecto.nombre || '' }}</span>
        </div>
        
        <div class="sql-canvas-acciones">
            <button class="btn-sql-accion" @click="copiarSQL" title="Copiar SQL">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                    <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                </svg>
                <span>Copiar</span>
            </button>
            
            <button class="btn-sql-accion" @click="descargarSQLDesdeCanvas" title="Descargar SQL">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                    <polyline points="7 10 12 15 17 10"></polyline>
                    <line x1="12" y1="15" x2="12" y2="3"></line>
                </svg>
                <span>Descargar</span>
            </button>
            
            <button class="btn-sql-cerrar" @click="cerrarCanvasSQL" title="Cerrar">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>
    </div>
    
    <div class="sql-canvas-info">
        <div class="sql-info-item">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
            </svg>
            <span>{{ tablas.length }} tablas</span>
        </div>
        <div class="sql-info-item">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="12" y1="1" x2="12" y2="23"></line>
                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
            </svg>
            <span>{{ contarLineasSQL }} líneas</span>
        </div>
        <div class="sql-info-item">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"></circle>
                <polyline points="12 6 12 12 16 14"></polyline>
            </svg>
            <span>{{ new Date().toLocaleDateString('es-ES') }}</span>
        </div>
    </div>
    
    <div class="sql-canvas-body">
        <div ref="editorContainer" class="editor-sql-container"></div>
    </div>
</div>

<!-- Overlay cuando el canvas está abierto -->
<div v-if="mostrarCanvasSQL" class="sql-canvas-overlay" @click="cerrarCanvasSQL"></div>

<div :class="['laravel-canvas-panel', { 'laravel-canvas-abierto': mostrarCanvasLaravel }]">
    <div class="laravel-canvas-header">
        <div class="laravel-canvas-titulo">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                <polyline points="2 17 12 22 22 17"></polyline>
                <polyline points="2 12 12 17 22 12"></polyline>
            </svg>
            <h3>Laravel Migrations</h3>
            <span class="laravel-canvas-badge">{{ proyecto.nombre || '' }}</span>
        </div>
        
        <div class="laravel-canvas-acciones">
            <button class="btn-laravel-accion" @click="copiarLaravel" title="Copiar Migraciones">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                    <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                </svg>
                <span>Copiar</span>
            </button>
            
            <button class="btn-laravel-cerrar" @click="cerrarPanelLaravel" title="Cerrar">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>
    </div>
    
    <div class="laravel-canvas-info">
        <div class="laravel-info-item">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
            </svg>
            <span>{{ contarMigraciones }} migraciones</span>
        </div>
        <div class="laravel-info-item">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="12" y1="1" x2="12" y2="23"></line>
                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
            </svg>
            <span>{{ contarLineasLaravel }} líneas</span>
        </div>
        <div class="laravel-info-item">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"></circle>
                <polyline points="12 6 12 12 16 14"></polyline>
            </svg>
            <span>{{ new Date().toLocaleDateString('es-ES') }}</span>
        </div>
    </div>
    
    <div class="laravel-canvas-body">
        <div ref="editorContainerLaravel" class="editor-laravel-container"></div>
    </div>
</div>

<!-- Overlay cuando el canvas Laravel está abierto -->
<div v-if="mostrarCanvasLaravel" class="laravel-canvas-overlay" @click="cerrarPanelLaravel"></div>

        <!-- Sidebar de Tablas -->
        <aside class="sidebar-tablas">
            <div class="sidebar-header">
                <h2 class="sidebar-titulo">Tablas</h2>
                <span class="sidebar-proyecto-nombre">{{ proyecto.nombre || '' }}</span>
            </div>

            <div class="sidebar-lista">
                <div
                    v-for="tabla in tablas"
                    :key="tabla.id_tabla"
                    class="tabla-item"
                    v-click-outside="() => cerrarMenu(tabla.id_tabla)"
                >
                    <div class="tabla-cabecera">
                        <button class="btn-toggle" @click="toggleTabla(tabla.id_tabla)">
                            <svg
                                width="14" height="14" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2.5"
                                :style="{ transform: tablasAbiertas[tabla.id_tabla] ? 'rotate(90deg)' : 'rotate(0deg)' }"
                                class="icono-chevron"
                            >
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </button>

                        <div class="tabla-nombre-wrap" :style="{ backgroundColor: tabla.color_tabla }">
                            <span class="tabla-nombre">{{ tabla.nombre_tabla }}</span>
                        </div>

                            <button class="btn-ubicar-tabla" @click.stop="centrarEnTabla(tabla)" title="Ir a la tabla">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <circle cx="12" cy="12" r="10"></circle>
            <circle cx="12" cy="12" r="3" fill="currentColor"></circle>
            <line x1="12" y1="2" x2="12" y2="6"></line>
            <line x1="12" y1="18" x2="12" y2="22"></line>
            <line x1="2" y1="12" x2="6" y2="12"></line>
            <line x1="18" y1="12" x2="22" y2="12"></line>
        </svg>
    </button>

                        <button class="btn-menu-tabla" @click.stop="toggleMenu(tabla.id_tabla)">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <circle cx="12" cy="5" r="1.5" fill="currentColor"></circle>
                                <circle cx="12" cy="12" r="1.5" fill="currentColor"></circle>
                                <circle cx="12" cy="19" r="1.5" fill="currentColor"></circle>
                            </svg>
                        </button>

                        <div v-if="tablasMenu[tabla.id_tabla]" class="menu-tabla">
                            <button class="menu-tabla-opcion" @click="abrirModalEditar(tabla)">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                </svg>
                                Editar tabla
                            </button>
                            <button class="menu-tabla-opcion menu-tabla-eliminar" @click="eliminarTabla(tabla)">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                </svg>
                                Eliminar tabla
                            </button>
                        </div>
                    </div>

                    <div v-if="tablasAbiertas[tabla.id_tabla]" class="tabla-contenido">
                        <div class="tabla-botones-acciones">
                            <button class="btn-tabla-accion" @click="abrirModalColumna(tabla)">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                Agregar columna
                            </button>
<button class="btn-tabla-accion" @click="abrirModalIndex(tabla)">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
        <line x1="12" y1="5" x2="12" y2="19"></line>
        <line x1="5" y1="12" x2="19" y2="12"></line>
    </svg>
    Agregar index
</button>
                        </div>

                        <div class="columnas-lista">
                            <div
                                v-for="col in (columnasTabla[tabla.id_tabla] || [])"
                                :key="col.id_columna"
                                class="columna-item"
                                v-click-outside="() => cerrarMenu2('col-' + col.id_columna)"
                            >
                                <div class="columna-row">
                                    <div class="columna-nombre-wrap">
                                        <span class="columna-nombre">{{ col.nombre_columna }}</span>
                                    </div>
                                    <span class="columna-tipo">{{ col.tipo_columna }}</span>
                                    <span v-if="col.longitud_columna" class="columna-longitud">({{ col.longitud_columna }})</span>

                                    <button class="btn-menu-columna" @click.stop="toggleMenu2('col-' + col.id_columna)">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                            <circle cx="12" cy="5" r="1.5" fill="currentColor"></circle>
                                            <circle cx="12" cy="12" r="1.5" fill="currentColor"></circle>
                                            <circle cx="12" cy="19" r="1.5" fill="currentColor"></circle>
                                        </svg>
                                    </button>

                                    <div v-if="tablasMenu['col-' + col.id_columna]" class="menu-columna">
                                        <button class="menu-columna-opcion" @click="abrirModalInfo(tabla, col)">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <line x1="12" y1="16" x2="12" y2="12"></line>
                                                <line x1="12" y1="8" x2="12.01" y2="8"></line>
                                            </svg>
                                            Ver información
                                        </button>
                                        <button class="menu-columna-opcion" @click="abrirModalEditarColumna(tabla, col)">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                            </svg>
                                            Editar
                                        </button>
                                        <button class="menu-columna-opcion menu-columna-eliminar" @click="eliminarColumna(tabla, col)">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <polyline points="3 6 5 6 21 6"></polyline>
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                            </svg>
                                            Eliminar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sección de Índices -->
<!-- Sección de Índices -->
<!-- Sección de Índices -->
<div v-if="(indicesTabla[tabla.id_tabla] || []).length > 0" class="indices-seccion">
    <h4 class="indices-titulo">Índices</h4>
    <div class="indice-item">
        <textarea
            :value="obtenerNombresColumnas(indicesTabla[tabla.id_tabla])"
            readonly
            class="indice-textarea"
        ></textarea>
        <button class="btn-menu-indice" @click.stop="toggleMenu2('idx-' + tabla.id_tabla)">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <circle cx="12" cy="5" r="1.5" fill="currentColor"></circle>
                <circle cx="12" cy="12" r="1.5" fill="currentColor"></circle>
                <circle cx="12" cy="19" r="1.5" fill="currentColor"></circle>
            </svg>
        </button>

        <div v-if="tablasMenu['idx-' + tabla.id_tabla]" class="menu-indice">
            <button class="menu-indice-opcion" @click="abrirModalIndex(tabla)">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                </svg>
                Editar
            </button>
        </div>
    </div>
</div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Workspace con tablas renderizadas directamente -->
        <div
            :class="['workspace', { panning: isPanning }]"
            ref="workspace"
            @contextmenu.prevent
            @mousedown="onMouseDown"
            @mousemove="onMouseMoveGlobal"
            @mouseup="onMouseUpGlobal"
            @mouseleave="onMouseUpGlobal"
            @wheel.prevent="onWheel"
        >
            <canvas ref="gridCanvas" class="grid-canvas"></canvas>

            <!-- Contenedor de tablas con transformación -->
            <div 
                class="plano-content" 
                ref="planoContent"
                :style="{
                    transform: `translate(${panX}px, ${panY}px) scale(${zoomLevel / 100})`,
                    transformOrigin: '0 0'
                }"
            >
            
                <!-- Renderizar cada tabla -->
                <div
                    v-for="tabla in tablasConPosiciones"
                    :key="tabla.id_tabla"
                    class="tabla-canvas"
                    :class="{ 'tabla-seleccionada': tablaSeleccionada === tabla.id_tabla }"
                    :style="{
                        left: tabla.x + 'px',
                        top: tabla.y + 'px',
                        width: '240px'
                    }"
                    @mousedown="onTableMouseDown($event, tabla)"
                >

                
                    <!-- Header -->
                    <div 
                        class="tabla-canvas-header"
                        :style="{ backgroundColor: tabla.color_tabla || '#8b00ff' }"
                    >
                        {{ tabla.nombre_tabla }}
                    </div>

                    <!-- Columnas -->
                    <div class="tabla-canvas-body">
<div
    v-for="(col, index) in tabla.columnas"
    :key="col.id_columna"
    class="tabla-canvas-row"
    :class="{ 'row-par': index % 2 === 0 }"
>
    <!-- PUNTO IZQUIERDO -->
    <div 
        :id="`punto-${col.id_columna}`"
        class="punto-conexion punto-izquierdo"
       :class="{ 
    'punto-visible': true,
    'punto-arrastrando': arrastrandoRelacion && puntoOrigenId === `punto-${col.id_columna}`
}"
        :style="{ backgroundColor: tabla.color_tabla || '#8b5cf6' }"
        @mousedown.stop="onPuntoMouseDown($event, tabla, col, 'izquierdo')"
        @mouseup.stop="onPuntoMouseUp($event, tabla, col, 'izquierdo')"
        @mouseenter="e => e.currentTarget.classList.add('punto-hover')"
        @mouseleave="e => e.currentTarget.classList.remove('punto-hover')"
    ></div>
    
<span class="row-icono">
  <i v-if="col.indice_tipo === 'PRIMARY KEY'" class="fas fa-key" title="Primary Key"></i>
  <i v-else-if="col.indice_tipo === 'UNIQUE'" class="fas fa-star" title="Unique"></i>
  <i v-else-if="col.indice_tipo === 'INDEX'" class="fas fa-file-lines" title="Index"></i>
</span>
    <span class="row-nombre">{{ col.nombre_columna }}</span>
    <span class="row-tipo">{{ col.tipo_columna }}</span>
    <span v-if="col.longitud_columna" class="row-longitud">({{ col.longitud_columna }})</span>
    
    <!-- PUNTO DERECHO -->
    <div 
        :id="`punto-${col.id_columna}-right`"
        class="punto-conexion punto-derecho"
:class="{ 
    'punto-visible': true,
    'punto-arrastrando': arrastrandoRelacion && puntoOrigenId === `punto-${col.id_columna}-right`
}"
        :style="{ backgroundColor: tabla.color_tabla || '#8b5cf6' }"
        @mousedown.stop="onPuntoMouseDown($event, tabla, col, 'derecho')"
        @mouseup.stop="onPuntoMouseUp($event, tabla, col, 'derecho')"
        @mouseenter="e => e.currentTarget.classList.add('punto-hover')"
        @mouseleave="e => e.currentTarget.classList.remove('punto-hover')"
    ></div>
</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modales (mantener igual) -->
    <div v-if="mostrarModal" class="modal-overlay" @click.self="mostrarModal = false">
        <div class="modal-box">
            <h2 class="modal-titulo">Agregar Tabla</h2>
            <input
                v-model="nombreTabla"
                type="text"
                class="modal-input"
                :class="{ 'input-limite': nombreTabla.length > 240 }"
                placeholder="Nombre de la tabla"
                maxlength="250"
                @keyup.enter="crearTabla"
            />
            <div class="contador-caracteres" :class="{ 'contador-limite': nombreTabla.length > 240 }">
                {{ nombreTabla.length }}/250
            </div>
            <div class="modal-acciones">
                <button class="btn-modal-cancelar" @click="mostrarModal = false">Cancelar</button>
                <button class="btn-modal-agregar" @click="crearTabla">Agregar</button>
            </div>
        </div>
    </div>

    <div v-if="mostrarModalEditar" class="modal-overlay" @click.self="mostrarModalEditar = false">
        <div class="modal-box">
            <h2 class="modal-titulo">Editar Tabla</h2>
            <input
                v-model="tablaEditando.nombre_tabla"
                type="text"
                class="modal-input"
                :class="{ 'input-limite': tablaEditando.nombre_tabla.length > 240 }"
                placeholder="Nombre de la tabla"
                maxlength="250"
                @keyup.enter="editarTabla"
            />
            <div class="contador-caracteres" :class="{ 'contador-limite': tablaEditando.nombre_tabla.length > 240 }">
                {{ tablaEditando.nombre_tabla.length }}/250
            </div>
            <div class="modal-acciones">
                <button class="btn-modal-cancelar" @click="mostrarModalEditar = false">Cancelar</button>
                <button class="btn-modal-agregar" @click="editarTabla">Editar</button>
            </div>
        </div>
    </div>

    <!-- Modal Agregar Columna -->
    <div v-if="mostrarModalColumna" class="modal-overlay modal-columna-overlay" @click.self="mostrarModalColumna = false">
        <div class="modal-box modal-columna">
            <div class="modal-columna-header">
                <h2 class="modal-titulo">Agregar Columna</h2>
                <span class="modal-columna-tabla-nombre">{{ tablaColumna?.nombre_tabla }}</span>
                <button class="btn-modal-cerrar" @click="mostrarModalColumna = false">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <div class="modal-columna-body">
                <div class="campo-columna campo-obligatorio">
                    <label>Nombre <span class="campo-requerido">*</span></label>
                    <input
                        v-model="nuevaColumna.nombre_columna"
                        type="text"
                        maxlength="250"
                        placeholder="Nombre"
                        :class="{ 'input-limite': nuevaColumna.nombre_columna.length > 240 }"
                    />
                    <div class="contador" :class="{ 'contador-limite': nuevaColumna.nombre_columna.length > 240 }">
                        {{ nuevaColumna.nombre_columna.length }}/250
                    </div>
                </div>

                <div class="campo-columna campo-obligatorio">
                    <label>Descripción <span class="campo-requerido">*</span></label>
                    <input
                        v-model="nuevaColumna.descripcion_columna"
                        type="text"
                        maxlength="250"
                        placeholder="Descripción"
                        :class="{ 'input-limite': nuevaColumna.descripcion_columna.length > 240 }"
                    />
                    <div class="contador" :class="{ 'contador-limite': nuevaColumna.descripcion_columna.length > 240 }">
                        {{ nuevaColumna.descripcion_columna.length }}/250
                    </div>
                </div>

                <div class="campo-columna campo-obligatorio">
                    <label>Tipo <span class="campo-requerido">*</span></label>
                    <select v-model="nuevaColumna.tipo_columna" @change="onTipoChange">
                        <option value="" disabled>Selecciona</option>
                        <optgroup v-for="grupo in tiposColumna" :key="grupo.grupo" :label="grupo.grupo">
                            <option v-for="tipo in grupo.tipos" :key="tipo" :value="tipo">{{ tipo }}</option>
                        </optgroup>
                    </select>
                </div>

                <div class="campo-columna campo-opcional" v-if="tienelongitud">
                    <label>Longitud</label>
                    <input
                        v-model.number="nuevaColumna.longitud_columna"
                        type="number"
                        :min="1"
                        :max="longitudMaxima"
                        placeholder="Longitud"
                    />
                    <div class="contador">Máx: {{ longitudMaxima }}</div>
                </div>

                <div class="campo-columna campo-opcional" v-if="tieneCotejamiento">
                    <label>Cotejamiento</label>
                    <select v-model="nuevaColumna.cotejamiento_columna">
                        <option value="" disabled>Selecciona</option>
                        <option v-for="c in cotejamiientos" :key="c" :value="c">{{ c }}</option>
                    </select>
                </div>

                <div class="campo-columna campo-opcional campo-toggle">
                    <label>Nulo</label>
                    <div class="toggle-wrap">
                        <input
                            type="checkbox"
                            id="toggle-nulo"
                            class="toggle-input"
                            :checked="nuevaColumna.nulo_columna"
                            @change="nuevaColumna.nulo_columna = $event.target.checked"
                        />
                        <label for="toggle-nulo" class="toggle-slider"></label>
                    </div>
                </div>

                <div class="campo-columna campo-opcional campo-toggle" v-if="tieneAutoIncremento">
                    <label>Auto inc.</label>
                    <div class="toggle-wrap">
                        <input
                            type="checkbox"
                            id="toggle-auto"
                            class="toggle-input"
                            :checked="nuevaColumna.auto_incrementar"
                            @change="nuevaColumna.auto_incrementar = $event.target.checked"
                        />
                        <label for="toggle-auto" class="toggle-slider"></label>
                    </div>
                </div>

                <div class="campo-columna campo-opcional">
                    <label>Índice</label>
                    <select v-model="nuevaColumna.indice_tipo">
                        <option value="">Ninguno</option>
                        <option v-for="idx in indicesTipo" :key="idx" :value="idx">{{ idx }}</option>
                    </select>
                </div>
            </div>

            <div class="modal-columna-footer">
                <button class="btn-modal-cancelar" @click="mostrarModalColumna = false">Cancelar</button>
                <button class="btn-modal-agregar" @click="crearColumna" :disabled="!columnaValida">Agregar</button>
            </div>
        </div>
    </div>

    <!-- Modal Ver Información (mantener igual) -->
    <div v-if="mostrarModalInfo && columnaInfo" class="modal-overlay modal-columna-overlay" @click.self="mostrarModalInfo = false">
        <div class="modal-box modal-info">
            <div class="modal-info-header">
                <h2 class="modal-titulo">Información de Columna</h2>
                <button class="btn-modal-cerrar" @click="mostrarModalInfo = false">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <div class="modal-info-body">
                <div class="info-campo">
                    <span class="info-label">Tabla</span>
                    <span class="info-valor info-valor-tabla">{{ columnaInfo._tabla_nombre }}</span>
                </div>

                <div class="info-campo">
                    <span class="info-label">Nombre</span>
                    <span class="info-valor">{{ columnaInfo.nombre_columna }}</span>
                </div>

                <div class="info-campo" v-if="columnaInfo.descripcion_columna">
                    <span class="info-label">Descripción</span>
                    <span class="info-valor">{{ columnaInfo.descripcion_columna }}</span>
                </div>

                <div class="info-campo">
                    <span class="info-label">Tipo</span>
                    <span class="info-valor info-valor-tipo">{{ columnaInfo.tipo_columna }}</span>
                </div>

                <div class="info-campo" v-if="columnaInfo.longitud_columna">
                    <span class="info-label">Longitud</span>
                    <span class="info-valor">{{ columnaInfo.longitud_columna }}</span>
                </div>

                <div class="info-campo" v-if="columnaInfo.cotejamiento_columna">
                    <span class="info-label">Cotejamiento</span>
                    <span class="info-valor info-valor-cotejamiento">{{ columnaInfo.cotejamiento_columna }}</span>
                </div>

                <div class="info-campo" v-if="columnaInfo.nulo_columna !== null">
                    <span class="info-label">Nulo</span>
                    <span class="info-valor">
                        <span class="info-badge" :class="columnaInfo.nulo_columna ? 'badge-si' : 'badge-no'">
                            {{ columnaInfo.nulo_columna ? 'Sí' : 'No' }}
                        </span>
                    </span>
                </div>

                <div class="info-campo" v-if="columnaInfo.auto_incrementar">
                    <span class="info-label">Auto incrementar</span>
                    <span class="info-valor">
                        <span class="info-badge badge-si">Sí</span>
                    </span>
                </div>

                <div class="info-campo" v-if="columnaInfo.indice_tipo">
                    <span class="info-label">Índice</span>
                    <span class="info-valor info-valor-indice">{{ columnaInfo.indice_tipo }}</span>
                </div>

                <div class="info-campo" v-if="columnaInfo.fecha_registro">
                    <span class="info-label">Fecha registro</span>
                    <span class="info-valor info-valor-fecha">{{ columnaInfo.fecha_registro }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Editar Columna -->
    <div v-if="mostrarModalEditarColumna && columnaEditando" class="modal-overlay modal-columna-overlay" @click.self="mostrarModalEditarColumna = false">
        <div class="modal-box modal-columna">
            <div class="modal-columna-header">
                <h2 class="modal-titulo">Editar Columna</h2>
                <span class="modal-columna-tabla-nombre">{{ tablaColumnaEditando?.nombre_tabla }}</span>
                <button class="btn-modal-cerrar" @click="mostrarModalEditarColumna = false">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <div class="modal-columna-body">
                <div class="campo-columna campo-obligatorio">
                    <label>Nombre <span class="campo-requerido">*</span></label>
                    <input
                        v-model="columnaEditando.nombre_columna"
                        type="text"
                        maxlength="250"
                        placeholder="Nombre"
                        :class="{ 'input-limite': columnaEditando.nombre_columna.length > 240 }"
                    />
                    <div class="contador" :class="{ 'contador-limite': columnaEditando.nombre_columna.length > 240 }">
                        {{ columnaEditando.nombre_columna.length }}/250
                    </div>
                </div>

                <div class="campo-columna campo-obligatorio">
                    <label>Descripción <span class="campo-requerido">*</span></label>
                    <input
                        v-model="columnaEditando.descripcion_columna"
                        type="text"
                        maxlength="250"
                        placeholder="Descripción"
                        :class="{ 'input-limite': columnaEditando.descripcion_columna.length > 240 }"
                    />
                    <div class="contador" :class="{ 'contador-limite': columnaEditando.descripcion_columna.length > 240 }">
                        {{ columnaEditando.descripcion_columna.length }}/250
                    </div>
                </div>

                <div class="campo-columna campo-obligatorio">
                    <label>Tipo <span class="campo-requerido">*</span></label>
                    <select v-model="columnaEditando.tipo_columna" @change="onTipoEditarChange">
                        <option value="" disabled>Selecciona</option>
                        <optgroup v-for="grupo in tiposColumna" :key="grupo.grupo" :label="grupo.grupo">
                            <option v-for="tipo in grupo.tipos" :key="tipo" :value="tipo">{{ tipo }}</option>
                        </optgroup>
                    </select>
                </div>

                <div class="campo-columna campo-opcional" v-if="tieneColumnaEditarLongitud">
                    <label>Longitud</label>
                    <input
                        v-model.number="columnaEditando.longitud_columna"
                        type="number"
                        :min="1"
                        :max="longitudEditarMaxima"
                        placeholder="Longitud"
                    />
                    <div class="contador">Máx: {{ longitudEditarMaxima }}</div>
                </div>

                <div class="campo-columna campo-opcional" v-if="tieneColumnaEditarCotejamiento">
                    <label>Cotejamiento</label>
                    <select v-model="columnaEditando.cotejamiento_columna">
                        <option value="" disabled>Selecciona</option>
                        <option v-for="c in cotejamiientos" :key="c" :value="c">{{ c }}</option>
                    </select>
                </div>

                <div class="campo-columna campo-opcional campo-toggle">
                    <label>Nulo</label>
                    <div class="toggle-wrap">
                        <input
                            type="checkbox"
                            id="toggle-nulo-editar"
                            class="toggle-input"
                            :checked="columnaEditando.nulo_columna"
                            @change="columnaEditando.nulo_columna = $event.target.checked"
                        />
                        <label for="toggle-nulo-editar" class="toggle-slider"></label>
                    </div>
                </div>

                <div class="campo-columna campo-opcional campo-toggle" v-if="tieneColumnaEditarAutoIncremento">
                    <label>Auto inc.</label>
                    <div class="toggle-wrap">
                        <input
                            type="checkbox"
                            id="toggle-auto-editar"
                            class="toggle-input"
                            :checked="columnaEditando.auto_incrementar"
                            @change="columnaEditando.auto_incrementar = $event.target.checked"
                        />
                        <label for="toggle-auto-editar" class="toggle-slider"></label>
                    </div>
                </div>

                <div class="campo-columna campo-opcional">
                    <label>Índice</label>
                    <select v-model="columnaEditando.indice_tipo">
                        <option value="">Ninguno</option>
                        <option v-for="idx in indicesTipo" :key="idx" :value="idx">{{ idx }}</option>
                    </select>
                </div>
            </div>

            <div class="modal-columna-footer">
                <button class="btn-modal-cancelar" @click="mostrarModalEditarColumna = false">Cancelar</button>
                <button class="btn-modal-agregar" @click="editarColumna" :disabled="!columnaEditaValida">Editar</button>
            </div>
        </div>
    </div>

    <!-- Popup eliminar relación -->
<div
    v-if="popupRelacion"
    class="popup-relacion"
    :style="{ left: popupRelacion.x + 'px', top: popupRelacion.y + 'px' }"
>
    <span class="popup-relacion-texto">¿Eliminar esta relación?</span>
    <div class="popup-relacion-botones">
        <button class="btn-popup-cancelar" @click="popupRelacion = null">Cancelar</button>
        <button class="btn-popup-eliminar" @click="eliminarRelacionPopup">Eliminar</button>
    </div>
</div>

<div v-if="mostrarModalIndex" class="modal-overlay modal-columna-overlay" @click.self="mostrarModalIndex = false">
    <div class="modal-box modal-columna">
        <div class="modal-columna-header">
            <h2 class="modal-titulo">{{ tienIndices(tablaIndex) ? 'Editar' : 'Agregar' }} Índice</h2>
            <span class="modal-columna-tabla-nombre">{{ tablaIndex?.nombre_tabla }}</span>
            <button class="btn-modal-cerrar" @click="mostrarModalIndex = false">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>

        <div class="modal-columna-body">
            <div class="campo-columna">
                <label>Selecciona las columnas para el índice</label>
                <div class="lista-columnas-index-horizontal">
                    <label
                        v-for="col in (columnasTabla[tablaIndex?.id_tabla] || [])"
                        :key="col.id_columna"
                        class="columna-chip"
                        :class="{ 'columna-chip-seleccionada': columnasSeleccionadasIndex.includes(col.id_columna) }"
                    >
                        <input
                            type="checkbox"
                            :value="col.id_columna"
                            :checked="columnasSeleccionadasIndex.includes(col.id_columna)"
                            @change="toggleColumnaIndex(col.id_columna)"
                            class="columna-chip-checkbox"
                        />
                        <span class="columna-chip-nombre">{{ col.nombre_columna }}</span>
                    </label>
                </div>
                <p v-if="columnasSeleccionadasIndex.length === 0" class="texto-ayuda-eliminar">
                    Si no se seleccionan ninguna columna, se eliminarán todos los índices
                </p>
            </div>
        </div>

        <div class="modal-columna-footer">
            <button class="btn-modal-cancelar" @click="mostrarModalIndex = false">Cancelar</button>
            <button 
                class="btn-modal-agregar" 
                @click="gestionarIndex"
                :class="{ 'btn-eliminar': columnasSeleccionadasIndex.length === 0 && tienIndices(tablaIndex) }"
            >
                {{ obtenerTextoBoton() }}
            </button>
        </div>
    </div>
</div>

    <div v-if="mostrarAlerta" class="alerta-toast">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#4ade80" stroke-width="2.5">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
            <polyline points="22 4 12 14.01 9 11.01"></polyline>
        </svg>
        <span>{{ mensajeAlerta }}</span>
    </div>
</template>

<script>
import axios from 'axios';
import { newInstance } from '@jsplumb/browser-ui';
import { EditorView, basicSetup } from 'codemirror';
import { sql } from '@codemirror/lang-sql';
import { oneDark } from '@codemirror/theme-one-dark';
import { php } from '@codemirror/lang-php';

const vClickOutside = {
    mounted(el, binding) {
        el._clickOutside = (e) => {
            if (!el.contains(e.target)) binding.value();
        };
        document.addEventListener('mousedown', el._clickOutside);
    },
    beforeUnmount(el) {
        document.removeEventListener('mousedown', el._clickOutside);
    }
};



export default {
    name: 'LeonardoData',
    directives: {
        clickOutside: vClickOutside
    },
    computed: {
        tienelongitud() {
            const tipos = ['CHAR','VARCHAR','TINYINT','SMALLINT','MEDIUMINT','INT','BIGINT','FLOAT','DOUBLE','DECIMAL','NUMERIC','BIT'];
            return tipos.includes(this.nuevaColumna.tipo_columna);
        },
        longitudMaxima() {
            const mapa = {
                CHAR: 255, VARCHAR: 255,
                TINYINT: 4, SMALLINT: 6, MEDIUMINT: 9, INT: 11, BIGINT: 20,
                FLOAT: 24, DOUBLE: 53, DECIMAL: 65, NUMERIC: 65, BIT: 64
            };
            return mapa[this.nuevaColumna.tipo_columna] || 255;
        },
        tieneCotejamiento() {
            const tipos = ['CHAR','VARCHAR','TINYTEXT','TEXT','MEDIUMTEXT','LONGTEXT','ENUM','SET'];
            return tipos.includes(this.nuevaColumna.tipo_columna);
        },
        tieneAutoIncremento() {
            const tipos = ['TINYINT','SMALLINT','MEDIUMINT','INT','BIGINT','FLOAT','DOUBLE','DECIMAL','NUMERIC'];
            return tipos.includes(this.nuevaColumna.tipo_columna);
        },
        columnaValida() {
            return this.nuevaColumna.nombre_columna.trim() !== ''
                && this.nuevaColumna.descripcion_columna.trim() !== ''
                && this.nuevaColumna.tipo_columna !== '';
        },
        tieneColumnaEditarLongitud() {
            const tipos = ['CHAR','VARCHAR','TINYINT','SMALLINT','MEDIUMINT','INT','BIGINT','FLOAT','DOUBLE','DECIMAL','NUMERIC','BIT'];
            return tipos.includes(this.columnaEditando?.tipo_columna);
        },
        longitudEditarMaxima() {
            const mapa = {
                CHAR: 255, VARCHAR: 255,
                TINYINT: 4, SMALLINT: 6, MEDIUMINT: 9, INT: 11, BIGINT: 20,
                FLOAT: 24, DOUBLE: 53, DECIMAL: 65, NUMERIC: 65, BIT: 64
            };
            return mapa[this.columnaEditando?.tipo_columna] || 255;
        },
        tieneColumnaEditarCotejamiento() {
            const tipos = ['CHAR','VARCHAR','TINYTEXT','TEXT','MEDIUMTEXT','LONGTEXT','ENUM','SET'];
            return tipos.includes(this.columnaEditando?.tipo_columna);
        },
        tieneColumnaEditarAutoIncremento() {
            const tipos = ['TINYINT','SMALLINT','MEDIUMINT','INT','BIGINT','FLOAT','DOUBLE','DECIMAL','NUMERIC'];
            return tipos.includes(this.columnaEditando?.tipo_columna);
        },
        columnaEditaValida() {
            if (!this.columnaEditando) return false;
            return this.columnaEditando.nombre_columna.trim() !== ''
                && this.columnaEditando.descripcion_columna.trim() !== ''
                && this.columnaEditando.tipo_columna !== '';
        },

        contarLineasSQL() {
        return this.sqlGenerado.split('\n').length;
        },

        contarLineasLaravel() {
        return this.migracionesLaravel.split('\n').length;
    },
    
    contarMigraciones() {
        if (!this.migracionesLaravel) return 0;

        const matches = this.migracionesLaravel.match(/class extends Migration/g);
        return matches ? matches.length : 0;
    },
        
        tablasConPosiciones() {
            return this.tablas.map(tabla => {
                const cols = this.columnasTabla[tabla.id_tabla] || [];
                let posX = 100;
                let posY = 100;
                
                if (tabla.posicion) {
                    posX = Number(tabla.posicion.pos_x) || 100;
                    posY = Number(tabla.posicion.pos_y) || 100;
                }
                
                return {
                    ...tabla,
                    x: posX,
                    y: posY,
                    columnas: cols
                };
            });
        }
    },
    data() {
        return {
            idProyecto: null,
            proyecto: {},
            zoomLevel: 100,
            cargando: true,

            isPanning: false,
            panX: 0,
            panY: 0,
            startPanX: 0,
            startPanY: 0,
            startMouseX: 0,
            startMouseY: 0,

            mostrarModal: false,
            nombreTabla: '',

            mensajeAlerta: '',
            mostrarAlerta: false,
            savePositionTimeout: null,

            tablas: [],
            tablasAbiertas: {},
            tablasMenu: {},

            mostrarModalEditar: false,
            tablaEditando: null,

            columnasTabla: {},

            mostrarModalInfo: false,
            columnaInfo: null,

            mostrarModalEditarColumna: false,
            columnaEditando: null,
            tablaColumnaEditando: null,

            tablaSeleccionada: null,

            mostrarModalColumna: false,
            tablaColumna: null,
            nuevaColumna: {
                nombre_columna: '',
                descripcion_columna: '',
                tipo_columna: '',
                longitud_columna: null,
                cotejamiento_columna: null,
                nulo_columna: true,
                auto_incrementar: false,
                indice_tipo: null
            },

            tiposColumna: [
                { grupo: 'Numéricos', tipos: ['TINYINT','SMALLINT','MEDIUMINT','INT','BIGINT','FLOAT','DOUBLE','DECIMAL','NUMERIC','BIT'] },
                { grupo: 'Texto', tipos: ['CHAR','VARCHAR','TINYTEXT','TEXT','MEDIUMTEXT','LONGTEXT'] },
                { grupo: 'Fecha y hora', tipos: ['DATE','DATETIME','TIMESTAMP','TIME','YEAR'] },
                { grupo: 'Otros', tipos: ['BOOLEAN','BLOB','ENUM','SET','JSON','GEOMETRY','POINT','LINESTRING','POLYGON'] }
            ],
            cotejamiientos: [
                'utf8mb4_unicode_ci',
                'utf8mb4_0900_ai_ci',
                'utf8mb4_general_ci',
                'utf8mb4_bin',
                'utf8mb4_0900_as_cs',
                'utf8mb4_spanish_ci',
                'utf8mb4_roman_ci',
                'utf8mb4_german2_ci',
                'utf8mb4_ja_0900_as_cs',
                'utf8mb4_general_mysql500_ci'
            ],
            indicesTipo: ['UNIQUE','PRIMARY KEY','FULLTEXT','SPATIAL'],
            
            draggingTable: null,
            dragOffsetX: 0,
            dragOffsetY: 0,

            jsPlumbInstance: null,
            relaciones: [],
            relacionesMap: new Map(), 

            arrastrandoRelacion: false,
            puntoOrigenId: null,
            puntoOrigenData: null,
            lineaTemporal: null,
            popupRelacion: null,

            mostrarModalIndex: false,
tablaIndex: null,
indicesTabla: {}, 
columnasSeleccionadasIndex: [],

mostrarMenuExportar: false,
        exportandoSQL: false,

        mostrarCanvasSQL: false,
        editorView: null,
        sqlGenerado: '',

        mostrarCanvasLaravel: false,
        editorViewLaravel: null,
        migracionesLaravel: '',

        };
    },

    mounted() {
        this.idProyecto = this.$route.params.id;
        if (this.idProyecto) {
            this.cargarProyecto();
            this.cargarTablas();
            this.cargarRelaciones();
        } else {
            this.$router.push('/leonardoproyectos');
        }

        this.$nextTick(() => {
            this.dibujarGrid();
            this.inicializarJsPlumb();
            window.addEventListener('resize', this.dibujarGrid);
            document.addEventListener('mouseup', this.onDocumentMouseUp);
            document.addEventListener('mousemove', this.onDocumentMouseMove);
        });
    },
    beforeUnmount() {
        window.removeEventListener('resize', this.dibujarGrid);
        document.removeEventListener('mouseup', this.onDocumentMouseUp);
        document.removeEventListener('mousemove', this.onDocumentMouseMove);
    },
    watch: {
        zoomLevel() {
            this.dibujarGrid();
        },
        panX() {
            this.dibujarGrid();
        },
        panY() {
            this.dibujarGrid();
        }
    },

    methods: {

        async cargarProyecto() {
            this.cargando = true;
            try {
                const token = localStorage.getItem('token');
                const response = await axios.get(`/api/proyectos/ver`, {
                    headers: { 'Authorization': `Bearer ${token}` }
                });
                this.proyecto = response.data.data.find(
                    p => p.id_proyecto === parseInt(this.idProyecto)
                );
                if (!this.proyecto) {
                    this.$router.push('/leonardoproyectos');
                }
            } catch (error) {
                this.$router.push('/leonardoproyectos');
            } finally {
                this.cargando = false;
            }
        },

        async cargarTablas() {
    try {
        const token = localStorage.getItem('token');
        const response = await axios.get(`/api/data/tablas/${this.idProyecto}`, {
            headers: { 'Authorization': `Bearer ${token}` }
        });
        this.tablas = response.data.data;

        for (const tabla of this.tablas) {
            await this.cargarColumnas(tabla.id_tabla);
            await this.cargarPosicion(tabla.id_tabla);
            await this.cargarIndices(tabla.id_tabla); 
        }

        this.$nextTick(() => {
            this.renderizarRelaciones();
        });

    } catch (error) {

    }
},

async mostrarCanvaSQL() {
            this.mostrarMenuExportar = false;
            
            try {
                const token = localStorage.getItem('token');
                
                const response = await axios.get(`/api/chat/proyecto/${this.idProyecto}/contexto`, {
                    headers: { 'Authorization': `Bearer ${token}` }
                });

                if (!response.data.success) {
                    throw new Error('No se pudo obtener el contexto del proyecto');
                }

                const { proyecto, tablas, estructura_completa } = response.data.data;
                this.sqlGenerado = this.generarSQL(proyecto, tablas, estructura_completa);
                this.mostrarCanvasSQL = true;
                
                await this.$nextTick();
                setTimeout(() => {
                    this.inicializarEditor();
                }, 50);

            } catch (error) {
                console.error('Error al mostrar canvas SQL:', error);
                this.mensajeAlerta = 'Error al generar el SQL';
                this.mostrarAlerta = true;
                setTimeout(() => { this.mostrarAlerta = false; }, 3000);
            }
        },

inicializarEditor() {
            const container = this.$refs.editorContainer;
            if (!container) {
                console.error('Container no encontrado');
                return;
            }


            if (this.editorView) {
                this.editorView.destroy();
                this.editorView = null;
            }


            container.innerHTML = '';

            try {
                this.editorView = new EditorView({
                    doc: this.sqlGenerado,
                    extensions: [
                        basicSetup,
                        sql(),
                        oneDark,
                        EditorView.editable.of(false),
                        EditorView.lineWrapping
                    ],
                    parent: container
                });
            } catch (error) {
                console.error('Error al crear editor:', error);
            }
        },

cerrarCanvasSQL() {
            this.mostrarCanvasSQL = false;
            
            this.$nextTick(() => {
                if (this.editorView) {
                    this.editorView.destroy();
                    this.editorView = null;
                }
            });
        },

copiarSQL() {
    if (!this.sqlGenerado) return;
    
    navigator.clipboard.writeText(this.sqlGenerado).then(() => {
        this.mensajeAlerta = 'SQL copiado al portapapeles';
        this.mostrarAlerta = true;
        setTimeout(() => { this.mostrarAlerta = false; }, 2000);
    }).catch(err => {
        console.error('Error al copiar:', err);
    });
},

descargarSQLDesdeCanvas() {
    if (!this.sqlGenerado) return;
    
    const nombreArchivo = `${this.proyecto.nombre.replace(/\s+/g, '_')}.sql`;
    this.descargarArchivo(this.sqlGenerado, nombreArchivo);
    
    this.mensajeAlerta = 'SQL descargado correctamente';
    this.mostrarAlerta = true;
    setTimeout(() => { this.mostrarAlerta = false; }, 2000);
},
        async cargarPosicion(idTabla) {
            try {
                const token = localStorage.getItem('token');
                const response = await axios.get(`/api/posicion/ver/${idTabla}`, {
                    headers: { 'Authorization': `Bearer ${token}` }
                });

                const tabla = this.tablas.find(t => t.id_tabla === idTabla);
                if (tabla && response.data.posicion) {
                    tabla.posicion = {
                        pos_x: Number(response.data.posicion.pos_x),
                        pos_y: Number(response.data.posicion.pos_y)
                    };
                } else if (tabla) {
                    tabla.posicion = null;
                }
            } catch (error) {
                const tabla = this.tablas.find(t => t.id_tabla === idTabla);
                if (tabla) {
                    tabla.posicion = null;
                }
            }
        },


obtenerNombresColumnas(indices) {
    if (!indices || indices.length === 0) return '';
    return indices.map(idx => idx.columna.nombre_columna).join(', ');
},




async cargarIndices(idTabla) {
    try {
        const token = localStorage.getItem('token');
        const response = await axios.get(`/api/index/tabla/${idTabla}`, {
            headers: { 'Authorization': `Bearer ${token}` }
        });
        
        this.indicesTabla = {
            ...this.indicesTabla,
            [idTabla]: response.data.data
        };
    } catch (error) {

    }
},



abrirModalIndex(tabla) {
    this.tablaIndex = tabla;
    

    const indicesExistentes = this.indicesTabla[tabla.id_tabla] || [];
    this.columnasSeleccionadasIndex = indicesExistentes.map(idx => idx.id_columna);
    
    this.mostrarModalIndex = true;
},


tienIndices(tabla) {
    if (!tabla) return false;
    const indices = this.indicesTabla[tabla.id_tabla] || [];
    return indices.length > 0;
},


obtenerTextoBoton() {
    if (this.columnasSeleccionadasIndex.length === 0 && this.tienIndices(this.tablaIndex)) {
        return 'Eliminar índices';
    }
    if (this.tienIndices(this.tablaIndex)) {
        return 'Actualizar';
    }
    return 'Agregar';
},

async abrirCanvasLaravel() {
        this.mostrarMenuExportar = false;
        
        try {
            const token = localStorage.getItem('token');
            
            const response = await axios.get(`/api/chat/proyecto/${this.idProyecto}/contexto`, {
                headers: { 'Authorization': `Bearer ${token}` }
            });

            if (!response.data.success) {
                throw new Error('No se pudo obtener el contexto del proyecto');
            }

            const { proyecto, tablas, estructura_completa } = response.data.data;
            this.migracionesLaravel = this.generarMigracionesLaravel(proyecto, tablas, estructura_completa);
            this.mostrarCanvasLaravel = true;
            
            await this.$nextTick();
            setTimeout(() => {
                this.inicializarEditorLaravel();
            }, 50);

        } catch (error) {
            console.error('Error al mostrar canvas Laravel:', error);
            this.mensajeAlerta = 'Error al generar las migraciones';
            this.mostrarAlerta = true;
            setTimeout(() => { this.mostrarAlerta = false; }, 3000);
        }
    },
    
    inicializarEditorLaravel() {
        const container = this.$refs.editorContainerLaravel;
        if (!container) {
            console.error('Container Laravel no encontrado');
            return;
        }

        if (this.editorViewLaravel) {
            this.editorViewLaravel.destroy();
            this.editorViewLaravel = null;
        }

        container.innerHTML = '';

        try {

            import('@codemirror/lang-php').then(({ php }) => {
                this.editorViewLaravel = new EditorView({
                    doc: this.migracionesLaravel,
                    extensions: [
                        basicSetup,
                        php(),
                        oneDark,
                        EditorView.editable.of(false),
                        EditorView.lineWrapping
                    ],
                    parent: container
                });
            }).catch(() => {

                this.editorViewLaravel = new EditorView({
                    doc: this.migracionesLaravel,
                    extensions: [
                        basicSetup,
                        EditorView.editable.of(false),
                        EditorView.lineWrapping
                    ],
                    parent: container
                });
            });
        } catch (error) {
            console.error('Error al crear editor Laravel:', error);
        }
    },
    
    cerrarPanelLaravel() {
        this.mostrarCanvasLaravel = false;
        
        this.$nextTick(() => {
            if (this.editorViewLaravel) {
                this.editorViewLaravel.destroy();
                this.editorViewLaravel = null;
            }
        });
    },
    
    copiarLaravel() {
        if (!this.migracionesLaravel) return;
        
        navigator.clipboard.writeText(this.migracionesLaravel).then(() => {
            this.mensajeAlerta = 'Migraciones copiadas al portapapeles';
            this.mostrarAlerta = true;
            setTimeout(() => { this.mostrarAlerta = false; }, 2000);
        }).catch(err => {
            console.error('Error al copiar:', err);
        });
    },
    
    generarMigracionesLaravel(proyecto, tablas, estructuraCompleta) {
        let migraciones = '';
        const fecha = new Date().toLocaleDateString('es-ES');
        

        migraciones += `<?php\n\n`;
        migraciones += `/**\n`;
        migraciones += ` * =============================================\n`;
        migraciones += ` * LeonardoDB - Laravel Migrations\n`;
        migraciones += ` * =============================================\n`;
        migraciones += ` * Proyecto: ${proyecto.nombre}\n`;
        migraciones += ` * Descripción: ${proyecto.descripcion || 'Sin descripción'}\n`;
        migraciones += ` * Generado: ${fecha}\n`;
        migraciones += ` * Tablas: ${tablas.length}\n`;
        migraciones += ` * =============================================\n`;
        migraciones += ` * \n`;
        migraciones += ` * Instrucciones:\n`;
        migraciones += ` * 1. Copiar cada migración en un archivo separado\n`;
        migraciones += ` * 2. Nombrar archivos con formato: YYYY_MM_DD_HHMMSS_create_tabla_table.php\n`;
        migraciones += ` * 3. Ejecutar: php artisan migrate\n`;
        migraciones += ` * \n`;
        migraciones += ` */\n\n`;
        
        migraciones += `// =============================================\n`;
        migraciones += `// MIGRACIONES DE TABLAS\n`;
        migraciones += `// =============================================\n\n`;
        

        estructuraCompleta.forEach((item, index) => {
            migraciones += this.generarMigracionTabla(item, index);
            migraciones += `\n\n`;
        });
        

        const tieneRelaciones = estructuraCompleta.some(item => 
            item.relaciones && item.relaciones.length > 0
        );
        
        if (tieneRelaciones) {
            migraciones += `// =============================================\n`;
            migraciones += `// MIGRACIÓN DE FOREIGN KEYS\n`;
            migraciones += `// =============================================\n\n`;
            migraciones += this.generarMigracionForeignKeys(estructuraCompleta, estructuraCompleta.length);
        }
        
        return migraciones;
    },
    
    generarMigracionTabla(item, index) {
        const { tabla, columnas, indices } = item;
        const nombreClase = this.convertirANombreClase(tabla.nombre_tabla);
        const timestamp = this.generarTimestampLaravel(index);
        
        let codigo = '';
        codigo += `// Archivo: ${timestamp}_create_${tabla.nombre_tabla}_table.php\n\n`;
        codigo += `<?php\n\n`;
        codigo += `use Illuminate\\Database\\Migrations\\Migration;\n`;
        codigo += `use Illuminate\\Database\\Schema\\Blueprint;\n`;
        codigo += `use Illuminate\\Support\\Facades\\Schema;\n\n`;
        codigo += `return new class extends Migration\n`;
        codigo += `{\n`;
        codigo += `    /**\n`;
        codigo += `     * Run the migrations.\n`;
        codigo += `     */\n`;
        codigo += `    public function up(): void\n`;
        codigo += `    {\n`;
        codigo += `        Schema::create('${tabla.nombre_tabla}', function (Blueprint $table) {\n`;
        
    
        columnas.forEach(col => {
            codigo += this.generarColumnaLaravel(col, columnas);
        });
        

        if (indices && indices.length > 0) {
            codigo += `\n            // Índices compuestos\n`;
            const columnasIdx = indices.map(idx => idx.columna.nombre_columna);
            codigo += `            $table->index([${columnasIdx.map(c => `'${c}'`).join(', ')}]);\n`;
        }
        
        codigo += `        });\n`;
        codigo += `    }\n\n`;
        codigo += `    /**\n`;
        codigo += `     * Reverse the migrations.\n`;
        codigo += `     */\n`;
        codigo += `    public function down(): void\n`;
        codigo += `    {\n`;
        codigo += `        Schema::dropIfExists('${tabla.nombre_tabla}');\n`;
        codigo += `    }\n`;
        codigo += `};\n`;
        
        return codigo;
    },
    
    generarColumnaLaravel(col, todasColumnas) {
        let linea = '            ';
        const tipo = col.tipo_columna.toUpperCase();
        

        const esPrimaryKey = col.indice_tipo === 'PRIMARY KEY';
        

        if (esPrimaryKey && tipo === 'INT') {
            linea += `$table->id()`;
        } else if (tipo === 'INT' || tipo === 'INTEGER') {
            linea += `$table->integer('${col.nombre_columna}')`;
        } else if (tipo === 'BIGINT') {
            linea += `$table->bigInteger('${col.nombre_columna}')`;
        } else if (tipo === 'TINYINT') {
            linea += `$table->tinyInteger('${col.nombre_columna}')`;
        } else if (tipo === 'SMALLINT') {
            linea += `$table->smallInteger('${col.nombre_columna}')`;
        } else if (tipo === 'MEDIUMINT') {
            linea += `$table->mediumInteger('${col.nombre_columna}')`;
        } else if (tipo === 'VARCHAR') {
            const longitud = col.longitud_columna || 255;
            linea += `$table->string('${col.nombre_columna}', ${longitud})`;
        } else if (tipo === 'CHAR') {
            const longitud = col.longitud_columna || 255;
            linea += `$table->char('${col.nombre_columna}', ${longitud})`;
        } else if (tipo === 'TEXT') {
            linea += `$table->text('${col.nombre_columna}')`;
        } else if (tipo === 'LONGTEXT') {
            linea += `$table->longText('${col.nombre_columna}')`;
        } else if (tipo === 'MEDIUMTEXT') {
            linea += `$table->mediumText('${col.nombre_columna}')`;
        } else if (tipo === 'TINYTEXT') {
            linea += `$table->text('${col.nombre_columna}')`;
        } else if (tipo === 'DECIMAL' || tipo === 'NUMERIC') {
            const longitud = col.longitud_columna || '8,2';
            linea += `$table->decimal('${col.nombre_columna}', ${longitud})`;
        } else if (tipo === 'FLOAT') {
            linea += `$table->float('${col.nombre_columna}')`;
        } else if (tipo === 'DOUBLE') {
            linea += `$table->double('${col.nombre_columna}')`;
        } else if (tipo === 'DATE') {
            linea += `$table->date('${col.nombre_columna}')`;
        } else if (tipo === 'DATETIME') {
            linea += `$table->dateTime('${col.nombre_columna}')`;
        } else if (tipo === 'TIMESTAMP') {
            linea += `$table->timestamp('${col.nombre_columna}')`;
        } else if (tipo === 'TIME') {
            linea += `$table->time('${col.nombre_columna}')`;
        } else if (tipo === 'YEAR') {
            linea += `$table->year('${col.nombre_columna}')`;
        } else if (tipo === 'BOOLEAN' || tipo === 'BOOL') {
            linea += `$table->boolean('${col.nombre_columna}')`;
        } else if (tipo === 'JSON') {
            linea += `$table->json('${col.nombre_columna}')`;
        } else if (tipo === 'BLOB') {
            linea += `$table->binary('${col.nombre_columna}')`;
        } else if (tipo === 'ENUM') {
            linea += `$table->enum('${col.nombre_columna}', [])`;
        } else {

            linea += `$table->string('${col.nombre_columna}')`;
        }
        

        if (!esPrimaryKey) {
            if (col.nulo_columna) {
                linea += `->nullable()`;
            }
            
            if (col.indice_tipo === 'UNIQUE') {
                linea += `->unique()`;
            }
            
            if (col.indice_tipo === 'INDEX') {
                linea += `->index()`;
            }
            
            if (col.auto_incrementar && !esPrimaryKey) {
                linea += `->autoIncrement()`;
            }
        }
        

        if (col.descripcion_columna) {
            const descripcion = col.descripcion_columna.replace(/'/g, "\\'");
            linea += `->comment('${descripcion}')`;
        }
        
        linea += `;\n`;
        
        return linea;
    },
    
    generarMigracionForeignKeys(estructuraCompleta, baseIndex) {
        const timestamp = this.generarTimestampLaravel(baseIndex);
        let codigo = '';
        
        codigo += `// Archivo: ${timestamp}_add_foreign_keys.php\n\n`;
        codigo += `<?php\n\n`;
        codigo += `use Illuminate\\Database\\Migrations\\Migration;\n`;
        codigo += `use Illuminate\\Database\\Schema\\Blueprint;\n`;
        codigo += `use Illuminate\\Support\\Facades\\Schema;\n\n`;
        codigo += `return new class extends Migration\n`;
        codigo += `{\n`;
        codigo += `    /**\n`;
        codigo += `     * Run the migrations.\n`;
        codigo += `     */\n`;
        codigo += `    public function up(): void\n`;
        codigo += `    {\n`;
        
        estructuraCompleta.forEach(item => {
            if (item.relaciones && item.relaciones.length > 0) {
                item.relaciones.forEach(rel => {
                    const columnaOrigen = rel.columna_origen;
                    const columnaDestino = rel.columna_destino;
                    
                    if (!columnaOrigen || !columnaDestino) return;
                    if (columnaOrigen.id_tabla !== item.tabla.id_tabla) return;
                    
                    const tablaDestino = this.tablas.find(t => t.id_tabla === columnaDestino.id_tabla);
                    if (!tablaDestino) return;
                    
                    codigo += `        Schema::table('${item.tabla.nombre_tabla}', function (Blueprint $table) {\n`;
                    codigo += `            $table->foreign('${columnaOrigen.nombre_columna}')\n`;
                    codigo += `                  ->references('${columnaDestino.nombre_columna}')\n`;
                    codigo += `                  ->on('${tablaDestino.nombre_tabla}')\n`;
                    codigo += `                  ->onDelete('cascade')\n`;
                    codigo += `                  ->onUpdate('cascade');\n`;
                    codigo += `        });\n\n`;
                });
            }
        });
        
        codigo += `    }\n\n`;
        codigo += `    /**\n`;
        codigo += `     * Reverse the migrations.\n`;
        codigo += `     */\n`;
        codigo += `    public function down(): void\n`;
        codigo += `    {\n`;
        
        estructuraCompleta.forEach(item => {
            if (item.relaciones && item.relaciones.length > 0) {
                item.relaciones.forEach(rel => {
                    const columnaOrigen = rel.columna_origen;
                    if (!columnaOrigen) return;
                    if (columnaOrigen.id_tabla !== item.tabla.id_tabla) return;
                    
                    codigo += `        Schema::table('${item.tabla.nombre_tabla}', function (Blueprint $table) {\n`;
                    codigo += `            $table->dropForeign(['${columnaOrigen.nombre_columna}']);\n`;
                    codigo += `        });\n\n`;
                });
            }
        });
        
        codigo += `    }\n`;
        codigo += `};\n`;
        
        return codigo;
    },
    
    generarTimestampLaravel(index) {
        const now = new Date();
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const day = String(now.getDate()).padStart(2, '0');
        const hour = String(now.getHours()).padStart(2, '0');
        const minute = String(now.getMinutes()).padStart(2, '0');
        const second = String(now.getSeconds() + index).padStart(2, '0');
        
        return `${year}_${month}_${day}_${hour}${minute}${second}`;
    },
    
    convertirANombreClase(nombreTabla) {
        return nombreTabla
            .split('_')
            .map(word => word.charAt(0).toUpperCase() + word.slice(1))
            .join('');
    },
    


async gestionarIndex() {
    try {
        const token = localStorage.getItem('token');
        

        let mensajeExito = 'Índice procesado correctamente';
        if (this.columnasSeleccionadasIndex.length === 0) {
            mensajeExito = 'Índices eliminados correctamente';
        } else if (this.tienIndices(this.tablaIndex)) {
            mensajeExito = 'Índice actualizado correctamente';
        } else {
            mensajeExito = 'Índice creado correctamente';
        }

        await axios.post('/api/index/gestionar', {
            id_tabla: this.tablaIndex.id_tabla,
            columnas: this.columnasSeleccionadasIndex
        }, {
            headers: { 'Authorization': `Bearer ${token}` }
        });

        this.mostrarModalIndex = false;
        this.mensajeAlerta = mensajeExito;
        this.mostrarAlerta = true;
        await this.cargarIndices(this.tablaIndex.id_tabla);

        setTimeout(() => { this.mostrarAlerta = false; }, 3000);

    } catch (error) {
        this.mensajeAlerta = 'Error al procesar índice';
        this.mostrarAlerta = true;
        setTimeout(() => { this.mostrarAlerta = false; }, 3000);
    }
},

toggleColumnaIndex(idColumna) {
    const index = this.columnasSeleccionadasIndex.indexOf(idColumna);
    if (index > -1) {
        this.columnasSeleccionadasIndex.splice(index, 1);
    } else {
        this.columnasSeleccionadasIndex.push(idColumna);
    }
},


obtenerNombresColumnas(indices) {
    if (!indices || indices.length === 0) return '';
    return indices.map(idx => idx.columna.nombre_columna).join(', ');
},
        async cargarColumnas(idTabla) {
            try {
                const token = localStorage.getItem('token');
                const response = await axios.get(`/api/columna/ver/${idTabla}`, {
                    headers: { 'Authorization': `Bearer ${token}` }
                });
                this.columnasTabla = {
                    ...this.columnasTabla,
                    [idTabla]: response.data.data
                };
            } catch (error) {

            }
        },


        async crearTabla() {
            if (!this.nombreTabla.trim()) return;

            try {
                const token = localStorage.getItem('token');
                await axios.post('/api/data/crear', {
                    nombre_tabla: this.nombreTabla,
                    id_proyecto: this.idProyecto
                }, {
                    headers: { 'Authorization': `Bearer ${token}` }
                });

                this.nombreTabla = '';
                this.mostrarModal = false;
                this.mensajeAlerta = 'Tabla agregada correctamente';
                this.mostrarAlerta = true;
                this.cargarTablas();

                setTimeout(() => {
                    this.mostrarAlerta = false;
                }, 3000);

            } catch (error) {

            }
        },

        toggleTabla(idTabla) {
            const abre = !this.tablasAbiertas[idTabla];
            this.tablasAbiertas = {
                ...this.tablasAbiertas,
                [idTabla]: abre
            };
            if (abre) {
                this.cargarColumnas(idTabla);
            }
        },

        toggleMenu(idTabla) {
            this.tablasMenu = {
                ...this.tablasMenu,
                [idTabla]: !this.tablasMenu[idTabla]
            };
        },

        cerrarMenu(idTabla) {
            this.tablasMenu = {
                ...this.tablasMenu,
                [idTabla]: false
            };
        },

        abrirModalEditar(tabla) {
            this.tablaEditando = { ...tabla };
            this.mostrarModalEditar = true;
            this.cerrarMenu(tabla.id_tabla);
        },

        centrarEnTabla(tabla) {

    let posX = 100;
    let posY = 100;
    
    if (tabla.posicion) {
        posX = Number(tabla.posicion.pos_x) || 100;
        posY = Number(tabla.posicion.pos_y) || 100;
    }
    

    const workspace = this.$refs.workspace;
    if (!workspace) return;
    
    const workspaceWidth = workspace.clientWidth;
    const workspaceHeight = workspace.clientHeight;
    
    const scale = this.zoomLevel / 100;
    

    const tablaWidth = 240; 
    const columnas = this.columnasTabla[tabla.id_tabla] || [];
    const tablaHeight = this.calcularAlturaTabla(columnas);
    

    const tablaCentroX = posX + (tablaWidth / 2);
    const tablaCentroY = posY + (tablaHeight / 2);
    

    this.panX = (workspaceWidth / 2) - (tablaCentroX * scale);
    this.panY = (workspaceHeight / 2) - (tablaCentroY * scale);
    

    this.tablaSeleccionada = tabla.id_tabla;
    

    this.actualizarPosicionesJsPlumb();
    

    this.resaltarTabla(tabla.id_tabla);
},


resaltarTabla(idTabla) {

    const tablasResaltadas = document.querySelectorAll('.tabla-canvas.tabla-resaltada');
    tablasResaltadas.forEach(t => t.classList.remove('tabla-resaltada'));
    

    this.$nextTick(() => {
        const elementoTabla = document.querySelector(`.tabla-canvas[data-tabla-id="${idTabla}"]`);
        if (elementoTabla) {
            elementoTabla.classList.add('tabla-resaltada');
            

            setTimeout(() => {
                elementoTabla.classList.remove('tabla-resaltada');
            }, 2000);
        }
    });
},

async exportarBaseDatos() {
    this.mostrarMenuExportar = false;
    this.exportandoSQL = true;

    try {
        const token = localStorage.getItem('token');
        

        const response = await axios.get(`/api/chat/proyecto/${this.idProyecto}/contexto`, {
            headers: { 'Authorization': `Bearer ${token}` }
        });

        if (!response.data.success) {
            throw new Error('No se pudo obtener el contexto del proyecto');
        }

        const { proyecto, tablas, estructura_completa } = response.data.data;


        const sql = this.generarSQL(proyecto, tablas, estructura_completa);


        this.descargarArchivo(sql, `${proyecto.nombre.replace(/\s+/g, '_')}.sql`);

        this.mensajeAlerta = 'Base de datos exportada correctamente';
        this.mostrarAlerta = true;
        setTimeout(() => { this.mostrarAlerta = false; }, 3000);

    } catch (error) {
        console.error('Error al exportar:', error);
        this.mensajeAlerta = 'Error al exportar la base de datos';
        this.mostrarAlerta = true;
        setTimeout(() => { this.mostrarAlerta = false; }, 3000);
    } finally {
        this.exportandoSQL = false;
    }
},

generarSQL(proyecto, tablas, estructuraCompleta) {
    let sql = '';
    const fecha = new Date().toLocaleString('es-ES');
    const nombreDB = proyecto.nombre.replace(/\s+/g, '_').toLowerCase();


    sql += `-- =============================================\n`;
    sql += `-- LeonardoDB - Database Designer\n`;
    sql += `-- =============================================\n`;
    sql += `-- Proyecto: ${proyecto.nombre}\n`;
    sql += `-- Descripción: ${proyecto.descripcion || 'Sin descripción'}\n`;
    sql += `-- Generado: ${fecha}\n`;
    sql += `-- Tablas: ${tablas.length}\n`;
    sql += `-- =============================================\n\n`;


    sql += `SET FOREIGN_KEY_CHECKS = 0;\n`;
    sql += `SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";\n`;
    sql += `SET time_zone = "+00:00";\n\n`;


    sql += `-- =============================================\n`;
    sql += `-- BASE DE DATOS\n`;
    sql += `-- =============================================\n\n`;
    sql += `CREATE DATABASE IF NOT EXISTS \`${nombreDB}\`;\n`;
    sql += `USE \`${nombreDB}\`;\n\n`;


    sql += `-- =============================================\n`;
    sql += `-- TABLAS\n`;
    sql += `-- =============================================\n\n`;
    
    estructuraCompleta.forEach(item => {
        sql += this.generarCreateTable(item.tabla, item.columnas, item.indices);
        sql += '\n';
    });


    sql += `-- =============================================\n`;
    sql += `-- FOREIGN KEYS (RELACIONES)\n`;
    sql += `-- =============================================\n\n`;
    
    let hayRelaciones = false;
    estructuraCompleta.forEach(item => {
        if (item.relaciones && item.relaciones.length > 0) {
            const fkSQL = this.generarForeignKeys(item.tabla, item.relaciones);
            if (fkSQL) {
                sql += fkSQL;
                hayRelaciones = true;
            }
        }
    });
    
    if (!hayRelaciones) {
        sql += `-- No hay relaciones definidas\n\n`;
    }


    sql += `-- =============================================\n`;
    sql += `-- FIN DEL SCRIPT\n`;
    sql += `-- =============================================\n\n`;
    sql += `SET FOREIGN_KEY_CHECKS = 1;\n`;

    return sql;
},

generarCreateTable(tabla, columnas, indices) {
    let sql = `-- Tabla: ${tabla.nombre_tabla}\n`;
    sql += `CREATE TABLE IF NOT EXISTS \`${tabla.nombre_tabla}\` (\n`;


    const columnasSQL = columnas.map((col, index) => {
        let colSQL = `  \`${col.nombre_columna}\` `;
        

        colSQL += this.mapearTipoDato(col);
        

        colSQL += col.nulo_columna ? ' NULL' : ' NOT NULL';
        

        const esNumericoEntero = ['TINYINT', 'SMALLINT', 'MEDIUMINT', 'INT', 'BIGINT'].includes(col.tipo_columna.toUpperCase());
        const esPrimaryKey = col.indice_tipo === 'PRIMARY KEY';
        
        if (col.auto_incrementar && esNumericoEntero && esPrimaryKey) {
            colSQL += ' AUTO_INCREMENT';
        }
        

        if (col.descripcion_columna) {
            colSQL += ` COMMENT '${col.descripcion_columna.replace(/'/g, "''")}'`;
        }
        
        return colSQL;
    }).join(',\n');

    sql += columnasSQL;


    const primaryKeys = columnas.filter(col => col.indice_tipo === 'PRIMARY KEY');
    if (primaryKeys.length > 0) {
        sql += `,\n  PRIMARY KEY (${primaryKeys.map(pk => `\`${pk.nombre_columna}\``).join(', ')})`;
    }


    const uniqueKeys = columnas.filter(col => col.indice_tipo === 'UNIQUE');
    uniqueKeys.forEach(uk => {
        sql += `,\n  UNIQUE KEY \`uk_${uk.nombre_columna}\` (\`${uk.nombre_columna}\`)`;
    });


    const indexes = columnas.filter(col => col.indice_tipo === 'INDEX');
    indexes.forEach(idx => {
        sql += `,\n  KEY \`idx_${idx.nombre_columna}\` (\`${idx.nombre_columna}\`)`;
    });


    const fulltextIndexes = columnas.filter(col => col.indice_tipo === 'FULLTEXT');
    fulltextIndexes.forEach(ft => {
        sql += `,\n  FULLTEXT KEY \`ft_${ft.nombre_columna}\` (\`${ft.nombre_columna}\`)`;
    });


    const spatialIndexes = columnas.filter(col => col.indice_tipo === 'SPATIAL');
    spatialIndexes.forEach(sp => {
        sql += `,\n  SPATIAL KEY \`sp_${sp.nombre_columna}\` (\`${sp.nombre_columna}\`)`;
    });

    if (indices && indices.length > 0) {

        const indicesPorTabla = {};
        indices.forEach(idx => {
            if (!indicesPorTabla[idx.id_tabla]) {
                indicesPorTabla[idx.id_tabla] = [];
            }
            indicesPorTabla[idx.id_tabla].push(idx);
        });


        Object.values(indicesPorTabla).forEach((grupoIndices, index) => {
            if (grupoIndices.length > 0) {
                const columnasIdx = grupoIndices
                    .map(g => g.columna ? `\`${g.columna.nombre_columna}\`` : null)
                    .filter(Boolean)
                    .join(', ');
                
                if (columnasIdx) {
                    sql += `,\n  KEY \`idx_compuesto_${index + 1}\` (${columnasIdx})`;
                }
            }
        });
    }

    sql += `\n) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;\n`;

    return sql;
},

mapearTipoDato(columna) {
    let tipo = columna.tipo_columna.toUpperCase();
    

    if (columna.longitud_columna) {
        if (['CHAR', 'VARCHAR', 'TINYINT', 'SMALLINT', 'MEDIUMINT', 'INT', 'BIGINT', 
             'FLOAT', 'DOUBLE', 'DECIMAL', 'NUMERIC', 'BIT'].includes(tipo)) {
            tipo += `(${columna.longitud_columna})`;
        }
    } else {

        if (tipo === 'INT') tipo = 'INT(11)';
        if (tipo === 'TINYINT') tipo = 'TINYINT(4)';
        if (tipo === 'SMALLINT') tipo = 'SMALLINT(6)';
        if (tipo === 'MEDIUMINT') tipo = 'MEDIUMINT(9)';
        if (tipo === 'BIGINT') tipo = 'BIGINT(20)';
    }
    

    if (columna.cotejamiento_columna && ['CHAR', 'VARCHAR', 'TEXT', 'TINYTEXT', 'MEDIUMTEXT', 'LONGTEXT'].includes(tipo.split('(')[0])) {
        tipo += ` COLLATE ${columna.cotejamiento_columna}`;
    }
    
    return tipo;
},

agruparIndicesCompuestos(indices, columnas) {

    return [];
},

generarForeignKeys(tabla, relaciones) {
    if (!relaciones || relaciones.length === 0) return '';
    
    let sql = '';
    let fkCount = 0;
    
    relaciones.forEach((rel) => {
        const columnaOrigen = rel.columna_origen;
        const columnaDestino = rel.columna_destino;
        
        if (!columnaOrigen || !columnaDestino) return;
        

        if (columnaOrigen.id_tabla !== tabla.id_tabla) return;
        

        const tablaDestino = this.tablas.find(t => t.id_tabla === columnaDestino.id_tabla);
        if (!tablaDestino) return;
        
        fkCount++;
        const constraintName = `fk_${tabla.nombre_tabla}_${columnaOrigen.nombre_columna}`;
        
        sql += `-- Relación: ${tabla.nombre_tabla}.${columnaOrigen.nombre_columna} -> ${tablaDestino.nombre_tabla}.${columnaDestino.nombre_columna}\n`;
        sql += `ALTER TABLE \`${tabla.nombre_tabla}\`\n`;
        sql += `  ADD CONSTRAINT \`${constraintName}\`\n`;
        sql += `  FOREIGN KEY (\`${columnaOrigen.nombre_columna}\`)\n`;
        sql += `  REFERENCES \`${tablaDestino.nombre_tabla}\` (\`${columnaDestino.nombre_columna}\`)\n`;
        sql += `  ON DELETE CASCADE\n`;
        sql += `  ON UPDATE CASCADE;\n\n`;
    });
    
    return sql;
},

descargarArchivo(contenido, nombreArchivo) {
    const blob = new Blob([contenido], { type: 'text/plain;charset=utf-8' });
    const url = window.URL.createObjectURL(blob);
    const link = document.createElement('a');
    link.href = url;
    link.download = nombreArchivo;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    window.URL.revokeObjectURL(url);
},

        async editarTabla() {
            if (!this.tablaEditando.nombre_tabla.trim()) return;

            try {
                const token = localStorage.getItem('token');
                await axios.put(`/api/data/editar/${this.tablaEditando.id_tabla}`, {
                    nombre_tabla: this.tablaEditando.nombre_tabla
                }, {
                    headers: { 'Authorization': `Bearer ${token}` }
                });

                this.mostrarModalEditar = false;
                this.mensajeAlerta = 'Tabla modificada correctamente';
                this.mostrarAlerta = true;
                this.tablaEditando = null;
                this.cargarTablas();

                setTimeout(() => {
                    this.mostrarAlerta = false;
                }, 3000);

            } catch (error) {

            }
        },

        async eliminarTabla(tabla) {
            try {
                const token = localStorage.getItem('token');
                await axios.delete(`/api/data/eliminar/${tabla.id_tabla}`, {
                    headers: { 'Authorization': `Bearer ${token}` }
                });

                this.cerrarMenu(tabla.id_tabla);
                this.cargarTablas();

                this.mensajeAlerta = 'Tabla eliminada correctamente';
                this.mostrarAlerta = true;

                setTimeout(() => {
                    this.mostrarAlerta = false;
                }, 3000);

            } catch (error) {

            }
        },


        toggleMenu2(id) {
            this.tablasMenu = {
                ...this.tablasMenu,
                [id]: !this.tablasMenu[id]
            };
        },

        cerrarMenu2(id) {
            this.tablasMenu = {
                ...this.tablasMenu,
                [id]: false
            };
        },

        abrirModalInfo(tabla, columna) {
            this.columnaInfo = { ...columna, _tabla_nombre: tabla.nombre_tabla };
            this.mostrarModalInfo = true;
            this.cerrarMenu2('col-' + columna.id_columna);
        },

        abrirModalColumna(tabla) {
            this.tablaColumna = tabla;
            this.nuevaColumna = {
                nombre_columna: '',
                descripcion_columna: '',
                tipo_columna: '',
                longitud_columna: null,
                cotejamiento_columna: null,
                nulo_columna: true,
                auto_incrementar: false,
                indice_tipo: null
            };
            this.mostrarModalColumna = true;
        },

        onTipoChange() {
            this.nuevaColumna.longitud_columna = null;
            this.nuevaColumna.cotejamiento_columna = null;
            this.nuevaColumna.auto_incrementar = false;
        },

        async crearColumna() {
            if (!this.columnaValida) return;

            try {
                const token = localStorage.getItem('token');
                const payload = {
                    nombre_columna: this.nuevaColumna.nombre_columna,
                    descripcion_columna: this.nuevaColumna.descripcion_columna,
                    tipo_columna: this.nuevaColumna.tipo_columna,
                    id_tabla: this.tablaColumna.id_tabla
                };

                if (this.nuevaColumna.longitud_columna) payload.longitud_columna = this.nuevaColumna.longitud_columna;
                if (this.nuevaColumna.cotejamiento_columna) payload.cotejamiento_columna = this.nuevaColumna.cotejamiento_columna;
                if (this.nuevaColumna.indice_tipo) payload.indice_tipo = this.nuevaColumna.indice_tipo;
                payload.nulo_columna = this.nuevaColumna.nulo_columna;
                payload.auto_incrementar = this.nuevaColumna.auto_incrementar;

                await axios.post(`/api/columna/crear/${this.tablaColumna.id_tabla}`, payload, {
                    headers: { 'Authorization': `Bearer ${token}` }
                });

                this.mostrarModalColumna = false;
                await this.cargarColumnas(this.tablaColumna.id_tabla);

                this.mensajeAlerta = 'Columna agregada correctamente';
                this.mostrarAlerta = true;

                this.$nextTick(() => {
                    this.renderizarRelaciones();
                });

                setTimeout(() => { this.mostrarAlerta = false; }, 3000);

            } catch (error) {
        
            }
        },

        async eliminarColumna(tabla, columna) {
            try {
                const token = localStorage.getItem('token');
                await axios.delete(`/api/columna/eliminar/${columna.id_columna}`, {
                    headers: { 'Authorization': `Bearer ${token}` }
                });

                this.cerrarMenu2('col-' + columna.id_columna);
                await this.cargarColumnas(tabla.id_tabla);

                this.$nextTick(() => {
                    this.renderizarRelaciones();
                });

            } catch (error) {

            }
        },

        abrirModalEditarColumna(tabla, columna) {
            this.tablaColumnaEditando = tabla;
            this.columnaEditando = {
                id_columna: columna.id_columna,
                nombre_columna: columna.nombre_columna || '',
                descripcion_columna: columna.descripcion_columna || '',
                tipo_columna: columna.tipo_columna || '',
                longitud_columna: columna.longitud_columna || null,
                cotejamiento_columna: columna.cotejamiento_columna || null,
                nulo_columna: columna.nulo_columna ?? true,
                auto_incrementar: columna.auto_incrementar ?? false,
                indice_tipo: columna.indice_tipo || null
            };
            this.mostrarModalEditarColumna = true;
            this.cerrarMenu2('col-' + columna.id_columna);
        },

        async editarColumna() {
            if (!this.columnaEditaValida) return;

            try {
                const token = localStorage.getItem('token');
                const payload = {
                    nombre_columna: this.columnaEditando.nombre_columna,
                    descripcion_columna: this.columnaEditando.descripcion_columna,
                    tipo_columna: this.columnaEditando.tipo_columna,
                    id_tabla: this.tablaColumnaEditando.id_tabla,
                    longitud_columna: this.columnaEditando.longitud_columna,
                    cotejamiento_columna: this.columnaEditando.cotejamiento_columna,
                    nulo_columna: this.columnaEditando.nulo_columna,
                    auto_incrementar: this.columnaEditando.auto_incrementar,
                    indice_tipo: this.columnaEditando.indice_tipo
                };

                await axios.put(`/api/columna/editar/${this.columnaEditando.id_columna}`, payload, {
                    headers: { 'Authorization': `Bearer ${token}` }
                });

                this.mostrarModalEditarColumna = false;
                this.mensajeAlerta = 'Columna modificada correctamente';
                this.mostrarAlerta = true;
                await this.cargarColumnas(this.tablaColumnaEditando.id_tabla);

                setTimeout(() => { this.mostrarAlerta = false; }, 3000);

            } catch (error) {

            }
        },

        onTipoEditarChange() {
            this.columnaEditando.longitud_columna = null;
            this.columnaEditando.cotejamiento_columna = null;
            this.columnaEditando.auto_incrementar = false;
        },


        async guardarPosicionTabla(idTabla, x, y) {
            try {
                const token = localStorage.getItem('token');
                const posX = Math.round(Number(x));
                const posY = Math.round(Number(y));
                
                await axios.put(`/api/posicion/actualizar/${idTabla}`, {
                    pos_x: posX,
                    pos_y: posY
                }, {
                    headers: { 'Authorization': `Bearer ${token}` }
                });
                
            } catch (error) {

            }
        },

        inicializarJsPlumb() {
            this.$nextTick(() => {
                const container = this.$refs.planoContent;
                if (!container) return;

                this.jsPlumbInstance = newInstance({
                    container: container,
                    connector: { type: 'Bezier', options: { curviness: 50 } },
                    paintStyle: { strokeWidth: 3, stroke: '#8b5cf6' },
                    endpoint: { type: 'Dot', options: { radius: 0 } },
                    endpointStyle: { fill: 'transparent' },
                    hoverPaintStyle: { strokeWidth: 4, stroke: '#a78bfa' },
                    anchors: ['Center', 'Center']
                });

                container.addEventListener('mousedown', (e) => {
    
                    if (this.arrastrandoRelacion) return;
                    
                    let target = e.target;
                    let connectorEl = null;

            
                    while (target && target !== container) {
                        if (target.classList && (
                            target.classList.contains('jtk-connector') || 
                            target.classList.contains('jtk-overlay') ||
                            target.tagName === 'path' ||
                            target.tagName === 'svg'
                        )) {
                            connectorEl = target;
                            break;
                        }
                        target = target.parentElement;
                    }

                    if (!connectorEl) return;

                    let idRelacion = null;
                    let checkEl = connectorEl;
                    while (checkEl && checkEl !== container) {
                        const dataId = checkEl.getAttribute('data-id-relacion');
                        if (dataId) {
                            idRelacion = dataId;
                            break;
                        }
                        checkEl = checkEl.parentElement;
                    }

                    if (!idRelacion) return;

                    e.preventDefault();
                    e.stopPropagation();

                    const rect = this.$refs.workspace.getBoundingClientRect();
                    this.popupRelacion = {
                        x: e.clientX - rect.left,
                        y: e.clientY - rect.top,
                        id_relacion: parseInt(idRelacion)
                    };
                });
            });
        },

        async cargarRelaciones() {
            try {
                const token = localStorage.getItem('token');
                const response = await axios.get(`/api/relaciones/proyecto/${this.idProyecto}`, {
                    headers: { 'Authorization': `Bearer ${token}` }
                });
                
                this.relaciones = response.data.data || [];
                
                this.$nextTick(() => {
                    this.renderizarRelaciones();
                });
            } catch (error) {
                
            }
        },

        async eliminarRelacionPopup() {
            if (!this.popupRelacion || !this.popupRelacion.id_relacion) return;

            try {
                const token = localStorage.getItem('token');
                await axios.delete(`/api/relaciones/eliminar/${this.popupRelacion.id_relacion}`, {
                    headers: { 'Authorization': `Bearer ${token}` }
                });

                this.mensajeAlerta = 'Relación eliminada correctamente';
                this.mostrarAlerta = true;
                this.popupRelacion = null;

                await this.cargarRelaciones();

                setTimeout(() => { this.mostrarAlerta = false; }, 3000);
            } catch (error) {
                this.mensajeAlerta = 'Error al eliminar relación';
                this.mostrarAlerta = true;
                this.popupRelacion = null;
                setTimeout(() => { this.mostrarAlerta = false; }, 3000);
            }
        },

        renderizarRelaciones() {
            if (!this.jsPlumbInstance) return;
            
            this.jsPlumbInstance.deleteEveryConnection();
            this.relacionesMap.clear();
            
            this.relaciones.forEach(relacion => {
                this.crearConexionVisual(relacion);
            });
        },

        crearConexionVisual(relacion) {
            if (!this.jsPlumbInstance) return;

            let sourceEl = document.getElementById(`punto-${relacion.id_columna_1}`);
            if (!sourceEl) {
                sourceEl = document.getElementById(`punto-${relacion.id_columna_1}-right`);
            }

            let targetEl = document.getElementById(`punto-${relacion.id_columna_2}-right`);
            if (!targetEl) {
                targetEl = document.getElementById(`punto-${relacion.id_columna_2}`);
            }

            if (!sourceEl || !targetEl) return;

            try {
                const connection = this.jsPlumbInstance.connect({
                    source: sourceEl,
                    target: targetEl,
                    paintStyle: { 
                        strokeWidth: 3, 
                        stroke: relacion.color_relacion || '#8b5cf6' 
                    },
                    endpointStyle: { 
                        fill: relacion.color_relacion || '#8b5cf6',
                        radius: 6
                    },
                    overlays: [
                        {
                            type: 'Arrow',
                            options: {
                                location: 1,
                                width: 12,
                                length: 12,
                                foldback: 0.8
                            }
                        }
                    ]
                });

                this.relacionesMap.set(connection.id, relacion.id_relacion);

                this.$nextTick(() => {
                    if (connection && connection.connector && connection.connector.canvas) {
                        const canvas = connection.connector.canvas;
                        canvas.setAttribute('data-id-relacion', relacion.id_relacion);
                        canvas.style.cursor = 'pointer';
                        canvas.style.zIndex = '0';
                        
                        const paths = canvas.querySelectorAll('path');
                        paths.forEach(path => {
                            path.setAttribute('data-id-relacion', relacion.id_relacion);
                            path.style.cursor = 'pointer';
                        });
                        
                        const overlays = canvas.querySelectorAll('svg');
                        overlays.forEach(overlay => {
                            overlay.setAttribute('data-id-relacion', relacion.id_relacion);
                            overlay.style.cursor = 'pointer';
                        });
                    }
                });

            } catch (error) {
                console.error('Error al crear conexión visual:', error);
            }
        },

        onPuntoMouseDown(e, tabla, columna, lado) {
            e.preventDefault();
            e.stopPropagation();
            
            this.arrastrandoRelacion = true;
            this.puntoOrigenId = lado === 'derecho'
                ? `punto-${columna.id_columna}-right`
                : `punto-${columna.id_columna}`;
            
            this.tablaSeleccionada = tabla.id_tabla;
            
            this.puntoOrigenData = {
                tabla: tabla,
                columna: columna,
                lado: lado
            };
            
            this.crearLineaTemporal(e, tabla.color_tabla || '#8b5cf6');
        },

beforeUnmount() {
    window.removeEventListener('resize', this.dibujarGrid);
    document.removeEventListener('mouseup', this.onDocumentMouseUp);
    document.removeEventListener('mousemove', this.onDocumentMouseMove);
    
    if (this.editorView) {
        this.editorView.destroy();
        this.editorView = null;
    }
    
    if (this.editorViewLaravel) {
        this.editorViewLaravel.destroy();
        this.editorViewLaravel = null;
    }
},

        crearLineaTemporal(e, color) {
            const workspace = this.$refs.workspace;
            const workspaceRect = workspace.getBoundingClientRect();
            const scale = this.zoomLevel / 100;
            
            const puntoOrigen = document.getElementById(this.puntoOrigenId);
            if (!puntoOrigen) return;
            const puntoRect = puntoOrigen.getBoundingClientRect();
            
            const startX = (puntoRect.left + puntoRect.width / 2 - workspaceRect.left - this.panX) / scale;
            const startY = (puntoRect.top + puntoRect.height / 2 - workspaceRect.top - this.panY) / scale;
            
            const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
            svg.classList.add('linea-temporal-relacion');
            svg.style.position = 'absolute';
            svg.style.top = '0';
            svg.style.left = '0';
            svg.style.width = '100%';
            svg.style.height = '100%';
            svg.style.pointerEvents = 'none';
            svg.style.zIndex = '1000';
            svg.style.overflow = 'visible';
            
            const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
            path.setAttribute('stroke', color);
            path.setAttribute('stroke-width', '3');
            path.setAttribute('fill', 'none');
            path.setAttribute('stroke-dasharray', '8,4');
            
            svg.appendChild(path);
            this.$refs.planoContent.appendChild(svg);
            
            this.lineaTemporal = { svg, path, startX, startY, color };
        },

        onDocumentMouseMove(e) {
            if (!this.arrastrandoRelacion || !this.lineaTemporal) return;
            
            const workspace = this.$refs.workspace;
            if (!workspace) return;
            const workspaceRect = workspace.getBoundingClientRect();
            const scale = this.zoomLevel / 100;
            
            const currentX = (e.clientX - workspaceRect.left - this.panX) / scale;
            const currentY = (e.clientY - workspaceRect.top - this.panY) / scale;
            
            const { startX, startY } = this.lineaTemporal;
            const dx = currentX - startX;

            const cp1X = startX + dx * 0.5;
            const cp1Y = startY;
            const cp2X = startX + dx * 0.5;
            const cp2Y = currentY;
            
            const pathData = `M ${startX} ${startY} C ${cp1X} ${cp1Y}, ${cp2X} ${cp2Y}, ${currentX} ${currentY}`;
            this.lineaTemporal.path.setAttribute('d', pathData);
        },

        onPuntoMouseUp(e, tabla, columna, lado) {
            if (!this.arrastrandoRelacion) return;
            
            e.preventDefault();
            e.stopPropagation();
            
            const puntoDestinoId = lado === 'derecho'
                ? `punto-${columna.id_columna}-right`
                : `punto-${columna.id_columna}`;
            
            if (this.puntoOrigenId === puntoDestinoId) {
                this.finalizarArrastrelRelacion();
                return;
            }

            const idColumnaOrigen = this.puntoOrigenData.columna.id_columna;
            const idColumnaDestino = columna.id_columna;
            
            this.crearRelacion(
                idColumnaOrigen,
                idColumnaDestino,
                this.lineaTemporal ? this.lineaTemporal.color : '#8b5cf6'
            );
            
            this.finalizarArrastrelRelacion();
        },

        onDocumentMouseUp(e) {
            if (this.arrastrandoRelacion) {
                this.finalizarArrastrelRelacion();
            }
        },

        finalizarArrastrelRelacion() {
            if (this.lineaTemporal && this.lineaTemporal.svg) {
                this.lineaTemporal.svg.remove();
            }
            
            this.arrastrandoRelacion = false;
            this.puntoOrigenId = null;
            this.puntoOrigenData = null;
            this.lineaTemporal = null;
        },

        async crearRelacion(idColumna1, idColumna2, color) {
            try {
                const token = localStorage.getItem('token');
                await axios.post('/api/relaciones/crear', {
                    id_columna_1: idColumna1,
                    id_columna_2: idColumna2,
                    color_relacion: color
                }, {
                    headers: { 'Authorization': `Bearer ${token}` }
                });
                
                this.mensajeAlerta = 'Relación creada correctamente';
                this.mostrarAlerta = true;
                
                await this.cargarRelaciones();
                
                setTimeout(() => { this.mostrarAlerta = false; }, 3000);
            } catch (error) {
                this.mensajeAlerta = 'Error al crear relación';
                this.mostrarAlerta = true;
                setTimeout(() => { this.mostrarAlerta = false; }, 3000);
            }
        },

        actualizarPosicionesJsPlumb() {
            if (this.jsPlumbInstance) {
                this.jsPlumbInstance.repaintEverything();
            }
        },


        onTableMouseDown(e, tabla) {
            if (this.arrastrandoRelacion) return;
            if (e.button !== 0) return;
            
            this.draggingTable = tabla.id_tabla;
            
            const scale = this.zoomLevel / 100;
            const rect = e.currentTarget.getBoundingClientRect();
            
            this.dragOffsetX = (e.clientX - rect.left) / scale;
            this.dragOffsetY = (e.clientY - rect.top) / scale;
            
            this.tablaSeleccionada = tabla.id_tabla;
            
            e.preventDefault();
        },

        onMouseMoveGlobal(e) {
            if (this.arrastrandoRelacion) return;
            
            if (this.isPanning) {
                this.panX = this.startPanX + (e.clientX - this.startMouseX);
                this.panY = this.startPanY + (e.clientY - this.startMouseY);
                this.actualizarPosicionesJsPlumb();
                return;
            }
            
            if (!this.draggingTable) return;
            
            const tabla = this.tablas.find(t => t.id_tabla === this.draggingTable);
            if (!tabla) return;
            
            const scale = this.zoomLevel / 100;
            const workspaceRect = this.$refs.workspace.getBoundingClientRect();
            
            const newX = (e.clientX - workspaceRect.left - this.panX) / scale - this.dragOffsetX;
            const newY = (e.clientY - workspaceRect.top - this.panY) / scale - this.dragOffsetY;
            
            if (!tabla.posicion) {
                tabla.posicion = { pos_x: newX, pos_y: newY };
            } else {
                tabla.posicion.pos_x = newX;
                tabla.posicion.pos_y = newY;
            }
            
            this.actualizarPosicionesJsPlumb();
        },

        onMouseUpGlobal(e) {
            if (this.arrastrandoRelacion) return;
            
            if (this.isPanning && e.button === 2) {
                this.isPanning = false;
                return;
            }
            
            if (this.draggingTable) {
                const tabla = this.tablas.find(t => t.id_tabla === this.draggingTable);
                if (tabla && tabla.posicion) {
                    this.guardarPosicionTabla(
                        this.draggingTable,
                        tabla.posicion.pos_x,
                        tabla.posicion.pos_y
                    );
                }
                this.draggingTable = null;
            }
        },

        calcularAlturaTabla(columnas) {
            const headerHeight = 42;
            const rowHeight = 34;
            return headerHeight + (columnas.length * rowHeight);
        },

        salirDelProyecto() {
            this.$router.push('/leonardoproyectos');
        },

        zoomIn() {
            if (this.zoomLevel < 200) this.zoomLevel += 10;
        },
        zoomOut() {
            if (this.zoomLevel > 25) this.zoomLevel -= 10;
        },
        resetZoom() {
            this.zoomLevel = 100;
            this.panX = 0;
            this.panY = 0;
        },

        onWheel(e) {
            const rect = this.$refs.workspace.getBoundingClientRect();
            const mouseX = e.clientX - rect.left;
            const mouseY = e.clientY - rect.top;

            const oldZoom = this.zoomLevel / 100;
            const delta = e.deltaY < 0 ? 1.1 : 0.9;
            let newZoomPercent = Math.round(this.zoomLevel * delta);
            newZoomPercent = Math.max(25, Math.min(200, newZoomPercent));
            const newZoom = newZoomPercent / 100;

            this.panX = mouseX - (mouseX - this.panX) * (newZoom / oldZoom);
            this.panY = mouseY - (mouseY - this.panY) * (newZoom / oldZoom);
            this.zoomLevel = newZoomPercent;
        },

        onMouseDown(e) {
            if (e.button === 2) {
                this.isPanning = true;
                this.startPanX = this.panX;
                this.startPanY = this.panY;
                this.startMouseX = e.clientX;
                this.startMouseY = e.clientY;
            }
        },

        dibujarGrid() {
            const canvas = this.$refs.gridCanvas;
            if (!canvas) return;

            const ws = this.$refs.workspace;
            canvas.width = ws.clientWidth;
            canvas.height = ws.clientHeight;

            const ctx = canvas.getContext('2d');
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            const zoom = this.zoomLevel / 100;

            const smallBase = 40;
            const bigBase = 200;

            const small = smallBase * zoom;
            const big = bigBase * zoom;

            const offsetX = ((this.panX % small) + small) % small;
            const offsetY = ((this.panY % small) + small) % small;

            ctx.strokeStyle = 'rgba(139, 0, 255, 0.12)';
            ctx.lineWidth = 1;
            ctx.beginPath();
            for (let x = offsetX; x < canvas.width; x += small) {
                ctx.moveTo(x, 0);
                ctx.lineTo(x, canvas.height);
            }
            for (let y = offsetY; y < canvas.height; y += small) {
                ctx.moveTo(0, y);
                ctx.lineTo(canvas.width, y);
            }
            ctx.stroke();

            const bigOffsetX = ((this.panX % big) + big) % big;
            const bigOffsetY = ((this.panY % big) + big) % big;

            for (let x = bigOffsetX; x < canvas.width; x += big) {
                const grad = ctx.createLinearGradient(0, 0, 0, canvas.height);
                grad.addColorStop(0, 'rgba(139, 0, 255, 0.45)');
                grad.addColorStop(0.5, 'rgba(0, 102, 255, 0.45)');
                grad.addColorStop(1, 'rgba(139, 0, 255, 0.45)');
                ctx.strokeStyle = grad;
                ctx.lineWidth = 1.5;
                ctx.beginPath();
                ctx.moveTo(x, 0);
                ctx.lineTo(x, canvas.height);
                ctx.stroke();
            }

            for (let y = bigOffsetY; y < canvas.height; y += big) {
                const grad = ctx.createLinearGradient(0, 0, canvas.width, 0);
                grad.addColorStop(0, 'rgba(0, 102, 255, 0.45)');
                grad.addColorStop(0.5, 'rgba(255, 0, 85, 0.45)');
                grad.addColorStop(1, 'rgba(0, 102, 255, 0.45)');
                ctx.strokeStyle = grad;
                ctx.lineWidth = 1.5;
                ctx.beginPath();
                ctx.moveTo(0, y);
                ctx.lineTo(canvas.width, y);
                ctx.stroke();
            }

            ctx.fillStyle = 'rgba(255, 0, 85, 0.25)';
            for (let x = bigOffsetX; x < canvas.width; x += big) {
                for (let y = bigOffsetY; y < canvas.height; y += big) {
                    ctx.beginPath();
                    ctx.arc(x, y, 2.5 * zoom, 0, Math.PI * 2);
                    ctx.fill();
                }
            }
        }
    }
};
</script>

<style scoped>
.leonardo-data {
    min-height: 100vh;
    background: #0a0010;
    position: relative;
    overflow: hidden;
}

/* ─── Navbar ─────────────────────────────────────────── */
.navbar-data {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    background: rgba(0, 0, 0, 0.95);
    backdrop-filter: blur(10px);
    border-bottom: 2px solid;
    border-image: linear-gradient(90deg, #8b00ff, #0066ff, #ff0055) 1;
    z-index: 1000;
    box-shadow: 0 4px 20px rgba(139, 0, 255, 0.3);
}

.navbar-content {
    max-width: 100%;
    padding: 0 40px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    height: 70px;
    gap: 30px;
}

.proyecto-info {
    display: flex;
    align-items: center;
    gap: 15px;
}

.icono-proyecto {
    width: 45px;
    height: 45px;
    border-radius: 10px;
    background: linear-gradient(135deg, #8b00ff, #0066ff);
    display: flex;
    align-items: center;
    justify-content: center;
}

.icono-proyecto svg {
    color: #ffffff;
}

.proyecto-nombre h1 {
    font-size: 1.5em;
    font-weight: 700;
    color: #ffffff;
    margin: 0;
    line-height: 1.2;
}

.navbar-actions {
    display: flex;
    align-items: center;
    gap: 15px;
}

.zoom-controls {
    display: flex;
    align-items: center;
    gap: 8px;
    background: rgba(139, 0, 255, 0.1);
    padding: 8px 12px;
    border-radius: 10px;
    border: 1px solid rgba(139, 0, 255, 0.3);
}

.btn-zoom {
    background: none;
    border: none;
    color: #8b00ff;
    cursor: pointer;
    padding: 5px;
    border-radius: 6px;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-zoom:hover {
    background: rgba(139, 0, 255, 0.2);
    transform: scale(1.1);
}

.zoom-level {
    color: #ffffff;
    font-weight: 600;
    font-size: 0.9em;
    min-width: 50px;
    text-align: center;
}

.btn-crear-tabla {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 12px 20px;
    background: linear-gradient(135deg, #8b00ff, #0066ff);
    color: #ffffff;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(139, 0, 255, 0.4);
}

.btn-crear-tabla:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.btn-crear-tabla:not(:disabled):hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(139, 0, 255, 0.6);
}

.btn-salir {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 12px 20px;
    background: rgba(255, 0, 85, 0.1);
    color: #ff0055;
    border: 2px solid rgba(255, 0, 85, 0.3);
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-salir:hover {
    background: rgba(255, 0, 85, 0.2);
    border-color: #ff0055;
    transform: translateY(-2px);
}

.workspace {
    position: fixed;
    top: 70px;
    left: 0;
    right: 0;
    bottom: 0;
    overflow: hidden;
    cursor: default;
    user-select: none;
}

.workspace.panning {
    cursor: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"><g fill="%23ffffff" stroke="%23000000" stroke-width="1.2" stroke-linejoin="round"><path d="M10 28h12l2-12H8z"/><path d="M8 16V6a2 2 0 0 1 4 0v6"/><path d="M12 15V4a2 2 0 0 1 4 0v7"/><path d="M16 16V6a2 2 0 0 1 4 0v6"/><path d="M20 17V9a2 2 0 0 1 4 0v8"/></g></svg>') 10 2, grab;
}

/* Canvas del grid — capa de fondo */
.grid-canvas {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 0;
}

/* Contenido del plano — capa superior al grid */
.plano-content {
    position: absolute;
    top: 0;
    left: 0;
    width: 50000px;  /* Mismo tamaño que el paper */
    height: 50000px; /* Mismo tamaño que el paper */
    z-index: 1;
    transform-origin: 0 0;
}

/* ─── Responsive ─────────────────────────────────────── */
@media (max-width: 1024px) {
    .navbar-content {
        padding: 0 20px;
    }

    .proyecto-nombre h1 {
        font-size: 1.2em;
    }

    .btn-crear-tabla span,
    .btn-salir span {
        display: none;
    }
}

/* Modal */
.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.7);
    backdrop-filter: blur(4px);
    z-index: 2000;
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-box {
    background: #12001f;
    border: 1.5px solid rgba(139, 0, 255, 0.4);
    border-radius: 16px;
    padding: 36px 32px 28px;
    width: 100%;
    max-width: 380px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.6), 0 0 40px rgba(139, 0, 255, 0.15);
}

.modal-titulo {
    color: #fff;
    font-size: 1.3em;
    font-weight: 700;
    margin: 0 0 22px;
}

.modal-input {
    width: 100%;
    padding: 12px 16px;
    background: rgba(139, 0, 255, 0.08);
    border: 1.5px solid rgba(139, 0, 255, 0.3);
    border-radius: 10px;
    color: #fff;
    font-size: 0.95em;
    outline: none;
    box-sizing: border-box;
    transition: border-color 0.3s;
}

.modal-input::placeholder {
    color: rgba(255, 255, 255, 0.35);
}

.modal-input:focus {
    border-color: #8b00ff;
}

.modal-acciones {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 24px;
}

.btn-modal-cancelar {
    padding: 10px 20px;
    background: transparent;
    border: 1.5px solid rgba(255, 255, 255, 0.15);
    border-radius: 8px;
    color: rgba(255, 255, 255, 0.6);
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-modal-cancelar:hover {
    border-color: rgba(255, 255, 255, 0.4);
    color: #fff;
}

.btn-modal-agregar {
    padding: 10px 22px;
    background: linear-gradient(135deg, #8b00ff, #0066ff);
    border: none;
    border-radius: 8px;
    color: #fff;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    box-shadow: 0 4px 14px rgba(139, 0, 255, 0.4);
}

.btn-modal-agregar:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 18px rgba(139, 0, 255, 0.5);
}

/* Alerta toast */
.alerta-toast {
    position: fixed;
    bottom: 32px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 3000;
    display: flex;
    align-items: center;
    gap: 12px;
    background: rgba(15, 15, 25, 0.92);
    border: 1.5px solid rgba(74, 222, 128, 0.4);
    border-radius: 12px;
    padding: 14px 24px;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.5);
    animation: toastEntrar 0.35s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
}

.alerta-toast span {
    color: #fff;
    font-weight: 600;
    font-size: 0.95em;
    white-space: nowrap;
}

@keyframes toastEntrar {
    from {
        opacity: 0;
        transform: translateX(-50%) translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateX(-50%) translateY(0);
    }
}

.contador-caracteres {
    color: rgba(255, 255, 255, 0.35);
    font-size: 0.75em;
    text-align: right;
    margin-top: 6px;
    transition: color 0.3s;
}

.contador-caracteres.contador-limite {
    color: #ff0055;
}

.modal-input.input-limite {
    border-color: #ff0055;
}

/* Sidebar */
.sidebar-tablas {
    position: fixed;
    top: 70px;
    left: 0;
    width: 260px;
    height: calc(100vh - 70px);
    background: rgba(10, 0, 18, 0.95);
    border-right: 1.5px solid rgba(139, 0, 255, 0.25);
    z-index: 900;
    display: flex;
    flex-direction: column;
    backdrop-filter: blur(10px);
}

.sidebar-header {
    padding: 20px 18px 16px;
    border-bottom: 1px solid rgba(139, 0, 255, 0.15);
    flex-shrink: 0;
}

.sidebar-titulo {
    color: #fff;
    font-size: 1.1em;
    font-weight: 700;
    margin: 0 0 4px;
}

.sidebar-proyecto-nombre {
    color: rgba(139, 0, 255, 0.7);
    font-size: 0.75em;
    font-weight: 500;
}

.sidebar-lista {
    flex: 1;
    overflow-y: auto;
    padding: 10px 10px;
}

/* Scrollbar roja */
.sidebar-lista::-webkit-scrollbar {
    width: 6px;
}

.sidebar-lista::-webkit-scrollbar-track {
    background: rgba(255, 0, 85, 0.08);
    border-radius: 3px;
}

.sidebar-lista::-webkit-scrollbar-thumb {
    background: #ff0055;
    border-radius: 3px;
}

.sidebar-lista::-webkit-scrollbar-thumb:hover {
    background: #ff3377;
}

/* Tabla item */
.tabla-item {
    position: relative;
    margin-bottom: 4px;
}

.tabla-cabecera {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 6px 4px;
    border-radius: 8px;
    transition: background 0.2s;
}

.tabla-cabecera:hover {
    background: rgba(139, 0, 255, 0.07);
}

.btn-toggle {
    background: none;
    border: none;
    cursor: pointer;
    padding: 2px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.icono-chevron {
    color: rgba(255, 255, 255, 0.45);
    transition: transform 0.2s ease, color 0.2s;
}

.tabla-cabecera:hover .icono-chevron {
    color: #8b00ff;
}

.tabla-nombre-wrap {
    flex: 1;
    padding: 6px 10px;
    border-radius: 6px;
    min-width: 0;
    max-width: 140px; /* ← AGREGAR */
    overflow-x: auto; /* ← AGREGAR */
    scrollbar-width: thin; /* ← AGREGAR */
    scrollbar-color: rgba(139, 0, 255, 0.4) transparent; /* ← AGREGAR */
}

/* AGREGAR ESTO COMPLETO: */
.tabla-nombre-wrap::-webkit-scrollbar {
    height: 3px;
}

.tabla-nombre-wrap::-webkit-scrollbar-track {
    background: transparent;
}

.tabla-nombre-wrap::-webkit-scrollbar-thumb {
    background: rgba(139, 0, 255, 0.4);
    border-radius: 2px;
}

.tabla-nombre {
    color: #fff;
    font-size: 0.85em;
    font-weight: 600;
    white-space: nowrap;
    /* QUITAR overflow y text-overflow */
    display: block;
}

.btn-menu-tabla {
    background: none;
    border: none;
    color: rgba(255, 255, 255, 0.3);
    cursor: pointer;
    padding: 4px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: color 0.2s, background 0.2s;
    flex-shrink: 0;
}

.btn-menu-tabla:hover {
    color: #fff;
    background: rgba(139, 0, 255, 0.15);
}

/* Menú 3 puntitos */
.menu-tabla {
    position: fixed; /* ← CAMBIAR de absolute a fixed */
    /* QUITAR right y top */
    background: #1a0030;
    border: 1.5px solid rgba(139, 0, 255, 0.35);
    border-radius: 10px;
    padding: 6px;
    z-index: 950;
    min-width: 160px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
}

.menu-tabla-opcion {
    display: flex;
    align-items: center;
    gap: 10px;
    width: 100%;
    padding: 9px 12px;
    background: none;
    border: none;
    color: rgba(255, 255, 255, 0.75);
    font-size: 0.82em;
    font-weight: 600;
    cursor: pointer;
    border-radius: 6px;
    transition: background 0.2s, color 0.2s;
    text-align: left;
}

.menu-tabla-opcion:hover {
    background: rgba(139, 0, 255, 0.12);
    color: #fff;
}

.menu-tabla-eliminar:hover {
    background: rgba(255, 0, 85, 0.12);
    color: #ff0055;
}

/* Contenido abierto */
.tabla-contenido {
    display: flex;
    flex-direction: column;
    gap: 4px;
    padding: 6px 6px 6px 30px;
}

.btn-tabla-accion {
    display: flex;
    align-items: center;
    gap: 7px;
    padding: 7px 10px;
    background: rgba(139, 0, 255, 0.08);
    border: 1px solid rgba(139, 0, 255, 0.2);
    border-radius: 7px;
    color: rgba(255, 255, 255, 0.6);
    font-size: 0.78em;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    text-align: left;
}

.btn-tabla-accion:hover {
    background: rgba(139, 0, 255, 0.18);
    border-color: #8b00ff;
    color: #fff;
}

/* Modal Columna */
.modal-columna-overlay {
    align-items: flex-start;
    justify-content: center;
    padding-top: 60px;
}

.modal-columna {
    max-width: 900px;
    width: 95%;
    max-height: 85vh;
    overflow-y: auto;
    padding: 0;
}

.modal-columna::-webkit-scrollbar { width: 5px; }
.modal-columna::-webkit-scrollbar-track { background: transparent; }
.modal-columna::-webkit-scrollbar-thumb { background: rgba(139,0,255,0.3); border-radius: 3px; }

.modal-columna-header {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 24px 28px 18px;
    border-bottom: 1px solid rgba(139, 0, 255, 0.15);
    flex-wrap: wrap;
}

.modal-columna-header .modal-titulo {
    margin: 0;
    flex-shrink: 0;
}

.modal-columna-tabla-nombre {
    flex: 1;
    color: rgba(139, 0, 255, 0.7);
    font-size: 0.78em;
    font-weight: 500;
}

.btn-modal-cerrar {
    background: none;
    border: none;
    color: rgba(255,255,255,0.35);
    cursor: pointer;
    margin-left: auto;
    padding: 4px;
    border-radius: 6px;
    transition: color 0.2s, background 0.2s;
}

.btn-modal-cerrar:hover {
    color: #fff;
    background: rgba(255,255,255,0.08);
}

.modal-columna-body {
    display: flex;
    flex-wrap: wrap;
    gap: 14px;
    padding: 22px 28px;
}

.campo-columna {
    display: flex;
    flex-direction: column;
    gap: 6px;
    min-width: 130px;
}

.campo-obligatorio { flex: 1 1 160px; }
.campo-opcional { flex: 0 1 140px; }
.campo-toggle { flex: 0 0 auto; min-width: 90px; }

.campo-columna label {
    color: rgba(255,255,255,0.6);
    font-size: 0.72em;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.campo-requerido {
    color: #ff0055;
}

.campo-columna input[type="text"],
.campo-columna input[type="number"],
.campo-columna select {
    width: 100%;
    padding: 9px 12px;
    background: rgba(139, 0, 255, 0.08);
    border: 1.5px solid rgba(139, 0, 255, 0.25);
    border-radius: 8px;
    color: #fff;
    font-size: 0.82em;
    outline: none;
    box-sizing: border-box;
    transition: border-color 0.3s;
    appearance: none;
    -webkit-appearance: none;
}

.campo-columna select {
    background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%238b00ff' stroke-width='2.5'><polyline points='6 9 12 15 18 9'></polyline></svg>");
    background-repeat: no-repeat;
    background-position: right 10px center;
    padding-right: 32px;
    cursor: pointer;
}

.campo-columna select option {
    background: #1a0030;
    color: #fff;
}

.campo-columna select optgroup {
    color: #8b00ff;
    font-weight: 700;
}

.campo-columna input:focus,
.campo-columna select:focus {
    border-color: #8b00ff;
}

.campo-columna input.input-limite {
    border-color: #ff0055;
}

.campo-columna .contador {
    color: rgba(255,255,255,0.3);
    font-size: 0.68em;
    text-align: right;
}

.campo-columna .contador.contador-limite {
    color: #ff0055;
}

/* Toggle */
.toggle-wrap {
    display: flex;
    align-items: center;
}

.toggle-input {
    display: none;
}

.toggle-slider {
    width: 42px;
    height: 22px;
    background: rgba(255,255,255,0.15);
    border-radius: 11px;
    cursor: pointer;
    position: relative;
    transition: background 0.3s;
}

.toggle-slider::after {
    content: '';
    position: absolute;
    top: 3px;
    left: 3px;
    width: 16px;
    height: 16px;
    background: #fff;
    border-radius: 50%;
    transition: transform 0.3s;
}

.toggle-input:checked + .toggle-slider {
    background: #8b00ff;
}

.toggle-input:checked + .toggle-slider::after {
    transform: translateX(20px);
}

/* Footer modal columna */
.modal-columna-footer {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    padding: 16px 28px 22px;
    border-top: 1px solid rgba(139, 0, 255, 0.15);
}

/* Botones acciones tabla */
.tabla-botones-acciones {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

/* Lista de columnas */
.columnas-lista {
    margin-top: 8px;
    border-top: 1px solid rgba(139, 0, 255, 0.12);
    padding-top: 6px;
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.columna-item {
    position: relative;
}

.columna-row {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 5px 6px;
    border-radius: 6px;
    transition: background 0.2s;
}

.columna-row:hover {
    background: rgba(139, 0, 255, 0.07);
}

/* Nombre con scroll si es largo */
.columna-nombre-wrap {
    flex: 1;
    min-width: 0;
    max-width: 100px;
    overflow-x: auto;
    white-space: nowrap;
    scrollbar-width: thin;
    scrollbar-color: rgba(139, 0, 255, 0.4) transparent;
}

.columna-nombre-wrap::-webkit-scrollbar {
    height: 3px;
}

.columna-nombre-wrap::-webkit-scrollbar-track {
    background: transparent;
}

.columna-nombre-wrap::-webkit-scrollbar-thumb {
    background: rgba(139, 0, 255, 0.4);
    border-radius: 2px;
}

.columna-nombre {
    color: rgba(255, 255, 255, 0.85);
    font-size: 0.78em;
    font-weight: 500;
}

.columna-tipo {
    color: #8b00ff;
    font-size: 0.7em;
    font-weight: 700;
    text-transform: uppercase;
    flex-shrink: 0;
}

.columna-longitud {
    color: rgba(255, 255, 255, 0.3);
    font-size: 0.68em;
    flex-shrink: 0;
}

/* Botón 3 puntos columna */
.btn-menu-columna {
    background: none;
    border: none;
    color: rgba(255, 255, 255, 0.25);
    cursor: pointer;
    padding: 3px;
    border-radius: 5px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: color 0.2s, background 0.2s;
    flex-shrink: 0;
    margin-left: auto;
}

.btn-menu-columna:hover {
    color: #fff;
    background: rgba(139, 0, 255, 0.15);
}

/* Menú columna */
.menu-columna {
    position: absolute;
    right: 6px;
    top: calc(100% + 2px);
    background: #1a0030;
    border: 1.5px solid rgba(139, 0, 255, 0.35);
    border-radius: 10px;
    padding: 5px;
    z-index: 960;
    min-width: 155px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
}

.menu-columna-opcion {
    display: flex;
    align-items: center;
    gap: 9px;
    width: 100%;
    padding: 8px 11px;
    background: none;
    border: none;
    color: rgba(255, 255, 255, 0.7);
    font-size: 0.78em;
    font-weight: 600;
    cursor: pointer;
    border-radius: 6px;
    transition: background 0.2s, color 0.2s;
    text-align: left;
}

.menu-columna-opcion:hover {
    background: rgba(139, 0, 255, 0.12);
    color: #fff;
}

.menu-columna-eliminar:hover {
    background: rgba(255, 0, 85, 0.12);
    color: #ff0055;
}

/* Modal Info */
.modal-info {
    max-width: 680px;
    width: 92%;
    padding: 0;
}

.modal-info-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 22px 26px 16px;
    border-bottom: 1px solid rgba(139, 0, 255, 0.15);
}

.modal-info-header .modal-titulo {
    margin: 0;
}

.modal-info-body {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    padding: 22px 26px 26px;
}

.info-campo {
    display: flex;
    flex-direction: column;
    gap: 5px;
    background: rgba(139, 0, 255, 0.06);
    border: 1px solid rgba(139, 0, 255, 0.15);
    border-radius: 10px;
    padding: 12px 16px;
    flex: 1 1 160px;
    min-width: 140px;
}

.info-label {
    color: rgba(255, 255, 255, 0.4);
    font-size: 0.68em;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.8px;
}

.info-valor {
    color: #fff;
    font-size: 0.85em;
    font-weight: 500;
    word-break: break-word;
}

.info-valor-tabla {
    color: rgba(139, 0, 255, 0.85);
    font-weight: 600;
}

.info-valor-tipo {
    color: #0066ff;
    font-weight: 700;
    text-transform: uppercase;
}

.info-valor-cotejamiento {
    color: rgba(255, 255, 255, 0.7);
    font-size: 0.78em;
}

.info-valor-indice {
    color: #ff0055;
    font-weight: 600;
    text-transform: uppercase;
}

.info-valor-fecha {
    color: rgba(255, 255, 255, 0.5);
    font-size: 0.78em;
}

/* Badges Sí/No */
.info-badge {
    display: inline-block;
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 0.82em;
    font-weight: 700;
}

.badge-si {
    background: rgba(74, 222, 128, 0.15);
    color: #4ade80;
    border: 1px solid rgba(74, 222, 128, 0.3);
}

.badge-no {
    background: rgba(255, 0, 85, 0.15);
    color: #ff0055;
    border: 1px solid rgba(255, 0, 85, 0.3);
}

/* Tablas en el canvas */
.plano-content {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
}

.tabla-canvas {
    position: absolute;
    background: #1a0a2e;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
    pointer-events: auto;
    cursor: move;
    user-select: none;
    transition: box-shadow 0.2s;
    overflow: visible;
    z-index: 1;
}

.tabla-canvas:hover {
    box-shadow: 0 6px 20px rgba(139, 0, 255, 0.3);
}

.tabla-canvas.tabla-seleccionada {
    box-shadow: 0 0 0 2px rgba(139, 0, 255, 0.6);
}

.tabla-canvas-header {
    padding: 12px 16px;
    border-radius: 8px 8px 0 0;
    color: white;
    font-weight: bold;
    font-size: 14px;
    text-align: center;
    font-family: 'Inter', system-ui, sans-serif;
}

.tabla-canvas-body {
    background: #1a0a2e;
    border-radius: 0 0 8px 8px;
    overflow: visible;
}

.tabla-canvas-row {
    padding: 8px 20px;
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 11px;
    color: #e0e0e0;
    font-family: 'Consolas', 'Monaco', monospace;
    border-bottom: 1px solid rgba(139, 0, 255, 0.1);
    position: relative;
}


.tabla-canvas-row:last-child {
    border-bottom: none;
}

.tabla-canvas-row.row-par {
    background: rgba(139, 0, 255, 0.08);
}

.row-icono {
    font-size: 14px;
    flex-shrink: 0;
}

.row-nombre {
    flex: 1;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.row-tipo {
    color: #a78bfa;
    font-weight: 500;
}

.row-longitud {
    color: #94a3b8;
}

/* Puntos de conexión mejorados */
.punto-conexion {
    position: absolute;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid white;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.2s, transform 0.2s;
    z-index: 10;
    cursor: grab;
    /* top: 50% va en cada subclase (izquierdo/derecho) */
}

.punto-izquierdo {
    left: -7px;
    top: 50%;
    transform: translateY(-50%);
    z-index: 20;
}

.punto-derecho {
    right: -7px;
    top: 50%;
    transform: translateY(-50%);
    z-index: 20;
}

/*  Cuando está visible: se activa opacity y pointer-events */
.punto-visible {
    opacity: 1;
    pointer-events: auto;
}

/*  Hover: se agranda y brilla */
.punto-hover {
    transform: translateY(-50%) scale(1.4) !important;
    box-shadow: 0 0 10px currentColor;
    opacity: 1 !important;
}

/*  Mientras arrastra desde este punto */
.punto-arrastrando {
    cursor: grabbing;
    transform: translateY(-50%) scale(1.5) !important;
    box-shadow: 0 0 15px currentColor;
    animation: pulse-grab 0.6s infinite;
}

@keyframes pulse-grab {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}



/* Línea temporal mientras arrastra */
.linea-temporal-relacion {
    pointer-events: none !important;
}

/* jsPlumb */
.jtk-overlay {
    z-index: 5;
}

.jtk-connector {
    z-index: 4;
    cursor: pointer;
    pointer-events: stroke;
}

.jtk-connector:hover {
    filter: brightness(1.4);
}

.jtk-endpoint {
    z-index: 6;
}

/* Popup eliminar relación */
.popup-relacion {
    position: fixed;
    z-index: 2000;
    background: #1a0030;
    border: 1.5px solid rgba(139, 0, 255, 0.4);
    border-radius: 10px;
    padding: 14px 18px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.6);
    display: flex;
    flex-direction: column;
    gap: 12px;
    min-width: 200px;
    animation: popupEntrar 0.2s ease forwards;
}

@keyframes popupEntrar {
    from {
        opacity: 0;
        transform: scale(0.9);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

.popup-relacion-texto {
    color: rgba(255, 255, 255, 0.8);
    font-size: 0.82em;
    font-weight: 600;
    text-align: center;
}

.popup-relacion-botones {
    display: flex;
    gap: 8px;
    justify-content: center;
}

.btn-popup-cancelar {
    padding: 6px 14px;
    background: transparent;
    border: 1.5px solid rgba(255, 255, 255, 0.15);
    border-radius: 6px;
    color: rgba(255, 255, 255, 0.6);
    font-size: 0.78em;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-popup-cancelar:hover {
    border-color: rgba(255, 255, 255, 0.4);
    color: #fff;
}

.btn-popup-eliminar {
    padding: 6px 14px;
    background: rgba(255, 0, 85, 0.15);
    border: 1.5px solid rgba(255, 0, 85, 0.4);
    border-radius: 6px;
    color: #ff0055;
    font-size: 0.78em;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-popup-eliminar:hover {
    background: rgba(255, 0, 85, 0.3);
    border-color: #ff0055;
}

.lista-columnas-index {
    max-height: 400px;
    overflow-y: auto;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 12px;
}

.columna-checkbox-item {
    padding: 10px;
    border-bottom: 1px solid #f3f4f6;
}

.columna-checkbox-item:last-child {
    border-bottom: none;
}

.checkbox-label {
    display: flex;
    align-items: center;
    gap: 12px;
    cursor: pointer;
}

.checkbox-label input[type="checkbox"] {
    width: 18px;
    height: 18px;
    cursor: pointer;
}

.checkbox-texto {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.checkbox-texto strong {
    color: #1f2937;
    font-size: 14px;
}

.checkbox-texto small {
    color: #6b7280;
    font-size: 12px;
}

.indices-seccion {
    margin-top: 16px;
    padding-top: 16px;
    border-top: 1px solid #e5e7eb;
}

.indices-titulo {
    font-size: 13px;
    font-weight: 600;
    color: #6b7280;
    margin-bottom: 8px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.indices-lista {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.indice-item {
    position: relative;
    display: flex;
    align-items: center;
    gap: 8px;
}

.indice-textarea {
    flex: 1;
    padding: 8px 12px;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    font-size: 13px;
    color: #374151;
    background-color: #f9fafb;
    resize: none;
    min-height: 36px;
    cursor: default;
}

.btn-menu-indice {
    background: none;
    border: none;
    padding: 4px;
    cursor: pointer;
    color: #9ca3af;
    transition: all 0.2s;
}

.btn-menu-indice:hover {
    color: #6b7280;
}

.menu-indice {
    position: absolute;
    right: 30px;
    top: 100%;
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    min-width: 150px;
    z-index: 1000;
    overflow: hidden;
}

.menu-indice-opcion {
    width: 100%;
    padding: 10px 14px;
    border: none;
    background: white;
    text-align: left;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: #374151;
    transition: all 0.2s;
}

.menu-indice-opcion:hover {
    background-color: #f3f4f6;
}

.menu-indice-eliminar {
    color: #dc2626;
}

.menu-indice-eliminar:hover {
    background-color: #fee2e2;
}

/* Textarea de índice con scroll */
.indice-textarea {
    flex: 1;
    padding: 8px 12px;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    font-size: 13px;
    color: #374151;
    background-color: #f9fafb;
    resize: none;
    min-height: 36px;
    max-height: 80px;
    overflow-y: auto;
    cursor: default;
    line-height: 1.4;
}

/* Scroll personalizado para textarea */
.indice-textarea::-webkit-scrollbar {
    width: 6px;
}

.indice-textarea::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

.indice-textarea::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 3px;
}

.indice-textarea::-webkit-scrollbar-thumb:hover {
    background: #555;
}

/* Lista horizontal de columnas con chips */
.lista-columnas-index-horizontal {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    padding: 16px;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    max-height: 400px;
    overflow-y: auto;
}

/* Chip de columna */
.columna-chip {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    border: 2px solid #e5e7eb;
    border-radius: 20px;
    background-color: #ffffff;
    cursor: pointer;
    transition: all 0.2s;
    user-select: none;
}

.columna-chip:hover {
    border-color: #8b5cf6;
    background-color: #f5f3ff;
}

.columna-chip-seleccionada {
    border-color: #8b5cf6;
    background-color: #8b5cf6;
    color: white;
}

.columna-chip-seleccionada .columna-chip-nombre {
    color: white;
}

.columna-chip-checkbox {
    width: 16px;
    height: 16px;
    cursor: pointer;
}

.columna-chip-nombre {
    font-size: 14px;
    font-weight: 500;
    color: #374151;
}

.columna-chip-seleccionada .columna-chip-nombre {
    color: white;
}

/* Índice item (un solo textarea) */
.indice-item {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 8px;
}

/* Texto de ayuda para eliminar */
.texto-ayuda-eliminar {
    margin-top: 12px;
    padding: 10px;
    background-color: #fef3c7;
    border-left: 3px solid #f59e0b;
    border-radius: 4px;
    font-size: 13px;
    color: #92400e;
}

/* Botón eliminar */
.btn-eliminar {
    background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%) !important;
}

.btn-eliminar:hover {
    background: linear-gradient(135deg, #b91c1c 0%, #7f1d1d 100%) !important;
}

/* Botón ubicar tabla */
.btn-ubicar-tabla {
    background: none;
    border: none;
    padding: 4px;
    cursor: pointer;
    color: #8b5cf6;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 4px;
}

.btn-ubicar-tabla:hover {
    background-color: #f3e8ff;
    color: #7c3aed;
    transform: scale(1.1);
}

.btn-ubicar-tabla:active {
    transform: scale(0.95);
}

/* Animación de resaltado para tabla */
.tabla-canvas.tabla-resaltada {
    animation: pulso-tabla 2s ease-in-out;
    z-index: 1000 !important;
}

@keyframes pulso-tabla {
    0%, 100% {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        transform: scale(1);
    }
    25% {
        box-shadow: 0 0 0 8px rgba(139, 92, 246, 0.3),
                    0 0 0 16px rgba(139, 92, 246, 0.2),
                    0 0 0 24px rgba(139, 92, 246, 0.1);
        transform: scale(1.05);
    }
    50% {
        box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.4),
                    0 0 0 12px rgba(139, 92, 246, 0.2);
        transform: scale(1.02);
    }
    75% {
        box-shadow: 0 0 0 8px rgba(139, 92, 246, 0.3),
                    0 0 0 16px rgba(139, 92, 246, 0.2);
        transform: scale(1.05);
    }
}

/* Ajustar espaciado de la cabecera */
.tabla-cabecera {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 8px 10px;
    border-bottom: 1px solid #e5e7eb;
}

.tabla-nombre-wrap {
    flex: 1;
    padding: 6px 10px;
    border-radius: 6px;
    min-width: 0;
}

.tabla-nombre {
    font-weight: 600;
    font-size: 13px;
    color: white;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    display: block;
}

/* Dropdown exportar */
.dropdown-exportar {
    position: relative;
}

.btn-exportar {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 16px;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.3s;
    box-shadow: 0 2px 4px rgba(16, 185, 129, 0.2);
}

.btn-exportar:hover {
    background: linear-gradient(135deg, #059669 0%, #047857 100%);
    box-shadow: 0 4px 8px rgba(16, 185, 129, 0.3);
    transform: translateY(-1px);
}

.btn-exportar .chevron-down {
    transition: transform 0.2s;
}

.dropdown-exportar:has(.menu-exportar) .chevron-down {
    transform: rotate(180deg);
}

.menu-exportar {
    position: absolute;
    top: calc(100% + 8px);
    right: 0;
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    min-width: 240px;
    z-index: 1000;
    overflow: hidden;
}

.menu-exportar-opcion {
    width: 100%;
    padding: 12px 16px;
    border: none;
    background: white;
    text-align: left;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 14px;
    color: #374151;
    transition: all 0.2s;
    border-bottom: 1px solid #f3f4f6;
}

.menu-exportar-opcion:last-child {
    border-bottom: none;
}

.menu-exportar-opcion:hover:not(:disabled) {
    background-color: #f9fafb;
    color: #10b981;
}

.menu-exportar-opcion:hover:not(:disabled) svg {
    stroke: #10b981;
}

.menu-exportar-deshabilitado {
    opacity: 0.5;
    cursor: not-allowed !important;
    position: relative;
}

.badge-proximamente {
    margin-left: auto;
    padding: 2px 8px;
    background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
    color: white;
    font-size: 10px;
    border-radius: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.sql-canvas-panel {
    position: fixed;
    top: 0;
    left: -600px;
    width: 600px;
    height: 100vh;
    background: #1e1e1e;
    z-index: 10000;
    display: flex;
    flex-direction: column;
    transition: left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 4px 0 24px rgba(0, 0, 0, 0.5);
}

.sql-canvas-panel.sql-canvas-abierto {
    left: 0;
}

.sql-canvas-header {
    background: #252526;
    padding: 16px 20px;
    border-bottom: 1px solid #3e3e42;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.sql-canvas-titulo {
    display: flex;
    align-items: center;
    gap: 12px;
    color: #ffffff;
}

.sql-canvas-titulo svg {
    color: #4ec9b0;
}

.sql-canvas-titulo h3 {
    margin: 0;
    font-size: 16px;
    font-weight: 600;
}

.sql-canvas-badge {
    padding: 4px 12px;
    background: rgba(78, 201, 176, 0.2);
    color: #4ec9b0;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 600;
}

.sql-canvas-acciones {
    display: flex;
    align-items: center;
    gap: 8px;
}

.btn-sql-accion {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 8px 12px;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 6px;
    color: #cccccc;
    font-size: 13px;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-sql-accion:hover {
    background: rgba(255, 255, 255, 0.1);
    border-color: rgba(255, 255, 255, 0.2);
    color: #ffffff;
}

.btn-sql-cerrar {
    padding: 6px;
    background: rgba(255, 59, 48, 0.1);
    border: 1px solid rgba(255, 59, 48, 0.2);
    border-radius: 6px;
    color: #ff3b30;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-sql-cerrar:hover {
    background: rgba(255, 59, 48, 0.2);
    border-color: rgba(255, 59, 48, 0.4);
}

.sql-canvas-info {
    background: #2d2d30;
    padding: 12px 20px;
    display: flex;
    gap: 24px;
    border-bottom: 1px solid #3e3e42;
}

.sql-info-item {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #858585;
    font-size: 13px;
}

.sql-info-item svg {
    color: #4ec9b0;
}

.sql-canvas-body {
    flex: 1;
    overflow: hidden;
    position: relative;
}

.monaco-container {
    width: 100%;
    height: 100%;
}

.sql-canvas-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    z-index: 9999;
    backdrop-filter: blur(2px);
}

/* Responsive */
@media (max-width: 768px) {
    .sql-canvas-panel {
        width: 100%;
        left: -100%;
    }
    
    .btn-sql-accion span {
        display: none;
    }
}

.editor-sql-container {
    height: 100%;
    width: 100%;
    overflow: auto;
}

.editor-sql-container .cm-editor {
    height: 100%;
    font-size: 14px;
}

.editor-sql-container .cm-scroller {
    overflow: auto;
}

/* =============================================
   LARAVEL CANVAS STYLES
   ============================================= */

.laravel-canvas-panel {
    position: fixed;
    top: 0;
    right: -50%;
    width: 50%;
    height: 100vh;
    background: #1a1a1a;
    box-shadow: -4px 0 20px rgba(0, 0, 0, 0.3);
    z-index: 9999;
    display: flex;
    flex-direction: column;
    transition: right 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.laravel-canvas-abierto {
    right: 0;
}

.laravel-canvas-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 9998;
    backdrop-filter: blur(2px);
}

.laravel-canvas-header {
    background: linear-gradient(135deg, #f05340 0%, #e84329 100%);
    padding: 20px 24px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.laravel-canvas-titulo {
    display: flex;
    align-items: center;
    gap: 12px;
    color: white;
}

.laravel-canvas-titulo svg {
    flex-shrink: 0;
}

.laravel-canvas-titulo h3 {
    margin: 0;
    font-size: 18px;
    font-weight: 600;
}

.laravel-canvas-badge {
    background: rgba(255, 255, 255, 0.2);
    padding: 4px 12px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 500;
}

.laravel-canvas-acciones {
    display: flex;
    gap: 8px;
}

.btn-laravel-accion {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    background: rgba(255, 255, 255, 0.15);
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.2s;
}

.btn-laravel-accion:hover {
    background: rgba(255, 255, 255, 0.25);
    transform: translateY(-1px);
}

.btn-laravel-cerrar {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    background: rgba(255, 255, 255, 0.15);
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-laravel-cerrar:hover {
    background: rgba(255, 255, 255, 0.25);
    transform: scale(1.05);
}

.laravel-canvas-info {
    display: flex;
    gap: 24px;
    padding: 16px 24px;
    background: #242424;
    border-bottom: 1px solid #333;
}

.laravel-info-item {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #aaa;
    font-size: 13px;
}

.laravel-info-item svg {
    color: #f05340;
}

.laravel-canvas-body {
    flex: 1;
    overflow: hidden;
    position: relative;
}

.editor-laravel-container {
    height: 100%;
    width: 100%;
    overflow: auto;
}

.editor-laravel-container .cm-editor {
    height: 100%;
    font-size: 14px;
    font-family: 'Fira Code', 'Consolas', monospace;
}

.editor-laravel-container .cm-scroller {
    overflow: auto;
}
</style>