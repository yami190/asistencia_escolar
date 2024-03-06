<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nomina_caja extends Model
{
    protected $table = 'Nomina_caja';
    protected $primaryKey = 'id_personal';
    protected $fillable = ['cedula', 'nombre', 'cargo', 'tipo_nomina', 'fecha_ingreso', 'condicion'];
}
