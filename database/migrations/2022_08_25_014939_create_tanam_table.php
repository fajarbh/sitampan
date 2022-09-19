<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTanamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tanam', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_komoditas');
            $table->foreign('id_komoditas')->references('id')->on('komoditas');
            $table->unsignedBigInteger('id_petani');
            $table->foreign('id_petani')->references('id')->on('petani');
            $table->date('tanggal_tanam')->index();
            $table->integer('jumlah_tanam');
            $table->integer('luas_tanam');
            $table->string('jenis_pupuk');
            $table->integer('biaya_produksi');
            $table->string('longitude');
            $table->string('latitude');
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
        Schema::dropIfExists('tanam');
    }
}
