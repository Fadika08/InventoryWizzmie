@extends('layouts.app')

@section('title', 'Detail User')

@section('page-title', 'Detail User')

@section('content')

    <div class="mx-auto max-w-5xl space-y-6">

        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>

                <p class="text-xs font-bold uppercase tracking-wider text-[#8F348E]">
                    User Management
                </p>

                <h2 class="mt-1 text-2xl font-bold text-slate-900">
                    Detail User
                </h2>

            </div>

            <a href="{{ route('users.edit', $user) }}"
                class="rounded-xl bg-[#8F348E] px-5 py-2.5 text-center text-sm font-semibold text-white hover:bg-[#752c74)">

                Edit User

            </a>

        </div>


        {{-- Profile --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

            <div class="flex flex-col gap-6 sm:flex-row sm:items-center">

                @if ($user->profile_photo)
                    <img src="{{ Storage::url($user->profile_photo) }}" alt="{{ $user->name }}"
                        class="h-24 w-24 rounded-2xl object-cover">
                @else
                    <div
                        class="flex h-24 w-24 items-center justify-center rounded-2xl bg-[#8F348E]/10 text-3xl font-bold text-[#8F348E]">

                        {{ strtoupper(substr($user->name, 0, 1)) }}

                    </div>
                @endif


                <div>

                    <h3 class="text-2xl font-bold text-slate-900">
                        {{ $user->name }}
                    </h3>

                    <p class="mt-1 text-sm text-slate-500">
                        {{ $user->email }}
                    </p>

                    <div class="mt-3 flex flex-wrap gap-2">

                        <span class="rounded-full bg-purple-50 px-3 py-1 text-xs font-semibold text-purple-700">

                            {{ ucwords(str_replace('_', ' ', $user->role?->name ?? '-')) }}

                        </span>

                        @if ($user->is_active)
                            <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-600">
                                Aktif
                            </span>
                        @else
                            <span class="rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-red-600">
                                Tidak Aktif
                            </span>
                        @endif

                    </div>

                </div>

            </div>

        </div>


        {{-- Informasi --}}
        <div class="grid gap-6 md:grid-cols-2">

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                <h3 class="font-bold text-slate-900">
                    Informasi Akun
                </h3>

                <dl class="mt-5 space-y-4">

                    <div>
                        <dt class="text-xs text-slate-400">
                            Email
                        </dt>

                        <dd class="mt-1 text-sm font-semibold text-slate-700">
                            {{ $user->email }}
                        </dd>
                    </div>

                    <div>
                        <dt class="text-xs text-slate-400">
                            Nomor Telepon
                        </dt>

                        <dd class="mt-1 text-sm font-semibold text-slate-700">
                            {{ $user->phone ?? '-' }}
                        </dd>
                    </div>

                    <div>
                        <dt class="text-xs text-slate-400">
                            Last Login
                        </dt>

                        <dd class="mt-1 text-sm font-semibold text-slate-700">
                            {{ $user->last_login_at?->format('d M Y H:i') ?? 'Belum pernah login' }}
                        </dd>
                    </div>

                </dl>

            </div>


            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                <h3 class="font-bold text-slate-900">
                    Penempatan
                </h3>

                <dl class="mt-5 space-y-4">

                    <div>
                        <dt class="text-xs text-slate-400">
                            Role
                        </dt>

                        <dd class="mt-1 text-sm font-semibold text-slate-700">
                            {{ ucwords(str_replace('_', ' ', $user->role?->name ?? '-')) }}
                        </dd>
                    </div>

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

                </dl>

            </div>

        </div>


        {{-- Activity --}}
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-100 px-6 py-5">

                <h3 class="font-bold text-slate-900">
                    Aktivitas Terakhir
                </h3>

            </div>

            <div class="divide-y divide-slate-100">

                @forelse($recentActivities as $activity)
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
