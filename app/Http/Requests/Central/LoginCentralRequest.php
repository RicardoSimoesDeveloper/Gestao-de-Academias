<?php

namespace App\Http\Requests\Central;

use Illuminate\Foundation\Http\FormRequest;

class LoginCentralRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ];
    }

    // Garante que o valor do campo de input 'remember' seja explicitamente convertido para um valor booleano
    protected function prepareForValidation()
    {
        $this->merge([
            'remember' => $this->boolean('remember'),
        ]);
    }

    public function messages(): array
    {
        return [
            'email.required' => 'O campo e-mail é obrigatório.',
            'email.email' => 'O formato do e-mail é inválido.',

            'password.required' => 'O campo senha é obrigatório.',
        ];
    }
}
