<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Aula;
use App\Alumnos;
use App\Asistencia;
use App\Personal;
use Carbon\Carbon;
use DB;

class AsistenciaControlador extends Controller
{
    public function index()
    {
        return view('asistencia/resumen');
    }

    public function selectAula(Request $request)
    {
       //if (!$request->ajax()) return redirect('/');
            $aulas = Aula::select('aula.id_aula', 'aula.nombres', 'personal.nombre_apellido as docente')
                ->join('personal', 'personal.grado', '=', 'aula.id_aula')
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

        // Verificar si ya existen registros de asistencia para el día actual
        $asistenciaHoy = DB::table('asistencias')
            ->join('alumnos', 'asistencias.id_alumno', '=', 'alumnos.id_alumno')
            ->whereDate('asistencias.fecha', $date)
            ->where('alumnos.id_aula', $request->id_aula)
            ->exists(); // Verificar si hay registros de asistencia

        // Si hay registros de asistencia hoy
        if ($asistenciaHoy) {
            $alumnos = Alumnos::select(
                'alumnos.id_alumno',
                'alumnos.cedul_esco',
                'alumnos.nombres',
                'alumnos.apellidos',
                'alumnos.sexo',
                'aula.nombres as aula',
                'asistencias.asistio' // Obtener si asistió o no
            )
            ->join('aula', 'alumnos.id_aula', '=', 'aula.id_aula')
            ->leftJoin('asistencias', function ($join) use ($date) {
                $join->on('alumnos.id_alumno', '=', 'asistencias.id_alumno')
                    ->where('asistencias.fecha', '=', $date);
            })
            ->where('alumnos.id_aula', $request->id_aula)
            ->orderBy('alumnos.id_alumno', 'asc')
            ->get();
        } else {
            // Si no hay asistencia hoy, devolver los alumnos con 'asistio' en NULL
            $alumnos = Alumnos::select(
                'alumnos.id_alumno',
                'alumnos.cedul_esco',
                'alumnos.nombres',
                'alumnos.apellidos',
                'alumnos.sexo',
                'aula.nombres as aula',
                DB::raw('NULL as asistio') // Establecer 'asistio' como NULL
            )
            ->join('aula', 'alumnos.id_aula', '=', 'aula.id_aula')
            ->where('alumnos.id_aula', $request->id_aula)
            ->orderBy('alumnos.id_alumno', 'asc')
            ->get();
        }

        // Devolver los alumnos con su asistencia o casillas vacías
        return response()->json(['alumnos' => $alumnos]);
    }


    public function guardarAsistencia(Request $request)
    {
        // Validar que se hayan enviado datos
        $request->validate([
            'asistencia' => 'required|array',
            'asistencia.*.id_alumno' => 'required|integer',
            'asistencia.*.asistio' => 'required|boolean',
        ]);
        
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
            // Obtener el registro de asistencia existente (si existe)
            $registroAsistencia = Asistencia::where('id_alumno', $asistencia['id_alumno'])
                ->where('fecha', now()->toDateString())
                ->first();

            // Si el registro de asistencia no existe o el estado ha cambiado, actualizarlo
            if (!$registroAsistencia || $registroAsistencia->asistio !== $asistencia['asistio']) {
                Asistencia::updateOrCreate(
                    [
                        'id_alumno' => $asistencia['id_alumno'],
                        'fecha' => now()->toDateString(),
                    ],
                    [
                        'asistio' => $asistencia['asistio'],
                    ]
                );
            }
        }

        // Devolver una respuesta
        return response()->json([
            'message' => 'Asistencia guardada correctamente.',
            'asistencia' => $asistenciaData,
        ]);
    }
 
    public function personal()
    {
        return view('asistencia/personal');
    }

    public function asispersonal(Request $request)
{
    // Obtener la fecha actual
    $fecha = Carbon::now()->format('Y-m-d');

    // Verificar si ya existen registros de asistencia para el día actual
    $asistenciaHoy = DB::table('asistencias')
        ->join('personal', 'asistencias.id_personal', '=', 'personal.id_personal')
        ->whereDate('asistencias.fecha', $fecha)
        ->exists(); // Verificar si hay registros de asistencia

    // Si hay registros de asistencia hoy
    if ($asistenciaHoy) {
        $personal = DB::table('personal')
            ->select(
                'personal.id_personal',
                'personal.cedula',
                'personal.nombre_apellido',
                'personal.sexo',
                'personal.codigo',
                'personal.cargo',
                'personal.horas_academicas',
                'personal.grado',
                'asistencias.asistio' // Obtener si asistió o no
            )
            ->leftJoin('asistencias', function ($join) use ($fecha) {
                $join->on('personal.id_personal', '=', 'asistencias.id_personal')
                    ->where('asistencias.fecha', '=', $fecha);
            })
            ->orderBy('personal.id_personal', 'asc')
            ->get();
    } else {
        // Si no hay asistencia hoy, devolver los registros de personal con 'asistio' en NULL
        $personal = DB::table('personal')
            ->select(
                'personal.id_personal',
                'personal.cedula',
                'personal.nombre_apellido',
                'personal.sexo',
                'personal.codigo',
                'personal.cargo',
                'personal.horas_academicas',
                'personal.grado',
                DB::raw('NULL as asistio') // Establecer 'asistio' como NULL
            )
            ->orderBy('personal.id_personal', 'asc')
            ->get();
    }

    // Devolver los datos de personal con su asistencia o casillas vacías
    return response()->json(['personal' => $personal]);
}

    public function guardarAsistenciaPersonal(Request $request)
    {
        //return $request;
        // Validar que se hayan enviado datos
        $request->validate([
            'asistencia' => 'required|array',
            'asistencia.*.id_personal' => 'required|integer',
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
                    'id_personal' => $asistencia['id_personal'],
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
