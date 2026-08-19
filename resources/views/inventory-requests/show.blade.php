@extends('layouts.app')

@section('title', 'Pengajuan Barang')

@section('content')


        <div class="flex flex-col gap-2">

            <h2 class="text-xl font-semibold text-slate-800">
                Detail Pengajuan Barang
            </h2>

            <p class="text-sm text-slate-500">
                {{ $inventoryRequest->request_number }}
            </p>

        </div>



    <div class="py-8">

        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">


            {{-- ========================================================= --}}
            {{-- SUCCESS --}}
            {{-- ========================================================= --}}

            @if (session('success'))
                <div class="mb-6 rounded-2xl border border-green-200 bg-green-50 p-4">

                    <p class="text-sm font-semibold text-green-700">
                        {{ session('success') }}
                    </p>

                </div>
            @endif


            {{-- ========================================================= --}}
            {{-- ERROR --}}
            {{-- ========================================================= --}}

            @if (session('error'))
                <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4">

                    <p class="text-sm font-semibold text-red-700">
                        {{ session('error') }}
                    </p>

                </div>
            @endif


            {{-- ========================================================= --}}
            {{-- HEADER --}}
            {{-- ========================================================= --}}

            <div class="mb-6">

                <a href="{{ route('inventory-requests.index') }}"
                    class="inline-flex items-center gap-2 text-sm font-semibold text-[#8F348E] hover:underline">

                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />

                    </svg>

                    Kembali ke Pengajuan

                </a>

            </div>


            {{-- ========================================================= --}}
            {{-- INFORMASI UTAMA --}}
            {{-- ========================================================= --}}

            <div class="mb-6 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                <div
                    class="flex flex-col gap-5 border-b border-slate-100 px-6 py-6 sm:flex-row sm:items-center sm:justify-between">

                    <div>

                        <p class="text-xs font-bold uppercase tracking-wider text-[#8F348E]">
                            Nomor Pengajuan
                        </p>

                        <h1 class="mt-1 text-2xl font-bold text-slate-900">
                            {{ $inventoryRequest->request_number }}
                        </h1>

                        <p class="mt-1 text-sm text-slate-500">

                            Diajukan
                            {{ $inventoryRequest->created_at?->format('d M Y H:i') ?? '-' }}

                        </p>

                    </div>


                    {{-- STATUS --}}

                    @php

                        $statusClass = match ($inventoryRequest->status) {
                            'Submitted' => 'bg-yellow-100 text-yellow-700',

                            'approved' => 'bg-green-100 text-green-700',

                            'rejected' => 'bg-red-100 text-red-700',

                            'cancelled' => 'bg-slate-100 text-slate-600',

                            'completed' => 'bg-blue-100 text-blue-700',

                            default => 'bg-slate-100 text-slate-600',
                        };

                        $statusLabel = match ($inventoryRequest->status) {
                            'Submitted' => 'Menunggu Persetujuan',

                            'approved' => 'Disetujui',

                            'rejected' => 'Ditolak',

                            'cancelled' => 'Dibatalkan',

                            'completed' => 'Selesai',

                            default => ucfirst($inventoryRequest->status),
                        };

                    @endphp


                    <span class="inline-flex w-fit rounded-full px-4 py-2 text-sm font-bold {{ $statusClass }}">

                        {{ $statusLabel }}

                    </span>

                </div>


                <div class="grid gap-6 p-6 sm:grid-cols-2 lg:grid-cols-4">


                    {{-- PEMOHON --}}

                    <div>

                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                            Pemohon
                        </p>

                        <p class="mt-2 font-semibold text-slate-800">
                            {{ $inventoryRequest->requester->name ?? '-' }}
                        </p>

                    </div>


                    {{-- DEPARTMENT --}}

                    <div>

                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                            Department
                        </p>

                        <p class="mt-2 font-semibold text-slate-800">

                            @if ($inventoryRequest->department)
                                {{ $inventoryRequest->department->code }}
                                -
                                {{ $inventoryRequest->department->name }}
                            @else
                                -
                            @endif

                        </p>

                    </div>


                    {{-- OUTLET --}}

                    <div>

                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                            Outlet
                        </p>

                        <p class="mt-2 font-semibold text-slate-800">

                            @if ($inventoryRequest->outlet)
                                {{ $inventoryRequest->outlet->code }}
                                -
                                {{ $inventoryRequest->outlet->name }}
                            @else
                                Head Office
                            @endif

                        </p>

                    </div>


                    {{-- JENIS --}}

                    <div>

                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                            Jenis Pengajuan
                        </p>

                        <p class="mt-2 font-semibold text-slate-800">

                            @switch($inventoryRequest->request_type)
                                @case('new_item')
                                    Barang Baru
                                @break

                                @case('replacement')
                                    Penggantian Barang
                                @break

                                @case('additional')
                                    Penambahan Barang
                                @break

                                @default
                                    {{ ucfirst($inventoryRequest->request_type) }}
                            @endswitch

                        </p>

                    </div>

                </div>

            </div>


            {{-- ========================================================= --}}
            {{-- ALASAN --}}
            {{-- ========================================================= --}}

            <div class="mb-6 grid gap-6 lg:grid-cols-2">


                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                    <h3 class="text-base font-bold text-slate-900">
                        Alasan Pengajuan
                    </h3>

                    <div class="mt-4 rounded-xl bg-slate-50 p-4">

                        <p class="whitespace-pre-line text-sm leading-6 text-slate-600">

                            {{ $inventoryRequest->reason }}

                        </p>

                    </div>

                </div>


                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                    <h3 class="text-base font-bold text-slate-900">
                        Catatan
                    </h3>

                    <div class="mt-4 rounded-xl bg-slate-50 p-4">

                        @if ($inventoryRequest->notes)
                            <p class="whitespace-pre-line text-sm leading-6 text-slate-600">

                                {{ $inventoryRequest->notes }}

                            </p>
                        @else
                            <p class="text-sm italic text-slate-400">
                                Tidak ada catatan.
                            </p>
                        @endif

                    </div>

                </div>

            </div>


            {{-- ========================================================= --}}
            {{-- DAFTAR BARANG --}}
            {{-- ========================================================= --}}

            <div class="mb-6 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                <div class="border-b border-slate-100 px-6 py-5">

                    <div class="flex items-center justify-between">

                        <div>

                            <h3 class="text-lg font-bold text-slate-900">
                                Daftar Barang
                            </h3>

                            <p class="mt-1 text-sm text-slate-500">
                                Barang yang diajukan dalam permintaan ini.
                            </p>

                        </div>


                        <div class="rounded-xl bg-[#8F348E]/10 px-4 py-2">

                            <span class="text-sm font-bold text-[#8F348E]">

                                {{ $inventoryRequest->items->count() }}
                                Item

                            </span>

                        </div>

                    </div>

                </div>


                <div class="overflow-x-auto">

                    <table class="w-full">

                        <thead class="bg-slate-50">

                            <tr>

                                <th
                                    class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wide text-slate-500">
                                    #
                                </th>

                                <th
                                    class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wide text-slate-500">
                                    Kategori
                                </th>

                                <th
                                    class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wide text-slate-500">
                                    Nama Barang
                                </th>

                                <th
                                    class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wide text-slate-500">
                                    Spesifikasi
                                </th>

                                <th
                                    class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wide text-slate-500">
                                    Jumlah
                                </th>

                                <th
                                    class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wide text-slate-500">
                                    Catatan
                                </th>

                            </tr>

                        </thead>


                        <tbody class="divide-y divide-slate-100">

                            @forelse($inventoryRequest->items
                                as $index => $item)
                                <tr class="hover:bg-slate-50">


                                    {{-- NOMOR --}}

                                    <td class="px-6 py-5">

                                        <div
                                            class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#8F348E]/10 text-sm font-bold text-[#8F348E]">

                                            {{ $index + 1 }}

                                        </div>

                                    </td>


                                    {{-- KATEGORI --}}

                                    <td class="px-6 py-5">

                                        @if ($item->category)
                                            <p class="font-semibold text-slate-800">
                                                {{ $item->category->name }}
                                            </p>

                                            <p class="mt-1 text-xs text-slate-400">
                                                {{ $item->category->code }}
                                            </p>
                                        @else
                                            <span class="text-sm text-slate-400">
                                                -
                                            </span>
                                        @endif

                                    </td>


                                    {{-- NAMA --}}

                                    <td class="px-6 py-5">

                                        <p class="font-semibold text-slate-800">
                                            {{ $item->item_name }}
                                        </p>

                                    </td>


                                    {{-- SPESIFIKASI --}}

                                    <td class="max-w-xs px-6 py-5">

                                        @if ($item->specification)
                                            <p class="whitespace-pre-line text-sm text-slate-600">

                                                {{ $item->specification }}

                                            </p>
                                        @else
                                            <span class="text-sm italic text-slate-400">
                                                Tidak ada spesifikasi.
                                            </span>
                                        @endif

                                    </td>


                                    {{-- JUMLAH --}}

                                    <td class="px-6 py-5 text-center">

                                        <span
                                            class="inline-flex min-w-10 justify-center rounded-lg bg-slate-100 px-3 py-2 font-bold text-slate-700">

                                            {{ $item->quantity }}

                                        </span>

                                    </td>


                                    {{-- CATATAN --}}

                                    <td class="px-6 py-5">

                                        @if ($item->notes)
                                            <p class="text-sm text-slate-600">
                                                {{ $item->notes }}
                                            </p>
                                        @else
                                            <span class="text-sm italic text-slate-400">
                                                -
                                            </span>
                                        @endif

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="6" class="px-6 py-12 text-center">

                                        <p class="font-semibold text-slate-600">
                                            Tidak ada item pengajuan.
                                        </p>

                                    </td>

                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>


            {{-- ========================================================= --}}
            {{-- INFORMASI APPROVAL --}}
            {{-- ========================================================= --}}

            @if ($inventoryRequest->approved_by || $inventoryRequest->approved_at || $inventoryRequest->rejected_reason)

                <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                    <h3 class="text-lg font-bold text-slate-900">
                        Informasi Persetujuan
                    </h3>


                    <div class="mt-5 grid gap-5 sm:grid-cols-2">


                        @if ($inventoryRequest->approved_by)
                            <div>

                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                    Diproses Oleh
                                </p>

                                <p class="mt-2 font-semibold text-slate-800">

                                    {{ $inventoryRequest->approver->name ?? '-' }}

                                </p>

                            </div>
                        @endif


                        @if ($inventoryRequest->approved_at)
                            <div>

                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                    Waktu Persetujuan
                                </p>

                                <p class="mt-2 font-semibold text-slate-800">

                                    {{ $inventoryRequest->approved_at->format('d M Y H:i') }}

                                </p>

                            </div>
                        @endif


                        @if ($inventoryRequest->rejected_reason)
                            <div class="sm:col-span-2">

                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                    Alasan Penolakan
                                </p>

                                <div class="mt-2 rounded-xl bg-red-50 p-4">

                                    <p class="whitespace-pre-line text-sm text-red-700">

                                        {{ $inventoryRequest->rejected_reason }}

                                    </p>

                                </div>

                            </div>
                        @endif

                    </div>

                </div>

            @endif


            {{-- ========================================================= --}}
            {{-- ACTION --}}
            {{-- ========================================================= --}}

            <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">


                <a href="{{ route('inventory-requests.index') }}"
                    class="rounded-xl border border-slate-200 bg-white px-5 py-3 text-center text-sm font-semibold text-slate-700 hover:bg-slate-50">

                    Kembali

                </a>

                @if(
                    $inventoryRequest->status === 'submitted'
                    &&
                    (
                        auth()->id() === $inventoryRequest->requester_id
                        ||
                        auth()->user()->isSuperAdmin()
                    )
                )

                    <a
                        href="{{ route('inventory-requests.edit', $inventoryRequest) }}"
                        class="rounded-xl bg-[#8F348E] px-5 py-3 text-center text-sm font-semibold text-white hover:bg-[#752C74]">

                        Edit Pengajuan

                    </a>

                @endif
              {{-- ===================================================== --}}
{{-- CANCEL --}}
{{-- ===================================================== --}}

@if (
    $inventoryRequest->status === 'submitted'
    &&
    (
        auth()->id() === $inventoryRequest->requester_id
        ||
        auth()->user()->isSuperAdmin()
    )
)

    <form
        method="POST"
        action="{{ route('inventory-requests.cancel', $inventoryRequest) }}"
        class="inline"
        onsubmit="return confirm('Yakin ingin membatalkan pengajuan ini?')">

        @csrf
        @method('PATCH')

        <button
            type="submit"
            class="rounded-xl border border-red-200 bg-red-50 px-5 py-2.5 text-sm font-semibold text-red-600 hover:bg-red-100">

            Batalkan Pengajuan

        </button>

    </form>

@endif


                {{-- ===================================================== --}}
                {{-- APPROVAL PLACEHOLDER --}}
                {{-- ===================================================== --}}

                @if ($inventoryRequest->status === 'submitted')

                    @if (auth()->user()->isSuperAdmin() || auth()->user()->isHoAdmin())
                        @if ($inventoryRequest->status === 'submitted')

                            @if (auth()->user()->isSuperAdmin() || auth()->user()->isHoAdmin() || auth()->user()->isOutletAdmin())
                                <div class="flex flex-col gap-3 sm:flex-row">

                                    {{-- ================================================= --}}
                                    {{-- TOLAK --}}
                                    {{-- ================================================= --}}

                                    <button type="button" onclick="openRejectModal()"
                                        class="rounded-xl border border-red-200 bg-white px-5 py-3 text-center text-sm font-semibold text-red-600 hover:bg-red-50">

                                        Tolak Pengajuan

                                    </button>


                                    {{-- ================================================= --}}
                                    {{-- SETUJUI --}}
                                    {{-- ================================================= --}}

                                    <form method="POST"
                                        action="{{ route('inventory-requests.approve', $inventoryRequest) }}"
                                        onsubmit="return confirm(
                    'Apakah Anda yakin ingin menyetujui pengajuan ini?'
                )">

                                        @csrf

                                        <button type="submit"
                                            class="rounded-xl bg-green-600 px-5 py-3 text-sm font-semibold text-white hover:bg-green-700">

                                            Setujui Pengajuan

                                        </button>

                                    </form>

                                </div>
                            @endif

                        @endif
                    @endif

                @endif

            </div>

        </div>

    </div>

    {{-- ============================================================= --}}
    {{-- MODAL TOLAK --}}
    {{-- ============================================================= --}}

    <div id="rejectModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 px-4">

        <div class="w-full max-w-lg rounded-2xl bg-white shadow-xl">

            {{-- HEADER --}}

            <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5">

                <div>

                    <h3 class="text-lg font-bold text-slate-900">
                        Tolak Pengajuan
                    </h3>

                    <p class="mt-1 text-sm text-slate-500">
                        Masukkan alasan penolakan pengajuan.
                    </p>

                </div>


                <button type="button" onclick="closeRejectModal()"
                    class="rounded-lg p-2 text-slate-400 hover:bg-slate-100 hover:text-slate-600">

                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />

                    </svg>

                </button>

            </div>


            {{-- FORM --}}

            <form method="POST" action="{{ route('inventory-requests.reject', $inventoryRequest) }}">

                @csrf


                <div class="p-6">

                    <label for="rejected_reason" class="mb-2 block text-sm font-semibold text-slate-700">

                        Alasan Penolakan

                        <span class="text-red-500">
                            *
                        </span>

                    </label>


                    <textarea id="rejected_reason" name="rejected_reason" rows="5" required
                        placeholder="Jelaskan alasan pengajuan ditolak..."
                        class="w-full rounded-xl border-slate-200 px-4 py-3 text-sm focus:border-[#8F348E] focus:ring-[#8F348E]">{{ old('rejected_reason') }}</textarea>


                    @error('rejected_reason')
                        <p class="mt-2 text-xs text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- FOOTER --}}

                <div class="flex justify-end gap-3 border-t border-slate-100 bg-slate-50 px-6 py-4">

                    <button type="button" onclick="closeRejectModal()"
                        class="rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700">

                        Batal

                    </button>


                    <button type="submit"
                        class="rounded-xl bg-red-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-red-700">

                        Tolak Pengajuan

                    </button>

                </div>

            </form>

        </div>

    </div>

    <script>
        function openRejectModal() {

            const modal =
                document.getElementById(
                    'rejectModal'
                );

            modal.classList.remove(
                'hidden'
            );

            modal.classList.add(
                'flex'
            );

        }


        function closeRejectModal() {

            const modal =
                document.getElementById(
                    'rejectModal'
                );

            modal.classList.add(
                'hidden'
            );

            modal.classList.remove(
                'flex'
            );

        }


        document.addEventListener(
            'keydown',
            function(event) {

                if (
                    event.key === 'Escape'
                ) {

                    closeRejectModal();

                }

            }
        );
    </script>

@endSection
