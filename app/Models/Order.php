<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'customer_id',
        'total',
        'status',
        'payment_method',
        'paid_at',
        'notes',
    ];

    protected $casts = [
        'total' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (!$order->order_number) {
                $order->order_number = 'INV-' . date('Ymd') . '-' . strtoupper(bin2hex(random_bytes(4)));
            }
        });
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function licenses(): HasMany
    {
        return $this->hasMany(License::class);
    }

    public function isPaid(): bool
    {
        return in_array($this->status, ['paid', 'completed']);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopePaid($query)
    {
        return $query->whereIn('status', ['paid', 'completed']);
    }
}
