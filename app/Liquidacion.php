<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Liquidacion extends Model
{
    protected $table = 'liquidaciones';
    protected $primaryKey = 'id_liquidacion';
    protected $fillable = ['cedula', 'monto', 'fecha_liquidacion', 'estatus'];
    public $timestamps = false;
}
