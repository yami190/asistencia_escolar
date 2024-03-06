<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Socio;
use App\Movimiento;
use Carbon\Carbon;

class MovimientosControlador extends Controller
{
    public function estadocuenta(Request $request)
    {
    if (!$request->ajax()) return redirect('/');

       $cedula = $request->cedula;

            $socio = Socio::join('nominas','socios.codigo','=','nominas.codigo')
            ->select('socios.cedula', 'socios.nombres','nominas.nombre as nomina', 'socios.condicion')
            ->where('socios.cedula', '=', $cedula)
            ->take(1)->get();
        
        return ['socio' => $socio];

    }
     public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if($buscar==''){

            $socios = Socio::join('movimientos', 'socios.cedula', '=', 'movimientos.cedula')
            ->join('nominas', 'socios.codigo', '=', 'nominas.codigo')
            ->join('mes', 'mes.id_mes', '=', 'movimientos.mes')
            ->select('movimientos.id_movimiento','socios.cedula','socios.nombres','movimientos.apor_ahorro','nominas.nombre as nom_nomina','movimientos.apor_presta','movimientos.seguro','mes.mes','movimientos.ano', 'socios.condicion')
            ->orderBy('id_socio', 'ASC')->paginate(12);

            $calcular = Movimiento::
        select(\DB::raw('SUM(apor_ahorro) as ahorro'),
               \DB::raw('SUM(apor_presta) as prestamos'),
               \DB::raw('SUM(seguro) as seguro'))
        ->join('socios', 'socios.cedula', '=', 'movimientos.cedula')
        ->where('socios.'.$criterio, 'like', '%'. $buscar .'%')
            ->get();

        }

        else {

            $socios = Socio::join('movimientos', 'socios.cedula', '=', 'movimientos.cedula')
            ->join('nominas', 'socios.codigo', '=', 'nominas.codigo')
            ->join('mes', 'mes.id_mes', '=', 'movimientos.mes')
            ->select('movimientos.id_movimiento','socios.cedula','socios.nombres','movimientos.apor_ahorro','nominas.nombre as nom_nomina','movimientos.apor_presta','movimientos.seguro','mes.mes','movimientos.ano', 'socios.condicion')
            ->where('socios.'.$criterio, 'like', '%'. $buscar .'%')
            ->orderBy('id_movimiento', 'ASC')->paginate(12);

           $calcular = Movimiento::
        select(\DB::raw('SUM(apor_ahorro) as ahorro'),
               \DB::raw('SUM(apor_presta) as prestamos'),
               \DB::raw('SUM(seguro) as seguro'))
        ->join('socios', 'socios.cedula', '=', 'movimientos.cedula')
        ->where('socios.'.$criterio, 'like', '%'. $buscar .'%')
            ->get();
        }
        return [
            'pagination' => [
                'total'        =>$socios->total(),
                'current_page' =>$socios->currentPage(),
                'per_page'     =>$socios->perPage(),
                'last_page'    =>$socios->lastPage(),
                'from'         =>$socios->firstItem(),
                'to'           =>$socios->lastItem(),
            ],
            'socios' => $socios, 'calcular' => $calcular,
        ];
    }


     public function buscarsoocio(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $date = Carbon::now();
        $date = $date->format('Y');

        $cedula = $request->cedula;

            $socioslista = Movimiento::join('mes', 'mes.id_mes', '=', 'movimientos.mes')
            ->select('movimientos.apor_ahorro','movimientos.apor_presta','movimientos.seguro','mes.mes','movimientos.ano')
            ->where('movimientos.cedula', $cedula)
            ->where('movimientos.ano', 2024)
            ->orderBy('id_movimiento', 'ASC')->paginate(12);
        return [
            'socioslista' => $socioslista
        ];
    }
     public function sumasoocio(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $cedula = $request->cedula;

             $calcularsocio = Movimiento::
        select(\DB::raw('SUM(apor_ahorro) as ahorro'),
               'prestamos_isp.monto_pag', 'prestamos_isp.prestamos',
               \DB::raw('SUM(seguro) as seguro'))
        ->join('socios', 'socios.cedula', '=', 'movimientos.cedula')
        ->leftjoin('prestamos_isp', 'movimientos.cedula', '=', 'prestamos_isp.cedula')
        ->where('socios.cedula', $cedula)
        ->groupBy('prestamos_isp.monto_pag','prestamos_isp.prestamos',)->get();

        return [
            'calcularsocio' => $calcularsocio
        ];
    }

    public function historicosicio(Request $request)
    {

        if(!$request->ajax()) return redirect('/');

        $date = Carbon::now();
        $date = $date->subYear();

        $cedula = $request->cedula;

        $historico = Movimiento::join('mes', 'mes.id_mes', '=', 'movimientos.mes')
        ->select('movimientos.id_movimiento','movimientos.apor_ahorro','movimientos.apor_presta','movimientos.seguro','mes.mes','movimientos.ano')
        ->where('movimientos.cedula', $cedula)
        //->where('movimientos.ano', $date)
        ->whereBetween('movimientos.ano', [2019, $date])
        ->orderBy('id_movimiento', 'desc')->paginate(12);

        return [
            'pagination' => [
                'total'        =>$historico->total(),
                'current_page' =>$historico->currentPage(),
                'per_page'     =>$historico->perPage(),
                'last_page'    =>$historico->lastPage(),
                'from'         =>$historico->firstItem(),
                'to'           =>$historico->lastItem(),
            ],
            'historico' => $historico
        ];

    }

     public function calcupresta(Request $request)
    {
   /* if (!$request->ajax()) return redirect('/'); */

       $cedula = $request->cedula;
       $dmes = $request->dmes;
       $hmes = $request->hmes;
       $dano = $request->dano;
       $hano = $request->hano;

       $totalp =   Movimiento::
        select('apor_presta', 'mes')
        ->where('cedula', $cedula)
        ->whereBetween('mes', [$dmes, $hmes])
        ->whereBetween('ano', [$dano, $hano])
        //->groupBy('prestamos_isp.monto_pag','prestamos_isp.prestamos',)
        ->get();
 
        return ['totalp' => $totalp];
      // return $request;

    }
}

