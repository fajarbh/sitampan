<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePetaniTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('petani', function (Blueprint $table) {
            $table->id();
            $table->string('nama_petani');
            $table->string('no_hp')->nullable();
            $table->integer('status');
            $table->TEXT('alamat');
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('id_kelompok');
            $table->foreign('id_kelompok')->references('id')->on('kelompok_tani');
            $table->unsignedBigInteger('id_desa');
            $table->foreign('id_desa')->references('id')->on('desa');
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
        Schema::dropIfExists('petani');
    }
}
