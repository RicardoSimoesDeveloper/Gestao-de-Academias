<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TenantController extends Controller
{
    // Dashboard Central (Lista de Academias)
  public function index()
    {
        return Inertia::render('Central/Index', [ // <--- Tem que ser Central/Index
            'tenants' => Tenant::with('domains')->get()
        ]);
    }

    // Formulário de Criação
    public function create()
    {
        // CAMINHO AJUSTADO: Agora aponta direto para Central/Create
        return Inertia::render('Central/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|alpha_dash|unique:tenants,id',
            'nome' => 'required|string|max:255',
            'email_admin' => 'required|email',
            'senha_admin' => 'required|min:6',
        ]);

        $tenant = Tenant::create([
            'id' => $request->id,
            'name' => $request->nome,
            'plan' => 'free',
        ]);

        $tenant->domains()->create([
            'domain' => $request->id . '.aplicacao.local'
        ]);

        \Stancl\Tenancy\Jobs\CreateDatabase::dispatchSync($tenant);
        \Stancl\Tenancy\Jobs\MigrateDatabase::dispatchSync($tenant);
        
        $tenant->run(function () use ($request) {
            \App\Models\User::create([
                'nome' => 'Administrador',
                'email' => $request->email_admin,
                'senha' => $request->senha_admin,
            ]);
        });

        return redirect()->route('central.dashboard')->with('success', 'Academia criada com sucesso!');
    }
}