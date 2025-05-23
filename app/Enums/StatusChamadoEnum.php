<?php
namespace App\Enums;

enum StatusChamadoEnum: string
{
    case ABERTO = 'ABERTO';
    case EM_ATENDIMENTO = 'EM_ATENDIMENTO';
    case ENCERRADO = 'ENCERRADO';
}
