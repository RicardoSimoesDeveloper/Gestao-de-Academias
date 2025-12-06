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
        // Valida inputs
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required', // Espera 'password' do front
        ]);

        // Tenta logar (Padrão Laravel)
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Credenciais incorretas.',
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