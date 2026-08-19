<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        {{ $inventory->name }} - Wizzmie
    </title>

    @vite(['resources/css/app.css'])

</head>


<body class="min-h-screen bg-slate-50">

    <div class="mx-auto max-w-3xl px-4 py-8">

        {{-- Header --}}
        <div class="text-center">

            <h1 class="text-2xl font-bold text-[#8F348E]">
                WIZZ MIE
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Informasi Inventaris
            </p>

        </div>


        {{-- Card --}}
        <div class="mt-6 overflow-hidden rounded-3xl bg-white shadow-lg">

            {{-- Foto --}}
            <div class="aspect-video bg-slate-100">

                @if ($inventory->primary_photo)
                    <img src="{{ asset('storage/' . $inventory->primary_photo) }}" alt="{{ $inventory->name }}"
                        class="h-full w-full object-cover">
                @else
                    <div class="flex h-full items-center justify-center">

                        <div class="text-center">

                            <div
                                class="mx-auto flex h-20 w-20 items-center justify-center rounded-2xl bg-[#8F348E] text-3xl font-bold text-white">

                                {{ strtoupper(substr($inventory->name, 0, 1)) }}

                            </div>

                            <p class="mt-3 text-sm text-slate-400">
                                Tidak ada foto
                            </p>

                        </div>

                    </div>
                @endif

            </div>


            <div class="p-6">

                {{-- Inventory Code --}}
                <div>

                    <p class="text-xs font-semibold uppercase tracking-wider text-[#8F348E]">
                        {{ $inventory->inventory_code }}
                    </p>

                    <h2 class="mt-2 text-2xl font-bold text-slate-900">
                        {{ $inventory->name }}
                    </h2>

                </div>


                {{-- Information --}}
                <div class="mt-6 grid gap-4 sm:grid-cols-2">

                    <div class="rounded-xl bg-slate-50 p-4">

                        <p class="text-xs text-slate-400">
                            Kategori
                        </p>

                        <p class="mt-1 font-semibold text-slate-700">
                            {{ $inventory->category?->name ?? '-' }}
                        </p>

                    </div>


                    <div class="rounded-xl bg-slate-50 p-4">

                        <p class="text-xs text-slate-400">
                            Brand / Model
                        </p>

                        <p class="mt-1 font-semibold text-slate-700">

                            {{ $inventory->brand ?? '-' }}

                            @if ($inventory->model)
                                / {{ $inventory->model }}
                            @endif

                        </p>

                    </div>


                    <div class="rounded-xl bg-slate-50 p-4">

                        <p class="text-xs text-slate-400">
                            Serial Number
                        </p>

                        <p class="mt-1 font-semibold text-slate-700">
                            {{ $inventory->serial_number ?? '-' }}
                        </p>

                    </div>


                    <div class="rounded-xl bg-slate-50 p-4">

                        <p class="text-xs text-slate-400">
                            Barcode
                        </p>

                        <p class="mt-1 font-semibold text-slate-700">
                            {{ $inventory->barcode }}
                        </p>

                    </div>

                </div>


                {{-- Location --}}
                <div class="mt-6">

                    <h3 class="font-bold text-slate-900">
                        Lokasi
                    </h3>

                    <div class="mt-3 rounded-xl bg-slate-50 p-4">

                        @if ($inventory->location_type === 'head_office')

                            <p class="font-semibold text-slate-700">
                                Head Office
                            </p>

                            <p class="mt-1 text-sm text-slate-500">

                                {{ $inventory->department?->name ?? '-' }}

                                @if ($inventory->room)
                                    · {{ $inventory->room->name }}
                                @endif

                            </p>
                        @else
                            <p class="font-semibold text-slate-700">
                                {{ $inventory->outlet?->name ?? '-' }}
                            </p>

                            <p class="mt-1 text-sm text-slate-500">
                                {{ $inventory->outlet?->code ?? '-' }}
                            </p>

                        @endif

                    </div>

                </div>


                {{-- Specification --}}
                <div class="mt-6">

                    <h3 class="font-bold text-slate-900">
                        Spesifikasi
                    </h3>

                    <p class="mt-3 whitespace-pre-line text-sm leading-7 text-slate-600">

                        {{ $inventory->specification ?: '-' }}

                    </p>

                </div>


                {{-- Status --}}
                <div class="mt-6">

                    <h3 class="font-bold text-slate-900">
                        Status
                    </h3>

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
                        class="mt-3 inline-flex rounded-full bg-emerald-50 px-4 py-2 text-sm font-semibold text-emerald-600">

                        {{ $statusLabels[$inventory->status] ?? $inventory->status }}

                    </span>

                </div>

            </div>

        </div>


        <p class="mt-6 text-center text-xs text-slate-400">

            Wizzmie Inventory Management System

        </p>

    </div>

</body>

</html>
