<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Departamento;
use App\Models\Ticket;

class DepartamentoController extends Controller
{
    public function index()
    {
        $departamentos = Departamento::orderBy('nombre_departamento')->get();
        return view('departamentos.index', compact('departamentos'));
    }

    public function create()
    {
        return view('departamentos.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre_departamento' => 'required|string|max:150|unique:departamentos,nombre_departamento',
        ]);

        Departamento::create($data);

        return redirect()->route('departamentos.index')->with('success', 'Departamento creado correctamente.');
    }

    public function edit($id)
    {
        $departamento = Departamento::findOrFail($id);
        return view('departamentos.edit', compact('departamento'));
    }

    public function update(Request $request, $id)
    {
        $departamento = Departamento::findOrFail($id);

        $data = $request->validate([
            'nombre_departamento' => 'required|string|max:150|unique:departamentos,nombre_departamento,' . $departamento->id_departamento . ',id_departamento',
        ]);

        $departamento->update($data);

        return redirect()->route('departamentos.index')->with('success', 'Departamento actualizado correctamente.');
    }

    public function destroy($id)
    {
        $departamento = Departamento::findOrFail($id);
        // Check for related tickets before deleting
        $tieneTickets = Ticket::where('id_departamento', $departamento->id_departamento)->exists();

        if ($tieneTickets) {
            return redirect()->route('departamentos.index')
                ->with('success', 'No se puede eliminar el departamento porque tiene tickets asociados.');
        }

        $departamento->delete();

        return redirect()->route('departamentos.index')->with('success', 'Departamento eliminado correctamente.');
    }
}
