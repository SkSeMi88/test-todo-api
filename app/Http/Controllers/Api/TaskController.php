<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Task;

use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     * GET /api/tasks - Получить все задачи
     */
    public function index()
    {
        //
        $tasks = Task::all();
        // var_dump($tasks);
        return response()->json([
            'success'   => true,
            'data'      => $tasks
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * POST /api/tasks - Создать задачу
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'title'         => 'required|string|max:255',
            'description'   => 'nullable|string',
            'status'        => 'nullable|in:pending,in_progress,completed,canceled'
        ]);
        

        if ($validator->fails()) {
            return response()->json([
                'success'   => false,
                'errors'    => $validator->errors()
            ], 422);
        }

        // Валидация только для title, description, status
        $validator = Validator::make($request->all(), [
            'title'             => 'required|string|max:255',
            'description'       => 'nullable|string',
            'status'            => 'nullable|in:pending,in_progress,completed,canceled',
        ], [
            'title.required'    => 'Название задачи обязательно для заполнения',
            'title.max'         => 'Название не должно превышать 255 символов',
            'status.in'         => 'Статус должен быть одним из: pending, in_progress, completed, canceled',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success'   => false,
                'errors'    => $validator->errors(),
                'message'   => 'Ошибка валидации'
            ], 422);
        }

        // Создаем задачу с тремя полями
        // По умолчанию "pending"
        $task = Task::create([
            'title'         => $request->title,
            'description'   => $request->description,
            'status'        => $request->status ?? 'pending', 
        ]);

        // Возвращаем JSON ответ с созданной задачей
        return response()->json([
            'success'       => true,
            'message'       => _('Task created successfully'),
            'data'          => $task,
        ], 201);
    }

    /**
     * Display the specified resource.
     * GET /api/v1/tasks/{id} - Получить задачу по ID
     */
    public function show(string $id)
    {
        $task = Task::find($id);
        // var_dump($task);
        if (!$task) {
            return response()->json([
                'success'   => false,
                'message'   => 'Задача не найдена'
            ], 404);
        }

        return response()->json([
            'success'       => true,
            'data'          => $task->toApiArray()
        ]);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $task = Task::find($id);

        if (!$task) {
            return response()->json([
                'success'   => false,
                'message'   => 'Задача не найдена'
            ], 404);
        }

        // Валидация только для трех полей
        $validator = Validator::make($request->all(), [
            'title'         => 'sometimes|required|string|max:255',
            'description'   => 'nullable|string',
            'status'        => 'sometimes|required|in:pending,in_progress,completed,canceled',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success'   => false,
                'errors'    => $validator->errors(),
                'message'   => 'Ошибка валидации'
            ], 422);
        }

        // Обновляем только title, description, status
        $task->update($request->only(['title', 'description', 'status']));

        return response()->json([
            'success'       => true,
            'data'          => $task,
            'message'       => 'Задача успешно обновлена'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
