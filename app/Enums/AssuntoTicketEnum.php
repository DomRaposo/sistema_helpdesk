<?php

namespace App\Enums;

enum AssuntoTicketEnum: string
{
    case SUPORTE = 'SUPORTE';
    case FINANCEIRO = 'FINANCEIRO';
    case TECNICO = 'TECNICO';
    case HARDWARE = 'HARDWARE';
    case SOFTWARE = 'SOFTWARE';
    case REDE = 'REDE';
    case IMPRESSORA = 'IMPRESSORA';
    case EMAIL = 'EMAIL';
    case ACESSO = 'ACESSO';
    case OUTROS = 'OUTROS';

    public static function values(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }
}
