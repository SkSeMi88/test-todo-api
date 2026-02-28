<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */

    public function authorize()
    {
        return true; // разрешаем всем
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'title'         => 'required|string|max:255',
            'description'   => 'nullable|string',
            'status'        => 'sometimes|in:pending,in_progress,completed,canceled', // если поле пришло, проверка значения
        ];
    }
}

