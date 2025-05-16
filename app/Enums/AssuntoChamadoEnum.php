<?php

namespace App\Enums;

class AssuntoChamadoEnum
{
    public const SUPORTE = 'suporte';
    public const FINANCEIRO = 'financeiro';
    public const TÉCNICO = 'técnico';

    public static function values(): array
    {
        return [
            self::SUPORTE,
            self::FINANCEIRO,
            self::TÉCNICO,
        ];
    }
}
