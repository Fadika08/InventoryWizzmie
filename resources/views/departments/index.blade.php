@extends('layouts.app')

@section('title', 'Divisi')

@section('page-title', 'Divisi')

@section('content')

    <div class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <p class="text-sm font-medium text-[#8F348E]">
                    Master Data
                </p>

                <h2 class="mt-1 text-2xl font-bold text-slate-900">
                    Divisi
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Kelola data divisi Head Office Wizzmie.
                </p>
            </div>

            <a href="{{ route('departments.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#8F348E] px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#752c74]">

                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16M4 12h16" />
                </svg>

                Tambah Divisi

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


        {{-- Search --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">

            <form method="GET" action="{{ route('departments.index') }}" class="flex flex-col gap-3 sm:flex-row">

                <div class="relative flex-1">

                    <svg class="absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M21 21l-4.35-4.35M19 11a8 8 0 11-16 0 8 8 0 0116 0z" />

                    </svg>

                    <input type="text" name="search" value="{{ $search }}"
                        placeholder="Cari kode atau nama divisi..."
                        class="w-full rounded-xl border-slate-200 py-2.5 pl-10 pr-4 text-sm focus:border-[#8F348E] focus:ring-[#8F348E]">

                </div>

                <button type="submit"
                    class="rounded-xl bg-slate-800 px-5 py-2.5 text-sm font-semibold text-white hover:bg-slate-700">

                    Cari

                </button>

                @if ($search)
                    <a href="{{ route('departments.index') }}"
                        class="rounded-xl border border-slate-200 px-5 py-2.5 text-center text-sm font-semibold text-slate-600 hover:bg-slate-50">

                        Reset

                    </a>
                @endif

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
                                Divisi
                            </th>

                            <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                User
                            </th>

                            <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                Ruangan
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

                        @forelse($departments as $department)
                            <tr class="transition hover:bg-slate-50">

                                <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-500">
                                    {{ $departments->firstItem() + $loop->index }}
                                </td>

                                <td class="px-5 py-4">

                                    <div>
                                        <p class="font-semibold text-slate-800">
                                            {{ $department->name }}
                                        </p>

                                        <p class="mt-0.5 text-xs font-medium text-[#8F348E]">
                                            {{ $department->code }}
                                        </p>
                                    </div>

                                </td>

                                <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-600">
                                    {{ number_format($department->users_count) }}
                                </td>

                                <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-600">
                                    {{ number_format($department->rooms_count) }}
                                </td>

                                <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-600">
                                    {{ number_format($department->inventory_items_count) }}
                                </td>

                                <td class="whitespace-nowrap px-5 py-4">

                                    @if ($department->is_active)
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

                                        <a href="{{ route('departments.show', $department) }}" title="Detail"
                                            class="rounded-lg p-2 text-slate-500 hover:bg-slate-100 hover:text-[#8F348E]">

                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                    d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6z" />
                                                <circle cx="12" cy="12" r="2.5" />
                                            </svg>

                                        </a>


                                        <a href="{{ route('departments.edit', $department) }}" title="Edit"
                                            class="rounded-lg p-2 text-slate-500 hover:bg-[#8F348E]/10 hover:text-[#8F348E]">

                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                    d="M12 20h9M16.5 3.5a2.12 2.12 0 013 3L8 18l-4 1 1-4 11.5-11.5z" />
                                            </svg>

                                        </a>


                                        <form method="POST"
                                            action="{{ route('departments.toggle-status', $department) }}">

                                            @csrf
                                            @method('PATCH')

                                            <button type="submit"
                                                title="{{ $department->is_active ? 'Nonaktifkan' : 'Aktifkan' }}"
                                                class="rounded-lg p-2 text-slate-500 hover:bg-[#FAAC3F]/10 hover:text-[#FAAC3F]">

                                                @if ($department->is_active)
                                                    <svg class="h-5 w-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="1.8"
                                                            d="M18 8a6 6 0 00-12 0v4a6 6 0 0012 0V8zM5 20h14" />
                                                    </svg>
                                                @else
                                                    <svg class="h-5 w-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="1.8" d="M12 3v9M6.2 6.2a8 8 0 1011.6 0" />
                                                    </svg>
                                                @endif

                                            </button>

                                        </form>


                                        <form method="POST" action="{{ route('departments.destroy', $department) }}"
                                            onsubmit="return confirm('Yakin ingin menghapus divisi ini?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" title="Hapus"
                                                class="rounded-lg p-2 text-slate-500 hover:bg-red-50 hover:text-[#E94025]">

                                                <svg class="h-5 w-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="1.8"
                                                        d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6M10 11v5M14 11v5" />
                                                </svg>

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="7" class="px-5 py-16 text-center">

                                    <div
                                        class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-slate-100 text-slate-400">

                                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                d="M4 19h16M4 19V5a2 2 0 012-2h12a2 2 0 012 2v14" />
                                        </svg>

                                    </div>

                                    <p class="mt-4 font-semibold text-slate-700">
                                        Tidak ada data divisi
                                    </p>

                                    <p class="mt-1 text-sm text-slate-400">
                                        Silakan tambahkan divisi terlebih dahulu.
                                    </p>

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>


            @if ($departments->hasPages())
                <div class="border-t border-slate-100 px-5 py-4">
                    {{ $departments->links() }}
                </div>
            @endif

        </div>

    </div>

@endsection
