<?php

namespace App\Repositories;

use App\Models\Resposta;

class RespostaRepository
{
    public function getAll()
    {
        return Resposta::all();
    }

    public function find($id)
    {
        return Resposta::find($id);
    }

    public function create(array $data)
    {
        return Resposta::create($data);
    }

    public function update($resposta, $data)
    {
        return $resposta->update($data);
    }

    public function delete($resposta)
    {
        return $resposta->delete();
    }


}
