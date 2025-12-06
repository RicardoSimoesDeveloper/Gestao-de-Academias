<?php

use App\Http\Controllers\Central\TenantController;
use App\Http\Controllers\Central\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Central\ReportController;

// --- ROTA RAIZ (Lógica de Redirecionamento) ---
Route::get('/', function () {
    // Se já estiver logado, vai para o painel
    if (Auth::check()) {
        return redirect()->route('central.dashboard');
    }
    // Se não, vai para o login
    return redirect()->route('central.login');
});

// --- ROTAS DE AUTENTICAÇÃO (Públicas) ---
Route::get('/login', [AuthController::class, 'login'])->name('central.login');
Route::post('/login', [AuthController::class, 'store']);
Route::post('/logout', [AuthController::class, 'destroy'])->name('central.logout');

// --- ÁREA ADMINISTRATIVA (Protegida) ---
Route::middleware('auth')->prefix('admin')->group(function () {
    
    // Dashboard (Visão Geral)
    Route::get('/dashboard', [TenantController::class, 'dashboard'])->name('central.dashboard');
    
    // Academias (Lista e CRUD)
    Route::get('/academias', [TenantController::class, 'index'])->name('tenants.index');
    Route::get('/nova-academia', [TenantController::class, 'create'])->name('tenants.create');
    Route::post('/nova-academia', [TenantController::class, 'store'])->name('tenants.store');

    Route::get('/academias/{id}/editar', [TenantController::class, 'edit'])->name('tenants.edit');
    Route::put('/academias/{id}', [TenantController::class, 'update'])->name('tenants.update');
    Route::delete('/academias/{id}', [TenantController::class, 'destroy'])->name('tenants.destroy');

    // Relatórios
     Route::get('/relatorios', [ReportController::class, 'index'])->name('central.reports');

});