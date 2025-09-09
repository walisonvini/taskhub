<?php

namespace App\Enums\Task;

enum TaskExportStatus: string {
    case PENDENTE = 'pendente';
    case PROCESSANDO = 'processando';
    case CONCLUIDO = 'concluído';
    case FALHOU = 'falhou';
}
