<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\StatusChamadoEnum;
use App\Enums\AssuntoChamadoEnum;
use App\Enums\PrioridadesChamadosEnum; // Se estiver usando enum de prioridade

class Chamado extends Model
{
    use HasFactory;

    protected $table = 'chamados';

    protected $fillable = [
        'titulo',
        'descricao',
        'assunto',
        'prioridade',
        'status',
        'user_id',
        'data_abertura',
        'imagem', // se estiver usando imagens
    ];

    protected $casts = [
        'status' => StatusChamadoEnum::class,
        'assunto' => AssuntoChamadoEnum::class,
        'prioridade' => PrioridadesChamadosEnum::class
    ];// Se estiver usando enum de prioridade

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function respostas()
    {
        return $this->hasMany(\App\Models\Resposta::class, 'chamado_id');
    }
}
