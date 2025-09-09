<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskExportController;

Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('me', [AuthController::class, 'me']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);

    Route::apiResource('tasks', TaskController::class);
    Route::patch('tasks/{id}/complete', [TaskController::class, 'complete']);

    Route::post('task-exports', [TaskExportController::class, 'store']);
    Route::get('task-exports', [TaskExportController::class, 'index']);
    Route::get('task-exports/{id}/download', [TaskExportController::class, 'download']);
});