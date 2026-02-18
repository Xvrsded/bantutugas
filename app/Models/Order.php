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
        'project_title',
        'description',
        'deadline',
        'budget',
        'attachment',
        'status',
        'notes',
        'is_notified'
    ];

    protected $casts = [
        'deadline' => 'datetime',
        'is_notified' => 'boolean'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
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
