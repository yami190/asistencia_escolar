<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    protected $table = 'eventos';
    protected $fillable = ['titulo','descripcion','tipo','fecha','end_date','color','id_usuario'];
}
