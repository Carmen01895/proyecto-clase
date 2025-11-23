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
        $usuarios = User::with(['rol', 'departamento'])
            ->where('activo',1)
            ->get();
        
        $departamentos = Departamento::all();

        return view('gestion', compact('usuarios', 'departamentos'));
    }

    public function edit($id)
    {

        $usuario_editar = User::findOrFail($id);


        $usuarios = User::with(['rol', 'departamento'])
                        ->where('activo', 1)
                        ->get();


        return view('gestion', compact('usuarios', 'usuario_editar'));
    }

    public function update(Request $request, $id)
    {
        $usuario = User::findOrFail($id);

  
        $request->validate([
            'nombre'          => 'required|string|max:100',
            'apellido'        => 'required|string|max:100',
            'email'           => 'required|email|max:255|unique:usuarios,correo,' . $id . ',id_usuario',
            'puesto'          => 'required|string|max:100',
            'id_rol'          => 'required',
            'id_departamento' => 'required',
            'foto'            => 'nullable|image|max:2048',

            'password'        => 'nullable|string|min:6', 
        ]);


        $usuario->nombre = $request->nombre;
        $usuario->apellido = $request->apellido;
        $usuario->correo = $request->email;
        $usuario->puesto = $request->puesto;
        $usuario->id_rol = $request->id_rol;
        $usuario->id_departamento = $request->id_departamento;

        
        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->password);
        }

       
        if ($request->hasFile('foto')) {
            // Opcional: Borrar foto anterior si existe
            //if($usuario->foto_perfil) Storage::disk('public')->delete($usuario->foto_perfil);
            
            $usuario->foto_perfil = $request->file('foto')->store('perfiles', 'public');
        }

        $usuario->save();

        return redirect()->route('gestion')->with('success', '¡Usuario actualizado correctamente!');
    }


    public function desactivar($id)
    {
        $usuario = User::findOrFail($id);
        

        $usuario->activo = 0; 
        $usuario->save();

        return redirect()->route('gestion')->with('success', 'Usuario eliminado de la lista.');
    }
}

