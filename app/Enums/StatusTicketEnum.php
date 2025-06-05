<?php
namespace App\Enums;

enum StatusTicketEnum: string
{
    case ABERTO = 'ABERTO';
    case EM_ATENDIMENTO = 'EM_ANADAMENTO';
    case ENCERRADO = 'ENCERRADO';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
