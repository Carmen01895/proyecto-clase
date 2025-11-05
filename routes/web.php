<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\PerfilController;


//Rutas de autenticación----------------------------------------------
Route::get('/', function () {
    return view('auth.login');
})->name('login');

Route::post('/', [LoginController::class, 'authenticate'])->name('login.post');
Route::middleware(['auth','role:3'])->prefix('empleado')->group(function(){});

Route::get('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

// Rutas de perfil----------------------------------------------------

Route::get('/perfil', [PerfilController::class, 'show'])->middleware('auth')->name('perfil');

// MODIFICADO: Apunta al método 'edit' del controlador
Route::get('/perfil/editar', [PerfilController::class, 'edit'])
    ->middleware('auth')
    ->name('perfil.editar');

// NUEVO: Ruta para procesar el formulario de actualización
Route::put('/guardar-perfil', [PerfilController::class, 'update'])
    ->middleware('auth')
    ->name('perfil.update');


// Rutas de tickets---------------------------------------------------
Route::get('/tickets', function () {
    return view('historial_tickets');
})->name('tickets.historial');

Route::get('/tickets/crear', [TicketController::class, 'create'])->name('tickets.create');
Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');

//Rutas de registro---------------------------------------------------
Route::get('/registro', function () {
    return view('gestion');
})->name('gestion');