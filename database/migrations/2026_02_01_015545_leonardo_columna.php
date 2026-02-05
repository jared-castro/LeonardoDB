<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LeonardoColumna extends Migration
{
    public function up(): void
    {
    Schema::create('leonardocolumna', function (Blueprint $table) {
    $table->increments('id_columna');
    $table->unsignedInteger('id_tabla');

    $table->string('nombre_columna', 255);
    $table->string('tipo_columna', 255);
    $table->text('longitud_columna')->nullable();
    $table->text('cotejamiento_columna')->nullable();

    $table->integer('nulo_columna')->default(0);
    $table->text('auto_incrementar')->nullable();
    $table->text('indice_tipo')->nullable();

    $table->string('descripcion_columna', 255);

    $table->timestamp('fecha_registro')->useCurrent();

    $table->foreign('id_tabla')
          ->references('id_tabla')
          ->on('leonardotablas');
});

    }

    public function down(): void
    {
        Schema::dropIfExists('leonardocolumna');
    }
};
