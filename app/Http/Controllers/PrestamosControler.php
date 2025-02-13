<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\carbon;
use App\Presta_temp;
use App\Socio;
use App\Cuota;
use DB;

class PrestamosControler extends Controller
{
    public function index(Request $request)
    {
    if (!$request->ajax()) return redirect('/');

       $temp_presta = Presta_temp::leftjoin('socios','presta_temp.cedula','=','socios.cedula')
            ->leftjoin('nominas','socios.codigo','=','nominas.codigo')
            ->select('presta_temp.id_prestamo','presta_temp.cedula', 'socios.nombres','nominas.nombre as nomina', 
            'presta_temp.monto', 'presta_temp.descuento', 'presta_temp.frecuencia', 'presta_temp.cuotas', 
            'presta_temp.fecha_registro', 'presta_temp.estatus', 'presta_temp.observacion')
            ->orderBy('presta_temp.id_prestamo', 'desc')->paginate(12);
        
        return ['temp_presta' => $temp_presta];

    }

    public function EstadoPresta(Request $request)
    {
    //if (!$request->ajax()) return redirect('/');
        $ano = Carbon::now();
        $ano = $ano->format('Y');
        $cedula = $request->cedula;

            $socio = Socio::join('nominas','socios.codigo','=','nominas.codigo')
            ->join('movimientos','socios.cedula','=','movimientos.cedula')
            ->leftjoin('histo_presta','socios.cedula','=','histo_presta.cedula')
            ->select('socios.cedula', 'socios.nombres','nominas.nombre as nomina',
            'histo_presta.monto')
            ->where('socios.cedula', '=', $cedula)
            ->where('movimientos.ano', '=', $ano)
            ->take(1)->get();
        
        return ['socio' => $socio];

    }
    public function store(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');
        
        $request->validate([
            'cedula' => 'required',
            'nombres' => 'required',
            'monto' => 'required',
            'descuento' => 'required',
            'frecuencia' => 'required',
            'cuotas' => 'required',
        ]);
            $mytime= Carbon::now('America/Caracas');
            //return $request;
            $prestatemp = new Presta_temp();
            $prestatemp->cedula = $request->cedula;
            // $prestatemp->id_usuario = \Auth::user()->id;
            $prestatemp->monto = $request->monto;
            $prestatemp->descuento = $request->descuento;
            $prestatemp->fecha_registro = $mytime->toDateString();
            $prestatemp->frecuencia = $request->frecuencia;
            $prestatemp->cuotas = $request->cuotas;
            $prestatemp->observacion = $request->observacion;

            $prestatemp->save();     
    }

    public function procesarpres(){

        $sql = "INSERT INTO histo_presta
                 (cedula, monto, descuento, frecuencia, cuotas, fecha_registro)
                SELECT
                   cedula, monto, descuento, frecuencia, cuotas, fecha_registro
                FROM
                presta_temp;
                ";

        $query_result = DB::select($sql);

        Presta_temp::truncate();
    }

    public function exporpdf(Request $request){

        $sociospresta = Presta_temp::get();
        $pdf = PDF::loadView('prestamospdf.presejepdf', compact('sociospresta'));

        return $pdf->download('prestamos_ejecutados.pdf');
    }
   
}
