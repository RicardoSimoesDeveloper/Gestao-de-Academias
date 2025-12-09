<?php

declare(strict_types=1);

use App\Http\Controllers\Tenant\AlunoTenantController;
use App\Http\Controllers\Tenant\DashboardTenantController;
use App\Http\Controllers\Tenant\LoginTenantController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

// O grupo middleware principal inicializa o tenant
Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {

    // --- ROTAS DE AUTENTICAÇÃO (PÚBLICAS) ---
    Route::get('/login', [LoginTenantController::class, 'login'])->name('login');
    Route::post('/login', [LoginTenantController::class, 'store']);
    Route::post('/logout', [LoginTenantController::class, 'destroy'])->name('logout');

    Route::get('/', function () {
        if (Auth::check()) {
            return redirect('/dashboard');
        }

        return redirect()->route('login');
    });

    // Opcional: Rotas protegidas (caso deseje mover o dashboard/alunos para cá depois)
    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [DashboardTenantController::class, 'index'])->name('dashboard');

        Route::get('/alunos', [AlunoTenantController::class, 'index'])->name('alunos.index');
        Route::get('/alunos/create', [AlunoTenantController::class, 'create'])->name('alunos.create');
        Route::post('/alunos', [AlunoTenantController::class, 'store'])->name('alunos.store');
        Route::get('/alunos/{aluno}/edit', [AlunoTenantController::class, 'edit'])->name('alunos.edit');
        Route::put('/alunos/{aluno}', [AlunoTenantController::class, 'update'])->name('alunos.update');
        Route::delete('/alunos/{aluno}', [AlunoTenantController::class, 'destroy'])->name('alunos.destroy');
    });
});
