<?php
namespace App\Repositories;

class ChamadoRepository{
    public function countByStatus(string $status): int
    {
        return Chamado::where('status', $status)->count();
    }

    public function getAll(string $status = null)
    {
        $query = Chamado::query();

        if ($status) {
            $query->where('status', strtolower($status));
        }

        return $query->get();
    }

    public function getStats(): array
    {
        $abertos = $this->postRepository->countByStatus('aberto');
        $emAtendimento = $this->postRepository->countByStatus('em_atendimento');
        $encerrados = $this->postRepository->countByStatus('encerrado');
        $total = $abertos + $emAtendimento + $encerrados;

        return [
            'ABERTO' => [
                'stats' => ['total' => $abertos],
                'border_color' => $this->getBorderColorByStatus('ABERTO'),
                'title' => 'Abertos'
            ],
            'EM_ATENDIMENTO' => [
                'stats' => ['total' => $emAtendimento],
                'border_color' => $this->getBorderColorByStatus('EM_ATENDIMENTO'),
                'title' => 'Em Atendimento'
            ],
            'ENCERRADO' => [
                'stats' => ['total' => $encerrados],
                'border_color' => $this->getBorderColorByStatus('ENCERRADO'),
                'title' => 'Encerrados'
            ],
            'TOTAL' => [
                'stats' => ['total' => $total],
                'border_color' => $this->getBorderColorByStatus('TOTAL'),
                'title' => 'Total'
            ]
        ];
    }
    private function getBorderColorByStatus(string $status): string
    {
        switch ($status) {
            case 'ABERTO':
                return 'border-blue-600';
            case 'EM_ATENDIMENTO':
                return 'border-yellow-500';
            case 'ENCERRADO':
                return 'border-red-600';
            case 'total':
                return 'border-green-600';
            default:
                return 'border-gray-500';
        }
    }
}
