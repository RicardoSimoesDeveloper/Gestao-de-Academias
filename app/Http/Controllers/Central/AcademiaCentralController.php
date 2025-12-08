<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Central\AcademiaCentralIndexRequest;
use App\Http\Requests\Central\AcademiaCentralStoreRequest;
use App\Http\Requests\Central\AcademiaCentralUpdateRequest;

class AcademiaCentralController extends Controller
{
    /**
     * NOVO: Dashboard Geral (Cards e Métricas)
     */
   public function dashboard()
    {
        // 1. Métrica: Total de Academias
        $totalTenants = Tenant::count();

        // 2. Métrica: Novas este mês
        $newTenantsThisMonth = Tenant::where('created_at', '>=', now()->startOfMonth())->count();

        // 3. Métrica: Total de Alunos (Agregação Multi-Tenant)
        $totalAlunos = 0;
        
        // Iteramos sobre todos os Tenants para calcular o total de alunos
        $tenants = Tenant::all();

        foreach ($tenants as $tenant) {
            // Tenta inicializar o ambiente do tenant
            try {
                tenancy()->initialize($tenant);
                
                // Agrega a contagem de alunos do banco do tenant
                // Assumindo que a tabela é 'alunos' no Tenant DB
                $totalAlunos += DB::table('alunos')->count();
                
            } catch (\Stancl\Tenancy\Exceptions\TenantDatabaseDoesNotExistException $e) {
                // Captura o erro, ignora este tenant e continua (sem quebrar a página)
            } catch (\Exception $e) {
                // Captura qualquer outro erro de DB (ex: tabela 'alunos' não existe)
            } finally {
                // Sai do contexto do tenant para garantir que as próximas chamadas voltem para o DB Central
                tenancy()->end();
            }
        }

        // 4. Métrica: Planos Ativos (Placeholder dinâmico)
        // Para um cálculo real, você precisaria da lógica de planos/assinaturas.
        // Por exemplo: (Tenants com status 'ativo' / Total de Tenants) * 100
        $activePlansPercent = '100%'; // Valor fixo por enquanto

        return Inertia::render('Central/Index', [
            'totalTenants' => $totalTenants,
            'newTenantsThisMonth' => $newTenantsThisMonth,
            'totalAlunos' => $totalAlunos,
            'activePlansPercent' => $activePlansPercent,
        ]);
    }

    /**
     * AJUSTADO: Lista de Academias (Tabela)
     * Agora aponta para a pasta 'Tenants/List' que criamos
     */
   // app/Http/Controllers/Central/TenantController.php

    // app/Http/Controllers/Central/TenantController.php

  public function index(AcademiaCentralIndexRequest $request) // 🚨 Injetando IndexRequest
    {
        $query = Tenant::with('domains');

        // Se o campo 'search' foi validado e está presente, aplicamos o filtro.
        if ($request->filled('search')) {
            $search = $request->search;
            
            $query->where(function($q) use ($search) {
                $q->where('id', 'LIKE', "{$search}%") 
                  ->orWhere('name', 'LIKE', "{$search}%"); 
            });
        }

        return Inertia::render('Central/Tenants/List', [
            'tenants' => $query->latest()
                               ->paginate(10)
                               ->withQueryString(), 
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
    public function store(AcademiaCentralStoreRequest $request) // 🚨 Injetando StoreRequest
    {
        // 1. A validação foi feita pelo Request. Usamos $request->validated() para dados limpos.
        $data = $request->validated();
        
        // 2. Definir o nome do domínio
        $appDomain = env('APP_DOMAIN');
        $subdomain = $data['id']; 
        $domain = $subdomain . '.' . $appDomain;

        // 3. Criação do Tenant (no banco central)
        $tenant = Tenant::create([
            'id' => $subdomain,
            'name' => $data['name'], 
        ]);

        // 4. Vincular o Domínio ao Tenant
        $tenant->domains()->create([
            'domain' => $domain,
        ]);

        // 5. Configuração do Tenant (Migrations e Usuário Admin)
        $tenant->run(function () use ($data) {
            \App\Models\User::create([
                'name' => 'Administrador', 
                'email' => $data['email_admin'], 
                'password' => Hash::make($data['senha_admin']), 
            ]);
        });

        // 6. Redirecionamento
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
    public function update(AcademiaCentralUpdateRequest $request, $id) // 🚨 Injetando UpdateRequest
    {
        $tenant = Tenant::findOrFail($id);
        $data = $request->validated(); // Dados limpos

        $tenant->update(['name' => $data['nome']]); 

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