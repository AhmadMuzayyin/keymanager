<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomOrderMilestone extends Model
{
    protected $fillable = [
        'custom_order_id',
        'title',
        'description',
        'percentage',
        'status',
        'due_date',
        'completed_at',
        'sort_order',
    ];

    protected $casts = [
        'due_date' => 'date',
        'completed_at' => 'datetime',
    ];

    public function customOrder(): BelongsTo
    {
        return $this->belongsTo(CustomOrder::class);
    }

    public function markAsCompleted(): void
    {
        $this->update([
            'status' => 'completed',
            'percentage' => 100,
            'completed_at' => now(),
        ]);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Belum Dimulai',
            'in_progress' => 'Dalam Proses',
            'completed' => 'Selesai',
            default => $this->status,
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'gray',
            'in_progress' => 'blue',
            'completed' => 'green',
            default => 'gray',
        };
    }

    public function isOverdue(): bool
    {
        return $this->due_date && $this->due_date->isPast() && $this->status !== 'completed';
    }
}
