<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LeonardoPosision extends Migration
{
    public function up(): void
    {
    Schema::create('leonardoposicion', function (Blueprint $table) {
    $table->increments('id_posicion');
    $table->unsignedInteger('id_tabla');

    $table->text('pos_x')->nullable();
    $table->text('pos_y')->nullable();

    $table->foreign('id_tabla')
          ->references('id_tabla')
          ->on('leonardotablas');
});

    }

    public function down(): void
    {
        Schema::dropIfExists('leonardoposicion');
    }
};
