<?php

namespace App\Services;
use App\Enums\StatusChamadoEnum;
use App\Models\Chamado;
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
        return $this->repository->getAll()
            ->map(fn($c) => [
                'id'        => $c->id,
                'titulo'    => $c->titulo,
                'descricao' => $c->descricao,
                'status'    => $c->status->value,
                'assunto'   => $c->assunto->value,
            ]);
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


    private function getStatusStats(string $status): array
    {
        return [
            'count' => $this->repository->countByStatus($status)
            ];

    }

    private function getBorderColorByStatus($status)
    {
        switch ($status) {
            case 'aberto':
                return 'border-blue-600';
            case 'em_atendimento':
                return 'border-yellow-500';
            case 'encerrado':
                return 'border-red-600';
            case 'total':
                return 'border-green-600';
            default:
                return 'border-gray-500';
        }
    }

    public function getStats(): array
    {
        $abertoStats = $this->getStatusStats('aberto');
        $emAtendimentoStats = $this->getStatusStats('em_atendimento');
        $encerradoStats = $this->getStatusStats('encerrado');

        $totalCount = $abertoStats['count'] + $emAtendimentoStats['count'] + $encerradoStats['count'];

        return [
            'aberto' => [
                'stats' => $abertoStats,
                'border_color' => $this->getBorderColorByStatus('aberto'),
                'title' => 'Aberto',
            ],
            'em_atendimento' => [
                'stats' => $emAtendimentoStats,
                'border_color' => $this->getBorderColorByStatus('em_atendimento'),
                'title' => 'Em Atendimento',
            ],
            'encerrado' => [
                'stats' => $encerradoStats,
                'border_color' => $this->getBorderColorByStatus('encerrado'),
                'title' => 'Encerrado',
            ],
            'total' => [
                'stats' => [
                    'count' => $totalCount,

                ],
                'border_color' => $this->getBorderColorByStatus('total'),
                'title' => 'Total',
            ],
        ];
    }

}
