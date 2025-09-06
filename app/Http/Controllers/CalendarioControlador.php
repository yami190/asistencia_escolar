<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Evento;
use DB;

class CalendarioControlador extends Controller
{
    public function index(Request $request)
    {
        return view('Calendario');
    }
    public function manual(Request $request)
    {
        return view('Manual');
    }

    public function efemeridesPorFecha(Request $request)
    {
        //return $request;
        $fecha = $request->input('fecha');
        $eventos = Evento::where('fecha', $fecha)->get();
        return response()->json($eventos);
    }

    public function diasConEfemerides(Request $request)
    {
        
        $mes = $request->query('mes'); // mes en formato numérico (1 a 12)

        if (!$mes) {
            return response()->json([], 400);
        }

        // Trae fechas que ocurren en ese mes (sin importar el año)
        $fechas = DB::table('eventos')
            ->whereMonth('fecha', $mes)
            ->pluck('fecha')
            ->map(function ($fecha) {
                return \Carbon\Carbon::parse($fecha)->format('d'); // solo el día
            })
            ->unique()
            ->values();

        return response()->json($fechas);
    }



    public function store(Request $request)
    {
        //return $request;
        return Evento::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $efemeride = Evento::findOrFail($id);
        $efemeride->update($request->all());
        return $efemeride;
    }

    public function destroy($id)
    {
        Evento::destroy($id);
        return response()->noContent();
    }
}
