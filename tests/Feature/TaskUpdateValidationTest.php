<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskUpdateValidationTest extends TestCase
{
    use RefreshDatabase; // чтобы база очищалась перед каждым тестом

    /**
     * Тест обновления задачи с пустым заголовком.
     */
    public function test_update_task_fails_when_title_is_empty()
    {
        // Создаём задачу в базе
        $task = Task::factory()->create();

        // Данные для обновления: пустой title
        $data = [
            'title' => '',
            'description' => 'Обновлённое описание',
            'status' => 'completed'
        ];

        // Отправляем PUT-запрос
        $response = $this->putJson("/api/tasks/{$task->id}", $data);

        // Проверяем статус 422 (Unprocessable Entity)
        $response->assertStatus(422);

        // Проверяем структуру ошибки (Laravel по умолчанию возвращает поле errors)
        $response->assertJsonValidationErrors(['title']);

        // Можно также проверить конкретное сообщение (зависит от локализации)
        $response->assertJsonFragment([
            'title' => ['Поле title обязательно для заполнения.']
        ]);

        // Убедимся, что задача не изменилась в базе
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => $task->title // старое значение
        ]);
    }

    /**
     * Тест обновления задачи с недопустимым статусом.
     */
    public function test_update_task_fails_with_invalid_status()
    {
        $task = Task::factory()->create();

        $data = [
            'title' => 'Новый заголовок',
            'status' => 'invalid_status' // не в списке разрешённых
        ];

        $response = $this->putJson("/api/tasks/{$task->id}", $data);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['status']);

        // Проверяем, что статус в базе не изменился
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'status' => $task->status
        ]);
    }

    /**
     * Тест обновления задачи со слишком длинным заголовком.
     */
    public function test_update_task_fails_when_title_is_too_long()
    {
        $task = Task::factory()->create();

        $data = [
            'title' => str_repeat('a', 256), // больше 255 символов
            'status' => 'pending'
        ];

        $response = $this->putJson("/api/tasks/{$task->id}", $data);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['title']);
    }

    /**
     * Тест обновления несуществующей задачи (должен вернуть 404).
     */
    public function test_update_non_existent_task_returns_404()
    {
        $data = [
            'title' => 'Заголовок',
            'status' => 'pending'
        ];

        $response = $this->putJson('/api/tasks/99999', $data);

        $response->assertStatus(404);

        // Если кастомизировали обработку ошибок, можно проверить структуру
        $response->assertJson([
            'message' => 'Задача не найдена'
        ]);
    }
}