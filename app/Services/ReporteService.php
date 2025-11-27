<?php

namespace App\Services;

use App\Models\GestionTicket;
use App\Models\EstatusTicket;
use Illuminate\Support\Collection;

class ReporteService
{
    /**
     * Obtiene tickets filtrados según criterios
     */
    public function obtenerTicketsFiltrados($estatus_id = null, $auxiliar_id = null, $departamento_id = null)
    {
        $query = GestionTicket::query()->with(['usuario', 'departamento', 'estatus', 'auxiliar']);

        if ($estatus_id) {
            $query->where('id_estatus', $estatus_id);
        }

        if ($auxiliar_id) {
            $query->where('id_auxiliar', $auxiliar_id);
        }

        if ($departamento_id) {
            $query->where('id_departamento', $departamento_id);
        }

        return $query->get();
    }

    /**
     * Calcula estadísticas para los gráficos
     */
    public function calcularEstadisticas($tickets)
    {
        return [
            'total' => $tickets->count(),
            'por_estatus' => $this->contarPorEstatus($tickets),
            'por_auxiliar' => $this->contarPorAuxiliar($tickets),
            'por_departamento' => $this->contarPorDepartamento($tickets),
            'tiempo_promedio' => $this->calcularTiempoPromedio($tickets),
        ];
    }

    /**
     * Cuenta tickets por estatus
     */
    private function contarPorEstatus($tickets): array
    {
        $conteos = $tickets->groupBy('id_estatus')
            ->map(fn($grupo) => $grupo->count())
            ->toArray();

        $etiquetas = EstatusTicket::whereIn('id_estatus', array_keys($conteos))->get();
        
        $resultado = [];
        foreach ($etiquetas as $estatus) {
            $resultado[$estatus->nombre] = $conteos[$estatus->id_estatus] ?? 0;
        }

        return $resultado;
    }

    /**
     * Cuenta tickets por auxiliar
     */
    private function contarPorAuxiliar($tickets): array
    {
        return $tickets->groupBy(function($ticket) {
            return $ticket->auxiliar?->nombre ?? 'Sin asignar';
        })
        ->map(fn($grupo) => $grupo->count())
        ->toArray();
    }

    /**
     * Cuenta tickets por departamento
     */
    private function contarPorDepartamento($tickets): array
    {
        return $tickets->groupBy(function($ticket) {
            return $ticket->departamento?->nombre_departamento ?? 'Sin departamento';
        })
        ->map(fn($grupo) => $grupo->count())
        ->toArray();
    }

    /**
     * Calcula tiempo promedio de resolución (en días)
     */
    private function calcularTiempoPromedio($tickets): float
    {
        if ($tickets->isEmpty()) {
            return 0;
        }

        $tiempos = $tickets->map(function ($ticket) {
            $inicio = $ticket->fecha_creacion;
            $fin = $ticket->fecha_finalizacion ?? now();
            return \Carbon\Carbon::parse($fin)->diffInDays(\Carbon\Carbon::parse($inicio));
        });

        return round($tiempos->avg(), 2);
    }

    /**
     * Obtiene datos para gráfico de línea (evolución temporal)
     */
    public function obtenerEvolucionTemporal($estatus_id = null, $auxiliar_id = null, $departamento_id = null)
    {
        $query = GestionTicket::query();

        if ($estatus_id) {
            $query->where('id_estatus', $estatus_id);
        }
        if ($auxiliar_id) {
            $query->where('id_auxiliar', $auxiliar_id);
        }
        if ($departamento_id) {
            $query->where('id_departamento', $departamento_id);
        }

        // Agrupa por fecha y cuenta
        $datos = $query->selectRaw('DATE(fecha_creacion) as fecha, COUNT(*) as total')
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->get();

        return $datos->mapWithKeys(fn($item) => [$item->fecha => $item->total])->toArray();
    }
}
