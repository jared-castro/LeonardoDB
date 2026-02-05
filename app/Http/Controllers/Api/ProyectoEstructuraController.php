<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Proyecto;
use App\Models\Data;
use App\Models\Columna;
use App\Models\Relacion;
use App\Models\Index;


class ProyectoEstructuraController extends Controller
{
    public function obtenerEstructura(Request $request, $idProyecto)
    {
        $usuario = $request->user();
        
        $proyecto = Proyecto::where('id_proyecto', $idProyecto)
            ->where('id_usuario', $usuario->id_usuario)
            ->first();
        
        if (!$proyecto) {
            return response()->json([
                'success' => false,
                'message' => 'Proyecto no encontrado'
            ], 404);
        }
        
        $tablas = Data::where('id_proyecto', $idProyecto)->get();
        
        $tablasConDetalles = [];
        
        foreach ($tablas as $tabla) {
            $columnas = Columna::where('id_tabla', $tabla->id_tabla)->get();
            
            $relaciones = Relacion::where('id_tabla_origen', $tabla->id_tabla)
                ->join('tablas', 'relaciones.id_tabla_destino', '=', 'tablas.id_tabla')
                ->select('relaciones.*', 'tablas.nombre as tabla_destino')
                ->get();
            
            $indices = Index::where('id_tabla', $tabla->id_tabla)->get();
            
            $tablasConDetalles[] = [
                'id_tabla' => $tabla->id_tabla,
                'nombre' => $tabla->nombre,
                'descripcion' => $tabla->descripcion,
                'columnas' => $columnas,
                'relaciones' => $relaciones,
                'indices' => $indices
            ];
        }
        
        return response()->json([
            'success' => true,
            'data' => [
                'proyecto' => $proyecto,
                'tablas' => $tablasConDetalles
            ]
        ]);
    }
}
