<?php

namespace App\Http\Requests;

use App\Enums\MilestoneStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProjectMilestoneRequest extends FormRequest
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
        $milestoneId = $this->route('milestone') instanceof \App\Models\ProjectMilestone
            ? $this->route('milestone')->id
            : $this->route('milestone');

        return [
            'project_id' => ['required', 'exists:projects,id'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('project_milestones', 'slug')->ignore($milestoneId)],
            'description' => ['nullable', 'string'],
            'target_date' => ['required', 'date'],
            'completion_date' => ['nullable', 'date'],
            'status' => ['required', Rule::enum(MilestoneStatus::class)],
            'progress_percentage' => ['nullable', 'integer', 'min:0', 'max:100'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_published' => ['nullable', 'boolean'],
            'image' => ['nullable', 'file', 'mimes:jpeg,jpg,png,webp', 'max:10240'],
        ];
    }
}
