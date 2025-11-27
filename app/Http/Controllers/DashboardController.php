<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket; 
use App\Models\Departamento; 
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. OBTENER LOS KDIs (INDICADORES CLAVE)
        
        $startOfMonth = Carbon::now()->startOfMonth();
        
        // Total de Entradas (Todos los tickets)
        $totalTickets = Ticket::count(); 
        
        // Entradas Cerradas (RESUELTOS: 3 + CANCELADOS: 4) en el mes actual
        $ticketsCerradosMes = Ticket::whereIn('id_estatus', [3, 4])
                                    ->whereDate('fecha_finalizacion', '>=', $startOfMonth)
                                    ->count();
                                    
        // Entradas Pendientes (PENDIENTE: 1 + PROCESO: 2)
        $ticketsPendientes = Ticket::whereIn('id_estatus', [1, 2])->count();
        
        // -------------------------------------------------------------------
        // CÁLCULO REAL DEL TIEMPO PROMEDIO DE RESPUESTA (FINAL CORRECCIÓN)
        // -------------------------------------------------------------------
        
        $avgSecondsResult = DB::table('tickets')
            // CLAVE: Usamos ABS() para tomar el valor absoluto y corregir el error de fechas negativas.
            ->select(DB::raw('AVG(ABS(UNIX_TIMESTAMP(fecha_finalizacion) - UNIX_TIMESTAMP(fecha_creacion))) AS avg_seconds'))
            ->whereIn('id_estatus', [3, 4]) // Solo tickets Resueltos o Cancelados
            ->whereNotNull('fecha_finalizacion') // Solo donde hay una fecha de cierre válida
            ->first();

        // El AVG siempre será positivo (o 0) gracias a ABS()
        $avgSeconds = $avgSecondsResult->avg_seconds ?? 0;
        
        $tiempoPromedioRespuesta = 'N/A';
        
        // Ahora solo necesitamos verificar que sea mayor que cero para calcular el tiempo.
        if ($avgSeconds > 0) { 
            // Convertir segundos a formato "HH hrs MM mins"
            $hours = floor($avgSeconds / 3600);
            $minutes = floor(($avgSeconds % 3600) / 60);

            $tiempoPromedioRespuesta = '';
            
            if ($hours > 0) {
                $tiempoPromedioRespuesta .= "{$hours} hrs ";
            }
            if ($minutes > 0) {
                 $tiempoPromedioRespuesta .= "{$minutes} mins";
            }
            
            // Si el promedio es menos de un minuto, pero mayor a 0 segundos
            if ($hours == 0 && $minutes == 0) {
                 $tiempoPromedioRespuesta = 'Menos de 1 min';
            }
        } 
        
        // -------------------------------------------------------------------
        // 2. DATOS PARA EL GRÁFICO 1: RENDIMIENTO MENSUAL
        // -------------------------------------------------------------------

        $seisMesesAtras = Carbon::now()->subMonths(5)->startOfMonth();
        
        // --- Consulta 1: Tickets CREADOS por mes de creación ---
        $creados = DB::table('tickets')
            ->select(
                DB::raw('YEAR(fecha_creacion) as anio'),
                DB::raw('MONTH(fecha_creacion) as mes'),
                DB::raw('COUNT(*) as creados')
            )
            ->where('fecha_creacion', '>=', $seisMesesAtras)
            ->groupBy('anio', 'mes')
            ->get()
            ->keyBy(function ($item) {
                return $item->anio . '-' . $item->mes;
            });

        // --- Consulta 2: Tickets CERRADOS por mes de finalización ---
        $cerrados = DB::table('tickets')
            ->select(
                DB::raw('YEAR(fecha_finalizacion) as anio'),
                DB::raw('MONTH(fecha_finalizacion) as mes'),
                DB::raw('COUNT(*) as cerrados')
            )
            ->whereIn('id_estatus', [3, 4]) 
            ->where('fecha_finalizacion', '>=', $seisMesesAtras)
            ->whereNotNull('fecha_finalizacion') 
            ->groupBy('anio', 'mes')
            ->get()
            ->keyBy(function ($item) {
                return $item->anio . '-' . $item->mes;
            });
            
        // --- 3. Combinar y Formatear los datos para Chart.js ---
        $datosRendimiento = collect();
        $mesActual = Carbon::now()->startOfMonth();
        for ($i = 0; $i < 6; $i++) {
            $mes = $mesActual->copy()->subMonths($i);
            $key = $mes->year . '-' . $mes->month;

            $datosRendimiento->push((object)[
                'anio' => $mes->year,
                'mes' => $mes->month,
                'creados' => $creados->get($key)?->creados ?? 0, 
                'cerrados' => $cerrados->get($key)?->cerrados ?? 0,
            ]);
        }
        $datosRendimiento = $datosRendimiento->reverse()->values();


        // -------------------------------------------------------------------
        // 3. DATOS PARA EL GRÁFICO 2: TICKETS POR DEPARTAMENTO
        // -------------------------------------------------------------------
        
        $datosDepartamentos = DB::table('tickets')
            ->join('departamentos', 'tickets.id_departamento', '=', 'departamentos.id_departamento')
            ->select(
                'departamentos.nombre_departamento',
                DB::raw('COUNT(tickets.id_ticket) as total')
            )
            ->groupBy('departamentos.nombre_departamento')
            ->get();


        // 4. PASAR TODOS LOS DATOS A LA VISTA
        return view('dashboard', compact(
            'totalTickets', 
            'ticketsCerradosMes', 
            'ticketsPendientes', 
            'tiempoPromedioRespuesta', // <-- ¡Ahora calculado correctamente!
            'datosRendimiento', 
            'datosDepartamentos'
        ));
    }
}