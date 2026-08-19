<?php

namespace App\Http\Controllers;

use App\Exports\InventoryReportExport;
use App\Models\Category;
use App\Models\Department;
use App\Models\InventoryItem;
use App\Models\Outlet;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class InventoryReportController extends Controller
{
    /**
     * Halaman utama report inventaris.
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        $query = $this->buildQuery($request, $user);

        $items = $query
            ->orderByDesc('inventory_items.id')
            ->paginate(25)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | Data filter
        |--------------------------------------------------------------------------
        */

        $departments = Department::query()
            ->orderBy('name')
            ->get();

        $outletsQuery = Outlet::query()
            ->where('is_active', true)
            ->orderBy('name');

        /*
        |--------------------------------------------------------------------------
        | Outlet Admin hanya melihat outlet sendiri
        |--------------------------------------------------------------------------
        */

        if ($user->isOutletAdmin()) {
            $outletsQuery->where(
                'id',
                $user->outlet_id
            );
        }

        $outlets = $outletsQuery->get();

        $categories = Category::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Statistik report
        |--------------------------------------------------------------------------
        */

        $statisticsQuery = $this->buildQuery(
            $request,
            $user
        );

        $statistics = [
            'total' => (clone $statisticsQuery)->count(),

            'head_office' => (clone $statisticsQuery)
                ->where(
                    'inventory_items.location_type',
                    'head_office'
                )
                ->count(),

            'outlet' => (clone $statisticsQuery)
                ->where(
                    'inventory_items.location_type',
                    'outlet'
                )
                ->count(),

            'baik' => (clone $statisticsQuery)
                ->where(
                    'inventory_items.condition_status',
                    'good'
                )
                ->count(),

            'rusak' => (clone $statisticsQuery)
                ->whereIn(
                    'inventory_items.condition_status',
                    [
                        'damaged',
                        'broken',
                    ]
                )
                ->count(),
        ];

        return view(
            'reports.inventory.index',
            compact(
                'items',
                'departments',
                'outlets',
                'categories',
                'statistics'
            )
        );
    }

    /**
     * Export Excel.
     */
    public function exportExcel(Request $request)
    {
        $user = $request->user();

        $query = $this->buildQuery(
            $request,
            $user
        );

        $items = $query
            ->orderByDesc('inventory_items.id')
            ->get();

        return Excel::download(
            new InventoryReportExport(
                $items,
                $this->filterInformation($request)
            ),
            'report-inventaris-' .
                now()->format('Y-m-d-His') .
                '.xlsx'
        );
    }

    /**
     * Export PDF.
     */
    public function exportPdf(Request $request)
    {
        $user = $request->user();

        $query = $this->buildQuery(
            $request,
            $user
        );

        $items = $query
            ->orderByDesc('inventory_items.id')
            ->get();

        $statisticsQuery = $this->buildQuery(
            $request,
            $user
        );

        $statistics = [
            'total' => (clone $statisticsQuery)->count(),

            'head_office' => (clone $statisticsQuery)
                ->where(
                    'inventory_items.location_type',
                    'head_office'
                )
                ->count(),

            'outlet' => (clone $statisticsQuery)
                ->where(
                    'inventory_items.location_type',
                    'outlet'
                )
                ->count(),

            'baik' => (clone $statisticsQuery)
                ->where(
                    'inventory_items.condition_status',
                    'good'
                )
                ->count(),

            'rusak' => (clone $statisticsQuery)
                ->whereIn(
                    'inventory_items.condition_status',
                    [
                        'damaged',
                        'broken',
                    ]
                )
                ->count(),
        ];

        $pdf = Pdf::loadView(
            'reports.inventory.pdf',
            [
                'items' => $items,
                'statistics' => $statistics,
                'filters' => $this->filterInformation(
                    $request
                ),
            ]
        );

        return $pdf
            ->setPaper('a4', 'landscape')
            ->download(
                'report-inventaris-' .
                now()->format('Y-m-d-His') .
                '.pdf'
            );
    }

    /**
     * Query utama report.
     */
    private function buildQuery(
        Request $request,
        $user
    ): Builder {

        $query = InventoryItem::query()
            ->select([
                'inventory_items.*',
            ])
            ->with([
                'category',
                'department',
                'room',
                'outlet',
            ]);

        /*
        |--------------------------------------------------------------------------
        | Hak akses user
        |--------------------------------------------------------------------------
        */

        $query->accessibleBy($user);

        /*
        |--------------------------------------------------------------------------
        | Tanggal pembelian
        |--------------------------------------------------------------------------
        */

        if ($request->filled('date_from')) {

            $query->whereDate(
                'inventory_items.purchase_date',
                '>=',
                $request->date_from
            );
        }

        if ($request->filled('date_to')) {

            $query->whereDate(
                'inventory_items.purchase_date',
                '<=',
                $request->date_to
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Lokasi
        |--------------------------------------------------------------------------
        */

        if ($request->filled('location_type')) {

            if (
                in_array(
                    $request->location_type,
                    [
                        'head_office',
                        'outlet',
                    ],
                    true
                )
            ) {
                $query->where(
                    'inventory_items.location_type',
                    $request->location_type
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Outlet
        |--------------------------------------------------------------------------
        */

        if ($request->filled('outlet_id')) {

            if ($request->outlet_id !== 'all') {

                $query->where(
                    'inventory_items.outlet_id',
                    $request->outlet_id
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Department / Divisi
        |--------------------------------------------------------------------------
        */

        if ($request->filled('department_id')) {

            if ($request->department_id !== 'all') {

                $query->where(
                    'inventory_items.department_id',
                    $request->department_id
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Kategori
        |--------------------------------------------------------------------------
        */

        if ($request->filled('category_id')) {

            if ($request->category_id !== 'all') {

                $query->where(
                    'inventory_items.category_id',
                    $request->category_id
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Status
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {

            if ($request->status !== 'all') {

                $query->where(
                    'inventory_items.status',
                    $request->status
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Kondisi
        |--------------------------------------------------------------------------
        */

        if ($request->filled('condition_status')) {

            if (
                $request->condition_status !== 'all'
            ) {

                $query->where(
                    'inventory_items.condition_status',
                    $request->condition_status
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = trim(
                $request->search
            );

            $query->where(function ($q) use ($search) {

                $q->where(
                    'inventory_items.inventory_code',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'inventory_items.public_code',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'inventory_items.barcode',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'inventory_items.name',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'inventory_items.serial_number',
                    'like',
                    "%{$search}%"
                );
            });
        }

        return $query;
    }

    /**
     * Informasi filter untuk header export.
     */
    private function filterInformation(
        Request $request
    ): array {

        $location = match(
            $request->location_type
        ) {

            'head_office' =>
                'Semua Head Office',

            'outlet' =>
                'Semua Outlet',

            default =>
                'Semua Lokasi',
        };

        return [
            'date_from' =>
                $request->date_from
                    ?: 'Semua',

            'date_to' =>
                $request->date_to
                    ?: 'Semua',

            'location' =>
                $location,

            'outlet_id' =>
                $request->outlet_id
                    ?: 'all',

            'department_id' =>
                $request->department_id
                    ?: 'all',

            'category_id' =>
                $request->category_id
                    ?: 'all',

            'status' =>
                $request->status
                    ?: 'all',

            'condition_status' =>
                $request->condition_status
                    ?: 'all',

            'search' =>
                $request->search
                    ?: '-',
        ];
    }
}
