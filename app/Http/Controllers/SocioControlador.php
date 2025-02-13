<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Socio;
use App\Movimiento;
use App\Cuenta;

class SocioControlador extends Controller
{
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if($buscar==''){

            $socios = Socio::join('nominas', 'socios.codigo', '=', 'nominas.codigo')
            ->select('socios.id_socio','socios.codigo','socios.nombres','socios.cedula','nominas.nombre as nom_nomina', 'socios.descripcion','socios.condicion')
            ->where('socios.'.$criterio, 'like', '%'. $buscar .'%')
            ->paginate(10);

        }

        else {

        	$socios = Socio::join('nominas', 'socios.codigo', '=', 'nominas.codigo')
            ->select('socios.id_socio','socios.codigo','socios.nombres','socios.cedula','nominas.nombre as nom_nomina', 'socios.descripcion','socios.condicion')
            ->where('socios.'.$criterio, 'like', '%'. $buscar .'%')
            ->orderBy('id_socio', 'DESC')->paginate(10);

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
            'socios' => $socios
        ];


    }

    

     public function store(Request $request)
    {
     return $request;
    if(!$request->ajax()) return redirect('/');
        $socio = new Socio();
        $socio->codigo = $request->codigo;
        $socio->nombres = $request->nombres;
        $socio->cedula = $request->cedula;
        $socio->descripcion = $request->descripcion;
        $socio->condicion = $request->condicion;

        $socio->save();
    }

 public function update(Request $request)
    {

       // return $request;
        if(!$request->ajax()) return redirect('/');
        $socio = Socio::where('cedula', $request->cedula)->first();
       // return $request;
        $socio->codigo = $request->codigo;
        $socio->nombres = $request->nombres;
       // $socio->descripcion = $request->descripcion;
        $socio->condicion = $request->condicion;

        $socio->save();
        
    }

    public function desactivar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $socio = Socio::findORFail($request->id_socio);
        $socio->condicion = '0';

        $socio->save(); 
    }

    public function activar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $socio = Socio::findORFail($request->id_socio);
        $socio->condicion = '1';

        $socio->save(); 
    }

    public function bancosmontos(Request $request)
    {

        $cuentasSocios = Cuenta::join('socios', 'cuentas.cedula', '=', 'socios.cedula')
            ->join('movimientos', 'socios.cedula', '=', 'movimientos.cedula')
            ->join('nominas', 'socios.codigo', '=', 'nominas.codigo')
            ->select('cuentas.id_cuenta','socios.nombres', 'cuentas.cedula','nominas.nombre as nom_nomina', 'movimientos.apor_ahorro','movimientos.apor_presta','movimientos.seguro', 'socios.codigo','cuentas.ncuenta', 'cuentas.banco')
            ->where('movimientos.mes', '8')
            ->where('movimientos.ano', '2022')
            ->where('cuentas.ncuenta', 'like', '0175%')
            ->paginate(10);

        return [
            'pagination' => [
                'total'        =>$cuentasSocios->total(),
                'current_page' =>$cuentasSocios->currentPage(),
                'per_page'     =>$cuentasSocios->perPage(),
                'last_page'    =>$cuentasSocios->lastPage(),
                'from'         =>$cuentasSocios->firstItem(),
                'to'           =>$cuentasSocios->lastItem(),
            ],
            'cuentasSocios' => $cuentasSocios
        ];
    }

    public function buscarSocio(Request $request)
    {
        // Sanitización del input (ejemplo para Laravel)
        $cedula = $request->validate(['cedula' => 'required|integer']);

        // Ejecución de la consulta con manejo de errores
        $archivosocio = Socio::select('socios.id_socio', 'socios.cedula', 'socios.nombres', 'nominas.nombre as nomina', 'socios.condicion', 'socios.codigo')
        ->join('nominas','socios.codigo','=','nominas.codigo')
        ->where('cedula', $cedula)->take(1)->get();

        if (!$archivosocio) {
            return response()->json(['message' => 'archivosocio no encontrado'], 404);
        }

        return ['archivosocio' => $archivosocio];
    }


}
