<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prestamos extends Model
{
    protected $table = 'prestamos';
    protected $primaryKey = 'id_prestamo';
    protected $fillable = ['cedula', 'deuda', 'fecha', 'status'];
    public $timestamps = false;
}
