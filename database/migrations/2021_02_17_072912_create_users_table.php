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
            $table->string('email')->unique();
            $table->string('nom')->nullable();
            $table->string('prenom')->nullable();
            $table->string('role');
            $table->string('wilaya')->nullable();
            $table->string('commune')->nullable();
            $table->string('genre')->nullable();
            $table->string('telephone')->nullable();
            $table->string('profile_pic')->nullable();
            $table->string('fonction')->nullable();
            $table->string('description')->nullable();
            $table->string('status');
            $table->string('password');
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
