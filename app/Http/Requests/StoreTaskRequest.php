<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Models\Task;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    /**
     * Получение всех задач
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(Task::all(), Response::HTTP_OK);
    }

    /**
     * Создание новой задачи
     *
     * @param  \App\Http\Requests\StoreTaskRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreTaskRequest $request)
    {
        $task = Task::create($request->validated());
        return response()->json($task, Response::HTTP_CREATED);
    }

    /**
     * Получение одной задачи
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Task $task)
    {
        return response()->json($task, Response::HTTP_OK);
    }

    /**
     * Обновление задачи
     *
     * @param  \App\Http\Requests\StoreTaskRequest  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(StoreTaskRequest $request, Task $task)
    {
        $task->update($request->validated());
        return response()->json($task, Response::HTTP_OK);
    }

    /**
     * Удаление задачи
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}