<?php

namespace App\Http\Controllers;

use App\Http\Request\RespostaChamadoRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\RespostaService;


class RespostaController extends Controller
{
    protected $respostaService;

    public function __construct(RespostaService $respostaService)
    {
        $this->respostaService = $respostaService;

    }

    public function store(RespostaChamadoRequest $request)
    {

        $data = $request->all();
        $result = $this->respostaService->store($data);
        return response()->json($result, 201);
    }

    public function show($id): JsonResponse
    {
        $resposta = $this->respostaService->show($id);

        if (!$resposta) {
            return response()->json(['message' => 'Call response not found'], 404);
        }

        return response()->json($resposta);
    }

    public function destroy($id): JsonResponse
    {
        $deleted = $this->respostaService->destroy($id);

        if (!$deleted) {
            return response()->json(['message' => 'Call response not found'], 404);
        }

        return response()->json(['message' => 'Answer deleted successfully']);
    }

    public function getByChamado($id)
    {
        $respostas = \App\Models\Resposta::where('chamado_id', $id)
            ->with('usuario')
            ->orderBy('created_at')
            ->get()
            ->map(function($r) {
                return [
                    'id' => $r->id,
                    'chamado_id' => $r->chamado_id,
                    'mensagem' => $r->mensagem,
                    'user_id' => $r->user_id,
                    'usuario_nome' => $r->usuario->name ?? null,
                    'created_at' => $r->created_at,
                    'updated_at' => $r->updated_at,
                ];
            });

        return response()->json($respostas);
    }


}
