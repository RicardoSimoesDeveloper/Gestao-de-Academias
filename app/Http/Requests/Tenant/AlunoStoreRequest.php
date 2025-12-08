<?php

namespace App\Http\Requests\Tenant;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AlunoStoreRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:30'],
            'email' => ['required', 'email', 'max:255', 'unique:alunos,email'], 
            'cpf' => ['nullable', 'string', 'max:14', 'unique:alunos,cpf'], 
            'data_nascimento' => ['nullable', 'date'],
            'status' => ['required', 'string', 'in:ativo,inativo,suspenso'],
        ];
    }
}