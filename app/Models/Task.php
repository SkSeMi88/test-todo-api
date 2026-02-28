<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

        
    protected $fillable = ['title', 'description', 'status'];
    
    // // Правила валидации
    // public static $rules = [
    //     'title'         => 'required|string|max:255',
    //     'description'   => 'nullable|string',
    //     'status'        => 'in:pending, in_progress, completed, canceled'
    // ];
    
    // // Сообщения об ошибках
    // public static $messages = [
    //     'title.required'    => 'Название задачи обязательно',
    //     'title.max'         => 'Название не должно превышать 255 символов',
    //     'status.in'         => 'Статус должен быть: pending, in_progress, completed, canceled'
    // ];
    
    // // Метод для валидации
    // public static function validate($data)
    // {
    //     $validator = Validator::make($data, self::$rules, self::$messages);
        
    //     if ($validator->fails()) {
    //         throw new ValidationException($validator);
    //     }
        
    //     return $validator->validated();
    // }

    // public function toApiArray(): array
    // {
    //     return [
    //         'id' => $this->id,
    //         'title' => $this->title,
    //         'description' => $this->description,
    //         'status' => $this->status,
    //         // 'priority' => $this->priority,
    //         // 'due_date' => $this->due_date ? $this->due_date->format('Y-m-d H:i:s') : null,
    //         'created_at' => $this->created_at->format('Y-m-d H:i:s'),
    //         'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
    //     ];
    // }
}
