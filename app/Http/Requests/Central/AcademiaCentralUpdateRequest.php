<?php

namespace App\Http\Requests\Central;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AcademiaCentralUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:50'],
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'O Nome da Academia é obrigatório.',
            'nome.string' => 'O Nome da Academia deve ser uma string.',
            'nome.max' => 'O Nome da Academia não pode exceder 50 caracteres.', ];
    }
}
