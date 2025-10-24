<?php

use Illuminate\Support\Facades\Route;

Route::get('/tickets/crear', function () {
    return view('tickets.create');
})->name('tickets.create');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/mi-perfil', function () {
    return view('perfil');
});

Route::get('/editar-perfil', function () {
    return view('editar-perfil');
});

Route::get('/tickets/historial', function () {
    return view('historial_tickets');
})->name('tickets.historial');