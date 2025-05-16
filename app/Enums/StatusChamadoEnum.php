<?php

namespace App\Enums;

class StatusChamadoEnum
{
    public const ABERTO = 'ABERTO';
    public const EM_ATENDIMENTO = 'EM_ATENDIMENTO';
    public const ENCERRADO = 'ENCERRADO';

    public static function values(): array
    {
        return array_values([
            self::ABERTO,
            self::EM_ATENDIMENTO,
            self::ENCERRADO,
        ]);
    }
}
