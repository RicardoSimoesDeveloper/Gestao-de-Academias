<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use App\Http\Requests\Central\AcademiaCentralIndexRequest;
use App\Http\Requests\Central\AcademiaCentralStoreRequest;
use App\Http\Requests\Central\AcademiaCentralUpdateRequest;
use App\Models\Tenant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class AcademiaCentralController extends Controller
{
    public function index(AcademiaCentralIndexRequest $request) // 🚨 Injetando IndexRequest
    {
        $query = Tenant::with('domains');

        // Se o campo 'search' foi validado e está presente, aplicamos o filtro.
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('id', 'LIKE', "{$search}%")
                    ->orWhere('name', 'LIKE', "{$search}%");
            });
        }

        return Inertia::render('Central/Academias/CentralList', [
            'tenants' => $query->latest()
                ->paginate(10)
                ->withQueryString(),
            'filters' => $request->only(['search']),
        ]);
    }

    /**
     * Formulário de Criação (Mantido)
     */
    public function create()
    {
        return Inertia::render('Central/Academias/CentralCreate');
    }

    /**
     * Salvar Nova Academia (Mantido com pequeno ajuste no redirect)
     */
    public function store(AcademiaCentralStoreRequest $request)
    {
        $data = $request->validated();

        $appDomain = env('APP_DOMAIN');
        $subdomain = $data['id'];
        $domain = $subdomain.'.'.$appDomain;

        $tenant = Tenant::create([
            'id' => $subdomain,
            'name' => $data['name'],
        ]);

        $tenant->domains()->create([
            'domain' => $domain,
        ]);

        $tenant->run(function () use ($data) {
            \App\Models\User::create([
                'name' => 'Administrador',
                'email' => $data['email_admin'],
                'password' => Hash::make($data['senha_admin']),
            ]);
        });

        return redirect()->route('tenants.index')->with('success', 'Academia criada e domínio configurado com sucesso!');
    }

    /**
     * Tela de Edição
     */
    public function edit($id)
    {
        // O findOrFail garante que se o ID não existir, dá erro 404 antes de carregar a tela
        $tenant = Tenant::with('domains')->findOrFail($id);

        return Inertia::render('Central/Academias/CentralEdit', [
            'tenant' => $tenant, // <--- Estamos enviando a variável 'tenant' aqui
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
