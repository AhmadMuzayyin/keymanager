<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'long_description',
        'type',
        'thumbnail',
        'demo_url',
        'is_active',
        'is_featured',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(ProductCategory::class, 'category_product', 'product_id', 'category_id');
    }

    public function prices(): HasMany
    {
        return $this->hasMany(ProductPrice::class)->orderBy('sort_order');
    }

    public function requirements(): HasMany
    {
        return $this->hasMany(ProductRequirement::class);
    }

    public function versions(): HasMany
    {
        return $this->hasMany(ProductVersion::class)->orderByDesc('released_at');
    }

    public function latestVersion()
    {
        return $this->hasOne(ProductVersion::class)->where('is_latest', true);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function lowestPrice()
    {
        return $this->prices()->where('is_active', true)->orderBy('price')->first();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }
}
