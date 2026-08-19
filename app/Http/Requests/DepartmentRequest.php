<?php

namespace App\Http\Requests;

use App\Models\Department;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DepartmentRequest extends FormRequest
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
        $departmentId = $this->route('department')?->id;

        return [
            'code' => [
                'required',
                'string',
                'max:50',
                'alpha_dash',
                Rule::unique('departments', 'code')
                    ->ignore($departmentId),
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
            'code' => 'kode divisi',
            'name' => 'nama divisi',
            'description' => 'deskripsi',
            'is_active' => 'status',
        ];
    }
}