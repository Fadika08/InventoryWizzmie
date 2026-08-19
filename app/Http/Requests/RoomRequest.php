<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoomRequest extends FormRequest
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
        $room = $this->route('room');

        return [
            'department_id' => [
                'required',
                'exists:departments,id',
            ],

            'code' => [
                'required',
                'string',
                'max:50',

                Rule::unique('rooms', 'code')
                    ->where(function ($query) {
                        return $query->where(
                            'department_id',
                            $this->department_id
                        );
                    })
                    ->ignore($room?->id),
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'floor' => [
                'nullable',
                'string',
                'max:50',
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
            'department_id' => 'divisi',
            'code' => 'kode ruangan',
            'name' => 'nama ruangan',
            'floor' => 'lantai',
            'description' => 'deskripsi',
            'is_active' => 'status',
        ];
    }
}