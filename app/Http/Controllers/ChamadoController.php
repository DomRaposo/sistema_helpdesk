<?php

namespace App\Http\Controllers;

use App\Enums\StatusChamadoEnum;
use App\Services\ChamadoService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChamadoController extends Controller
{
    protected $service;

    public function __construct(ChamadoService $service)
    {
        $this->service = $service;
    }

    public function stats(): JsonResponse
    {
        $stats = $this->service->getStats();
        return response()->json($stats);
    }

    public function index(): JsonResponse
    {
        $chamados = $this->service->index();
        return response()->json($chamados);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'status' => 'nullable|in:' . implode(',', StatusChamadoEnum::values()),
            'prioridade' => 'required|in:baixo,medio,alto',
            'assunto' => 'required|string',
            'user_id' => 'required|exists:users,id',
        ]);

        $data = $request->all();
        $data['data_abertura'] = now()->toDateString();

        // Garante um status válido
        $data['status'] = in_array($data['status'] ?? null, StatusChamadoEnum::values())
            ? $data['status']
            : StatusChamadoEnum::ABERTO->value;

        if ($request->hasFile('imagem')) {
            $data['imagem'] = $request->file('imagem')->store('chamados', 'public');
        }

        $result = $this->service->store($data);

        return response()->json($result, 201);
    }

    public function show($id): JsonResponse
    {
        $chamado = $this->service->show($id);

        if (!$chamado) {
            return response()->json(['message' => 'Chamado não encontrado'], 404);
        }

        return response()->json($chamado);
    }

    public function updateStatus($id, Request $request)
    {
        $request->validate([
            'status' => 'required|in:' . implode(',', StatusChamadoEnum::values()),
        ]);

        $status = $request->input('status');
        $chamado = $this->service->updateStatus($id, $status);

        return response()->json([
            'message' => 'Status atualizado com sucesso',
            'data' => $chamado,
        ]);
    }

    public function close($id)
    {
        $chamado = $this->service->closeChamado($id);

        return response()->json([
            'message' => 'Chamado encerrado com sucesso',
            'data' => $chamado
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $deleted = $this->service->destroy($id);

        if (!$deleted) {
            return response()->json(['message' => 'Chamado não encontrado'], 404);
        }

        return response()->json(['message' => 'Chamado deletado com sucesso']);
    }

    public function gerarPDF(Request $request)
    {
        $status = $request->query('status');

        $dados = $this->service->gerarPDF($status);
        $pdf = Pdf::loadView('relatorios.chamados', ['chamados' => $dados]);

        return $pdf->stream('relatorio_chamados.pdf');
    }

    public function filter($status)
    {
        $result = $this->service->filterByStatus($status);
        return response()->json($result);
    }

    public function update(Request $request, $id)
    {
        $chamado = $this->service->show($id);
        if (!$chamado) {
            return response()->json(['message' => 'Chamado não encontrado'], 404);
        }

        $request->validate([
            'prioridade' => 'required|in:baixo,medio,alto',
        ]);

        $data = $request->all();
        $chamado = $this->service->update($id, $data);

        return response()->json([
            'message' => 'Chamado atualizado com sucesso',
            'data' => $chamado,
        ]);
    }
}
