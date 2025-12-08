<?php

namespace App\Http\Requests\Tenant;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AlunoUpdateRequest extends FormRequest
{

    public function rules(): array
    {
        // 🚨 Obtém o ID do aluno da rota para exclusão da checagem de unicidade
        $alunoId = $this->route('aluno'); 

        return [
            'nome' => ['required', 'string', 'max:255'],
            
            // 🚨 CRÍTICO: Unique, exceto para o ID do aluno que está sendo atualizado
            'email' => [
                'required', 
                'email', 
                'max:255', 
                Rule::unique('alunos', 'email')->ignore($alunoId)
            ], 
            'cpf' => [
                'nullable', 
                'string', 
                'max:14', 
                Rule::unique('alunos', 'cpf')->ignore($alunoId)
            ],
            
            'data_nascimento' => ['nullable', 'date'],
            'status' => ['required', 'string', 'in:ativo,inativo,suspenso'],
        ];
    }
}