<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check()
            && (
                auth()->user()->isSuperAdmin()
                || auth()->user()->isHoAdmin()
            );
    }

    public function rules(): array
    {
        $category = $this->route('category');

        return [
            'code' => [
                'required',
                'string',
                'max:50',
                'alpha_dash',
                Rule::unique(
                    'categories',
                    'code'
                )->ignore($category?->id),
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'code' => 'kode kategori',
            'name' => 'nama kategori',
            'description' => 'deskripsi',
            'is_active' => 'status',
        ];
    }
}