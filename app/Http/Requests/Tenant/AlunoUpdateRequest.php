<?php

namespace App\Http\Requests\Tenant;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class AlunoUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        $alunoId = $this->route('aluno');

        return [
            'nome' => ['required', 'string', 'max:50'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('alunos', 'email')->ignore($alunoId),
            ],
            'cpf' => [
                'nullable',
                'string',
                'max:14',
                Rule::unique('alunos', 'cpf')->ignore($alunoId),
            ],

            'data_nascimento' => ['nullable', 'date'],
            'status' => ['required', 'string', 'in:ativo,inativo,suspenso'],
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'O Nome do Aluno é obrigatório.',
            'nome.max' => 'O Nome do Aluno pode ter no máximo 50 caracteres.',
            
            'email.required' => 'O E-mail do Aluno é obrigatório.',
            'email.email' => 'O E-mail do Aluno deve ser um endereço de e-mail válido.',
            'email.max' => 'O E-mail do Aluno pode ter no máximo 255 caracteres.',
            'email.unique' => 'Este E-mail já está em uso por outro aluno.',

            'cpf.unique' => 'Este CPF já está em uso por outro aluno.',
            'cpf.max' => 'O CPF pode ter no máximo 14 caracteres.',

            'data_nascimento.date' => 'A Data de Nascimento deve ser uma data válida.',

            'status.required' => 'O Status do Aluno é obrigatório.',
            'status.in' => 'O Status do Aluno deve ser um dos seguintes valores: ativo, inativo, suspenso.',
        ];
    }
}
