<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContentManagementRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() && (
            $this->user()->hasRole('superadmin') ||
            $this->user()->can('website-content-edit')
        );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'active_page' => ['required', 'string', 'max:60', 'regex:/^[a-zA-Z0-9_\-]+$/'],
            'content' => ['nullable', 'array'],
            'content.*' => ['nullable', 'array'],
            'media_files' => ['nullable', 'array'],
            'media_files.*.*' => ['nullable', 'file', 'mimes:jpeg,jpg,png,webp,svg,ico,pdf', 'max:15360'],
            'remove_media' => ['nullable', 'array'],
        ];
    }
}
