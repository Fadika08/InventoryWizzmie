@extends('layouts.app')

@section('title', 'Edit Ruangan')

@section('page-title', 'Edit Ruangan')

@section('content')

    <div class="mx-auto max-w-3xl">

        <div class="mb-6">

            <a href="{{ route('rooms.index') }}" class="text-sm font-medium text-[#8F348E] hover:underline">

                ← Kembali ke Ruangan

            </a>

            <h2 class="mt-3 text-2xl font-bold text-slate-900">
                Edit Ruangan
            </h2>

        </div>


        <form method="POST" action="{{ route('rooms.update', $room) }}"
            class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

            @csrf
            @method('PUT')

            <div class="grid gap-5 sm:grid-cols-2">

                <div class="sm:col-span-2">

                    <label for="department_id" class="mb-2 block text-sm font-semibold text-slate-700">

                        Divisi

                    </label>

                    <select id="department_id" name="department_id" required
                        class="w-full rounded-xl border-slate-200 text-sm focus:border-[#8F348E] focus:ring-[#8F348E]">

                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}" @selected(old('department_id', $room->department_id) == $department->id)>

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


                <div>

                    <label for="code" class="mb-2 block text-sm font-semibold text-slate-700">

                        Kode Ruangan

                    </label>

                    <input id="code" name="code" type="text" value="{{ old('code', $room->code) }}" required
                        class="w-full rounded-xl border-slate-200 text-sm uppercase focus:border-[#8F348E] focus:ring-[#8F348E]">

                    @error('code')
                        <p class="mt-1 text-xs text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                <div>

                    <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">

                        Nama Ruangan

                    </label>

                    <input id="name" name="name" type="text" value="{{ old('name', $room->name) }}" required
                        class="w-full rounded-xl border-slate-200 text-sm focus:border-[#8F348E] focus:ring-[#8F348E]">

                    @error('name')
                        <p class="mt-1 text-xs text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                <div>

                    <label for="floor" class="mb-2 block text-sm font-semibold text-slate-700">

                        Lantai

                    </label>

                    <input id="floor" name="floor" type="text" value="{{ old('floor', $room->floor) }}"
                        class="w-full rounded-xl border-slate-200 text-sm focus:border-[#8F348E] focus:ring-[#8F348E]">

                </div>

            </div>


            <div class="mt-5">

                <label for="description" class="mb-2 block text-sm font-semibold text-slate-700">

                    Deskripsi

                </label>

                <textarea id="description" name="description" rows="4"
                    class="w-full rounded-xl border-slate-200 text-sm focus:border-[#8F348E] focus:ring-[#8F348E]">{{ old('description', $room->description) }}</textarea>

            </div>


            <div class="mt-5">

                <label class="flex items-center gap-3">

                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $room->is_active))
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

                <button type="submit" class="rounded-xl bg-[#8F348E] px-5 py-2.5 text-sm font-semibold text-white">

                    Simpan Perubahan

                </button>

            </div>

        </form>

    </div>

@endsection
