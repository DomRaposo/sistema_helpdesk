<?php

namespace App\Http\Controllers;
use App\Http\Requests\ChamadoRequest;
use App\Repositories\ChamadoRepository;
use App\Services\ChamadoService;
use Illuminate\Http\JsonResponse;


use Illuminate\Http\Request;

class ChamadoController extends Controller
{
    private ChamadoRepository $chamadoRepository;
    protected $chamadoservice;

    public function __construct(ChamadoService $chamadoService)
    {
        $this->chamadoService = $chamadoService;
    }

    public function index(): JsonResponse
    {
        $chamados = $this->chamadoRepository->list();
        return response()->json($chamados);
    }

    public function store(ChamadoRequest $request): JsonResponse
    {
        $chamado = $this->chamadoservice->store($request->validated());
        return response()->json($chamado, 201);
    }

    public function show(int $id): JsonResponse
    {
        $chamado = $this->chamadoservice->show($id);
        return response()->json($chamado);
    }

    public function update(ChamadoRequest $request, int $id): JsonResponse
    {
        $chamado = $this->chamadoservice->update($id, $request->validated());
        return response()->json($chamado);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->chamadoservice->destroy($id);
        return response()->json(null, 204);
    }

    public function stats(): JsonResponse
    {
        $stats = $this->chamadoservice->getStats();
        return response()->json($stats);
    }
}
