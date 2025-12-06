<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Acessível apenas em seudominio.com (sem subdomínio)
Route::get('/', function () {
    return Inertia::render('Central/Home', [
        'title' => 'Bem vindo ao Gestor de Academias'
    ]);
});
