<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Socio;
use DB;

class ExportTxtControlador extends Controller
{
    public function index()
    // {
    //     $socios = DB::table('socios as a')
    //     ->select(DB::raw("TRIM(a.cedula) as cedula"), DB::raw("TRIM(a.nombres) as nombres"),'b.apor_ahorro', 'b.mes', 'b.seguro')
    //     ->join('movimientos as b', 'a.cedula', '=', 'b.cedula')
    //     ->where('b.mes', '=', 1)
    //     ->where('b.ano', '=', 2023)
    //     ->whereBetween('a.codigo', [1, 29])
    //     ->get();

    //     $contenido = '';
    //         foreach ($socios as $dato) {
    //             $cedula = preg_replace('/\D/', '', $dato->cedula); // Elimina todos los caracteres no numéricos de la cédula
    //             $contenido .= $cedula . "\t" . $dato->apor_ahorro . "\n";
    //         }

    //     Storage::disk('local')->put('datos.txt', $contenido);

    //     $rutaArchivo = storage_path('app/datos.txt');
    //     $nombreArchivo = 'datos.txt';
    
    //     return response()->download($rutaArchivo, $nombreArchivo, [], 'attachment');
    }

      
}
