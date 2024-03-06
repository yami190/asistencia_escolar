<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contabilidad;
use App\Mes;

class ContabilidadControlador extends Controller
{
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if($buscar==''){

            $contabilidad = Contabilidad::orderBy('id_contabilidad', 'DESC')->paginate(10);

        }

        else {

            $contabilidad = Contabilidad::where($criterio, 'like', '%'. $buscar .'%')
            ->orderBy('id_contabilidad', 'DESC')->paginate(10);

        }
        return [
            'pagination' => [
                'total'        =>$contabilidad->total(),
                'current_page' =>$contabilidad->currentPage(),
                'per_page'     =>$contabilidad->perPage(),
                'last_page'    =>$contabilidad->lastPage(),
                'from'         =>$contabilidad->firstItem(),
                'to'           =>$contabilidad->lastItem(),
            ],
            'contabilidad' => $contabilidad
        ];


    }
    public function selectMes(Request $request)
    {
       // if (!$request->ajax()) return redirect('/');
        $mes = Mes::orderBy('mes', 'asc')->get();
        return ['mes' => $mes];
    }

    
    public function store(Request $request)
    {

    if(!$request->ajax()) return redirect('/');
        $contabilidad = new Contabilidad();
        $contabilidad->cedula = $request->cedula;
        $contabilidad->mes = $request->mes;
        $contabilidad->referencia = $request->referencia;
        $contabilidad->observacion = $request->observacion;
        $contabilidad->condicion = '1';

        $contabilidad->save();


    }

    
    
    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $contabilidad = Contabilidad::findORFail($request->id_contabilidad);
        $contabilidad->cedula = $request->cedula;
        $contabilidad->mes = $request->mes;
        $contabilidad->referencia = $request->referencia;
        $contabilidad->observacion = $request->observacion;
        $nomina->condicion = '1';

        $nomina->save();
        
    }

    public function desactivar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $contabilidad = Contabilidad::findORFail($request->id_contabilidad);
        $contabilidad->condicion = '0';

        $contabilidad->save(); 
    }

    public function activar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $contabilidad = Contabilidad::findORFail($request->id_contabilidad);
        $contabilidad->condicion = '1';

        $contabilidad->save(); 
    }
}
