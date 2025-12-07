<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Aluno;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AlunoController extends Controller
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

   public function store(Request $request)
    {
        $data = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:alunos,email'], // Garante email único na tabela 'alunos'
            'cpf' => ['nullable', 'string', 'max:14', 'unique:alunos,cpf'],
            'data_nascimento' => ['nullable', 'date'],
            'status' => ['required', 'string', 'in:ativo,inativo,suspenso'],
        ]);

        // Cria o aluno no banco de dados do Tenant
        Aluno::create($data);

        // Redireciona de volta para a listagem com uma mensagem de sucesso
        return redirect()->route('alunos.index')->with('success', 'Aluno cadastrado com sucesso!');
    }

    public function edit(Aluno $aluno)
    {
        // O Laravel injeta o objeto Aluno automaticamente
        return Inertia::render('Tenant/Alunos/Edit', [
            'aluno' => $aluno,
        ]);
    }

    /**
     * Atualiza os dados do aluno.
     */
    public function update(Request $request, Aluno $aluno)
    {
        $data = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            // Exclui o próprio aluno da checagem de unicidade
            'email' => ['required', 'email', 'max:255', 'unique:alunos,email,' . $aluno->id], 
            'cpf' => ['nullable', 'string', 'max:14', 'unique:alunos,cpf,' . $aluno->id],
            'data_nascimento' => ['nullable', 'date'],
            'status' => ['required', 'string', 'in:ativo,inativo,suspenso'],
        ]);

        $aluno->update($data);

        return redirect()->route('alunos.index')->with('success', 'Dados do aluno atualizados!');
    }

    /**
     * Exclui (Soft Delete) o aluno.
     */
    public function destroy(Aluno $aluno)
    {
        // O método delete() do Eloquent com SoftDeletes apenas preenche a coluna deleted_at.
        $aluno->delete();

        return redirect()->route('alunos.index')->with('success', 'Aluno excluído (movido para lixeira).');
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

        return redirect()->route('alunos.index')->with('success', 'Aluno restaurado com sucesso!');
    }
}