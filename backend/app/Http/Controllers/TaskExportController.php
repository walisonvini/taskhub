<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Requests\TaskExport\StoreTaskExportRequest;

use App\Traits\ApiResponse;

use App\Services\TaskExportService;

use Symfony\Component\HttpFoundation\StreamedResponse;

use Exception;

class TaskExportController extends Controller
{
    use ApiResponse;

    public function __construct(
        private TaskExportService $taskExportService
    ){}

    public function index(): JsonResponse
    {
        try {
            $exports = $this->taskExportService->all();

            return $this->successResponse([ 'exports' => $exports], 'Exportações recuperadas com sucesso');
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 404);
        }
    }

    public function store(StoreTaskExportRequest $request): JsonResponse
    {
        try {
            $export = $this->taskExportService->create($request->validated());

            return $this->successResponse([ 'export' => $export], 'Exportação enviada para processamento');
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 404);
        }
    }

    public function download($id): StreamedResponse|JsonResponse
    {
        try {
            $export = $this->taskExportService->find($id);

            return $this->taskExportService->download($export);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 404);
        }
    }
}
