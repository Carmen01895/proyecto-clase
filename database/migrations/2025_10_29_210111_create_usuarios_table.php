<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('id_usuario');
            $table->string('nombre', 100);
            $table->string('apellido', 100)->nullable();
            $table->string('correo', 150)->unique();
            $table->string('puesto', 100)->nullable();
            $table->string('password');
            $table->string('foto_perfil')->nullable();
            $table->foreignId('id_departamento')
                  ->nullable()
                  ->constrained('departamentos', 'id_departamento')
                  ->nullOnDelete();
            $table->foreignId('id_rol')
                  ->nullable()
                  ->constrained('roles', 'id_rol')
                  ->nullOnDelete();
            $table->dateTime('fecha_registro')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
};
