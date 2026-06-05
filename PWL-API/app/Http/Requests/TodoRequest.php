<?php

namespace App\Http\Requests;

class TodoRequest extends ApiRequest
{
    public function authorize(): bool
    {
        if ($this->method() == 'POST') {
            return true;
        }

        $todo = $this->route('todo');
        return $todo && $this->user()->id == $todo->user_id;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'done' => 'nullable|boolean',
        ];
    }
}
