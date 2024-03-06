<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cuenta;

class CuentasControlador extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function cuentasSocios(Request $request)
    {
    //if (!$request->ajax()) return redirect('/');

       $cedula = $request->cedula;

            $cuentas = Cuenta::join('socios', 'cuentas.cedula', '=', 'socios.cedula')
            ->join('nominas', 'socios.codigo', '=', 'nominas.codigo')
            ->select('cuentas.id_cuenta','socios.nombres', 'cuentas.cedula','nominas.nombre as nomina', 'socios.codigo','cuentas.ncuenta', 'cuentas.banco', 'cuentas.condicion')
            ->where('socios.cedula', '=', $cedula)
            ->take(5)->get();
        
        return ['cuentas' => $cuentas];

    }
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if($buscar==''){

            $cuentas = Cuenta::join('socios', 'cuentas.cedula', '=', 'socios.cedula')
            ->join('nominas', 'socios.codigo', '=', 'nominas.codigo')
            ->select('cuentas.id_cuenta','socios.nombres', 'cuentas.cedula','nominas.nombre as nom_nomina', 'socios.codigo','cuentas.ncuenta', 'cuentas.banco', 'cuentas.condicion')
            ->orderBy('id_cuenta', 'ASC')->paginate(10);

        }

        else {

            $cuentas = Cuenta::join('socios', 'cuentas.cedula', '=', 'socios.cedula')
            ->join('nominas', 'socios.codigo', '=', 'nominas.codigo')
            ->select('cuentas.id_cuenta','socios.nombres', 'cuentas.cedula','nominas.nombre as nom_nomina', 'socios.codigo','cuentas.ncuenta', 'cuentas.banco', 'cuentas.condicion')
            ->where('socios.'.$criterio, 'like', '%'. $buscar .'%')
             ->orderBy('id_cuenta', 'ASC')->paginate(10);

        }
        return [
            'pagination' => [
                'total'        =>$cuentas->total(),
                'current_page' =>$cuentas->currentPage(),
                'per_page'     =>$cuentas->perPage(),
                'last_page'    =>$cuentas->lastPage(),
                'from'         =>$cuentas->firstItem(),
                'to'           =>$cuentas->lastItem(),
            ],
            'cuentas' => $cuentas
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
