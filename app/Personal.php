<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    protected $table = 'personal';

    // Clave primaria de la tabla
    protected $primaryKey = 'id_personal';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'cedula',
        'nombre_apellido',
        'cargo',
        'tipo_personal',
        'fecha',
        'sexo',
        'horas_academicas',
        'horas_adm',
        'grado',
        'titulo',
        'tiempo_servicio',
        'seccion',
        'telefono',
        'correo'
    ];
    public $timestamps = false;

}
