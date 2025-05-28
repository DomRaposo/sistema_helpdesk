<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Request\RespostaChamadoRequest;


class Resposta extends Model
{
    use HasFactory;

    protected $table = 'respostas';

    protected $fillable = [
        'chamado_id',
        'user_id',
        'mensagem',
        'created_at',
    ];


    public function chamado()
    {
        return $this->belongsTo(Chamado::class, 'chamado_id');
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
