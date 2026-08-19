<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryRequestItem extends Model
{
    protected $fillable = [
        'request_id',
        'category_id',
        'item_name',
        'specification',
        'quantity',
        'notes',
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    public function request(): BelongsTo
    {
        return $this->belongsTo(
            InventoryRequest::class,
            'request_id'
        );
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}