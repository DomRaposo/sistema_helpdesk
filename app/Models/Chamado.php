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
        'assunto',
        'status',
         'user_id',
        'data_abertura',
    ];

    protected $casts = [
        'status' => StatusChamadoEnum::class,
        'assunto' => AssuntoChamadoEnum::class,
    ];


    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
