@extends('layouts.app')

@section('title', 'Edit User')

@section('page-title', 'Edit User')

@section('content')

    <div class="mx-auto max-w-4xl space-y-6">

        {{-- Header --}}
        <div>

            <p class="text-xs font-bold uppercase tracking-wider text-[#8F348E]">
                User Management
            </p>

            <h2 class="mt-1 text-2xl font-bold text-slate-900">
                Edit User
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Perbarui informasi dan hak akses pengguna.
            </p>

        </div>


        <form method="POST" action="{{ route('users.update', $user) }}" enctype="multipart/form-data" class="space-y-6">

            @csrf

            @method('PUT')


            {{-- Informasi User --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                <h3 class="text-lg font-bold text-slate-900">
                    Informasi User
                </h3>

                <div class="mt-5 grid gap-5 md:grid-cols-2">

                    {{-- Nama --}}
                    <div class="md:col-span-2">

                        <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">

                            Nama Lengkap

                        </label>

                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                            class="w-full rounded-xl border-slate-200 focus:border-[#8F348E] focus:ring-[#8F348E]">

                        @error('name')
                            <p class="mt-1 text-xs text-red-500">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- Email --}}
                    <div>

                        <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">

                            Email

                        </label>

                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                            required class="w-full rounded-xl border-slate-200 focus:border-[#8F348E] focus:ring-[#8F348E]">

                        @error('email')
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

                        <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}"
                            class="w-full rounded-xl border-slate-200 focus:border-[#8F348E] focus:ring-[#8F348E]">

                        @error('phone')
                            <p class="mt-1 text-xs text-red-500">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                </div>

            </div>


            {{-- Role --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                <h3 class="text-lg font-bold text-slate-900">
                    Hak Akses & Penempatan
                </h3>

                <div class="mt-5 grid gap-5 md:grid-cols-2">

                    {{-- Role --}}
                    <div>

                        <label for="role_id" class="mb-2 block text-sm font-semibold text-slate-700">

                            Role

                        </label>

                        <select name="role_id" id="role_id" required
                            class="w-full rounded-xl border-slate-200 focus:border-[#8F348E] focus:ring-[#8F348E]">

                            <option value="">
                                Pilih Role
                            </option>

                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}" data-role="{{ $role->name }}"
                                    @selected(old('role_id', $user->role_id) == $role->id)>

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
                                <option value="{{ $department->id }}" @selected(old('department_id', $user->department_id) == $department->id)>

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
                                <option value="{{ $outlet->id }}" @selected(old('outlet_id', $user->outlet_id) == $outlet->id)>

                                    {{ $outlet->code }} -
                                    {{ $outlet->name }}

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


            {{-- Foto --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                <h3 class="text-lg font-bold text-slate-900">
                    Foto Profil
                </h3>

                <div class="mt-5 flex flex-col gap-5 sm:flex-row sm:items-center">

                    @if ($user->profile_photo)
                        <img src="{{ Storage::url($user->profile_photo) }}" alt="{{ $user->name }}"
                            class="h-24 w-24 rounded-2xl object-cover">
                    @else
                        <div
                            class="flex h-24 w-24 items-center justify-center rounded-2xl bg-[#8F348E]/10 text-3xl font-bold text-[#8F348E]">

                            {{ strtoupper(substr($user->name, 0, 1)) }}

                        </div>
                    @endif


                    <div class="flex-1">

                        <label for="profile_photo" class="mb-2 block text-sm font-semibold text-slate-700">

                            Ganti Foto Profil

                        </label>

                        <input type="file" name="profile_photo" id="profile_photo" accept=".jpg,.jpeg,.png,.webp"
                            class="block w-full rounded-xl border border-slate-200 text-sm">

                        <p class="mt-1 text-xs text-slate-400">
                            JPG, JPEG, PNG atau WEBP. Maksimal 2 MB.
                        </p>

                        @error('profile_photo')
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
                    Password
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    Kosongkan jika tidak ingin mengubah password.
                </p>

                <div class="mt-5 grid gap-5 md:grid-cols-2">

                    <div>

                        <label for="password" class="mb-2 block text-sm font-semibold text-slate-700">

                            Password Baru

                        </label>

                        <input type="password" name="password" id="password" autocomplete="new-password"
                            class="w-full rounded-xl border-slate-200">

                        @error('password')
                            <p class="mt-1 text-xs text-red-500">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    <div>

                        <label for="password_confirmation" class="mb-2 block text-sm font-semibold text-slate-700">

                            Konfirmasi Password

                        </label>

                        <input type="password" name="password_confirmation" id="password_confirmation"
                            autocomplete="new-password" class="w-full rounded-xl border-slate-200">

                    </div>

                </div>

            </div>


            {{-- Status --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                <label class="flex cursor-pointer items-center gap-3">

                    <input type="hidden" name="is_active" value="0">

                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $user->is_active))
                        class="rounded border-slate-300 text-[#8F348E] focus:ring-[#8F348E]">

                    <span>

                        <span class="block text-sm font-semibold text-slate-700">
                            Akun Aktif
                        </span>

                        <span class="block text-xs text-slate-400">
                            User dapat login jika akun dalam keadaan aktif.
                        </span>

                    </span>

                </label>

            </div>


            {{-- Buttons --}}
            <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

                <a href="{{ route('users.show', $user) }}"
                    class="rounded-xl border border-slate-200 bg-white px-6 py-3 text-center text-sm font-semibold text-slate-600 hover:bg-slate-50">

                    Batal

                </a>

                <button type="submit"
                    class="rounded-xl bg-[#8F348E] px-6 py-3 text-sm font-semibold text-white hover:bg-[#752c74]">

                    Simpan Perubahan

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
                    document.getElementById(
                        'department-wrapper'
                    );

                const outletWrapper =
                    document.getElementById(
                        'outlet-wrapper'
                    );

                const department =
                    document.getElementById(
                        'department_id'
                    );

                const outlet =
                    document.getElementById(
                        'outlet_id'
                    );


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
