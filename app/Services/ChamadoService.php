<?php

namespace App\Services;

use App\Models\Chamado;
use App\Repositories\ChamadoRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ChamadoService
{
    protected ChamadoRepository $repository;

    public function __construct(ChamadoRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(?string $status): JsonResponse
    {
        $chamados = $status
            ? $this->repository->getByStatus($status)
            : $this->repository->getAll();

        return response()->json($chamados);
    }

    public function store(array $data): JsonResponse
    {
        $data['usuario_id'] = Auth::id();
        $chamado = $this->repository->create($data);

        return response()->json($chamado, 201);
    }

    public function show(int $id): JsonResponse
    {
        $chamado = $this->repository->find($id);

        return $chamado
            ? response()->json($chamado)
            : response()->json(['message' => 'Chamado não encontrado'], 404);
    }

    public function update(int $id, array $data): JsonResponse
    {
        $chamado = $this->repository->find($id);

        if (!$chamado) {
            return response()->json(['message' => 'Chamado não encontrado'], 404);
        }

        $updated = $this->repository->update($chamado, $data);
        return response()->json($updated);
    }

    public function destroy(int $id): JsonResponse
    {
        $chamado = $this->repository->find($id);

        if (!$chamado) {
            return response()->json(['message' => 'Chamado não encontrado'], 404);
        }

        $this->repository->delete($chamado);
        return response()->json(null, 204);
    }

    public function stats(): JsonResponse
    {
        $abertos = $this->repository->countByStatus('ABERTO');
        $emAtendimento = $this->repository->countByStatus('EM_ATENDIMENTO');
        $encerrados = $this->repository->countByStatus('ENCERRADO');
        $total = $abertos + $emAtendimento + $encerrados;

        return response()->json([
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
        ]);
    }

    private function getBorderColorByStatus(string $status): string
    {
        return match (strtoupper($status)) {
            'ABERTO' => 'border-blue-600',
            'EM_ATENDIMENTO' => 'border-yellow-500',
            'ENCERRADO' => 'border-red-600',
            'TOTAL' => 'border-green-600',
            default => 'border-gray-500',
        };
    }
}
