<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Outlet extends Model
{
    protected $fillable = [
        'code',
        'name',
        'address',
        'city',
        'area',
        'phone',
        'manager_name',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * User yang berada di outlet.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Inventaris outlet.
     */
    public function inventoryItems(): HasMany
    {
        return $this->hasMany(InventoryItem::class);
    }

    /**
     * Pengajuan outlet.
     */
    public function inventoryRequests(): HasMany
    {
        return $this->hasMany(InventoryRequest::class);
    }
}