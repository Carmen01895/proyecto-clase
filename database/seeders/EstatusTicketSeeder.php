<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class EstatusTicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Deshabilitar restricciones de llave foránea
        Schema::disableForeignKeyConstraints();
        
        // Limpiar la tabla primero
        DB::table('estatus_ticket')->truncate();
        
        // Habilitar restricciones de llave foránea
        Schema::enableForeignKeyConstraints();

        $estatus = [
            [
                'id_estatus' => 1, // AGREGAR ESTA LÍNEA
                'nombre_estatus' => 'pendiente',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_estatus' => 2, // AGREGAR ESTA LÍNEA
                'nombre_estatus' => 'proceso',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_estatus' => 3, // AGREGAR ESTA LÍNEA
                'nombre_estatus' => 'resuelto',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_estatus' => 4, // AGREGAR ESTA LÍNEA
                'nombre_estatus' => 'cancelado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('estatus_ticket')->insert($estatus);

        $this->command->info('✓ Estatus de tickets creados correctamente');
    }
}