@extends('layouts.app')

@section('title', 'Scan Barcode')

@section('page-title', 'Scan Barcode')

@section('content')

    <div class="mx-auto max-w-3xl space-y-6">

        {{-- Header --}}
        <div>

            <h2 class="text-2xl font-bold text-slate-900">
                Scan Barcode Inventaris
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Scan barcode aset atau masukkan kode barcode secara manual.
            </p>

        </div>


        {{-- Scanner --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

            <div class="text-center">

                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-[#8F348E]/10 text-2xl">
                    📦
                </div>

                <h3 class="mt-4 text-lg font-bold text-slate-900">
                    Barcode Inventaris
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    Gunakan scanner barcode atau ketik kode secara manual.
                </p>

            </div>


            <form method="GET" action="{{ route('inventory.search-barcode') }}" class="mt-6">

                <label for="barcode" class="mb-2 block text-sm font-semibold text-slate-700">

                    Barcode

                </label>


                <div class="flex flex-col gap-3 sm:flex-row">

                    <input type="text" name="barcode" id="barcode" autofocus autocomplete="off"
                        placeholder="WZM-2026-00000001"
                        class="w-full rounded-xl border-slate-200 focus:border-[#8F348E] focus:ring-[#8F348E] sm:flex-1">


                    <button type="submit"
                        class="rounded-xl bg-[#8F348E] px-6 py-3 text-sm font-semibold text-white hover:bg-[#752c74]">

                        Cari

                    </button>

                </div>

            </form>


            @if (session('error'))
                <div class="mt-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700">

                    {{ session('error') }}

                </div>
            @endif

        </div>


        {{-- Information --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

            <h3 class="font-bold text-slate-900">
                Cara Penggunaan
            </h3>

            <div class="mt-5 space-y-4">

                <div class="flex gap-3">

                    <div
                        class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-[#8F348E] text-sm font-bold text-white">
                        1
                    </div>

                    <p class="text-sm text-slate-600">
                        Klik kolom barcode.
                    </p>

                </div>


                <div class="flex gap-3">

                    <div
                        class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-[#DF3C95] text-sm font-bold text-white">
                        2
                    </div>

                    <p class="text-sm text-slate-600">
                        Scan barcode menggunakan scanner.
                    </p>

                </div>


                <div class="flex gap-3">

                    <div
                        class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-[#FAAC3F] text-sm font-bold text-white">
                        3
                    </div>

                    <p class="text-sm text-slate-600">
                        Sistem akan mencari inventaris secara otomatis.
                    </p>

                </div>


                <div class="flex gap-3">

                    <div
                        class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-[#E94025] text-sm font-bold text-white">
                        4
                    </div>

                    <p class="text-sm text-slate-600">
                        Detail inventaris akan ditampilkan.
                    </p>

                </div>

            </div>

        </div>

    </div>

@endsection
