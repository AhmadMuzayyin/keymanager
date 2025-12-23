<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LicenseLog extends Model
{
    protected $fillable = [
        'license_key',
        'license_product_name',
        'license_status',
        'license_domain',
        'license_expires_at',
        'request_domain',
        'ip_address',
        'user_agent',
        'status',
        'invalid_reason',
        'checked_at',
    ];

    protected $casts = [
        'license_expires_at' => 'datetime',
        'checked_at' => 'datetime',
    ];
}
