<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InventoryRequestFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [

            'request_type' => [
                'required',
                'in:new_item,replacement,additional,other',
            ],

            'reason' => [
                'required',
                'string',
                'max:2000',
            ],

            'notes' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'items' => [
                'required',
                'array',
                'min:1',
            ],

            'items.*.category_id' => [
                'nullable',
                'exists:categories,id',
            ],

            'items.*.item_name' => [
                'required',
                'string',
                'max:255',
            ],

            'items.*.specification' => [
                'nullable',
                'string',
                'max:2000',
            ],

            'items.*.quantity' => [
                'required',
                'integer',
                'min:1',
                'max:10000',
            ],

            'items.*.notes' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ];
    }

    public function messages(): array
    {
        return [

            'request_type.required' =>
                'Jenis pengajuan wajib dipilih.',

            'reason.required' =>
                'Alasan pengajuan wajib diisi.',

            'items.required' =>
                'Minimal satu barang harus diajukan.',

            'items.min' =>
                'Minimal satu barang harus diajukan.',

            'items.*.item_name.required' =>
                'Nama barang wajib diisi.',

            'items.*.quantity.required' =>
                'Jumlah barang wajib diisi.',

            'items.*.quantity.min' =>
                'Jumlah barang minimal 1.',
        ];
    }
}
