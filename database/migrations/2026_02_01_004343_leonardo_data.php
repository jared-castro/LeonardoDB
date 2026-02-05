<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LeonardoData extends Migration
{
    public function up(): void
    {
        Schema::create('leonardotablas', function (Blueprint $table) {
    $table->increments('id_tabla');

    $table->string('nombre_tabla', 255);
    $table->string('color_tabla', 255);

    $table->unsignedInteger('id_proyecto');

    $table->timestamp('fecha_registro')->useCurrent();

    $table->foreign('id_proyecto')
          ->references('id_proyecto')
          ->on('proyectosleonardo');
});

    }

    public function down(): void
    {
        Schema::dropIfExists('leonardotablas');
    }
};
