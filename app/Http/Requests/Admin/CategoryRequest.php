<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->is_admin === true; // admin-only
    }

    public function rules(): array
    {
        $id = $this->route('category')?->id ?? null;

        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('categories', 'slug')->ignore($id),
            ],
            'description' => ['nullable', 'string'],
        ];
    }

    public function prepareForValidation(): void
    {
        // Auto-generate slug from name if not provided
        if (! $this->filled('slug') && $this->filled('name')) {
            $this->merge(['slug' => Str::slug((string) $this->input('name'))]);
        }
    }
}
