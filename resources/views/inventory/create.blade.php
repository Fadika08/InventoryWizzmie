@extends('layouts.app')

@section('title', 'Tambah Inventaris')

@section('page-title', 'Tambah Inventaris')

@section('content')

    <div class="mx-auto max-w-5xl space-y-6">

        <div>

            <a href="{{ route('inventory.index') }}" class="text-sm font-semibold text-[#8F348E] hover:underline">

                ← Kembali ke Inventaris

            </a>

            <h2 class="mt-3 text-2xl font-bold text-slate-900">
                Tambah Inventaris
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Masukkan data inventaris secara lengkap.
            </p>

        </div>


        @if ($errors->any())

            <div class="rounded-xl border border-red-200 bg-red-50 p-4">

                <p class="font-semibold text-red-700">
                    Terdapat kesalahan:
                </p>

                <ul class="mt-2 list-inside list-disc text-sm text-red-600">

                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach

                </ul>

            </div>

        @endif


        <form method="POST" action="{{ route('inventory.store') }}" enctype="multipart/form-data" class="space-y-6">

            @csrf


            {{-- Identitas --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                <h3 class="text-lg font-bold text-slate-900">
                    Identitas Barang
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    Informasi utama inventaris.
                </p>


                <div class="mt-6 grid gap-5 md:grid-cols-2">

                    <div class="md:col-span-2">

                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                            Nama Barang *
                        </label>

                        <input type="text" name="name" value="{{ old('name') }}" required
                            placeholder="Contoh: Laptop Lenovo ThinkPad"
                            class="w-full rounded-xl border-slate-200 focus:border-[#8F348E] focus:ring-[#8F348E]">

                    </div>


                    <div>

                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                            Kategori *
                        </label>

                        <select name="category_id" required
                            class="w-full rounded-xl border-slate-200 focus:border-[#8F348E] focus:ring-[#8F348E]">

                            <option value="">
                                Pilih kategori
                            </option>

                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>

                                    {{ $category->code }} - {{ $category->name }}

                                </option>
                            @endforeach

                        </select>

                    </div>


                    <div>

                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                            Brand
                        </label>

                        <input type="text" name="brand" value="{{ old('brand') }}" placeholder="Contoh: Lenovo"
                            class="w-full rounded-xl border-slate-200 focus:border-[#8F348E] focus:ring-[#8F348E]">

                    </div>


                    <div>

                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                            Model
                        </label>

                        <input type="text" name="model" value="{{ old('model') }}"
                            placeholder="Contoh: ThinkPad E14 Gen 5"
                            class="w-full rounded-xl border-slate-200 focus:border-[#8F348E] focus:ring-[#8F348E]">

                    </div>


                    <div>

                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                            Serial Number
                        </label>

                        <input type="text" name="serial_number" value="{{ old('serial_number') }}"
                            placeholder="Serial number perangkat"
                            class="w-full rounded-xl border-slate-200 focus:border-[#8F348E] focus:ring-[#8F348E]">

                    </div>


                    <div class="md:col-span-2">

                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                            Spesifikasi
                        </label>

                        <textarea name="specification" rows="4" placeholder="Contoh: Intel Core i5, RAM 16GB, SSD 512GB..."
                            class="w-full rounded-xl border-slate-200 focus:border-[#8F348E] focus:ring-[#8F348E]">{{ old('specification') }}</textarea>

                    </div>

                </div>

            </div>


            {{-- Lokasi --}}
            {{-- Lokasi --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                <h3 class="text-lg font-bold text-slate-900">
                    Lokasi Inventaris
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    Tentukan lokasi barang berada.
                </p>


                {{-- ===================================================== --}}
                {{-- OUTLET ADMIN --}}
                {{-- ===================================================== --}}

                @if (auth()->user()->isOutletAdmin())

                    <input type="hidden" name="location_type" value="outlet">


                    @php
                        $myOutlet = $outlets->first();
                    @endphp


                    <div class="mt-6">

                        <label class="mb-2 block text-sm font-semibold text-slate-700">

                            Outlet

                            <span class="text-red-500">*</span>

                        </label>


                        @if ($myOutlet)

                            {{-- PENTING:
                     outlet_id tetap dikirim ke server
                --}}
                            <input type="hidden" name="outlet_id" value="{{ $myOutlet->id }}">


                            <div class="rounded-xl border-2 border-[#8F348E] bg-[#8F348E]/5 p-5">

                                <div class="flex items-center gap-4">

                                    <div
                                        class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-[#8F348E] text-white">

                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 10l9-7 9 7v10a2 2 0 01-2 2H5a2 2 0 01-2-2V10z" />

                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 21v-6h6v6" />

                                        </svg>

                                    </div>


                                    <div>

                                        <p class="text-xs font-bold uppercase tracking-wide text-[#8F348E]">
                                            Outlet Anda
                                        </p>

                                        <p class="mt-1 text-base font-bold text-slate-900">
                                            {{ $myOutlet->code }}
                                            -
                                            {{ $myOutlet->name }}
                                        </p>

                                        @if ($myOutlet->city || $myOutlet->area)

                                            <p class="mt-1 text-sm text-slate-500">

                                                {{ $myOutlet->city }}

                                                @if ($myOutlet->city && $myOutlet->area)
                                                    ·
                                                @endif

                                                {{ $myOutlet->area }}

                                            </p>

                                        @endif

                                    </div>

                                </div>

                            </div>
                        @else
                            <div class="rounded-xl border border-red-200 bg-red-50 p-5">

                                <p class="font-semibold text-red-700">
                                    Outlet belum terhubung dengan akun Anda.
                                </p>

                                <p class="mt-1 text-sm text-red-600">
                                    Hubungi Super Admin IT untuk mengatur outlet akun Anda.
                                </p>

                            </div>

                        @endif

                    </div>


                    {{-- ===================================================== --}}
                    {{-- SUPER ADMIN --}}
                    {{-- ===================================================== --}}
                @elseif(auth()->user()->isSuperAdmin())
                    <div class="mt-6">

                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                            Jenis Lokasi *
                        </label>


                        <div class="grid gap-3 sm:grid-cols-2">

                            <label
                                class="location-option cursor-pointer rounded-xl border-2 border-slate-200 p-4 transition hover:border-[#8F348E]">

                                <input type="radio" name="location_type" value="head_office" class="location-type sr-only"
                                    @checked(old('location_type', 'head_office') === 'head_office')>

                                <p class="font-semibold text-slate-800">
                                    Head Office
                                </p>

                                <p class="mt-1 text-xs text-slate-500">
                                    Inventaris yang berada di kantor pusat.
                                </p>

                            </label>


                            <label
                                class="location-option cursor-pointer rounded-xl border-2 border-slate-200 p-4 transition hover:border-[#8F348E]">

                                <input type="radio" name="location_type" value="outlet" class="location-type sr-only"
                                    @checked(old('location_type') === 'outlet')>

                                <p class="font-semibold text-slate-800">
                                    Outlet
                                </p>

                                <p class="mt-1 text-xs text-slate-500">
                                    Inventaris yang berada di outlet.
                                </p>

                            </label>

                        </div>

                    </div>


                    {{-- Head Office --}}
                    <div id="head-office-fields" class="mt-6 grid gap-5 md:grid-cols-2">

                        <div>

                            <label for="department_id" class="mb-2 block text-sm font-semibold text-slate-700">

                                Divisi *

                            </label>

                            <select id="department_id" name="department_id"
                                class="w-full rounded-xl border-slate-200 focus:border-[#8F348E] focus:ring-[#8F348E]">

                                <option value="">
                                    Pilih Divisi
                                </option>

                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}" @selected(old('department_id') == $department->id)>

                                        {{ $department->code }}
                                        -
                                        {{ $department->name }}

                                    </option>
                                @endforeach

                            </select>

                        </div>


                        <div>

                            <label for="room_id" class="mb-2 block text-sm font-semibold text-slate-700">

                                Ruangan *

                            </label>

                            <select id="room_id" name="room_id"
                                class="w-full rounded-xl border-slate-200 focus:border-[#8F348E] focus:ring-[#8F348E]">

                                <option value="">
                                    Pilih divisi terlebih dahulu
                                </option>

                            </select>

                        </div>

                    </div>


                    {{-- Outlet --}}
                    <div id="outlet-fields" class="mt-6 hidden">

                        <label for="outlet_id" class="mb-2 block text-sm font-semibold text-slate-700">

                            Outlet *

                        </label>


                        <select id="outlet_id" name="outlet_id"
                            class="w-full rounded-xl border-slate-200 focus:border-[#8F348E] focus:ring-[#8F348E]">

                            <option value="">
                                Pilih Outlet
                            </option>

                            @foreach ($outlets as $outlet)
                                <option value="{{ $outlet->id }}" @selected(old('outlet_id') == $outlet->id)>

                                    {{ $outlet->code }}
                                    -
                                    {{ $outlet->name }}

                                </option>
                            @endforeach

                        </select>

                    </div>


                    {{-- ===================================================== --}}
                    {{-- HO ADMIN --}}
                    {{-- ===================================================== --}}
                @elseif(auth()->user()->isHoAdmin())
                    <input type="hidden" name="location_type" value="head_office">


                    <div class="mt-6 grid gap-5 md:grid-cols-2">

                        <div>

                            <label for="department_id" class="mb-2 block text-sm font-semibold text-slate-700">

                                Divisi *

                            </label>

                            <select id="department_id" name="department_id" required
                                class="w-full rounded-xl border-slate-200 focus:border-[#8F348E] focus:ring-[#8F348E]">

                                <option value="">
                                    Pilih Divisi
                                </option>

                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}" @selected(old('department_id') == $department->id)>

                                        {{ $department->code }}
                                        -
                                        {{ $department->name }}

                                    </option>
                                @endforeach

                            </select>

                        </div>


                        <div>

                            <label for="room_id" class="mb-2 block text-sm font-semibold text-slate-700">

                                Ruangan *

                            </label>

                            <select id="room_id" name="room_id" required
                                class="w-full rounded-xl border-slate-200 focus:border-[#8F348E] focus:ring-[#8F348E]">

                                <option value="">
                                    Pilih divisi terlebih dahulu
                                </option>

                            </select>

                        </div>

                    </div>

                @endif

            </div>


            {{-- Kondisi --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                <h3 class="text-lg font-bold text-slate-900">
                    Kondisi & Status
                </h3>


                <div class="mt-6 grid gap-5 md:grid-cols-2">

                    <div>

                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                            Kondisi *
                        </label>

                        <select name="condition_status" required
                            class="w-full rounded-xl border-slate-200 focus:border-[#8F348E] focus:ring-[#8F348E]">

                            <option value="good" @selected(old('condition_status', 'good') === 'good')>
                                Baik
                            </option>

                            <option value="minor_damage" @selected(old('condition_status') === 'minor_damage')>
                                Kerusakan Ringan
                            </option>

                            <option value="damaged" @selected(old('condition_status') === 'damaged')>
                                Rusak
                            </option>

                            <option value="lost" @selected(old('condition_status') === 'lost')>
                                Hilang
                            </option>

                        </select>

                    </div>


                    <div>

                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                            Status *
                        </label>

                        <select name="status" required
                            class="w-full rounded-xl border-slate-200 focus:border-[#8F348E] focus:ring-[#8F348E]">

                            <option value="active" @selected(old('status', 'active') === 'active')>
                                Aktif
                            </option>

                            <option value="maintenance" @selected(old('status') === 'maintenance')>
                                Maintenance
                            </option>

                            <option value="borrowed" @selected(old('status') === 'borrowed')>
                                Dipinjam
                            </option>

                            <option value="lost" @selected(old('status') === 'lost')>
                                Hilang
                            </option>

                        </select>

                    </div>

                </div>

            </div>


            {{-- Pembelian --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                <h3 class="text-lg font-bold text-slate-900">
                    Informasi Pembelian & Garansi
                </h3>


                <div class="mt-6 grid gap-5 md:grid-cols-2">

                    <div>

                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                            Tanggal Pembelian
                        </label>

                        <input type="date" name="purchase_date" value="{{ old('purchase_date') }}"
                            class="w-full rounded-xl border-slate-200 focus:border-[#8F348E] focus:ring-[#8F348E]">

                    </div>


                    <div>

                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                            Harga Pembelian
                        </label>

                        <input type="number" name="purchase_price" value="{{ old('purchase_price') }}" min="0"
                            step="0.01" placeholder="0"
                            class="w-full rounded-xl border-slate-200 focus:border-[#8F348E] focus:ring-[#8F348E]">

                    </div>


                    <div>

                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                            Garansi Mulai
                        </label>

                        <input type="date" name="warranty_start" value="{{ old('warranty_start') }}"
                            class="w-full rounded-xl border-slate-200 focus:border-[#8F348E] focus:ring-[#8F348E]">

                    </div>


                    <div>

                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                            Garansi Berakhir
                        </label>

                        <input type="date" name="warranty_end" value="{{ old('warranty_end') }}"
                            class="w-full rounded-xl border-slate-200 focus:border-[#8F348E] focus:ring-[#8F348E]">

                    </div>

                </div>

            </div>


            {{-- Dokumentasi --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                <h3 class="text-lg font-bold text-slate-900">
                    Dokumentasi
                </h3>


                <div class="mt-6">

                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Foto Barang
                    </label>

                    <input type="file" name="primary_photo" accept=".jpg,.jpeg,.png,.webp"
                        class="w-full rounded-xl border border-slate-200 p-2 text-sm">

                    <p class="mt-1 text-xs text-slate-400">
                        JPG, PNG atau WEBP. Maksimal 5 MB.
                    </p>

                </div>


                <div class="mt-5">

                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Keterangan
                    </label>

                    <textarea name="description" rows="4" placeholder="Keterangan tambahan..."
                        class="w-full rounded-xl border-slate-200 focus:border-[#8F348E] focus:ring-[#8F348E]">{{ old('description') }}</textarea>

                </div>

            </div>


            {{-- Submit --}}
            <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

                <a href="{{ route('inventory.index') }}"
                    class="rounded-xl border border-slate-200 px-6 py-3 text-center text-sm font-semibold text-slate-600">

                    Batal

                </a>

                <button type="submit"
                    class="rounded-xl bg-[#8F348E] px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-[#752c74]">

                    Simpan Inventaris

                </button>

            </div>

        </form>

    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const locationTypes =
                document.querySelectorAll('.location-type');

            const hoFields =
                document.getElementById('head-office-fields');

            const outletFields =
                document.getElementById('outlet-fields');

            const department =
                document.getElementById('department_id');

            const room =
                document.getElementById('room_id');


            function updateLocationFields() {

                const selected =
                    document.querySelector(
                        '.location-type:checked'
                    )?.value;

                if (selected === 'outlet') {

                    hoFields.classList.add('hidden');
                    outletFields.classList.remove('hidden');

                    department.value = '';
                    room.innerHTML =
                        '<option value="">Pilih divisi terlebih dahulu</option>';

                } else {

                    hoFields.classList.remove('hidden');
                    outletFields.classList.add('hidden');

                    document.getElementById('outlet_id').value = '';

                }
            }


            async function loadRooms(
                departmentId,
                selectedRoom = null
            ) {

                room.innerHTML =
                    '<option value="">Memuat ruangan...</option>';

                if (!departmentId) {

                    room.innerHTML =
                        '<option value="">Pilih divisi terlebih dahulu</option>';

                    return;
                }

                try {

                    const response = await fetch(
                        `{{ route('inventory.rooms') }}?department_id=${departmentId}`
                    );

                    const rooms = await response.json();

                    room.innerHTML =
                        '<option value="">Pilih Ruangan</option>';

                    rooms.forEach(function(item) {

                        const option =
                            document.createElement('option');

                        option.value = item.id;

                        option.textContent =
                            `${item.code} - ${item.name}`;

                        if (
                            selectedRoom &&
                            Number(selectedRoom) === Number(item.id)
                        ) {
                            option.selected = true;
                        }

                        room.appendChild(option);

                    });

                } catch (error) {

                    room.innerHTML =
                        '<option value="">Gagal memuat ruangan</option>';

                    console.error(error);
                }
            }


            locationTypes.forEach(function(radio) {

                radio.addEventListener(
                    'change',
                    updateLocationFields
                );

            });


            department.addEventListener(
                'change',
                function() {
                    loadRooms(this.value);
                }
            );


            updateLocationFields();


            @if (old('department_id'))

                loadRooms(
                    '{{ old('department_id') }}',
                    '{{ old('room_id') }}'
                );
            @endif

        });
    </script>

@endsection
