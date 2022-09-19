<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKelompokTaniTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kelompok_tani', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kelompok')->unique();
            $table->unsignedBigInteger('id_desa');
            $table->foreign('id_desa')->references('id')->on('desa');
            $table->unsignedBigInteger('id_penyuluh');
            $table->foreign('id_penyuluh')->references('id')->on('penyuluh');
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
        Schema::dropIfExists('kelompok_tani');
    }
}
