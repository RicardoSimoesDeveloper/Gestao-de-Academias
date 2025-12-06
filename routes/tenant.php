<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; // <--- IMPORTANTE: Adicione esta linha
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Controllers\Tenant\AuthController;
use Inertia\Inertia;

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {

    // --- ROTAS PÚBLICAS ---
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'store']);
    Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');
    // Dentro do middleware 'auth'...

    Route::get('/alunos', [App\Http\Controllers\Tenant\AlunoController::class, 'index'])->name('alunos.index');
    Route::post('/alunos', [App\Http\Controllers\Tenant\AlunoController::class, 'store'])->name('alunos.store');

    // --- ROTAS PROTEGIDAS (DASHBOARD) ---
    Route::middleware('auth')->group(function () {
        
        Route::get('/', function () {
            return redirect('/dashboard');
        });

        Route::get('/dashboard', function () {
            return Inertia::render('Tenant/Dashboard', [
                // Forma mais segura de pegar o usuário:
                'user' => Auth::user(), 
                
                // Ou alternativamente: 'user' => request()->user(),
                
                'academia' => tenant('name') // Certifique-se que a coluna 'name' existe no banco central
            ]);
        })->name('dashboard');
    });
});