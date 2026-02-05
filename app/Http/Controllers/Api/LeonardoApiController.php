<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\API;

class LeonardoApiController extends Controller
{

    public function obtenerConfiguracion()
    {
        try {
            $usuario = Auth::user();
            
            $configuracion = API::where('id_usuario', $usuario->id_usuario)->first();
            
            if (!$configuracion) {
                return response()->json([
                    'success' => false,
                    'message' => 'No hay configuración guardada',
                    'data' => null
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Configuración obtenida exitosamente',
                'data' => $configuracion
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener configuración: ' . $e->getMessage()
            ], 500);
        }
    }


    public function guardarConfiguracion(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'api_key' => 'required|string',
                'end_point' => 'required|string|url',
                'modelo' => 'required|string'
            ], [
                'api_key.required' => 'La API Key es obligatoria',
                'end_point.required' => 'El Endpoint/URL es obligatorio',
                'end_point.url' => 'El Endpoint debe ser una URL válida',
                'modelo.required' => 'El Modelo es obligatorio'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de validación',
                    'errors' => $validator->errors()
                ], 422);
            }

            $usuario = Auth::user();
            

            $configuracion = API::where('id_usuario', $usuario->id_usuario)->first();

            if ($configuracion) {

                $configuracion->update([
                    'api_key' => $request->api_key,
                    'end_point' => $request->end_point,
                    'modelo' => $request->modelo
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Configuración actualizada exitosamente',
                    'data' => $configuracion
                ], 200);

            } else {

                $configuracion = API::create([
                    'api_key' => $request->api_key,
                    'end_point' => $request->end_point,
                    'modelo' => $request->modelo,
                    'id_usuario' => $usuario->id_usuario
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Configuración creada exitosamente',
                    'data' => $configuracion
                ], 201);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar configuración: ' . $e->getMessage()
            ], 500);
        }
    }


    public function eliminarConfiguracion()
    {
        try {
            $usuario = Auth::user();
            
            $configuracion = API::where('id_usuario', $usuario->id_usuario)->first();
            
            if (!$configuracion) {
                return response()->json([
                    'success' => false,
                    'message' => 'No hay configuración para eliminar'
                ], 404);
            }

            $configuracion->delete();

            return response()->json([
                'success' => true,
                'message' => 'Configuración eliminada exitosamente'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar configuración: ' . $e->getMessage()
            ], 500);
        }
    }
}