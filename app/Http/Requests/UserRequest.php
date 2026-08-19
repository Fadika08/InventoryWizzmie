<?php

namespace App\Http\Requests;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')
                    ->ignore($this->route('user')),
            ],

            'role_id' => [
                'required',
                'exists:roles,id',
            ],

            'department_id' => [
                'nullable',
                'exists:departments,id',

                Rule::requiredIf(function () {

                    return Role::where(
                        'id',
                        $this->input('role_id')
                    )
                    ->where(
                        'name',
                        'ho_admin'
                    )
                    ->exists();

                }),
            ],

            'outlet_id' => [
                'nullable',
                'exists:outlets,id',

                Rule::requiredIf(function () {

                    return Role::where(
                        'id',
                        $this->input('role_id')
                    )
                    ->where(
                        'name',
                        'outlet_admin'
                    )
                    ->exists();

                }),
            ],

            'phone' => [
                'nullable',
                'string',
                'max:30',
            ],

            'profile_photo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'password' => [
                $this->isMethod('POST')
                    ? 'required'
                    : 'nullable',

                'string',
                'min:8',
                'confirmed',
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],
        ];
    }
}