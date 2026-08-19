@extends('layouts.app')

@section('title', 'Detail Inventaris')

@section('page-title', 'Detail Inventaris')

@section('content')

    <div class="mx-auto max-w-6xl space-y-6">

        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>

                <a href="{{ route('inventory.index') }}" class="text-sm font-semibold text-[#8F348E] hover:underline">

                    ← Kembali ke Inventaris

                </a>

                <h2 class="mt-3 text-2xl font-bold text-slate-900">
                    Detail Inventaris
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Informasi lengkap mengenai aset inventaris.
                </p>

            </div>


            <div class="flex flex-wrap gap-2">

                <a href="{{ route('inventory.edit', $inventory) }}"
                    class="rounded-xl bg-[#8F348E] px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#752c74]">

                    Edit Inventaris

                </a>

                <form method="POST" action="{{ route('inventory.destroy', $inventory) }}"
                    onsubmit="return confirm('Inventaris ini akan diarsipkan. Lanjutkan?')">

                    @csrf
                    @method('DELETE')

                    <button type="submit"
                        class="rounded-xl bg-[#E94025] px-5 py-2.5 text-sm font-semibold text-white hover:bg-red-700">

                        Arsipkan

                    </button>

                </form>

            </div>

        </div>


        {{-- Success --}}
        @if (session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">

                {{ session('success') }}

            </div>
        @endif


        {{-- Main Card --}}
        <div class="grid gap-6 lg:grid-cols-4">

            {{-- QR Code --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                <div class="text-center">

                    <h3 class="font-bold text-slate-900">
                        QR Code Inventaris
                    </h3>

                    <p class="mt-1 text-xs text-slate-400">
                        Scan untuk melihat detail inventaris
                    </p>

                    <div class="mt-5 flex justify-center">

                        {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(220)->margin(2)->generate(route('inventory.public', $inventory->public_code)) !!}

                    </div>

                    <p class="mt-4 text-xs text-slate-400">
                        {{ $inventory->inventory_code }}
                    </p>

                </div>

            </div>
            {{-- Foto --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                <div class="aspect-square overflow-hidden rounded-2xl bg-slate-100">

                    @if ($inventory->primary_photo)
                        <img src="{{ asset('storage/' . $inventory->primary_photo) }}" alt="{{ $inventory->name }}"
                            class="h-full w-full object-cover">
                    @else
                        <div class="flex h-full items-center justify-center">

                            <div class="text-center">

                                <div
                                    class="mx-auto flex h-20 w-20 items-center justify-center rounded-2xl bg-gradient-to-br from-[#8F348E] to-[#DF3C95] text-3xl font-bold text-white">

                                    {{ strtoupper(substr($inventory->name, 0, 1)) }}

                                </div>

                                <p class="mt-4 text-sm text-slate-400">
                                    Tidak ada foto
                                </p>

                            </div>

                        </div>
                    @endif

                </div>


                {{-- Code --}}
                <div class="mt-5 rounded-xl bg-slate-50 p-4">

                    <p class="text-xs font-medium text-slate-400">
                        Kode Inventaris
                    </p>

                    <p class="mt-1 text-lg font-bold text-[#8F348E]">
                        {{ $inventory->inventory_code }}
                    </p>

                    <p class="mt-1 text-xs text-slate-400">
                        Barcode: {{ $inventory->barcode }}
                    </p>

                </div>

            </div>


            {{-- Basic Information --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm lg:col-span-2">

                <div class="flex items-start justify-between gap-4">

                    <div>

                        <p class="text-xs font-bold uppercase tracking-wider text-[#8F348E]">
                            {{ $inventory->category?->name ?? 'Tanpa Kategori' }}
                        </p>

                        <h3 class="mt-2 text-2xl font-bold text-slate-900">
                            {{ $inventory->name }}
                        </h3>

                        @if ($inventory->brand || $inventory->model)

                            <p class="mt-2 text-sm text-slate-500">

                                {{ $inventory->brand }}

                                @if ($inventory->brand && $inventory->model)
                                    ·
                                @endif

                                {{ $inventory->model }}

                            </p>

                        @endif

                    </div>


                    @php
                        $statusLabels = [
                            'active' => 'Aktif',
                            'maintenance' => 'Maintenance',
                            'borrowed' => 'Dipinjam',
                            'lost' => 'Hilang',
                            'disposed' => 'Dihapus',
                        ];
                    @endphp

                    <span
                        class="shrink-0 rounded-full px-3 py-1.5 text-xs font-bold
                    @if ($inventory->status === 'active') bg-emerald-50 text-emerald-600
                    @elseif($inventory->status === 'maintenance')
                        bg-amber-50 text-amber-600
                    @elseif($inventory->status === 'lost')
                        bg-red-50 text-red-600
                    @else
                        bg-slate-100 text-slate-600 @endif">

                        {{ $statusLabels[$inventory->status] ?? $inventory->status }}

                    </span>

                </div>


                <div class="my-6 border-t border-slate-100"></div>


                {{-- Information Grid --}}
                <div class="grid gap-x-8 gap-y-6 sm:grid-cols-2">

                    <div>

                        <p class="text-xs font-medium text-slate-400">
                            Serial Number
                        </p>

                        <p class="mt-1 text-sm font-semibold text-slate-700">
                            {{ $inventory->serial_number ?: '-' }}
                        </p>

                    </div>


                    <div>

                        <p class="text-xs font-medium text-slate-400">
                            Barcode
                        </p>

                        <p class="mt-1 text-sm font-semibold text-slate-700">
                            {{ $inventory->barcode }}
                        </p>

                    </div>


                    <div>

                        <p class="text-xs font-medium text-slate-400">
                            Kondisi
                        </p>

                        @php
                            $conditionLabels = [
                                'good' => 'Baik',
                                'minor_damage' => 'Kerusakan Ringan',
                                'damaged' => 'Rusak',
                                'lost' => 'Hilang',
                            ];
                        @endphp

                        <p class="mt-1 text-sm font-semibold text-slate-700">
                            {{ $conditionLabels[$inventory->condition_status] ?? $inventory->condition_status }}
                        </p>

                    </div>


                    <div>

                        <p class="text-xs font-medium text-slate-400">
                            Lokasi
                        </p>

                        <p class="mt-1 text-sm font-semibold text-slate-700">

                            @if ($inventory->location_type === 'head_office')
                                Head Office
                            @else
                                Outlet
                            @endif

                        </p>

                    </div>

                </div>

            </div>

        </div>


        {{-- Location --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

            <div class="flex items-center gap-3">

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#8F348E]/10 text-[#8F348E]">

                    📍

                </div>

                <div>

                    <h3 class="font-bold text-slate-900">
                        Lokasi Inventaris
                    </h3>

                    <p class="text-xs text-slate-400">
                        Lokasi terakhir aset terdaftar.
                    </p>

                </div>

            </div>


            <div class="mt-6 grid gap-5 md:grid-cols-3">

                @if ($inventory->location_type === 'head_office')
                    <div class="rounded-xl bg-slate-50 p-4">

                        <p class="text-xs text-slate-400">
                            Lokasi
                        </p>

                        <p class="mt-1 font-semibold text-slate-700">
                            Head Office
                        </p>

                    </div>


                    <div class="rounded-xl bg-slate-50 p-4">

                        <p class="text-xs text-slate-400">
                            Divisi
                        </p>

                        <p class="mt-1 font-semibold text-slate-700">
                            {{ $inventory->department?->name ?? '-' }}
                        </p>

                    </div>


                    <div class="rounded-xl bg-slate-50 p-4">

                        <p class="text-xs text-slate-400">
                            Ruangan
                        </p>

                        <p class="mt-1 font-semibold text-slate-700">
                            {{ $inventory->room?->name ?? '-' }}
                        </p>

                    </div>
                @else
                    <div class="rounded-xl bg-slate-50 p-4 md:col-span-3">

                        <p class="text-xs text-slate-400">
                            Outlet
                        </p>

                        <p class="mt-1 font-semibold text-slate-700">
                            {{ $inventory->outlet?->code }}
                            -
                            {{ $inventory->outlet?->name }}
                        </p>

                    </div>
                @endif

            </div>

        </div>


        {{-- Specification --}}
        <div class="grid gap-6 lg:grid-cols-2">

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                <h3 class="font-bold text-slate-900">
                    Spesifikasi
                </h3>

                <div class="mt-5 rounded-xl bg-slate-50 p-4">

                    <p class="whitespace-pre-line text-sm leading-7 text-slate-600">

                        {{ $inventory->specification ?: 'Tidak ada spesifikasi.' }}

                    </p>

                </div>

            </div>


            {{-- Purchase --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                <h3 class="font-bold text-slate-900">
                    Pembelian & Garansi
                </h3>

                <div class="mt-5 space-y-5">

                    <div>

                        <p class="text-xs text-slate-400">
                            Tanggal Pembelian
                        </p>

                        <p class="mt-1 font-semibold text-slate-700">

                            {{ $inventory->purchase_date?->format('d F Y') ?? '-' }}

                        </p>

                    </div>


                    <div>

                        <p class="text-xs text-slate-400">
                            Harga Pembelian
                        </p>

                        <p class="mt-1 font-semibold text-slate-700">

                            @if ($inventory->purchase_price !== null)
                                Rp {{ number_format($inventory->purchase_price, 0, ',', '.') }}
                            @else
                                -
                            @endif

                        </p>

                    </div>


                    <div>

                        <p class="text-xs text-slate-400">
                            Masa Garansi
                        </p>

                        <p class="mt-1 font-semibold text-slate-700">

                            @if ($inventory->warranty_start && $inventory->warranty_end)
                                {{ $inventory->warranty_start->format('d M Y') }}
                                -
                                {{ $inventory->warranty_end->format('d M Y') }}
                            @else
                                Tidak tersedia
                            @endif

                        </p>

                    </div>

                </div>

            </div>

        </div>


        {{-- Description --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

            <h3 class="font-bold text-slate-900">
                Keterangan
            </h3>

            <p class="mt-4 whitespace-pre-line text-sm leading-7 text-slate-600">

                {{ $inventory->description ?: 'Tidak ada keterangan tambahan.' }}

            </p>

        </div>


        {{-- Audit --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

            <h3 class="font-bold text-slate-900">
                Informasi Sistem
            </h3>

            <div class="mt-5 grid gap-5 md:grid-cols-3">

                <div>

                    <p class="text-xs text-slate-400">
                        Dibuat Oleh
                    </p>

                    <p class="mt-1 text-sm font-semibold text-slate-700">
                        {{ $inventory->creator?->name ?? '-' }}
                    </p>

                </div>


                <div>

                    <p class="text-xs text-slate-400">
                        Terakhir Diubah Oleh
                    </p>

                    <p class="mt-1 text-sm font-semibold text-slate-700">
                        {{ $inventory->updater?->name ?? '-' }}
                    </p>

                </div>


                <div>

                    <p class="text-xs text-slate-400">
                        Terakhir Diperbarui
                    </p>

                    <p class="mt-1 text-sm font-semibold text-slate-700">

                        {{ $inventory->updated_at?->format('d M Y H:i') }}

                    </p>

                </div>

            </div>

        </div>

    </div>

@endsection
