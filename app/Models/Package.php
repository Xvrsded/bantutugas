<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'name',
        'slug',
        'price_per_unit',
        'unit_label',
        'description',
        'features',
        'min_quantity',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'price_per_unit' => 'decimal:2',
        'features' => 'array',
        'is_active' => 'boolean',
        'min_quantity' => 'integer'
    ];

    // Relationships
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForService($query, $serviceId)
    {
        return $query->where('service_id', $serviceId);
    }

    // Helpers
    public function calculatePrice($quantity)
    {
        return $this->price_per_unit * max($quantity, $this->min_quantity);
    }

    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price_per_unit, 0, ',', '.');
    }
}
