@extends('layouts.app')

@section('title', 'Detail Outlet')

@section('page-title', 'Detail Outlet')

@section('content')

    <div class="mx-auto max-w-6xl space-y-6">

        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>

                <p class="text-xs font-bold uppercase tracking-wider text-[#8F348E]">
                    Outlet Management
                </p>

                <h2 class="mt-1 text-2xl font-bold text-slate-900">
                    {{ $outlet->name }}
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Detail informasi outlet.
                </p>

            </div>


            <div class="flex gap-3">

                <a href="{{ route('outlets.edit', $outlet) }}"
                    class="rounded-xl bg-[#8F348E] px-5 py-2.5 text-sm font-semibold text-white">

                    Edit

                </a>

                <a href="{{ route('outlets.index') }}"
                    class="rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-600">

                    Kembali

                </a>

            </div>

        </div>


        {{-- Flash --}}
        @if (session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-700">

                {{ session('success') }}

            </div>
        @endif


        {{-- Main Information --}}
        <div class="grid gap-6 lg:grid-cols-3">

            {{-- Identity --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-xs font-bold uppercase text-[#8F348E]">
                            Outlet Code
                        </p>

                        <h3 class="mt-1 text-xl font-bold text-slate-900">
                            {{ $outlet->code }}
                        </h3>

                    </div>


                    @if ($outlet->is_active)
                        <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-600">
                            Aktif
                        </span>
                    @else
                        <span class="rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-red-600">
                            Tidak Aktif
                        </span>
                    @endif

                </div>


                <div class="mt-6 border-t border-slate-100 pt-5">

                    <p class="text-xs text-slate-400">
                        Nama Outlet
                    </p>

                    <p class="mt-1 font-semibold text-slate-800">
                        {{ $outlet->name }}
                    </p>

                </div>

            </div>


            {{-- Location --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                <h3 class="font-bold text-slate-900">
                    Lokasi
                </h3>

                <div class="mt-5 space-y-4">

                    <div>

                        <p class="text-xs text-slate-400">
                            Kota
                        </p>

                        <p class="mt-1 text-sm font-semibold text-slate-700">
                            {{ $outlet->city ?? '-' }}
                        </p>

                    </div>


                    <div>

                        <p class="text-xs text-slate-400">
                            Area
                        </p>

                        <p class="mt-1 text-sm font-semibold text-slate-700">
                            {{ $outlet->area ?? '-' }}
                        </p>

                    </div>


                    <div>

                        <p class="text-xs text-slate-400">
                            Alamat
                        </p>

                        <p class="mt-1 text-sm leading-6 text-slate-600">
                            {{ $outlet->address ?? '-' }}
                        </p>

                    </div>

                </div>

            </div>


            {{-- PIC --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                <h3 class="font-bold text-slate-900">
                    Manager / PIC
                </h3>

                <div class="mt-5 space-y-4">

                    <div>

                        <p class="text-xs text-slate-400">
                            Nama
                        </p>

                        <p class="mt-1 text-sm font-semibold text-slate-700">
                            {{ $outlet->manager_name ?? '-' }}
                        </p>

                    </div>


                    <div>

                        <p class="text-xs text-slate-400">
                            Telepon
                        </p>

                        <p class="mt-1 text-sm font-semibold text-slate-700">
                            {{ $outlet->phone ?? '-' }}
                        </p>

                    </div>

                </div>

            </div>

        </div>


        {{-- Statistics --}}
        <div class="grid gap-4 sm:grid-cols-3">

            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                <p class="text-xs font-semibold uppercase text-slate-400">
                    User
                </p>

                <p class="mt-2 text-3xl font-bold text-slate-900">
                    {{ $outlet->users_count }}
                </p>

            </div>


            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                <p class="text-xs font-semibold uppercase text-slate-400">
                    Inventaris
                </p>

                <p class="mt-2 text-3xl font-bold text-slate-900">
                    {{ $outlet->inventory_items_count }}
                </p>

            </div>


            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                <p class="text-xs font-semibold uppercase text-slate-400">
                    Pengajuan
                </p>

                <p class="mt-2 text-3xl font-bold text-slate-900">
                    {{ $outlet->inventory_requests_count }}
                </p>

            </div>

        </div>


        {{-- Users --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-100 px-6 py-5">

                <h3 class="font-bold text-slate-900">
                    User Outlet
                </h3>

            </div>


            <div class="overflow-x-auto">

                <table class="w-full min-w-[700px]">

                    <thead class="bg-slate-50">

                        <tr>

                            <th class="px-6 py-4 text-left text-xs font-bold uppercase text-slate-500">
                                Nama
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-bold uppercase text-slate-500">
                                Email
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-bold uppercase text-slate-500">
                                Role
                            </th>

                            <th class="px-6 py-4 text-center text-xs font-bold uppercase text-slate-500">
                                Status
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-slate-100">

                        @forelse($outlet->users as $user)
                            <tr>

                                <td class="px-6 py-4">

                                    <p class="text-sm font-semibold text-slate-800">
                                        {{ $user->name }}
                                    </p>

                                </td>

                                <td class="px-6 py-4 text-sm text-slate-600">

                                    {{ $user->email }}

                                </td>

                                <td class="px-6 py-4">

                                    <span
                                        class="rounded-full bg-[#8F348E]/10 px-3 py-1 text-xs font-semibold text-[#8F348E]">

                                        {{ ucwords(str_replace('_', ' ', $user->role?->name ?? '-')) }}

                                    </span>

                                </td>

                                <td class="px-6 py-4 text-center">

                                    @if ($user->is_active)
                                        <span class="text-xs font-semibold text-emerald-600">
                                            Aktif
                                        </span>
                                    @else
                                        <span class="text-xs font-semibold text-red-600">
                                            Tidak Aktif
                                        </span>
                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="4" class="px-6 py-10 text-center text-sm text-slate-400">

                                    Belum ada user pada outlet ini.

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

@endsection
