<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  mixed ...$roles  
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        if (!in_array($user->id_rol, $roles)) {
            
            if ($user->id_rol == 3) {
                 return redirect()->route('tickets.historial'); 
            } elseif ($user->id_rol == 1) {
                 return redirect()->route('gestion'); 
            }

            return redirect()->route('login');
        }

        return $next($request);
    }
}
