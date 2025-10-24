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
