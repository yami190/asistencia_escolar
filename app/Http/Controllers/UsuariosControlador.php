<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Roles;

class UsuariosControlador extends Controller
{
    public function index(Request $request)
    {
        
        $cedula = $request->buscar;

        //return $cedula;

        if($cedula==''){

            $user = User::select('users.id', 'users.nombres', 'users.cedula','users.telefono','users.correo','users.cargo','users.id_rol', 'roles.descripcion as rol', 'users.respuesta1' , 'users.respuesta2', 'users.respuesta3')
            ->join('roles', 'users.id_rol', '=', 'roles.id_rol')
            ->orderBy('users.id', 'DESC')->paginate(10);

        }

        else {

            $user = User::select('users.id', 'users.nombres', 'users.cedula','users.telefono','users.correo','users.cargo','users.id_rol', 'roles.descripcion as rol', 'users.respuesta1' , 'users.respuesta2', 'users.respuesta3')
            ->join('roles', 'users.id_rol', '=', 'roles.id_rol')
            ->where('users.cedula', 'like', '%'. $cedula .'%')
            ->orderBy('users.id', 'DESC')->paginate(10);

        }
        
        return [
            'pagination' => [
                'total'        =>$user->total(),
                'current_page' =>$user->currentPage(),
                'per_page'     =>$user->perPage(),
                'last_page'    =>$user->lastPage(),
                'from'         =>$user->firstItem(),
                'to'           =>$user->lastItem(),
            ],
            'user' => $user
        ];
    }
    public function selectRol(Request $request)
    {
       if (!$request->ajax()) return redirect('/');
            $roles = Roles::select('id_rol', 'descripcion')
                ->orderBy('id_rol', 'asc')
                ->get();
            $roles->prepend((object) ['id_rol' => '', 'descripcion' => 'Seleccione']);
        return ['roles' => $roles];
    }
    public function guardarUsuario(Request $request)
    {
        // Validación del formulario
        $request->validate([
            'cedula' => 'required|unique:users,cedula',
            'nombres' => 'required|string',
            'id_rol' => 'required|numeric',
            'cargo' => 'required|string',
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
            $user->id_rol = $request->id_rol;
            $user->cargo = $request->cargo;
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


    public function eliminarUsuario(Request $request)
    {
        $id = $request->query('id'); // Para obtener el parámetro de consulta
       
        if (empty($id)) {
            return response()->json(['error' => 'ID no proporcionado'], 400);
        }
        $usuario = User::find($id);
            if ($usuario) {
                $usuario->delete();
                return response()->json(['success' => 'Usuario eliminado correctamente.']);
            } else {
                return response()->json(['error' => 'Usuario no encontrado.'], 404);
            }
        
    }

    public function BuscarUsuario(Request $request)
    {
        //return $request;
        $id = $request['id'];
        $user =User::select('users.id', 'users.nombres', 'users.cedula','users.telefono','users.correo','users.cargo', 'users.id_rol', 'users.respuesta1' , 'users.respuesta2', 'users.respuesta3')
        ->where('id', 'like', '%'. $id .'%')->take(1)->get();
        return ['user' => $user];
    }

    public function EditarUsuario(Request $request)
{
    $id = $request->id; // 👈 Aquí defines la variable correctamente

    // Validar entrada
    $validator = Validator::make($request->all(), [
        'nombres'     => 'required|string|max:255',
        'cedula'      => 'required|string|max:20|unique:users,cedula,' . $id,
        'id_rol'      => 'required|exists:roles,id_rol',
        'cargo'       => 'required|string|max:100',
        'telefono'    => 'required|string|max:20',
        'correo'      => 'required|email|max:255|unique:users,correo,' . $id,
        'respuesta1'  => 'nullable|string|max:255',
        'respuesta2'  => 'nullable|string|max:255',
        'respuesta3'  => 'nullable|string|max:255',
        'clave'       => 'nullable|string|min:6|confirmed',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => 'error',
            'errors' => $validator->errors()
        ], 422);
    }

    // Buscar usuario
    $user = User::findOrFail($id);

    // Asignar valores
    $user->nombres     = $request->nombres;
    $user->cedula      = $request->cedula;
    $user->id_rol      = $request->id_rol;
    $user->cargo       = $request->cargo;
    $user->telefono    = $request->telefono;
    $user->correo      = $request->correo;
    $user->respuesta1  = $request->respuesta1;
    $user->respuesta2  = $request->respuesta2;
    $user->respuesta3  = $request->respuesta3;

    if (!empty($request->clave)) {
        $user->clave = Hash::make($request->clave);
    }

    $user->save();

    return response()->json([
        'status' => 'success',
        'message' => 'Usuario actualizado correctamente'
    ]);
}

    
    

      
}