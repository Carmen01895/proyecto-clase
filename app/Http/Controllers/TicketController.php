<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\EstatusTicket;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::check()){
            return redirect()->route('login')->with('error', 'Debes iniciar sesión');
        }

        try{
            $query = Ticket::with(['estatus', 'asignado', 'departamento'])
                           ->where('id_usuario', Auth::id());
            if ($request->has('filtro_estado') && $request->filtro_estado !== 'todos') {
                $query->whereHas('estatus', function($q) use ($request) {
                    $q->where('nombre_estatus', $request->filtro_estado);
                });
            }

            if ($request->has('buscar_id') && !empty($request->buscar_id)) {
                $query->where('id_ticket', 'LIKE', '%' . $request->buscar_id . '%');
            }

            $ordenar = $request->get('ordenar_por', 'fecha-desc');
            switch ($ordenar) {
                case 'fecha-asc':
                    $query->orderBy('fecha_creacion', 'asc');
                    break;
                case 'estado':
                    $query->orderBy('id_estatus', 'asc');
                    break;
                default: // fecha desc
                    $query->orderBy('fecha_creacion', 'desc');
                    break;
            }
            $tickets = $query->paginate(10)->appends($request->all());
            $usuario = Auth::user();

            return view('historial_tickets', compact('tickets', 'usuario'));

        } catch (\Exception $e) {
            Log::error('Error en index de tickets: ' . $e->getMessage());
            
            $tickets = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 10);
            $usuario = Auth::user();
            
            return view('historial_tickets', compact('tickets', 'usuario'))
                   ->with('error', 'Error al cargar los tickets: ' . $e->getMessage());
        }
    }
    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para crear un ticket');
        }

        $usuario = Auth::user();
        $estatus = EstatusTicket::all();

        return view('tickets.create', compact('usuario', 'estatus'));
    }
    public function store(Request $request)
    {
        try {
            $request->validate([
                'titulo' => 'required|string|min:8|max:100',
                'descripcion' => 'required|string|min:20',
                'archivo' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            ]);

            $estatusPendiente = EstatusTicket::where('nombre_estatus', 'pendiente')->first();

            if (!$estatusPendiente) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Error: No existe el estado "pendiente". Por favor, ejecuta el seeder de estatus');
            }

            $ticket = new Ticket();
            $ticket->titulo = $request->titulo;
            $ticket->descripcion = $request->descripcion;
            $ticket->id_usuario = Auth::id();
            $ticket->id_estatus = $estatusPendiente->id_estatus;

            if ($request->hasFile('archivo')) {
                $file = $request->file('archivo');
                $path = $file->store('evidencias', 'public');
                $ticket->evidencia = $path;
            }

            $ticket->save();

            return redirect()->route('tickets.historial')->with('success', 'Ticket registrado correctamente');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Por favor, verifica los datos del formulario');
        } catch (\Exception $e) {
            Log::error('Error al crear ticket: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al registrar el ticket: ' . $e->getMessage());
        }
    }
    public function cancelar($id)
    {
        try {
            $ticket = Ticket::with('estatus')->findOrFail($id);
            if ($ticket->id_usuario !== Auth::id()) {
                return redirect()->back()->with('error', 'No tienes permiso para cancelar este ticket');
            }
            $estatusPendiente = EstatusTicket::where('nombre_estatus', 'pendiente')->first();
            $estatusCancelado = EstatusTicket::where('nombre_estatus', 'cancelado')->first();

            if (!$estatusCancelado) {
                return redirect()->back()->with('error', 'Error: No existe el estado "cancelado"');
            }

            if (!$ticket->estatus || $ticket->estatus->nombre_estatus !== 'pendiente') {
                return redirect()->back()->with('error', 'Solo puedes cancelar tickets en estado pendiente');
            }

            $ticket->id_estatus = $estatusCancelado->id_estatus;
            $ticket->save();

            return redirect()->route('tickets.historial')
                ->with('success', 'El ticket #' . $ticket->id_ticket . ' ha sido cancelado exitosamente');
        } catch (\Exception $e) {
            Log::error('Error al cancelar ticket: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al cancelar el ticket: ' . $e->getMessage());
        }
    }

    /**
    * Eliminar ticket del historial (solo para tickets resueltos o cancelados)
    */
    public function destroy($id)
    {
        try {
            $ticket = Ticket::findOrFail($id);
            
            // Verificar que el ticket pertenece al usuario autenticado
            if ($ticket->id_usuario !== Auth::id()) {
                return redirect()->back()
                    ->with('error', 'No tienes permiso para eliminar este ticket');
            }
            
            // Verificar que el ticket esté resuelto o cancelado
            if ($ticket->estatus && !in_array($ticket->estatus->nombre_estatus, ['resuelto', 'cancelado'])) {
                return redirect()->back()
                    ->with('error', 'Solo puedes eliminar tickets resueltos o cancelados');
            }
            
            // Eliminar el ticket
            $ticket->delete();
            
            return redirect()->route('tickets.historial')
                ->with('success', 'Ticket eliminado del historial correctamente');
                
        } catch (\Exception $e) {
            Log::error('Error al eliminar ticket: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error al eliminar el ticket: ' . $e->getMessage());
        }
    }

    
}