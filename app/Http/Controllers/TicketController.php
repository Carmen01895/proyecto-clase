<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\EstatusTicket;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function create()
    {
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
                'id_estatus' => 'required|exists:estatus_ticket,id_estatus',
                'archivo' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            ]);

            $ticket = new Ticket();
            $ticket->titulo = $request->titulo;
            $ticket->descripcion = $request->descripcion;
            $ticket->id_usuario = Auth::id(); //obtiene el id del usuario, revisar en caso de que haya algun problema :)
            $ticket->id_estatus = $request->id_estatus;

            if ($request->hasFile('archivo')) {
                $file = $request->file('archivo');
                $path = $file->store('evidencias', 'public');
                $ticket->evidencia = $path;
            }

            $ticket->save();

            return redirect()->back()->with('success', 'Ticket registrado correctamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al registrar el ticket. Inténtalo nuevamente');
        }
    }
}
