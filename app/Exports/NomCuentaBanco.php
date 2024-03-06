<?php

namespace App\Exports;

use App\Cuenta;
use App\Movimiento;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class NomCuentaBanco implements FromView
{
    protected $ncuenta;
    protected $mes;

 function __construct($ncuenta, $mes) {
        $this->ncuenta = $ncuenta;
        $this->mes = $mes;
 }

    public function view(): View
    {
        return view('exports.nomianSocio', [
            'cuentas' => Cuenta::join('socios', 'cuentas.cedula', '=', 'socios.cedula')
            ->join('movimientos', 'socios.cedula', '=', 'movimientos.cedula')
            ->select('movimientos.apor_ahorro','movimientos.apor_presta','movimientos.seguro', 'cuentas.ncuenta','cuentas.cedula')
            ->where('movimientos.mes', $this->mes)
            ->where('movimientos.ano', '2022')
            ->where('cuentas.ncuenta', 'like', $this->ncuenta.'%')
            ->get(), 'sumas' => Movimiento::select('movimientos.mes',
            \DB::raw('SUM(apor_ahorro) as ahorro'),
            \DB::raw('SUM(apor_presta) as prestamos'),
            \DB::raw('SUM(seguro) as seguro'))
            ->join('cuentas', 'cuentas.cedula', '=', 'movimientos.cedula')
            ->where('movimientos.mes', $this->mes)
            ->where('movimientos.ano', '2022')
            ->where('cuentas.ncuenta', $this->ncuenta.'%')
            ->groupBy('mes')
            ->get();
        ]);


        // return Cuenta::join('socios', 'cuentas.cedula', '=', 'socios.cedula')
        //     ->join('movimientos', 'socios.cedula', '=', 'movimientos.cedula')
        //     ->select('movimientos.apor_ahorro','movimientos.apor_presta','movimientos.seguro', 'cuentas.ncuenta','cuentas.cedula')
        //     ->where('movimientos.mes', $this->mes)
        //     ->where('movimientos.ano', '2022')
        //     ->where('cuentas.ncuenta', 'like', $this->ncuenta.'%')->get()
    }
}
