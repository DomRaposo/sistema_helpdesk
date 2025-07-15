<?php

namespace App\Services;

use App\Enums\StatusChamadoEnum;
use App\Models\Chamado;
use App\Repositories\ChamadoRepository;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
        'id'         => $c->id,
        'titulo'     => $c->titulo,
        'descricao'  => $c->descricao,
        'status'     => $c->status->value,
        'assunto'    => $c->assunto->value,
        'prioridade' => $c->prioridade, // <-- adicionado aqui
        'created_at' => $c->created_at,
        'updated_at' => $c->updated_at,
        'usuarioId'  => $c->user_id,
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

    public function filterByStatus($status)
    {
        return $this->repository->filterByStatus($status);
    }

    public function closeChamado($id)
    {
        $chamado = $this->repository->find($id);

        if (!$chamado) {
            throw new \Exception('Chamado não encontrado');
        }

        return $this->repository->update($chamado, ['status' => StatusChamadoEnum::ENCERRADO->value]);
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
        $chamado = $this->repository->find($id);

        if (!$chamado) return null;

        $user = auth()->user();
        if ($user->tipo !== 'admin' && $chamado->user_id !== $user->id) {
            abort(403, 'Acesso negado');
        }

        $respostas = $chamado->respostas()
            ->with('usuario')
            ->orderBy('created_at')
            ->get()
            ->map(fn($r) => [
                'id' => $r->id,
                'chamado_id' => $r->chamado_id,
                'mensagem' => $r->mensagem,
                'user_id' => $r->user_id,
                'usuario_nome' => $r->usuario->name ?? null,
                'created_at' => $r->created_at,
                'updated_at' => $r->updated_at,
            ]);

        return [
            'id'           => $chamado->id,
            'titulo'       => $chamado->titulo,
            'descricao'    => $chamado->descricao,
            'status'       => $chamado->status->value,
            'border_color' => $this->getBorderColorByStatus($chamado->status->value),
            'respostas'    => $respostas,
        ];
    }

    public function updateStatus($id, $status)
    {
        // Validação para garantir status válido usando enum
        if (!in_array($status, StatusChamadoEnum::values())) {
            throw new \InvalidArgumentException("Status inválido: $status");
        }

        $chamado = $this->repository->find($id);

        if (!$chamado) {
            throw new \Exception('Chamado não encontrado');
        }

        return $this->repository->update($chamado, ['status' => $status]);
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

    private function getBorderColorByStatus(string $status): string
    {
        switch (strtolower($status)) {
            case strtolower(StatusChamadoEnum::ABERTO->value):
                return 'border-blue-600';
            case strtolower(StatusChamadoEnum::EM_ATENDIMENTO->value):
                return 'border-yellow-500';
            case strtolower(StatusChamadoEnum::ENCERRADO->value):
                return 'border-red-600';
            case 'total':
                return 'border-green-600';
            default:
                return 'border-gray-500';
        }
    }

    public function getStats(): array
    {
        $abertoStats = $this->getStatusStats(StatusChamadoEnum::ABERTO->value);
        $emAtendimentoStats = $this->getStatusStats(StatusChamadoEnum::EM_ATENDIMENTO->value);
        $encerradoStats = $this->getStatusStats(StatusChamadoEnum::ENCERRADO->value);

        $totalCount = $abertoStats['count'] + $emAtendimentoStats['count'] + $encerradoStats['count'];

        return [
            'aberto' => [
                'stats' => $abertoStats,
                'border_color' => $this->getBorderColorByStatus(StatusChamadoEnum::ABERTO->value),
                'title' => 'Aberto'
            ],
            'em_atendimento' => [
                'stats' => $emAtendimentoStats,
                'border_color' => $this->getBorderColorByStatus(StatusChamadoEnum::EM_ATENDIMENTO->value),
                'title' => 'Em Atendimento'
            ],
            'encerrado' => [
                'stats' => $encerradoStats,
                'border_color' => $this->getBorderColorByStatus(StatusChamadoEnum::ENCERRADO->value),
                'title' => 'Encerrado'
            ],
            'total' => [
                'stats' => ['count' => $totalCount],
                'border_color' => $this->getBorderColorByStatus('total'),
                'title' => 'Total'
            ]
        ];
    }

    public function update($id, $data)
    {
        $chamado = $this->repository->find($id);
        if (!$chamado) {
            throw new \Exception('Chamado não encontrado');
        }

        if (empty($data['prioridade'])) {
            $data['prioridade'] = $chamado->prioridade;
        }

        $this->repository->update($chamado, $data);
        return $chamado->fresh();
    }
}
