<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Addon extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'type', // percentage, fixed, per_unit
        'price',
        'description',
        'icon',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean'
    ];

    // Relationships
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_addons')
            ->withPivot('addon_price')
            ->withTimestamps();
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    // Helpers
    public function calculatePrice($basePrice, $quantity = 1)
    {
        switch ($this->type) {
            case 'percentage':
                return ($basePrice * $this->price) / 100;
            case 'fixed':
                return $this->price;
            case 'per_unit':
                return $this->price * $quantity;
            default:
                return 0;
        }
    }

    public function getFormattedPriceAttribute()
    {
        if ($this->type === 'percentage') {
            return $this->price . '%';
        }
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getIconClassAttribute()
    {
        return $this->icon ?? 'bi-plus-circle';
    }
}
