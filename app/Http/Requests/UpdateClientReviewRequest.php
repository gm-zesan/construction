<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClientReviewRequest extends FormRequest
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
            'client_name' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'review' => 'required|string|max:5000',
            'rating' => 'required|integer|min:1|max:5',
            'project_id' => 'nullable|exists:projects,id',
            'featured' => 'nullable|boolean',
            'is_published' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
            'client_photo' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
        ];
    }

    /**
     * Custom attribute names for validation errors.
     */
    public function attributes(): array
    {
        return [
            'client_name' => 'client name',
            'designation' => 'designation',
            'company_name' => 'company name',
            'review' => 'testimonial content',
            'rating' => 'star rating',
            'project_id' => 'related project',
            'client_photo' => 'client photo',
        ];
    }
}
