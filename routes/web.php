<?php

Route::get('AdmUser', function () {
    return view('Calendario');
})->middleware('auth');

Route::get('Adminstrador', function () {
    return view('prueba');
})->middleware('auth');

Route::get('/', 'LoginControlador@login')->name('login');
Route::get('logout', 'LoginControlador@logout')->middleware('auth');

Route::post('Gusuarios', 'LoginControlador@Gusuarios')->middleware('auth');
Route::post('entrada_login', 'LoginControlador@entrada_login');
Route::get('buscarUsuario', 'LoginControlador@buscarUsuario')->middleware('auth');
Route::get('roles', 'UsuariosControlador@selectRol')->middleware('auth');

Route::get('Resumen', 'AsistenciaControlador@index')->middleware('auth');
Route::get('aula', 'AsistenciaControlador@selectAula')->middleware('auth');
Route::get('Lalumnos', 'AsistenciaControlador@alumnos')->middleware('auth');
Route::post('Gasistencia', 'AsistenciaControlador@guardarAsistencia')->middleware('auth');
Route::get('ResumenPersonal', 'AsistenciaControlador@personal')->middleware('auth');
Route::get('asispersonal', 'AsistenciaControlador@asispersonal')->middleware('auth');
Route::post('GasistenciaP', 'AsistenciaControlador@guardarAsistenciaPersonal')->middleware('auth');

//Alumnoss

Route::get('Alumnos', 'AlumnoControlador@index')->middleware('auth');
Route::get('LisAlumno', 'AlumnoControlador@listaAlumnos')->middleware('auth');
Route::post('Gestudiante', 'AlumnoControlador@guardarEstudiante')->middleware('auth');
Route::get('Bestuadiante', 'AlumnoControlador@BuscarEtudiante')->middleware('auth');
Route::post('Eestudiante', 'AlumnoControlador@EditarEstudiante')->middleware('auth');
Route::get('ELtudiante', 'AlumnoControlador@eliminarestudinte')->middleware('auth');
Route::get('reportes', 'AlumnoControlador@ReportesAsistencia')->middleware('auth');
Route::get('reporte/pdf', 'AlumnoControlador@ReportesAsis')->middleware('auth');

Route::post('Gpersonal', 'PersonalControlador@guardarPersonal')->middleware('auth');
Route::get('Bpersonal', 'PersonalControlador@BuscarPersonal')->middleware('auth');
Route::post('Epersonal', 'PersonalControlador@EditarPersonal')->middleware('auth');
Route::get('ELpersonal', 'PersonalControlador@eliminarPersonal')->middleware('auth');
Route::get('Personal', 'PersonalControlador@index')->middleware('auth');
Route::get('LisPerso', 'PersonalControlador@ListaPersonal')->middleware('auth');
Route::get('reporteperdonal', 'PersonalControlador@ReportesAsis')->middleware('auth');
//Usuarios
Route::get('Lusuario', 'UsuariosControlador@index')->middleware('auth');
Route::post('Gusuario', 'UsuariosControlador@guardarUsuario');
Route::get('ELusuario', 'UsuariosControlador@eliminarUsuario')->middleware('auth');
Route::get('Bususuario', 'UsuariosControlador@BuscarUsuario')->middleware('auth');
Route::post('Eusuario', 'UsuariosControlador@EditarUsuario')->middleware('auth');
Route::get('roles', 'UsuariosControlador@selectRol')->middleware('auth');

Route::get('GestorBD', 'DatabaseBackupController@index');
Route::post('import-db', 'DatabaseBackupController@import');
Route::get('export-db', 'DatabaseBackupController@export');

Route::get('Gsuario', 'GestionUsuarioController@index');
Route::post('Bussuario', 'GestionUsuarioController@buscarCedula');
Route::post('validar-respuestas', 'GestionUsuarioController@validarRespuestas');
Route::post('actualizar-contraseña', 'GestionUsuarioController@actualizarContraseña');
Route::post('Resuario', 'UsuariosControlador@guardarUsuario');
Route::post('Gresuario', 'GestionUsuarioController@guardarUsuario');

Route::get('MANUAL_DE_SISTEMA_DE_ASISTENCIA', 'CalendarioControlador@manual');
Route::get('Calendario', 'CalendarioControlador@index');
Route::get('efemerides/mes', 'CalendarioControlador@diasConEfemerides');
// Obtener todas las efemérides de una fecha específica
Route::get('efemerides', 'CalendarioControlador@efemeridesPorFecha');

// Crear una nueva efeméride
Route::post('efemerides', 'CalendarioControlador@store');

// Actualizar una efeméride por ID
Route::put('efemerides/{id}', 'CalendarioControlador@update');

// (Opcional) Eliminar una efeméride
Route::delete('efemerides/{id}', 'CalendarioControlador@destroy');
