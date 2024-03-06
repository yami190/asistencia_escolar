<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mov_temp extends Model
{
    protected $table = 'mov_temp';
    protected $primaryKey = 'id_movimiento';
    protected $fillable = ['cedula',  'apor_ahorro', 'apor_presta', 'seguro',  'mes', 'ano', 'condicion'];
    
    public $timestamps = false;
}
