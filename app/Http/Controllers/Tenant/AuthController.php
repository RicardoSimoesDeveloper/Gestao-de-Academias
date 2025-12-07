<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function login()
    {
        return Inertia::render('Tenant/Auth/Login', [
            'academia' => tenant('name') 
        ]);
    }

public function store(Request $request)
    {
        // 1. Validação dos dados
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Tenta autenticar o usuário no banco de dados do Tenant
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            
            // Regenera a sessão para prevenir ataques de fixação de sessão
            $request->session()->regenerate();

            // 3. Redireciona para o Dashboard
            return redirect()->intended(route('dashboard'));
        }

        // 4. Falha na autenticação: Retorna com erro
        return back()->withErrors([
            'email' => 'As credenciais fornecidas não correspondem aos nossos registros.',
        ])->onlyInput('email');
    }

    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}