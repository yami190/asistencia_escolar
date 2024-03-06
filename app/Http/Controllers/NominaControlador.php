<?php

namespace App\Http\Controllers;
use App\Nomina;

use Illuminate\Http\Request;

class NominaControlador extends Controller
{
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if($buscar==''){

            $nominas = Nomina::orderBy('id_nomina', 'DESC')->paginate(10);

        }

        else {

            $nominas = Nomina::where($criterio, 'like', '%'. $buscar .'%')->orderBy('id_nomina', 'DESC')->paginate(10);

        }
        return [
            'pagination' => [
                'total'        =>$nominas->total(),
                'current_page' =>$nominas->currentPage(),
                'per_page'     =>$nominas->perPage(),
                'last_page'    =>$nominas->lastPage(),
                'from'         =>$nominas->firstItem(),
                'to'           =>$nominas->lastItem(),
            ],
            'nominas' => $nominas
        ];


    }
    public function selectNomina(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $nominas = Nomina::where('condicion', '=', '1')
        ->select('codigo', 'nombre')->orderBy('nombre', 'asc')->get();
        return ['nominas' => $nominas];
    }

    
    public function store(Request $request)
    {

    if(!$request->ajax()) return redirect('/');
        $nomina = new Nomina();
        $nomina->codigo = $request->codigo;
        $nomina->nombre = $request->nombre;
        $nomina->descripcion = $request->descripcion;
        $nomina->condicion = '1';

        $nomina->save();


    }

    
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $nomina = Nomina::findORFail($request->id_nomina);
        $nomina->codigo = $request->codigo;
        $nomina->nombre = $request->nombre;
        $nomina->descripcion = $request->descripcion;
        $nomina->condicion = '1';

        $nomina->save();
        
    }

    public function desactivar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $nomina = Nomina::findORFail($request->id_nomina);
        $nomina->condicion = '0';

        $nomina->save(); 
    }

    public function activar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $nomina = Nomina::findORFail($request->id_nomina);
        $nomina->condicion = '1';

        $nomina->save(); 
    }
}
