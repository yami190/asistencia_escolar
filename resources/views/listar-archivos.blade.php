<!-- resources/views/adjuntar-archivo.blade.php -->
<form action="{{ url('/guardar-archivo') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="archivo">
    <button type="submit">Adjuntar</button>
</form>
<br>
<br>
<br>
<br>
<!-- resources/views/listar-archivos.blade.php -->
<table>
    <thead>
        <tr>
            <th>Nombre de archivo</th>
            <th>Descargar</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($archivos as $archivo)
        <tr>
            <td>{{ $archivo }}</td>
            <td><a href="{{ url('/descargar-archivo/'.$archivo) }}">Descargar</a></td>
        </tr>
        @endforeach
    </tbody>
</table>