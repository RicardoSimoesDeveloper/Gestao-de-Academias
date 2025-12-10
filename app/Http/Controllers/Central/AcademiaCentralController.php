<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use App\Http\Requests\Central\AcademiaCentralIndexRequest;
use App\Http\Requests\Central\AcademiaCentralStoreRequest;
use App\Http\Requests\Central\AcademiaCentralUpdateRequest;
use App\Models\Tenant;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class AcademiaCentralController extends Controller
{
    public function index(AcademiaCentralIndexRequest $request)
    {
        $query = Tenant::with('domains');
    
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('id', 'LIKE', "{$search}%")
                    ->orWhere('nome', 'LIKE', "{$search}%");
            });
        }

        return Inertia::render('Central/Academias/CentralList', [
            'tenants' => $query->latest()
                ->paginate(10)
                ->withQueryString(),
            'filters' => $request->only(['search']),
        ]);
    }

    public function create()
    {
        return Inertia::render('Central/Academias/CentralCreate');
    }

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

        return redirect()->route('tenants.index')
            ->with('success', 'Academia criada e domínio configurado com sucesso!');
    }

    public function edit($id)
    {
        $tenant = Tenant::with('domains')->findOrFail($id);

        return Inertia::render('Central/Academias/CentralEdit', [
            'tenant' => $tenant,
        ]);
    }

    public function update(AcademiaCentralUpdateRequest $request, $id)
    {
        $tenant = Tenant::findOrFail($id);
        $data = $request->validated();

        $tenant->update(['name' => $data['nome']]);

        return redirect()->route('tenants.index', [], 303)
            ->with('success', 'Academia atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $tenant = Tenant::findOrFail($id);

        $tenant->delete();
    
        return redirect()->route('tenants.index', [], 303)
            ->with('success', 'Academia e banco de dados excluídos!');
    }
}
