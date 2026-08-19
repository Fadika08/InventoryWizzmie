@extends('layouts.app')

@section('title', 'Inventaris')

@section('page-title', 'Inventaris')

@section('content')

    <div class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

            <div>

                <p class="text-sm font-semibold text-[#8F348E]">
                    Data Inventaris
                </p>

                <h2 class="mt-1 text-2xl font-bold text-slate-900">
                    Inventaris Wizzmie
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Kelola seluruh data aset dan inventaris.
                </p>

            </div>
            <div class="flex flex-col gap-3 sm:flex-row">
                <a href="{{ route('inventory.scanner') }}"
                    class="inline-flex items-center rounded-xl bg-[#DF3C95] px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#c92d83]">Scan
                    Barcode
                </a><a href="{{ route('inventory.create') }}"
                    class="inline-flex items-center justify-center rounded-xl bg-[#8F348E] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#752c74]">

                    + Tambah Inventaris

                </a>
            </div>



        </div>


        {{-- Alert --}}
        @if (session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('success') }}
            </div>
        @endif


        {{-- Filter --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

            <form method="GET" action="{{ route('inventory.index') }}" class="grid gap-4 md:grid-cols-2 lg:grid-cols-5">

                <div class="lg:col-span-2">

                    <label class="mb-1.5 block text-xs font-semibold text-slate-500">
                        Pencarian
                    </label>

                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Kode, nama, barcode, serial..."
                        class="w-full rounded-xl border-slate-200 text-sm focus:border-[#8F348E] focus:ring-[#8F348E]">

                </div>


                <div>

                    <label class="mb-1.5 block text-xs font-semibold text-slate-500">
                        Kategori
                    </label>

                    <select name="category_id"
                        class="w-full rounded-xl border-slate-200 text-sm focus:border-[#8F348E] focus:ring-[#8F348E]">

                        <option value="">
                            Semua
                        </option>

                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>

                                {{ $category->name }}

                            </option>
                        @endforeach

                    </select>

                </div>


                <div>

                    <label class="mb-1.5 block text-xs font-semibold text-slate-500">
                        Lokasi
                    </label>

                    <select name="location_type"
                        class="w-full rounded-xl border-slate-200 text-sm focus:border-[#8F348E] focus:ring-[#8F348E]">

                        <option value="">
                            Semua
                        </option>

                        <option value="head_office" @selected(request('location_type') === 'head_office')>

                            Head Office

                        </option>

                        <option value="outlet" @selected(request('location_type') === 'outlet')>

                            Outlet

                        </option>

                    </select>

                </div>


                <div>

                    <label class="mb-1.5 block text-xs font-semibold text-slate-500">
                        Status
                    </label>

                    <select name="status"
                        class="w-full rounded-xl border-slate-200 text-sm focus:border-[#8F348E] focus:ring-[#8F348E]">

                        <option value="">
                            Semua
                        </option>

                        <option value="active" @selected(request('status') === 'active')>
                            Aktif
                        </option>

                        <option value="maintenance" @selected(request('status') === 'maintenance')>
                            Maintenance
                        </option>

                        <option value="borrowed" @selected(request('status') === 'borrowed')>
                            Dipinjam
                        </option>

                        <option value="lost" @selected(request('status') === 'lost')>
                            Hilang
                        </option>

                        <option value="disposed" @selected(request('status') === 'disposed')>
                            Dihapus
                        </option>

                    </select>

                </div>


                <div class="flex gap-2 md:col-span-2 lg:col-span-5">

                    <button type="submit" class="rounded-xl bg-slate-800 px-5 py-2.5 text-sm font-semibold text-white">

                        Filter

                    </button>

                    <a href="{{ route('inventory.index') }}"
                        class="rounded-xl border border-slate-200 px-5 py-2.5 text-sm font-semibold text-slate-600">

                        Reset

                    </a>

                </div>

            </form>

        </div>


        {{-- Table --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="overflow-x-auto">

                <table class="min-w-[1100px] w-full">

                    <thead class="border-b border-slate-200 bg-slate-50">

                        <tr>

                            <th class="px-5 py-4 text-left text-xs font-bold uppercase text-slate-500">
                                Inventaris
                            </th>

                            <th class="px-5 py-4 text-left text-xs font-bold uppercase text-slate-500">
                                Barang
                            </th>

                            <th class="px-5 py-4 text-left text-xs font-bold uppercase text-slate-500">
                                Kategori
                            </th>

                            <th class="px-5 py-4 text-left text-xs font-bold uppercase text-slate-500">
                                Lokasi
                            </th>

                            <th class="px-5 py-4 text-left text-xs font-bold uppercase text-slate-500">
                                Kondisi
                            </th>

                            <th class="px-5 py-4 text-left text-xs font-bold uppercase text-slate-500">
                                Status
                            </th>

                            <th class="px-5 py-4 text-right text-xs font-bold uppercase text-slate-500">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-slate-100">

                        @forelse($inventories as $inventory)

                            <tr class="transition hover:bg-slate-50">

                                {{-- Code --}}
                                <td class="px-5 py-4">

                                    <p class="font-semibold text-[#8F348E]">
                                        {{ $inventory->inventory_code }}
                                    </p>

                                    <p class="mt-1 text-xs text-slate-400">
                                        {{ $inventory->barcode }}
                                    </p>

                                </td>


                                {{-- Name --}}
                                <td class="px-5 py-4">

                                    <p class="font-semibold text-slate-800">
                                        {{ $inventory->name }}
                                    </p>

                                    @if ($inventory->brand || $inventory->model)
                                        <p class="mt-1 text-xs text-slate-400">

                                            {{ $inventory->brand }}

                                            @if ($inventory->model)
                                                {{ $inventory->model }}
                                            @endif

                                        </p>
                                    @endif

                                </td>


                                {{-- Category --}}
                                <td class="px-5 py-4">

                                    <span class="text-sm font-medium text-slate-700">
                                        {{ $inventory->category->name }}
                                    </span>

                                </td>


                                {{-- Location --}}
                                <td class="px-5 py-4">

                                    @if ($inventory->location_type === 'head_office')
                                        <p class="text-sm font-semibold text-slate-700">
                                            Head Office
                                        </p>

                                        <p class="text-xs text-slate-400">

                                            {{ $inventory->department?->name }}

                                            @if ($inventory->room)
                                                · {{ $inventory->room->name }}
                                            @endif

                                        </p>
                                    @else
                                        <p class="text-sm font-semibold text-slate-700">
                                            {{ $inventory->outlet?->name ?? '-' }}
                                        </p>

                                        <p class="text-xs text-slate-400">
                                            Outlet
                                        </p>
                                    @endif

                                </td>


                                {{-- Condition --}}
                                <td class="px-5 py-4">

                                    @php
                                        $conditionLabels = [
                                            'good' => 'Baik',
                                            'minor_damage' => 'Kerusakan Ringan',
                                            'damaged' => 'Rusak',
                                            'lost' => 'Hilang',
                                        ];
                                    @endphp

                                    <span class="text-sm text-slate-600">
                                        {{ $conditionLabels[$inventory->condition_status] ?? $inventory->condition_status }}
                                    </span>

                                </td>


                                {{-- Status --}}
                                <td class="px-5 py-4">

                                    @php
                                        $statusLabels = [
                                            'active' => 'Aktif',
                                            'maintenance' => 'Maintenance',
                                            'borrowed' => 'Dipinjam',
                                            'lost' => 'Hilang',
                                            'disposed' => 'Dihapus',
                                        ];
                                    @endphp

                                    @if ($inventory->status === 'active')
                                        <span
                                            class="rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-600">
                                            {{ $statusLabels[$inventory->status] }}
                                        </span>
                                    @elseif($inventory->status === 'maintenance')
                                        <span
                                            class="rounded-full bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-600">
                                            {{ $statusLabels[$inventory->status] }}
                                        </span>
                                    @else
                                        <span
                                            class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600">
                                            {{ $statusLabels[$inventory->status] ?? $inventory->status }}
                                        </span>
                                    @endif

                                </td>


                                {{-- Action --}}
                                <td class="px-5 py-4">

                                    <div class="flex justify-end gap-3">

                                        <a href="{{ route('inventory.show', $inventory) }}"
                                            class="text-sm font-semibold text-slate-500 hover:text-[#8F348E]">

                                            Detail

                                        </a>

                                        <a href="{{ route('inventory.edit', $inventory) }}"
                                            class="text-sm font-semibold text-[#8F348E]">

                                            Edit

                                        </a>

                                        <form method="POST" action="{{ route('inventory.destroy', $inventory) }}"
                                            onsubmit="return confirm('Inventaris akan diarsipkan. Lanjutkan?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="text-sm font-semibold text-[#E94025]">

                                                Arsipkan

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="7" class="px-5 py-16 text-center">

                                    <p class="font-semibold text-slate-700">
                                        Belum ada inventaris
                                    </p>

                                    <p class="mt-1 text-sm text-slate-400">
                                        Data inventaris akan tampil di sini.
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            @if ($inventories->hasPages())
                <div class="border-t border-slate-100 px-5 py-4">

                    {{ $inventories->links() }}

                </div>
            @endif

        </div>

    </div>

@endsection
