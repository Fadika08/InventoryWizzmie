@extends('layouts.app')

@section('title', 'Detail Divisi')

@section('page-title', 'Detail Divisi')

@section('content')

    <div class="space-y-6">

        <div>

            <a href="{{ route('departments.index') }}" class="text-sm font-medium text-[#8F348E] hover:underline">
                ← Kembali ke Divisi
            </a>

        </div>


        {{-- Profile --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

            <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">

                <div class="flex items-center gap-4">

                    <div
                        class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-[#8F348E] to-[#DF3C95] text-xl font-bold text-white">
                        {{ strtoupper(substr($department->name, 0, 1)) }}
                    </div>

                    <div>

                        <p class="text-xs font-bold uppercase tracking-wider text-[#8F348E]">
                            {{ $department->code }}
                        </p>

                        <h2 class="mt-1 text-2xl font-bold text-slate-900">
                            {{ $department->name }}
                        </h2>

                    </div>

                </div>


                <a href="{{ route('departments.edit', $department) }}"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#8F348E] px-4 py-2.5 text-sm font-semibold text-white hover:bg-[#752c74]">

                    Edit Divisi

                </a>

            </div>


            <div class="mt-6 border-t border-slate-100 pt-6">

                <p class="text-sm font-semibold text-slate-700">
                    Deskripsi
                </p>

                <p class="mt-2 text-sm leading-6 text-slate-500">
                    {{ $department->description ?: 'Tidak ada deskripsi.' }}
                </p>

            </div>

        </div>


        {{-- Statistics --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">

            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                <p class="text-sm text-slate-500">
                    User
                </p>

                <p class="mt-2 text-3xl font-bold text-slate-900">
                    {{ number_format($department->users_count) }}
                </p>

            </div>


            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                <p class="text-sm text-slate-500">
                    Ruangan
                </p>

                <p class="mt-2 text-3xl font-bold text-slate-900">
                    {{ number_format($department->rooms_count) }}
                </p>

            </div>


            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                <p class="text-sm text-slate-500">
                    Inventaris
                </p>

                <p class="mt-2 text-3xl font-bold text-slate-900">
                    {{ number_format($department->inventory_items_count) }}
                </p>

            </div>

        </div>


        {{-- Information --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

            <h3 class="font-semibold text-slate-900">
                Informasi Divisi
            </h3>

            <div class="mt-5 grid gap-5 sm:grid-cols-2">

                <div>

                    <p class="text-xs font-medium text-slate-400">
                        Kode
                    </p>

                    <p class="mt-1 text-sm font-semibold text-slate-700">
                        {{ $department->code }}
                    </p>

                </div>

                <div>

                    <p class="text-xs font-medium text-slate-400">
                        Status
                    </p>

                    @if ($department->is_active)
                        <span
                            class="mt-1 inline-flex rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-600">
                            Aktif
                        </span>
                    @else
                        <span
                            class="mt-1 inline-flex rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-500">
                            Nonaktif
                        </span>
                    @endif

                </div>

                <div>

                    <p class="text-xs font-medium text-slate-400">
                        Dibuat
                    </p>

                    <p class="mt-1 text-sm font-semibold text-slate-700">
                        {{ $department->created_at?->format('d M Y H:i') }}
                    </p>

                </div>

                <div>

                    <p class="text-xs font-medium text-slate-400">
                        Terakhir diperbarui
                    </p>

                    <p class="mt-1 text-sm font-semibold text-slate-700">
                        {{ $department->updated_at?->format('d M Y H:i') }}
                    </p>

                </div>

            </div>

        </div>

    </div>

@endsection
