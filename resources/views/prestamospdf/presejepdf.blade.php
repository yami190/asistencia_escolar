<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>prueba</title>
</head>
<body>
	<table>
		<head>
			<tr>
			<th>id</th>
			<th>cedula</th>
		</tr>
		</head>
		<tbody>
			 @foreach($sociospresta as $presta)
			 <tr>
			 	<td>{{ $presta->id_prestamo }}<td>
				<td>{{ $presta->cedula }}<td>
			 </tr>
				
			@endforeach 
		</tbody>
	</table>
</body>
</html>