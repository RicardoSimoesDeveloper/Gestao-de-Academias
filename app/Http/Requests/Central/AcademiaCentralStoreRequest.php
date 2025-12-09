<?php

namespace App\Http\Requests\Central;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AcademiaCentralStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'id' => ['required', 'string', 'max:50', 'unique:tenants,id'],
            'name' => ['required', 'string', 'max:50'],
            'email_admin' => ['required', 'email'],
            'senha_admin' => ['required', 'string', 'min:6'],
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'O ID da Academia Central é obrigatório.',
            'id.string' => 'O ID da Academia Central deve ser uma string.',
            'id.max' => 'O ID da Academia Central pode ter no máximo 50 caracteres.',
            'id.unique' => 'Este ID ja esta em uso por outra Academia Central.',

            'name.required' => 'O Nome da Academia Central é obrigatório.',
            'name.string' => 'O Nome da Academia Central deve ser uma string.',
            'name.max' => 'O Nome da Academia Central pode ter no máximo 50 caracteres.',

            'email_admin.required' => 'O E-mail do Administrador é obrigatório.',
            'email_admin.email' => 'O E-mail do Administrador deve ser um endereço de e-mail válido.',

            'senha_admin.required' => 'A senha do Administrador é obrigatória.',
            'senha_admin.string' => 'A senha do Administrador deve ser uma string.',
            'senha_admin.min' => 'A senha do Administrador deve ter no mínimo 6 caracteres.',
        ];
    }
}
