<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'description',
        'icon',
        'image',
        'price_start',
        'price_end',
        'features',
        'is_active'
    ];

    protected $casts = [
        'features' => 'array',
        'is_active' => 'boolean'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function packages()
    {
        return $this->hasMany(Package::class)->orderBy('sort_order');
    }

    public function activePackages()
    {
        return $this->hasMany(Package::class)->where('is_active', true)->orderBy('sort_order');
    }

    // Get price range from packages
    public function getPriceRangeAttribute()
    {
        $packages = $this->packages()->active()->get();
        if ($packages->isEmpty()) {
            return [
                'min' => $this->price_start ?? 0,
                'max' => $this->price_end ?? 0
            ];
        }

        return [
            'min' => $packages->min('price_per_unit'),
            'max' => $packages->max('price_per_unit')
        ];
    }
}
