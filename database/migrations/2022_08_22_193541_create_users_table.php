<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nik')->unique();
            $table->string('no_hp')->nullable();
            // $2y$10$0CCI2uNMUB17eSJnl0OkY.Knw2A0u42Y3RCKHYRuGZNjZdV1ljMUa
            $table->string('password');
            $table->boolean('is_verified')->default(false);
            $table->string('api_token')->nullable();
            $table->tinyInteger('level');
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
        Schema::dropIfExists('users');
    }
}
