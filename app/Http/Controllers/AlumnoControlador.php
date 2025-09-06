<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use App\Alumnos;
use App\Asistencia;
use Carbon\Carbon;


class AlumnoControlador extends Controller
{
    public function index(Request $request)
    {
        return view('asistencia/alumnos');
    }
    public function listaAlumnos(Request $request)
    {

        $cedul_esco = $request->buscar;

       // return $cedul_esco;

        if($cedul_esco=='undefined'){
            $alumnos= Alumnos::select(
                'alumnos.id_alumno as id',
                'alumnos.cedul_esco',
                'alumnos.nombres',
                'alumnos.apellidos',
                'alumnos.sexo',
                'alumnos.fecha_naci',
                'alumnos.estado',
                'alumnos.entidad',
                'aula.nombres as aula',
            )
            ->join('aula', 'alumnos.id_aula', '=', 'aula.id_aula')
            ->orderBy('alumnos.id_alumno', 'ASC')
            ->paginate(10);
        }else{
            $alumnos= Alumnos::select(
                'alumnos.id_alumno as id',
                'alumnos.cedul_esco',
                'alumnos.nombres',
                'alumnos.apellidos',
                'alumnos.sexo',
                'alumnos.fecha_naci',
                'alumnos.estado',
                'alumnos.entidad',
                'aula.nombres as aula',
            )
            ->join('aula', 'alumnos.id_aula', '=', 'aula.id_aula')
            ->where('alumnos.cedul_esco', 'like', '%'. $cedul_esco .'%')
            ->orderBy('alumnos.id_alumno', 'ASC')
            ->paginate(10);
        }
        return [
            'pagination' => [
                'total'        =>$alumnos->total(),
                'current_page' =>$alumnos->currentPage(),
                'per_page'     =>$alumnos->perPage(),
                'last_page'    =>$alumnos->lastPage(),
                'from'         =>$alumnos->firstItem(),
                'to'           =>$alumnos->lastItem(),
            ],
            'alumnos' => $alumnos
        ];
        //return response()->json(['alumnos' => $alumnos]);
    }
    public function guardarEstudiante(Request $request)
        {    
            try {
                $estudiante = new Alumnos();
                $estudiante->cedul_esco = $request->cedul_esco;
                $estudiante->nombres = $request->nombres;
                $estudiante->apellidos = $request->apellidos;
                $estudiante->sexo = $request->sexo;
                $estudiante->fecha_naci = $request->fecha_naci;
                $estudiante->estado = $request->estado;
                $estudiante->entidad = $request->entidad;
                $estudiante->id_aula = $request->id_aula;
                
                $estudiante->save();

                return response()->json(['message' => 'El estudiante fue registrado con éxito'], 201);
            } catch (ValidationException $e) {
                return response()->json(['errors' => $e->validator->errors()], 422);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Error al registrar el estudiante: ' . $e->getMessage()], 500);
            }
        }

    public function eliminarestudinte(Request $request)
    {
        //return $request;
        $id = $request->query('id'); // Para obtener el parámetro de consulta
       
        if (empty($id)) {
            return response()->json(['error' => 'ID no proporcionado'], 400);
        }
        $estudiante = Alumnos::find($id);
            if ($estudiante) {
                $estudiante->delete();
                return response()->json(['success' => 'Usuario eliminado correctamente.']);
            } else {
                return response()->json(['error' => 'Usuario no encontrado.'], 404);
            }
        
    }

    public function BuscarEtudiante(Request $request)
    {
        //return $request;
        $id = $request['id'];
        $estudiante = Alumnos::where('id_alumno', 'like', '%'. $id .'%')->take(1)->get();
        return ['estudiante' => $estudiante];
    }

    public function EditarEstudiante(Request $request)
        {
            //return $request;
            try {
                // Buscar al estudiante
                $estudiante = Alumnos::findOrFail($request->id);

                // Actualizar los campos
                $estudiante->cedul_esco = $request->cedul_esco;
                $estudiante->nombres = $request->nombres;
                $estudiante->apellidos = $request->apellidos;
                $estudiante->sexo = $request->sexo;
                $estudiante->fecha_naci = $request->fecha_naci;
                $estudiante->estado = $request->estado;
                $estudiante->entidad = $request->entidad;
                $estudiante->id_aula = $request->id_aula;

                // Guardar los cambios
                $estudiante->save();

                return response()->json(['message' => 'Estudiante actualizado con éxito'], 200);
            } catch (ModelNotFoundException $e) {
                return response()->json(['error' => 'Estudiante no encontrado'], 404);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Error al actualizar el estudiante: ' . $e->getMessage()], 500);
            }
        }

        public function ReportesAsistencia(Request $request)
        {
            return view('asistencia/reportes');
            
        }

        public function ReportesAsis(Request $request)
        {

            Carbon::setLocale('es'); // Asegura que los días se muestren en español

            $id_aula = $request->id_aula;
            $fecha = $request->fecha; // Recibe la fecha desde el formulario
        
            $alumnos = Alumnos::select(
                'alumnos.nombres',
                'alumnos.apellidos',
                'aula.nombres as aula',
                'asistencias.asistio',
                'asistencias.fecha'
            )
            ->join('aula', 'alumnos.id_aula', '=', 'aula.id_aula')
            ->join('asistencias', 'alumnos.id_alumno', '=', 'asistencias.id_alumno')
            ->where('alumnos.id_aula', '=', $id_aula) 
            ->where('asistencias.fecha', '=', $fecha)
            ->get();
        
            // Formatea la fecha en un formato que Carbon pueda interpretar
            $fechaFormateada = Carbon::parse($fecha)->format('Y-m-d');
        
            // Envía la fecha con formato correcto a la vista
            $pdf = PDF::loadView('pdf.reportesAlumnos', compact('alumnos', 'fechaFormateada'))
                ->setPaper('A4', 'portrait');
        
            return $pdf->stream('reporte_asistencia.pdf'); // Para mostrar en el navegador
            // return $pdf->download('reporte_asistencia.pdf'); // Para descargar directamente
        }



    
    

      
}