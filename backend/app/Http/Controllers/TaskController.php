<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Requests\Task\IndexTaskRequest;

use App\Traits\ApiResponse;

use App\Http\Resources\Task\TaskResource;
use App\Http\Resources\Task\TaskPaginatedResource;

use App\Services\TaskService;

use Exception;

class TaskController extends Controller
{
    use ApiResponse;

    public function __construct(
        private TaskService $taskService
    ){}

    public function index(IndexTaskRequest $request)
    {
        try {
            $tasks = $this->taskService->getPaginatedTasks($request);

            return $this->successResponse(
                new TaskPaginatedResource($tasks), 
                'Tasks retrieved successfully'
            );
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 404);
        }
    }

    public function store(StoreTaskRequest $request): JsonResponse
    {
        try {
            $task = $this->taskService->create($request->validated());

            return $this->successResponse([ 'task' => new TaskResource($task)], 'Task created successfully');
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 404);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $task = $this->taskService->find($id);

            return $this->successResponse([ 'task' => new TaskResource($task)], 'Task retrieved successfully');
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 404);
        }
    }

    public function update(UpdateTaskRequest $request, $id): JsonResponse
    {
        try {
            $task = $this->taskService->update($this->taskService->find($id), $request->validated());

            return $this->successResponse([ 'task' => new TaskResource($task)], 'Task updated successfully');
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 404);
        }
    }

    public function destroy($id)
    {
        try {
            $this->taskService->delete($this->taskService->find($id));

            return $this->successResponse(null, 'Task deleted successfully');
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 404);
        }
    }
}
