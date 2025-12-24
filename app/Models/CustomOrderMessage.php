<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomOrderMessage extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'custom_order_id',
        'sender_type',
        'message',
        'attachments',
        'is_read',
        'created_at',
    ];

    protected $casts = [
        'attachments' => 'array',
        'is_read' => 'boolean',
        'created_at' => 'datetime',
    ];

    public function customOrder(): BelongsTo
    {
        return $this->belongsTo(CustomOrder::class);
    }

    public function isFromAdmin(): bool
    {
        return $this->sender_type === 'admin';
    }

    public function isFromCustomer(): bool
    {
        return $this->sender_type === 'customer';
    }

    public function markAsRead(): void
    {
        $this->update(['is_read' => true]);
    }
}
