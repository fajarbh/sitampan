<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePanenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('panen', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_petani');
            $table->foreign('id_petani')->references('id')->on('petani');
            $table->unsignedBigInteger('id_tanam');
            $table->foreign('id_tanam')->references('id')->on('tanam');
            $table->unsignedBigInteger('id_komoditas');
            $table->foreign('id_komoditas')->references('id')->on('komoditas');
            $table->date('tanggal_panen');
            $table->integer('jumlah_panen');
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
        Schema::dropIfExists('panen');
    }
}
