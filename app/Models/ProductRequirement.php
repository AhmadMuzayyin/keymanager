<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductRequirement extends Model
{
    protected $fillable = [
        'product_id',
        'runtime_type',
        'min_version',
        'recommended_version',
        'additional_requirements',
    ];

    protected $casts = [
        'additional_requirements' => 'array',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getRuntimeLabelAttribute(): string
    {
        return match ($this->runtime_type) {
            'php' => 'PHP',
            'nodejs' => 'Node.js',
            'java' => 'Java',
            'kotlin' => 'Kotlin',
            'python' => 'Python',
            'flutter' => 'Flutter',
            'electron' => 'Electron',
            'dotnet' => '.NET',
            default => $this->runtime_type,
        };
    }
}
