@extends('layouts.app')

@section('title', 'Detail Ruangan')

@section('page-title', 'Detail Ruangan')

@section('content')

    <div class="space-y-6">

        <div>

            <a href="{{ route('rooms.index') }}" class="text-sm font-medium text-[#8F348E] hover:underline">

                ← Kembali ke Ruangan

            </a>

        </div>


        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

            <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">

                <div>

                    <p class="text-xs font-bold uppercase tracking-wider text-[#8F348E]">
                        {{ $room->code }}
                    </p>

                    <h2 class="mt-1 text-2xl font-bold text-slate-900">
                        {{ $room->name }}
                    </h2>

                    <p class="mt-2 text-sm text-slate-500">
                        {{ $room->department->code }}
                        -
                        {{ $room->department->name }}
                    </p>

                </div>

                <a href="{{ route('rooms.edit', $room) }}"
                    class="rounded-xl bg-[#8F348E] px-5 py-2.5 text-center text-sm font-semibold text-white hover:bg-[#752c74)">

                    Edit Ruangan

                </a>

            </div>

        </div>


        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">

            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                <p class="text-sm text-slate-500">
                    Divisi
                </p>

                <p class="mt-2 font-bold text-slate-900">
                    {{ $room->department->name }}
                </p>

            </div>


            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                <p class="text-sm text-slate-500">
                    Lantai
                </p>

                <p class="mt-2 font-bold text-slate-900">
                    {{ $room->floor ?: '-' }}
                </p>

            </div>


            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                <p class="text-sm text-slate-500">
                    Total Inventaris
                </p>

                <p class="mt-2 text-3xl font-bold text-slate-900">
                    {{ number_format($room->inventory_items_count) }}
                </p>

            </div>

        </div>


        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

            <h3 class="font-semibold text-slate-900">
                Informasi Ruangan
            </h3>

            <div class="mt-5 grid gap-5 sm:grid-cols-2">

                <div>

                    <p class="text-xs text-slate-400">
                        Kode
                    </p>

                    <p class="mt-1 font-semibold text-slate-700">
                        {{ $room->code }}
                    </p>

                </div>

                <div>

                    <p class="text-xs text-slate-400">
                        Status
                    </p>

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

                </div>

                <div>

                    <p class="text-xs text-slate-400">
                        Dibuat
                    </p>

                    <p class="mt-1 text-sm font-semibold text-slate-700">
                        {{ $room->created_at?->format('d M Y H:i') }}
                    </p>

                </div>

                <div>

                    <p class="text-xs text-slate-400">
                        Diperbarui
                    </p>

                    <p class="mt-1 text-sm font-semibold text-slate-700">
                        {{ $room->updated_at?->format('d M Y H:i') }}
                    </p>

                </div>

            </div>

            <div class="mt-6 border-t border-slate-100 pt-5">

                <p class="text-xs text-slate-400">
                    Deskripsi
                </p>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    {{ $room->description ?: 'Tidak ada deskripsi.' }}
                </p>

            </div>

        </div>

    </div>

@endsection
