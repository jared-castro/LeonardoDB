<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Data;
use App\Models\Posision;

class PosisionController extends Controller
{
    public function ver_posicion($id_tabla)
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'message' => 'Usuario no autenticado'
                ], 401);
            }


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


            $posicion = Posision::where('id_tabla', $id_tabla)->first();

            return response()->json([
                'posicion' => $posicion
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error en ver_posicion para tabla ' . $id_tabla . ': ' . $e->getMessage());
            
            return response()->json([
                'message' => 'Error interno del servidor',
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ], 500);
        }
    }

    public function actualizar_posicion(Request $request, $id_tabla)
{
    try {

        \Log::info('Request recibido:', [
            'id_tabla' => $id_tabla,
            'pos_x' => $request->pos_x,
            'pos_y' => $request->pos_y,
            'user_id' => Auth::id()
        ]);

        $request->validate([
            'pos_x' => 'required|numeric',
            'pos_y' => 'required|numeric',
        ]);

        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'message' => 'Usuario no autenticado'
            ], 401);
        }

        $tabla = Data::where('id_tabla', $id_tabla)
            ->whereHas('proyecto', function ($query) use ($user) {
                $query->where('id_usuario', $user->id_usuario);
            })
            ->first();

        if (!$tabla) {
            \Log::error('Tabla no encontrada: ' . $id_tabla);
            return response()->json([
                'message' => 'Tabla no encontrada o no tienes permisos'
            ], 404);
        }


        $posicion = Posision::updateOrCreate(
            ['id_tabla' => $id_tabla],
            [
                'pos_x' => $request->pos_x,
                'pos_y' => $request->pos_y,
            ]
        );

        \Log::info('Posición guardada:', $posicion->toArray());

        return response()->json([
            'message' => 'Posición actualizada exitosamente',
            'posicion' => $posicion
        ], 200);

    } catch (\Exception $e) {
        \Log::error('Error en actualizar_posicion:', [
            'message' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => $e->getFile()
        ]);
        
        return response()->json([
            'message' => 'Error interno del servidor',
            'error' => $e->getMessage(),
            'line' => $e->getLine()
        ], 500);
    }
}

    public function crear_posicion(Request $request, $id_tabla)
    {
        try {
            $request->validate([
                'pos_x' => 'required|numeric',
                'pos_y' => 'required|numeric',
            ]);

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

            $posicion = Posision::create([
                'pos_x'    => $request->pos_x,
                'pos_y'    => $request->pos_y,
                'id_tabla' => $tabla->id_tabla,
            ]);

            return response()->json([
                'message' => 'Posición creada exitosamente',
                'posicion' => $posicion
            ], 201);

        } catch (\Exception $e) {
            Log::error('Error en crear_posicion: ' . $e->getMessage());
            
            return response()->json([
                'message' => 'Error interno del servidor',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}