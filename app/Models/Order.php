<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_name',
        'client_email',
        'client_phone',
        'service_id',
        'package_id',
        'project_title',
        'description',
        'deadline',
        'budget',
        'quantity',
        'unit_quantity',
        'payment_method',
        'attachment',
        'status',
        'notes',
        'is_notified',
        // Package-based pricing
        'package_price',
        'addons_total',
        'subtotal',
        'admin_adjusted_price',
        'price_adjustment_notes',
        // Parameter Kalkulasi (legacy, optional)
        'question_type',
        'subject',
        'question_count',
        'needs_explanation',
        'deadline_hours',
        // Hasil Kalkulasi (legacy, optional)
        'difficulty_score',
        'difficulty_level',
        'base_price',
        'multiplier',
        'calculated_price',
        'final_price',
        'price_overridden',
        'price_adjustment_reason'
    ];

    protected $casts = [
        'deadline' => 'datetime',
        'is_notified' => 'boolean',
        'needs_explanation' => 'boolean',
        'price_overridden' => 'boolean',
        'base_price' => 'decimal:2',
        'multiplier' => 'decimal:2',
        'calculated_price' => 'decimal:2',
        'final_price' => 'decimal:2',
        'package_price' => 'decimal:2',
        'addons_total' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'admin_adjusted_price' => 'decimal:2'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function addons()
    {
        return $this->belongsToMany(Addon::class, 'order_addons')
            ->withPivot('addon_price')
            ->withTimestamps();
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'warning',
            'accepted' => 'info',
            'in_progress' => 'primary',
            'completed' => 'success',
            'rejected' => 'danger'
        ];
        return $badges[$this->status] ?? 'secondary';
    }
}
