<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth; //TODO: remover ao migrar a validação pro service

class TaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'journey_id'     => 'required|exists:journeys,id',
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string',
            'type'           => 'required|string|in:normal,especial,boss',
            'xp_reward'      => 'required|integer|min:0',
            'coin_reward'    => 'required|integer|min:0',
            'deadline'       => 'nullable|date|after_or_equal:now',
            'requires_proof' => 'nullable|boolean',
            'proof_url'      => 'required_if:requires_proof,true|nullable|url'
        ];
    }

    public function messages(): array
    {
        return [
            'journey_id.required'      => 'A jornada é obrigatória.',
            'journey_id.exists'        => 'A jornada informada não existe.',
            'title.required'           => 'O título da tarefa é obrigatório.',
            'title.string'             => 'O título da tarefa deve ser um texto.',
            'title.max'                => 'O título da tarefa não pode exceder 255 caracteres.',
            'description.string'       => 'A descrição da tarefa deve ser texto válido.',
            'type.in'                  => 'O tipo de tarefa informado é inválido.',
            'xp_reward.required'       => 'A recompensa de XP é obrigatória.',
            'coin_reward.required'     => 'A recompensa em moedas é obrigatória.',
            'deadline.after_or_equal'  => 'O prazo não pode ser anterior ao momento atual.',
            'proof_url.required_if'    => 'A URL da prova é obrigatória quando a tarefa exige prova.',
            'proof_url.url'            => 'A URL de prova deve ser um link válido.',
        ];
    }
}
