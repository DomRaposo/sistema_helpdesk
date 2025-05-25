<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RespostaChamadoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'mensagem' => 'required|string',
            'chamado_id' => 'required|exists:chamados,id',
            'user_id' => 'required|exists:users,id',
        ];
    }

    public function messages(): array
    {
        return [
            'mensagem.required' => 'A mensagem da resposta é obrigatória.',
            'chamado_id.required' => 'O ID do chamado é obrigatório.',
            'chamado_id.exists' => 'O chamado informado não existe.',
            'user_id.required' => 'O ID do usuário é obrigatório.',
            'user_id.exists' => 'O usuário informado não existe.',
        ];
    }
}
