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
        Schema::create('persona', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('apellido');
            $table->tinyInteger('telefono');
            $table->integer('empresa_id');
            $table->string('ocupacion');
            $table->integer('talla');
            $table->string('peso_ideal');
            $table->integer('distrito');
            $table->string('p_grasa_ideal');
            $table->string('p_masa_muscular');
            $table->integer('consultorio_id');
            $table->text('gustos');
            $table->text('no_gustos');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personas');
    }
};
