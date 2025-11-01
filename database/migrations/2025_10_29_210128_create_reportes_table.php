<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reportes', function (Blueprint $table) {
    $table->id('id_reporte');
    $table->string('nombre_reporte', 200)->nullable();
    $table->string('ruta_reporte', 255)->nullable();
    $table->foreignId('id_ticket')->nullable()->constrained('tickets', 'id_ticket')->nullOnDelete();
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
        Schema::dropIfExists('reportes');
    }
};
