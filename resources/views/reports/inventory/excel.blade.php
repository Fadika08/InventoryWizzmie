<table>

    <tr>
        <td colspan="13"
            style="
                background-color:#8F348E;
                color:#FFFFFF;
                font-size:18px;
                font-weight:bold;
                text-align:center;
                height:30px;
            ">

            WIZZMiE - REPORT INVENTARIS

        </td>
    </tr>


    <tr>

        <td colspan="13"
            style="
                font-size:11px;
                font-weight:bold;
                text-align:center;
                height:22px;
            ">

            Laporan Inventaris

        </td>

    </tr>


    <tr>

        <td colspan="13"
            style="
                font-size:10px;
                text-align:center;
            ">

            Periode:
            {{ $filters['date_from'] }}
            -
            {{ $filters['date_to'] }}

        </td>

    </tr>


    <tr>
        <td colspan="13">&nbsp;</td>
    </tr>


    <tr>

        <td colspan="2"
            style="font-weight:bold;">
            Lokasi
        </td>

        <td colspan="3">
            {{ $filters['location'] }}
        </td>

        <td colspan="2"
            style="font-weight:bold;">
            Pencarian
        </td>

        <td colspan="6">
            {{ $filters['search'] }}
        </td>

    </tr>


    <tr>
        <td colspan="13">&nbsp;</td>
    </tr>


    <thead>

        <tr>

            <th
                style="
                    background-color:#8F348E;
                    color:#FFFFFF;
                    font-weight:bold;
                    text-align:center;
                    border:1px solid #D1D5DB;
                "
                width="7">

                No

            </th>


            <th
                style="
                    background-color:#8F348E;
                    color:#FFFFFF;
                    font-weight:bold;
                    border:1px solid #D1D5DB;
                "
                width="22">

                Kode Inventaris

            </th>


            <th
                style="
                    background-color:#8F348E;
                    color:#FFFFFF;
                    font-weight:bold;
                    border:1px solid #D1D5DB;
                "
                width="30">

                Nama Barang

            </th>


            <th
                style="
                    background-color:#8F348E;
                    color:#FFFFFF;
                    font-weight:bold;
                    border:1px solid #D1D5DB;
                "
                width="20">

                Kategori

            </th>


            <th
                style="
                    background-color:#8F348E;
                    color:#FFFFFF;
                    font-weight:bold;
                    border:1px solid #D1D5DB;
                "
                width="25">

                Brand / Model

            </th>


            <th
                style="
                    background-color:#8F348E;
                    color:#FFFFFF;
                    font-weight:bold;
                    border:1px solid #D1D5DB;
                "
                width="22">

                Serial Number

            </th>


            <th
                style="
                    background-color:#8F348E;
                    color:#FFFFFF;
                    font-weight:bold;
                    border:1px solid #D1D5DB;
                "
                width="18">

                Lokasi

            </th>


            <th
                style="
                    background-color:#8F348E;
                    color:#FFFFFF;
                    font-weight:bold;
                    border:1px solid #D1D5DB;
                "
                width="22">

                Divisi

            </th>


            <th
                style="
                    background-color:#8F348E;
                    color:#FFFFFF;
                    font-weight:bold;
                    border:1px solid #D1D5DB;
                "
                width="16">

                Kondisi

            </th>


            <th
                style="
                    background-color:#8F348E;
                    color:#FFFFFF;
                    font-weight:bold;
                    border:1px solid #D1D5DB;
                "
                width="16">

                Status

            </th>


            <th
                style="
                    background-color:#8F348E;
                    color:#FFFFFF;
                    font-weight:bold;
                    border:1px solid #D1D5DB;
                "
                width="16">

                Tanggal Pembelian

            </th>

        </tr>

    </thead>


    <tbody>

        @foreach($items as $index => $item)

            <tr>

                <td
                    style="
                        border:1px solid #E5E7EB;
                        text-align:center;
                    ">

                    {{ $index + 1 }}

                </td>


                <td
                    style="
                        border:1px solid #E5E7EB;
                    ">

                    {{ $item->inventory_code }}

                </td>


                <td
                    style="
                        border:1px solid #E5E7EB;
                    ">

                    {{ $item->name }}

                </td>


                <td
                    style="
                        border:1px solid #E5E7EB;
                    ">

                    {{ $item->category?->name ?? '-' }}

                </td>


                <td
                    style="
                        border:1px solid #E5E7EB;
                    ">

                    {{ trim(($item->brand ?? '') . ' ' . ($item->model ?? '')) ?: '-' }}

                </td>


                <td
                    style="
                        border:1px solid #E5E7EB;
                        data-type:string;
                    ">

                    {{ $item->serial_number ?: '-' }}

                </td>


                <td
                    style="
                        border:1px solid #E5E7EB;
                    ">

                    @if($item->location_type === 'head_office')

                        Head Office

                        @if($item->room)
                            - {{ $item->room->name }}
                        @endif

                    @else

                        {{ $item->outlet?->name ?? 'Outlet' }}

                    @endif

                </td>


                <td
                    style="
                        border:1px solid #E5E7EB;
                    ">

                    {{ $item->department?->name ?? '-' }}

                </td>


                <td
                    style="
                        border:1px solid #E5E7EB;
                    ">

                    {{ ucfirst($item->condition_status ?? '-') }}

                </td>


                <td
                    style="
                        border:1px solid #E5E7EB;
                    ">

                    {{ ucfirst($item->status ?? '-') }}

                </td>


                <td
                    style="
                        border:1px solid #E5E7EB;
                    ">

                    {{ $item->purchase_date?->format('d/m/Y') ?? '-' }}

                </td>

            </tr>

        @endforeach

    </tbody>

</table>
