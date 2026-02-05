<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LeonardoRelacion extends Migration
{
     public function up(): void
    {
    Schema::create('leonardorelacion', function (Blueprint $table) {
    $table->increments('id_relacion');
    $table->unsignedInteger('id_columna_1');
    $table->unsignedInteger('id_columna_2');

    $table->string('color_relacion', 255);


    $table->foreign('id_columna_1')
                ->references('id_columna')
                ->on('leonardocolumna')
                ->onDelete('cascade');

    $table->foreign('id_columna_2')
                ->references('id_columna')
                ->on('leonardocolumna')
                ->onDelete('cascade');
});

    }

    public function down(): void
    {
        Schema::dropIfExists('leonardorelacion');
    }
};