<?php

namespace App\Services;
use App\Enums\StatusTicketEnum;
use App\Models\Ticket;
use App\Repositories\TicketRepository;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

class TicektService
{
    protected $repository;

    public function __construct(TicketRepository $repository)
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
                'created_at' => $c->created_at,
                'updated_at' => $c->updated_at,
            ]);
    }

    public function gerarPDF($status = null)
    {
        $chamados = $status
            ? $this->filterByStatus($status)
            : $this->repository->getAll();

        return $chamados->map(fn($c) => [
            'id'                => $c->id,
            'titulo'            => $c->titulo,
            'descricao'         => $c->descricao,
            'status'            => $c->status->value,
            'assunto'           => $c->assunto->value,
            'data_criacao'      => $c->created_at->format('d/m/Y'),
            'data_encerramento' => $c->updated_at->format('d/m/Y'),
        ]);
    }


    public function filterByStatus($status){
        return $this->repository->filterByStatus($status);
    }

 public function closeChamado($id)
    {
        $ticket = $this->repository->find($id);

        if (!$ticket) {
            throw new \Exception('Chamado não encontrado');
        }

        return $this->repository->update($ticket, ['status' => 'ENCERRADO']);
    }


    public function store($data)
    {
        $data['user_id'] = auth()->id();
        $data['data_abertura'] = Carbon::now()->toDateString();




        $chamado = $this->repository->create($data);

        return [
            'id' => $chamado->id,
            'titulo' => $chamado->titulo,
            'message' => 'Chamado criado com sucesso'
        ];
    }



    public function show($id)
    {
        $ticket = $this->repository->find($id);

        if (!$ticket) return null;

        return [
            'id' => $ticket->id,
            'titulo' => $ticket->titulo,
            'descricao' => $ticket->descricao,
            'status' => $ticket->status,
            'border_color' => $this->getBorderColorByStatus($ticket->status),
        ];
    }


    public function updateStatus($id, $status)
    {
        $ticket = $this->repository->find($id);

        if (!$ticket) {
            throw new \Exception('Chamado não encontrado');
        }

        return $this->repository->update($ticket, ['status' => $status]);
    }


    public function destroy($id)
    {
        $ticket = $this->repository->find($id);
        return $ticket ? $this->repository->delete($ticket) : false;
    }


    private function getStatusStats(string $status): array
    {
        return [
            'count' => $this->repository->countByStatus($status)
        ];
    }

    private function getBorderColorByStatus(string $status): string
    {
        switch (strtolower($status)) {
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
        $abertoStats = $this->getStatusStats('ABERTO');
        $emAtendimentoStats = $this->getStatusStats('EM_ATENDIMENTO');
        $encerradoStats = $this->getStatusStats('ENCERRADO');

        $totalCount = $abertoStats['count'] + $emAtendimentoStats['count'] + $encerradoStats['count'];

        return [
            'aberto' => [
                'stats' => $abertoStats,
                'border_color' => $this->getBorderColorByStatus('aberto'),
                'title' => 'Aberto'
            ],
            'em_atendimento' => [
                'stats' => $emAtendimentoStats,
                'border_color' => $this->getBorderColorByStatus('em_atendimento'),
                'title' => 'Em Atendimento'
            ],
            'encerrado' => [
                'stats' => $encerradoStats,
                'border_color' => $this->getBorderColorByStatus('encerrado'),
                'title' => 'Encerrado'
            ],
            'total' => [
                'stats' => [
                    'count' => $totalCount
                ],
                'border_color' => $this->getBorderColorByStatus('total'),
                'title' => 'Total'
            ]
        ];
    }}
