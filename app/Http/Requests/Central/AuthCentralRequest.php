<?php

namespace App\Http\Requests\Central; // 🚨 Namespace ajustado para Central

use Illuminate\Foundation\Http\FormRequest;

class AuthCentralRequest extends FormRequest // 🚨 Nome da Classe alterado
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; 
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        // Regras para o Login da Central
        return [
            'email' => 'required|email',
            'password' => 'required',
        ];
    }

    /**
     * Opcional: Customizar as mensagens de erro.
     */
    public function messages(): array
    {
        return [
            'email.required' => 'O campo e-mail é obrigatório.',
            'email.email' => 'O formato do e-mail é inválido.',
            'password.required' => 'O campo senha é obrigatório.',
        ];
    }
}