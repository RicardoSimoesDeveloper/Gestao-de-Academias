<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Aluno;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Requests\Tenant\AlunoStoreRequest;
use App\Http\Requests\Tenant\AlunoUpdateRequest;

class AlunoTenantController extends Controller
{
  public function index(Request $request)
    {
        $query = Aluno::query();
        $filters = $request->only(['search']);

        // Filtro de Busca (Nome ou CPF)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nome', 'LIKE', "%{$search}%")
                  ->orWhere('cpf', 'LIKE', "{$search}%"); 
            });
        }
        
        $alunos = $query->latest()
                        ->paginate(15) // Paginação padrão para o Tenant
                        ->withQueryString();

        return Inertia::render('Tenant/Alunos/Index', [
            'alunos' => $alunos,
            'filters' => $filters,
        ]);
    }

    // Método para exibir o formulário de criação
    public function create()
    {
        return Inertia::render('Tenant/Alunos/Create');
    }

   public function store(AlunoStoreRequest $request) 
    {
        $data = $request->validated(); 

        Aluno::create($data);

        return redirect()->route('alunos.index')->with('success', 'Aluno cadastrado com sucesso');
    }

    public function edit(Aluno $aluno)
    {
        $aluno->data_nascimento = $aluno->data_nascimento 
            ? $aluno->data_nascimento->format('Y-m-d') 
            : null;

        return Inertia::render('Tenant/Alunos/Edit', [
        'aluno' => $aluno, 
    ]);
    }

    /**
     * Atualiza os dados do aluno.
     */
   public function update(AlunoUpdateRequest $request, Aluno $aluno) 
    {
        // Validação e exclusão de unicidade feita pelo Request.
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
    
    /**
     * Restaura um aluno que foi excluído (Soft Delete).
     * Este é um método extra útil!
     */
    public function restore($id)
    {
        // Busca o aluno, incluindo os deletados
        $aluno = Aluno::withTrashed()->findOrFail($id);
        $aluno->restore();

        return redirect()->route('alunos.index', [], 303)
            ->with('success', 'Aluno restaurado com sucesso!');
    }
}