<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Proyecto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Data; 
use App\Models\Posision;
use App\Models\Columna;
class ProyectosLeonardoController extends Controller
{

    public function ver_proyectos()
{
    $user = Auth::user();

    $proyectos = Proyecto::where('id_usuario', $user->id_usuario)
        ->with([
            'creadoPor:id_usuario,correo,usuario',
            'modificadoPor:id_usuario,correo,usuario'
        ])
        ->select(
            'id_proyecto',
            'nombre',
            'descripcion',
            'estado',
            'fecha_registro',
            'fecha_modificacion',
            'creado_por',
            'modificado_por'
        )
        ->get();

    $data = $proyectos->map(function ($proyecto) {
        return [
            'id_proyecto'        => $proyecto->id_proyecto,
            'nombre'             => $proyecto->nombre,
            'descripcion'        => $proyecto->descripcion,
            'estado'             => $proyecto->estado,
            'fecha_registro'     => $proyecto->fecha_registro,
            'fecha_modificacion' => $proyecto->fecha_modificacion,
            'creado_por'         => $proyecto->creadoPor ? [
                'usuario' => $proyecto->creadoPor->usuario,
                'correo'  => $proyecto->creadoPor->correo
            ] : null,
            'modificado_por'     => $proyecto->modificadoPor ? [
                'usuario' => $proyecto->modificadoPor->usuario,
                'correo'  => $proyecto->modificadoPor->correo
            ] : null,
        ];
    });

    return response()->json([
        'message' => 'Lista de proyectos',
        'total'   => $data->count(),
        'data'    => $data
    ], 200);
}



    public function crear_proyecto(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255',
        ]);

        $user = Auth::user();

        $proyecto = Proyecto::create([
            'nombre'        => $request->nombre,
            'descripcion'   => $request->descripcion,
            'estado'        => 1,
            'id_usuario'    => $user->id_usuario,
            'creado_por'    => $user->id_usuario,
            'fecha_registro'=> now(),
        ]);

        return response()->json([
            'message' => 'Proyecto creado exitosamente',
            'proyecto' => [
                'id_proyecto' => $proyecto->id_proyecto,
                'nombre'      => $proyecto->nombre,
                'descripcion' => $proyecto->descripcion,
                'estado'      => $proyecto->estado,
                'fecha'       => $proyecto->fecha_registro,
            ]
        ], 201);
    }

    public function editar_proyecto(Request $request, $id)
    {
         $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255',
            'estado' => 'required|integer'
        ]);

        $user = Auth::user();

             $proyecto = Proyecto::where('id_proyecto', $id)
            ->where('id_usuario', $user->id_usuario)
            ->first();

        if (!$proyecto) {
            return response()->json([
                'message' => 'Proyecto no encontrado o no tienes permisos'
            ], 404);
        }

        $proyecto->update([
            'nombre'              => $request->nombre,
            'descripcion'         => $request->descripcion,
            'estado'              => $request->estado,
            'modificado_por'      => $user->id_usuario,
            'fecha_modificacion'  => now(),
        ]);

        return response()->json([
            'message' => 'Proyecto modificado exitosamente',
            'proyecto' => [
            'id_proyecto'        => $proyecto->id_proyecto,
            'nombre'             => $proyecto->nombre,
            'descripcion'        => $proyecto->descripcion,
            'estado'             => $proyecto->estado,
            'fecha_modificacion' => $proyecto->fecha_modificacion,
            ]
        ], 200);
    }


    public function eliminar_proyecto($id)
{
    try {
        $user = auth()->user();

        $proyecto = Proyecto::where('id_proyecto', $id)
            ->where('id_usuario', $user->id_usuario)
            ->first();

        if (!$proyecto) {
            return response()->json([
                'message' => 'Proyecto no encontrado o no tienes permisos para eliminarlo'
            ], 404);
        }


        \DB::beginTransaction();

        try {

            $idsTablas = Data::where('id_proyecto', $id)->pluck('id_tabla')->toArray();

            if (!empty($idsTablas)) {

                \App\Models\Posision::whereIn('id_tabla', $idsTablas)->delete();
                

                Columna::whereIn('id_tabla', $idsTablas)->delete();
            }


            Data::where('id_proyecto', $id)->delete();


            $proyecto->delete();

            \DB::commit();

            return response()->json([
                'message' => 'Proyecto y todos sus registros relacionados eliminados exitosamente',
                'id_proyecto' => $id
            ], 200);

        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Error al eliminar el proyecto',
            'error' => $e->getMessage()
        ], 500);
    }
}
}
