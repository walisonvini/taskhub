<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

use App\Enums\Task\TaskPriority;
use App\Enums\Task\TaskStatus;

use Illuminate\Validation\Rule;

class UpdateTaskRequest extends FormRequest
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
            'title' => ['sometimes', 'string', 'max:255'],
            'description' => ['sometimes', 'nullable', 'string'],
            'priority' => ['sometimes', Rule::in(array_column(TaskPriority::cases(), 'value'))],
            'status' => ['sometimes', Rule::in(array_column(TaskStatus::cases(), 'value'))],
            'due_date' => ['sometimes', 'date'],
        ];
    }

    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new \Illuminate\Http\Exceptions\HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Os dados fornecidos são inválidos.',
                'errors' => $validator->errors(),
            ], 422)
        );
    }
}
