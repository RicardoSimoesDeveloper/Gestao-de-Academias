<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; 
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Controllers\Tenant\LoginTenantController;
use App\Http\Controllers\Tenant\AlunoTenantController;
use App\Http\Controllers\Tenant\DashboardTenantController;

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

    // 🚨 ROTA RAIZ ('/') E REDIRECIONAMENTO DE ACORDO COM O STATUS DE LOGIN
    Route::get('/', function () { 
        if (Auth::check()) {
            return redirect('/dashboard');
        }
        return redirect()->route('login'); 
    });

    // --- ROTAS DO SISTEMA (POR ENQUANTO, FORA DO MIDDLEWARE 'auth') ---

    // 1. Dashboard
    Route::get('/dashboard', [DashboardTenantController::class, 'index'])->name('dashboard');

    // 2. CRUD de Alunos (Rotas completas)
    // Listagem (GET /alunos)
    Route::get('/alunos', [AlunoTenantController::class, 'index'])->name('alunos.index');
    
    // 🚨 ROTA FALTANTE: Exibir o formulário de criação (GET /alunos/create)
    Route::get('/alunos/create', [AlunoTenantController::class, 'create'])->name('alunos.create');
    
    // Processar o formulário de criação (POST /alunos)
    Route::post('/alunos', [AlunoTenantController::class, 'store'])->name('alunos.store');
    
    // Exibir o formulário de edição (GET /alunos/{aluno}/edit)
    Route::get('/alunos/{aluno}/edit', [AlunoTenantController::class, 'edit'])->name('alunos.edit');
    
    // Processar o formulário de edição (PUT/PATCH /alunos/{aluno})
    Route::put('/alunos/{aluno}', [AlunoTenantController::class, 'update'])->name('alunos.update');
    
    // Excluir (DELETE /alunos/{aluno})
    Route::delete('/alunos/{aluno}', [AlunoTenantController::class, 'destroy'])->name('alunos.destroy');

    // Opcional: Rotas protegidas (caso deseje mover o dashboard/alunos para cá depois)
    // Route::middleware('auth')->group(function () {
    //    // ...
    // });
});