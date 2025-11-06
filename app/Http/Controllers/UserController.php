<?php

namespace App\Http\Controllers;

use App\Models\User; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage; 
use App\Models\Role;
use App\Models\Departamento;

class UserController extends Controller
{
    /**
     * Guarda un nuevo usuario en la base de datos.
     */
    public function store(Request $request)
    {
        // 1. VALIDACIÓN
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            // Verifica unicidad en la columna 'correo' de la tabla 'usuarios'
            'email' => 'required|string|email|max:255|unique:usuarios,correo', 
            'password' => 'required|string|min:6',
            'puesto' => 'required|string|max:100',
            
            // CORRECCIÓN CLAVE: Usamos 'id_rol' y 'id_departamento'
            // Ya que son las claves primarias reales de esas tablas (confirmado con la imagen 'roles')
            'id_rol' => 'required|exists:roles,id_rol', 
            'id_departamento' => 'required|exists:departamentos,id_departamento', 
            
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 
        ]);

        // 2. Lógica de subida de la FOTO
        $ruta_foto = null;
        if ($request->hasFile('foto')) {
            $ruta_foto = $request->file('foto')->store('perfiles', 'public');
        }

        // 3. CREACIÓN del Usuario
        User::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'correo' => $request->email, 
            'password' => Hash::make($request->password), 
            'puesto' => $request->puesto,
            'id_rol' => $request->id_rol,
            'id_departamento' => $request->id_departamento,
            'foto_perfil' => $ruta_foto,
        ]);

        // 4. Redirección con mensaje de éxito (ya lo habías agregado)
        return redirect()->route('gestion')->with('success', '¡Usuario registrado exitosamente!');
    }

    /**
     * Muestra una lista de todos los usuarios registrados.
     */
    public function index()
    {
        $usuarios = User::with(['rol', 'departamento'])->get();
        
        // Retorna la vista 'gestion' y le pasa la colección de usuarios
        return view('gestion', compact('usuarios'));
    }
}
