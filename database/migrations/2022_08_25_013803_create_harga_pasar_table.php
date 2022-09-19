<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHargaPasarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('harga_pasar', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_penyuluh');
            $table->foreign('id_penyuluh')->references('id')->on('penyuluh');
            $table->unsignedBigInteger('id_komoditas');
            $table->foreign('id_komoditas')->references('id')->on('komoditas');
            $table->date('periode_bulan');
            $table->integer('harga_pasar_lokal');
            $table->integer('harga_pasar_induk');
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
        Schema::dropIfExists('harga_pasar');
    }
}
