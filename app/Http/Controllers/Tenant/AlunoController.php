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
        return redirect('/alunos')->with('success', 'Aluno cadastrado com sucesso!');
    }

    public function edit(Aluno $aluno)
    {
        return Inertia::render('Tenant/Alunos/Edit', [
            'aluno' => $aluno, // 🚨 Passando o objeto Aluno para a view
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

        return redirect('/alunos')->with('success', 'Aluno atualizado com sucesso!');
    }

    /**
     * Exclui (Soft Delete) o aluno.
     */
  public function destroy(Aluno $aluno)
    {
        try {
            // Isso executa o soft delete (popula a coluna deleted_at)
            $aluno->delete(); 
            
            // Retorna o usuário para a lista de alunos
           return redirect('/alunos')->with('success', 'Aluno excluído com sucesso!');

        } catch (\Exception $e) {
            // Se houver algum erro, como chave estrangeira, você pode retornar um erro
            return redirect()->back()->with('error', 'Não foi possível excluir o aluno. Erro: ' . $e->getMessage());
        }
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

       return redirect('/alunos')->with('success', 'Aluno restaurado com sucesso!');
    }
}