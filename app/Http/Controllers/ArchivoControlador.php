<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Archivo;
use App\Socio;
use App\Liquidacion;

class ArchivoControlador extends Controller
{
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

            $katiuska = Archivo::join('socios', 'archivo.cedula', '=', 'socios.cedula')
            ->join('nominas', 'socios.codigo', '=', 'nominas.codigo')
            ->select('archivo.id_archivo', 'socios.nombres', 'archivo.cedula', 'nominas.codigo', 'nominas.nombre as nomina', 'archivo.fecha_entrega')
            ->where('id_personal', '1')
            ->where('estatus', '1')
            ->orderBy('id_archivo', 'asc')
            ->get();
            $eudis = Archivo::join('socios', 'archivo.cedula', '=', 'socios.cedula')
            ->join('nominas', 'socios.codigo', '=', 'nominas.codigo')
            ->select('archivo.id_archivo', 'socios.nombres', 'archivo.cedula', 'nominas.codigo', 'nominas.nombre as nomina', 'archivo.fecha_entrega')
            ->where('id_personal', '2')
            ->where('estatus', '1')
            ->orderBy('id_archivo', 'asc')
            ->get();
            $eucar = Archivo::join('socios', 'archivo.cedula', '=', 'socios.cedula')
            ->join('nominas', 'socios.codigo', '=', 'nominas.codigo')
            ->select('archivo.id_archivo', 'socios.nombres', 'archivo.cedula', 'nominas.codigo', 'nominas.nombre as nomina', 'archivo.fecha_entrega')
            ->where('id_personal', '25')
            ->where('estatus', '1')
            ->orderBy('id_archivo', 'asc')
            ->get();
            $karla = Archivo::join('socios', 'archivo.cedula', '=', 'socios.cedula')
            ->join('nominas', 'socios.codigo', '=', 'nominas.codigo')
            ->select('archivo.id_archivo', 'socios.nombres', 'archivo.cedula', 'nominas.codigo', 'nominas.nombre as nomina', 'archivo.fecha_entrega')
            ->where('id_personal', '3')
            ->where('estatus', '1')
            ->orderBy('id_archivo', 'asc')
            ->get();
            $jhanfri = Archivo::join('socios', 'archivo.cedula', '=', 'socios.cedula')
            ->join('nominas', 'socios.codigo', '=', 'nominas.codigo')
            ->select('archivo.id_archivo', 'socios.nombres', 'archivo.cedula', 'nominas.codigo', 'nominas.nombre as nomina', 'archivo.fecha_entrega')
            ->where('id_personal', '13')
            ->where('estatus', '1')
            ->orderBy('id_archivo', 'asc')
            ->get();
            $susana = Archivo::join('socios', 'archivo.cedula', '=', 'socios.cedula')
            ->join('nominas', 'socios.codigo', '=', 'nominas.codigo')
            ->select('archivo.id_archivo', 'socios.nombres', 'archivo.cedula', 'nominas.codigo', 'nominas.nombre as nomina', 'archivo.fecha_entrega')
            ->where('id_personal', '6')
            ->where('estatus', '1')
            ->orderBy('id_archivo', 'asc')
            ->get();
            $daijanis = Archivo::join('socios', 'archivo.cedula', '=', 'socios.cedula')
            ->join('nominas', 'socios.codigo', '=', 'nominas.codigo')
            ->select('archivo.id_archivo', 'socios.nombres', 'archivo.cedula', 'nominas.codigo', 'nominas.nombre as nomina', 'archivo.fecha_entrega')
            ->where('id_personal', '23')
            ->where('estatus', '1')
            ->orderBy('id_archivo', 'asc')
            ->get();
            $julio = Archivo::join('socios', 'archivo.cedula', '=', 'socios.cedula')
            ->join('nominas', 'socios.codigo', '=', 'nominas.codigo')
            ->select('archivo.id_archivo', 'socios.nombres', 'archivo.cedula', 'nominas.codigo', 'nominas.nombre as nomina', 'archivo.fecha_entrega')
            ->where('id_personal', '24')
            ->where('estatus', '1')
            ->orderBy('id_archivo', 'asc')
            ->get();
            $basanta = Archivo::join('socios', 'archivo.cedula', '=', 'socios.cedula')
            ->join('nominas', 'socios.codigo', '=', 'nominas.codigo')
            ->select('archivo.id_archivo', 'socios.nombres', 'archivo.cedula', 'nominas.codigo', 'nominas.nombre as nomina', 'archivo.fecha_entrega')
            ->where('id_personal', '20')
            ->where('estatus', '1')
            ->orderBy('id_archivo', 'asc')
            ->get();
            $josmel = Archivo::join('socios', 'archivo.cedula', '=', 'socios.cedula')
            ->join('nominas', 'socios.codigo', '=', 'nominas.codigo')
            ->select('archivo.id_archivo', 'socios.nombres', 'archivo.cedula', 'nominas.codigo', 'nominas.nombre as nomina', 'archivo.fecha_entrega')
            ->where('id_personal', '26')
            ->where('estatus', '1')
            ->orderBy('id_archivo', 'asc')
            ->get();

        return ['katiuska' => $katiuska, '$eudis'=> $eudis, 'eudis'=> $eudis, 'eucar'=> $eucar, 'karla'=> $karla, 'jhanfri'=> $jhanfri, 'susana'=> $susana, 'daijanis'=> $daijanis, 'julio'=> $julio, 'basanta'=> $basanta, 'josmel'=> $josmel];
    }

    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
            $request->validate([
                'cedula' => 'required',
                //'nombres' => 'required',
                'fecha_entrega' => 'required'
                // 'monto' => 'required',
                // 'descuento' => 'required',
                // 'frecuencia' => 'required',
                // 'cuotas' => 'required',
            ]);
        $archivo = new Archivo();
        $archivo->cedula = $request->cedula;
        $archivo->id_personal = $request->id_personal;
        $archivo->fecha_entrega = $request->fecha_entrega;
        $archivo->estatus = '1';

        $archivo->save();
    }

    public function archivossocios(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

            $cedula = $request->cedula;

            $archivosocio = Socio::join('nominas','socios.codigo','=','nominas.codigo')
            ->leftjoin('archivo','archivo.cedula','=','socios.cedula')
            ->leftjoin('personal_caja','personal_caja.id_personal','=','archivo.id_personal')
            ->select('socios.id_socio', 'socios.cedula', 'socios.nombres', 'socios.codigo', 'nominas.nombre as nomina', 'archivo.id_personal','archivo.fecha_entrega', 'personal_caja.nombre', 'archivo.id_archivo')
            ->where('socios.cedula', '=', $cedula)
            ->take(1)->get();

        return ['archivosocio' => $archivosocio];

    }

    public function eliminar (Request $request){
        if(!$request->ajax()) return redirect('/');
        $archivo = Archivo::findORFail($request->id_archivo);
        $archivo->delete();
    }

    public function listaliqui(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

            $liquidacionestotales = Liquidacion::join('socios', 'liquidaciones.cedula', '=', 'socios.cedula')
            ->join('nominas', 'socios.codigo', '=', 'nominas.codigo')
            ->select('liquidaciones.id_liquidacion', 'socios.nombres', 'liquidaciones.cedula', 'nominas.codigo', 'nominas.nombre as nomina', 'liquidaciones.fecha_liquidacion', 'liquidaciones.monto', 'liquidaciones.observacion')
            ->where('estatus', 'LIQUIDACION')
            ->orderBy('id_liquidacion', 'asc')
            ->get();
            $fallecidostotales = Liquidacion::join('socios', 'liquidaciones.cedula', '=', 'socios.cedula')
            ->join('nominas', 'socios.codigo', '=', 'nominas.codigo')
            ->select('liquidaciones.id_liquidacion', 'socios.nombres', 'liquidaciones.cedula', 'nominas.codigo', 'nominas.nombre as nomina', 'liquidaciones.fecha_liquidacion', 'liquidaciones.monto', 'liquidaciones.observacion')
            ->where('estatus', 'FALLECIDO')
            ->orderBy('id_liquidacion', 'asc')
            ->get();
            $jubiladostotales = Liquidacion::join('socios', 'liquidaciones.cedula', '=', 'socios.cedula')
            ->join('nominas', 'socios.codigo', '=', 'nominas.codigo')
            ->select('liquidaciones.id_liquidacion', 'socios.nombres', 'liquidaciones.cedula', 'nominas.codigo', 'nominas.nombre as nomina', 'liquidaciones.fecha_liquidacion', 'liquidaciones.monto', 'liquidaciones.observacion')
            ->where('estatus', 'JUBILADOS')
            ->orderBy('id_liquidacion', 'asc')
            ->get();
        return ['liquidacionestotales' => $liquidacionestotales, 'fallecidostotales'=> $fallecidostotales, 'jubiladostotales'=> $jubiladostotales];
    }

    public function liquidacionsocio (Request $request){

        $cedula = $request->cedula;

        $liquidacion = Socio::join('nominas','socios.codigo','=','nominas.codigo')
            ->leftjoin('liquidaciones','liquidaciones.cedula','=','socios.cedula')
            //->leftjoin('personal_caja','personal_caja.id_personal','=','archivo.id_personal')
            ->select('socios.id_socio', 'socios.cedula', 'socios.nombres', 'socios.codigo', 'nominas.nombre as nomina', 'liquidaciones.id_liquidacion', 'liquidaciones.monto', 'liquidaciones.fecha_liquidacion', 'liquidaciones.fecha_liquidacion', 'liquidaciones.estatus', 'liquidaciones.observacion')
            ->where('socios.cedula', '=', $cedula)
            ->take(1)->get();

            return ['liquidacion' => $liquidacion];
    }

    public function saveliquisocio (Request $request){

        if(!$request->ajax()) return redirect('/');

            $request->validate([
                'cedula' => 'required',
                'monto' => 'required',
                'fecha_liquidacion' => 'required',
                'estatus' => 'required'
            ]);

        $liquidacion = new Liquidacion();
        $liquidacion->cedula = $request->cedula;
        $liquidacion->monto = $request->monto;
        $liquidacion->fecha_liquidacion = $request->fecha_liquidacion;
        $liquidacion->estatus = $request->estatus;

        $liquidacion->save();
    }

    public function eliminarliqui (Request $request){
        if(!$request->ajax()) return redirect('/');
        $liquidado = Liquidacion::findORFail($request->id_liquidacion);
        $liquidado->delete();
    }
}

