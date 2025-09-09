<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

use App\Models\TaskExport;
use App\Models\Task;

use App\Enums\Task\TaskExportStatus;

use App\Jobs\GenerateTasksCsvJob;

use App\Traits\HasCompanyScope;

use Illuminate\Support\Facades\Log;

use Illuminate\Support\Collection;

use Exception;

class TaskExportService
{
    use HasCompanyScope;

    public function all(): Collection
    {
        return TaskExport::where('user_id', $this->getUserId())->orderBy('created_at', 'desc')->get();
    }

    public function find(int $id): TaskExport
    {
        $taskExport = TaskExport::find($id);

        if (!$taskExport) {
            throw new Exception('Exportação não encontrada');
        }

        return $taskExport;
    }

    public function create(array $data): TaskExport
    {
        $taskExport = TaskExport::create($this->addCompanyContext($data));

        GenerateTasksCsvJob::dispatch($taskExport);

        return $taskExport;
    }

    public function generateCsvFile(TaskExport $taskExport): void
    {
        $filters = $taskExport->filters;
        if (is_string($filters)) {
            $filters = json_decode($filters, true);
        }

        $query = Task::query();

        $query->where('company_id', $taskExport->company_id);
        
        if ($filters && is_array($filters)) {
            $query->where($filters);
        }
 
        $tasks = $query->get();

        Log::info($tasks);

        if ($tasks->isEmpty()) {
            $taskExport->update([
                'status' => TaskExportStatus::FALHOU,
                'error_message' => 'Nenhuma tarefa encontrada',
                'completed_at' => now(),
            ]);
        }

        $handle = fopen('php://temp', 'r+'); 

        fputcsv($handle, ['Título', 'Status', 'Descrição', 'Prioridade', 'Data limite', 'Data de criação'], ';');

        foreach ($tasks as $task) {
            fputcsv($handle, [
                $task->title,
                $task->status->value,
                $task->description,
                $task->priority->value,
                $task->due_date,
                $task->created_at,
            ], ';');
        }

        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);

        $filename = 'tasks_' . now()->format('Ymd_His') . '_' . $taskExport->id . '_' . $taskExport->company_id . '.csv';
        $filePath = 'exports/' . $filename;

        Storage::put($filePath, $csv);

        $taskExport->update([
            'status' => TaskExportStatus::CONCLUIDO,
            'file_path' => $filePath,
            'filename' => $filename,
            'completed_at' => now(),
        ]);
    }

    public function download(TaskExport $taskExport)
    {
        if (!$taskExport->file_path) {
            throw new Exception('File not found');
        }

        return Storage::download($taskExport->file_path);
    }
}