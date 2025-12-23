<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    protected $fillable = [
        'key',
        'product_name',
        'domain',
        'expires_at',
        'max_activations',
        'status',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function logs()
    {
        return $this->hasMany(LicenseLog::class);
    }
}
