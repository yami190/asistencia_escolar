<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contabilidad extends Model
{
    protected $table = 'contabilidad';
    protected $primaryKey = 'id_contabilidad';
    protected $fillable = ['beneficiario', 'referencia', 'observacion', 'mes','condicion', 'id_banco','monto', 'fecha'];
}
