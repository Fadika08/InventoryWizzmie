<?php

namespace App\Http\Requests;

use App\Models\InventoryItem;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InventoryItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        $inventory = $this->route('inventory');

        if (!$inventory instanceof InventoryItem) {
            $inventory = $this->route('inventory_item');
        }

        return [

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'category_id' => [
                'required',
                'exists:categories,id',
            ],

            'brand' => [
                'nullable',
                'string',
                'max:100',
            ],

            'model' => [
                'nullable',
                'string',
                'max:150',
            ],

            'serial_number' => [
                'nullable',
                'string',
                'max:150',
                Rule::unique(
                    'inventory_items',
                    'serial_number'
                )->ignore($inventory?->id),
            ],

            'specification' => [
                'nullable',
                'string',
            ],

            'location_type' => [
                'required',
                Rule::in([
                    'head_office',
                    'outlet',
                ]),
            ],

            'department_id' => [
                'nullable',
                'exists:departments,id',
            ],

            'room_id' => [
                'nullable',
                'exists:rooms,id',
            ],

            'outlet_id' => [
                'nullable',
                'exists:outlets,id',
            ],

            'condition_status' => [
                'required',
                Rule::in([
                    'good',
                    'minor_damage',
                    'damaged',
                    'lost',
                ]),
            ],

            'status' => [
                'required',
                Rule::in([
                    'active',
                    'maintenance',
                    'borrowed',
                    'lost',
                    'disposed',
                ]),
            ],

            'purchase_date' => [
                'nullable',
                'date',
            ],

            'purchase_price' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'warranty_start' => [
                'nullable',
                'date',
            ],

            'warranty_end' => [
                'nullable',
                'date',
                'after_or_equal:warranty_start',
            ],

            'description' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'primary_photo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {

            $user = auth()->user();

            /*
            |--------------------------------------------------------------------------
            | Outlet Admin
            |--------------------------------------------------------------------------
            */

            if ($user->isOutletAdmin()) {

                if ($this->location_type !== 'outlet') {
                    $validator->errors()->add(
                        'location_type',
                        'Outlet Admin hanya dapat mengelola inventaris outlet.'
                    );
                }

                if (
                    (int) $this->outlet_id !==
                    (int) $user->outlet_id
                ) {
                    $validator->errors()->add(
                        'outlet_id',
                        'Anda hanya dapat mengelola outlet Anda sendiri.'
                    );
                }
            }


            /*
            |--------------------------------------------------------------------------
            | Head Office
            |--------------------------------------------------------------------------
            */

            if ($this->location_type === 'head_office') {

                if (!$this->department_id) {
                    $validator->errors()->add(
                        'department_id',
                        'Divisi wajib dipilih.'
                    );
                }

                if (!$this->room_id) {
                    $validator->errors()->add(
                        'room_id',
                        'Ruangan wajib dipilih.'
                    );
                }

                if ($this->outlet_id) {
                    $validator->errors()->add(
                        'outlet_id',
                        'Inventaris Head Office tidak boleh memiliki outlet.'
                    );
                }

                if ($this->room_id && $this->department_id) {

                    $roomBelongsToDepartment =
                        \App\Models\Room::query()
                            ->whereKey($this->room_id)
                            ->where(
                                'department_id',
                                $this->department_id
                            )
                            ->exists();

                    if (!$roomBelongsToDepartment) {
                        $validator->errors()->add(
                            'room_id',
                            'Ruangan tidak sesuai dengan divisi yang dipilih.'
                        );
                    }
                }
            }


            /*
            |--------------------------------------------------------------------------
            | Outlet
            |--------------------------------------------------------------------------
            */

            if ($this->location_type === 'outlet') {

                if (!$this->outlet_id) {
                    $validator->errors()->add(
                        'outlet_id',
                        'Outlet wajib dipilih.'
                    );
                }

                if ($this->department_id) {
                    $validator->errors()->add(
                        'department_id',
                        'Inventaris outlet tidak boleh memiliki divisi Head Office.'
                    );
                }

                if ($this->room_id) {
                    $validator->errors()->add(
                        'room_id',
                        'Inventaris outlet tidak boleh memiliki ruangan Head Office.'
                    );
                }
            }
        });
    }
}