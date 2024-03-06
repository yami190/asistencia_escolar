<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nomina extends Model
{
    protected $table = 'nominas';
    protected $primaryKey = 'id_nomina';
    protected $fillable = ['nombre', 'descripcion', 'condicion'];
}