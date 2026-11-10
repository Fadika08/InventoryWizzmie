<table>
    <thead>
        <tr>
            <th colspan="12"
                style="background-color:#8F348E; color:#FFFFFF;
                       font-size:18px; font-weight:bold;
                       text-align:center; height:30px;">
                WIZZMiE - REPORT INVENTARIS
            </th>
        </tr>

        <tr>
            <th colspan="12" style="font-size:11px; text-align:center; height:22px;">
                Laporan Inventaris
            </th>
        </tr>

        <tr>
            <th colspan="12" style="font-size:10px; text-align:center;">
                Periode:
                {{ $filters['date_from'] }}
                -
                {{ $filters['date_to'] }}
            </th>
        </tr>

        <tr>
            <th colspan="12">&nbsp;</th>
        </tr>

        <tr>
            <th colspan="2" style="font-weight:bold;">
                Lokasi
            </th>
            <th colspan="3">
                {{ $filters['location'] }}
            </th>
            <th colspan="2" style="font-weight:bold;">
                Pencarian
            </th>
            <th colspan="5">
                {{ $filters['search'] }}
            </th>
        </tr>

        <tr>
            <th colspan="3" style="font-weight:bold;">
                Total Data Inventaris
            </th>
            <th>
                {{ $items->count() }}
            </th>
            <th colspan="3" style="font-weight:bold;">
                Total Jumlah Barang
            </th>
            <th>
                {{ (int) $items->sum('quantity') }}
            </th>
            <th colspan="4">&nbsp;</th>
        </tr>

        <tr>
            <th colspan="12">&nbsp;</th>
        </tr>

        <tr>
            @php
                $headers = [
                    ['No', 7],
                    ['Kode Inventaris', 22],
                    ['Nama Barang', 30],
                    ['Jumlah', 12],
                    ['Kategori', 20],
                    ['Brand / Model', 25],
                    ['Serial Number', 22],
                    ['Lokasi', 25],
                    ['Divisi', 22],
                    ['Kondisi', 18],
                    ['Status', 18],
                    ['Tanggal Pembelian', 20],
                ];
            @endphp

            @foreach ($headers as [$label, $width])
                <th width="{{ $width }}"
                    style="background-color:#8F348E; color:#FFFFFF;
                           font-weight:bold; text-align:center;
                           border:1px solid #D1D5DB;">
                    {{ $label }}
                </th>
            @endforeach
        </tr>
    </thead>

    <tbody>
        @php
            $conditionLabels = [
                'good' => 'Baik',
                'minor_damage' => 'Rusak Ringan',
                'damaged' => 'Rusak',
                'lost' => 'Hilang',
            ];

            $statusLabels = [
                'active' => 'Aktif',
                'maintenance' => 'Maintenance',
                'borrowed' => 'Dipinjam',
                'lost' => 'Hilang',
                'disposed' => 'Dihapus',
            ];
        @endphp

        @forelse ($items as $item)
            <tr>
                <td style="border:1px solid #E5E7EB; text-align:center;">
                    {{ $loop->iteration }}
                </td>

                <td style="border:1px solid #E5E7EB;">
                    {{ $item->inventory_code }}
                </td>

                <td style="border:1px solid #E5E7EB;">
                    {{ $item->name }}
                </td>

                <td style="border:1px solid #E5E7EB; text-align:right;">
                    {{ (int) $item->quantity }}
                </td>

                <td style="border:1px solid #E5E7EB;">
                    {{ $item->category?->name ?? '-' }}
                </td>

                <td style="border:1px solid #E5E7EB;">
                    {{ trim(($item->brand ?? '') . ' ' . ($item->model ?? '')) ?: '-' }}
                </td>

                <td style="border:1px solid #E5E7EB;">
                    {{ $item->serial_number ?: '-' }}
                </td>

                <td style="border:1px solid #E5E7EB;">
                    @if (in_array($item->location_type, ['head_office', 'dbl'], true))
                        {{ $item->location_type === 'dbl' ? 'DBL' : 'Head Office' }}

                        @if ($item->room)
                            - {{ $item->room->name }}
                        @endif
                    @elseif ($item->location_type === 'outlet')
                        {{ $item->outlet?->name ?? 'Outlet' }}
                    @else
                        {{ $item->location_type ?? '-' }}
                    @endif
                </td>

                <td style="border:1px solid #E5E7EB;">
                    {{ $item->department?->name ?? '-' }}
                </td>

                <td style="border:1px solid #E5E7EB;">
                    {{ $conditionLabels[$item->condition_status] ?? ($item->condition_status ?? '-') }}
                </td>

                <td style="border:1px solid #E5E7EB;">
                    {{ $statusLabels[$item->status] ?? ($item->status ?? '-') }}
                </td>

                <td style="border:1px solid #E5E7EB; text-align:center;">
                    {{ $item->purchase_date?->format('d/m/Y') ?? '-' }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="12" style="border:1px solid #E5E7EB; text-align:center;">
                    Tidak ada data inventaris berdasarkan filter.
                </td>
            </tr>
        @endforelse

        <tr>
            <td colspan="3"
                style="background-color:#F3F4F6; font-weight:bold;
                       border:1px solid #D1D5DB;">
                Total Jumlah Barang
            </td>

            <td
                style="background-color:#F3F4F6; font-weight:bold;
                       text-align:right; border:1px solid #D1D5DB;">
                {{ (int) $items->sum('quantity') }}
            </td>

            <td colspan="8" style="background-color:#F3F4F6; border:1px solid #D1D5DB;">
                &nbsp;
            </td>
        </tr>
    </tbody>
</table>
