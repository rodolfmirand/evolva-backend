<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth; //TODO: remover ao migrar a validação pro service

class TaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = Auth::user();
        $journeyId = $this->input('journey_id');

        // Permite apenas se o usuário for mestre dessa jornada
        return $user && $user->journeys()
            ->where('journey_id', $journeyId)
            ->wherePivot('is_master', true)
            ->exists();  //TODO: ajustar esse authorize, acho q era pra tar no service
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
            'deadline'       => 'nullable|date|after_or_equal:today',
            'requires_proof' => 'boolean',
            'proof_url'      => 'nullable|url'
        ];
    }

    public function messages(): array
    {
        return [
            'journey_id.required'      => 'A jornada é obrigatória.',
            'journey_id.exists'        => 'A jornada informada não existe.',
            'title.required'           => 'O título da tarefa é obrigatório.',
            'title.string'             => 'O título da tarefa deve ser uma string.',
            'title.max'                => 'O título da tarefa não pode exceder 255 caracteres.',
            'description.string'       => 'A descrição da tarefa deve ser uma string.',
            'type.in'                  => 'O tipo de tarefa informado é inválido.',
            'xp_reward.required'       => 'A recompensa de XP é obrigatória.',
            'coin_reward.required'     => 'A recompensa em moedas é obrigatória.',
            'deadline.after_or_equal'  => 'O prazo não pode ser anterior a hoje.',
            'proof_url.url'            => 'A URL de prova deve ser um link válido.'
        ];
    }
}
