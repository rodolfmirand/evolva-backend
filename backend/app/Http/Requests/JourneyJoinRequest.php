<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JourneyJoinRequest extends FormRequest
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
            'journey_id' => 'required|integer|exists:journeys,join_code|size:6',
        ];
    }

    public function messages(): array
    {
        return [
            'journey_id.required' => 'O código de entrada é obrigatório.',
            'journey_id.integer' => 'O código de entrada deve ser um número inteiro.',
            'journey_id.exists' => 'Jornada não encontrada com o código fornecido.',
            'journey_id.size' => 'O código de entrada deve ter exatamente 6 caracteres.'
        ];
    }
}
