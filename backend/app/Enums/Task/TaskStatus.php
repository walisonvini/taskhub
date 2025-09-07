<?php

namespace App\Enums\Task;

enum TaskStatus: string {
    case PENDENTE = 'pendente';
    case ANDAMENTO = 'em andamento';
    case CONCLUIDA = 'concluída';
}