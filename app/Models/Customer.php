<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
    ];

    public function licenses(): HasMany
    {
        return $this->hasMany(License::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function downloads(): HasMany
    {
        return $this->hasMany(CustomerDownload::class);
    }

    public function customOrders(): HasMany
    {
        return $this->hasMany(CustomOrder::class);
    }

    public function hasPurchased(Product $product): bool
    {
        return $this->downloads()->where('product_id', $product->id)->exists();
    }
}
