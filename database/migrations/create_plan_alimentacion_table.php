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
        Schema::create('plan_alimentacions', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->date('fec_ultima_act');
            $table->text('tips');
            $table->text('notas');
            $table->integer('usuario_id');
            $table->integer('nutricionista_id');
            $table->decimal('kcal_total');
            $table->decimal('peso');
            $table->integer('p_cho');
            $table->integer('p_prot');
            $table->integer('p_grasas');
            $table->tinyInteger('tipo');
            $table->tinyInteger('estado');

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
        Schema::dropIfExists('plan_alimentacion');
    }
};
