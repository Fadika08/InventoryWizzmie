@extends('layouts.app')

@section('title', 'Edit Outlet')

@section('page-title', 'Edit Outlet')

@section('content')

    <div class="mx-auto max-w-4xl space-y-6">

        {{-- Header --}}
        <div>

            <p class="text-xs font-bold uppercase tracking-wider text-[#8F348E]">
                Outlet Management
            </p>

            <h2 class="mt-1 text-2xl font-bold text-slate-900">
                Edit Outlet
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Perbarui informasi outlet.
            </p>

        </div>


        {{-- Errors --}}
        @if ($errors->any())

            <div class="rounded-2xl border border-red-200 bg-red-50 p-5">

                <p class="text-sm font-bold text-red-700">
                    Terdapat kesalahan pada data.
                </p>

                <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-600">

                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach

                </ul>

            </div>

        @endif


        <form method="POST" action="{{ route('outlets.update', $outlet) }}" class="space-y-6">

            @csrf

            @method('PUT')


            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">

                <div class="border-b border-slate-100 px-6 py-5">

                    <h3 class="text-lg font-bold text-slate-900">
                        Informasi Outlet
                    </h3>

                </div>


                <div class="grid gap-5 p-6 md:grid-cols-2">

                    {{-- Code --}}
                    <div>

                        <label for="code" class="mb-2 block text-sm font-semibold text-slate-700">

                            Kode Outlet
                            <span class="text-red-500">*</span>

                        </label>

                        <input type="text" name="code" id="code" value="{{ old('code', $outlet->code) }}"
                            required
                            class="w-full rounded-xl border-slate-200 uppercase focus:border-[#8F348E] focus:ring-[#8F348E]">

                        @error('code')
                            <p class="mt-1 text-xs text-red-500">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- Name --}}
                    <div>

                        <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">

                            Nama Outlet
                            <span class="text-red-500">*</span>

                        </label>

                        <input type="text" name="name" id="name" value="{{ old('name', $outlet->name) }}"
                            required class="w-full rounded-xl border-slate-200 focus:border-[#8F348E] focus:ring-[#8F348E]">

                        @error('name')
                            <p class="mt-1 text-xs text-red-500">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- City --}}
                    <div>

                        <label for="city" class="mb-2 block text-sm font-semibold text-slate-700">

                            Kota

                        </label>

                        <input type="text" name="city" id="city" value="{{ old('city', $outlet->city) }}"
                            class="w-full rounded-xl border-slate-200">

                        @error('city')
                            <p class="mt-1 text-xs text-red-500">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- Area --}}
                    <div>

                        <label for="area" class="mb-2 block text-sm font-semibold text-slate-700">

                            Area

                        </label>

                        <input type="text" name="area" id="area" value="{{ old('area', $outlet->area) }}"
                            class="w-full rounded-xl border-slate-200">

                        @error('area')
                            <p class="mt-1 text-xs text-red-500">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- Manager --}}
                    <div>

                        <label for="manager_name" class="mb-2 block text-sm font-semibold text-slate-700">

                            Manager / PIC

                        </label>

                        <input type="text" name="manager_name" id="manager_name"
                            value="{{ old('manager_name', $outlet->manager_name) }}"
                            class="w-full rounded-xl border-slate-200">

                        @error('manager_name')
                            <p class="mt-1 text-xs text-red-500">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- Phone --}}
                    <div>

                        <label for="phone" class="mb-2 block text-sm font-semibold text-slate-700">

                            Nomor Telepon

                        </label>

                        <input type="text" name="phone" id="phone" value="{{ old('phone', $outlet->phone) }}"
                            class="w-full rounded-xl border-slate-200">

                        @error('phone')
                            <p class="mt-1 text-xs text-red-500">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- Address --}}
                    <div class="md:col-span-2">

                        <label for="address" class="mb-2 block text-sm font-semibold text-slate-700">

                            Alamat

                        </label>

                        <textarea name="address" id="address" rows="4" class="w-full rounded-xl border-slate-200">{{ old('address', $outlet->address) }}</textarea>

                        @error('address')
                            <p class="mt-1 text-xs text-red-500">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                </div>

            </div>


            {{-- Status --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                <label class="flex cursor-pointer items-center gap-3">

                    <input type="hidden" name="is_active" value="0">

                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $outlet->is_active))
                        class="h-4 w-4 rounded border-slate-300 text-[#8F348E] focus:ring-[#8F348E]">

                    <div>

                        <p class="text-sm font-semibold text-slate-700">
                            Outlet Aktif
                        </p>

                        <p class="text-xs text-slate-400">
                            Outlet aktif dapat digunakan untuk inventaris.
                        </p>

                    </div>

                </label>

            </div>


            {{-- Actions --}}
            <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

                <a href="{{ route('outlets.show', $outlet) }}"
                    class="rounded-xl border border-slate-200 bg-white px-6 py-3 text-center text-sm font-semibold text-slate-600">

                    Batal

                </a>

                <button type="submit"
                    class="rounded-xl bg-[#8F348E] px-7 py-3 text-sm font-semibold text-white hover:bg-[#752C74]">

                    Simpan Perubahan

                </button>

            </div>

        </form>

    </div>

@endsection
