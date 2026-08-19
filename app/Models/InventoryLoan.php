<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryLoan extends Model
{
    protected $fillable = [
        'inventory_id',
        'borrower_id',
        'purpose',
        'borrowed_at',
        'expected_return_at',
        'returned_at',
        'status',
        'notes',
        'approved_by',
    ];

    protected $casts = [
        'borrowed_at' => 'datetime',
        'expected_return_at' => 'datetime',
        'returned_at' => 'datetime',
    ];

    public function inventory(): BelongsTo
    {
        return $this->belongsTo(InventoryItem::class);
    }

    public function borrower(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'borrower_id'
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