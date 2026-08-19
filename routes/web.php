<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InventoryItemController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InventoryRequestController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\InventoryReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [
        DashboardController::class,
        'index'
    ])->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Department
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:super_admin,ho_admin')
    ->group(function () {

        Route::get(
        '/activity-logs',
        [ActivityLogController::class, 'index']
    )->name('activity-logs.index');

        Route::resource(
            'departments',
            DepartmentController::class
        );

        Route::patch(
            '/departments/{department}/toggle-status',
            [DepartmentController::class, 'toggleStatus']
        )->name('departments.toggle-status');
        Route::resource(
            'categories',
            CategoryController::class
        )->parameters([
            'categories' => 'category',
        ]);

        Route::patch(
            '/categories/{category}/toggle-status',
            [
                CategoryController::class,
                'toggleStatus'
            ]
        )->name(
            'categories.toggle-status'
        );
    });

    Route::get(
        '/users',
        [UserController::class, 'index']
    )->name('users.index');

    Route::get(
    '/users/create',
    [UserController::class, 'create']
    )->name('users.create');

    Route::post(
    '/users',
    [UserController::class, 'store']
    )->name('users.store');

    Route::get(
        '/users/{user}',
        [UserController::class, 'show']
    )->name('users.show');

    Route::get(
        '/users/{user}/edit',
        [UserController::class, 'edit']
    )->name('users.edit');

    Route::put(
        '/users/{user}',
        [UserController::class, 'update']
    )->name('users.update');

    Route::patch(
    '/users/{user}/toggle-status',
    [UserController::class, 'toggleStatus']
)->name('users.toggle-status');

    /*
    |--------------------------------------------------------------------------
    | Inventory Items
    |--------------------------------------------------------------------------
    */
    Route::get(
    '/inventory/search-barcode',
    [InventoryItemController::class, 'searchBarcode']
    )->name('inventory.search-barcode');

    Route::get(
    '/inventory/scanner',
    [InventoryItemController::class, 'scanner']
    )->name('inventory.scanner');

    Route::get(
        '/inventory',
        [InventoryItemController::class, 'index']
    )->name('inventory.index');

    Route::get(
        '/inventory/create',
        [InventoryItemController::class, 'create']
    )->name('inventory.create');

    Route::post(
        '/inventory',
        [InventoryItemController::class, 'store']
    )->name('inventory.store');

    Route::get(
        '/inventory/{inventory}',
        [InventoryItemController::class, 'show']
    )->name('inventory.show');

    Route::get(
        '/inventory/{inventory}/edit',
        [InventoryItemController::class, 'edit']
    )->name('inventory.edit');

    Route::put(
        '/inventory/{inventory}',
        [InventoryItemController::class, 'update']
    )->name('inventory.update');

    Route::delete(
        '/inventory/{inventory}',
        [InventoryItemController::class, 'destroy']
    )->name('inventory.destroy');

    Route::get(
        '/inventory-rooms',
        [InventoryItemController::class, 'rooms']
    )->name('inventory.rooms');

        /*
        |--------------------------------------------------------------------------
        | Rooms
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'rooms',
            RoomController::class
        );

        Route::patch(
            '/rooms/{room}/toggle-status',
            [RoomController::class, 'toggleStatus']
        )->name(
            'rooms.toggle-status'
        );
    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/profile',
        [ProfileController::class, 'edit']
    )->name('profile.edit');

    Route::patch(
        '/profile',
        [ProfileController::class, 'update']
    )->name('profile.update');

    Route::put(
        '/profile/password',
        [ProfileController::class, 'password']
    )->name('profile.password');

    Route::resource(
        'outlets',
        OutletController::class
    );

    Route::patch(
        '/outlets/{outlet}/toggle-status',
        [OutletController::class, 'toggleStatus']
    )->name('outlets.toggle-status');

     Route::get(
        '/inventory-requests',
        [InventoryRequestController::class, 'index']
    )->name('inventory-requests.index');

    Route::get(
        '/inventory-requests/create',
        [InventoryRequestController::class, 'create']
    )->name('inventory-requests.create');

    Route::post(
        '/inventory-requests',
        [InventoryRequestController::class, 'store']
    )->name('inventory-requests.store');

    Route::get(
        '/inventory-requests/{inventoryRequest}',
        [InventoryRequestController::class, 'show']
    )->name('inventory-requests.show');

    Route::patch(
        '/inventory-requests/{inventoryRequest}/cancel',
        [InventoryRequestController::class, 'cancel']
    )->name('inventory-requests.cancel');
    Route::post(
    '/inventory-requests/{inventoryRequest}/approve',
    [InventoryRequestController::class, 'approve']
    )->name('inventory-requests.approve');

    Route::post(
        '/inventory-requests/{inventoryRequest}/reject',
        [InventoryRequestController::class, 'reject']
    )->name('inventory-requests.reject');

    Route::get(
    '/inventory-requests/{inventoryRequest}/edit',
    [InventoryRequestController::class, 'edit']
)->name('inventory-requests.edit');

Route::put(
    '/inventory-requests/{inventoryRequest}',
    [InventoryRequestController::class, 'update']
)->name('inventory-requests.update');
 Route::get(
        '/reports/inventory',
        [InventoryReportController::class, 'index']
    )->name('reports.inventory.index');

    Route::get(
        '/reports/inventory/excel',
        [InventoryReportController::class, 'exportExcel']
    )->name('reports.inventory.excel');

    Route::get(
        '/reports/inventory/pdf',
        [InventoryReportController::class, 'exportPdf']
    )->name('reports.inventory.pdf');

});

Route::get(
    '/inventory/public/{public_code}',
    [InventoryItemController::class, 'publicShow']
)->name('inventory.public');

require __DIR__.'/auth.php';
