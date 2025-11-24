<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class PerfilController extends Controller
{
    
    public function show()
    {
        $usuario = Auth::user()->load('departamento');
        return view('perfil', ['usuario' => $usuario]);
    }


    public function edit()
    {

        $usuario = Auth::user()->load('departamento');
        return view('editar-perfil', ['usuario' => $usuario]);
    }



    public function update(Request $request)
    {
        $usuario = Auth::user();


        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'correo' => [
                'required',
                'string',
                'email',
                'max:255',
                
                Rule::unique('users', 'email'),
            ],
            'foto_perfil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        if ($request->hasFile('foto_perfil')) {
            
            if ($usuario->foto_perfil) {
                Storage::disk('public')->delete($usuario->foto_perfil);
            }

            $path = $request->file('foto_perfil')->store('perfiles', 'public');
            $usuario->foto_perfil = $path;
        }

        $usuario->nombre = $validatedData['nombre'];
        $usuario->apellido = $validatedData['apellido'];
        $usuario->correo = $validatedData['correo'];

        if (!empty($validatedData['password'])) {
            // Hashear la nueva contraseña antes de guardar.
            $usuario->password = Hash::make($validatedData['password']);
        }
        
        $usuario->save();

        return redirect()->route('perfil')->with('success', 'Perfil actualizado');
    }
}
