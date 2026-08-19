<!DOCTYPE html>
<html>

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
            margin-bottom: 15px;
        }

        .summary td {
            width: 20%;
            border: 1px solid #e2e8f0;
            padding: 7px;
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

        .filters {
            width: 100%;
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
            border-collapse: collapse;
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
        }

        table.report tr:nth-child(even) td {
            background: #f8fafc;
        }

        .center {
            text-align: center;
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

        <td>

            <div class="summary-title">
                TOTAL
            </div>

            <div class="summary-value">
                {{ number_format($statistics['total']) }}
            </div>

        </td>


        <td>

            <div class="summary-title">
                HEAD OFFICE
            </div>

            <div class="summary-value">
                {{ number_format($statistics['head_office']) }}
            </div>

        </td>


        <td>

            <div class="summary-title">
                OUTLET
            </div>

            <div class="summary-value">
                {{ number_format($statistics['outlet']) }}
            </div>

        </td>


        <td>

            <div class="summary-title">
                KONDISI BAIK
            </div>

            <div class="summary-value">
                {{ number_format($statistics['baik']) }}
            </div>

        </td>


        <td>

            <div class="summary-title">
                KONDISI RUSAK
            </div>

            <div class="summary-value">
                {{ number_format($statistics['rusak']) }}
            </div>

        </td>

    </tr>

</table>


<table class="filters">

    <tr>

        <td class="filter-label">
            Periode
        </td>

        <td>
            {{ $filters['date_from'] }}
            -
            {{ $filters['date_to'] }}
        </td>

        <td class="filter-label">
            Lokasi
        </td>

        <td>
            {{ $filters['location'] }}
        </td>

    </tr>


    <tr>

        <td class="filter-label">
            Pencarian
        </td>

        <td colspan="3">
            {{ $filters['search'] }}
        </td>

    </tr>

</table>


<table class="report">

    <thead>

        <tr>

            <th width="4%">
                No
            </th>

            <th width="10%">
                Kode
            </th>

            <th width="14%">
                Nama
            </th>

            <th width="9%">
                Kategori
            </th>

            <th width="10%">
                Brand / Model
            </th>

            <th width="10%">
                Serial Number
            </th>

            <th width="12%">
                Lokasi
            </th>

            <th width="9%">
                Divisi
            </th>

            <th width="7%">
                Kondisi
            </th>

            <th width="7%">
                Status
            </th>

            <th width="8%">
                Pembelian
            </th>

        </tr>

    </thead>


    <tbody>

        @foreach($items as $index => $item)

            <tr>

                <td class="center">
                    {{ $index + 1 }}
                </td>

                <td>
                    {{ $item->inventory_code }}
                </td>

                <td>
                    {{ $item->name }}
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

                    @if($item->location_type === 'head_office')

                        Head Office

                        @if($item->room)
                            - {{ $item->room->name }}
                        @endif

                    @else

                        {{ $item->outlet?->name ?? 'Outlet' }}

                    @endif

                </td>

                <td>
                    {{ $item->department?->name ?? '-' }}
                </td>

                <td class="center">
                    {{ ucfirst($item->condition_status ?? '-') }}
                </td>

                <td class="center">
                    {{ ucfirst($item->status ?? '-') }}
                </td>

                <td class="center">
                    {{ $item->purchase_date?->format('d/m/Y') ?? '-' }}
                </td>

            </tr>

        @endforeach

    </tbody>

</table>


<div class="footer">

    Dicetak:
    {{ now()->format('d/m/Y H:i') }}

</div>


</body>

</html>
