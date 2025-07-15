<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\StatusChamadoEnum;
use App\Enums\AssuntoChamadoEnum;

class ChamadoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'assunto' => 'required|in:' . implode(',', AssuntoChamadoEnum::values()),
            'status' => 'required|in:' . implode(',', StatusChamadoEnum::values()),
            'user_id' => 'required|int|exists:users,id',
            'data_abertura' => 'required|date',
            'prioridade' => 'required|in:baixo,medio,alto',  // validação da prioridade
        ];
    }

    public function messages(): array
    {
        return [
            'status.in' => 'O status selecionado é inválido.',
            'assunto.in' => 'O assunto selecionado é inválido.',
            'user_id.exists' => 'O usuário selecionado não existe.',
            'prioridade.in' => 'A prioridade selecionada é inválida. Deve ser baixo, medio ou alto.',  // mensagem personalizada
        ];
    }
}
