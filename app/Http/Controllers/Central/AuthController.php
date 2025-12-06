<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AuthController extends Controller
{
    // Tela de Login
    public function login()
    {
        return Inertia::render('Central/Auth/Login');
    }

    // Processar Login
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required', // Valida o campo 'password'
        ]);

        // O Laravel busca 'email' e compara 'password' automaticamente
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('central.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Credenciais inválidas.',
        ])->onlyInput('email');
    }

    // Sair
    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}