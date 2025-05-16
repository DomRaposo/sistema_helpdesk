<?php

// app/Http/Requests/ChamadoRequest.php

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
'user_id' => 'required|exists:users,id',
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
