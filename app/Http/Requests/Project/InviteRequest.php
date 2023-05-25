<?php

namespace App\Http\Requests\Project;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class InviteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('update', $this->project());
    }

    private function project()
    {
        return $this->route('project');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'id' => 'exists:users,id',
        ];
    }

    public function persist()
    {
        return tap($this->project())->invite($this->validated('id'));
    }
}
