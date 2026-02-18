<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Portfolio extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'description',
        'image',
        'client_name',
        'project_url',
        'technologies',
        'is_featured'
    ];

    protected $casts = [
        'technologies' => 'array',
        'is_featured' => 'boolean'
    ];
}
