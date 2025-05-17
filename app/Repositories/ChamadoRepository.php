<?php

namespace App\Repositories;

use App\Models\Chamado;

class ChamadoRepository
{
    public function getAll()
    {
        return Chamado::all();
    }

    public function getByStatus(string $status)
    {
        return Chamado::where('status', strtoupper($status))->get();
    }

    public function find(int $id): ?Chamado
    {
        return Chamado::find($id);
    }

    public function create(array $data): Chamado
    {
        return Chamado::create($data);
    }

    public function update(Chamado $chamado, array $data): Chamado
    {
        $chamado->update($data);
        return $chamado;
    }

    public function delete(Chamado $chamado): bool
    {
        return $chamado->delete();
    }

    public function countByStatus(string $status): int
    {
        return Chamado::where('status', strtoupper($status))->count();
    }
}
