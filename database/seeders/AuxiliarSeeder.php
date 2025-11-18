<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuxiliarSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'nombre' => 'Auxiliar',
            'apellido' => 'Demo',
            'correo' => 'auxiliar@demo.com',
            'puesto' => 'Auxiliar Técnico',
            'password' => Hash::make('123456'),
            'foto_perfil' => null,
            'id_departamento' => 2,
            'id_rol' => 1,
            'activo' => 1
        ]);
    }
}
