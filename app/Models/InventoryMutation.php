<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryMutation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'inventory_id',

        'from_department_id',
        'from_room_id',
        'from_outlet_id',

        'to_department_id',
        'to_room_id',
        'to_outlet_id',

        'reason',
        'status',

        'requested_by',
        'approved_by',

        'requested_at',
        'approved_at',
        'completed_at',

        'notes',
    ];

    protected $casts = [
        'requested_at' => 'datetime',
        'approved_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function inventory(): BelongsTo
    {
        return $this->belongsTo(InventoryItem::class);
    }

    public function fromDepartment(): BelongsTo
    {
        return $this->belongsTo(
            Department::class,
            'from_department_id'
        );
    }

    public function fromRoom(): BelongsTo
    {
        return $this->belongsTo(
            Room::class,
            'from_room_id'
        );
    }

    public function fromOutlet(): BelongsTo
    {
        return $this->belongsTo(
            Outlet::class,
            'from_outlet_id'
        );
    }

    public function toDepartment(): BelongsTo
    {
        return $this->belongsTo(
            Department::class,
            'to_department_id'
        );
    }

    public function toRoom(): BelongsTo
    {
        return $this->belongsTo(
            Room::class,
            'to_room_id'
        );
    }

    public function toOutlet(): BelongsTo
    {
        return $this->belongsTo(
            Outlet::class,
            'to_outlet_id'
        );
    }

    public function requester(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'requested_by'
        );
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'approved_by'
        );
    }
}