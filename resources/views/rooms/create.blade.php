@extends('layouts.app')

@section('title', 'Tambah Ruangan')

@section('page-title', 'Tambah Ruangan')

@section('content')

    <div class="mx-auto max-w-3xl">

        <div class="mb-6">

            <a href="{{ route('rooms.index') }}" class="text-sm font-medium text-[#8F348E] hover:underline">

                ← Kembali ke Ruangan

            </a>

            <h2 class="mt-3 text-2xl font-bold text-slate-900">
                Tambah Ruangan
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Tambahkan ruangan baru pada Head Office.
            </p>

        </div>


        <form method="POST" action="{{ route('rooms.store') }}"
            class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

            @csrf

            <div class="grid gap-5 sm:grid-cols-2">

                {{-- Department --}}
                <div class="sm:col-span-2">

                    <label for="department_id" class="mb-2 block text-sm font-semibold text-slate-700">

                        Divisi

                    </label>

                    <select id="department_id" name="department_id" required
                        class="w-full rounded-xl border-slate-200 text-sm focus:border-[#8F348E] focus:ring-[#8F348E]">

                        <option value="">
                            Pilih Divisi
                        </option>

                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}" @selected(old('department_id') == $department->id)>

                                {{ $department->code }} - {{ $department->name }}

                            </option>
                        @endforeach

                    </select>

                    @error('department_id')
                        <p class="mt-1 text-xs text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Code --}}
                <div>

                    <label for="code" class="mb-2 block text-sm font-semibold text-slate-700">

                        Kode Ruangan

                    </label>

                    <input id="code" name="code" type="text" value="{{ old('code') }}"
                        placeholder="Contoh: IT-ROOM-01" required
                        class="w-full rounded-xl border-slate-200 text-sm uppercase focus:border-[#8F348E] focus:ring-[#8F348E]">

                    @error('code')
                        <p class="mt-1 text-xs text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Name --}}
                <div>

                    <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">

                        Nama Ruangan

                    </label>

                    <input id="name" name="name" type="text" value="{{ old('name') }}"
                        placeholder="Contoh: Ruang IT" required
                        class="w-full rounded-xl border-slate-200 text-sm focus:border-[#8F348E] focus:ring-[#8F348E]">

                    @error('name')
                        <p class="mt-1 text-xs text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Floor --}}
                <div>

                    <label for="floor" class="mb-2 block text-sm font-semibold text-slate-700">

                        Lantai

                    </label>

                    <input id="floor" name="floor" type="text" value="{{ old('floor') }}"
                        placeholder="Contoh: Lantai 2"
                        class="w-full rounded-xl border-slate-200 text-sm focus:border-[#8F348E] focus:ring-[#8F348E]">

                    @error('floor')
                        <p class="mt-1 text-xs text-red-500">
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

                <textarea id="description" name="description" rows="4" placeholder="Keterangan ruangan..."
                    class="w-full rounded-xl border-slate-200 text-sm focus:border-[#8F348E] focus:ring-[#8F348E]">{{ old('description') }}</textarea>

            </div>


            {{-- Status --}}
            <div class="mt-5">

                <label class="flex items-center gap-3">

                    <input type="checkbox" name="is_active" value="1" checked
                        class="rounded border-slate-300 text-[#8F348E] focus:ring-[#8F348E]">

                    <span class="text-sm font-semibold text-slate-700">
                        Aktif
                    </span>

                </label>

            </div>


            <div class="mt-8 flex flex-col-reverse gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:justify-end">

                <a href="{{ route('rooms.index') }}"
                    class="rounded-xl border border-slate-200 px-5 py-2.5 text-center text-sm font-semibold text-slate-600">

                    Batal

                </a>

                <button type="submit"
                    class="rounded-xl bg-[#8F348E] px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#752c74]">

                    Simpan Ruangan

                </button>

            </div>

        </form>

    </div>

@endsection
