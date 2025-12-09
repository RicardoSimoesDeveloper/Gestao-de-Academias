<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\AlunoStoreRequest;
use App\Http\Requests\Tenant\AlunoUpdateRequest;
use App\Models\Aluno;
use App\Models\Plano;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AlunoTenantController extends Controller
{
    public function index(Request $request)
    {
        $query = Aluno::with('plano'); // 🔥 Carrega o plano direto

        $filters = $request->only(['search']);

        // Filtro de busca
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nome', 'LIKE', "%{$search}%")
                  ->orWhere('cpf', 'LIKE', "{$search}%");
            });
        }

        $alunos = $query
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return Inertia::render('Tenant/Alunos/AlunoIndex', [
            'alunos' => $alunos,
            'filters' => $filters,
        ]);
    }

    public function create()
    {
        return Inertia::render('Tenant/Alunos/AlunoCreate', [
            'planos' => Plano::select('id', 'nome')->orderBy('nome')->get(),
        ]);
    }

    public function store(AlunoStoreRequest $request)
    {
        $data = $request->validated();

        Aluno::create($data);

        return redirect()->route('alunos.index')->with('success', 'Aluno cadastrado com sucesso');
    }

    public function edit(Aluno $aluno)
    {
        $planos = Plano::select('id', 'nome')->orderBy('nome')->get();

        $aluno->data_nascimento = $aluno->data_nascimento
            ? $aluno->data_nascimento->format('Y-m-d')
            : null;

        return Inertia::render('Tenant/Alunos/AlunoEdit', [
            'aluno' => $aluno,
            'planos' => $planos,
        ]);
    }

    public function update(AlunoUpdateRequest $request, Aluno $aluno)
    {
        $data = $request->validated();

        $aluno->update($data);

        return redirect()->route('alunos.index', [], 303)
            ->with('success', 'Aluno atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $aluno = Aluno::findOrFail($id);

        $aluno->delete();

        return redirect()->route('alunos.index', [], 303)
            ->with('success', 'Aluno excluído com sucesso!');
    }

    public function restore($id)
    {
        $aluno = Aluno::withTrashed()->findOrFail($id);
        $aluno->restore();

        return redirect()->route('alunos.index', [], 303)
            ->with('success', 'Aluno restaurado com sucesso!');
    }
}
