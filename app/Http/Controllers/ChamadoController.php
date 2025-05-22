<?php

namespace App\Http\Controllers;

use App\Services\ChamadoService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\ChamadoRequest;
use App\Http\Requests\UpdateChamadoRequest;
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

    public function store(ChamadoRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $result = $this->service->store($validated);

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

    public function update(ChamadoRequest $request, $id): JsonResponse
    {
        $validated = $request->validated();
        $result = $this->service->update($id, $validated);

        if (!$result) {
            return response()->json(['message' => 'Chamado não encontrado ou não atualizado'], 404);
        }

        return response()->json($result);
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


    public function filter($status){
        $result = $this->service->filterByStatus($status);
        return response()->json($result);
    }


}
