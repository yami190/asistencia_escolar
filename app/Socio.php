<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Socio extends Model
{
    protected $table = 'socios';
    protected $primaryKey = 'id_socio';
    protected $fillable = ['codigo','nombres', 'cedula', 'descripcion', 'condicion'];

    public function nominas(){
    	return $this->belongsTo('App\Nomina', 'codigo', 'codigo');
    }

    public function movimientos(){
    	return $this->hasMany('App\Movimiento', 'cedula', 'cedula');
    }
}
