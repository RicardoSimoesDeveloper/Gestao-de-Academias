<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; 
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Controllers\Tenant\AuthController;
use Inertia\Inertia;

// 🚨 O middleware DEVE estar aqui para inicializar o Tenant e Carregar as Rotas.
Route::middleware([
    'web',
    InitializeTenancyByDomain::class, // Mantido aqui
    PreventAccessFromCentralDomains::class,
])->group(function () {

    // --- ROTAS PÚBLICAS / LOGIN ---
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'store']);
    Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');
    
    // 🚨 CORREÇÃO ESSENCIAL: A ROTA RAIZ ('/') DEVE SER PÚBLICA.
    // Ela verifica a autenticação e redireciona, ou envia para o login.
    Route::get('/', function () { 
        if (Auth::check()) {
            return redirect('/dashboard');
        }
        return redirect()->route('login'); 
    });

    // --- ROTAS PROTEGIDAS ---
    Route::middleware('auth')->group(function () {
        
        Route::get('/dashboard', function () {
            return Inertia::render('Tenant/Dashboard', [
                'user' => Auth::user(), 
                'academia' => tenant('name') 
            ]);
        })->name('dashboard');

        // Rotas de Alunos
        Route::get('/alunos', [App\Http\Controllers\Tenant\AlunoController::class, 'index'])->name('alunos.index');
        Route::post('/alunos', [App\Http\Controllers\Tenant\AlunoController::class, 'store'])->name('alunos.store');
    });
});