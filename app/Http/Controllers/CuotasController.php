<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\carbon;
use DB;
use App\Cuotas;
use App\Presta_temp;
use App\Socio;


class CuotasController extends Controller
{

    public function index(Request $request)
    {
        $cedula = $request->cedula;
        $cuotas = Cuotas::where('cedula', '=', $cedula)->get();
        return ['cuotas' => $cuotas];
       
    }
    public function aperturarPresta(Request $request)
    {
         if (!$request->ajax()) return redirect('/');

        
            $mytime= Carbon::now('America/Caracas');
            $cuotas = new Cuotas();
            $cuotas->cedula = $request->cedula;
            $cuotas->referencia = $request->referencia;
            $cuotas->montop = $request->montop;
            $cuotas->fecha = $request->fecha;
            $cuotas->save();
            return 'exito';     
    }

    public function prestamos(Request $request)
    {
        $cedula = $request->cedula;
        $prestamos = Socio::join('nominas', 'socios.codigo', '=', 'nominas.codigo')
            ->join('presta_temp', 'socios.cedula', '=', 'presta_temp.cedula')
            ->join('cuotas', 'presta_temp.cedula', '=', 'cuotas.cedula')
            ->select(
                'presta_temp.cedula',
                'socios.nombres',
                'nominas.nombre as nomina',
                'presta_temp.monto as prestamo',
                DB::raw("TO_CHAR(presta_temp.fecha_registro, 'DD-MM-YYYY') as fechad"),
                //'presta_temp.fecha_registro as fechad',
                DB::raw('SUM(cuotas.montop) as pago'), // Sumar montop
                'presta_temp.estatus'
            )
            ->where('presta_temp.cedula', '=', $cedula)
            ->groupBy(
                'presta_temp.cedula',
                'socios.nombres',
                'nominas.nombre',
                'presta_temp.monto',
                'presta_temp.fecha_registro',
                'presta_temp.estatus'
            )
            ->get();

        return ['prestamos' => $prestamos];
    }
    public function eliminarcuota(Request $request)
    {
        $id_cuota = $request->id_cuota;
        $cuota = Cuotas::find($id_cuota); // Busca el registro por su ID

        if ($cuota) {
            $cuota->delete(); // Elimina el registro
        }

    }
}
