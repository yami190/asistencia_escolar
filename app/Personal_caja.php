<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Personal_caja extends Model
{
    protected $table = 'personal_caja';
    protected $primaryKey = 'id_personal';
    protected $fillable = ['cedula', 'nombre', 'cargo', 'tipo_nomina', 'fecha_ingreso', 'condicion'];
    public $timestamps = false;

}
