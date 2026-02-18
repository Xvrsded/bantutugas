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

    public function getTechnologiesAttribute($value)
    {
        if (is_array($value)) {
            if (count($value) === 1 && is_string($value[0])) {
                $maybeJson = json_decode($value[0], true);
                if (is_array($maybeJson)) {
                    return $this->normalizeTechnologies($maybeJson);
                }
            }

            return $this->normalizeTechnologies($value);
        }

        if ($value === null) {
            return [];
        }

        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (is_array($decoded)) {
                return $this->normalizeTechnologies($decoded);
            }

            return $this->normalizeTechnologies(
                array_values(array_filter(array_map('trim', explode(',', $value))))
            );
        }

        return [];
    }

    private function normalizeTechnologies(array $items)
    {
        return array_values(array_filter(array_map(function ($item) {
            if (!is_string($item)) {
                return null;
            }

            $clean = trim($item);
            $clean = trim($clean, "\"'");
            $clean = str_replace('\\', '', $clean);
            return $clean !== '' ? $clean : null;
        }, $items)));
    }
}
