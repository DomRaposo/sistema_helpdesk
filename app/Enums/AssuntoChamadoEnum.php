<?php

namespace App\Enums;

enum AssuntoChamadoEnum: string
{
    case SUPORTE = 'suporte';
    case FINANCEIRO = 'financeiro';
    case TECNICO = 'tecnico';

    public static function values(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }
}
