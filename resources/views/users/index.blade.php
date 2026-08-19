@extends('layouts.app')

@section('title', 'Manajemen User')

@section('page-title', 'Manajemen User')

@section('content')
    @if (session('success'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-700">

            {{ session('success') }}

        </div>
    @endif


    @if (session('error'))
        <div class="rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-medium text-red-700">

            {{ session('error') }}

        </div>
    @endif
    <div class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>

                <p class="text-xs font-bold uppercase tracking-wider text-[#8F348E]">
                    User Management
                </p>

                <h2 class="mt-1 text-2xl font-bold text-slate-900">
                    Manajemen User
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Kelola pengguna, role, department, outlet, dan status akun.
                </p>

            </div>


            <a href="{{ route('users.create') }}"
                class="inline-flex items-center justify-center rounded-xl bg-[#8F348E] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#752c74]">

                + Tambah User

            </a>

        </div>


        {{-- Filter --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

            <form method="GET" action="{{ route('users.index') }}" class="grid gap-4 lg:grid-cols-4">

                {{-- Search --}}
                <div class="lg:col-span-2">

                    <label for="search" class="mb-2 block text-sm font-semibold text-slate-700">

                        Cari User

                    </label>

                    <input type="text" name="search" id="search" value="{{ $search }}"
                        placeholder="Nama, email, atau nomor telepon..."
                        class="w-full rounded-xl border-slate-200 text-sm focus:border-[#8F348E] focus:ring-[#8F348E]">

                </div>


                {{-- Role --}}
                <div>

                    <label for="role_id" class="mb-2 block text-sm font-semibold text-slate-700">

                        Role

                    </label>

                    <select name="role_id" id="role_id"
                        class="w-full rounded-xl border-slate-200 text-sm focus:border-[#8F348E] focus:ring-[#8F348E]">

                        <option value="">
                            Semua Role
                        </option>

                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" @selected($roleId == $role->id)>

                                {{ ucwords(str_replace('_', ' ', $role->name)) }}

                            </option>
                        @endforeach

                    </select>

                </div>


                {{-- Status --}}
                <div>

                    <label for="status" class="mb-2 block text-sm font-semibold text-slate-700">

                        Status

                    </label>

                    <select name="status" id="status"
                        class="w-full rounded-xl border-slate-200 text-sm focus:border-[#8F348E] focus:ring-[#8F348E]">

                        <option value="">
                            Semua Status
                        </option>

                        <option value="1" @selected($status === '1')>

                            Aktif

                        </option>

                        <option value="0" @selected($status === '0')>

                            Tidak Aktif

                        </option>

                    </select>

                </div>


                {{-- Buttons --}}
                <div class="flex justify-end gap-3 lg:col-span-4">

                    <a href="{{ route('users.index') }}"
                        class="rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50">

                        Reset

                    </a>

                    <button type="submit"
                        class="rounded-xl bg-[#8F348E] px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#752c74]">

                        Terapkan Filter

                    </button>

                </div>

            </form>

        </div>


        {{-- User Table --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-100 px-5 py-4">

                <h3 class="font-bold text-slate-900">
                    Daftar User
                </h3>

                <p class="mt-1 text-xs text-slate-400">
                    {{ $users->total() }} user terdaftar
                </p>

            </div>


            <div class="overflow-x-auto">

                <table class="w-full min-w-[1100px]">

                    <thead class="bg-slate-50">

                        <tr>

                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                User
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                Role
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                Department
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                Outlet
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                Status
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                Last Login
                            </th>

                            <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-slate-500">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-slate-100">

                        @forelse($users as $user)
                            <tr class="transition hover:bg-slate-50">

                                {{-- User --}}
                                <td class="px-6 py-4">

                                    <div class="flex items-center gap-3">

                                        @if ($user->profile_photo)
                                            <img src="{{ Storage::url($user->profile_photo) }}" alt="{{ $user->name }}"
                                                class="h-10 w-10 rounded-full object-cover">
                                        @else
                                            <div
                                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#8F348E]/10 text-sm font-bold text-[#8F348E]">

                                                {{ strtoupper(substr($user->name, 0, 1)) }}

                                            </div>
                                        @endif


                                        <div class="min-w-0">

                                            <p class="truncate text-sm font-bold text-slate-800">

                                                {{ $user->name }}

                                            </p>

                                            <p class="truncate text-xs text-slate-400">

                                                {{ $user->email }}

                                            </p>

                                        </div>

                                    </div>

                                </td>


                                {{-- Role --}}
                                <td class="px-6 py-4">

                                    @php

                                        $roleClass = match ($user->role?->name) {
                                            'super_admin' => 'bg-purple-50 text-purple-700',

                                            'ho_admin' => 'bg-blue-50 text-blue-700',

                                            'outlet_admin' => 'bg-orange-50 text-orange-700',

                                            default => 'bg-slate-100 text-slate-600',
                                        };

                                    @endphp

                                    <span
                                        class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $roleClass }}">

                                        {{ ucwords(str_replace('_', ' ', $user->role?->name ?? '-')) }}

                                    </span>

                                </td>


                                {{-- Department --}}
                                <td class="px-6 py-4">

                                    <p class="text-sm text-slate-600">

                                        {{ $user->department?->name ?? '-' }}

                                    </p>

                                </td>


                                {{-- Outlet --}}
                                <td class="px-6 py-4">

                                    <p class="text-sm text-slate-600">

                                        {{ $user->outlet?->name ?? '-' }}

                                    </p>

                                </td>


                                {{-- Status --}}
                                <td class="px-6 py-4">

                                    @if ($user->is_active)
                                        <span
                                            class="inline-flex rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-600">

                                            Aktif

                                        </span>
                                    @else
                                        <span
                                            class="inline-flex rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-red-600">

                                            Tidak Aktif

                                        </span>
                                    @endif

                                </td>


                                {{-- Last Login --}}
                                <td class="px-6 py-4">

                                    @if ($user->last_login_at)
                                        <p class="text-sm font-medium text-slate-600">

                                            {{ $user->last_login_at->format('d M Y') }}

                                        </p>

                                        <p class="text-xs text-slate-400">

                                            {{ $user->last_login_at->format('H:i') }}

                                        </p>
                                    @else
                                        <span class="text-xs text-slate-400">
                                            Belum pernah login
                                        </span>
                                    @endif

                                </td>


                                {{-- Actions --}}
                                <td class="px-6 py-4">

                                    <div class="flex items-center justify-end gap-3">

                                        {{-- Detail --}}
                                        <a href="{{ route('users.show', $user) }}"
                                            class="text-sm font-semibold text-[#8F348E] hover:underline">

                                            Detail

                                        </a>


                                        {{-- Edit --}}
                                        <a href="{{ route('users.edit', $user) }}"
                                            class="text-sm font-semibold text-blue-600 hover:underline">

                                            Edit

                                        </a>


                                        {{-- Toggle Status --}}
                                        @if (!$user->isSuperAdmin())
                                            <form method="POST" action="{{ route('users.toggle-status', $user) }}"
                                                onsubmit="return confirm(
                    '{{ $user->is_active ? 'Nonaktifkan user ini?' : 'Aktifkan user ini?' }}'
                )">

                                                @csrf

                                                @method('PATCH')

                                                @if ($user->is_active)
                                                    <button type="submit"
                                                        class="text-sm font-semibold text-red-600 hover:underline">

                                                        Nonaktifkan

                                                    </button>
                                                @else
                                                    <button type="submit"
                                                        class="text-sm font-semibold text-emerald-600 hover:underline">

                                                        Aktifkan

                                                    </button>
                                                @endif

                                            </form>
                                        @endif

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="7" class="px-6 py-16 text-center">

                                    <p class="font-semibold text-slate-600">
                                        Belum ada user.
                                    </p>

                                    <p class="mt-1 text-sm text-slate-400">
                                        User yang terdaftar akan muncul di sini.
                                    </p>

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>


            @if ($users->hasPages())
                <div class="border-t border-slate-100 px-5 py-4">

                    {{ $users->links() }}

                </div>
            @endif

        </div>

    </div>

@endsection
