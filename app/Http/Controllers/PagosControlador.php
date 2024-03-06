<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pago;

class PagosControlador extends Controller
{
    public function index(Request $request)
    {
         // if(!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if($buscar==''){

            $pagos = Pago::join('socios', 'pagos.id_socio', '=', 'socios.id_socio')
            ->join('nominas', 'socios.codigo', '=', 'nominas.codigo')
            ->select('pagos.banco_analista','socios.nombres', 'socios.cedula','nominas.nombre as nom_nomina', 'pagos.monto_socio','pagos.refrecibida', 'pagos.fecharecibido', 'pagos.id_analista')
            ->orderBy('id_pagos', 'ASC')->paginate(10);

        }

        else {

            // $pagos = Pagos::join('socios', 'cuentas.cedula', '=', 'socios.cedula')
            // ->join('nominas', 'socios.codigo', '=', 'nominas.codigo')
            // ->select('cuentas.id_cuenta','socios.nombres', 'cuentas.cedula','nominas.nombre as nom_nomina', 'socios.codigo','cuentas.ncuenta', 'cuentas.banco', 'cuentas.condicion')
            // ->where('socios.'.$criterio, 'like', '%'. $buscar .'%')
            //  ->orderBy('id_cuenta', 'ASC')->paginate(10);

        }
        return [
            'pagination' => [
                'total'        =>$pagos->total(),
                'current_page' =>$pagos->currentPage(),
                'per_page'     =>$pagos->perPage(),
                'last_page'    =>$pagos->lastPage(),
                'from'         =>$pagos->firstItem(),
                'to'           =>$pagos->lastItem(),
            ],
            'pagos' => $pagos
        ];
    }
}
