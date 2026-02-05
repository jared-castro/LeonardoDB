<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegistroController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\ProyectosLeonardoController;
use App\Http\Controllers\Api\LeonardoDataController;
use App\Http\Controllers\Api\LeonardoColumnaController;
use App\Http\Controllers\Api\PosisionController;
use App\Http\Controllers\Api\LeonardoRelacionController;
use App\Http\Controllers\Api\LeonardoIndexController;
use App\Http\Controllers\Api\LeonardoApiController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\ProyectoEstructuraController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::post('/register', [RegistroController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {

    Route::post('/proyectos/crear', [ProyectosLeonardoController::class, 'crear_proyecto']);
    Route::get('/proyectos/ver', [ProyectosLeonardoController::class, 'ver_proyectos']);
    Route::delete('/proyectos/eliminar/{id}', [ProyectosLeonardoController::class, 'eliminar_proyecto']);
    Route::put('/proyectos/editar/{id}', [ProyectosLeonardoController::class, 'editar_proyecto']);


    Route::post('/data/crear', [LeonardoDataController::class, 'crear_tabla']);
    Route::get('/data/tablas/{id_proyecto}', [LeonardoDataController::class, 'ver_tablas']);
    Route::put('/data/editar/{id_tabla}', [LeonardoDataController::class, 'editar_tabla']);
    Route::delete('/data/eliminar/{id_tabla}', [LeonardoDataController::class, 'eliminar_tabla']);

    Route::post('/columna/crear/{id_tabla}', [LeonardoColumnaController::class, 'crear_columna']);
    Route::get('/columna/ver/{id_tabla}', [LeonardoColumnaController::class, 'ver_columna']);
    Route::delete('/columna/eliminar/{id_tabla}', [LeonardoColumnaController::class, 'eliminar_columna']);
    Route::put('/columna/editar/{id_columna}', [LeonardoColumnaController::class, 'editar_columna']);

    Route::post('/posicion/crear/{id_tabla}', [PosisionController::class, 'crear_posicion']);
    Route::put('/posicion/actualizar/{id_tabla}', [PosisionController::class, 'actualizar_posicion']);
    Route::get('/posicion/ver/{id_tabla}', [PosisionController::class, 'ver_posicion']);



    Route::post('/relaciones/crear', [LeonardoRelacionController::class, 'crear']);
    Route::get('/relaciones/proyecto/{id_proyecto}', [LeonardoRelacionController::class, 'ver_por_proyecto']);
    Route::delete('/relaciones/eliminar/{id_relacion}', [LeonardoRelacionController::class, 'eliminar']);

});

    Route::middleware('auth:sanctum')->prefix('index')->group(function () {
        Route::get('/tabla/{id_tabla}', [LeonardoIndexController::class, 'ver_indices']);
        Route::post('/gestionar', [LeonardoIndexController::class, 'gestionar_index']);
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/api-config/obtener', [LeonardoApiController::class, 'obtenerConfiguracion']);
        Route::post('/api-config/guardar', [LeonardoApiController::class, 'guardarConfiguracion']);
        Route::delete('/api-config/eliminar', [LeonardoApiController::class, 'eliminarConfiguracion']);
    });

    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return response()->json($request->user());
    });

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/chat/config', [ChatController::class, 'obtenerConfiguracion']);
    Route::get('/chat/proyecto/{idProyecto}/contexto', [ChatController::class, 'obtenerContextoProyecto']);
    
    Route::get('/columnas/tabla/{idTabla}', [LeonardoColumnaController::class, 'ver_columna']);
    Route::get('/relaciones/tabla/{idTabla}', [LeonardoRelacionController::class, 'ver_por_proyecto']);
    Route::get('/indices/tabla/{idTabla}', [LeonardoIndexController::class, 'ver_indices']);
});