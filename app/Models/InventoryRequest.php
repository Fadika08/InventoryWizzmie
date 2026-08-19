<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InventoryRequest extends Model
{
    protected $fillable = [
        'request_number',
        'requester_id',
        'department_id',
        'outlet_id',
        'request_type',
        'status',
        'reason',
        'notes',
        'approved_by',
        'approved_at',
        'rejected_reason',
        'completed_at',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function requester(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'requester_id'
        );
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function outlet(): BelongsTo
    {
        return $this->belongsTo(Outlet::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'approved_by'
        );
    }

    public function items(): HasMany
    {
        return $this->hasMany(
            InventoryRequestItem::class,
            'request_id'
        );
    }
}