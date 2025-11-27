<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GestionTicket;
use App\Models\User;
use App\Models\Departamento;
use App\Models\EstatusTicket;
use App\Services\ReporteService;
use Barryvdh\DomPDF\Facade\Pdf;

class ReporteController extends Controller
{
    protected $reporteService;

    public function __construct(ReporteService $reporteService)
    {
        $this->reporteService = $reporteService;
    }

    /**
     * Muestra el formulario con filtros para generar el reporte.
     */
    public function index()
    {
        $tickets = GestionTicket::with(['usuario', 'departamento', 'estatus', 'auxiliar'])->get();

        return view('reportes.index', [
            'auxiliares'     => User::where('id_rol', 3)->get(),
            'departamentos'  => Departamento::all(),
            'estatus'        => EstatusTicket::all(),
            'tickets'        => $tickets,
        ]);
    }

    /**
     * Obtiene estadísticas y datos para los gráficos (AJAX)
     */
    public function obtenerEstadisticas(Request $request)
    {
        $estatus_id       = $request->estatus_id ?? null;
        $auxiliar_id      = $request->auxiliar_id ?? null;
        $departamento_id  = $request->departamento_id ?? null;

        $tickets = $this->reporteService->obtenerTicketsFiltrados(
            $estatus_id,
            $auxiliar_id,
            $departamento_id
        );

        $estadisticas = $this->reporteService->calcularEstadisticas($tickets);

        $evolucion = $this->reporteService->obtenerEvolucionTemporal(
            $estatus_id,
            $auxiliar_id,
            $departamento_id
        );

        return response()->json([
            'estadisticas' => $estadisticas,
            'evolucion'    => $evolucion
        ]);
    }

    /**
     * Genera y descarga el PDF según los filtros aplicados.
     */
    public function generarPDF(Request $request)
    {
        $estatus_id       = $request->estatus_id ?? null;
        $auxiliar_id      = $request->auxiliar_id ?? null;
        $departamento_id  = $request->departamento_id ?? null;

        $tickets = $this->reporteService->obtenerTicketsFiltrados(
            $estatus_id,
            $auxiliar_id,
            $departamento_id
        );

        $estadisticas = $this->reporteService->calcularEstadisticas($tickets);

        $pdf = Pdf::loadView('reportes.pdf', [
            'tickets'     => $tickets,
            'estadisticas'=> $estadisticas,
            'filtros'     => $request->all()
        ])->setPaper('letter', 'portrait');

        return $pdf->download(
            'Reporte_Tickets_' . now()->format('d-m-Y_H-i-s') . '.pdf'
        );
    }
}
