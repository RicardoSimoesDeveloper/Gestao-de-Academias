<?php

use App\Http\Controllers\Central\TenantCentralController;
use App\Http\Controllers\Central\AuthCentralController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Central\ReportCentralController;

$appDomain = env('APP_DOMAIN'); 

// ----------------------------------------------------
// --- ROTAS DO SISTEMA CENTRAL (Somente aplicacao.local) ---
// ----------------------------------------------------

Route::domain($appDomain)->group(function () { 

    // --- ROTA RAIZ (Lógica de Redirecionamento) ---
    Route::get('/', function () {
        if (Auth::check()) {
            return redirect()->route('central.dashboard');
        }
        return redirect()->route('central.login');
    });

    // --- ROTAS DE AUTENTICAÇÃO (Públicas) ---
    Route::get('/login', [AuthCentralController::class, 'login'])->name('central.login');
    Route::post('/login', [AuthCentralController::class, 'store']);
    Route::post('/logout', [AuthCentralController::class, 'destroy'])->name('central.logout');

    // --- ÁREA ADMINISTRATIVA (Protegida) ---
    Route::middleware('auth')->prefix('admin')->group(function () {
        
        // Dashboard Geral
        Route::get('/dashboard', [TenantCentralController::class, 'dashboard'])->name('central.dashboard');
        
        // Academias (Lista e CRUD)
        Route::get('/academias', [TenantCentralController::class, 'index'])->name('tenants.index');
        Route::get('/nova-academia', [TenantCentralController::class, 'create'])->name('tenants.create');
        Route::post('/nova-academia', [TenantCentralController::class, 'store'])->name('tenants.store');
        Route::get('/academias/{id}/editar', [TenantCentralController::class, 'edit'])->name('tenants.edit');
        Route::put('/academias/{id}', [TenantCentralController::class, 'update'])->name('tenants.update');
        Route::delete('/academias/{id}', [TenantCentralController::class, 'destroy'])->name('tenants.destroy');

        // Relatórios
        Route::get('/relatorios', [ReportCentralController::class, 'index'])->name('central.reports');
    });

});