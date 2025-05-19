<?php

namespace App\Repositories;

use App\Models\Chamado;

class ChamadoRepository
{
    public function getAll()
    {
        return Chamado::all();
    }

    public function getByStatus($status)
    {
        return Chamado::where('status', $status)->get();
    }

    public function find($id)
    {
        return Chamado::find($id);
    }

    public function create($data)
    {
        return Chamado::create($data);
    }

    public function update($chamado, $data)
    {
        return $chamado->update($data);
    }

    public function delete($chamado)
    {
        return $chamado->delete();
    }

    public function countByStatus($status)
    {
        return Chamado::where('status', $status)->count();
    }
}
