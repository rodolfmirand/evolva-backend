<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MasterEvaluationRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'status' => ['required', 'string', 'in:approved,rejected'],
        ];
    }

    public function messages(): array
    {
        return [
            'userId.required' => 'O campo userId é obrigatório.',
            'userId.integer'  => 'O campo userId deve ser um número inteiro.',
            'userId.exists'   => 'O usuário especificado não existe.',
            'status.required' => 'O campo status é obrigatório.',
            'status.string'   => 'O campo status deve ser uma string.',
            'status.in'       => 'O campo status deve ser "approved" ou "rejected".',
        ];
    }
}
