<?php

namespace App\Http\Requests\Tenant;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PlanoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:100'],
            'descricao' => ['nullable', 'string'],
            'preco' => ['required', 'numeric', 'min:0'],
            'duracao_dias' => ['required', 'integer'],
            'ativo' => ['boolean'],
        ];
    }

     public function messages(): array
    {
        return [
            'nome.required' => 'O Nome do Plano é obrigatório.',
            'nome.string' => 'O Nome do Plano deve ser uma string.',
            'nome.max' => 'O Nome do Plano pode ter no máximo 100 caracteres.',

            'descricao.string' => 'A Descricao do Plano deve ser uma string.',

            'preco.required' => 'O Preço do Plano é obrigatório.',
            'preco.numeric' => 'O Preço do Plano deve ser um valor numérico.',
            'preco.min' => 'O Preço do Plano deve ser maior que zero.',

            'duracao_dias.required' => 'A Duração do Plano é obrigatório.',
            'duracao_dias.integer' => 'A Duração do Plano deve ser um valor inteiro.',
        ];
    }
}
