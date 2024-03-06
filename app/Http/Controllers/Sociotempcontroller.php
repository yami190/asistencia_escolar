<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Temp_socio;
use DB;

class Sociotempcontroller extends Controller
{
    public function index(Request $request){

        $sql = "SELECT t1.cedula, t1.nombres, t1.codigo FROM temp_socios t1 WHERE NOT EXISTS (SELECT t2.cedula, t2.nombres, t2.codigo FROM socios t2 WHERE t2.cedula = t1.cedula)
                ";

        $socioslista = DB::select($sql);

        return ['socioslista' => $socioslista];
    }

    public function procesarSocio()
    {
        $sql = "INSERT INTO socios (cedula, nombres, codigo)
                SELECT DISTINCT t1.cedula, t1.nombres, t1.codigo FROM temp_socios t1 
                WHERE NOT EXISTS (SELECT t2.cedula, t2.nombres, t2.codigo FROM socios t2 WHERE t2.cedula = t1.cedula)";

        $socioslista = DB::select($sql);

        //Temp_socio::truncate(); 
    }

    public function ActuNomSocios()
    {
        $sql = "UPDATE socios a, temp_socios b
                SET a.condicion = 1
                WHERE a.cedula = b.cedula";

        $socioslista = DB::select($sql);

        //Temp_socio::truncate();

        
    }

    public function CambSociodata()
    {
        $sql = "UPDATE socios a, temp_socios b
            SET a.codigo = b.codigo
            WHERE a.cedula = b.cedula";

        $socioslista = DB::select($sql);

       Temp_socio::truncate(); 
        
    }

// INSERT INTO movimientos (cedula, apor_ahorro, apor_presta, seguro, mes, ano)
// SELECT cedula, apor_ahorro, apor_presta, seguro, mes, ano
// FROM temp_socios

// INSERT INTO cuentas (ncuenta, cedula, banco, condicion)
// SELECT DISTINCT ncuenta, cedula, banco, condicion
// FROM temp_cuenta
// CREATE TEMPORARY TABLE temporal SELECT tipo_gasto, count(tipo_gasto), ROUND(SUM(valor_base),2) FROM factura WHERE tipo_gasto = 'VIV' AND tipo_gasto = 'vivienda';

// SELECT * FROM temporal;
}
