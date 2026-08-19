<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryHistory extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'inventory_id',
        'user_id',
        'action',
        'old_data',
        'new_data',
        'description',
        'created_at',
    ];

    protected $casts = [
        'old_data' => 'array',
        'new_data' => 'array',
        'created_at' => 'datetime',
    ];

    public function inventory(): BelongsTo
    {
        return $this->belongsTo(
            InventoryItem::class,
            'inventory_id'
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}