@extends('layouts.app')

@section('title', 'Edit Inventaris')

@section('page-title', 'Edit Inventaris')

@section('content')

    <div class="mx-auto max-w-5xl space-y-6">

        {{-- Header --}}
        <div>

            <a href="{{ route('inventory.show', $inventory) }}" class="text-sm font-semibold text-[#8F348E] hover:underline">

                ← Kembali ke Detail

            </a>

            <h2 class="mt-3 text-2xl font-bold text-slate-900">
                Edit Inventaris
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Perbarui informasi inventaris {{ $inventory->inventory_code }}.
            </p>

        </div>


        {{-- Error --}}
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


        <form method="POST" action="{{ route('inventory.update', $inventory) }}" enctype="multipart/form-data"
            class="space-y-6">

            @csrf
            @method('PUT')


            {{-- Identitas --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                <h3 class="text-lg font-bold text-slate-900">
                    Identitas Barang
                </h3>


                <div class="mt-6 grid gap-5 md:grid-cols-2">

                    {{-- Inventory Code --}}
                    <div>

                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                            Kode Inventaris
                        </label>

                        <input type="text" value="{{ $inventory->inventory_code }}" readonly
                            class="w-full rounded-xl border-slate-200 bg-slate-50 text-slate-500">

                        <p class="mt-1 text-xs text-slate-400">
                            Kode dibuat otomatis oleh sistem.
                        </p>

                    </div>


                    {{-- Barcode --}}
                    <div>

                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                            Barcode
                        </label>

                        <input type="text" value="{{ $inventory->barcode }}" readonly
                            class="w-full rounded-xl border-slate-200 bg-slate-50 text-slate-500">

                    </div>


                    <div class="md:col-span-2">

                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                            Nama Barang *
                        </label>

                        <input type="text" name="name" value="{{ old('name', $inventory->name) }}" required
                            class="w-full rounded-xl border-slate-200 focus:border-[#8F348E] focus:ring-[#8F348E]">

                    </div>


                    <div>

                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                            Kategori *
                        </label>

                        <select name="category_id" required
                            class="w-full rounded-xl border-slate-200 focus:border-[#8F348E] focus:ring-[#8F348E]">

                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id', $inventory->category_id) == $category->id)>

                                    {{ $category->code }} - {{ $category->name }}

                                </option>
                            @endforeach

                        </select>

                    </div>


                    <div>

                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                            Brand
                        </label>

                        <input type="text" name="brand" value="{{ old('brand', $inventory->brand) }}"
                            class="w-full rounded-xl border-slate-200 focus:border-[#8F348E] focus:ring-[#8F348E]">

                    </div>


                    <div>

                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                            Model
                        </label>

                        <input type="text" name="model" value="{{ old('model', $inventory->model) }}"
                            class="w-full rounded-xl border-slate-200 focus:border-[#8F348E] focus:ring-[#8F348E]">

                    </div>


                    <div>

                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                            Serial Number
                        </label>

                        <input type="text" name="serial_number"
                            value="{{ old('serial_number', $inventory->serial_number) }}"
                            class="w-full rounded-xl border-slate-200 focus:border-[#8F348E] focus:ring-[#8F348E]">

                    </div>


                    <div class="md:col-span-2">

                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                            Spesifikasi
                        </label>

                        <textarea name="specification" rows="5"
                            class="w-full rounded-xl border-slate-200 focus:border-[#8F348E] focus:ring-[#8F348E]">{{ old('specification', $inventory->specification) }}</textarea>

                    </div>

                </div>

            </div>


            {{-- Lokasi --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                <h3 class="text-lg font-bold text-slate-900">
                    Lokasi Inventaris
                </h3>


                <div class="mt-6 grid gap-3 sm:grid-cols-2">

                    <label class="location-option cursor-pointer rounded-xl border-2 border-slate-200 p-4">

                        <input type="radio" name="location_type" value="head_office" class="location-type sr-only"
                            @checked(old('location_type', $inventory->location_type) === 'head_office')>

                        <p class="font-semibold text-slate-800">
                            Head Office
                        </p>

                        <p class="mt-1 text-xs text-slate-500">
                            Inventaris Head Office.
                        </p>

                    </label>


                    <label class="location-option cursor-pointer rounded-xl border-2 border-slate-200 p-4">

                        <input type="radio" name="location_type" value="outlet" class="location-type sr-only"
                            @checked(old('location_type', $inventory->location_type) === 'outlet')>

                        <p class="font-semibold text-slate-800">
                            Outlet
                        </p>

                        <p class="mt-1 text-xs text-slate-500">
                            Inventaris outlet.
                        </p>

                    </label>

                </div>


                {{-- HO --}}
                <div id="head-office-fields" class="mt-6 grid gap-5 md:grid-cols-2">

                    <div>

                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                            Divisi *
                        </label>

                        <select id="department_id" name="department_id"
                            class="w-full rounded-xl border-slate-200 focus:border-[#8F348E] focus:ring-[#8F348E]">

                            <option value="">
                                Pilih Divisi
                            </option>

                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}" @selected(old('department_id', $inventory->department_id) == $department->id)>

                                    {{ $department->code }} - {{ $department->name }}

                                </option>
                            @endforeach

                        </select>

                    </div>


                    <div>

                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                            Ruangan *
                        </label>

                        <select id="room_id" name="room_id"
                            class="w-full rounded-xl border-slate-200 focus:border-[#8F348E] focus:ring-[#8F348E]">

                            <option value="">
                                Memuat ruangan...
                            </option>

                            @foreach ($rooms as $room)
                                <option value="{{ $room->id }}" @selected(old('room_id', $inventory->room_id) == $room->id)>

                                    {{ $room->code }} - {{ $room->name }}

                                </option>
                            @endforeach

                        </select>

                    </div>

                </div>


                {{-- Outlet --}}
                <div id="outlet-fields" class="mt-6">

                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Outlet *
                    </label>

                    <select id="outlet_id" name="outlet_id"
                        class="w-full rounded-xl border-slate-200 focus:border-[#8F348E] focus:ring-[#8F348E]">

                        <option value="">
                            Pilih Outlet
                        </option>

                        @foreach ($outlets as $outlet)
                            <option value="{{ $outlet->id }}" @selected(old('outlet_id', $inventory->outlet_id) == $outlet->id)>

                                {{ $outlet->code }} - {{ $outlet->name }}

                            </option>
                        @endforeach

                    </select>

                </div>

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

                            <option value="good" @selected(old('condition_status', $inventory->condition_status) === 'good')>
                                Baik
                            </option>

                            <option value="minor_damage" @selected(old('condition_status', $inventory->condition_status) === 'minor_damage')>
                                Kerusakan Ringan
                            </option>

                            <option value="damaged" @selected(old('condition_status', $inventory->condition_status) === 'damaged')>
                                Rusak
                            </option>

                            <option value="lost" @selected(old('condition_status', $inventory->condition_status) === 'lost')>
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

                            <option value="active" @selected(old('status', $inventory->status) === 'active')>
                                Aktif
                            </option>

                            <option value="maintenance" @selected(old('status', $inventory->status) === 'maintenance')>
                                Maintenance
                            </option>

                            <option value="borrowed" @selected(old('status', $inventory->status) === 'borrowed')>
                                Dipinjam
                            </option>

                            <option value="lost" @selected(old('status', $inventory->status) === 'lost')>
                                Hilang
                            </option>

                            <option value="disposed" @selected(old('status', $inventory->status) === 'disposed')>
                                Dihapus
                            </option>

                        </select>

                    </div>

                </div>

            </div>


            {{-- Pembelian --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                <h3 class="text-lg font-bold text-slate-900">
                    Pembelian & Garansi
                </h3>


                <div class="mt-6 grid gap-5 md:grid-cols-2">

                    <div>

                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                            Tanggal Pembelian
                        </label>

                        <input type="date" name="purchase_date"
                            value="{{ old('purchase_date', $inventory->purchase_date?->format('Y-m-d')) }}"
                            class="w-full rounded-xl border-slate-200 focus:border-[#8F348E] focus:ring-[#8F348E]">

                    </div>


                    <div>

                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                            Harga Pembelian
                        </label>

                        <input type="number" name="purchase_price"
                            value="{{ old('purchase_price', $inventory->purchase_price) }}" min="0"
                            step="0.01"
                            class="w-full rounded-xl border-slate-200 focus:border-[#8F348E] focus:ring-[#8F348E]">

                    </div>


                    <div>

                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                            Garansi Mulai
                        </label>

                        <input type="date" name="warranty_start"
                            value="{{ old('warranty_start', $inventory->warranty_start?->format('Y-m-d')) }}"
                            class="w-full rounded-xl border-slate-200 focus:border-[#8F348E] focus:ring-[#8F348E]">

                    </div>


                    <div>

                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                            Garansi Berakhir
                        </label>

                        <input type="date" name="warranty_end"
                            value="{{ old('warranty_end', $inventory->warranty_end?->format('Y-m-d')) }}"
                            class="w-full rounded-xl border-slate-200 focus:border-[#8F348E] focus:ring-[#8F348E]">

                    </div>

                </div>

            </div>


            {{-- Foto --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                <h3 class="text-lg font-bold text-slate-900">
                    Dokumentasi
                </h3>


                @if ($inventory->primary_photo)
                    <div class="mb-5">

                        <p class="mb-2 text-sm font-semibold text-slate-700">
                            Foto Saat Ini
                        </p>

                        <img src="{{ asset('storage/' . $inventory->primary_photo) }}" alt="{{ $inventory->name }}"
                            class="h-48 w-48 rounded-xl object-cover ring-1 ring-slate-200">

                    </div>
                @endif


                <label class="mb-2 block text-sm font-semibold text-slate-700">
                    Ganti Foto
                </label>

                <input type="file" name="primary_photo" accept=".jpg,.jpeg,.png,.webp"
                    class="w-full rounded-xl border border-slate-200 p-2 text-sm">

                <p class="mt-1 text-xs text-slate-400">
                    Kosongkan jika tidak ingin mengganti foto.
                </p>


                <div class="mt-5">

                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Keterangan
                    </label>

                    <textarea name="description" rows="4"
                        class="w-full rounded-xl border-slate-200 focus:border-[#8F348E] focus:ring-[#8F348E]">{{ old('description', $inventory->description) }}</textarea>

                </div>

            </div>


            {{-- Button --}}
            <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

                <a href="{{ route('inventory.show', $inventory) }}"
                    class="rounded-xl border border-slate-200 px-6 py-3 text-center text-sm font-semibold text-slate-600">

                    Batal

                </a>

                <button type="submit"
                    class="rounded-xl bg-[#8F348E] px-6 py-3 text-sm font-semibold text-white hover:bg-[#752c74]">

                    Simpan Perubahan

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

                } else {

                    hoFields.classList.remove('hidden');

                    outletFields.classList.add('hidden');

                }
            }


            async function loadRooms(
                departmentId,
                selectedRoom = null
            ) {

                if (!departmentId) {

                    room.innerHTML =
                        '<option value="">Pilih divisi terlebih dahulu</option>';

                    return;

                }

                room.innerHTML =
                    '<option value="">Memuat ruangan...</option>';

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

                    loadRooms(
                        this.value
                    );

                }
            );


            updateLocationFields();


            /*
            |--------------------------------------------------------------------------
            | Load room ketika halaman pertama dibuka
            |--------------------------------------------------------------------------
            */

            @if ($inventory->department_id)

                loadRooms(
                    '{{ $inventory->department_id }}',
                    '{{ $inventory->room_id }}'
                );
            @endif

        });
    </script>

@endsection
