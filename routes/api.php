<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Версия API v1
Route::prefix('v1')->group(function () {
    // Полный CRUD для задач
    Route::apiResource('tasks', TaskController::class);
    
    // Если нужны дополнительные методы вне CRUD
    Route::patch('/tasks/{task}/complete', [TaskController::class, 'complete'])
        ->name('tasks.complete');
    
    Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])
        ->name('tasks.status');
});