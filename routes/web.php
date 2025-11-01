<?php

use Illuminate\Support\Facades\Route;


//Rutas de autenticación----------------------------------------------
Route::get('/', function () {
    return view('auth.login');
})->name('login');

Route::get('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

// Rutas de perfil----------------------------------------------------
Route::get('/perfil', function () {
    return view('perfil');
})->name('perfil');

Route::get('/perfil/editar', function () {
    return view('editar-perfil');
})->name('perfil.editar');

// Rutas de tickets---------------------------------------------------
Route::get('/tickets', function () {
    return view('historial_tickets');
})->name('tickets.historial');

Route::get('/tickets/crear', function () {
    return view('tickets.create');
})->name('tickets.create');

//Rutas de registro---------------------------------------------------
Route::get('/registro', function () {
    return view('gestion');
})->name('gestion');