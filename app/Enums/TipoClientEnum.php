<?php


namespace App\Enums;

class TipoClientEnum
{
    public const CLIENTE = 'CLIENTE';
    public const ATENDENTE = 'ATENDENTE';
    public const ADMIN = 'ADMIN';

    public static function values(): array
    {
        return array_values([
            self::CLIENTE,
            self::ATENDENTE,
            self::ADMIN,
        ]);
    }
}
