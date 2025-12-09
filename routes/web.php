<?php

use App\Http\Controllers\Central\AcademiaCentralController;
use App\Http\Controllers\Central\LoginCentralController;
use App\Http\Controllers\Central\RelatorioCentralController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Central\CentralDashboardController;

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
    Route::get('/login', [LoginCentralController::class, 'login'])->name('central.login');
    Route::post('/login', [LoginCentralController::class, 'store']);
    Route::post('/logout', [LoginCentralController::class, 'destroy'])->name('central.logout');

    // --- ÁREA ADMINISTRATIVA (Protegida) ---
    Route::middleware('auth')->prefix('admin')->group(function () {

        // Dashboard Geral
        Route::get('/dashboard', [CentralDashboardController::class, 'index'])->name('central.dashboard');

        // Academias (Lista e CRUD)
        Route::get('/academias', [AcademiaCentralController::class, 'index'])->name('tenants.index');
        Route::get('/nova-academia', [AcademiaCentralController::class, 'create'])->name('tenants.create');
        Route::post('/nova-academia', [AcademiaCentralController::class, 'store'])->name('tenants.store');
        Route::get('/academias/{id}/editar', [AcademiaCentralController::class, 'edit'])->name('tenants.edit');
        Route::put('/academias/{id}', [AcademiaCentralController::class, 'update'])->name('tenants.update');
        Route::delete('/academias/{id}', [AcademiaCentralController::class, 'destroy'])->name('tenants.destroy');

        // Relatórios
        Route::get('/relatorios', [RelatorioCentralController::class, 'index'])->name('central.reports');
    });

});
