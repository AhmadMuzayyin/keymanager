<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DownloadLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'customer_download_id',
        'product_version_id',
        'ip_address',
        'user_agent',
        'downloaded_at',
    ];

    protected $casts = [
        'downloaded_at' => 'datetime',
    ];

    public function customerDownload(): BelongsTo
    {
        return $this->belongsTo(CustomerDownload::class);
    }

    public function productVersion(): BelongsTo
    {
        return $this->belongsTo(ProductVersion::class);
    }
}
