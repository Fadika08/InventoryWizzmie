<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithProperties;

class InventoryReportExport implements
    FromView,
    WithProperties
{
    protected Collection $items;

    protected array $filters;

    public function __construct(
        Collection $items,
        array $filters
    ) {
        $this->items = $items;
        $this->filters = $filters;
    }

    public function view(): View
    {
        return view(
            'reports.inventory.excel',
            [
                'items' => $this->items,
                'filters' => $this->filters,
            ]
        );
    }

    public function properties(): array
    {
        return [
            'creator' => 'Wizzmie Inventory System',

            'lastModifiedBy' =>
                'Wizzmie Inventory System',

            'title' =>
                'Report Inventaris',

            'description' =>
                'Laporan inventaris Wizzmie',

            'subject' =>
                'Inventory Report',

            'company' =>
                'Wizzmie',
        ];
    }
}
