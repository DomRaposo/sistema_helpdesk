<?php



namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\StatusTicketEnum;
use App\Enums\AssuntoTicketEnum;

class TicketRequest extends FormRequest
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
'assunto' => 'required|in:' . implode(',', AssuntoTicketEnum::values()),
'status' => 'required|in:' . implode(',', StatusTicketEnum::values()),
'user_id' => 'required|int|exists:users,id',
'data_abertura' => 'required|date',
];
}

    public function messages(): array
    {
        return [
            'status.in' => 'O status selecionado é inválido.',
            'assunto.in' => 'O assunto selecionado é inválido.',
            'user_id.exists' => 'O usuário selecionado não existe.',

        ];
    }
}
