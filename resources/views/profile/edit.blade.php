@extends('layouts.app')

@section('title', 'Profile')

@section('page-title', 'Profile')

@section('content')

    <div class="mx-auto max-w-5xl space-y-6">

        {{-- Header --}}
        <div>

            <p class="text-xs font-bold uppercase tracking-wider text-[#8F348E]">
                Account
            </p>

            <h2 class="mt-1 text-2xl font-bold text-slate-900">
                Profile Saya
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Kelola informasi pribadi dan keamanan akun Anda.
            </p>

        </div>


        {{-- Success --}}
        @if (session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-700">

                {{ session('success') }}

            </div>
        @endif


        {{-- Error --}}
        @if (session('error'))
            <div class="rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-medium text-red-700">

                {{ session('error') }}

            </div>
        @endif


        <div class="grid gap-6 lg:grid-cols-3">

            {{-- Profile Card --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                <div class="text-center">

                    @if ($user->profile_photo)
                        <img src="{{ Storage::url($user->profile_photo) }}" alt="{{ $user->name }}"
                            class="mx-auto h-28 w-28 rounded-2xl object-cover">
                    @else
                        <div
                            class="mx-auto flex h-28 w-28 items-center justify-center rounded-2xl bg-[#8F348E]/10 text-4xl font-bold text-[#8F348E]">

                            {{ strtoupper(substr($user->name, 0, 1)) }}

                        </div>
                    @endif


                    <h3 class="mt-4 text-lg font-bold text-slate-900">
                        {{ $user->name }}
                    </h3>

                    <p class="mt-1 text-sm text-slate-400">
                        {{ $user->email }}
                    </p>


                    <div class="mt-4">

                        <span
                            class="inline-flex rounded-full bg-[#8F348E]/10 px-3 py-1 text-xs font-semibold text-[#8F348E]">

                            {{ ucwords(str_replace('_', ' ', $user->role?->name ?? '-')) }}

                        </span>

                    </div>

                </div>


                <div class="mt-6 border-t border-slate-100 pt-5">

                    <dl class="space-y-4">

                        <div>

                            <dt class="text-xs text-slate-400">
                                Department
                            </dt>

                            <dd class="mt-1 text-sm font-semibold text-slate-700">
                                {{ $user->department?->name ?? '-' }}
                            </dd>

                        </div>


                        <div>

                            <dt class="text-xs text-slate-400">
                                Outlet
                            </dt>

                            <dd class="mt-1 text-sm font-semibold text-slate-700">
                                {{ $user->outlet?->name ?? '-' }}
                            </dd>

                        </div>


                        <div>

                            <dt class="text-xs text-slate-400">
                                Status
                            </dt>

                            <dd class="mt-1">

                                @if ($user->is_active)
                                    <span
                                        class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-600">
                                        Aktif
                                    </span>
                                @else
                                    <span class="rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-red-600">
                                        Tidak Aktif
                                    </span>
                                @endif

                            </dd>

                        </div>

                    </dl>

                </div>

            </div>


            {{-- Right --}}
            <div class="space-y-6 lg:col-span-2">

                {{-- Informasi Profile --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                    <h3 class="text-lg font-bold text-slate-900">
                        Informasi Profile
                    </h3>

                    <p class="mt-1 text-sm text-slate-500">
                        Informasi ini dapat Anda ubah sendiri.
                    </p>


                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data"
                        class="mt-6 space-y-5">

                        @csrf

                        @method('PATCH')


                        {{-- Name --}}
                        <div>

                            <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">

                                Nama Lengkap

                            </label>

                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                                required
                                class="w-full rounded-xl border-slate-200 focus:border-[#8F348E] focus:ring-[#8F348E]">

                            @error('name')
                                <p class="mt-1 text-xs text-red-500">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- Email --}}
                        <div>

                            <label class="mb-2 block text-sm font-semibold text-slate-700">

                                Email

                            </label>

                            <input type="text" value="{{ $user->email }}" disabled
                                class="w-full cursor-not-allowed rounded-xl border-slate-200 bg-slate-50 text-slate-500">

                            <p class="mt-1 text-xs text-slate-400">
                                Email hanya dapat diubah oleh Super Admin IT.
                            </p>

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


                        {{-- Foto --}}
                        <div>

                            <label for="profile_photo" class="mb-2 block text-sm font-semibold text-slate-700">

                                Foto Profile

                            </label>

                            <input type="file" name="profile_photo" id="profile_photo" accept=".jpg,.jpeg,.png,.webp"
                                class="block w-full rounded-xl border border-slate-200 text-sm">

                            <p class="mt-1 text-xs text-slate-400">
                                JPG, PNG, WEBP. Maksimal 2 MB.
                            </p>

                            @error('profile_photo')
                                <p class="mt-1 text-xs text-red-500">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        <div class="flex justify-end">

                            <button type="submit"
                                class="rounded-xl bg-[#8F348E] px-6 py-3 text-sm font-semibold text-white hover:bg-[#752c74]">

                                Simpan Profile

                            </button>

                        </div>

                    </form>

                </div>


                {{-- Password --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                    <h3 class="text-lg font-bold text-slate-900">
                        Ubah Password
                    </h3>

                    <p class="mt-1 text-sm text-slate-500">
                        Gunakan password minimal 8 karakter.
                    </p>


                    <form method="POST" action="{{ route('profile.password') }}" class="mt-6 space-y-5">

                        @csrf

                        @method('PUT')


                        <div>

                            <label for="current_password" class="mb-2 block text-sm font-semibold text-slate-700">

                                Password Saat Ini

                            </label>

                            <input type="password" name="current_password" id="current_password" required
                                autocomplete="current-password" class="w-full rounded-xl border-slate-200">

                            @error('current_password')
                                <p class="mt-1 text-xs text-red-500">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        <div class="grid gap-5 md:grid-cols-2">

                            <div>

                                <label for="password" class="mb-2 block text-sm font-semibold text-slate-700">

                                    Password Baru

                                </label>

                                <input type="password" name="password" id="password" required autocomplete="new-password"
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

                                <input type="password" name="password_confirmation" id="password_confirmation" required
                                    autocomplete="new-password" class="w-full rounded-xl border-slate-200">

                            </div>

                        </div>


                        <div class="flex justify-end">

                            <button type="submit"
                                class="rounded-xl border border-[#8F348E] px-6 py-3 text-sm font-semibold text-[#8F348E] hover:bg-[#8F348E] hover:text-white">

                                Ubah Password

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>


        {{-- Recent Activity --}}
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-100 px-6 py-5">

                <h3 class="font-bold text-slate-900">
                    Aktivitas Saya
                </h3>

                <p class="mt-1 text-xs text-slate-400">
                    10 aktivitas terakhir
                </p>

            </div>


            <div class="divide-y divide-slate-100">

                @forelse($activities as $activity)
                    <div class="px-6 py-4">

                        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">

                            <div>

                                <span class="rounded-full bg-slate-100 px-3 py-1 text-[10px] font-bold text-slate-600">

                                    {{ $activity->action }}

                                </span>

                                <p class="mt-2 text-sm text-slate-600">

                                    {{ $activity->description }}

                                </p>

                            </div>

                            <span class="text-xs text-slate-400">

                                {{ $activity->created_at?->format('d M Y H:i') }}

                            </span>

                        </div>

                    </div>

                @empty

                    <div class="px-6 py-10 text-center">

                        <p class="text-sm text-slate-400">
                            Belum ada aktivitas.
                        </p>

                    </div>
                @endforelse

            </div>

        </div>

    </div>

@endsection
