<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class InventoryItem extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'inventory_code',
        'public_code',
        'barcode',
        'name',
        'category_id',
        'brand',
        'model',
        'serial_number',
        'specification',
        'location_type',
        'department_id',
        'room_id',
        'outlet_id',
        'condition_status',
        'status',
        'purchase_date',
        'purchase_price',
        'warranty_start',
        'warranty_end',
        'description',
        'primary_photo',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'public_code' => 'string',
        'purchase_date' => 'date',
        'warranty_start' => 'date',
        'warranty_end' => 'date',
        'purchase_price' => 'decimal:2',
    ];

    /**
     * Kategori.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Department.
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Room.
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Outlet.
     */
    public function outlet(): BelongsTo
    {
        return $this->belongsTo(Outlet::class);
    }

    /**
     * User yang membuat.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'created_by'
        );
    }

    /**
     * User yang terakhir mengubah.
     */
    public function updater(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'updated_by'
        );
    }

    /**
     * Foto inventaris.
     */
    public function photos(): HasMany
    {
        return $this->hasMany(InventoryPhoto::class);
    }

    /**
     * History inventaris.
     */
    public function histories(): HasMany
    {
        return $this->hasMany(InventoryHistory::class);
    }

    /**
     * Mutasi.
     */
    public function mutations(): HasMany
    {
        return $this->hasMany(InventoryMutation::class);
    }

    /**
     * Maintenance.
     */
    public function maintenances(): HasMany
    {
        return $this->hasMany(InventoryMaintenance::class);
    }

    /**
     * Peminjaman.
     */
    public function loans(): HasMany
    {
        return $this->hasMany(InventoryLoan::class);
    }
    public function scopeAccessibleBy(
    Builder $query,
    User $user
): Builder {
    if ($user->isSuperAdmin()) {
        return $query;
    }

    if ($user->isHoAdmin()) {
        return $query->where(
            'location_type',
            'head_office'
        );
    }

    if ($user->isOutletAdmin()) {
        return $query
            ->where('location_type', 'outlet')
            ->where(
                'outlet_id',
                $user->outlet_id
            );
    }

    return $query->whereRaw('1 = 0');
}
}