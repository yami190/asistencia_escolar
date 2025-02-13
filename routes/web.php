<?php

Route::get('AdmUser', function () {
    return view('prueba');
})->middleware('auth');

Route::get('/', 'LoginControlador@login')->name('login');
Route::get('logout', 'LoginControlador@logout')->middleware('auth');

Route::post('Gusuarios', 'LoginControlador@Gusuarios')->middleware('auth');
Route::post('entrada_login', 'LoginControlador@entrada_login');
Route::get('buscarUsuario', 'LoginControlador@buscarUsuario')->middleware('auth');
Route::get('roles', 'UsuariosControlador@selectRol')->middleware('auth');

Route::get('Resumen', 'AsistenciaControlador@index')->middleware('auth');;
Route::get('aula', 'AsistenciaControlador@selectAula')->middleware('auth');;
Route::get('Lalumnos', 'AsistenciaControlador@alumnos')->middleware('auth');;
Route::post('Gasistencia', 'AsistenciaControlador@guardarAsistencia')->middleware('auth');;


//Usuarios
Route::get('Lusuario', 'UsuariosControlador@index')->middleware('auth');
Route::post('Gusuario', 'UsuariosControlador@guardarUsuario')->middleware('auth');
Route::get('ELusuario', 'UsuariosControlador@eliminarUsuario')->middleware('auth');
Route::get('Bususuario', 'UsuariosControlador@BuscarUsuario')->middleware('auth');
Route::post('Eusuario', 'UsuariosControlador@EditarUsuario')->middleware('auth');
Route::get('roles', 'UsuariosControlador@selectRol')->middleware('auth');


