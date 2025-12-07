<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

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
   // app/Http/Controllers/Central/TenantController.php

    // app/Http/Controllers/Central/TenantController.php

   public function index(Request $request)
    {
        $query = Tenant::with('domains');

        // Se tiver busca, aplica o filtro (ID ou Nome)
        if ($request->filled('search')) {
            $search = $request->search;
            
            $query->where(function($q) use ($search) {
                $q->where('id', 'LIKE', "{$search}%") 
                  ->orWhere('nome', 'LIKE', "{$search}%"); // Coluna 'nome'
            });
        }

        // 3. Retorna os dados PAGINADOS
        return Inertia::render('Central/Tenants/List', [
            // 🚨 MUDANÇA AQUI: Usando paginate(10) para buscar apenas 10 itens por página
            'tenants' => $query->latest()
                               ->paginate(10)
                               ->withQueryString(), // Mantém os filtros de busca na paginação
            'filters' => $request->only(['search'])
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
        // 1. Validação
        $request->validate([
            'id' => ['required', 'string', 'max:255', 'unique:tenants,id'],
            'name' => ['required', 'string', 'max:255'],
            'email_admin' => ['required', 'email'],
            'senha_admin' => ['required', 'string', 'min:6'],
        ]);

        // 2. Definir o nome do domínio (Ex: sportfit.aplicacao.local)
        $appDomain = env('APP_DOMAIN'); // Ex: aplicacao.local
        $subdomain = $request->id;      // Ex: sportfit
        $domain = $subdomain . '.' . $appDomain; // sportfit.aplicacao.local

        // 3. Criação do Tenant (no banco central)
        $tenant = Tenant::create([
            'id' => $subdomain,
            'name' => $request->name, // Garante que o nome seja salvo nos dados do tenant
        ]);

        // 🚨 PASSO ESSENCIAL: Vincular o Domínio ao Tenant
        // Isso cria o registro na tabela `domains`
        $tenant->domains()->create([
            'domain' => $domain,
        ]);

        // 4. Configuração do Tenant (Migrations e Usuário Admin)
        $tenant->run(function () use ($request) {
            // Criação do usuário admin no banco de dados do Tenant
            \App\Models\User::create([
                'name' => 'Administrador', 
                'email' => $request->email_admin,
                'password' => Hash::make($request->senha_admin), 
            ]);
        });

        // 5. Redirecionamento
        return redirect()->route('tenants.index')->with('success', 'Academia criada e domínio configurado com sucesso!');
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