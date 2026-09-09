<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWebsiteSettingFieldRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() && ($this->user()->hasRole('superadmin') || $this->user()->can('website-setting-create'));
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('key')) {
            $this->merge([
                'key' => strtolower(trim(preg_replace('/[^A-Za-z0-9_]+/', '_', $this->input('key')), '_')),
            ]);
        }

        if ($this->has('group')) {
            $this->merge([
                'group' => strtolower(trim(preg_replace('/[^A-Za-z0-9_-]+/', '_', $this->input('group')), '_')),
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'key' => ['required', 'string', 'max:100', 'regex:/^[a-z0-9_]+$/', 'unique:website_settings,key'],
            'label' => ['required', 'string', 'max:150'],
            'type' => ['required', 'string', 'in:text,textarea,email,url,phone,image,number'],
            'group' => ['required', 'string', 'max:80', 'regex:/^[a-z0-9_-]+$/'],
            'placeholder' => ['nullable', 'string', 'max:200'],
            'value' => ['nullable', 'string', 'max:5000'],
            'col_class' => ['nullable', 'string', 'in:col-12,col-md-6 col-12,col-md-4 col-12,col-md-8 col-12,col-md-3 col-12'],
        ];
    }

    /**
     * Custom error messages.
     */
    public function messages(): array
    {
        return [
            'key.regex' => 'The setting key must only contain lowercase letters, numbers, and underscores.',
            'key.unique' => 'A setting with this key already exists.',
            'group.regex' => 'The group name must only contain lowercase letters, numbers, and underscores.',
        ];
    }
}
