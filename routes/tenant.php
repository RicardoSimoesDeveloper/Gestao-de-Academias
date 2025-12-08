<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; 
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Controllers\Tenant\AuthTenantController;
use App\Http\Controllers\Tenant\AlunoController; // 🚨 Importe o AlunoController
use App\Http\Controllers\Tenant\DashboardAlunoController;

// O grupo middleware principal inicializa o tenant
Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {

    // --- ROTAS DE AUTENTICAÇÃO (PÚBLICAS) ---
    Route::get('/login', [AuthTenantController::class, 'login'])->name('login');
    Route::post('/login', [AuthTenantController::class, 'store']);
    Route::post('/logout', [AuthTenantController::class, 'destroy'])->name('logout');

    // 🚨 ROTA RAIZ ('/') E REDIRECIONAMENTO DE ACORDO COM O STATUS DE LOGIN
    Route::get('/', function () { 
        if (Auth::check()) {
            return redirect('/dashboard');
        }
        return redirect()->route('login'); 
    });

    // --- ROTAS DO SISTEMA (POR ENQUANTO, FORA DO MIDDLEWARE 'auth') ---

    // 1. Dashboard
    Route::get('/dashboard', [DashboardAlunoController::class, 'index'])->name('dashboard');

    // 2. CRUD de Alunos (Rotas completas)
    // Listagem (GET /alunos)
    Route::get('/alunos', [AlunoController::class, 'index'])->name('alunos.index');
    
    // 🚨 ROTA FALTANTE: Exibir o formulário de criação (GET /alunos/create)
    Route::get('/alunos/create', [AlunoController::class, 'create'])->name('alunos.create');
    
    // Processar o formulário de criação (POST /alunos)
    Route::post('/alunos', [AlunoController::class, 'store'])->name('alunos.store');
    
    // Exibir o formulário de edição (GET /alunos/{aluno}/edit)
    Route::get('/alunos/{aluno}/edit', [AlunoController::class, 'edit'])->name('alunos.edit');
    
    // Processar o formulário de edição (PUT/PATCH /alunos/{aluno})
    Route::put('/alunos/{aluno}', [AlunoController::class, 'update'])->name('alunos.update');
    
    // Excluir (DELETE /alunos/{aluno})
    Route::delete('/alunos/{aluno}', [AlunoController::class, 'destroy'])->name('alunos.destroy');

    // Opcional: Rotas protegidas (caso deseje mover o dashboard/alunos para cá depois)
    // Route::middleware('auth')->group(function () {
    //    // ...
    // });
});