<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Data;
use App\Models\Proyecto;

class LeonardoDataController extends Controller
{

public function ver_tablas($id_proyecto)
{
    $user = Auth::user();

    $proyecto = Proyecto::where('id_proyecto', $id_proyecto)
        ->where('id_usuario', $user->id_usuario)
        ->first();

    if (!$proyecto) {
        return response()->json([
            'message' => 'Proyecto no encontrado o no tienes permisos'
        ], 404);
    }

    $tablas = Data::where('id_proyecto', $id_proyecto)
        ->select('id_tabla', 'nombre_tabla', 'color_tabla', 'id_proyecto')
        ->get();

    return response()->json([
        'message' => 'Lista de tablas',
        'total'   => $tablas->count(),
        'data'    => $tablas
    ], 200);
}

    public function crear_tabla(Request $request)
    {
        $request->validate([
            'nombre_tabla' => 'required|string|max:255',
            'id_proyecto'  => 'required|integer'
        ]);

        $user = Auth::user();

        $proyecto = Proyecto::where('id_proyecto', $request->id_proyecto)
            ->where('id_usuario', $user->id_usuario)
            ->first();

        if (!$proyecto) {
            return response()->json([
                'message' => 'Proyecto no encontrado o no tienes permisos'
            ], 404);
        }

        $tabla = Data::create([
            'nombre_tabla'   => $request->nombre_tabla,
            'color_tabla' => sprintf(
            '#%02X%02X%02X',
                mt_rand(0, 120),
                mt_rand(0, 120),
                mt_rand(0, 120)
            ),

            'id_proyecto'    => $proyecto->id_proyecto,
            'fecha_registro' => now(),
        ]);

        return response()->json([
            'message' => 'Tabla creada exitosamente',
            'tabla' => [
                'id_tabla'       => $tabla->id_tabla ?? null,
                'nombre_tabla'   => $tabla->nombre_tabla,
                'color_tabla'    => $tabla->color,
                'id_proyecto'    => $tabla->id_proyecto,
                'fecha_registro' => $tabla->fecha_registro,
            ]
        ], 201);
    }

public function editar_tabla(Request $request, $id)
{
    $request->validate([
        'nombre_tabla' => 'required|string|max:255'
    ]);

    $user = Auth::user();

    $tabla = Data::where('id_tabla', $id)
        ->whereHas('proyecto', function ($query) use ($user) {
            $query->where('id_usuario', $user->id_usuario);
        })
        ->first();

    if (!$tabla) {
        return response()->json([
            'message' => 'Tabla no encontrada o no tienes permisos'
        ], 404);
    }

    $tabla->update([
        'nombre_tabla' => $request->nombre_tabla,
    ]);

    return response()->json([
        'message' => 'Tabla modificada exitosamente',
        'tabla' => [
            'id_tabla'     => $tabla->id_tabla,
            'nombre_tabla' => $tabla->nombre_tabla,
            'color_tabla'  => $tabla->color_tabla,
            'id_proyecto'  => $tabla->id_proyecto,
        ]
    ], 200);
}

public function eliminar_tabla($id)
{
    $user = auth()->user();

    $tabla = Data::where('id_tabla', $id)
        ->whereHas('proyecto', function ($query) use ($user) {
            $query->where('id_usuario', $user->id_usuario);
        })
        ->first();

    if (!$tabla) {
        return response()->json([
            'message' => 'Tabla no encontrada o no tienes permisos'
        ], 404);
    }


    $tabla->columnas()->delete();
    $tabla->posiciones()->delete();

    $tabla->delete();

    return response()->json([
        'message' => 'Tabla y todos sus datos asociados eliminados exitosamente',
        'id_tabla' => $id
    ], 200);
}

}
