<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transferencia;

class TransferenciasControlador extends Controller
{
    public function index(Request $request)
    {
         // if(!$request->ajax()) return redirect('/');

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
}
