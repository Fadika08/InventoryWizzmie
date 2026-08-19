@extends('layouts.app')

@section('title', 'Riwayat Aktivitas')

@section('page-title', 'Riwayat Aktivitas')

@section('content')

    <div class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-[#8F348E]">
                    Activity Log
                </p>

                <h2 class="mt-1 text-2xl font-bold text-slate-900">
                    Riwayat Aktivitas
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Pantau seluruh aktivitas pengguna yang terjadi di dalam sistem.
                </p>
            </div>

        </div>


        {{-- Filter --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

            <form method="GET" action="{{ route('activity-logs.index') }}" class="grid gap-4 md:grid-cols-4">

                {{-- Search --}}
                <div class="md:col-span-2">

                    <label for="search" class="mb-2 block text-sm font-semibold text-slate-700">

                        Cari Aktivitas

                    </label>

                    <input type="text" name="search" id="search" value="{{ $search }}"
                        placeholder="Cari nama user atau aktivitas..."
                        class="w-full rounded-xl border-slate-200 text-sm focus:border-[#8F348E] focus:ring-[#8F348E]">

                </div>


                {{-- Action --}}
                <div>

                    <label for="action" class="mb-2 block text-sm font-semibold text-slate-700">

                        Aktivitas

                    </label>

                    <select name="action" id="action"
                        class="w-full rounded-xl border-slate-200 text-sm focus:border-[#8F348E] focus:ring-[#8F348E]">

                        <option value="">
                            Semua Aktivitas
                        </option>

                        @foreach (['CREATE', 'UPDATE', 'DELETE', 'LOGIN', 'LOGOUT', 'APPROVE', 'REJECT', 'MUTATION', 'MAINTENANCE', 'EXPORT'] as $item)
                            <option value="{{ $item }}" @selected($action === $item)>

                                {{ $item }}

                            </option>
                        @endforeach

                    </select>

                </div>


                {{-- Module --}}
                <div>

                    <label for="module" class="mb-2 block text-sm font-semibold text-slate-700">

                        Modul

                    </label>

                    <select name="module" id="module"
                        class="w-full rounded-xl border-slate-200 text-sm focus:border-[#8F348E] focus:ring-[#8F348E]">

                        <option value="">
                            Semua Modul
                        </option>

                        @foreach (['Inventory', 'Category', 'Department', 'Outlet', 'User', 'Request', 'Maintenance', 'Report', 'Authentication'] as $item)
                            <option value="{{ $item }}" @selected($module === $item)>

                                {{ $item }}

                            </option>
                        @endforeach

                    </select>

                </div>


                {{-- Button --}}
                <div class="flex items-end md:col-span-4">

                    <div class="flex w-full justify-end gap-3">

                        <a href="{{ route('activity-logs.index') }}"
                            class="rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50">

                            Reset

                        </a>

                        <button type="submit"
                            class="rounded-xl bg-[#8F348E] px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#752c74]">

                            Terapkan Filter

                        </button>

                    </div>

                </div>

            </form>

        </div>


        {{-- Activity Table --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-100 px-5 py-4">

                <div class="flex items-center justify-between">

                    <div>

                        <h3 class="font-bold text-slate-900">
                            Aktivitas Sistem
                        </h3>

                        <p class="mt-1 text-xs text-slate-400">
                            {{ $logs->total() }} aktivitas tercatat
                        </p>

                    </div>

                </div>

            </div>


            <div class="overflow-x-auto">

                <table class="w-full min-w-[1000px]">

                    <thead class="bg-slate-50">

                        <tr>

                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                Waktu
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                User
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                Aktivitas
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                Modul
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                IP Address
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-slate-100">

                        @forelse($logs as $log)
                            <tr class="transition hover:bg-slate-50">

                                {{-- Waktu --}}
                                <td class="whitespace-nowrap px-6 py-4">

                                    <p class="text-sm font-semibold text-slate-700">

                                        {{ $log->created_at?->format('d M Y') ?? '-' }}

                                    </p>

                                    <p class="mt-1 text-xs text-slate-400">

                                        {{ $log->created_at?->format('H:i:s') ?? '-' }}

                                    </p>

                                </td>


                                {{-- User --}}
                                <td class="px-6 py-4">

                                    <div class="flex items-center gap-3">

                                        <div
                                            class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[#8F348E]/10 text-sm font-bold text-[#8F348E]">

                                            {{ strtoupper(substr($log->user?->name ?? 'S', 0, 1)) }}

                                        </div>

                                        <div>

                                            <p class="text-sm font-semibold text-slate-700">

                                                {{ $log->user?->name ?? 'System' }}

                                            </p>

                                            <p class="text-xs text-slate-400">

                                                {{ $log->user?->email ?? '-' }}

                                            </p>

                                        </div>

                                    </div>

                                </td>


                                {{-- Aktivitas --}}
                                <td class="px-6 py-4">

                                    @php

                                        $badge = match ($log->action) {
                                            'CREATE' => 'bg-emerald-50 text-emerald-600',

                                            'UPDATE' => 'bg-blue-50 text-blue-600',

                                            'DELETE' => 'bg-red-50 text-red-600',

                                            'LOGIN' => 'bg-purple-50 text-purple-600',

                                            'LOGOUT' => 'bg-slate-100 text-slate-600',

                                            'APPROVE' => 'bg-emerald-50 text-emerald-600',

                                            'REJECT' => 'bg-red-50 text-red-600',

                                            'MUTATION' => 'bg-orange-50 text-orange-600',

                                            'MAINTENANCE' => 'bg-yellow-50 text-yellow-600',

                                            'EXPORT' => 'bg-cyan-50 text-cyan-600',

                                            default => 'bg-slate-100 text-slate-600',
                                        };

                                    @endphp


                                    <div class="flex flex-col items-start gap-2">

                                        <span
                                            class="rounded-full px-2.5 py-1 text-[10px] font-bold tracking-wide {{ $badge }}">

                                            {{ $log->action }}

                                        </span>

                                        <p class="max-w-md text-sm text-slate-600">

                                            {{ $log->description }}

                                        </p>

                                    </div>

                                </td>


                                {{-- Module --}}
                                <td class="px-6 py-4">

                                    <span
                                        class="inline-flex rounded-lg bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-600">

                                        {{ $log->module }}

                                    </span>

                                </td>


                                {{-- IP --}}
                                <td class="px-6 py-4">

                                    <span class="font-mono text-xs text-slate-500">

                                        {{ $log->ip_address ?? '-' }}

                                    </span>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5" class="px-6 py-16 text-center">

                                    <div class="mx-auto max-w-sm">

                                        <div
                                            class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100">

                                            <svg class="h-7 w-7 text-slate-400" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">

                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z" />

                                            </svg>

                                        </div>

                                        <h4 class="mt-4 font-bold text-slate-700">
                                            Belum Ada Aktivitas
                                        </h4>

                                        <p class="mt-1 text-sm text-slate-400">
                                            Aktivitas pengguna akan muncul di halaman ini.
                                        </p>

                                    </div>

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- Pagination --}}
            @if ($logs->hasPages())
                <div class="border-t border-slate-100 px-5 py-4">

                    {{ $logs->links() }}

                </div>
            @endif

        </div>

    </div>

@endsection
