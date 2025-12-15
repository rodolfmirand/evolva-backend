<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JourneyJoinRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'join_code' => 'required|string|size:6|exists:journeys,join_code',
        ];
    }

    public function messages(): array
    {
        return [
            'join_code.required' => 'O código de entrada é obrigatório.',
            'join_code.string' => 'O código de entrada deve ser uma string.',
            'join_code.size' => 'O código de entrada deve ter exatamente 6 caracteres.',
            'join_code.exists' => 'Nenhuma jornada encontrada com esse código.',
        ];
    }
}
