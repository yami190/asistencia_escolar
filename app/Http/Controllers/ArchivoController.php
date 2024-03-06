<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

    class ArchivoController extends Controller
{
    public function listarTodo()
    {
        $rutaCarpeta = storage_path('app/public/archivos');

        if (file_exists($rutaCarpeta)) {
            $archivos = \File::files($rutaCarpeta);
            $nombreArchivos = [];

            foreach ($archivos as $archivo) {
                $nombreArchivos[] = $archivo->getFilename();
            }

            return view('listar-archivos', ['archivos' => $nombreArchivos]);
        }else {
            abort(404, 'Carpeta no encontrada');
        }
    }

    public function descargar($nombreArchivo)
    {
        $rutaArchivo = storage_path('app/public/archivos/' . $nombreArchivo);

        if (file_exists($rutaArchivo)) {
            return response()->download($rutaArchivo);
        } else {
            abort(404, 'Archivo no encontrado');
        }
    }

    public function guardar(Request $request)
    {
        $archivo = $request->file('archivo');

        if ($archivo) {
            $nombreArchivo = $archivo->getClientOriginalName();
            $archivo->storeAs('public/archivos', $nombreArchivo);
            return redirect('listar-archivos')->with('success', 'Archivo adjuntado correctamente');
        } else {
            return redirect('adjuntar-archivo')->with('error', 'No se ha adjuntado ningún archivo');
        }
    }
}
