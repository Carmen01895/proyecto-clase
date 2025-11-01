<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function username()
    {
        return 'correo';
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'correo' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $credentials = $request->only('correo', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            $rol_empleado = 3;
            $rol_jefe = 2;
            $rol_admin = 1;

            switch ($user->id_rol) {
                case $rol_empleado:
                    return redirect()->intended(route('tickets.historial'));
                //case $rol_jefe:
                    //return redirect()->intended('/jefe/dashboard');
                //case $rol_admin:
                    //return redirect()->intended('/admin/dashboard');
                default:
                    Auth::logout();
                    return back()->withErrors([
                        'correo' => 'Tu rol de acceso no está permitido o es desconocido'
                    ])->onlyInput('correo');
            }
        }

        // Si la autenticación falla, devolver error
        return back()->withErrors([
            'correo' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->onlyInput('correo');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}