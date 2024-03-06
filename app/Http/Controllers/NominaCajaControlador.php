<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Personal_caja;

class NominaCajaControlador extends Controller
{
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if($buscar==''){

            $personal_caja = Personal_caja::orderBy('id_personal', 'DESC')->paginate(10);

        }

        else {

            $personal_caja = Personal_caja::where($criterio, 'like', '%'. $buscar .'%')->orderBy('id_personal', 'DESC')->paginate(10);

        }
        return [
            'pagination' => [
                'total'        =>$personal_caja->total(),
                'current_page' =>$personal_caja->currentPage(),
                'per_page'     =>$personal_caja->perPage(),
                'last_page'    =>$personal_caja->lastPage(),
                'from'         =>$personal_caja->firstItem(),
                'to'           =>$personal_caja->lastItem(),
            ],
            'personal_caja' => $personal_caja
        ];


    }

    public function store(Request $request)
    {

    if(!$request->ajax()) return redirect('/');
        $nomina = new Personal_caja();
        $nomina->cedula = $request->cedula;
        $nomina->nombre = $request->nombre;
        $nomina->cargo = $request->cargo;
        $nomina->fecha_ingreso = $request->fecha_ingreso;
        $nomina->tipo_nomina = '1';
        $nomina->condicion = '1';

        $nomina->save();


    }

    public function desactivar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $personal_caja = personal_caja::findORFail($request->id_personal);
        $personal_caja->condicion = '0';

        $personal_caja->save(); 
    }

    public function activar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $personal_caja = personal_caja::findORFail($request->id_personal);
        $personal_caja->condicion = '1';

        $personal_caja->save(); 
    }
}
