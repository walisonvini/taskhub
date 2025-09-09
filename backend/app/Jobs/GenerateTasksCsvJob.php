<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\TaskExport;

use App\Services\TaskExportService;

use App\Enums\Task\TaskExportStatus;

use Throwable;

class GenerateTasksCsvJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $taskExport;

    public function __construct(TaskExport $taskExport)
    {
        $this->taskExport = $taskExport;
    }

    public function handle()
    {
        try {
            $this->taskExport->update(['status' => TaskExportStatus::PROCESSANDO, 'started_at' => now()]);
            
            $taskExportService = app(TaskExportService::class);
            $taskExportService->generateCsvFile($this->taskExport);
        } catch (Throwable $e) {
            $this->taskExport->update(['status' => TaskExportStatus::FALHOU, 'error_message' => $e->getMessage()]);
        }
    }
}
