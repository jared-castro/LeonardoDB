<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proyectosleonardo', function (Blueprint $table) {
    $table->increments('id_proyecto');

    $table->string('nombre', 255);
    $table->string('descripcion', 255);

    $table->integer('estado')->default(1);
    $table->string('tipo_db', 255);

    $table->unsignedInteger('id_usuario');
    $table->unsignedInteger('creado_por');
    $table->unsignedInteger('modificado_por')->nullable();

    $table->timestamp('fecha_registro')->useCurrent();
    $table->timestamp('fecha_modificacion')->nullable();

    $table->foreign('id_usuario')
          ->references('id_usuario')
          ->on('users');

    $table->foreign('creado_por')
          ->references('id_usuario')
          ->on('users');

    $table->foreign('modificado_por')
          ->references('id_usuario')
          ->on('users');
});

    }

    public function down(): void
    {
        Schema::dropIfExists('proyectosleonardo');
    }
};
