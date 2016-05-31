<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSphKodLokasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sph_kod_lokasi', function (Blueprint $table) {
            $table->integer('kod_id')->nullable();
            $table->string('butiran',50)->nullable();
            $table->string('initial,25')->nullable();
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
        Schema::drop('sph_kod_lokasi');
    }
}
