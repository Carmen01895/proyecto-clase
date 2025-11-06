<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Ticket;
use App\Models\EstatusTicket;
use App\Models\User;

class TicketsEjemploSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Obtener los estatus
        $estatusProceso = EstatusTicket::where('nombre_estatus', 'proceso')->first();
        $estatusResuelto = EstatusTicket::where('nombre_estatus', 'resuelto')->first();
        
        // Obtener un usuario existente (usaremos el usuario con ID 3 como en tus otros seeders)
        $usuario = User::find(3);

        if (!$usuario) {
            $this->command->error('No se encontró el usuario con ID 3');
            return;
        }

        if (!$estatusProceso || !$estatusResuelto) {
            $this->command->error('No se encontraron los estatus necesarios. Ejecuta primero EstatusTicketSeeder.');
            return;
        }

        $tickets = [
            // Tickets en "En proceso"
            [
                'titulo' => 'Problema con acceso a red WiFi',
                'descripcion' => 'No puedo conectarme a la red WiFi de la oficina desde mi laptop. El equipo detecta la red pero no se puede establecer la conexión. He intentado reiniciar el adaptador de red pero el problema persiste.',
                'fecha_creacion' => now()->subDays(2),
                'fecha_finalizacion' => null,
                'id_estatus' => $estatusProceso->id_estatus,
                'id_usuario' => $usuario->id_usuario,
                'id_auxiliar' => null,
                'id_departamento' => null,
                'id_jefe' => null,
                'fecha_asignacion' => now()->subDays(1),
                'evidencia' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'titulo' => 'Solicitud de software especializado',
                'descripcion' => 'Necesito instalar AutoCAD para realizar planos de arquitectura en el proyecto actual. El software es esencial para cumplir con los plazos de entrega del cliente.',
                'fecha_creacion' => now()->subDays(1),
                'fecha_finalizacion' => null,
                'id_estatus' => $estatusProceso->id_estatus,
                'id_usuario' => $usuario->id_usuario,
                'id_auxiliar' => null,
                'id_departamento' => null,
                'id_jefe' => null,
                'fecha_asignacion' => now()->subHours(12),
                'evidencia' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],

            // Tickets en "Resuelto"
            [
                'titulo' => 'Reparación de teclado',
                'descripcion' => 'Las teclas F1-F12 no funcionan correctamente en mi teclado. Al presionarlas no responden o ejecutan funciones incorrectas. Esto afecta mi productividad con los atajos de teclado.',
                'fecha_creacion' => now()->subDays(5),
                'fecha_finalizacion' => now()->subDays(1),
                'id_estatus' => $estatusResuelto->id_estatus,
                'id_usuario' => $usuario->id_usuario,
                'id_auxiliar' => null,
                'id_departamento' => null,
                'id_jefe' => null,
                'fecha_asignacion' => now()->subDays(4),
                'evidencia' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'titulo' => 'Configuración de correo en móvil',
                'descripcion' => 'Necesito ayuda para configurar mi correo corporativo en iPhone. He intentado seguir las instrucciones pero me da error de autenticación. Necesito acceso al correo para revisar documentos importantes fuera de la oficina.',
                'fecha_creacion' => now()->subDays(3),
                'fecha_finalizacion' => now()->subDays(1),
                'id_estatus' => $estatusResuelto->id_estatus,
                'id_usuario' => $usuario->id_usuario,
                'id_auxiliar' => null,
                'id_departamento' => null,
                'id_jefe' => null,
                'fecha_asignacion' => now()->subDays(2),
                'evidencia' => null,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        // Insertar los tickets
        foreach ($tickets as $ticket) {
            DB::table('tickets')->insert($ticket);
        }

        $this->command->info('✓ 4 tickets de ejemplo insertados correctamente (2 en proceso, 2 resueltos)');
    }
}