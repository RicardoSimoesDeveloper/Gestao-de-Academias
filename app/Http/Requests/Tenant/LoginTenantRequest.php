<?php

namespace App\Http\Requests\Tenant;

use Illuminate\Foundation\Http\FormRequest;

class LoginTenantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * * O login não exige autenticação prévia.
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
        // 🚨 Validações movidas do Controller
        return [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ];
    }

    /**
     * Opcional: Preparar a requisição antes da validação.
     * Se você tiver um campo "remember" no formulário e quiser garantir que ele seja booleano:
     */
    protected function prepareForValidation()
    {
        // Garante que o checkbox 'remember' seja um booleano (útil se o frontend enviar 'on' ou 'off')
        $this->merge([
            'remember' => $this->boolean('remember'),
        ]);
    }
}