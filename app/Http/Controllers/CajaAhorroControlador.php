<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Personal_caja;
use App\Nomina_caja;

class CajaAhorroControlador extends Controller
{
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if($buscar==''){

            $cajaahorro = Personal_caja::join('nomina_caja', 'nomina_caja.id_personal', '=', 'personal_caja.id_personal')
            //->join('nominas', 'nomina_caja.codigo', '=', 'nominas.codigo')
            ->join('mes', 'mes.id_mes', '=', 'nomina_caja.id_mes')
            ->select('nomina_caja.id_nominaca','personal_caja.cedula', 'personal_caja.nombre','nomina_caja.ahor_socio_caja','nomina_caja.cuota_presta', 'nomina_caja.id_mes', 'nomina_caja.ano','mes.mes', 'personal_caja.condicion')
            ->orderBy('id_nominaca', 'ASC')->paginate(12);

            $calcular = Nomina_caja::select(\DB::raw('SUM(ahor_socio_caja) as ahorro'))
            //        \DB::raw('SUM(apor_presta) as prestamos'),
            //        \DB::raw('SUM(seguro) as seguro'))
            ->join('personal_caja', 'nomina_caja.id_personal', '=', 'personal_caja.id_personal')
            ->where('personal_caja.'.$criterio, 'like', '%'. $buscar .'%')
            ->get();

        }else {

            $cajaahorro = Personal_caja::join('nomina_caja', 'nomina_caja.id_personal', '=', 'personal_caja.id_personal')
            //->join('nominas', 'nomina_caja.codigo', '=', 'nominas.codigo')
            ->join('mes', 'mes.id_mes', '=', 'nomina_caja.id_mes')
            ->select('personal_caja.id_personal','personal_caja.cedula', 'personal_caja.nombre','nomina_caja.ahor_socio_caja','nomina_caja.cuota_presta', 'nomina_caja.id_mes', 'nomina_caja.ano','mes.mes', 'personal_caja.condicion')
            ->where('personal_caja.'.$criterio, 'like', '%'. $buscar .'%')
            ->orderBy('id_personal', 'ASC')->paginate(12);

            $calcular = Nomina_caja::select(\DB::raw('SUM(ahor_socio_caja) as ahorro'))
            //        \DB::raw('SUM(apor_presta) as prestamos'),
            //        \DB::raw('SUM(seguro) as seguro'))
            ->join('personal_caja', 'nomina_caja.id_personal', '=', 'personal_caja.id_personal')
            ->where('personal_caja.'.$criterio, 'like', '%'. $buscar .'%')
            ->get();

        //    $calcular = Movimiento::
        // select(\DB::raw('SUM(apor_ahorro) as ahorro'),
        //        \DB::raw('SUM(apor_presta) as prestamos'),
        //        \DB::raw('SUM(seguro) as seguro'))
        // ->join('socios', 'socios.cedula', '=', 'Personal_caja.cedula')
        // ->where('socios.'.$criterio, 'like', '%'. $buscar .'%')
        //     ->get();

            //return ;

            // $totalsocio = DB::table("Personal_caja")->select(DB::Raw("apor_ahorro as total"))->where($criterio, 'like', '%'. $buscar .'%');
            //return $totalsocio;
        }
        return [
            'pagination' => [
                'total'        =>$cajaahorro->total(),
                'current_page' =>$cajaahorro->currentPage(),
                'per_page'     =>$cajaahorro->perPage(),
                'last_page'    =>$cajaahorro->lastPage(),
                'from'         =>$cajaahorro->firstItem(),
                'to'           =>$cajaahorro->lastItem(),
            ],
            'cajaahorro' => $cajaahorro, 'calcular' => $calcular,
        ];
    }
}
