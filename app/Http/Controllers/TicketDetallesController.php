<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\EstatusTicket;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class TicketDetallesController extends Controller
{
    /**
     * Muestra los tickets asignados al auxiliar (TU LISTA)
     */
    public function index(Request $request)
    {
        try {
            $query = Ticket::with(['usuario', 'departamento', 'estatus'])
                ->where('id_auxiliar', Auth::id());

            // Filtros opcionales
            if ($request->filled('estatus')) {
                $query->where('id_estatus', $request->estatus);
            }

            if ($request->filled('buscar')) {
                $query->where(function($q) use ($request) {
                    $q->where('titulo', 'LIKE', '%' . $request->buscar . '%')
                      ->orWhere('id_ticket', 'LIKE', '%' . $request->buscar . '%');
                });
            }

            $tickets = $query->orderBy('fecha_creacion', 'desc')->paginate(10);
            
            return view('mis_tickets_asignados', compact('tickets'));

        } catch (\Exception $e) {
            Log::error('Error al listar tickets del auxiliar: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al cargar los tickets');
        }
    }

    /**
     * Muestra los detalles de un ticket específico (TU BOTÓN VER DETALLES)
     */
    public function show($id)
    {
        try {
            // Cargar el ticket con todas sus relaciones
            $ticket = Ticket::with(['usuario', 'asignado', 'departamento', 'estatus'])
                ->findOrFail($id);

            // Verificar que el ticket esté asignado al auxiliar autenticado
            if ($ticket->id_auxiliar !== Auth::id()) {
                return redirect()->route('tickets.misAsignados')
                    ->with('error', 'No tienes permiso para ver este ticket');
            }

            // CORRECCIÓN: Pasar el auxiliar autenticado a la vista
            $auxiliar = Auth::user();

            // Pasar tanto el ticket como el auxiliar a la vista
            return view('tickets.ticket_detaller', compact('ticket', 'auxiliar'));

        } catch (\Exception $e) {
            Log::error('Error al mostrar detalles del ticket: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error al cargar los detalles del ticket');
        }
    }

    /**
     * Actualiza el estado del ticket
     */
    public function actualizar(Request $request, $id)
    {
        try {
            // Validar los datos
            $request->validate([
                'estado' => 'required|in:proceso,resuelto',
                'fecha_finalizacion' => 'required_if:estado,resuelto|nullable|date',
                'comentario' => 'nullable|string|max:1000'
            ], [
                'estado.required' => 'Debes seleccionar un estado',
                'estado.in' => 'El estado seleccionado no es válido',
                'fecha_finalizacion.required_if' => 'La fecha de finalización es obligatoria para tickets resueltos',
                'fecha_finalizacion.date' => 'La fecha de finalización no es válida'
            ]);

            // Buscar el ticket
            $ticket = Ticket::findOrFail($id);

            // Verificar permisos
            if ($ticket->id_auxiliar !== Auth::id()) {
                return redirect()->back()
                    ->with('error', 'No tienes permiso para actualizar este ticket');
            }

            // Verificar que el ticket no esté cancelado
            if ($ticket->estatus && $ticket->estatus->nombre_estatus === 'cancelado') {
                return redirect()->back()
                    ->with('error', 'No puedes actualizar un ticket cancelado');
            }

            // Buscar el nuevo estado
            $nuevoEstatus = EstatusTicket::where('nombre_estatus', $request->estado)->first();

            if (!$nuevoEstatus) {
                return redirect()->back()
                    ->with('error', 'El estado seleccionado no existe en el sistema');
            }

            // Actualizar el ticket
            $ticket->id_estatus = $nuevoEstatus->id_estatus;

            if ($request->estado === 'resuelto') {
                $ticket->fecha_finalizacion = Carbon::parse($request->fecha_finalizacion);
            }

            $ticket->save();

            // Historial (Log)
            if ($request->filled('comentario')) {
                Log::info("Comentario en ticket #{$id}: " . $request->comentario);
            }

            return redirect()->back()
                ->with('success', 'Ticket actualizado correctamente');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Por favor, verifica los datos del formulario');

        } catch (\Exception $e) {
            Log::error('Error al actualizar ticket: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al actualizar el ticket: ' . $e->getMessage());
        }
    }
}