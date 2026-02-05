<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leonardorindex', function (Blueprint $table) {
            $table->increments('id_index');
            $table->unsignedInteger('id_tabla');
            $table->unsignedInteger('id_columna');

            $table->foreign('id_tabla')
                  ->references('id_tabla')
                  ->on('leonardotablas')
                  ->onDelete('cascade');

            $table->foreign('id_columna')
                  ->references('id_columna')
                  ->on('leonardocolumna')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leonardorindex');
    }
};