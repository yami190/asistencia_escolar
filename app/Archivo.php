<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Archivo extends Model
{
    protected $table = 'archivo';
    protected $primaryKey = 'id_archivo';
    protected $fillable = ['cedula_socio', 'id_personal', 'fecha_entrega', 'estatus'];
    public $timestamps = false;
}
