<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alumnos extends Model
{
    protected $table = 'alumnos';
    protected $primaryKey = 'id_alumno';
    protected $fillable = ['cedul_esco', 'apellidos', 'nombres', 'sexo','fecha_naci','estado','entidad','fecha_egre','id_matricula','estatus'];
    public $timestamps = false;
}
