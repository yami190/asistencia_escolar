<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Validator;
use App\Personal;
use App\Asistencia;
use Carbon\Carbon;

class PersonalControlador extends Controller
{
    public function index(Request $request)
    {
        return view('RegistroPersonal');
    }
    public function ListaPersonal (Request $request)
    {

        $cedula = $request->buscar;

       // return $cedula;

        if($cedula=='undefined'){
            $personal= Personal::orderBy('id_personal', 'ASC')
            ->paginate(10);
        }else{
            $personal= Personal::orderBy('id_personal', 'ASC')
            ->where('cedula', 'like', '%'. $cedula .'%')
            ->paginate(10);
        }
        return [
            'pagination' => [
                'total'        =>$personal->total(),
                'current_page' =>$personal->currentPage(),
                'per_page'     =>$personal->perPage(),
                'last_page'    =>$personal->lastPage(),
                'from'         =>$personal->firstItem(),
                'to'           =>$personal->lastItem(),
            ],
            'personal' => $personal
        ];
        //return response()->json(['alumnos' => $alumnos]);
    }
    public function guardarPersonal(Request $request)
    {
        // Validar los datos recibidos
        $validator = Validator::make($request->all(), [
            'cedula' => 'required|string|max:20',
            'nombre_apellido' => 'required|string|max:255',
            'sexo' => 'required|string|max:10',
            'codigo' => 'required|string|max:50',
            'cargo' => 'required|string|max:100',
            'horas_academicas' => 'required|integer',
            'grado' => 'required|string|max:50',
        ]);

        // Si la validación falla, devolver una respuesta con los errores
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 400);  // Puedes cambiar el código de estado según sea necesario
        }

        // Crear un nuevo registro en la base de datos
        try {
            $personal = new Personal();
            $personal->cedula = $request->cedula;
            $personal->nombre_apellido = $request->nombre_apellido;
            $personal->sexo = $request->sexo;
            $personal->codigo = $request->codigo;
            $personal->cargo = $request->cargo;
            $personal->horas_academicas = $request->horas_academicas;
            $personal->grado = $request->grado;

            // Guardar en la base de datos
            $personal->save();

            // Devolver una respuesta exitosa
            return response()->json([
                'success' => true,
                'message' => 'Estudiante registrado correctamente.',
                'data' => $personal
            ], 200);

        } catch (\Exception $e) {
            // Si ocurre un error durante el guardado, devolver un error
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al guardar el estudiante: ' . $e->getMessage()
            ], 500);
        }
    }

    public function eliminarPersonal(Request $request)
    {
       // return $request;
        $id = $request->query('id_personal'); // Para obtener el parámetro de consulta
       
        if (empty($id)) {
            return response()->json(['error' => 'ID no proporcionado'], 400);
        }
        $estudiante = Personal::find($id);
            if ($estudiante) {
                $estudiante->delete();
                return response()->json(['success' => 'Usuario eliminado correctamente.']);
            } else {
                return response()->json(['error' => 'Usuario no encontrado.'], 404);
            }
        
    }

    public function BuscarPersonal(Request $request)
    {
        //return $request;
        $id = $request['id'];
        $estudiante = Personal::where('id_personal', 'like', '%'. $id .'%')->take(1)->get();
        return ['estudiante' => $estudiante];
    }

    public function EditarPersonal(Request $request)
    {
       // return $request;
        // Validación de los datos recibidos
        $request->validate([
            'id' => 'required|max:10',
            'cedula' => 'required|string|max:10',
            'nombre_apellido' => 'required|string|max:100',
            'sexo' => 'required|string|max:10',
            'codigo' => 'required|string|max:20',
            'cargo' => 'required|string|max:50',
            'horas_academicas' => 'required|numeric|min:1',
            'grado' => 'required|string|max:10',
        ]);

        // Encuentra el personal a editar, por ejemplo usando la cédula
        $personal = Personal::where('id_personal', $request->id)->first();

        // Si el personal no existe, retorna un error
        if (!$personal) {
            return response()->json(['error' => 'No se encontró el personal con esa cédula.'], 404);
        }

        // Actualiza los campos del personal
        $personal->cedula = $request->cedula;
        $personal->nombre_apellido = $request->nombre_apellido;
        $personal->sexo = $request->sexo;
        $personal->codigo = $request->codigo;
        $personal->cargo = $request->cargo;
        $personal->horas_academicas = $request->horas_academicas;
        $personal->grado = $request->grado;

        // Guarda los cambios en la base de datos
        $personal->save();

        // Retorna una respuesta de éxito
        return response()->json(['success' => 'Personal actualizado correctamente.']);
    }

        public function ReportesAsistencia(Request $request)
        {
            return view('asistencia/reportes');
            
        }

        public function ReportesAsis(Request $request)
        {

            Carbon::setLocale('es'); // Asegura que los días se muestren en español

            $fecha = $request->fecha; // Recibe la fecha desde el formulario
        
            $personal = Personal::select(
                'personal.nombre_apellido',
                'personal.cedula',
                'personal.cargo',
                'personal.grado',
                'asistencias.asistio',
                'asistencias.fecha'
            )
           
            
            ->join('asistencias', 'personal.id_personal', '=', 'asistencias.id_personal')
            ->where('asistencias.fecha', '=', $fecha)
            ->get();
       // return $personal;
            // Formatea la fecha en un formato que Carbon pueda interpretar
            $fechaFormateada = Carbon::parse($fecha)->format('Y-m-d');
        
            // Envía la fecha con formato correcto a la vista
            $pdf = PDF::loadView('pdf.reportePersonal', compact('personal', 'fechaFormateada'))
                ->setPaper('A4', 'portrait');
        
            return $pdf->stream('reporte_asistencia.pdf'); // Para mostrar en el navegador
            // return $pdf->download('reporte_asistencia.pdf'); // Para descargar directamente
        }
}
