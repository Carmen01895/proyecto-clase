<?php

use Illuminate\Support\Facades\Route;

Route::get('/tickets/crear', function () {
    return view('tickets.create');
})->name('tickets.create');
