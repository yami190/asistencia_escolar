<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    protected $table = 'asistencias';
    protected $primaryKey = 'id_asistencia';
    protected $fillable = ['id_alumno', 'id_personal','fecha','asistio'];
    public $timestamps = false;
}
