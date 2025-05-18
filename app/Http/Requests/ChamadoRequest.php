<?php

namespace App\Http\Requests;

use App\Enums\AssuntoChamadoEnum;
use Illuminate\Foundation\Http\FormRequest;

class ChamadoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'status' => 'required|string|in:ABERTO,EM_ATENDIMENTO,ENCERRADO',
            'assunto' => 'nullable|string|in:' . implode(',', AssuntoChamadoEnum::values()),
            ];
    }
}
