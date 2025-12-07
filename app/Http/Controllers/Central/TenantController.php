<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;

class TenantController extends Controller
{
    /**
     * NOVO: Dashboard Geral (Cards e Métricas)
     */
    public function dashboard()
    {
        return Inertia::render('Central/Index', [
            // Conta quantos tenants existem para mostrar no card
            'totalTenants' => Tenant::count()
        ]);
    }

    /**
     * AJUSTADO: Lista de Academias (Tabela)
     * Agora aponta para a pasta 'Tenants/List' que criamos
     */
    public function index()
    {
        return Inertia::render('Central/Tenants/List', [
            'tenants' => Tenant::with('domains')->get()
        ]);
    }

    /**
     * Formulário de Criação (Mantido)
     */
    public function create()
    {
        return Inertia::render('Central/Create');
    }

    /**
     * Salvar Nova Academia (Mantido com pequeno ajuste no redirect)
     */
    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|alpha_dash|unique:tenants,id',
            'nome' => 'required|string|max:255',
            'email_admin' => 'required|email',
            'senha_admin' => 'required|min:6',
        ]);

        // 1. Ao rodar o CREATE aqui, o pacote já dispara os eventos
        // que criam o banco e rodam as migrations automaticamente!
        $tenant = Tenant::create([
            'id' => $request->id,
            'name' => $request->nome,
            'plan' => 'free',
        ]);

        $tenant->domains()->create([
            'domain' => $request->id . '.aplicacao.local'
        ]);

        // --- REMOVA OU COMENTE ESTAS LINHAS ABAIXO ---
        // \Stancl\Tenancy\Jobs\CreateDatabase::dispatchSync($tenant); <--- CULPADO
        // \Stancl\Tenancy\Jobs\MigrateDatabase::dispatchSync($tenant); <--- CULPADO
        
        // Mantemos a criação do usuário, pois isso é customizado nosso
        $tenant->run(function () use ($request) {
            \App\Models\User::create([
                'nome' => 'Administrador',
                'email' => $request->email_admin,
                'password' => $request->senha_admin,
            ]);
        });

        return redirect()->route('tenants.index')->with('success', 'Academia criada com sucesso!');
    }

    // ... métodos dashboard, index, create, store já existem ...

    /**
     * Tela de Edição
     */
    public function edit($id)
    {
        // O findOrFail garante que se o ID não existir, dá erro 404 antes de carregar a tela
        $tenant = Tenant::with('domains')->findOrFail($id);

        return Inertia::render('Central/Tenants/Edit', [
            'tenant' => $tenant // <--- Estamos enviando a variável 'tenant' aqui
        ]);
    }

    /**
     * Atualizar Dados
     */
    public function update(Request $request, $id)
    {
        $tenant = Tenant::findOrFail($id);
        $request->validate(['nome' => 'required|string|max:255']);

        $tenant->update(['name' => $request->nome]);

        // O SEGREDO ESTÁ AQUI NO FINAL: '303'
        return redirect()->route('tenants.index', [], 303)
                        ->with('success', 'Academia atualizada com sucesso!');
    }

    /**
     * Excluir Academia e Banco de Dados
     */
    public function destroy($id)
    {
        $tenant = Tenant::findOrFail($id);
        
        // Deleta registro e banco de dados
        $tenant->delete();

        // A CORREÇÃO MÁGICA ESTÁ AQUI: ', [], 303'
        // Isso força o navegador a transformar o DELETE em GET ao redirecionar
        return redirect()->route('tenants.index', [], 303)
                        ->with('success', 'Academia e banco de dados excluídos!');
    }
}