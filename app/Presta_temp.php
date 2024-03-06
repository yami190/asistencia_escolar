<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Presta_temp extends Model
{
    protected $table = 'presta_temp';
    protected $primaryKey = 'id_prestamo';
    protected $fillable = ['cedula', 'monto', 'descuento', 'frecuencia', 'cuotas' , 'fecha_registro', 'estatus'];
    public $timestamps = false;
}
