@extends('layouts.app')

@section('title', 'Kategori Inventaris')

@section('page-title', 'Kategori Inventaris')

@section('content')

    <div class="space-y-6">

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>

                <p class="text-sm font-medium text-[#8F348E]">
                    Master Data
                </p>

                <h2 class="mt-1 text-2xl font-bold text-slate-900">
                    Kategori Inventaris
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Kelola kategori barang inventaris Wizzmie.
                </p>

            </div>

            <a href="{{ route('categories.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#8F348E] px-4 py-2.5 text-sm font-semibold text-white hover:bg-[#752c74]">

                + Tambah Kategori

            </a>

        </div>


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


        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">

            <form method="GET" action="{{ route('categories.index') }}" class="flex flex-col gap-3 sm:flex-row">

                <input type="text" name="search" value="{{ $search }}" placeholder="Cari kode atau kategori..."
                    class="flex-1 rounded-xl border-slate-200 text-sm focus:border-[#8F348E] focus:ring-[#8F348E]">

                <button type="submit" class="rounded-xl bg-slate-800 px-5 py-2.5 text-sm font-semibold text-white">

                    Cari

                </button>

                @if ($search)
                    <a href="{{ route('categories.index') }}"
                        class="rounded-xl border border-slate-200 px-5 py-2.5 text-center text-sm font-semibold text-slate-600">

                        Reset

                    </a>
                @endif

            </form>

        </div>


        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="overflow-x-auto">

                <table class="min-w-full">

                    <thead class="border-b border-slate-200 bg-slate-50">

                        <tr>

                            <th class="px-5 py-4 text-left text-xs font-bold uppercase text-slate-500">
                                #
                            </th>

                            <th class="px-5 py-4 text-left text-xs font-bold uppercase text-slate-500">
                                Kategori
                            </th>

                            <th class="px-5 py-4 text-left text-xs font-bold uppercase text-slate-500">
                                Inventaris
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

                        @forelse($categories as $category)
                            <tr class="hover:bg-slate-50">

                                <td class="px-5 py-4 text-sm text-slate-500">
                                    {{ $categories->firstItem() + $loop->index }}
                                </td>

                                <td class="px-5 py-4">

                                    <p class="font-semibold text-slate-800">
                                        {{ $category->name }}
                                    </p>

                                    <p class="mt-0.5 text-xs font-medium text-[#8F348E]">
                                        {{ $category->code }}
                                    </p>

                                </td>

                                <td class="px-5 py-4 text-sm text-slate-600">
                                    {{ number_format($category->inventory_items_count) }}
                                </td>

                                <td class="px-5 py-4">

                                    @if ($category->is_active)
                                        <span
                                            class="rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-600">
                                            Aktif
                                        </span>
                                    @else
                                        <span
                                            class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-500">
                                            Nonaktif
                                        </span>
                                    @endif

                                </td>

                                <td class="px-5 py-4">

                                    <div class="flex justify-end gap-2">

                                        <a href="{{ route('categories.show', $category) }}"
                                            class="text-sm font-medium text-slate-500 hover:text-[#8F348E]">

                                            Detail

                                        </a>

                                        <a href="{{ route('categories.edit', $category) }}"
                                            class="text-sm font-medium text-[#8F348E]">

                                            Edit

                                        </a>

                                        <form method="POST" action="{{ route('categories.toggle-status', $category) }}">

                                            @csrf
                                            @method('PATCH')

                                            <button type="submit" class="text-sm font-medium text-[#FAAC3F]">

                                                {{ $category->is_active ? 'Nonaktifkan' : 'Aktifkan' }}

                                            </button>

                                        </form>

                                        <form method="POST" action="{{ route('categories.destroy', $category) }}"
                                            onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="text-sm font-medium text-[#E94025]">

                                                Hapus

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5" class="px-5 py-16 text-center text-sm text-slate-500">

                                    Belum ada kategori inventaris.

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

            @if ($categories->hasPages())
                <div class="border-t border-slate-100 px-5 py-4">
                    {{ $categories->links() }}
                </div>
            @endif

        </div>

    </div>

@endsection
