<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GestionTicketsController;
use App\Http\Controllers\TicketDetallesController;


//Rutas de autenticación----------------------------------------------
Route::get('/', function () {
    return view('auth.login');
})->name('login');

Route::post('/', [LoginController::class, 'authenticate'])->name('login.post');

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

//VISTAS UNIVERSALES ----------------------------------------------------

Route::middleware(['auth'])->group(function () {
    //perfil de usuario
    Route::get('/perfil', [PerfilController::class, 'show'])->middleware('auth')->name('perfil');

    Route::get('/perfil/editar', [PerfilController::class, 'edit'])
        ->middleware('auth')
        ->name('perfil.editar');

    Route::put('/guardar-perfil', [PerfilController::class, 'update'])
        ->middleware('auth')
        ->name('perfil.update');
});

// RUTAS PARA EMPLEADO ----------------------------------------------------

Route::middleware(['auth','role:3'])->prefix('empleado')->group(function(){

    //tickets
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.historial');

    Route::get('/tickets/crear', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
    Route::put('/tickets/{id}/cancelar', [TicketController::class, 'cancelar'])->name('tickets.cancelar');
    Route::delete('/tickets/{id}/eliminar', [TicketController::class, 'destroy'])->name('tickets.eliminar');

});
//RUTAS PARA JEFE---------------------------------------------------

Route::middleware(['auth','role:2'])->group(function(){
//Gestion de Usuarios
    Route::get('/registro', [UserController::class, 'index'])->name('gestion'); 
    Route::post('/usuarios', [UserController::class, 'store'])->name('usuarios.store');
    Route::get('/usuarios/{id}/editar', [UserController::class, 'edit'])->name('usuarios.edit');
    Route::put('/usuarios/{id}', [UserController::class, 'update'])->name('usuarios.update');
    Route::put('/usuarios/{id}/desactivar', [UserController::class, 'desactivar'])->name('usuarios.desactivar');

//Rutas de visualización de tickets y asignación
    Route::prefix('jefe/gestion/ticket')->group(function () {

        Route::get('/', [GestionTicketsController::class, 'index'])
            ->name('gestion.tickets');

        Route::post('/asignar/{id}', [GestionTicketsController::class, 'asignar'])
            ->name('gestion.asignar');

        Route::put('/cancelar/{id}', [GestionTicketsController::class, 'cancelarAsignacion'])
            ->name('gestion.cancelar');

    });
});

//RUTAS DEL ADMINISTRADOR (AUXILIAR)--------------------------------------------

Route::middleware(['auth','role:1'])->prefix('auxiliar')->group(function(){
    
    // Dashboard de tickets asignados al auxiliar
    Route::get('/tickets', [TicketDetallesController::class, 'index'])
        ->name('auxiliar.tickets');
    
    // Ver detalles de un ticket específico
    Route::get('/tickets/{id}/detalles', [TicketDetallesController::class, 'show'])
        ->name('auxiliar.tickets.detalles');
    
    // Actualizar el estado del ticket
    Route::post('/tickets/{id}/actualizar', [TicketDetallesController::class, 'actualizar'])
        ->name('auxiliar.tickets.actualizar');
});