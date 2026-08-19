@extends('layouts.app')

@section('title', 'Tambah User')

@section('page-title', 'Tambah User')

@section('content')

    <div class="mx-auto max-w-4xl space-y-6">

        <div>
            <p class="text-xs font-bold uppercase tracking-wider text-[#8F348E]">
                User Management
            </p>

            <h2 class="mt-1 text-2xl font-bold text-slate-900">
                Tambah User
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Tambahkan pengguna baru ke dalam sistem inventaris.
            </p>
        </div>


        <form method="POST" action="{{ route('users.store') }}" class="space-y-6">

            @csrf

            {{-- Informasi User --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                <h3 class="text-lg font-bold text-slate-900">
                    Informasi User
                </h3>

                <div class="mt-5 grid gap-5 md:grid-cols-2">

                    <div class="md:col-span-2">

                        <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">

                            Nama Lengkap

                        </label>

                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                            class="w-full rounded-xl border-slate-200 focus:border-[#8F348E] focus:ring-[#8F348E]">

                        @error('name')
                            <p class="mt-1 text-xs text-red-500">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    <div>

                        <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">

                            Email

                        </label>

                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                            class="w-full rounded-xl border-slate-200 focus:border-[#8F348E] focus:ring-[#8F348E]">

                        @error('email')
                            <p class="mt-1 text-xs text-red-500">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    <div>

                        <label for="phone" class="mb-2 block text-sm font-semibold text-slate-700">

                            Nomor Telepon

                        </label>

                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                            class="w-full rounded-xl border-slate-200 focus:border-[#8F348E] focus:ring-[#8F348E]">

                    </div>

                </div>

            </div>


            {{-- Role & Organisasi --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                <h3 class="text-lg font-bold text-slate-900">
                    Hak Akses & Penempatan
                </h3>

                <div class="mt-5 grid gap-5 md:grid-cols-2">

                    <div>

                        <label for="role_id" class="mb-2 block text-sm font-semibold text-slate-700">

                            Role

                        </label>

                        <select name="role_id" id="role_id" required class="w-full rounded-xl border-slate-200">

                            <option value="">
                                Pilih Role
                            </option>

                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}" data-role="{{ $role->name }}"
                                    @selected(old('role_id') == $role->id)>

                                    {{ ucwords(str_replace('_', ' ', $role->name)) }}

                                </option>
                            @endforeach

                        </select>

                        @error('role_id')
                            <p class="mt-1 text-xs text-red-500">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- Department --}}
                    <div id="department-wrapper">

                        <label for="department_id" class="mb-2 block text-sm font-semibold text-slate-700">

                            Department

                        </label>

                        <select name="department_id" id="department_id" class="w-full rounded-xl border-slate-200">

                            <option value="">
                                Pilih Department
                            </option>

                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}" @selected(old('department_id') == $department->id)>

                                    {{ $department->name }}

                                </option>
                            @endforeach

                        </select>

                        @error('department_id')
                            <p class="mt-1 text-xs text-red-500">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- Outlet --}}
                    <div id="outlet-wrapper">

                        <label for="outlet_id" class="mb-2 block text-sm font-semibold text-slate-700">

                            Outlet

                        </label>

                        <select name="outlet_id" id="outlet_id" class="w-full rounded-xl border-slate-200">

                            <option value="">
                                Pilih Outlet
                            </option>

                            @foreach ($outlets as $outlet)
                                <option value="{{ $outlet->id }}" @selected(old('outlet_id') == $outlet->id)>

                                    {{ $outlet->code }} - {{ $outlet->name }}

                                </option>
                            @endforeach

                        </select>

                        @error('outlet_id')
                            <p class="mt-1 text-xs text-red-500">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                </div>

            </div>


            {{-- Password --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                <h3 class="text-lg font-bold text-slate-900">
                    Keamanan Akun
                </h3>

                <div class="mt-5 grid gap-5 md:grid-cols-2">

                    <div>

                        <label for="password" class="mb-2 block text-sm font-semibold text-slate-700">

                            Password

                        </label>

                        <input type="password" name="password" id="password" required autocomplete="new-password"
                            class="w-full rounded-xl border-slate-200">

                    </div>


                    <div>

                        <label for="password_confirmation" class="mb-2 block text-sm font-semibold text-slate-700">

                            Konfirmasi Password

                        </label>

                        <input type="password" name="password_confirmation" id="password_confirmation" required
                            autocomplete="new-password" class="w-full rounded-xl border-slate-200">

                    </div>

                </div>

            </div>


            {{-- Status --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                <label class="flex cursor-pointer items-center gap-3">

                    <input type="checkbox" name="is_active" value="1" checked
                        class="rounded border-slate-300 text-[#8F348E] focus:ring-[#8F348E]">

                    <span>

                        <span class="block text-sm font-semibold text-slate-700">
                            Aktifkan akun
                        </span>

                        <span class="block text-xs text-slate-400">
                            User dapat langsung login setelah akun dibuat.
                        </span>

                    </span>

                </label>

            </div>


            {{-- Buttons --}}
            <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

                <a href="{{ route('users.index') }}"
                    class="rounded-xl border border-slate-200 bg-white px-6 py-3 text-center text-sm font-semibold text-slate-600 hover:bg-slate-50">

                    Batal

                </a>

                <button type="submit"
                    class="rounded-xl bg-[#8F348E] px-6 py-3 text-sm font-semibold text-white hover:bg-[#752c74]">

                    Simpan User

                </button>

            </div>

        </form>

    </div>


    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                const roleSelect =
                    document.getElementById('role_id');

                const departmentWrapper =
                    document.getElementById('department-wrapper');

                const outletWrapper =
                    document.getElementById('outlet-wrapper');

                const department =
                    document.getElementById('department_id');

                const outlet =
                    document.getElementById('outlet_id');


                function updateFields() {

                    const selected =
                        roleSelect.options[
                            roleSelect.selectedIndex
                        ];

                    const role =
                        selected ?
                        selected.dataset.role :
                        '';


                    if (role === 'ho_admin') {

                        departmentWrapper.classList.remove(
                            'hidden'
                        );

                        outletWrapper.classList.add(
                            'hidden'
                        );

                        department.disabled = false;
                        outlet.disabled = true;

                        outlet.value = '';

                    } else if (role === 'outlet_admin') {

                        departmentWrapper.classList.add(
                            'hidden'
                        );

                        outletWrapper.classList.remove(
                            'hidden'
                        );

                        department.disabled = true;
                        outlet.disabled = false;

                        department.value = '';

                    } else {

                        departmentWrapper.classList.add(
                            'hidden'
                        );

                        outletWrapper.classList.add(
                            'hidden'
                        );

                        department.disabled = true;
                        outlet.disabled = true;

                        department.value = '';
                        outlet.value = '';

                    }

                }


                roleSelect.addEventListener(
                    'change',
                    updateFields
                );


                updateFields();

            });
        </script>
    @endpush

@endsection
