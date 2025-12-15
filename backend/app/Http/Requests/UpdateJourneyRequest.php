<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJourneyRequest extends FormRequest
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
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string',
            'is_private' => 'sometimes|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'O título é obrigatório quando enviado',
            'title.string' => 'O título deve ser uma string',
            'title.max' => 'O título não pode exceder 255 caracteres',
            'description.string' => 'A descrição deve ser uma string',
            'is_private.boolean' => 'O campo de privacidade deve ser verdadeiro ou falso',
        ];
    }
}
