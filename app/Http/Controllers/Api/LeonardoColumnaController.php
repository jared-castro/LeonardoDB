<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Data;
use App\Models\Proyecto;
use App\Models\Columna;
class LeonardoColumnaController extends Controller
{

public function ver_columna($id_tabla)
{
    $user = Auth::user();

    $tabla = Data::where('id_tabla', $id_tabla)
        ->whereHas('proyecto', function ($query) use ($user) {
            $query->where('id_usuario', $user->id_usuario);
        })
        ->first();

    if (!$tabla) {
        return response()->json([
            'message' => 'Tabla no encontrada o no tienes permisos'
        ], 404);
    }

    $columnas = Columna::where('id_tabla', $id_tabla)
        ->select('id_columna', 'nombre_columna', 'descripcion_columna', 'tipo_columna', 'longitud_columna', 'cotejamiento_columna', 'nulo_columna', 'auto_incrementar', 'indice_tipo', 'fecha_registro')
        ->get();

    return response()->json([
        'message' => 'Lista de columnas',
        'total'   => $columnas->count(),
        'data'    => $columnas
    ], 200);
}


public function crear_columna(Request $request)
{
    $request->validate([
        'nombre_columna'      => 'required|string|max:255',
        'descripcion_columna' => 'required|string|max:255',
        'tipo_columna'        => 'required|string|max:255',
        'id_tabla'            => 'required|integer'
    ]);

    $user = Auth::user();

    $tabla = Data::where('id_tabla', $request->id_tabla)
        ->whereHas('proyecto', function ($query) use ($user) {
            $query->where('id_usuario', $user->id_usuario);
        })
        ->first();

    if (!$tabla) {
        return response()->json([
            'message' => 'Tabla no encontrada o no tienes permisos'
        ], 404);
    }

    $columna = Columna::create([
        'nombre_columna'      => $request->nombre_columna,
        'descripcion_columna' => $request->descripcion_columna,
        'tipo_columna'        => $request->tipo_columna,
        'longitud_columna'    => $request->longitud_columna ?? null,
        'cotejamiento_columna'=> $request->cotejamiento_columna ?? null,
        'nulo_columna'        => $request->nulo_columna ?? true,
        'auto_incrementar'    => $request->auto_incrementar ?? false,
        'indice_tipo'         => $request->indice_tipo ?? null,
        'id_tabla'            => $tabla->id_tabla,
        'fecha_registro'      => now(),
    ]);

    return response()->json([
        'message' => 'Columna creada exitosamente',
        'columna' => [
            'id_columna'          => $columna->id_columna,
            'nombre_columna'      => $columna->nombre_columna,
            'descripcion_columna' => $columna->descripcion_columna,
            'tipo_columna'        => $columna->tipo_columna,
            'id_tabla'            => $columna->id_tabla,
            'fecha_registro'      => $columna->fecha_registro,
        ]
    ], 201);
}

public function editar_columna(Request $request, $id_columna)
{
    $request->validate([
        'nombre_columna'      => 'required|string|max:255',
        'descripcion_columna' => 'required|string|max:255',
        'tipo_columna'        => 'required|string|max:255',
        'id_tabla'            => 'required|integer',
    ]);

    $user = Auth::user();

    $columna = Columna::where('id_columna', $id_columna)
        ->whereHas('tabla.proyecto', function ($query) use ($user) {
            $query->where('id_usuario', $user->id_usuario);
        })
        ->first();

    if (!$columna) {
        return response()->json([
            'message' => 'Columna no encontrada o no tienes permisos'
        ], 404);
    }

    $columna->update([
        'nombre_columna'       => $request->nombre_columna,
        'descripcion_columna'  => $request->descripcion_columna,
        'tipo_columna'         => $request->tipo_columna,
        'longitud_columna'     => $request->longitud_columna,
        'cotejamiento_columna' => $request->cotejamiento_columna,
        'nulo_columna'         => $request->nulo_columna ?? true,
        'auto_incrementar'     => $request->auto_incrementar ?? false,
        'indice_tipo'          => $request->indice_tipo,
    ]);

    return response()->json([
        'message' => 'Columna actualizada exitosamente',
        'columna' => $columna
    ], 200);
}





public function eliminar_columna($id_columna)
{
    $user = auth()->user();

    $columna = Columna::where('id_columna', $id_columna)
        ->whereHas('tabla.proyecto', function ($query) use ($user) {
            $query->where('id_usuario', $user->id_usuario);
        })
        ->first();

    if (!$columna) {
        return response()->json([
            'message' => 'Columna no encontrada o no tienes permisos'
        ], 404);
    }

    $columna->delete();

    return response()->json([
        'message' => 'Columna eliminada exitosamente',
        'id_columna' => $id_columna
    ], 200);
}

}
