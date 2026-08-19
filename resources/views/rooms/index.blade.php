@extends('layouts.app')

@section('title', 'Ruangan')

@section('page-title', 'Ruangan')

@section('content')

    <div class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <p class="text-sm font-medium text-[#8F348E]">
                    Master Data
                </p>

                <h2 class="mt-1 text-2xl font-bold text-slate-900">
                    Ruangan
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Kelola ruangan Head Office berdasarkan divisi.
                </p>
            </div>

            <a href="{{ route('rooms.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#8F348E] px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#752c74]">

                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16M4 12h16" />
                </svg>

                Tambah Ruangan

            </a>

        </div>


        {{-- Alert --}}
        @if (session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                {{ session('error') }}
            </div>
        @endif


        {{-- Filter --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">

            <form method="GET" action="{{ route('rooms.index') }}" class="grid gap-3 md:grid-cols-3">

                <div class="md:col-span-2">

                    <input type="text" name="search" value="{{ $search }}"
                        placeholder="Cari kode atau nama ruangan..."
                        class="w-full rounded-xl border-slate-200 text-sm focus:border-[#8F348E] focus:ring-[#8F348E]">

                </div>

                <div>

                    <select name="department_id"
                        class="w-full rounded-xl border-slate-200 text-sm focus:border-[#8F348E] focus:ring-[#8F348E]">

                        <option value="">
                            Semua Divisi
                        </option>

                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}" @selected($departmentId == $department->id)>

                                {{ $department->code }} - {{ $department->name }}

                            </option>
                        @endforeach

                    </select>

                </div>

                <div class="flex gap-2 md:col-span-3">

                    <button type="submit"
                        class="rounded-xl bg-slate-800 px-5 py-2.5 text-sm font-semibold text-white hover:bg-slate-700">

                        Filter

                    </button>

                    <a href="{{ route('rooms.index') }}"
                        class="rounded-xl border border-slate-200 px-5 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50">

                        Reset

                    </a>

                </div>

            </form>

        </div>


        {{-- Table --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="overflow-x-auto">

                <table class="min-w-full">

                    <thead class="border-b border-slate-200 bg-slate-50">

                        <tr>

                            <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                #
                            </th>

                            <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                Ruangan
                            </th>

                            <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                Divisi
                            </th>

                            <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                Lantai
                            </th>

                            <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                Inventaris
                            </th>

                            <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                Status
                            </th>

                            <th class="px-5 py-4 text-right text-xs font-bold uppercase tracking-wider text-slate-500">
                                Aksi
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-slate-100">

                        @forelse($rooms as $room)
                            <tr class="transition hover:bg-slate-50">

                                <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-500">
                                    {{ $rooms->firstItem() + $loop->index }}
                                </td>

                                <td class="px-5 py-4">

                                    <p class="font-semibold text-slate-800">
                                        {{ $room->name }}
                                    </p>

                                    <p class="mt-0.5 text-xs font-medium text-[#8F348E]">
                                        {{ $room->code }}
                                    </p>

                                </td>

                                <td class="px-5 py-4">

                                    <p class="text-sm font-semibold text-slate-700">
                                        {{ $room->department->name }}
                                    </p>

                                    <p class="text-xs text-slate-400">
                                        {{ $room->department->code }}
                                    </p>

                                </td>

                                <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-600">
                                    {{ $room->floor ?: '-' }}
                                </td>

                                <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-600">
                                    {{ number_format($room->inventory_items_count) }}
                                </td>

                                <td class="whitespace-nowrap px-5 py-4">

                                    @if ($room->is_active)
                                        <span
                                            class="inline-flex rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-600">
                                            Aktif
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-500">
                                            Nonaktif
                                        </span>
                                    @endif

                                </td>

                                <td class="whitespace-nowrap px-5 py-4">

                                    <div class="flex justify-end gap-1">

                                        <a href="{{ route('rooms.show', $room) }}"
                                            class="rounded-lg p-2 text-slate-500 hover:bg-slate-100 hover:text-[#8F348E]"
                                            title="Detail">

                                            Detail

                                        </a>

                                        <a href="{{ route('rooms.edit', $room) }}"
                                            class="rounded-lg p-2 text-slate-500 hover:bg-[#8F348E]/10 hover:text-[#8F348E]"
                                            title="Edit">

                                            Edit

                                        </a>

                                        <form method="POST" action="{{ route('rooms.toggle-status', $room) }}">

                                            @csrf
                                            @method('PATCH')

                                            <button type="submit"
                                                class="rounded-lg p-2 text-slate-500 hover:bg-[#FAAC3F]/10 hover:text-[#FAAC3F]">

                                                {{ $room->is_active ? 'Nonaktifkan' : 'Aktifkan' }}

                                            </button>

                                        </form>

                                        <form method="POST" action="{{ route('rooms.destroy', $room) }}"
                                            onsubmit="return confirm('Yakin ingin menghapus ruangan ini?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="rounded-lg p-2 text-slate-500 hover:bg-red-50 hover:text-[#E94025]">

                                                Hapus

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="7" class="px-5 py-16 text-center">

                                    <p class="font-semibold text-slate-700">
                                        Belum ada ruangan
                                    </p>

                                    <p class="mt-1 text-sm text-slate-400">
                                        Tambahkan ruangan untuk Head Office.
                                    </p>

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>


            @if ($rooms->hasPages())
                <div class="border-t border-slate-100 px-5 py-4">
                    {{ $rooms->links() }}
                </div>
            @endif

        </div>

    </div>

@endsection
