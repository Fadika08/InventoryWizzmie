@extends('layouts.app')

@section('title', 'Detail Kategori')

@section('page-title', 'Detail Kategori')

@section('content')

    <div class="mx-auto max-w-3xl space-y-5">

        <a href="{{ route('categories.index') }}" class="text-sm font-medium text-[#8F348E]">

            ← Kembali ke Kategori

        </a>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                <div>

                    <p class="text-xs font-bold uppercase text-[#8F348E]">
                        {{ $category->code }}
                    </p>

                    <h2 class="mt-1 text-2xl font-bold text-slate-900">
                        {{ $category->name }}
                    </h2>

                </div>

                <a href="{{ route('categories.edit', $category) }}"
                    class="rounded-xl bg-[#8F348E] px-5 py-2.5 text-center text-sm font-semibold text-white">

                    Edit

                </a>

            </div>

            <div class="mt-6 border-t border-slate-100 pt-5">

                <p class="text-xs text-slate-400">
                    Deskripsi
                </p>

                <p class="mt-2 text-sm text-slate-600">
                    {{ $category->description ?: 'Tidak ada deskripsi.' }}
                </p>

            </div>

        </div>


        <div class="grid gap-4 sm:grid-cols-2">

            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                <p class="text-sm text-slate-500">
                    Total Inventaris
                </p>

                <p class="mt-2 text-3xl font-bold text-slate-900">
                    {{ $totalInventory }}
                </p>

            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                <p class="text-sm text-slate-500">
                    Status
                </p>

                <p class="mt-2">

                    @if ($category->is_active)
                        <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-600">
                            Aktif
                        </span>
                    @else
                        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-500">
                            Nonaktif
                        </span>
                    @endif

                </p>

            </div>

        </div>

    </div>

@endsection
