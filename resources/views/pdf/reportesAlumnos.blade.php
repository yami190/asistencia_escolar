<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Asistencia de Alumnos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td, th {
            border: 1px solid black;
            padding: 5px;
            text-align: left;
        }
        .footer {
            position: fixed;
            bottom: -30px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 12px;
        }
        .header img {
            width: 500;  /* Ajusta el ancho en píxeles */
            height: auto;  /* Mantiene la proporción de la imagen */
        }
        .pagenum:before {
            content: counter(page) " de " counter(pages);
        }
    </style>
</head>
<body>
    @php
        $totalAsistidos = $alumnos->where('asistio', 1)->count();
        $totalFaltantes = $alumnos->where('asistio', 0)->count();
    @endphp
    <div class="header">
        <img src="{{ public_path('pruebas/Imagen1.png') }}" alt="Logo">
    </div>
    <div>
        <center> <h2>Reporte de Asistencia de Alumnos</h2></center>
        <p><strong>Día:</strong> {{ ucfirst(\Carbon\Carbon::createFromFormat('Y-m-d', $fechaFormateada)->translatedFormat('l')) }}</p>
        <p><strong>Fecha:</strong> {{ \Carbon\Carbon::createFromFormat('Y-m-d', $fechaFormateada)->format('d/m/Y') }}</p>
        <p><strong>Hora de Generación:</strong> {{ now()->format('h:i:s A') }}</p>
    </div>
    

    <hr>

    <table>
        <thead>
            <tr>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Sección/Grado</th>
                <th>Asistencia</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            @foreach($alumnos as $alumno)
            <tr>
                <td>{{ $alumno->nombres }}</td>
                <td>{{ $alumno->apellidos }}</td>
                <td>{{ $alumno->aula }}</td>
                <td>{{ $alumno->asistio ? 'Presente' : 'Ausente' }}</td>
                <td>{{ $alumno->fecha  }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <!-- 🔹 Resumen de Totales -->
    <div style="margin-top: 20px; font-size: 14px;">
        <strong>Total de Alumnos Asistidos:</strong> {{ $totalAsistidos }} <br>
        <strong>Total de Alumnos Faltantes:</strong> {{ $totalFaltantes }}
    </div>

    <div class="footer">
        Página <span class="pagenum"></span>
    </div>
</body>
</html>
