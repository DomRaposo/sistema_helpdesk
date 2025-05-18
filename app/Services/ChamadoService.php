<?php

namespace App\Services;

use App\Repositories\ChamadoRepository;
use Illuminate\Support\Facades\Auth;

class ChamadoService
{
    protected $repository;

    public function __construct(ChamadoRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $chamados = $this->repository->getAll();

    }

    public function store($data)
    {
        $data['user_id'] = Auth::id();
        $chamado = $this->repository->create($data);

        return [
            'id' => $chamado->id,
            'titulo' => $chamado->titulo,
            'message' => 'Chamado criado com sucesso'
        ];
    }

    public function show($id)
    {
        $chamado = $this->repository->find($id);

        if (!$chamado) return null;

        return [
            'id' => $chamado->id,
            'titulo' => $chamado->titulo,
            'descricao' => $chamado->descricao,
            'status' => $chamado->status,
            'border_color' => $this->getBorderColorByStatus($chamado->status),
        ];
    }

    public function update($id, $data)
    {
        $chamado = $this->repository->find($id);

        if (!$chamado || !$this->repository->update($chamado, $data)) return null;

        return [
            'id' => $chamado->id,
            'message' => 'Chamado atualizado com sucesso'
        ];
    }

    public function destroy($id)
    {
        $chamado = $this->repository->find($id);
        return $chamado ? $this->repository->delete($chamado) : false;
    }

    public function getStats(): array
    {
        $abertoStats = $this->getStatusStats('ABERTO');
        $emAtendimentoStats = $this->getStatusStats('EM_ATENDIMENTO');
        $encerradoStats = $this->getStatusStats('ENCERRADO');

        $total = $abertoStats + $emAtendimentoStats + $encerradoStats;

        return [
            'aberto' => [
                'count' => $abertoStats,
                'border_color' => $this->getBorderColorByStatus('ABERTO'),
                'title' => 'Aberto',
            ],
            'em_atendimento' => [
                'count' => $emAtendimentoStats,
                'border_color' => $this->getBorderColorByStatus('EM_ATENDIMENTO'),
                'title' => 'Em Atendimento',
            ],
            'encerrado' => [
                'count' => $encerradoStats,
                'border_color' => $this->getBorderColorByStatus('ENCERRADO'),
                'title' => 'Encerrado',
            ],
            'total' => [
                'count' => $total,
                'border_color' => $this->getBorderColorByStatus('TOTAL'),
                'title' => 'Total',
            ],
        ];
    }

    private function getStatusStats(string $status): int
    {
        return $this->repository->countByStatus($status);
    }

    private function getBorderColorByStatus(string $status): string
    {
        switch (strtoupper($status)) {
            case 'ABERTO':
                return 'border-blue-600';
            case 'EM_ATENDIMENTO':
                return 'border-yellow-500';
            case 'ENCERRADO':
                return 'border-red-600';
            case 'TOTAL':
                return 'border-green-600';
            default:
                return 'border-gray-500';
        }
    }

}
