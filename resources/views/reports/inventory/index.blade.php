@extends('layouts.app')

@section('title', 'Report Inventaris')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

        <div>
            <h1 class="text-2xl font-bold text-slate-900">
                Report Inventaris
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Analisis dan cetak laporan inventaris berdasarkan periode dan lokasi.
            </p>
        </div>

        <div class="flex flex-wrap gap-2">

            <a
                href="{{ route('reports.inventory.excel', request()->query()) }}"
                class="rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-emerald-700">

                Export Excel
            </a>

            <a
                href="{{ route('reports.inventory.pdf', request()->query()) }}"
                class="rounded-xl bg-red-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-red-700">

                Export PDF
            </a>

        </div>

    </div>


    {{-- STATISTICS --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-5">

        @php

            $cards = [

                [
                    'title' => 'Total Inventaris',
                    'value' => $statistics['total'],
                ],

                [
                    'title' => 'Head Office',
                    'value' => $statistics['head_office'],
                ],

                [
                    'title' => 'Outlet',
                    'value' => $statistics['outlet'],
                ],

                [
                    'title' => 'Kondisi Baik',
                    'value' => $statistics['baik'],
                ],

                [
                    'title' => 'Kondisi Rusak',
                    'value' => $statistics['rusak'],
                ],

            ];

        @endphp


        @foreach($cards as $card)

            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                <p class="text-sm text-slate-500">
                    {{ $card['title'] }}
                </p>

                <p class="mt-2 text-3xl font-bold text-slate-900">
                    {{ number_format($card['value']) }}
                </p>

            </div>

        @endforeach

    </div>


    {{-- FILTER --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

        <div class="mb-6">

            <h2 class="text-lg font-bold text-slate-900">
                Filter Report
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Tentukan data yang ingin ditampilkan pada laporan.
            </p>

        </div>


        <form
            method="GET"
            action="{{ route('reports.inventory.index') }}"
            class="space-y-5">

            {{-- SEARCH --}}
            <div>

                <label
                    for="search"
                    class="mb-2 block text-sm font-semibold text-slate-700">

                    Pencarian

                </label>

                <input
                    type="text"
                    id="search"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Kode, nama barang, barcode, serial number..."
                    class="w-full rounded-xl border-slate-200 px-4 py-3 text-sm focus:border-[#8F348E] focus:ring-[#8F348E]">

            </div>


            {{-- DATE --}}
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                <div>

                    <label
                        for="date_from"
                        class="mb-2 block text-sm font-semibold text-slate-700">

                        Dari Tanggal

                    </label>

                    <input
                        type="date"
                        id="date_from"
                        name="date_from"
                        value="{{ request('date_from') }}"
                        class="w-full rounded-xl border-slate-200 px-4 py-3 text-sm">

                </div>


                <div>

                    <label
                        for="date_to"
                        class="mb-2 block text-sm font-semibold text-slate-700">

                        Sampai Tanggal

                    </label>

                    <input
                        type="date"
                        id="date_to"
                        name="date_to"
                        value="{{ request('date_to') }}"
                        class="w-full rounded-xl border-slate-200 px-4 py-3 text-sm">

                </div>

            </div>


            {{-- LOCATION --}}
            <div>

                <label
                    for="location_type"
                    class="mb-2 block text-sm font-semibold text-slate-700">

                    Lokasi

                </label>

                <select
                    id="location_type"
                    name="location_type"
                    class="w-full rounded-xl border-slate-200 px-4 py-3 text-sm">

                    <option value="">
                        Semua Lokasi
                    </option>

                    <option
                        value="head_office"
                        @selected(request('location_type') === 'head_office')>

                        Semua Head Office
                    </option>

                    <option
                        value="outlet"
                        @selected(request('location_type') === 'outlet')>

                        Semua Outlet
                    </option>

                </select>

            </div>


            {{-- OUTLET + DIVISION --}}
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                <div>

                    <label
                        for="outlet_id"
                        class="mb-2 block text-sm font-semibold text-slate-700">

                        Outlet

                    </label>

                    <select
                        id="outlet_id"
                        name="outlet_id"
                        class="w-full rounded-xl border-slate-200 px-4 py-3 text-sm">

                        <option value="all">
                            Semua Outlet
                        </option>

                        @foreach($outlets as $outlet)

                            <option
                                value="{{ $outlet->id }}"
                                @selected(
                                    (string) request('outlet_id')
                                    ===
                                    (string) $outlet->id
                                )>

                                {{ $outlet->code }}
                                -
                                {{ $outlet->name }}

                            </option>

                        @endforeach

                    </select>

                </div>


                <div>

                    <label
                        for="department_id"
                        class="mb-2 block text-sm font-semibold text-slate-700">

                        Divisi

                    </label>

                    <select
                        id="department_id"
                        name="department_id"
                        class="w-full rounded-xl border-slate-200 px-4 py-3 text-sm">

                        <option value="all">
                            Semua Divisi
                        </option>

                        @foreach($departments as $department)

                            <option
                                value="{{ $department->id }}"
                                @selected(
                                    (string) request('department_id')
                                    ===
                                    (string) $department->id
                                )>

                                {{ $department->name }}

                            </option>

                        @endforeach

                    </select>

                </div>

            </div>


            {{-- CATEGORY + STATUS --}}
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                <div>

                    <label
                        for="category_id"
                        class="mb-2 block text-sm font-semibold text-slate-700">

                        Kategori

                    </label>

                    <select
                        id="category_id"
                        name="category_id"
                        class="w-full rounded-xl border-slate-200 px-4 py-3 text-sm">

                        <option value="all">
                            Semua Kategori
                        </option>

                        @foreach($categories as $category)

                            <option
                                value="{{ $category->id }}"
                                @selected(
                                    (string) request('category_id')
                                    ===
                                    (string) $category->id
                                )>

                                {{ $category->code }}
                                -
                                {{ $category->name }}

                            </option>

                        @endforeach

                    </select>

                </div>


                <div>

                    <label
                        for="status"
                        class="mb-2 block text-sm font-semibold text-slate-700">

                        Status

                    </label>

                    <select
                        id="status"
                        name="status"
                        class="w-full rounded-xl border-slate-200 px-4 py-3 text-sm">

                        <option value="all">
                            Semua Status
                        </option>

                        <option
                            value="active"
                            @selected(request('status') === 'active')>

                            Aktif

                        </option>

                        <option
                            value="inactive"
                            @selected(request('status') === 'inactive')>

                            Tidak Aktif

                        </option>

                    </select>

                </div>

            </div>


            {{-- CONDITION --}}
            <div>

                <label
                    for="condition_status"
                    class="mb-2 block text-sm font-semibold text-slate-700">

                    Kondisi

                </label>

                <select
                    id="condition_status"
                    name="condition_status"
                    class="w-full rounded-xl border-slate-200 px-4 py-3 text-sm">

                    <option value="all">
                        Semua Kondisi
                    </option>

                    <option
                        value="good"
                        @selected(request('condition_status') === 'good')>

                        Baik

                    </option>

                    <option
                        value="damaged"
                        @selected(request('condition_status') === 'damaged')>

                        Rusak Ringan

                    </option>

                    <option
                        value="broken"
                        @selected(request('condition_status') === 'broken')>

                        Rusak Berat

                    </option>

                </select>

            </div>


            {{-- BUTTON --}}
            <div class="flex flex-wrap gap-3 pt-2">

                <button
                    type="submit"
                    class="rounded-xl bg-[#8F348E] px-6 py-3 text-sm font-semibold text-white hover:bg-[#752c74]">

                    Terapkan Filter

                </button>


                <a
                    href="{{ route('reports.inventory.index') }}"
                    class="rounded-xl border border-slate-200 bg-white px-6 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">

                    Reset

                </a>

            </div>

        </form>

    </div>


    {{-- TABLE --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="overflow-x-auto">

            <table class="w-full min-w-[1400px] text-left">

                <thead class="bg-slate-50">

                    <tr>

                        <th class="px-5 py-4 text-xs font-bold uppercase">
                            No
                        </th>

                        <th class="px-5 py-4 text-xs font-bold uppercase">
                            Kode
                        </th>

                        <th class="px-5 py-4 text-xs font-bold uppercase">
                            Inventaris
                        </th>

                        <th class="px-5 py-4 text-xs font-bold uppercase">
                            Kategori
                        </th>

                        <th class="px-5 py-4 text-xs font-bold uppercase">
                            Brand / Model
                        </th>

                        <th class="px-5 py-4 text-xs font-bold uppercase">
                            Serial Number
                        </th>

                        <th class="px-5 py-4 text-xs font-bold uppercase">
                            Lokasi
                        </th>

                        <th class="px-5 py-4 text-xs font-bold uppercase">
                            Divisi
                        </th>

                        <th class="px-5 py-4 text-xs font-bold uppercase">
                            Kondisi
                        </th>

                        <th class="px-5 py-4 text-xs font-bold uppercase">
                            Status
                        </th>

                        <th class="px-5 py-4 text-xs font-bold uppercase">
                            Pembelian
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-slate-100">

                    @forelse($items as $item)

                        <tr class="hover:bg-slate-50">

                            <td class="px-5 py-4 text-sm">
                                {{ $items->firstItem() + $loop->index }}
                            </td>

                            <td class="px-5 py-4 text-sm font-semibold">
                                {{ $item->inventory_code }}
                            </td>

                            <td class="px-5 py-4 text-sm">

                                <div class="font-semibold">
                                    {{ $item->name }}
                                </div>

                                @if($item->public_code)

                                    <div class="text-xs text-slate-400">
                                        {{ $item->public_code }}
                                    </div>

                                @endif

                            </td>

                            <td class="px-5 py-4 text-sm">

                                {{ $item->category?->name ?? '-' }}

                            </td>

                            <td class="px-5 py-4 text-sm">

                                {{ $item->brand ?: '-' }}

                                @if($item->model)
                                    / {{ $item->model }}
                                @endif

                            </td>

                            <td class="px-5 py-4 text-sm">
                                {{ $item->serial_number ?: '-' }}
                            </td>

                            <td class="px-5 py-4 text-sm">

                                @if($item->location_type === 'head_office')

                                    <span class="font-semibold">
                                        Head Office
                                    </span>

                                    @if($item->room)
                                        <div class="text-xs text-slate-400">
                                            {{ $item->room->name }}
                                        </div>
                                    @endif

                                @else

                                    <span class="font-semibold">
                                        {{ $item->outlet?->name ?? 'Outlet' }}
                                    </span>

                                @endif

                            </td>

                            <td class="px-5 py-4 text-sm">
                                {{ $item->department?->name ?? '-' }}
                            </td>

                            <td class="px-5 py-4 text-sm">
                                {{ ucfirst($item->condition_status ?? '-') }}
                            </td>

                            <td class="px-5 py-4 text-sm">
                                {{ ucfirst($item->status ?? '-') }}
                            </td>

                            <td class="px-5 py-4 text-sm">
                                {{ $item->purchase_date?->format('d/m/Y') ?? '-' }}
                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="11"
                                class="px-5 py-12 text-center text-sm text-slate-400">

                                Tidak ada data inventaris berdasarkan filter.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        @if($items->hasPages())

            <div class="border-t border-slate-100 p-5">

                {{ $items->links() }}

            </div>

        @endif

    </div>

</div>

@endsection
