<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class RegistroController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'nombreCompleto' => [
                'required',
                'max:50',
                'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/'
            ],
            'usuario' => [
                'required',
                'max:250',
                'unique:users,usuario'
            ],
            'correo' => [
            'required',
            'email',
            'max:250',
            'unique:users,correo'
            ],

            'contrasena' => [
                'required',
                'min:6',
                'regex:/^(?=.*\d)(?=.*[!@#$%^&*()_+\-=\[\]{};\':"\\|,.<>\/?]).+$/'
            ],
            'confirmarContrasena' => [
                'required',
                'same:contrasena'
            ]
        ]);

        $correo = strtolower($request->correo);

        $user = User::create([
            'nombre' => $request->nombreCompleto,
            'usuario' => $request->usuario,
            'correo' => $correo,
            'contrasena' => Hash::make($request->contrasena),
        ]);

        return response()->json([
            'message' => 'Usuario registrado exitosamente',
            'user' => [
                'id' => $user->id,
                'nombre' => $user->nombreCompleto,
                'usuario' => $user->usuario,
                'correo' => $user->correo
            ]
        ], 201);
    }
}