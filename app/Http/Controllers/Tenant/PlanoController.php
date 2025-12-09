<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Plano;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PlanoController extends Controller
{
    // Métodos de validação em um helper (poderia ser um Form Request)
    private function validateRequest(Request $request)
    {
        return $request->validate([
            'nome' => ['required', 'string', 'max:100'],
            'preco' => ['required', 'numeric', 'min:0.01'],
            'duracao_dias' => ['required', 'integer', 'min:1'],
            'descricao' => ['nullable', 'string'],
        ]);
    }
    
    /**
     * Exibe a lista de planos.
     */
  public function index(Request $request)
    {
        // 🚨 O erro 500 geralmente ocorre NESTA LINHA
        $planos = Plano::latest()->paginate(10); 
        return Inertia::render('Tenant/Planos/PlanoIndex', compact('planos'));
    }

    /**
     * Exibe o formulário de criação.
     */
    public function create()
    {
        return Inertia::render('Tenant/Planos/PlanoCreate');
    }

    /**
     * Armazena um novo plano.
     */
    public function store(Request $request)
    {
        $data = $this->validateRequest($request);
        Plano::create($data);
        return redirect()->route('planos.index')->with('success', 'Plano criado com sucesso!');
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
    public function update(Request $request, Plano $plano)
    {
        $data = $this->validateRequest($request);
        $plano->update($data);
        return redirect()->route('planos.index')->with('success', 'Plano atualizado com sucesso!');
    }

    /**
     * Deleta (Soft Delete) um plano.
     */
    public function destroy($id)
    {
        $plano = Plano::findOrFail($id);

        $plano->delete();

        return redirect()->route('planos.index', [], 303)
            ->with('success', 'Plano excluído com sucesso!');
    }
}