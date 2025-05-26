<?php

namespace App\Services;

use App\Repositories\RespostaRepository;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RespostaService
{
    protected $repository;

    public function __construct(RespostaRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        
        return $this->repository->getAll()
            ->map(fn($r) => [
                'id' => $r->id,
                'chamado_id' => $r->chamado_id,
                'mensagem' => $r->mensagem,
                'user_id' => $r->user_id,
                'created_at' => $r->created_at,
                'updated_at' => $r->updated_at,
            ]);
    }

    public function store($data)
    {
        $user = request()->user();

        $data['user_id'] = $user->id;

        return $this->repository->create($data);
    }

    public function show($id)
    {
        $resposta = $this->repository->find($id);

        if (!$resposta) return null;

        return [
            'id' => $resposta->id,
            'chamado_id' => $resposta->chamado_id,
            'mensagem' => $resposta->mensagem,
            'user_id' => $resposta->user_id,
            'created_at' => $resposta->created_at,
            'updated_at' => $resposta->updated_at,
        ];
    }

    public function destroy($id)
    {
        $resposta = $this->repository->find($id);
        return $resposta ? $this->repository->delete($resposta) : false;
    }
}
