<?php

namespace App\Http\Requests\Central;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class TenantCentralUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Apenas usuários autenticados (administradores da Central) podem atualizar tenants.
        return Auth::check();
    }

    public function rules(): array
    {
        // 🚨 Regras de validação para a atualização (update)
        return [
            'nome' => ['required', 'string', 'max:255'],
        ];
    }
}