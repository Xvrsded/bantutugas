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

    public function getImageListAttribute(): array
    {
        $value = $this->attributes['image'] ?? null;

        if ($value === null || trim((string) $value) === '') {
            return [];
        }

        $images = [];

        if (is_string($value)) {
            $decoded = json_decode($value, true);

            if (is_array($decoded)) {
                $images = $decoded;
            } elseif (str_contains($value, '|')) {
                $images = explode('|', $value);
            } elseif (str_contains($value, ',')) {
                $images = explode(',', $value);
            } else {
                $images = [$value];
            }
        }

        $cleaned = array_values(array_filter(array_map(function ($item) {
            if (!is_string($item)) {
                return null;
            }

            $path = trim($item);
            if ($path === '') {
                return null;
            }

            return ltrim($path, '/');
        }, $images)));

        $existing = array_values(array_filter($cleaned, function ($path) {
            if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
                return true;
            }

            return file_exists(public_path($path));
        }));

        if (count($existing) === 0) {
            return [];
        }

        if (count($existing) === 1 && !str_starts_with($existing[0], 'http')) {
            return $this->discoverSiblingImages($existing[0]);
        }

        return $existing;
    }

    private function discoverSiblingImages(string $path): array
    {
        $result = [$path];

        $fullPath = public_path($path);
        if (!file_exists($fullPath)) {
            return $result;
        }

        $directory = pathinfo($path, PATHINFO_DIRNAME);
        $directory = $directory === '.' ? '' : $directory;
        $filename = pathinfo($path, PATHINFO_FILENAME);
        $extension = pathinfo($path, PATHINFO_EXTENSION);

        if (preg_match('/(.+?)([-_])1$/', $filename, $matches)) {
            $base = $matches[1];
            $separator = $matches[2];

            for ($index = 2; $index <= 10; $index++) {
                $candidateName = $base . $separator . $index . '.' . $extension;
                $candidatePath = $directory !== '' ? $directory . '/' . $candidateName : $candidateName;

                if (file_exists(public_path($candidatePath))) {
                    $result[] = $candidatePath;
                    continue;
                }

                break;
            }
        }

        return array_values(array_unique($result));
    }
}
