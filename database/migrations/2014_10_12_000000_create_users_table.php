<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id_usuario');

            $table->string('nombre', 250);
            $table->string('usuario', 250);
            $table->string('correo', 250);
            $table->text('contrasena');

            $table->timestamp('fecha_creacion')->useCurrent();
        });

    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
