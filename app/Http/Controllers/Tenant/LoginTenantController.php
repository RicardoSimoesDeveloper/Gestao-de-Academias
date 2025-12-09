<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\LoginTenantRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class LoginTenantController extends Controller
{
    public function login()
    {
        return Inertia::render('Tenant/Auth/TenantLogin', [
            'academia' => tenant('name'),
        ]);
    }

    public function store(LoginTenantRequest $request)
    {
        Log::info('Tentando login', [
            'credentials' => $request->only('email'),
            'tenant' => tenant('id'),
        ]);

        $credentials = $request->except('remember');
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'));
        }

        Log::info('Falha Auth::attempt');

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
