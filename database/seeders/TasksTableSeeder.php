<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Task;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
                // Создаем несколько общих задач
        Task::factory()->count(10)->create();

        // // Создаем задачи с конкретными статусами для демонстрации
        // Task::factory()->create([
        //     'title' => 'Изучить документацию Laravel',
        //     'description' => 'Подробно изучить документацию по Eloquent и миграциям',
        //     'status' => 'completed',
        // ]);

        // Task::factory()->create([
        //     'title' => 'Написать тесты для API',
        //     'description' => 'Создать unit и feature тесты для всех эндпоинтов',
        //     'status' => 'in_progress',
        // ]);

        // Task::factory()->create([
        //     'title' => 'Рефакторинг кода',
        //     'description' => 'Оптимизировать существующий код и улучшить архитектуру',
        //     'status' => 'pending',
        // ]);

        // Task::factory()->create([
        //     'title' => 'Отмененный проект',
        //     'description' => 'Проект был отменен по причине изменения требований',
        //     'status' => 'canceled',
        // ]);

        // Создаем задачи с использованием состояний (states)
        // Task::factory()->count(5)->pending()->create();
        // Task::factory()->count(3)->inProgress()->create();
        // Task::factory()->count(7)->completed()->create();
        // Task::factory()->count(2)->canceled()->create();

    }

}
