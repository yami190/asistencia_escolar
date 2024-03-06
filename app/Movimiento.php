<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    protected $table = 'movimientos';
    protected $primaryKey = 'id_movimiento';
    protected $fillable = ['cedula', 'apor_ahorro', 'apor_presta'];
}
