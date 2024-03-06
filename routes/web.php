<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('old', function () {
    return view('contenido/contenido');
});

Route::get('CAHORRO', function () {
    return view('contenido/contenido');
});

Route::get('cta-bancos', function () {
    return view('cuentas_bancos');
});

//Pruebas Solo se usa para probar rutas 

Route::get('/Nomina_gob', 'BalanceControlador@nomina_goberna');


Route::get('/balance', 'BalanceControlador@index');

Route::get('listado-liquidaciones', 'ArchivoControlador@listaliqui');
Route::get('buscar-socio', 'ArchivoControlador@liquidacionsocio');
Route::post('liquidar-socio', 'ArchivoControlador@saveliquisocio');
Route::put('eliminar/liquidacion', 'ArchivoControlador@eliminarliqui');

//Socios
Route::get('/socio', 'SocioControlador@index');
Route::post('registrar/socio', 'SocioControlador@store');
Route::put('/actualizar/socio', 'SocioControlador@update');
Route::put('/desactivar/socio', 'SocioControlador@desactivar');
Route::put('/activar/socio', 'SocioControlador@activar');

//Nominas
Route::get('/nomina', 'NominaControlador@index');
Route::get('cuenta', 'CuentasControlador@index');
Route::post('/registrar/nomina', 'NominaControlador@store');
Route::put('/actualizar/nomina', 'NominaControlador@update');
Route::put('/desactivar/nomina', 'NominaControlador@desactivar');
Route::put('/activar/nomina', 'NominaControlador@activar');
Route::get('selectNomina/nomina', 'NominaControlador@selectNomina');

//movimientos
Route::get('estado_cuenta', function () {
    return view('estadoscuentas');
});
Route::get('/movimiento', 'MovimientosControlador@index');
Route::get('calculo-prestamos', 'MovimientosControlador@calcupresta');

//Contabilidad

Route::resource('/contabilidad', 'ContabilidadControlador');
Route::put('/desactivar/contabilidad', 'ContabilidadControlador@desactivar');
Route::put('/activar/contabilidad', 'ContabilidadControlador@activar');
Route::get('selectMes/Mes', 'ContabilidadControlador@selectMes');
Route::get('transferencia', 'PagosControlador@index');

//Balances
Route::get('/balance', 'BalanceControlador@index');
Route::get('/balance-porrango', 'BalanceControlador@porrango');
Route::get('/balance-porrangosud', 'BalanceControlador@porrangosud');
Route::get('/balance-compare', 'BalanceControlador@compare');

//Nomina Caja
Route::get('/movimientoCaja', 'CajaAhorroControlador@index');

Route::get('movimientoCaja-vista', function(){
    return view('movicaja');
});
//Route::get('/movimientoCaja-vista', 'CajaAhorroControlador@vista');
Route::get('/balance-porrangosud', 'BalanceControlador@porrangosud');

Route::get('reporte-balances', function () {
    return view('balances');
});


//Usuarios
Route::resource('/Usruarios', 'UserController');

//Nomina Caja

Route::get('lista-nominacaja', 'NominaCajaControlador@index');
Route::post('guardar-nominacaja', 'NominaCajaControlador@store');
Route::put('desactivar/personal', 'NominaCajaControlador@desactivar');
Route::put('activar/personal', 'NominaCajaControlador@activar');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//apartir de aqui comienza varjalla
//Atencion al socio

Route::get('EstCuenta', function () {
    return view('AtenSocio.estacuenta');
});

Route::get('estado-socio', 'MovimientosControlador@estadocuenta');
Route::get('est-socio', 'MovimientosControlador@buscarsoocio');
Route::get('suma-socio', 'MovimientosControlador@sumasoocio');
Route::get('lista-historico', 'MovimientosControlador@historicosicio');

//archivo

Route::get('Expedientes', function () {
    return view('expedientes');
});

Route::get('/listado-expedientes', 'ArchivoControlador@index');
Route::get('buscar-expediente', 'ArchivoControlador@archivossocios');
Route::post('asignar-expediente', 'ArchivoControlador@store');
Route::put('/desactivar/expediente', 'ArchivoControlador@eliminar');

Route::get('Liquidaciones', function () {
    return view('liquidaciones');
});

//prestamos

Route::get('Prestamos', function () {
    return view('descuentos.prestamos');
});

Route::get('listar-presta-temp', 'PrestamosControler@index');
Route::get('Estado-Presta', 'PrestamosControler@EstadoPresta');
Route::get('Expor-presta-pdf', 'PrestamosControler@exporpdf');
Route::post('presta-temp-socio', 'PrestamosControler@store');
Route::post('procesar-presta', 'PrestamosControler@procesarpres');

//cuentas bancarias

Route::get('CuentasSocios', function () {
    return view('bancos.cuentas_bancos');
});

Route::get('cuentas-socio', 'CuentasControlador@cuentasSocios');

Route::get('Balances', function () {
    return view('administrador.nomina');
});

//Descuentos
Route::get('Descuentos-Socios', function () {
    return view('descuentos.ajustesfinan');
});


//Administrador nomina

Route::get('Balances-caja', function () {
    return view('edofinanci.balances');
});

Route::get('Nomina-socio', function () {
    return view('administrador.NominaSocio');
});
Route::get('veri-nue-socio', 'SocioControlador@bancosmontos');
Route::get('Expor-nomina-socio', 'NominasSociosController@ExpSociCuen');
Route::get('Banco-Bicentenario', 'NominasSociosController@bancoBicentenario');
Route::get('Banco-Caroni', 'NominasSociosController@bancosCaroni');
Route::get('Banco-Venezuela', 'NominasSociosController@bancosVenezuela');
Route::get('act-socio-lista', 'Sociotempcontroller@procesarSocio');
Route::get('act-socio-data', 'Sociotempcontroller@ActuNomSocios');
Route::get('cam-socio-data', 'Sociotempcontroller@CambSociodata');
Route::get('Expor-nom-tx', 'ExportTxtControlador@index');

Route::post('Impo-mov-socio', 'NominasSociosController@impsociomov');
Route::get('Export-mov-socio', 'NominasSociosController@expsociomov')->name('Export.socio.mov.excel');


Route::get('listar-archivos', 'ArchivoController@listarTodo');
Route::get('descargar-archivo/{nombreArchivo}', 'ArchivoController@descargar');
Route::post('/guardar-archivo', 'ArchivoController@guardar');

// Route::get('Prueba', function () {
//     return view('prueba');
// });

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
