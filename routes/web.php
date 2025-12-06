<?php

use App\Http\Controllers\Central\TenantController;
use App\Http\Controllers\Central\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

Route::get('/debug-senha', function () {
    $email = 'admin@central.com';
    $senhaTentada = '123456';
    
    // 1. Busca Usuário
    // Usamos makeVisible para ver o campo 'senha' e 'password' se existirem
    $user = User::where('email', $email)->first(); 

    if (!$user) {
        return "ERRO: Usuário $email não encontrado no banco!";
    }

    $hashNoBanco = $user->senha;

    // 2. Testa a senha manualmente
    $bateu = Hash::check($senhaTentada, $hashNoBanco);

    return [
        '1. Usuario Encontrado' => $user->nome,
        '2. Email' => $user->email,
        '3. Hash que esta no Banco' => $hashNoBanco,
        '4. Senha que estamos testando' => $senhaTentada,
        '5. O Hash::check diz que bate?' => $bateu ? 'SIM, A SENHA ESTÁ CERTA' : 'NÃO, A SENHA ESTÁ ERRADA',
        '6. Configuracao do Model' => $user->getCasts(),
    ];
});

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
    
    // Dashboard (Lista de Academias)
    Route::get('/dashboard', [TenantController::class, 'index'])->name('central.dashboard');
    
    // Criação de Academias
    Route::get('/nova-academia', [TenantController::class, 'create'])->name('tenants.create');
    Route::post('/nova-academia', [TenantController::class, 'store'])->name('tenants.store');

});