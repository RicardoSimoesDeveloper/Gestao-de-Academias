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
        $request->validate([
            'email' => ['required', 'email'],
            'senha' => ['required'],
        ]);

        // Mapeamento manual: O Laravel espera a chave 'password' para validar
        $credentials = [
            'email' => $request->email,
            'password' => $request->senha 
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'As credenciais fornecidas estão incorretas.',
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