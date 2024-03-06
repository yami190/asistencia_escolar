<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Centro extends Model
{
   	protected $table = 'centros';
    protected $primaryKey = 'id_centro';
    protected $fillable = ['centro', 'id_municipio'];
}
