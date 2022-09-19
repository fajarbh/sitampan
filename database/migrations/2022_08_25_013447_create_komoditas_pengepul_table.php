<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKomoditasPengepulTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('komoditas_pengepul', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_komoditas');
            $table->foreign('id_komoditas')->references('id')->on('komoditas');
            $table->unsignedBigInteger('id_pengepul');
            $table->foreign('id_pengepul')->references('id')->on('pengepul');
            $table->unsignedBigInteger('id_penyuluh');
            $table->foreign('id_penyuluh')->references('id')->on('penyuluh');
            $table->integer('harga');
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
        Schema::dropIfExists('komoditas_pengepul');
    }
}
