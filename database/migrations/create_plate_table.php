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
        Schema::create('plate', function (Blueprint $table) {
            $table->id('plate_id');
            $table->string('plate_title');
            $table->string('plate_image');
            $table->integer('plate_restaurant');
            $table->text('plate_description');
            $table->string('plate_type_food');
            $table->string('plate_portion');
            $table->integer('plate_counter_like');
            $table->string('plate_status');
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
        Schema::dropIfExists('plate');
    }
};
