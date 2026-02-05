<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LeonardoAPI extends Migration
{
   public function up(): void
    {
        Schema::create('leonardoapi', function (Blueprint $table) {
    $table->increments('id_api');

    $table->text('api_key');
    $table->text('end_point');
    $table->text('modelo');

    $table->unsignedInteger('id_usuario');

    $table->timestamp('fecha_registro')->useCurrent();

    $table->foreign('id_usuario')
          ->references('id_usuario')
          ->on('users');
});

    }

    public function down(): void
    {
        Schema::dropIfExists('leonardoapi');
    }
};