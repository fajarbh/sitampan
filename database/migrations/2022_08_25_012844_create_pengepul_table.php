<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengepulTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengepul', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pengepul')->unique();
            $table->string('kontak')->nullable();
            $table->TEXT('alamat')->nullable();
            $table->string('lokasi_distribusi');
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
        Schema::dropIfExists('pengepul');
    }
}
