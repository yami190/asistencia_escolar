<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContabilidadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contabilidad', function (Blueprint $table) {
            $table->Increments('id_contabilidad');
            $table->integer('cedula');
            $table->char('referencia', 20);
            $table->char('observacion', 255);
            $table->integer('mes');
            $table->Integer('condicion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contabilidad');
    }
}
