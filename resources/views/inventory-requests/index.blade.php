@extends('layouts.app')

@section('title', 'Pengajuan Barang')

@section('content')


        <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h2 class="text-xl font-semibold text-slate-800">
                    Pengajuan Barang
                </h2>

                <p class="text-sm text-slate-500">
                    Kelola dan pantau seluruh pengajuan barang.
                </p>
            </div>

            <a
                href="{{ route('inventory-requests.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#8F348E] px-5 py-3 text-sm font-semibold text-white hover:bg-[#752C74]">

                <span class="text-lg">+</span>
                Buat Pengajuan

            </a>

        </div>



    <div class="py-8">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">


            {{-- SUCCESS --}}

            @if(session('success'))

                <div class="mb-6 rounded-xl border border-green-200 bg-green-50 p-4">

                    <p class="text-sm font-semibold text-green-700">
                        {{ session('success') }}
                    </p>

                </div>

            @endif


            {{-- ERROR --}}

            @if(session('error'))

                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4">

                    <p class="text-sm font-semibold text-red-700">
                        {{ session('error') }}
                    </p>

                </div>

            @endif


            {{-- ===================================================== --}}
            {{-- FILTER --}}
            {{-- ===================================================== --}}

            <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                <form
                    method="GET"
                    action="{{ route('inventory-requests.index') }}"
                    class="grid gap-4 md:grid-cols-3">

                    {{-- SEARCH --}}

                    <div class="md:col-span-2">

                        <label
                            for="search"
                            class="mb-2 block text-sm font-semibold text-slate-700">

                            Cari Pengajuan

                        </label>

                        <input
                            type="text"
                            id="search"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari nomor pengajuan..."
                            class="w-full rounded-xl border-slate-200 px-4 py-3 text-sm focus:border-[#8F348E] focus:ring-[#8F348E]">

                    </div>


                    {{-- STATUS --}}

                <div>

                    <label
                        for="status"
                        class="mb-2 block text-sm font-semibold text-slate-700">

                        Status

                    </label>

                    <select
                        id="status"
                        name="status"
                        class="w-full rounded-xl border-slate-200 px-4 py-3 text-sm focus:border-[#8F348E] focus:ring-[#8F348E]">

                        <option value="">
                            Semua Status
                        </option>

                        <option
                            value="draft"
                            @selected(request('status') === 'draft')>

                            Draft

                        </option>

                        <option
                            value="submitted"
                            @selected(request('status') === 'submitted')>

                            Diajukan

                        </option>

                        <option
                            value="processing"
                            @selected(request('status') === 'processing')>

                            Diproses

                        </option>

                        <option
                            value="approved"
                            @selected(request('status') === 'approved')>

                            Disetujui

                        </option>

                        <option
                            value="rejected"
                            @selected(request('status') === 'rejected')>

                            Ditolak

                        </option>

                        <option
                            value="completed"
                            @selected(request('status') === 'completed')>

                            Selesai

                        </option>

                        <option
                            value="cancelled"
                            @selected(request('status') === 'cancelled')>

                            Dibatalkan

                        </option>

                    </select>

                </div>


                    <div class="md:col-span-3 flex flex-wrap gap-3">

                        <button
                            type="submit"
                            class="rounded-xl bg-[#8F348E] px-5 py-2.5 text-sm font-semibold text-white">

                            Filter

                        </button>


                        <a
                            href="{{ route('inventory-requests.index') }}"
                            class="rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700">

                            Reset

                        </a>

                    </div>

                </form>

            </div>


            {{-- ===================================================== --}}
            {{-- TABLE --}}
            {{-- ===================================================== --}}

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                <div class="overflow-x-auto">

                    <table class="w-full min-w-[1000px]">

                        <thead class="bg-slate-50">

                            <tr>

                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wide text-slate-500">
                                    No
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wide text-slate-500">
                                    Nomor Pengajuan
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wide text-slate-500">
                                    Pemohon
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wide text-slate-500">
                                    Lokasi
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wide text-slate-500">
                                    Jenis
                                </th>

                                <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wide text-slate-500">
                                    Item
                                </th>

                                <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wide text-slate-500">
                                    Status
                                </th>

                                <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wide text-slate-500">
                                    Aksi
                                </th>

                            </tr>

                        </thead>


                        <tbody class="divide-y divide-slate-100">

                            @forelse($requests as $index => $item)

                                @php

                                    $statusClass = match($item->status) {

                                        'pending' =>
                                            'bg-yellow-100 text-yellow-700',

                                        'approved' =>
                                            'bg-green-100 text-green-700',

                                        'rejected' =>
                                            'bg-red-100 text-red-700',

                                        'cancelled' =>
                                            'bg-slate-100 text-slate-600',

                                        'completed' =>
                                            'bg-blue-100 text-blue-700',

                                        default =>
                                            'bg-slate-100 text-slate-600',

                                    };


                                    $statusLabel = match($item->status) {

                                        'pending' =>
                                            'Menunggu',

                                        'approved' =>
                                            'Disetujui',

                                        'rejected' =>
                                            'Ditolak',

                                        'cancelled' =>
                                            'Dibatalkan',

                                        'completed' =>
                                            'Selesai',

                                        default =>
                                            ucfirst($item->status),

                                    };


                                    $typeLabel = match($item->request_type) {

                                        'new_item' =>
                                            'Barang Baru',

                                        'replacement' =>
                                            'Penggantian',

                                        'additional' =>
                                            'Penambahan',

                                        default =>
                                            ucfirst($item->request_type),

                                    };

                                @endphp


                                <tr class="transition hover:bg-slate-50">


                                    {{-- NO --}}

                                    <td class="px-6 py-5">

                                        <span class="text-sm text-slate-500">
                                            {{ $requests->firstItem() + $index }}
                                        </span>

                                    </td>


                                    {{-- NOMOR --}}

                                    <td class="px-6 py-5">

                                        <a
                                            href="{{ route('inventory-requests.show', $item) }}"
                                            class="font-bold text-[#8F348E] hover:underline">

                                            {{ $item->request_number }}

                                        </a>

                                        <p class="mt-1 text-xs text-slate-400">

                                            {{ $item->created_at?->format('d M Y H:i') }}

                                        </p>

                                    </td>


                                    {{-- PEMOHON --}}

                                    <td class="px-6 py-5">

                                        <p class="font-semibold text-slate-800">
                                            {{ $item->requester->name ?? '-' }}
                                        </p>

                                    </td>


                                    {{-- LOKASI --}}

                                    <td class="px-6 py-5">

                                        @if($item->outlet)

                                            <p class="font-semibold text-slate-800">
                                                {{ $item->outlet->code }}
                                            </p>

                                            <p class="text-xs text-slate-500">
                                                {{ $item->outlet->name }}
                                            </p>

                                        @elseif($item->department)

                                            <p class="font-semibold text-slate-800">
                                                {{ $item->department->code }}
                                            </p>

                                            <p class="text-xs text-slate-500">
                                                {{ $item->department->name }}
                                            </p>

                                        @else

                                            <span class="text-sm text-slate-400">
                                                -
                                            </span>

                                        @endif

                                    </td>


                                    {{-- JENIS --}}

                                    <td class="px-6 py-5">

                                        <span class="text-sm font-medium text-slate-700">
                                            {{ $typeLabel }}
                                        </span>

                                    </td>


                                    {{-- JUMLAH ITEM --}}

                                    <td class="px-6 py-5 text-center">

                                        <span class="inline-flex min-w-9 justify-center rounded-lg bg-slate-100 px-3 py-2 text-sm font-bold text-slate-700">

                                            {{ $item->items->count() }}

                                        </span>

                                    </td>


                                    {{-- STATUS --}}

                                    <td class="px-6 py-5 text-center">

                                        <span
                                            class="inline-flex whitespace-nowrap rounded-full px-3 py-1.5 text-xs font-bold {{ $statusClass }}">

                                            {{ $statusLabel }}

                                        </span>

                                    </td>


                                    {{-- AKSI --}}

                                    <td class="px-6 py-5 text-right">

                                        <div class="flex justify-end gap-2">

                                            <a
                                                href="{{ route('inventory-requests.show', $item) }}"
                                                class="rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">

                                                Detail

                                            </a>


                                            @if(
                                                $item->status === 'pending'
                                                &&
                                                (
                                                    auth()->id() === $item->requester_id
                                                    ||
                                                    auth()->user()->isSuperAdmin()
                                                )
                                            )

                                                <a
                                                    href="{{ route('inventory-requests.edit', $item) }}"
                                                    class="rounded-lg bg-[#8F348E] px-3 py-2 text-xs font-semibold text-white hover:bg-[#752C74]">

                                                    Edit

                                                </a>

                                            @endif

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="8"
                                        class="px-6 py-16 text-center">

                                        <div class="mx-auto max-w-sm">

                                            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100">

                                                <svg
                                                    class="h-7 w-7 text-slate-400"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24">

                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414A1 1 0 0119 9.414V19a2 2 0 01-2 2z" />

                                                </svg>

                                            </div>

                                            <p class="mt-4 font-semibold text-slate-700">
                                                Belum ada pengajuan
                                            </p>

                                            <p class="mt-1 text-sm text-slate-400">
                                                Belum terdapat pengajuan barang yang dapat ditampilkan.
                                            </p>

                                        </div>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>


                {{-- PAGINATION --}}

                @if($requests->hasPages())

                    <div class="border-t border-slate-100 px-6 py-5">

                        {{ $requests->links() }}

                    </div>

                @endif

            </div>

        </div>

    </div>

@endsection
