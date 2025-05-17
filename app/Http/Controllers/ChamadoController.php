<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChamadoRequest;
use App\Services\ChamadoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChamadoController extends Controller
{
    protected ChamadoService $chamadoService;

    public function __construct(ChamadoService $chamadoService)
    {
        $this->chamadoService = $chamadoService;
    }

    public function index(Request $request): JsonResponse
    {
        return $this->chamadoService->index($request->query('status'));
    }

    public function store(ChamadoRequest $request): JsonResponse
    {
        return $this->chamadoService->store($request->validated());
    }

    public function show(int $id): JsonResponse
    {
        return $this->chamadoService->show($id);
    }

    public function update(ChamadoRequest $request, int $id): JsonResponse
    {
        return $this->chamadoService->update($id, $request->validated());
    }

    public function destroy(int $id): JsonResponse
    {
        return $this->chamadoService->destroy($id);
    }

    public function stats(): JsonResponse
    {
        return $this->chamadoService->stats();
    }
}
