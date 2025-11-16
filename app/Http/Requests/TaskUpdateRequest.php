<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskUpdateRequest extends FormRequest
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
    public function rules(): array{
        return [
            'task_name' => 'required|string|min:3|max:5|regex:/^[a-zA-Z\s]+$/',
            'description' => 'required|string|min:10|max:2000',
        ];
    }


    public function messages()
    {
        return [
        'task_name.regex' => 'Task name must contain only letters and spaces',
        'task_name.required' => 'Task name is required',
        'description.required' => 'Description is required',
        ];
    }
}
