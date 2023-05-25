<?php

namespace App\Http\Requests\Project;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class DeleteMemberRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('manage', $this->project());
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
            'id' => 'exists:project_members,user_id',
        ];
    }

    public function remove()
    {
        return tap($this->project())->remove($this->validated('id'));
    }
}
