<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CustomerDownload extends Model
{
    protected $fillable = [
        'customer_id',
        'product_id',
        'order_item_id',
        'download_count',
        'last_downloaded_at',
    ];

    protected $casts = [
        'last_downloaded_at' => 'datetime',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function logs(): HasMany
    {
        return $this->hasMany(DownloadLog::class);
    }

    public function incrementDownload(): void
    {
        $this->increment('download_count');
        $this->update(['last_downloaded_at' => now()]);
    }
}
