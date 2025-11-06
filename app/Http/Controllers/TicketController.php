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
    // Mostrar historial de tickets
    public function index(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión');
        }

        try {
            // Consulta base con relaciones
            $query = Ticket::with(['estatus', 'asignado', 'departamento'])
                           ->where('id_usuario', Auth::id());

            // Filtro por estado
            if ($request->has('filtro_estado') && $request->filtro_estado !== 'todos') {
                $query->whereHas('estatus', function($q) use ($request) {
                    $q->where('nombre_estatus', $request->filtro_estado);
                });
            }

            // Búsqueda por ID
            if ($request->has('buscar_id') && !empty($request->buscar_id)) {
                $query->where('id_ticket', 'LIKE', '%' . $request->buscar_id . '%');
            }

            // Ordenar
            $ordenar = $request->get('ordenar_por', 'fecha-desc');
            switch ($ordenar) {
                case 'fecha-asc':
                    $query->orderBy('fecha_creacion', 'asc');
                    break;
                case 'estado':
                    $query->orderBy('id_estatus', 'asc');
                    break;
                default: // fecha-desc
                    $query->orderBy('fecha_creacion', 'desc');
                    break;
            }

            // Obtener tickets con paginación
            $tickets = $query->paginate(10)->appends($request->all());
            $usuario = Auth::user();

            return view('historial_tickets', compact('tickets', 'usuario'));

        } catch (\Exception $e) {
            Log::error('Error en index de tickets: ' . $e->getMessage());
            
            // Si hay error, devolver colección vacía
            $tickets = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 10);
            $usuario = Auth::user();
            
            return view('historial_tickets', compact('tickets', 'usuario'))
                   ->with('error', 'Error al cargar los tickets: ' . $e->getMessage());
        }
    }

    // Crear ticket
    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para crear un ticket');
        }

        $usuario = Auth::user();
        $estatus = EstatusTicket::all();

        return view('tickets.create', compact('usuario', 'estatus'));
    }

    // Guardar ticket
    public function store(Request $request)
    {
        try {
            $request->validate([
                'titulo' => 'required|string|min:8|max:100',
                'descripcion' => 'required|string|min:20',
                'archivo' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            ]);

            // Buscar el estatus pendiente
            $estatusPendiente = EstatusTicket::where('nombre_estatus', 'pendiente')->first();

            if (!$estatusPendiente) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Error: No existe el estado "pendiente". Por favor, ejecuta el seeder de estatus.');
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

    // Cancelar ticket
    public function cancelar($id)
    {
        try {
            $ticket = Ticket::with('estatus')->findOrFail($id);

            // Verificar que el ticket pertenece al usuario
            if ($ticket->id_usuario !== Auth::id()) {
                return redirect()->back()->with('error', 'No tienes permiso para cancelar este ticket');
            }

            // Buscar estados
            $estatusPendiente = EstatusTicket::where('nombre_estatus', 'pendiente')->first();
            $estatusCancelado = EstatusTicket::where('nombre_estatus', 'cancelado')->first();

            if (!$estatusCancelado) {
                return redirect()->back()->with('error', 'Error: No existe el estado "cancelado"');
            }

            // Verificar que el ticket está en estado pendiente
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
}