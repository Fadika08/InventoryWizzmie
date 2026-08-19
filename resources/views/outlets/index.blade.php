@extends('layouts.app')

@section('title', 'Outlet')

@section('page-title', 'Outlet')

@section('content')

    <div class="space-y-6">

        {{-- Flash --}}
        @if (session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-700">
                {{ session('success') }}
            </div>
        @endif


        @if (session('error'))
            <div class="rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-medium text-red-700">
                {{ session('error') }}
            </div>
        @endif


        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>

                <p class="text-xs font-bold uppercase tracking-wider text-[#8F348E]">
                    Outlet Management
                </p>

                <h2 class="mt-1 text-2xl font-bold text-slate-900">
                    Outlet
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Kelola seluruh outlet Wizzmie.
                </p>

            </div>


            <a href="{{ route('outlets.create') }}"
                class="inline-flex items-center justify-center rounded-xl bg-[#8F348E] px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#752C74]">

                + Tambah Outlet

            </a>

        </div>


        {{-- Search --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

            <form method="GET" action="{{ route('outlets.index') }}" class="flex flex-col gap-3 md:flex-row">

                <input type="text" name="search" value="{{ $search }}"
                    placeholder="Cari kode, outlet, kota, area, atau manager..."
                    class="w-full rounded-xl border-slate-200 focus:border-[#8F348E] focus:ring-[#8F348E]">

                <button type="submit" class="rounded-xl bg-[#8F348E] px-6 py-2.5 text-sm font-semibold text-white">

                    Cari

                </button>

                <a href="{{ route('outlets.index') }}"
                    class="rounded-xl border border-slate-200 px-6 py-2.5 text-center text-sm font-semibold text-slate-600">

                    Reset

                </a>

            </form>

        </div>


        {{-- Table --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="overflow-x-auto">

                <table class="w-full min-w-[1100px]">

                    <thead class="bg-slate-50">

                        <tr>

                            <th class="px-6 py-4 text-left text-xs font-bold uppercase text-slate-500">
                                Outlet
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-bold uppercase text-slate-500">
                                Lokasi
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-bold uppercase text-slate-500">
                                Manager / PIC
                            </th>

                            <th class="px-6 py-4 text-center text-xs font-bold uppercase text-slate-500">
                                User
                            </th>

                            <th class="px-6 py-4 text-center text-xs font-bold uppercase text-slate-500">
                                Inventaris
                            </th>

                            <th class="px-6 py-4 text-center text-xs font-bold uppercase text-slate-500">
                                Status
                            </th>

                            <th class="px-6 py-4 text-right text-xs font-bold uppercase text-slate-500">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-slate-100">

                        @forelse($outlets as $outlet)
                            <tr class="transition hover:bg-slate-50">

                                {{-- Outlet --}}
                                <td class="px-6 py-4">

                                    <p class="text-xs font-bold text-[#8F348E]">
                                        {{ $outlet->code }}
                                    </p>

                                    <p class="mt-1 text-sm font-bold text-slate-800">
                                        {{ $outlet->name }}
                                    </p>

                                </td>


                                {{-- Location --}}
                                <td class="px-6 py-4">

                                    <p class="text-sm font-semibold text-slate-700">

                                        {{ $outlet->city ?? '-' }}

                                    </p>

                                    <p class="mt-1 text-xs text-slate-400">

                                        {{ $outlet->area ?? '-' }}

                                    </p>

                                </td>


                                {{-- Manager --}}
                                <td class="px-6 py-4">

                                    <p class="text-sm font-semibold text-slate-700">

                                        {{ $outlet->manager_name ?? '-' }}

                                    </p>

                                    @if ($outlet->phone)
                                        <p class="mt-1 text-xs text-slate-400">

                                            {{ $outlet->phone }}

                                        </p>
                                    @endif

                                </td>


                                {{-- User --}}
                                <td class="px-6 py-4 text-center">

                                    <span class="rounded-lg bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-600">

                                        {{ $outlet->users_count }}

                                    </span>

                                </td>


                                {{-- Inventory --}}
                                <td class="px-6 py-4 text-center">

                                    <span class="rounded-lg bg-orange-50 px-3 py-1 text-xs font-semibold text-orange-600">

                                        {{ $outlet->inventory_items_count }}

                                    </span>

                                </td>


                                {{-- Status --}}
                                <td class="px-6 py-4 text-center">

                                    @if ($outlet->is_active)
                                        <span
                                            class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-600">

                                            Aktif

                                        </span>
                                    @else
                                        <span class="rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-red-600">

                                            Tidak Aktif

                                        </span>
                                    @endif

                                </td>


                                {{-- Action --}}
                                <td class="px-6 py-4">

                                    <div class="flex justify-end gap-3">

                                        <a href="{{ route('outlets.show', $outlet) }}"
                                            class="text-sm font-semibold text-[#8F348E]">

                                            Detail

                                        </a>


                                        <a href="{{ route('outlets.edit', $outlet) }}"
                                            class="text-sm font-semibold text-blue-600">

                                            Edit

                                        </a>


                                        <form method="POST" action="{{ route('outlets.toggle-status', $outlet) }}">

                                            @csrf

                                            @method('PATCH')

                                            <button type="submit"
                                                class="text-sm font-semibold {{ $outlet->is_active ? 'text-red-600' : 'text-emerald-600' }}">

                                                {{ $outlet->is_active ? 'Nonaktifkan' : 'Aktifkan' }}

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="7" class="px-6 py-16 text-center">

                                    <p class="font-semibold text-slate-600">
                                        Belum ada data outlet.
                                    </p>

                                    <p class="mt-1 text-sm text-slate-400">
                                        Tambahkan outlet untuk mulai mengelola inventaris outlet.
                                    </p>

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>


            @if ($outlets->hasPages())
                <div class="border-t border-slate-100 px-5 py-4">

                    {{ $outlets->links() }}

                </div>
            @endif

        </div>

    </div>

@endsection
