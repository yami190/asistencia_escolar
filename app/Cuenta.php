<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cuenta extends Model
{
    protected $table = 'cuentas';
    protected $primaryKey = 'id_cuenta';
    protected $fillable = ['Cedula', 'ncuenta', 'banco', 'condicion'];
}
