@extends('layouts.app')

@section('title', 'Pengajuan Barang')

@section('content')



        <div>

            <h2 class="text-xl font-semibold text-slate-800">
                Edit Pengajuan Barang
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                {{ $inventoryRequest->request_number }}
            </p>

        </div>




    <div class="py-8">

        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">


            {{-- BACK --}}

            <div class="mb-6">

                <a
                    href="{{ route('inventory-requests.show', $inventoryRequest) }}"
                    class="inline-flex items-center gap-2 text-sm font-semibold text-[#8F348E] hover:underline">

                    ← Kembali ke Detail

                </a>

            </div>


            {{-- ERROR --}}

            @if($errors->any())

                <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-5">

                    <p class="font-semibold text-red-700">
                        Terdapat kesalahan:
                    </p>

                    <ul class="mt-2 list-disc pl-5 text-sm text-red-600">

                        @foreach($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            <form
                method="POST"
                action="{{ route('inventory-requests.update', $inventoryRequest) }}">

                @csrf

                @method('PUT')


                {{-- ================================================= --}}
                {{-- INFORMASI PENGAJUAN --}}
                {{-- ================================================= --}}

                <div class="mb-6 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                    <div class="border-b border-slate-100 px-6 py-5">

                        <h3 class="text-lg font-bold text-slate-900">
                            Informasi Pengajuan
                        </h3>

                    </div>


                    <div class="space-y-6 p-6">


                        {{-- NOMOR --}}

                        <div class="rounded-xl bg-slate-50 p-4">

                            <p class="text-xs font-semibold uppercase text-slate-400">
                                Nomor Pengajuan
                            </p>

                            <p class="mt-1 font-bold text-[#8F348E]">
                                {{ $inventoryRequest->request_number }}
                            </p>

                        </div>


                        {{-- JENIS --}}

                        <div>

                            <label
                                for="request_type"
                                class="mb-2 block text-sm font-semibold text-slate-700">

                                Jenis Pengajuan
                                <span class="text-red-500">*</span>

                            </label>


                            <select
                                id="request_type"
                                name="request_type"
                                required
                                class="w-full rounded-xl border-slate-200 px-4 py-3 text-sm focus:border-[#8F348E] focus:ring-[#8F348E]">

                                <option value="">
                                    Pilih Jenis
                                </option>

                                <option
                                    value="new"
                                    @selected(
                                        old(
                                            'request_type',
                                            $inventoryRequest->request_type
                                        ) === 'new'
                                    )>

                                    Barang Baru

                                </option>

                                <option
                                    value="replacement"
                                    @selected(
                                        old(
                                            'request_type',
                                            $inventoryRequest->request_type
                                        ) === 'replacement'
                                    )>

                                    Penggantian Barang

                                </option>

                                <option
                                    value="additional"
                                    @selected(
                                        old(
                                            'request_type',
                                            $inventoryRequest->request_type
                                        ) === 'additional'
                                    )>

                                    Penambahan Barang

                                </option>

                            </select>

                        </div>


                        {{-- ALASAN --}}

                        <div>

                            <label
                                for="reason"
                                class="mb-2 block text-sm font-semibold text-slate-700">

                                Alasan Pengajuan
                                <span class="text-red-500">*</span>

                            </label>


                            <textarea
                                id="reason"
                                name="reason"
                                rows="4"
                                required
                                class="w-full rounded-xl border-slate-200 px-4 py-3 text-sm focus:border-[#8F348E] focus:ring-[#8F348E]">{{ old('reason', $inventoryRequest->reason) }}</textarea>

                        </div>


                        {{-- CATATAN --}}

                        <div>

                            <label
                                for="notes"
                                class="mb-2 block text-sm font-semibold text-slate-700">

                                Catatan

                            </label>


                            <textarea
                                id="notes"
                                name="notes"
                                rows="3"
                                class="w-full rounded-xl border-slate-200 px-4 py-3 text-sm focus:border-[#8F348E] focus:ring-[#8F348E]">{{ old('notes', $inventoryRequest->notes) }}</textarea>

                        </div>

                    </div>

                </div>


                {{-- ================================================= --}}
                {{-- BARANG --}}
                {{-- ================================================= --}}

                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                    <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5">

                        <div>

                            <h3 class="text-lg font-bold text-slate-900">
                                Daftar Barang
                            </h3>

                            <p class="mt-1 text-sm text-slate-500">
                                Ubah daftar barang yang diajukan.
                            </p>

                        </div>


                        <button
                            type="button"
                            id="btnTambahItem"
                            class="rounded-xl bg-[#8F348E] px-4 py-2.5 text-sm font-semibold text-white hover:bg-[#752C74]">

                            + Tambah Barang

                        </button>

                    </div>


                    <div
                        id="itemsContainer"
                        class="space-y-5 p-6">


                        @php

                            $items = old(
                                'items',
                                $inventoryRequest->items
                                    ->map(
                                        function ($item) {

                                            return [

                                                'category_id' =>
                                                    $item->category_id,

                                                'item_name' =>
                                                    $item->item_name,

                                                'specification' =>
                                                    $item->specification,

                                                'quantity' =>
                                                    $item->quantity,

                                                'notes' =>
                                                    $item->notes,

                                            ];

                                        }
                                    )
                                    ->toArray()
                            );

                        @endphp


                        @foreach($items as $index => $item)

                            <div
                                class="request-item rounded-2xl border border-slate-200 bg-slate-50 p-5">

                                <div class="mb-5 flex items-center justify-between">

                                    <div class="flex items-center gap-3">

                                        <div class="item-number flex h-9 w-9 items-center justify-center rounded-lg bg-[#8F348E] text-sm font-bold text-white">

                                            {{ $index + 1 }}

                                        </div>


                                        <h4 class="font-bold text-slate-800">
                                            Barang #{{ $index + 1 }}
                                        </h4>

                                    </div>


                                    <button
                                        type="button"
                                        class="btnHapusItem rounded-lg px-3 py-2 text-sm font-semibold text-red-600 hover:bg-red-50">

                                        Hapus

                                    </button>

                                </div>


                                <div class="grid gap-5 md:grid-cols-2">


                                    {{-- KATEGORI --}}

                                    <div>

                                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                                            Kategori
                                        </label>


                                        <select
                                            name="items[{{ $index }}][category_id]"
                                            class="w-full rounded-xl border-slate-200 bg-white px-4 py-3 text-sm">

                                            <option value="">
                                                Pilih Kategori
                                            </option>

                                            @foreach($categories as $category)

                                                <option
                                                    value="{{ $category->id }}"
                                                    @selected(
                                                        ($item['category_id'] ?? '') == $category->id
                                                    )>

                                                    {{ $category->code }}
                                                    -
                                                    {{ $category->name }}

                                                </option>

                                            @endforeach

                                        </select>

                                    </div>


                                    {{-- NAMA --}}

                                    <div>

                                        <label class="mb-2 block text-sm font-semibold text-slate-700">

                                            Nama Barang
                                            <span class="text-red-500">*</span>

                                        </label>


                                        <input
                                            type="text"
                                            name="items[{{ $index }}][item_name]"
                                            value="{{ $item['item_name'] ?? '' }}"
                                            required
                                            class="w-full rounded-xl border-slate-200 bg-white px-4 py-3 text-sm">

                                    </div>


                                    {{-- SPESIFIKASI --}}

                                    <div class="md:col-span-2">

                                        <label class="mb-2 block text-sm font-semibold text-slate-700">

                                            Spesifikasi

                                        </label>


                                        <textarea
                                            name="items[{{ $index }}][specification]"
                                            rows="3"
                                            class="w-full rounded-xl border-slate-200 bg-white px-4 py-3 text-sm">{{ $item['specification'] ?? '' }}</textarea>

                                    </div>


                                    {{-- JUMLAH --}}

                                    <div>

                                        <label class="mb-2 block text-sm font-semibold text-slate-700">

                                            Jumlah
                                            <span class="text-red-500">*</span>

                                        </label>


                                        <input
                                            type="number"
                                            name="items[{{ $index }}][quantity]"
                                            value="{{ $item['quantity'] ?? 1 }}"
                                            min="1"
                                            required
                                            class="w-full rounded-xl border-slate-200 bg-white px-4 py-3 text-sm">

                                    </div>


                                    {{-- CATATAN --}}

                                    <div>

                                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                                            Catatan
                                        </label>


                                        <input
                                            type="text"
                                            name="items[{{ $index }}][notes]"
                                            value="{{ $item['notes'] ?? '' }}"
                                            class="w-full rounded-xl border-slate-200 bg-white px-4 py-3 text-sm">

                                    </div>

                                </div>

                            </div>

                        @endforeach

                    </div>


                    {{-- FOOTER --}}

                    <div class="flex flex-col gap-3 border-t border-slate-100 bg-slate-50 px-6 py-5 sm:flex-row sm:justify-end">

                        <a
                            href="{{ route('inventory-requests.show', $inventoryRequest) }}"
                            class="rounded-xl border border-slate-200 bg-white px-5 py-3 text-center text-sm font-semibold text-slate-700">

                            Batal

                        </a>


                        <button
                            type="submit"
                            class="rounded-xl bg-[#8F348E] px-6 py-3 text-sm font-semibold text-white hover:bg-[#752C74]">

                            Simpan Perubahan

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- ============================================================= --}}
    {{-- TEMPLATE ITEM --}}
    {{-- ============================================================= --}}

    <template id="itemTemplate">

        <div class="request-item rounded-2xl border border-slate-200 bg-slate-50 p-5">

            <div class="mb-5 flex items-center justify-between">

                <div class="flex items-center gap-3">

                    <div class="item-number flex h-9 w-9 items-center justify-center rounded-lg bg-[#8F348E] text-sm font-bold text-white">
                        1
                    </div>

                    <h4 class="font-bold text-slate-800">
                        Barang #1
                    </h4>

                </div>


                <button
                    type="button"
                    class="btnHapusItem rounded-lg px-3 py-2 text-sm font-semibold text-red-600 hover:bg-red-50">

                    Hapus

                </button>

            </div>


            <div class="grid gap-5 md:grid-cols-2">

                <div>

                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Kategori
                    </label>

                    <select
                        name="items[__INDEX__][category_id]"
                        class="w-full rounded-xl border-slate-200 bg-white px-4 py-3 text-sm">

                        <option value="">
                            Pilih Kategori
                        </option>

                        @foreach($categories as $category)

                            <option value="{{ $category->id }}">

                                {{ $category->code }}
                                -
                                {{ $category->name }}

                            </option>

                        @endforeach

                    </select>

                </div>


                <div>

                    <label class="mb-2 block text-sm font-semibold text-slate-700">

                        Nama Barang
                        <span class="text-red-500">*</span>

                    </label>

                    <input
                        type="text"
                        name="items[__INDEX__][item_name]"
                        required
                        class="w-full rounded-xl border-slate-200 bg-white px-4 py-3 text-sm">

                </div>


                <div class="md:col-span-2">

                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Spesifikasi
                    </label>

                    <textarea
                        name="items[__INDEX__][specification]"
                        rows="3"
                        class="w-full rounded-xl border-slate-200 bg-white px-4 py-3 text-sm"></textarea>

                </div>


                <div>

                    <label class="mb-2 block text-sm font-semibold text-slate-700">

                        Jumlah
                        <span class="text-red-500">*</span>

                    </label>

                    <input
                        type="number"
                        name="items[__INDEX__][quantity]"
                        value="1"
                        min="1"
                        required
                        class="w-full rounded-xl border-slate-200 bg-white px-4 py-3 text-sm">

                </div>


                <div>

                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Catatan
                    </label>

                    <input
                        type="text"
                        name="items[__INDEX__][notes]"
                        class="w-full rounded-xl border-slate-200 bg-white px-4 py-3 text-sm">

                </div>

            </div>

        </div>

    </template>


    <script>

        document.addEventListener(
            'DOMContentLoaded',
            function () {

                const container =
                    document.getElementById(
                        'itemsContainer'
                    );

                const template =
                    document.getElementById(
                        'itemTemplate'
                    );

                const addButton =
                    document.getElementById(
                        'btnTambahItem'
                    );


                let nextIndex =
                    container.querySelectorAll(
                        '.request-item'
                    ).length;


                function updateNumbers() {

                    const items =
                        container.querySelectorAll(
                            '.request-item'
                        );


                    items.forEach(
                        function (item, index) {

                            const number =
                                item.querySelector(
                                    '.item-number'
                                );

                            const title =
                                item.querySelector(
                                    'h4'
                                );

                            const deleteButton =
                                item.querySelector(
                                    '.btnHapusItem'
                                );


                            if (number) {

                                number.textContent =
                                    index + 1;

                            }


                            if (title) {

                                title.textContent =
                                    'Barang #' +
                                    (index + 1);

                            }


                            if (
                                items.length === 1
                            ) {

                                deleteButton.classList.add(
                                    'hidden'
                                );

                            } else {

                                deleteButton.classList.remove(
                                    'hidden'
                                );

                            }

                        }
                    );

                }


                addButton.addEventListener(
                    'click',
                    function () {

                        const html =
                            template.innerHTML.replaceAll(
                                '__INDEX__',
                                nextIndex
                            );


                        container.insertAdjacentHTML(
                            'beforeend',
                            html
                        );


                        nextIndex++;

                        updateNumbers();

                    }
                );


                container.addEventListener(
                    'click',
                    function (event) {

                        const button =
                            event.target.closest(
                                '.btnHapusItem'
                            );


                        if (!button) {
                            return;
                        }


                        const item =
                            button.closest(
                                '.request-item'
                            );


                        if (item) {

                            item.remove();

                            updateNumbers();

                        }

                    }
                );


                updateNumbers();

            }
        );

    </script>

@endsection
