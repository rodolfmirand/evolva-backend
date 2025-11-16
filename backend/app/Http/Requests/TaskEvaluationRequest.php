<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskEvaluationRequest extends FormRequest
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
            'task_id' => ['required', 'integer', 'exists:tasks,id'],
            'proof_url' => ['nullable', 'url', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'task_id.required' => 'O campo task_id é obrigatório.',
            'task_id.integer'  => 'O campo task_id deve ser um número inteiro.',
            'task_id.exists'   => 'A tarefa especificada não existe.',
            'proof_url.url'    => 'O campo proof_url deve ser uma URL válida.',
            'proof_url.max'    => 'O campo proof_url não pode exceder 255 caracteres.',
        ];
    }
}
