<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\API;
use App\Models\Proyecto;
use App\Models\Data;
use App\Models\Columna;
use App\Models\Relacion;
use App\Models\Index;
use App\Models\Posision;

class EstructuraCompleta extends Controller
{

    public function obtenerContextoProyecto(Request $request, $idProyecto)
    {
        \Log::info('Iniciando obtenerContextoProyecto');
        \Log::info('ID Proyecto: ' . $idProyecto);
        \Log::info('Usuario: ' . $request->user()->id_usuario);
        
        try {
            $usuario = $request->user();
            
            $proyecto = Proyecto::where('id_proyecto', $idProyecto)
                ->where('id_usuario', $usuario->id_usuario)
                ->first();
            
            \Log::info('Proyecto encontrado: ' . ($proyecto ? 'SI' : 'NO'));
            
            if (!$proyecto) {
                return response()->json([
                    'success' => false,
                    'message' => 'Proyecto no encontrado'
                ], 404);
            }
            
            $tablas = Data::where('id_proyecto', $idProyecto)->get();
            \Log::info('Tablas encontradas: ' . $tablas->count());
            
            $estructuraCompleta = [];
            
            foreach ($tablas as $tabla) {
                \Log::info('Procesando tabla: ' . $tabla->id_tabla);
                
                $columnas = Columna::where('id_tabla', $tabla->id_tabla)->get();
                \Log::info('Columnas: ' . $columnas->count());
                
                $indices = Index::where('id_tabla', $tabla->id_tabla)
                    ->with('columna')
                    ->get();
                \Log::info('Indices: ' . $indices->count());

                $posicion = Posision::where('id_tabla', $tabla->id_tabla)->first();
                \Log::info('Posicion: ' . ($posicion ? 'encontrada' : 'no encontrada'));
                
                $columnasIds = $columnas->pluck('id_columna')->toArray();

                $relaciones = Relacion::whereIn('id_columna_1', $columnasIds)
                    ->orWhereIn('id_columna_2', $columnasIds)
                    ->with(['columnaOrigen', 'columnaDestino']) 
                    ->get()
                    ->map(function($rel) {
                        return [
                            'id_relacion' => $rel->id_relacion,
                            'id_columna_1' => $rel->id_columna_1,
                            'id_columna_2' => $rel->id_columna_2,
                            'columna_origen' => [
                                'id_columna' => $rel->columnaOrigen->id_columna,
                                'nombre_columna' => $rel->columnaOrigen->nombre_columna,
                                'tipo_columna' => $rel->columnaOrigen->tipo_columna,
                                'id_tabla' => $rel->columnaOrigen->id_tabla
                            ],
                            'columna_destino' => [
                                'id_columna' => $rel->columnaDestino->id_columna,
                                'nombre_columna' => $rel->columnaDestino->nombre_columna,
                                'tipo_columna' => $rel->columnaDestino->tipo_columna,
                                'id_tabla' => $rel->columnaDestino->id_tabla
                            ]
                        ];
                    });
                
                \Log::info('Relaciones: ' . $relaciones->count());
                
                $estructuraCompleta[] = [
                    'tabla' => $tabla,
                    'columnas' => $columnas,
                    'relaciones' => $relaciones,
                    'indices' => $indices,
                    'posicion' => $posicion
                ];
            }
            
            return response()->json([
                'success' => true,
                'data' => [
                    'proyecto' => $proyecto,
                    'tablas' => $tablas,
                    'estructura_completa' => $estructuraCompleta
                ]
            ]);
            
        } catch (\Exception $e) {
            \Log::error('ERROR: ' . $e->getMessage());
            \Log::error('TRACE: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}