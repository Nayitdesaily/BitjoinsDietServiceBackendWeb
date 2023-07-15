<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evolucion', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->decimal('peso');
            $table->decimal('imc');
            $table->decimal('p_grasa');
            $table->decimal('p_masa');
            $table->decimal('cintura');
            $table->decimal('otramedida');
            $table->string('label_otra');
            $table->text('observacion');
            $table->text('actividades');
            $table->integer('usuario_id');
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
        Schema::dropIfExists('evolucion');
    }
};
