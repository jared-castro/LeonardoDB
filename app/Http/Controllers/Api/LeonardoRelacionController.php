<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Relacion;
use App\Models\Columna;

class LeonardoRelacionController extends Controller
{
    public function crear(Request $request)
    {
        $request->validate([
            'id_columna_1' => 'required|exists:leonardocolumna,id_columna',
            'id_columna_2' => 'required|exists:leonardocolumna,id_columna',
            'color_relacion' => 'required|string|max:255',
        ]);

        $user = Auth::user();

        $columna1 = Columna::where('id_columna', $request->id_columna_1)
            ->whereHas('tabla.proyecto', function ($query) use ($user) {
                $query->where('id_usuario', $user->id_usuario);
            })
            ->first();

        $columna2 = Columna::where('id_columna', $request->id_columna_2)
            ->whereHas('tabla.proyecto', function ($query) use ($user) {
                $query->where('id_usuario', $user->id_usuario);
            })
            ->first();

        if (!$columna1 || !$columna2) {
            return response()->json([
                'message' => 'Columnas no encontradas o sin permisos'
            ], 404);
        }

        $relacion = Relacion::create([
            'id_columna_1' => $request->id_columna_1,
            'id_columna_2' => $request->id_columna_2,
            'color_relacion' => $request->color_relacion,
        ]);

        return response()->json([
            'message' => 'Relación creada exitosamente',
            'data' => $relacion
        ], 201);
    }

    public function ver_por_proyecto($id_proyecto)
    {
        $user = Auth::user();

        $relaciones = Relacion::whereHas('columnaOrigen.tabla.proyecto', function ($query) use ($user, $id_proyecto) {
            $query->where('id_usuario', $user->id_usuario)
                  ->where('id_proyecto', $id_proyecto);
        })
        ->with(['columnaOrigen', 'columnaDestino'])
        ->get();

        return response()->json([
            'data' => $relaciones
        ], 200);
    }

    public function eliminar($id_relacion)
    {
        $user = Auth::user();

        $relacion = Relacion::where('id_relacion', $id_relacion)
            ->whereHas('columnaOrigen.tabla.proyecto', function ($query) use ($user) {
                $query->where('id_usuario', $user->id_usuario);
            })
            ->first();

        if (!$relacion) {
            return response()->json([
                'message' => 'Relación no encontrada o sin permisos'
            ], 404);
        }

        $relacion->delete();

        return response()->json([
            'message' => 'Relación eliminada exitosamente'
        ], 200);
    }
}