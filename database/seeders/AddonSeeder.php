<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Addon;

class AddonSeeder extends Seeder
{
    public function run(): void
    {
        $addons = [
            [
                'name' => 'Express (24 Jam)',
                'slug' => 'express',
                'type' => 'percentage',
                'price' => 50, // 50% extra
                'description' => 'Pengerjaan diprioritaskan dan selesai dalam 24 jam',
                'icon' => 'bi-lightning-charge-fill',
                'sort_order' => 1
            ],
            [
                'name' => 'Turnitin Check',
                'slug' => 'turnitin',
                'type' => 'fixed',
                'price' => 50000,
                'description' => 'Cek plagiarisme dengan Turnitin + laporan similarity',
                'icon' => 'bi-shield-check',
                'sort_order' => 2
            ],
            [
                'name' => 'English Version',
                'slug' => 'english',
                'type' => 'percentage',
                'price' => 30, // 30% extra
                'description' => 'Tugas dikerjakan dalam bahasa Inggris',
                'icon' => 'bi-globe',
                'sort_order' => 3
            ],
            [
                'name' => 'Penjelasan Detail',
                'slug' => 'explanation',
                'type' => 'per_unit',
                'price' => 5000, // Per halaman/soal
                'description' => 'Disertai langkah-langkah penyelesaian lengkap',
                'icon' => 'bi-file-text',
                'sort_order' => 4
            ],
            [
                'name' => 'Konsultasi Bimbingan',
                'slug' => 'consultation',
                'type' => 'fixed',
                'price' => 100000,
                'description' => 'Sesi konsultasi 1 jam via video call',
                'icon' => 'bi-camera-video',
                'sort_order' => 5
            ],
            [
                'name' => 'Revisi Unlimited',
                'slug' => 'unlimited_revision',
                'type' => 'percentage',
                'price' => 20, // 20% extra
                'description' => 'Revisi tanpa batas hingga Anda puas',
                'icon' => 'bi-arrow-repeat',
                'sort_order' => 6
            ],
            [
                'name' => 'Presentasi PPT',
                'slug' => 'presentation',
                'type' => 'fixed',
                'price' => 75000,
                'description' => 'Dibuatkan slide presentasi PowerPoint',
                'icon' => 'bi-file-earmark-slides',
                'sort_order' => 7
            ]
        ];

        foreach ($addons as $addon) {
            Addon::create($addon);
        }
    }
}
