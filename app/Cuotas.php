<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cuotas extends Model
{
    protected $table = 'cuotas';
    protected $primaryKey = 'id_cuota';
    protected $fillable = ['cedula', 'deuda', 'referencia', 'montoP'];
    public $timestamps = false;
}
