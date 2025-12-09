<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\PlanoRequest;
use App\Models\Plano;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PlanoController extends Controller
{
    /**
     * Exibe a lista de planos com paginação.
     */
    public function index(Request $request)
    {
        $planos = Plano::latest()->paginate(10);

        return Inertia::render('Tenant/Planos/PlanoIndex', [
            'planos' => $planos
        ]);
    }

    /**
     * Exibe o formulário de criação.
     */
    public function create()
    {
        return Inertia::render('Tenant/Planos/PlanoCreate');
    }

    /**
     * Salva um novo plano.
     */
    public function store(PlanoRequest $request)
    {
        Plano::create($request->validated());

        return redirect()
            ->route('planos.index')
            ->with('success', 'Plano criado com sucesso!');
    }

    /**
     * Exibe o formulário de edição.
     */
    public function edit(Plano $plano)
    {
        return Inertia::render('Tenant/Planos/PlanoEdit', [
            'plano' => $plano
        ]);
    }

    /**
     * Atualiza um plano existente.
     */
    public function update(PlanoRequest $request, Plano $plano)
    {
        $plano->update($request->validated());

        return redirect()
            ->route('planos.index')
            ->with('success', 'Plano atualizado com sucesso!');
    }

    /**
     * Soft delete do plano.
     */
    public function destroy($id)
    {
        $plano = Plano::findOrFail($id);
        $plano->delete();

        return redirect()
            ->route('planos.index', [], 303)
            ->with('success', 'Plano excluído com sucesso!');
    }
}
