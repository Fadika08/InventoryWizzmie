<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Department;
use App\Models\InventoryItem;
use App\Models\Outlet;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        $query = InventoryItem::query()
            ->accessibleBy($user);

        $totalInventory = (clone $query)->count();

        $totalGood = (clone $query)
            ->where('condition_status', 'good')
            ->count();

        $totalMaintenance = (clone $query)
            ->where('status', 'maintenance')
            ->count();

        $totalLost = (clone $query)
            ->where('status', 'lost')
            ->count();

        $totalBorrowed = (clone $query)
            ->where('status', 'borrowed')
            ->count();

        $totalDisposed = (clone $query)
            ->where('status', 'disposed')
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Inventory by Category
        |--------------------------------------------------------------------------
        */

        $inventoryByCategory = (clone $query)
            ->selectRaw('category_id, COUNT(*) as total')
            ->with('category:id,name')
            ->groupBy('category_id')
            ->orderByDesc('total')
            ->limit(8)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Recent Activity
        |--------------------------------------------------------------------------
        */

        $recentActivities = ActivityLog::query()
            ->with('user:id,name')
            ->latest('created_at')
            ->limit(8)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Master Data Count
        |--------------------------------------------------------------------------
        */

        $totalDepartments = Department::where(
            'is_active',
            true
        )->count();

        $totalOutlets = Outlet::where(
            'is_active',
            true
        )->count();

        return view('dashboard', compact(
            'totalInventory',
            'totalGood',
            'totalMaintenance',
            'totalLost',
            'totalBorrowed',
            'totalDisposed',
            'inventoryByCategory',
            'recentActivities',
            'totalDepartments',
            'totalOutlets',
        ));
    }
}
