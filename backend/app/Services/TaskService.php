<?php

namespace App\Services;

use App\Models\Task;
use App\Traits\HasCompanyScope;

use Exception;

use Illuminate\Database\Eloquent\Collection;

class TaskService
{
    use HasCompanyScope;

    public function all(): Collection
    {
        return Task::all();
    }

    public function create(array $data): Task
    {
        return Task::create($this->addCompanyContext($data));
    }

    public function find(int $id): Task
    {
        $task = Task::find($id);
        
        if (!$task) {
            throw new Exception('Task not found');
        }
        
        return $task;
    }

    public function update(Task $task, array $data): Task
    {
        $task->update($data);
        return $task;
    }

    public function delete(Task $task): void
    {
        $task->delete();
    }
}