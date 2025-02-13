<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Roles;

class UsuariosControlador extends Controller
{
    public function index(Request $request)
    {
        
        $cedula = $request->buscar;

        //return $cedula;

        if($cedula==''){

            $user = User::select('users.id', 'users.nombres', 'users.cedula','users.telefono','users.correo','users.cargo', 'roles.descripcion as rol')
            ->join('roles', 'users.id_rol', '=', 'roles.id_rol')
            ->orderBy('users.id', 'DESC')->paginate(10);

        }

        else {

            $user = User::select('users.id', 'users.nombres', 'users.cedula','users.telefono','users.correo','users.cargo', 'roles.descripcion as rol')
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
        try {

            $user = new User();
            $user->cedula = $request->cedula;
            $user->nombres = $request->nombres;
            $user->id_rol = $request->id_rol;
            $user->cargo = $request->cargo;
            $user->telefono = $request->telefono;
            $user->correo = $request->correo;
            $user->clave = Hash::make($request->clave);
            
            $user->save();
      
        return response()->json(['message' => 'El Usuario fue creados con éxito'], 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->validator->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al crear la cita: ' . $e->getMessage()], 500);
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
        $user =User::select('users.id', 'users.nombres', 'users.cedula','users.telefono','users.correo','users.cargo', 'users.id_rol')
        ->where('id', 'like', '%'. $id .'%')->take(1)->get();
        return ['user' => $user];
    }

    public function EditarUsuario(Request $request)
    {
    
         // Buscar al usuario
            $user = User::findOrFail($request->id);

            // Actualizar los campos
            $user->nombres = $request->nombres;
            $user->cedula = $request->cedula;
            $user->id_rol = $request->id_rol;
            $user->cargo = $request->cargo;
            $user->telefono = $request->telefono;
            $user->correo = $request->correo;

            // Actualizar la clave solo si se proporciona una nueva
            if ($request->filled('clave')) {
                $user->clave = Hash::make($request->clave); // Hashear la nueva clave
            }

            // Guardar los cambios
            $user->save();
                
            }
    
    

      
}