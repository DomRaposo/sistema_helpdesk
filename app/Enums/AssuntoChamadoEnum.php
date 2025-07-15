<?php


namespace App\Enums;

enum AssuntoChamadoEnum: string
{
    case HARDWARE = 'hardware';
    case SOFTWARE = 'software';
    case REDE = 'rede';
    case IMPRESSORA = 'impressora';
    case EMAIL = 'email';
    case ACESSO = 'acesso';
    case OUTROS = 'outros';

    public static function values(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }
}
