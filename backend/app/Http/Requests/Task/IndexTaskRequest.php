<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

use App\Enums\Task\TaskStatus;
use App\Enums\Task\TaskPriority;

use Illuminate\Validation\Rule;

class IndexTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'status' => ['nullable', 'string', Rule::in(array_column(TaskStatus::cases(), 'value'))],
            'priority' => ['nullable', 'string', Rule::in(array_column(TaskPriority::cases(), 'value'))]
        ];
    }
}
