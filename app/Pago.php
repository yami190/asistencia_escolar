<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $table = 'pagos';
    protected $primaryKey = 'id_pago';
    protected $fillable = ['id_socio', 'banco_analista', 'monto_socio', 'refrecibida', 'fecharecibido', 'id_analista', 'banco_caja', 'referencia', 'monto_caja', 'fecha'];
    public $timestamps = false;
}
