<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Report Inventaris</title>

    <style>
        @page {
            margin: 25px 20px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 8px;
            color: #1e293b;
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
        }

        .title {
            font-size: 18px;
            font-weight: bold;
            color: #8F348E;
        }

        .subtitle {
            font-size: 10px;
            margin-top: 4px;
            color: #64748b;
        }

        .summary {
            width: 100%;
            table-layout: fixed;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        .summary td {
            border: 1px solid #e2e8f0;
            padding: 7px 4px;
            text-align: center;
        }

        .summary-title {
            font-size: 7px;
            color: #64748b;
        }

        .summary-value {
            font-size: 13px;
            font-weight: bold;
            margin-top: 3px;
        }

        .quantity-summary {
            padding: 8px;
            margin-bottom: 15px;
            background: #faf5ff;
            border: 1px solid #e9d5ff;
            font-size: 10px;
            color: #8F348E;
        }

        .filters {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .filters td {
            padding: 4px;
            border-bottom: 1px solid #e2e8f0;
        }

        .filter-label {
            font-weight: bold;
            width: 18%;
        }

        table.report {
            width: 100%;
            table-layout: fixed;
            border-collapse: collapse;
        }

        table.report thead {
            display: table-header-group;
        }

        table.report th {
            background: #8F348E;
            color: white;
            border: 1px solid #d1d5db;
            padding: 6px 4px;
            font-size: 7px;
            text-align: center;
        }

        table.report td {
            border: 1px solid #d1d5db;
            padding: 5px 4px;
            font-size: 7px;
            vertical-align: top;
            word-wrap: break-word;
        }

        table.report tbody tr:nth-child(even) td {
            background: #f8fafc;
        }

        table.report tr {
            page-break-inside: avoid;
        }

        table.report tbody tr.total-row td {
            background: #f1f5f9;
            font-weight: bold;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .footer {
            margin-top: 15px;
            text-align: right;
            font-size: 7px;
            color: #64748b;
        }
    </style>
</head>

<body>
    @php
        $totalQuantity = $items->sum('quantity');

        $summaryCards = [
            'TOTAL DATA' => $statistics['total'],
            'HEAD OFFICE' => $statistics['head_office'],
            'DBL' => $statistics['dbl'],
            'OUTLET' => $statistics['outlet'],
            'KONDISI BAIK' => $statistics['baik'],
            'KONDISI RUSAK' => $statistics['rusak'],
        ];

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

    <div class="header">
        <div class="title">
            WIZZMiE INVENTORY SYSTEM
        </div>

        <div class="subtitle">
            REPORT INVENTARIS
        </div>
    </div>

    <table class="summary">
        <tr>
            @foreach ($summaryCards as $label => $value)
                <td>
                    <div class="summary-title">
                        {{ $label }}
                    </div>

                    <div class="summary-value">
                        {{ number_format($value, 0, ',', '.') }}
                    </div>
                </td>
            @endforeach
        </tr>
    </table>

    <div class="quantity-summary">
        <strong>Total Jumlah Barang:</strong>
        {{ number_format($totalQuantity, 0, ',', '.') }}
    </div>

    <table class="filters">
        <tr>
            <td class="filter-label">Periode</td>

            <td>
                {{ $filters['date_from'] }}
                -
                {{ $filters['date_to'] }}
            </td>

            <td class="filter-label">Lokasi</td>

            <td>
                {{ $filters['location'] }}
            </td>
        </tr>

        <tr>
            <td class="filter-label">Pencarian</td>

            <td colspan="3">
                {{ $filters['search'] }}
            </td>
        </tr>
    </table>

    <table class="report">
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="10%">Kode</th>
                <th width="12%">Nama</th>
                <th width="6%">Jumlah</th>
                <th width="8%">Kategori</th>
                <th width="9%">Brand / Model</th>
                <th width="10%">Serial Number</th>
                <th width="11%">Lokasi</th>
                <th width="9%">Divisi</th>
                <th width="7%">Kondisi</th>
                <th width="7%">Status</th>
                <th width="8%">Pembelian</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($items as $item)
                <tr>
                    <td class="center">
                        {{ $loop->iteration }}
                    </td>

                    <td>
                        {{ $item->inventory_code }}
                    </td>

                    <td>
                        {{ $item->name }}
                    </td>

                    <td class="right">
                        {{ number_format($item->quantity, 0, ',', '.') }}
                    </td>

                    <td>
                        {{ $item->category?->name ?? '-' }}
                    </td>

                    <td>
                        {{ trim(($item->brand ?? '') . ' ' . ($item->model ?? '')) ?: '-' }}
                    </td>

                    <td>
                        {{ $item->serial_number ?: '-' }}
                    </td>

                    <td>
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

                    <td>
                        {{ $item->department?->name ?? '-' }}
                    </td>

                    <td class="center">
                        {{ $conditionLabels[$item->condition_status] ?? ($item->condition_status ?? '-') }}
                    </td>

                    <td class="center">
                        {{ $statusLabels[$item->status] ?? ($item->status ?? '-') }}
                    </td>

                    <td class="center">
                        {{ $item->purchase_date?->format('d/m/Y') ?? '-' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="12" class="center">
                        Tidak ada data inventaris berdasarkan filter.
                    </td>
                </tr>
            @endforelse

            <tr class="total-row">
                <td colspan="3">
                    Total Jumlah Barang
                </td>

                <td class="right">
                    {{ number_format($totalQuantity, 0, ',', '.') }}
                </td>

                <td colspan="8"></td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        Dicetak: {{ now()->format('d/m/Y H:i') }}
    </div>
</body>

</html>
