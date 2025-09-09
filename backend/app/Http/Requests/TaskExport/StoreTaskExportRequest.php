<?php

namespace App\Http\Requests\TaskExport;

use Illuminate\Foundation\Http\FormRequest;

use App\Enums\Task\TaskStatus;
use App\Enums\Task\TaskPriority;

use Illuminate\Validation\Rule;

class StoreTaskExportRequest extends FormRequest
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
            'filters' => ['nullable', 'array'],
            'filters.status' => ['nullable', 'string', Rule::in(array_column(TaskStatus::cases(), 'value'))],
            'filters.priority' => ['nullable', 'string', Rule::in(array_column(TaskPriority::cases(), 'value'))],
        ];
    }
}
