<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryMaintenance extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'inventory_id',
        'reported_by',
        'technician_id',
        'problem',
        'action_taken',
        'status',
        'estimated_cost',
        'actual_cost',
        'reported_at',
        'started_at',
        'completed_at',
        'notes',
    ];

    protected $casts = [
        'estimated_cost' => 'decimal:2',
        'actual_cost' => 'decimal:2',
        'reported_at' => 'datetime',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function inventory(): BelongsTo
    {
        return $this->belongsTo(InventoryItem::class);
    }

    public function reporter(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'reported_by'
        );
    }

    public function technician(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'technician_id'
        );
    }
}