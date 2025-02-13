<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Aula;
use App\Alumnos;
use App\Asistencia;
use Carbon\Carbon;

class AsistenciaControlador extends Controller
{
    public function index()
    {
        return view('asistencia/resumen');
    }

    public function selectAula(Request $request)
    {
       if (!$request->ajax()) return redirect('/');
            $aulas = Aula::select('id_aula', 'nombres')
                ->orderBy('id_aula', 'asc')
                ->get();
            $aulas->prepend((object) ['id_aula' => '', 'nombres' => 'Seleccione']);
        return ['aulas' => $aulas];
    }

    public function alumnos(Request $request)
    {
       // Validar que el id_aula esté presente y sea válido
        $request->validate([
            'id_aula' => 'required|integer|exists:aula,id_aula',
        ]);

        // Obtener la fecha actual
        $date = Carbon::now()->format('Y-m-d');
       // echo $date;
        // Consulta para obtener los alumnos con su asistencia (si existe)
        $alumnos = Alumnos::select(
            'alumnos.id_alumno',
            'alumnos.cedul_esco',
            'alumnos.nombres',
            'alumnos.apellidos',
            'alumnos.sexo',
            'aula.nombres as aula',
            'asistencias.asistio' // Campo que indica si asistió o no
        )
        ->join('aula', 'alumnos.id_aula', '=', 'aula.id_aula')
        ->leftJoin('asistencias', function ($join) use ($date) {
            $join->on('alumnos.id_alumno', '=', 'asistencias.id_alumno')
                ->where('asistencias.fecha', '=', $date);
        })
        ->where('alumnos.id_aula', $request->id_aula)
        ->orderBy('alumnos.id_alumno', 'asc')
        ->get();

        // Devolver la respuesta en formato JSON
        return response()->json(['alumnos' => $alumnos]);
    }
    public function guardarAsistencia(Request $request)
    {
        //return $request;
        // Validar que se hayan enviado datos
        $request->validate([
            'asistencia' => 'required|array',
            'asistencia.*.id_alumno' => 'required|integer',
            'asistencia.*.asistio' => 'required|boolean',
        ]);
        
        //return $request;
        // Obtener los datos de asistencia
        $asistenciaData = $request->input('asistencia');
    
        // Verificar que $asistenciaData sea un array y no esté vacío
        if (!is_array($asistenciaData) || empty($asistenciaData)) {
            return response()->json([
                'message' => 'No se recibieron datos de asistencia válidos.',
            ], 400); // Código de estado HTTP 400: Bad Request
        }
    
        // Guardar la asistencia en la base de datos
        foreach ($asistenciaData as $asistencia) {
            Asistencia::updateOrCreate(
                [
                    'id_alumno' => $asistencia['id_alumno'],
                    'fecha' => now()->toDateString(), // Guardar la fecha actual
                ],
                [
                    'asistio' => $asistencia['asistio'],
                ]
            );
        }
    
        // Devolver una respuesta
        return response()->json([
            'message' => 'Asistencia guardada correctamente.',
            'asistencia' => $asistenciaData,
        ]);
    }
}   
