@extends('layouts.app')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('content')

    <div class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">

            <div>

                <p class="text-sm font-medium text-[#8F348E]">
                    Inventory Management System
                </p>

                <h2 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">
                    Selamat datang, {{ auth()->user()->name }}
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Pantau dan kelola inventaris Wizzmie secara terpusat.
                </p>

            </div>

            <div>

                <a href="{{ route('inventory.create') }}"
                    class="inline-flex items-center gap-2 rounded-xl bg-[#8F348E] px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#752c74]">

                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16M4 12h16" />
                    </svg>

                    Tambah Inventaris

                </a>

            </div>

        </div>


        {{-- Statistics --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

            {{-- Total --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                <div class="flex items-start justify-between">

                    <div>

                        <p class="text-sm font-medium text-slate-500">
                            Total Inventaris
                        </p>

                        <h3 class="mt-2 text-3xl font-bold text-slate-900">
                            {{ number_format($totalInventory) }}
                        </h3>

                        <p class="mt-2 text-xs text-slate-400">
                            Seluruh barang terdata
                        </p>

                    </div>

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#8F348E]/10 text-[#8F348E]">

                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M4 7h16M4 12h16M4 17h16" />
                        </svg>

                    </div>

                </div>

            </div>


            {{-- Good --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                <div class="flex items-start justify-between">

                    <div>

                        <p class="text-sm font-medium text-slate-500">
                            Kondisi Baik
                        </p>

                        <h3 class="mt-2 text-3xl font-bold text-slate-900">
                            {{ number_format($totalGood) }}
                        </h3>

                        <p class="mt-2 text-xs text-emerald-500">
                            Inventaris dalam kondisi baik
                        </p>

                    </div>

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">

                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>

                    </div>

                </div>

            </div>


            {{-- Maintenance --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                <div class="flex items-start justify-between">

                    <div>

                        <p class="text-sm font-medium text-slate-500">
                            Maintenance
                        </p>

                        <h3 class="mt-2 text-3xl font-bold text-slate-900">
                            {{ number_format($totalMaintenance) }}
                        </h3>

                        <p class="mt-2 text-xs text-[#FAAC3F]">
                            Barang sedang diperbaiki
                        </p>

                    </div>

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#FAAC3F]/10 text-[#FAAC3F]">

                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M11 4h2M12 2v2M6.5 6.5l1.4 1.4M4 12H2M6.5 17.5l1.4-1.4M17.5 17.5l-1.4-1.4M20 12h2M17.5 6.5l-1.4 1.4M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>

                    </div>

                </div>

            </div>


            {{-- Lost --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                <div class="flex items-start justify-between">

                    <div>

                        <p class="text-sm font-medium text-slate-500">
                            Barang Hilang
                        </p>

                        <h3 class="mt-2 text-3xl font-bold text-slate-900">
                            {{ number_format($totalLost) }}
                        </h3>

                        <p class="mt-2 text-xs text-[#E94025]">
                            Membutuhkan perhatian
                        </p>

                    </div>

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#E94025]/10 text-[#E94025]">

                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M12 9v4M12 17h.01M10.3 4.3L2.7 17a2 2 0 001.7 3h15.2a2 2 0 001.7-3L13.7 4.3a2 2 0 00-3.4 0z" />
                        </svg>

                    </div>

                </div>

            </div>

        </div>


        {{-- Main Content --}}
        <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">


            {{-- Inventory Overview --}}
            <div class="xl:col-span-2 rounded-2xl border border-slate-200 bg-white shadow-sm">

                <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">

                    <div>

                        <h3 class="font-semibold text-slate-900">
                            Inventaris Berdasarkan Kategori
                        </h3>

                        <p class="mt-1 text-xs text-slate-400">
                            Distribusi inventaris yang terdaftar
                        </p>

                    </div>

                    <a href="#" class="text-sm font-medium text-[#8F348E] hover:underline">
                        Lihat semua
                    </a>

                </div>


                <div class="p-5">

                    @forelse($inventoryByCategory as $item)
                        @php
                            $percentage = $totalInventory > 0 ? round(($item->total / $totalInventory) * 100) : 0;
                        @endphp

                        <div class="mb-5 last:mb-0">

                            <div class="mb-2 flex items-center justify-between">

                                <div class="flex items-center gap-3">

                                    <div class="h-2.5 w-2.5 rounded-full bg-[#8F348E]"></div>

                                    <span class="text-sm font-medium text-slate-700">
                                        {{ $item->category?->name ?? 'Tanpa Kategori' }}
                                    </span>

                                </div>

                                <div class="flex items-center gap-3">

                                    <span class="text-sm font-semibold text-slate-800">
                                        {{ number_format($item->total) }}
                                    </span>

                                    <span class="text-xs text-slate-400">
                                        {{ $percentage }}%
                                    </span>

                                </div>

                            </div>

                            <div class="h-2 overflow-hidden rounded-full bg-slate-100">

                                <div class="h-full rounded-full bg-gradient-to-r from-[#8F348E] to-[#DF3C95]"
                                    style="width: {{ $percentage }}%">
                                </div>

                            </div>

                        </div>

                    @empty

                        <div class="flex min-h-48 items-center justify-center">

                            <div class="text-center">

                                <div
                                    class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-slate-400">

                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M4 7h16M4 12h16M4 17h16" />
                                    </svg>

                                </div>

                                <p class="mt-3 text-sm font-medium text-slate-600">
                                    Belum ada data inventaris
                                </p>

                                <p class="mt-1 text-xs text-slate-400">
                                    Data akan tampil setelah inventaris ditambahkan.
                                </p>

                            </div>

                        </div>
                    @endforelse

                </div>

            </div>


            {{-- Summary --}}
            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">

                <div class="border-b border-slate-100 px-5 py-4">

                    <h3 class="font-semibold text-slate-900">
                        Ringkasan Sistem
                    </h3>

                    <p class="mt-1 text-xs text-slate-400">
                        Informasi master data
                    </p>

                </div>


                <div class="divide-y divide-slate-100">

                    <div class="flex items-center justify-between px-5 py-4">

                        <div class="flex items-center gap-3">

                            <div
                                class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#8F348E]/10 text-[#8F348E]">

                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M4 19h16M4 19V5a2 2 0 012-2h12a2 2 0 012 2v14" />
                                </svg>

                            </div>

                            <span class="text-sm text-slate-600">
                                Divisi
                            </span>

                        </div>

                        <span class="font-semibold text-slate-800">
                            {{ number_format($totalDepartments) }}
                        </span>

                    </div>


                    <div class="flex items-center justify-between px-5 py-4">

                        <div class="flex items-center gap-3">

                            <div
                                class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#DF3C95]/10 text-[#DF3C95]">

                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M3 21h18M5 21V8l7-5 7 5v13" />
                                </svg>

                            </div>

                            <span class="text-sm text-slate-600">
                                Outlet
                            </span>

                        </div>

                        <span class="font-semibold text-slate-800">
                            {{ number_format($totalOutlets) }}
                        </span>

                    </div>


                    <div class="flex items-center justify-between px-5 py-4">

                        <div class="flex items-center gap-3">

                            <div
                                class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#FAAC3F]/10 text-[#FAAC3F]">

                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M4 7h16M4 12h16M4 17h16" />
                                </svg>

                            </div>

                            <span class="text-sm text-slate-600">
                                Dipinjam
                            </span>

                        </div>

                        <span class="font-semibold text-slate-800">
                            {{ number_format($totalBorrowed) }}
                        </span>

                    </div>


                    <div class="flex items-center justify-between px-5 py-4">

                        <div class="flex items-center gap-3">

                            <div
                                class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#E94025]/10 text-[#E94025]">

                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M12 8v4l3 2M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>

                            </div>

                            <span class="text-sm text-slate-600">
                                Disposed
                            </span>

                        </div>

                        <span class="font-semibold text-slate-800">
                            {{ number_format($totalDisposed) }}
                        </span>

                    </div>

                </div>

            </div>

        </div>


        {{-- Recent Activity --}}
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">

                <div>

                    <h3 class="font-semibold text-slate-900">
                        Aktivitas Terbaru
                    </h3>

                    <p class="mt-1 text-xs text-slate-400">
                        Aktivitas pengguna pada sistem
                    </p>

                </div>

                @if (auth()->user()->isSuperAdmin())
                    <a href="#" class="text-sm font-medium text-[#8F348E] hover:underline">
                        Lihat semua
                    </a>
                @endif

            </div>


            <div class="divide-y divide-slate-100">

                @forelse($recentActivities as $activity)
                    <div class="flex items-center gap-4 px-5 py-4">

                        <div
                            class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[#8F348E]/10 text-[#8F348E]">

                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M12 8v4l3 2M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>

                        </div>


                        <div class="min-w-0 flex-1">

                            <p class="text-sm text-slate-700">

                                <span class="font-semibold">
                                    {{ $activity->user?->name ?? 'System' }}
                                </span>

                                {{ $activity->description ?? $activity->action }}

                            </p>

                            <p class="mt-1 text-xs text-slate-400">

                                {{ $activity->module ?? 'System' }}

                                @if ($activity->created_at)
                                    · {{ $activity->created_at->diffForHumans() }}
                                @endif

                            </p>

                        </div>

                    </div>

                @empty

                    <div class="px-5 py-10 text-center">

                        <div
                            class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-slate-400">

                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M12 8v4l3 2M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>

                        </div>

                        <p class="mt-3 text-sm font-medium text-slate-600">
                            Belum ada aktivitas
                        </p>

                        <p class="mt-1 text-xs text-slate-400">
                            Aktivitas sistem akan muncul di sini.
                        </p>

                    </div>
                @endforelse

            </div>

        </div>

    </div>

@endsection
