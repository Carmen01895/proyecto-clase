<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('departamentos')->insert([
            ['nombre_departamento' => 'Ventas'],
            ['nombre_departamento' => 'SoporteTecnico'], 
            ['nombre_departamento' => 'Administracion'], 
            ['nombre_departamento' => 'RecursosHumanos'],
            ['nombre_departamento' => 'Desarrollo'],
        ]);
    }
}