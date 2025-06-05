<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\StatusTicketEnum;
use App\Enums\AssuntoTicketEnum;

class Ticket extends Model
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
        'status' => StatusTicketEnum::class,
        'assunto' => AssuntoTicketEnum::class,
    ];


    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
