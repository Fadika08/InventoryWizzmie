@extends('layouts.app')

@section('title', 'Edit Divisi')

@section('page-title', 'Edit Divisi')

@section('content')

    <div class="mx-auto max-w-3xl space-y-6">

        <div>

            <a href="{{ route('departments.index') }}" class="text-sm font-medium text-[#8F348E] hover:underline">
                ← Kembali ke Divisi
            </a>

            <h2 class="mt-3 text-2xl font-bold text-slate-900">
                Edit Divisi
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Perbarui informasi divisi.
            </p>

        </div>


        <form method="POST" action="{{ route('departments.update', $department) }}"
            class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

            @csrf
            @method('PUT')

            <div class="grid gap-5 sm:grid-cols-2">

                {{-- Code --}}
                <div>

                    <label for="code" class="mb-2 block text-sm font-semibold text-slate-700">
                        Kode Divisi
                    </label>

                    <input id="code" name="code" type="text" value="{{ old('code', $department->code) }}"
                        maxlength="50" required
                        class="w-full rounded-xl border-slate-200 text-sm uppercase focus:border-[#8F348E] focus:ring-[#8F348E]">

                    @error('code')
                        <p class="mt-1.5 text-xs text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Name --}}
                <div>

                    <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">
                        Nama Divisi
                    </label>

                    <input id="name" name="name" type="text" value="{{ old('name', $department->name) }}"
                        maxlength="255" required
                        class="w-full rounded-xl border-slate-200 text-sm focus:border-[#8F348E] focus:ring-[#8F348E]">

                    @error('name')
                        <p class="mt-1.5 text-xs text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

            </div>


            {{-- Description --}}
            <div class="mt-5">

                <label for="description" class="mb-2 block text-sm font-semibold text-slate-700">
                    Deskripsi
                </label>

                <textarea id="description" name="description" rows="4"
                    class="w-full rounded-xl border-slate-200 text-sm focus:border-[#8F348E] focus:ring-[#8F348E]">{{ old('description', $department->description) }}</textarea>

                @error('description')
                    <p class="mt-1.5 text-xs text-red-500">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Status --}}
            <div class="mt-5">

                <label class="flex cursor-pointer items-center gap-3">

                    <input type="checkbox" name="is_active" value="1"
                        {{ old('is_active', $department->is_active) ? 'checked' : '' }}
                        class="rounded border-slate-300 text-[#8F348E] focus:ring-[#8F348E]">

                    <div>

                        <p class="text-sm font-semibold text-slate-700">
                            Aktif
                        </p>

                        <p class="text-xs text-slate-400">
                            Divisi dapat digunakan dalam sistem.
                        </p>

                    </div>

                </label>

            </div>


            {{-- Action --}}
            <div class="mt-8 flex flex-col-reverse gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:justify-end">

                <a href="{{ route('departments.index') }}"
                    class="rounded-xl border border-slate-200 px-5 py-2.5 text-center text-sm font-semibold text-slate-600 hover:bg-slate-50">
                    Batal
                </a>

                <button type="submit"
                    class="rounded-xl bg-[#8F348E] px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#752c74]">
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

@endsection
