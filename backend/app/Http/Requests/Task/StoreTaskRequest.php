<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use App\Enums\Task\TaskPriority;
use App\Enums\Task\TaskStatus;


class StoreTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'priority' => ['required', Rule::in(array_column(TaskPriority::cases(), 'value'))],
            'status' => ['required', Rule::in(array_column(TaskStatus::cases(), 'value'))],
            'due_date' => ['required', 'date'],
        ];
    }
}
