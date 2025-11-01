<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // <-- Asegúrate de usar la clase DB

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            ['nombre_rol' => 'Administrador'], // Rol con todos los permisos
            ['nombre_rol' => 'JefeDeDepartamento'], 
            ['nombre_rol' => 'Empleado'], 
            // Agrega cualquier otro rol que necesite tu sistema
        ]);
    }
}
