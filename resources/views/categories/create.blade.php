@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('page-title', 'Tambah Kategori')

@section('content')

    <div class="mx-auto max-w-2xl">

        <a href="{{ route('categories.index') }}" class="text-sm font-medium text-[#8F348E]">

            ← Kembali

        </a>

        <div class="mt-4 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

            <h2 class="text-xl font-bold text-slate-900">
                Tambah Kategori Inventaris
            </h2>

            <form method="POST" action="{{ route('categories.store') }}" class="mt-6 space-y-5">

                @csrf

                <div>

                    <label for="code" class="mb-2 block text-sm font-semibold text-slate-700">

                        Kode

                    </label>

                    <input id="code" name="code" value="{{ old('code') }}" placeholder="Contoh: LAPTOP" required
                        class="w-full rounded-xl border-slate-200 uppercase focus:border-[#8F348E] focus:ring-[#8F348E]">

                    @error('code')
                        <p class="mt-1 text-xs text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                <div>

                    <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">

                        Nama Kategori

                    </label>

                    <input id="name" name="name" value="{{ old('name') }}" placeholder="Contoh: Laptop" required
                        class="w-full rounded-xl border-slate-200 focus:border-[#8F348E] focus:ring-[#8F348E]">

                    @error('name')
                        <p class="mt-1 text-xs text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                <div>

                    <label for="description" class="mb-2 block text-sm font-semibold text-slate-700">

                        Deskripsi

                    </label>

                    <textarea id="description" name="description" rows="4"
                        class="w-full rounded-xl border-slate-200 focus:border-[#8F348E] focus:ring-[#8F348E]">{{ old('description') }}</textarea>

                </div>

                <label class="flex items-center gap-3">

                    <input type="checkbox" name="is_active" value="1" checked
                        class="rounded border-slate-300 text-[#8F348E] focus:ring-[#8F348E]">

                    <span class="text-sm font-semibold text-slate-700">
                        Aktif
                    </span>

                </label>

                <div class="flex justify-end gap-3 border-t border-slate-100 pt-5">

                    <a href="{{ route('categories.index') }}"
                        class="rounded-xl border border-slate-200 px-5 py-2.5 text-sm font-semibold text-slate-600">

                        Batal

                    </a>

                    <button type="submit" class="rounded-xl bg-[#8F348E] px-5 py-2.5 text-sm font-semibold text-white">

                        Simpan

                    </button>

                </div>

            </form>

        </div>

    </div>

@endsection
