<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogCategoryStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // adjust with policies if needed
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:blog_categories,name',
            'slug' => 'required|string|max:255|unique:blog_categories,slug',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_active' => 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Category name is required.',
            'name.unique' => 'This category name already exists.',
            'slug.required' => 'Slug is required.',
            'slug.unique' => 'This slug already exists.',
            'image.image' => 'File must be an image.',
            'image.max' => 'Image cannot exceed 2MB.',
            'is_active.required' => 'Status is required.',
        ];
    }
}
