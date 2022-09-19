<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHargaKelompokTaniTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('harga_kelompok_tani', function (Blueprint $table) {
            $table->id();
            $table->date('periode_bulan');
            $table->integer('harga_tani');
            $table->unsignedBigInteger('id_komoditas');
            $table->foreign('id_komoditas')->references('id')->on('komoditas');
            $table->unsignedBigInteger('id_petani');
            $table->foreign('id_petani')->references('id')->on('petani');
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
        Schema::dropIfExists('harga_kelompok_tani');
    }
}
