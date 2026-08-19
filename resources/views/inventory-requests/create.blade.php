@extends('layouts.app')

@section('title', 'Pengajuan Barang')

@section('content')



        <div class="flex items-center justify-between">

            <div>
                <h2 class="text-xl font-semibold text-slate-800">
                    Buat Pengajuan Barang
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Ajukan kebutuhan barang inventaris.
                </p>
            </div>

        </div>



    <div class="py-8">

        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">


            {{-- ========================================================= --}}
            {{-- BACK --}}
            {{-- ========================================================= --}}

            <div class="mb-6">

                <a href="{{ route('inventory-requests.index') }}"
                    class="inline-flex items-center gap-2 text-sm font-semibold text-[#8F348E] hover:underline">

                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />

                    </svg>

                    Kembali ke Pengajuan

                </a>

            </div>


            {{-- ========================================================= --}}
            {{-- ERROR --}}
            {{-- ========================================================= --}}

            @if ($errors->any())

                <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-5">

                    <div class="flex gap-3">

                        <svg class="mt-0.5 h-5 w-5 shrink-0 text-red-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M10.29 3.86l-7.82 13.5A2 2 0 004.2 20.4h15.6a2 2 0 001.73-3.04l-7.82-13.5a2 2 0 00-3.42 0z" />

                        </svg>


                        <div>

                            <p class="font-semibold text-red-700">
                                Terdapat kesalahan:
                            </p>

                            <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-600">

                                @foreach ($errors->all() as $error)
                                    <li>
                                        {{ $error }}
                                    </li>
                                @endforeach

                            </ul>

                        </div>

                    </div>

                </div>

            @endif


            <form action="{{ route('inventory-requests.store') }}" method="POST">

                @csrf


                {{-- ===================================================== --}}
                {{-- INFORMASI PENGAJUAN --}}
                {{-- ===================================================== --}}

                <div class="mb-6 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                    <div class="border-b border-slate-100 px-6 py-5">

                        <h3 class="text-lg font-bold text-slate-900">
                            Informasi Pengajuan
                        </h3>

                        <p class="mt-1 text-sm text-slate-500">
                            Tentukan jenis dan alasan kebutuhan barang.
                        </p>

                    </div>


                    <div class="grid gap-6 p-6">


                        {{-- JENIS PENGAJUAN --}}

                        <div>

                            <label for="request_type" class="mb-2 block text-sm font-semibold text-slate-700">

                                Jenis Pengajuan
                                <span class="text-red-500">*</span>

                            </label>

                        <select id="request_type" name="request_type" required
                            class="w-full rounded-xl border-slate-200 px-4 py-3 text-sm focus:border-[#8F348E] focus:ring-[#8F348E]">

                            <option value="">
                                Pilih Jenis Pengajuan
                            </option>

                            <option value="new_item" @selected(old('request_type') === 'new_item')>
                                Barang Baru
                            </option>

                            <option value="replacement" @selected(old('request_type') === 'replacement')>
                                Penggantian Barang
                            </option>

                            <option value="additional" @selected(old('request_type') === 'additional')>
                                Penambahan Barang
                            </option>

                            <option value="other" @selected(old('request_type') === 'other')>
                                Lainnya
                            </option>

                        </select>

                            @error('request_type')
                                <p class="mt-2 text-xs text-red-500">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- ALASAN --}}

                        <div>

                            <label for="reason" class="mb-2 block text-sm font-semibold text-slate-700">

                                Alasan Pengajuan
                                <span class="text-red-500">*</span>

                            </label>


                            <textarea id="reason" name="reason" rows="4" required
                                placeholder="Jelaskan alasan atau kebutuhan pengajuan barang..."
                                class="w-full rounded-xl border-slate-200 px-4 py-3 text-sm focus:border-[#8F348E] focus:ring-[#8F348E]">{{ old('reason') }}</textarea>


                            @error('reason')
                                <p class="mt-2 text-xs text-red-500">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- CATATAN --}}

                        <div>

                            <label for="notes" class="mb-2 block text-sm font-semibold text-slate-700">

                                Catatan
                                <span class="font-normal text-slate-400">
                                    (Opsional)
                                </span>

                            </label>


                            <textarea id="notes" name="notes" rows="3" placeholder="Tambahkan catatan jika diperlukan..."
                                class="w-full rounded-xl border-slate-200 px-4 py-3 text-sm focus:border-[#8F348E] focus:ring-[#8F348E]">{{ old('notes') }}</textarea>

                        </div>

                    </div>

                </div>


                {{-- ===================================================== --}}
                {{-- DAFTAR BARANG --}}
                {{-- ===================================================== --}}

                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                    <div
                        class="flex flex-col gap-4 border-b border-slate-100 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">

                        <div>

                            <h3 class="text-lg font-bold text-slate-900">
                                Daftar Barang
                            </h3>

                            <p class="mt-1 text-sm text-slate-500">
                                Tambahkan barang yang ingin diajukan.
                            </p>

                        </div>


                        <button type="button" id="btnTambahItem"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#8F348E] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#752C74]">

                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />

                            </svg>

                            Tambah Barang

                        </button>

                    </div>


                    <div id="itemsContainer" class="space-y-5 p-6">


                        {{-- ================================================= --}}
                        {{-- ITEM PERTAMA --}}
                        {{-- ================================================= --}}

                        @php

                            $oldItems = old('items', [
                                [
                                    'category_id' => '',
                                    'item_name' => '',
                                    'specification' => '',
                                    'quantity' => 1,
                                    'notes' => '',
                                ],
                            ]);

                        @endphp


                        @foreach ($oldItems as $index => $item)
                            <div class="request-item rounded-2xl border border-slate-200 bg-slate-50 p-5"
                                data-index="{{ $index }}">

                                <div class="mb-5 flex items-center justify-between">

                                    <div class="flex items-center gap-3">

                                        <div
                                            class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#8F348E] text-sm font-bold text-white">

                                            {{ $index + 1 }}

                                        </div>


                                        <div>

                                            <h4 class="font-bold text-slate-800">
                                                Barang #{{ $index + 1 }}
                                            </h4>

                                            <p class="text-xs text-slate-500">
                                                Detail barang yang diajukan.
                                            </p>

                                        </div>

                                    </div>


                                    <button type="button"
                                        class="btnHapusItem hidden rounded-lg px-3 py-2 text-sm font-semibold text-red-600 transition hover:bg-red-50">

                                        Hapus

                                    </button>

                                </div>


                                <div class="grid gap-5 md:grid-cols-2">


                                    {{-- KATEGORI --}}

                                    <div>

                                        <label class="mb-2 block text-sm font-semibold text-slate-700">

                                            Kategori

                                        </label>


                                        <select name="items[{{ $index }}][category_id]"
                                            class="w-full rounded-xl border-slate-200 bg-white px-4 py-3 text-sm focus:border-[#8F348E] focus:ring-[#8F348E]">

                                            <option value="">
                                                Pilih Kategori
                                            </option>


                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" @selected(($item['category_id'] ?? '') == $category->id)>

                                                    {{ $category->code }}
                                                    -
                                                    {{ $category->name }}

                                                </option>
                                            @endforeach

                                        </select>

                                    </div>


                                    {{-- NAMA BARANG --}}

                                    <div>

                                        <label class="mb-2 block text-sm font-semibold text-slate-700">

                                            Nama Barang

                                            <span class="text-red-500">
                                                *
                                            </span>

                                        </label>


                                        <input type="text" name="items[{{ $index }}][item_name]"
                                            value="{{ $item['item_name'] ?? '' }}" required
                                            placeholder="Contoh: Laptop Lenovo LOQ"
                                            class="w-full rounded-xl border-slate-200 bg-white px-4 py-3 text-sm focus:border-[#8F348E] focus:ring-[#8F348E]">

                                    </div>


                                    {{-- SPESIFIKASI --}}

                                    <div class="md:col-span-2">

                                        <label class="mb-2 block text-sm font-semibold text-slate-700">

                                            Spesifikasi

                                        </label>


                                        <textarea name="items[{{ $index }}][specification]" rows="3"
                                            placeholder="Contoh: Intel Core i7, RAM 16GB, SSD 512GB..."
                                            class="w-full rounded-xl border-slate-200 bg-white px-4 py-3 text-sm focus:border-[#8F348E] focus:ring-[#8F348E]">{{ $item['specification'] ?? '' }}</textarea>

                                    </div>


                                    {{-- JUMLAH --}}

                                    <div>

                                        <label class="mb-2 block text-sm font-semibold text-slate-700">

                                            Jumlah

                                            <span class="text-red-500">
                                                *
                                            </span>

                                        </label>


                                        <input type="number" name="items[{{ $index }}][quantity]"
                                            value="{{ $item['quantity'] ?? 1 }}" min="1" max="10000"
                                            required
                                            class="w-full rounded-xl border-slate-200 bg-white px-4 py-3 text-sm focus:border-[#8F348E] focus:ring-[#8F348E]">

                                    </div>


                                    {{-- CATATAN ITEM --}}

                                    <div>

                                        <label class="mb-2 block text-sm font-semibold text-slate-700">

                                            Catatan Item

                                        </label>


                                        <input type="text" name="items[{{ $index }}][notes]"
                                            value="{{ $item['notes'] ?? '' }}" placeholder="Catatan tambahan..."
                                            class="w-full rounded-xl border-slate-200 bg-white px-4 py-3 text-sm focus:border-[#8F348E] focus:ring-[#8F348E]">

                                    </div>

                                </div>

                            </div>
                        @endforeach

                    </div>


                    {{-- ================================================= --}}
                    {{-- EMPTY STATE --}}
                    {{-- ================================================= --}}

                    <div id="emptyItemsMessage" class="hidden px-6 pb-6">

                        <div class="rounded-xl border border-dashed border-slate-300 p-8 text-center">

                            <p class="font-semibold text-slate-600">
                                Belum ada barang.
                            </p>

                            <p class="mt-1 text-sm text-slate-400">
                                Klik "Tambah Barang" untuk menambahkan item.
                            </p>

                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- FOOTER --}}
                    {{-- ================================================= --}}

                    <div
                        class="flex flex-col gap-3 border-t border-slate-100 bg-slate-50 px-6 py-5 sm:flex-row sm:justify-end">

                        <a href="{{ route('inventory-requests.index') }}"
                            class="rounded-xl border border-slate-200 bg-white px-5 py-3 text-center text-sm font-semibold text-slate-700 hover:bg-slate-50">

                            Batal

                        </a>


                        <button type="submit"
                            class="rounded-xl bg-[#8F348E] px-6 py-3 text-sm font-semibold text-white transition hover:bg-[#752C74]">

                            Ajukan Barang

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- ================================================================ --}}
    {{-- TEMPLATE ITEM --}}
    {{-- ================================================================ --}}

    <template id="itemTemplate">

        <div class="request-item rounded-2xl border border-slate-200 bg-slate-50 p-5" data-index="__INDEX__">

            <div class="mb-5 flex items-center justify-between">

                <div class="flex items-center gap-3">

                    <div
                        class="item-number flex h-9 w-9 items-center justify-center rounded-lg bg-[#8F348E] text-sm font-bold text-white">

                        1

                    </div>


                    <div>

                        <h4 class="font-bold text-slate-800">
                            Barang #1
                        </h4>

                        <p class="text-xs text-slate-500">
                            Detail barang yang diajukan.
                        </p>

                    </div>

                </div>


                <button type="button"
                    class="btnHapusItem rounded-lg px-3 py-2 text-sm font-semibold text-red-600 transition hover:bg-red-50">

                    Hapus

                </button>

            </div>


            <div class="grid gap-5 md:grid-cols-2">


                {{-- KATEGORI --}}

                <div>

                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Kategori
                    </label>


                    <select name="items[__INDEX__][category_id]"
                        class="w-full rounded-xl border-slate-200 bg-white px-4 py-3 text-sm focus:border-[#8F348E] focus:ring-[#8F348E]">

                        <option value="">
                            Pilih Kategori
                        </option>

                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">

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


                    <input type="text" name="items[__INDEX__][item_name]" required
                        placeholder="Contoh: Laptop Lenovo LOQ"
                        class="w-full rounded-xl border-slate-200 bg-white px-4 py-3 text-sm focus:border-[#8F348E] focus:ring-[#8F348E]">

                </div>


                {{-- SPESIFIKASI --}}

                <div class="md:col-span-2">

                    <label class="mb-2 block text-sm font-semibold text-slate-700">

                        Spesifikasi

                    </label>


                    <textarea name="items[__INDEX__][specification]" rows="3"
                        placeholder="Contoh: Intel Core i7, RAM 16GB, SSD 512GB..."
                        class="w-full rounded-xl border-slate-200 bg-white px-4 py-3 text-sm focus:border-[#8F348E] focus:ring-[#8F348E]"></textarea>

                </div>


                {{-- JUMLAH --}}

                <div>

                    <label class="mb-2 block text-sm font-semibold text-slate-700">

                        Jumlah

                        <span class="text-red-500">*</span>

                    </label>


                    <input type="number" name="items[__INDEX__][quantity]" value="1" min="1"
                        max="10000" required
                        class="w-full rounded-xl border-slate-200 bg-white px-4 py-3 text-sm focus:border-[#8F348E] focus:ring-[#8F348E]">

                </div>


                {{-- CATATAN --}}

                <div>

                    <label class="mb-2 block text-sm font-semibold text-slate-700">

                        Catatan Item

                    </label>


                    <input type="text" name="items[__INDEX__][notes]" placeholder="Catatan tambahan..."
                        class="w-full rounded-xl border-slate-200 bg-white px-4 py-3 text-sm focus:border-[#8F348E] focus:ring-[#8F348E]">

                </div>

            </div>

        </div>

    </template>


    {{-- ================================================================ --}}
    {{-- JAVASCRIPT --}}
    {{-- ================================================================ --}}

    <script>
        document.addEventListener(
            'DOMContentLoaded',
            function() {

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

                const emptyMessage =
                    document.getElementById(
                        'emptyItemsMessage'
                    );


                let nextIndex =
                    container.querySelectorAll(
                        '.request-item'
                    ).length;


                /*
                |--------------------------------------------------------------------------
                | Update nomor item
                |--------------------------------------------------------------------------
                */

                function updateItemNumbers() {

                    const items =
                        container.querySelectorAll(
                            '.request-item'
                        );


                    items.forEach(
                        function(item, index) {

                            const number =
                                item.querySelector(
                                    '.item-number'
                                );

                            const title =
                                item.querySelector(
                                    'h4'
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


                            const deleteButton =
                                item.querySelector(
                                    '.btnHapusItem'
                                );


                            /*
                            | Item pertama tidak bisa dihapus
                            | jika hanya tersisa satu.
                            */

                            if (items.length <= 1) {

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


                    /*
                    |--------------------------------------------------------------------------
                    | Empty state
                    |--------------------------------------------------------------------------
                    */

                    if (items.length === 0) {

                        emptyMessage.classList.remove(
                            'hidden'
                        );

                    } else {

                        emptyMessage.classList.add(
                            'hidden'
                        );
                    }
                }


                /*
                |--------------------------------------------------------------------------
                | Tambah Item
                |--------------------------------------------------------------------------
                */

                addButton.addEventListener(
                    'click',
                    function() {

                        const html =
                            template.innerHTML
                            .replaceAll(
                                '__INDEX__',
                                nextIndex
                            );


                        container.insertAdjacentHTML(
                            'beforeend',
                            html
                        );


                        nextIndex++;

                        updateItemNumbers();

                    }
                );


                /*
                |--------------------------------------------------------------------------
                | Hapus Item
                |--------------------------------------------------------------------------
                */

                container.addEventListener(
                    'click',
                    function(event) {

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


                        if (!item) {
                            return;
                        }


                        item.remove();

                        updateItemNumbers();

                    }
                );


                updateItemNumbers();

            }
        );
    </script>

@endsection
