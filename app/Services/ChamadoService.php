<?php

namespace App\Services;

use App\Models\Chamado;
use App\Repositories\ChamadoRepository;

class ChamadoService
{
    public function __construct(ChamadoRepository $chamadoRepository)
    {
        $this->chamadoRepository = $chamadoRepository;
    }

    public function getAll(?string $status = null)
    {
        return $this->chamadoRepository->getAll($status);
    }

    public function getStats():array
    {
        return $this->chamadoRepository->getStats();
    }

    public function create(array $data): Chamado
    {
        $data['usuario_id'] = Auth::id(); //opcional, registrar autor chamado
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
    public function show(Chamado $chamado): Chamado
    {
        return $chamado;
    }
}
