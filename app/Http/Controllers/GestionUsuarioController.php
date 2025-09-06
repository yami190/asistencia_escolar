<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;

class GestionUsuarioController extends Controller
{
    public function index()
    {
        return view('login.gestiondeusuario');
    }

    public function buscarCedula(Request $request)
    {
        //return $request;
        $usuario = User::where('cedula', $request->cedula)->first();

        //return $usuario;

        if ($usuario) {
            return response()->json([
                'existe' => true,
                'pregunta1' => $usuario->pregunta1,
                'pregunta2' => $usuario->pregunta2
            ]);
        }

        return response()->json(['existe' => false]);
    }
    public function validarRespuestas(Request $request)
    {
        $usuario = User::where('cedula', $request->cedula)->first();

        if (!$usuario) {
            return response()->json(['validado' => false, 'mensaje' => 'Usuario no encontrado.'], 404);
        }

        // Comparar respuestas (puedes normalizar cadenas si es necesario)
        if (
            $usuario->respuesta1 == $request->respuesta1 &&
            $usuario->respuesta2 == $request->respuesta2 &&
            $usuario->respuesta3 == $request->respuesta3
        ) {
            return response()->json(['validado' => true]);
        }

        return response()->json(['validado' => false, 'mensaje' => 'Las respuestas no son correctas.']);
    }
    public function actualizarContraseña(Request $request)
    {
        $usuario = User::where('cedula', $request->cedula)->first();

        if (!$usuario) {
            return response()->json(['actualizado' => false, 'mensaje' => 'Usuario no encontrado.'], 404);
        }

        // Actualizamos la contraseña usando un hash (bcrypt)
        $usuario->clave = Hash::make($request->nueva_contraseña);
        $usuario->save();

        return response()->json(['actualizado' => true]);
    }

    public function guardarUsuario(Request $request)
    {
        // Validación del formulario
        $request->validate([
            'cedula' => 'required|unique:users,cedula',
            'nombres' => 'required|string',
            'telefono' => 'required|string',
            'correo' => 'required|email|unique:users,correo',
            'clave' => 'required|min:6|same:confirmar_clave',
            'confirmar_clave' => 'required|min:6',
            'respuesta1' => 'required|string',
            'respuesta2' => 'required|string',
            'respuesta3' => 'required|string',
        ], [
            'clave.same' => 'Las contraseñas no coinciden.',
            'confirmar_clave.required' => 'Debe confirmar la contraseña.',
            'cedula.unique' => 'La cédula ya está registrada.',
            'correo.unique' => 'El correo ya está registrado.',
        ]);
    
        try {
            $user = new User();
            $user->cedula = $request->cedula;
            $user->nombres = $request->nombres;
            $user->telefono = $request->telefono;
            $user->correo = $request->correo;
            $user->respuesta1 = $request->respuesta1;
            $user->respuesta2 = $request->respuesta2;
            $user->respuesta3 = $request->respuesta3;
            $user->clave = Hash::make($request->clave); // Encriptar la clave
            $user->save();
    
            return response()->json(['message' => 'El usuario fue creado con éxito'], 201);
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Esto rara vez se ejecuta porque ya usamos $request->validate(), pero se incluye por seguridad
            return response()->json(['errors' => $e->errors()], 422);
    
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Ocurrió un error al crear el usuario',
                'detalle' => $e->getMessage()
            ], 500);
        }
    }
}

