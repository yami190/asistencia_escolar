<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SociosExport;
use App\Exports\NomCuentaBanco;
use App\Imports\SocioMov;
use App\Movimiento;
use App\Mov_temp;

class NominasSociosController extends Controller
{

   public function expsociomov(){

        return Excel::download(new SociosExport, 'Socios-List.xlsx');
   }

   public function impsociomov(Request $request){

      
     $file = $request->file('file');
    Excel::import(new SocioMov, $file);

    return back()->with('menssage', 'Importacion completada');
    //return 'Exito';

   }

   public function ExpSociCuen(Request $request){

      $ncuenta = $request->ncuenta;
      $mes = $request->mes;

      return Excel::download(new NomCuentaBanco($ncuenta, $mes), 'Socios-List.xlsx');
   }

   public function bancoBicentenario(Request $request)
   {
      $bicentenario = Movimiento::select('movimientos.mes',
            \DB::raw('SUM(apor_ahorro) as ahorro'),
            \DB::raw('SUM(apor_presta) as prestamos'),
            \DB::raw('SUM(seguro) as seguro'))
            ->join('cuentas', 'cuentas.cedula', '=', 'movimientos.cedula')
            ->where('movimientos.mes', 8)
            ->where('movimientos.ano', '2022')
            ->where('cuentas.ncuenta', 'like', '0175%')
            ->groupBy('mes')
            ->get();
      return ['bicentenario' => $bicentenario];
   }

    public function bancosCaroni(Request $request)
   {
     
      $caroni = Movimiento::select('movimientos.mes',
            \DB::raw('SUM(apor_ahorro) as ahorro'),
            \DB::raw('SUM(apor_presta) as prestamos'),
            \DB::raw('SUM(seguro) as seguro'))
            ->join('cuentas', 'cuentas.cedula', '=', 'movimientos.cedula')
            ->where('movimientos.mes', 8)
            ->where('movimientos.ano', '2022')
            ->where('cuentas.ncuenta', 'like', '0128%')
            ->groupBy('mes')
            ->get();
      return ['caroni' => $caroni];
   }

   public function bancosVenezuela(Request $request)
   {
     
      $venezuela = Movimiento::select('movimientos.mes',
            \DB::raw('SUM(apor_ahorro) as ahorro'),
            \DB::raw('SUM(apor_presta) as prestamos'),
            \DB::raw('SUM(seguro) as seguro'))
            ->join('cuentas', 'cuentas.cedula', '=', 'movimientos.cedula')
            ->where('movimientos.mes', 8)
            ->where('movimientos.ano', '2022')
            ->where('cuentas.ncuenta', 'like', '0102%')
            ->groupBy('mes')
            ->get();
      return ['venezuela' => $venezuela];
   }
}
