<?php

namespace App\Http\Controllers;

use App\Services\ChamadoService;
use Illuminate\Http\Request;

class ChamadoController extends Controller
{
    protected $service;

    public function __construct(ChamadoService $service)
    {
        $this->service = $service;
    }


    public function index()
    {
        $chamados = $this->service->index();
        return response()->json($chamados);
    }


    public function store(Request $request)
    {

        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'status' => 'required|string|in:ABERTO,EM_ATENDIMENTO,ENCERRADO',
        ]);

        $result = $this->service->store($validated);

        return response()->json($result, 201);
    }


    public function show($id)
    {
        $chamado = $this->service->show($id);

        if (!$chamado) {
            return response()->json(['message' => 'Chamado não encontrado'], 404);
        }

        return response()->json($chamado);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'titulo' => 'sometimes|required|string|max:255',
            'descricao' => 'sometimes|nullable|string',
            'status' => 'sometimes|required|string|in:ABERTO,EM_ATENDIMENTO,ENCERRADO',
        ]);

        $result = $this->service->update($id, $validated);

        if (!$result) {
            return response()->json(['message' => 'Chamado não encontrado ou não atualizado'], 404);
        }

        return response()->json($result);
    }

    public function destroy($id)
    {
        $deleted = $this->service->destroy($id);

        if (!$deleted) {
            return response()->json(['message' => 'Chamado não encontrado'], 404);
        }

        return response()->json(['message' => 'Chamado deletado com sucesso']);
    }


    public function stats()
    {
        $stats = $this->service->stats();

        return response()->json($stats);
    }
}
