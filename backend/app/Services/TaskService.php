<?php

namespace App\Services;

use App\Models\Task;
use App\Traits\HasCompanyScope;

use Exception;

use Illuminate\Database\Eloquent\Collection;

class TaskService
{
    use HasCompanyScope;

    public function all($perPage = 10, $page = 1, $filters = [])
    {
        $query = Task::query();
        
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        
        if (!empty($filters['priority'])) {
            $query->where('priority', $filters['priority']);
        }
        
        return $query->paginate($perPage, ['*'], 'page', $page);
    }

    public function getPaginatedTasks($request)
    {
        $perPage = $request->get('per_page', 10);
        $page = $request->get('page', 1);
        $filters = [
            'status' => $request->get('status'),
            'priority' => $request->get('priority')
        ];
        
        return $this->all($perPage, $page, $filters);
    }

    public function create(array $data): Task
    {
        if (\Carbon\Carbon::parse($data['due_date'])->lt(today())) {
            throw new Exception('Due date cannot be in the past');
        }

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