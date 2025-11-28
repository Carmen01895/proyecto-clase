<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GestionTicket;
use App\Models\User;
use App\Models\Departamento;
use App\Models\EstatusTicket;
use Carbon\Carbon;
use App\Models\ticket;

class GestionTicketsController extends Controller
{
    public function index(Request $request)
    {
        Carbon::setLocale('es');

        $query = GestionTicket::with(['usuario', 'auxiliar', 'departamento', 'estatus']);

        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            $query->whereBetween('fecha_creacion', [
                Carbon::parse($request->fecha_inicio)->startOfDay(),
                Carbon::parse($request->fecha_fin)->endOfDay()
            ]);
        }

        if ($request->filled('estatus')) {
            $query->where('id_estatus', $request->estatus);
        }

        if ($request->filled('mes')) {
            $query->whereMonth('fecha_creacion', $request->mes);
        }

        if ($request->filled('semana')) {
            $query->whereRaw('WEEK(fecha_creacion, 1) = ?', [$request->semana]);
        }

        if ($request->filled('departamento')) {
            $query->where('id_departamento', $request->departamento);
        }

        if ($request->filled('auxiliar')) {
            $query->where('id_auxiliar', $request->auxiliar);
        }

        $tickets = $query->orderBy('fecha_creacion', 'desc')->paginate(6);

        $auxiliares = User::whereHas('rol', function ($q) {
            $q->where('nombre_rol', 'Administrador');
        })->get();

        $departamentos = Departamento::all();
        $estatus = EstatusTicket::all();

        return view('tickets.GestionTickets', compact('tickets', 'auxiliares', 'departamentos', 'estatus'));
    }

    public function asignar(Request $request, $id)
    {
        $ticket = GestionTicket::findOrFail($id);
        $ticket->id_auxiliar = $request->id_auxiliar;
        $ticket->id_jefe = auth()->user()->id_usuario ?? null;

        $estatusProceso = EstatusTicket::where('nombre_estatus', 'Proceso')->first();
        if ($estatusProceso) {
            $ticket->id_estatus = $estatusProceso->id_estatus;
        }

        $ticket->fecha_asignacion = now();
        $ticket->save();

        return redirect()->back()->with('success', 'Ticket asignado correctamente');
    }

    public function cancelarAsignacion($id)
    {
        $ticket = GestionTicket::findOrFail($id);

        $ticket->id_auxiliar = null;
        $ticket->id_jefe = null;
        $ticket->fecha_asignacion = null;

        $estatusPendiente = EstatusTicket::where('nombre_estatus', 'Pendiente')->first();
        if ($estatusPendiente) {
            $ticket->id_estatus = $estatusPendiente->id_estatus;
        }

        $ticket->save();

        return redirect()->back()->with('success', 'Asignación cancelada');
    }

     public function verDetalle($id)
    {
        // Usamos 'Ticket' en lugar de 'GestionTicket'
        $ticket = Ticket::findOrFail($id);

        return response()->json([
            'titulo' => 'Ticket #' . $ticket->id_ticket . ': ' . $ticket->titulo,
            'descripcion' => $ticket->descripcion,
            'evidencia' => $ticket->evidencia ? asset('storage/' . $ticket->evidencia) : null,
        ]);
    }
}
