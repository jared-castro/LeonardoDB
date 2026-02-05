<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Data;
use App\Models\Index;
use App\Models\Columna;

class LeonardoIndexController extends Controller
{
    public function ver_indices($id_tabla)
    {
        try {
            $user = Auth::user();

            $tabla = Data::where('id_tabla', $id_tabla)
                ->whereHas('proyecto', function ($query) use ($user) {
                    $query->where('id_usuario', $user->id_usuario);
                })
                ->first();

            if (!$tabla) {
                return response()->json([
                    'message' => 'Tabla no encontrada o no tienes permisos',
                    'data' => []
                ], 200);
            }

            $indices = DB::table('leonardorindex')
                ->where('id_tabla', $id_tabla)
                ->get();


            $resultado = [];
            foreach ($indices as $index) {
                $columna = DB::table('leonardocolumna')
                    ->where('id_columna', $index->id_columna)
                    ->first();

                if ($columna) {
                    $resultado[] = [
                        'id_index' => $index->id_index,
                        'id_tabla' => $index->id_tabla,
                        'id_columna' => $index->id_columna,
                        'columna' => [
                            'id_columna' => $columna->id_columna,
                            'nombre_columna' => $columna->nombre_columna,
                            'tipo_columna' => $columna->tipo_columna
                        ]
                    ];
                }
            }

            return response()->json([
                'message' => 'Lista de índices',
                'total' => count($resultado),
                'data' => $resultado
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener índices',
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ], 500);
        }
    }

    public function crear_index(Request $request)
    {
        try {
            $request->validate([
                'id_tabla' => 'required|integer',
                'columnas' => 'required|array|min:1',
                'columnas.*' => 'integer'
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

            $columnasValidas = DB::table('leonardocolumna')
                ->where('id_tabla', $request->id_tabla)
                ->whereIn('id_columna', $request->columnas)
                ->count();

            if ($columnasValidas !== count($request->columnas)) {
                return response()->json([
                    'message' => 'Una o más columnas no pertenecen a esta tabla'
                ], 400);
            }

            DB::beginTransaction();

            $indices = [];
            foreach ($request->columnas as $idColumna) {
                $idIndex = DB::table('leonardorindex')->insertGetId([
                    'id_tabla' => $request->id_tabla,
                    'id_columna' => $idColumna
                ]);

                $columna = DB::table('leonardocolumna')
                    ->where('id_columna', $idColumna)
                    ->first();

                $indices[] = [
                    'id_index' => $idIndex,
                    'id_tabla' => $request->id_tabla,
                    'id_columna' => $idColumna,
                    'columna' => [
                        'id_columna' => $columna->id_columna,
                        'nombre_columna' => $columna->nombre_columna,
                        'tipo_columna' => $columna->tipo_columna
                    ]
                ];
            }

            DB::commit();

            return response()->json([
                'message' => 'Índice creado exitosamente',
                'data' => $indices
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error al crear índice',
                'error' => $e->getMessage(),
                'line' => $e->getLine()
            ], 500);
        }
    }

    public function gestionar_index(Request $request)
{
    try {
        $request->validate([
            'id_tabla' => 'required|integer',
            'columnas' => 'nullable|array',
            'columnas.*' => 'integer'
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

        if (count($request->columnas) > 0) {
            $columnasValidas = DB::table('leonardocolumna')
                ->where('id_tabla', $request->id_tabla)
                ->whereIn('id_columna', $request->columnas)
                ->count();

            if ($columnasValidas !== count($request->columnas)) {
                return response()->json([
                    'message' => 'Una o más columnas no pertenecen a esta tabla'
                ], 400);
            }
        }

        DB::beginTransaction();

        $indicesExistentes = DB::table('leonardorindex')
            ->where('id_tabla', $request->id_tabla)
            ->pluck('id_index')
            ->toArray();

        if (count($indicesExistentes) > 0) {
            DB::table('leonardorindex')
                ->where('id_tabla', $request->id_tabla)
                ->delete();
        }

        if (count($request->columnas) === 0) {
            DB::commit();
            return response()->json([
                'message' => 'Índices eliminados exitosamente',
                'data' => []
            ], 200);
        }

        $nuevosIndices = [];
        foreach ($request->columnas as $idColumna) {
            $idIndex = DB::table('leonardorindex')->insertGetId([
                'id_tabla' => $request->id_tabla,
                'id_columna' => $idColumna
            ]);

            $columna = DB::table('leonardocolumna')
                ->where('id_columna', $idColumna)
                ->first();

            $nuevosIndices[] = [
                'id_index' => $idIndex,
                'id_tabla' => $request->id_tabla,
                'id_columna' => $idColumna,
                'columna' => [
                    'id_columna' => $columna->id_columna,
                    'nombre_columna' => $columna->nombre_columna,
                    'tipo_columna' => $columna->tipo_columna
                ]
            ];
        }

        DB::commit();

        $mensaje = count($indicesExistentes) > 0 
            ? 'Índice actualizado exitosamente' 
            : 'Índice creado exitosamente';

        return response()->json([
            'message' => $mensaje,
            'data' => $nuevosIndices
        ], 200);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'message' => 'Error al gestionar índice',
            'error' => $e->getMessage(),
            'line' => $e->getLine()
        ], 500);
    }
}

}