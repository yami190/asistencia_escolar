<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
   public function index(Request $request)
    {
       $buscar = $request->buscar;
        $criterio = $request->criterio;

        if($buscar==''){

            $users = User::select('users.id','users.name','users.cedula','users.password','users.condicion', 'users.descripcion','users.condicion', 'rol.nombre as rol')->where('users.condicion', '=', '1')
            ->orderBy('id', 'DESC')->paginate(10);

        }

        else {

        	$users = User::select('users.id','users.name','users.cedula','users.password','users.condicion', 'users.descripcion','users.condicion', 'rol.nombre as rol')->where('users.condicion', '=', '1')
            ->where('socios.'.$criterio, 'like', '%'. $buscar .'%')
            ->orderBy('id', 'DESC')->paginate(10);

        }
        return [
            'pagination' => [
                'total'        =>$users->total(),
                'current_page' =>$users->currentPage(),
                'per_page'     =>$users->perPage(),
                'last_page'    =>$users->lastPage(),
                'from'         =>$users->firstItem(),
                'to'           =>$users->lastItem(),
            ],
            'users' => $users
        ];


    }

    

     public function store(Request $request)
    {

    if(!$request->ajax()) return redirect('/');
        $user = new User();
        $user->name = $request->name;
        $user->cedula = $request->cedula;
        $user->password = bcrypt($request->password);
        $user->id_rol = $request->id_rol;
        $user->condicion = '1';

        $user->save();
    }
}
