<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Temp_socio extends Model
{
    protected $table = 'temp_socios';
    protected $primaryKey = 'id';
    protected $fillable = ['cedula', 'nombres', 'codigo', 'apor_ahorro', 'apor_presta', 'seguro', 'mes', 'ano'];
    public $timestamps = false;
}
