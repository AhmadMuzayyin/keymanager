<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CustomOrder extends Model
{
    protected $fillable = [
        'order_number',
        'customer_id',
        'name',
        'email',
        'phone',
        'project_type',
        'title',
        'description',
        'budget_range',
        'deadline',
        'attachments',
        'status',
        'admin_notes',
        'quoted_price',
        'quoted_at',
        'accepted_at',
        'completed_at',
    ];

    protected $casts = [
        'attachments' => 'array',
        'quoted_price' => 'decimal:2',
        'deadline' => 'date',
        'quoted_at' => 'datetime',
        'accepted_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (!$order->order_number) {
                $order->order_number = 'CUST-' . date('Ymd') . '-' . strtoupper(bin2hex(random_bytes(4)));
            }
        });
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(CustomOrderMessage::class)->orderBy('created_at');
    }

    public function milestones(): HasMany
    {
        return $this->hasMany(CustomOrderMilestone::class)->orderBy('sort_order');
    }

    public function getProgressAttribute(): int
    {
        $milestones = $this->milestones;

        if ($milestones->isEmpty()) {
            return 0;
        }

        return (int) round($milestones->avg('percentage'));
    }

    public function getProjectTypeLabelAttribute(): string
    {
        return match ($this->project_type) {
            'android' => 'Android',
            'desktop' => 'Desktop',
            'web' => 'Web',
            'other' => 'Lainnya',
            default => $this->project_type,
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Menunggu Review',
            'reviewed' => 'Sedang Direview',
            'quoted' => 'Penawaran Terkirim',
            'accepted' => 'Deal',
            'in_progress' => 'Dalam Pengerjaan',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default => $this->status,
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'yellow',
            'reviewed' => 'blue',
            'quoted' => 'purple',
            'accepted' => 'indigo',
            'in_progress' => 'cyan',
            'completed' => 'green',
            'cancelled' => 'red',
            default => 'gray',
        };
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    public function scopeActive($query)
    {
        return $query->whereNotIn('status', ['completed', 'cancelled']);
    }
}
