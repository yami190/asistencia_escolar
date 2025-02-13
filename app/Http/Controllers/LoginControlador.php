<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;


class LoginControlador extends Controller{
    public function login(){
        return view('login.login');
    }
    // Respuesta para sweetalert
    public function entrada_login(Request $request){

        //return $request;
        $cedula = $request['cedula'];
        $clave  = $request['clave'];
        if (!isset($cedula) || $cedula == '' || $cedula == 'undefined' || $cedula ==null ) {
            /* If cedula that we recieved is invalid, go here, and return 2 as output */
            echo 2;
            exit();
        }
        if (!isset($clave) || $clave == '' || $clave == 'undefined' || $clave ==null) {
            /* If Password that we recieved is invalid, go here, and return 3 as output */
            echo $clave;
            exit();
        }

        $user = User::where('cedula', $cedula)->first();
       
        //return $user;

        if ($user == null) {
            /* If Password that we recieved is invalid, go here, and return 3 as output */
            echo 4;
            exit();
        }

        // if($user->status == false){
        //    // return $user->status;
        //     echo 6;
        //     exit();
        // }
        


        $claveIngresada = trim($clave); // Elimina espacios en blanco
            if (Hash::check($claveIngresada, $user->clave)) {
                Auth::login($user);
                echo 1;
            } else {
                echo 5; // La contraseña no es válida
            }
        // $user = User::where('nick', $nick)->first();
    }

    public function logout(Request $request){
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    }

    public function showUser(){
        $cedulas = User::get();
        return view('administrador_noticias.cedulas', ['cedulas' => $cedulas]);
    }

    public function buscarUsuario(Request $request){
        $cedula = $request['cedula'];
        $user = User::where('cedula', $cedula)->take(1)->get();
        return ['user' => $user];

    }

    public function Gusuarios(Request $request){
        // Buscar al usuario por cédula
        $user = User::where('cedula', $request->cedula)->first();
        $request->validate([
            'cedula' => 'required|numeric',
            'nombres' => 'required|string',
            'correo' => 'required|string',
            'password' => 'required|string',

        ]);
        try {
            if (!$user) {
                $user = new User();
                $user->fill($request->all()); // Rellena el modelo con todos los datos del request
                $user->nombres = $request->nombres;
                $user->correo = $request->correo;
                $user->password = Hash::make($request->password);
                $user->save();
            } else {
                // Si el usuario existe, actualizarlo (opcional)
                $user->fill($request->except('cedula')); // Actualiza todos los campos excepto la cédula
                $user->nombres = $request->nombres;
                $user->correo = $request->correo;
                $user->password = Hash::make($request->password);
                $user->save();
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
            // Si el usuario no existe, crearlo
           
        }
        
      


}
