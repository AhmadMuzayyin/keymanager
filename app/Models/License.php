<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class License extends Model
{
    protected $fillable = [
        'customer_id',
        'order_id',
        'key',
        'purchase_code',
        'product_name',
        'domain',
        'expires_at',
        'max_activations',
        'status',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($license) {
            if (empty($license->purchase_code)) {
                $license->purchase_code = self::generatePurchaseCode();
            }
        });
    }

    public static function generatePurchaseCode(): string
    {
        do {
            $code = 'PUR-' . strtoupper(Str::random(8));
        } while (self::where('purchase_code', $code)->exists());

        return $code;
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function logs()
    {
        return $this->hasMany(LicenseLog::class);
    }
}
