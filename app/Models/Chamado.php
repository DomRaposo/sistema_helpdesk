<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\StatusChamadoEnum;
use App\Enums\AssuntoChamadoEnum;

class Chamado extends Model
{
    use HasFactory;

    protected $table = 'chamados';

    protected $fillable = [
        'titulo',
        'descricao',
        'status',
        'assunto',
        'usuario_id',
    ];

    protected $casts = [
        'status' => StatusChamadoEnum::class,
        'assunto' => AssuntoChamadoEnum::class,
    ];


    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
