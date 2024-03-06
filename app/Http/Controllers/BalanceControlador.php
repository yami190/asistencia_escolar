<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movimiento;
use App\Nomina;
Use DB;

class BalanceControlador extends Controller
{
     public function index(Request $request)
    {
        $gremio = $request->gremio;
        //$nomhasta = $request->hasta;
        $mes = $request->mes;

      $balance = Movimiento::
        select('movimientos.mes',
            \DB::raw('SUM(apor_ahorro) as ahorro'),
            \DB::raw('SUM(apor_presta) as prestamos'),
            \DB::raw('SUM(seguro) as seguro'))
        ->join('socios', 'socios.cedula', '=', 'movimientos.cedula')
        //->whereBetween('socios.codigo', [$nomdesde, $nomhasta])
         ->where('movimientos.codigo', $gremio)
        ->where('movimientos.mes', $mes)
        ->where('movimientos.ano', '2021')
        ->groupBy('mes')
        ->get();


            return ['balance' => $balance];
          //  return $balance;

  //   $query = "SELECT SUM(apor_ahorro) FROM movimientos
    //    INNER join socios on socios.cedula = movimientos.cedula
    //    where mes = 'junio' and ano = '2021' and socios.codigo = 30"
   // $movimiento = DB::select($query)->get();

    }

     public function porrango(Request $request)
    {

        $gmes = $request->gmes;
        $gmes2 = $request->gmes2;
        $gremio = $request->gremio;
        $gano = $request->gano;

        //return $request;
        $balance = Movimiento::
        select('mes.mes', 'movimientos.ano', 'nominas.gremio',
            \DB::raw('count(*) as filas'),
            \DB::raw('SUM(apor_ahorro) as ahorro'),
            \DB::raw('SUM(apor_presta) as prestamos'),
            \DB::raw('SUM(seguro) as seguro'))
        ->join('socios', 'socios.cedula', '=', 'movimientos.cedula')
        ->join('nominas', 'socios.codigo', '=', 'nominas.codigo')
        ->join('mes', 'mes.id_mes', '=', 'movimientos.mes')
        ->where('nominas.gremio', $gremio)
        ->whereBetween('movimientos.mes', [$gmes, $gmes2])
        ->where('movimientos.ano', $gano)
        ->groupBy('movimientos.mes', 'mes.mes', 'movimientos.ano', 'nominas.gremio')
        ->get();


            return ['balance' => $balance];

    }
     public function porrangosud(Request $request)
    {

        $mes = $request->mes;
        $mes2 = $request->mes2;
        $sud_gremio = $request->sud_gremio;
        $ano = $request->ano;
       // $codigohasta = $request->codigohasta;

        $balancedos = Movimiento::
        select('nominas.sud_gremio', 'mes.mes', 'movimientos.ano',
            \DB::raw('count(*) as filas'),
            \DB::raw('SUM(apor_ahorro) as ahorro'),
            \DB::raw('SUM(apor_presta) as prestamos'),
            \DB::raw('SUM(seguro) as seguro'))
        ->join('socios', 'socios.cedula', '=', 'movimientos.cedula')
        ->join('nominas', 'socios.codigo', '=', 'nominas.codigo')
        ->join('mes', 'mes.id_mes', '=', 'movimientos.mes')
       ->where('nominas.sud_gremio', $sud_gremio)
        ->whereBetween('movimientos.mes', [$mes, $mes2])
        ->where('movimientos.ano', $ano)
        ->groupBy('movimientos.mes', 'mes.mes', 'movimientos.ano', 'nominas.sud_gremio')
        ->orderby('movimientos.mes', 'ASC')
        ->get();


            return ['balancedos' => $balancedos];
           //return view('balance_reporte', ['balance' => $balance]);

  //   $query = "SELECT SUM(apor_ahorro) FROM movimientos
        //      INNER join balance on socios.cedula = movimientos.cedula
        //      where mes = 'junio' and ano = '2021' and socios.codigo = 30"
     // $movimiento = DB::select($query)->get();

    }

    public function nomina_goberna(Request $request)
    {

        $nomina = Nomina::select('codigo','nombre as nomina')
        ->get();

        return $nomina;
        

    }
    public function compare(Request $request)
    {

        $mes = $request->mes;
        $mes2 = $request->mes2;
        $sud_gremio = $request->sud_gremio;
        $ano = $request->ano;
       // $codigohasta = $request->codigohasta;

        $compare = Movimiento::
        select( 'movimientos.cedulas', 'nominas.sud_gremio', 'mes.mes', 'movimientos.ano')
        ->join('socios', 'socios.cedula', '=', 'movimientos.cedula')
        ->join('nominas', 'socios.codigo', '=', 'nominas.codigo')
        ->join('mes', 'mes.id_mes', '=', 'movimientos.mes')
       ->where('nominas.sud_gremio', $sud_gremio)
        ->whereBetween('movimientos.mes', [$mes, $mes2])
        ->where('movimientos.ano', $ano)
        //->groupBy('movimientos.mes', 'mes.mes', 'movimientos.ano', 'nominas.sud_gremio')
        ->orderby('movimientos.mes', 'ASC')
        ->get();


            return ['compare' => $compare];
           //return view('balance_reporte', ['balance' => $balance]);

  //   $query = "SELECT SUM(apor_ahorro) FROM movimientos
        //      INNER join balance on socios.cedula = movimientos.cedula
        //      where mes = 'junio' and ano = '2021' and socios.codigo = 30"
     // $movimiento = DB::select($query)->get();

    }
}
