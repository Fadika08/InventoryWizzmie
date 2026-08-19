<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryPhoto extends Model
{
    protected $fillable = [
        'inventory_id',
        'file_path',
        'file_name',
        'is_primary',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    public function inventory(): BelongsTo
    {
        return $this->belongsTo(
            InventoryItem::class,
            'inventory_id'
        );
    }
}