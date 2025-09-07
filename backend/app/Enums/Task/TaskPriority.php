<?php

namespace App\Enums\Task;

enum TaskPriority: string {
    case ALTA = 'alta';
    case MEDIA = 'média';
    case BAIXA = 'baixa';
}