<?php

namespace App\Http\Requests\Project\Task;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class CreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('update', $this->project());
    }

    private function project()
    {
        return $this->route('project');
    }

    public function rules(): array
    {
        return [
            'body' => 'string|required',
        ];
    }

    public function persist()
    {
        return tap($this->project())->addTask($this->validated());
    }
}
