<?php

namespace App\Http\Requests\Central;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class TenantCentralStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Apenas usuários autenticados (administradores da Central) podem criar tenants.
        return Auth::check();
    }

    public function rules(): array
    {
        // 🚨 Regras de validação para a criação (store)
        return [
            // ID (Subdomínio) - Obrigatório e Único na tabela 'tenants'
            'id' => ['required', 'string', 'max:255', 'unique:tenants,id'], 
            'name' => ['required', 'string', 'max:255'], // Nome da Academia
            'email_admin' => ['required', 'email'], // Email do Admin
            'senha_admin' => ['required', 'string', 'min:6'], // Senha do Admin
        ];
    }

    public function messages(): array
    {
        return [
            'id.unique' => 'Este identificador (ID/Subdomínio) já está em uso.',
            'id.required' => 'O ID/Subdomínio é obrigatório.',
            'name.required' => 'O Nome da Academia é obrigatório.',
            'email_admin.required' => 'O E-mail do Administrador é obrigatório.',
            'senha_admin.min' => 'A senha deve ter no mínimo 6 caracteres.',
        ];
    }
}