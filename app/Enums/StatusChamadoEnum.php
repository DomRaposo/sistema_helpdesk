<?php
namespace App\Enums;

class StatusChamadoEnum
{
public const ABERTO = 'aberto';
public const EM_ATENDIMENTO = 'em_atendimento';
public const ENCERRADO = 'encerrado';

public static function values(): array
{
return array_values([
self::ABERTO,
self::EM_ATENDIMENTO,
self::ENCERRADO,
]);
}
}
