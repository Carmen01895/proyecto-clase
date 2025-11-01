<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // <-- IMPORTANTE

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id('id_ticket');
            $table->string('titulo', 200);
            $table->text('descripcion')->nullable();
            $table->dateTime('fecha_creacion')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('fecha_finalizacion')->nullable();
            
            $table->foreignId('id_usuario')
                  ->nullable()
                  ->constrained('usuarios', 'id_usuario')
                  ->nullOnDelete();
            $table->foreignId('id_auxiliar')
                  ->nullable()
                  ->constrained('usuarios', 'id_usuario')
                  ->nullOnDelete();
            $table->foreignId('id_departamento')
                  ->nullable()
                  ->constrained('departamentos', 'id_departamento')
                  ->nullOnDelete();
            $table->foreignId('id_estatus')
                  ->nullable()
                  ->constrained('estatus_ticket', 'id_estatus')
                  ->nullOnDelete();
            $table->foreignId('id_jefe')
                  ->nullable()
                  ->constrained('usuarios', 'id_usuario')
                  ->nullOnDelete();

            $table->dateTime('fecha_asignacion')->nullable();
            $table->string('evidencia')->nullable();
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
        Schema::dropIfExists('tickets');
    }
};
