<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Addon;

class AddonSeeder extends Seeder
{
    public function run(): void
    {
        // ADD-ONS REALISTIS SESUAI STANDAR PASAR INDONESIA 2026
        $addons = [
            [
                'name' => '⚡ Express 24 Jam',
                'slug' => 'express-24',
                'type' => 'percentage',
                'price' => 20, // +20% dari harga paket
                'description' => 'Pengerjaan dipercepat, selesai dalam 24 jam (tidak termasuk hari libur)',
                'icon' => 'bi-lightning-charge-fill',
                'sort_order' => 1
            ],
            [
                'name' => '🌍 Bahasa Inggris',
                'slug' => 'english-version',
                'type' => 'percentage',
                'price' => 30, // +30% dari harga paket
                'description' => 'Dikerjakan dalam bahasa Inggris yang baik dan profesional',
                'icon' => 'bi-globe',
                'sort_order' => 2
            ],
            [
                'name' => '📋 Turnitin Check',
                'slug' => 'turnitin-check',
                'type' => 'fixed',
                'price' => 25000, // Rp 25k fixed
                'description' => 'Cek plagiarisme lengkap dengan laporan similarity dari Turnitin',
                'icon' => 'bi-shield-check',
                'sort_order' => 3
            ],
            [
                'name' => '📊 Analisis Statistik',
                'slug' => 'statistics-analysis',
                'type' => 'fixed',
                'price' => 150000, // Rp 150k fixed (kompleks)
                'description' => 'Ditambahkan analisis data & grafik statistik berkualitas SPSS/Excel',
                'icon' => 'bi-bar-chart',
                'sort_order' => 4
            ],
            [
                'name' => '💻 Source Code & Demo',
                'slug' => 'source-code-demo',
                'type' => 'fixed',
                'price' => 200000, // Rp 200k fixed (kompleks)
                'description' => 'Source code lengkap + demo aplikasi + dokumentasi teknis',
                'icon' => 'bi-code-slash',
                'sort_order' => 5
            ],
            [
                'name' => '🔄 Revisi Unlimited',
                'slug' => 'unlimited-revisions',
                'type' => 'percentage',
                'price' => 15, // +15% dari harga paket
                'description' => 'Revisi tanpa batas hingga Anda benar-benar puas (upgrade dari paket)',
                'icon' => 'bi-arrow-repeat',
                'sort_order' => 6
            ],
            [
                'name' => '📑 Format & Finishing',
                'slug' => 'formatting-finishing',
                'type' => 'fixed',
                'price' => 50000, // Rp 50k fixed
                'description' => 'Formatting sempurna sesuai standar, daftar isi otomatis, margin presisi',
                'icon' => 'bi-file-earmark-richtext',
                'sort_order' => 7
            ],
            [
                'name' => '📹 Video Penjelasan',
                'slug' => 'video-explanation',
                'type' => 'fixed',
                'price' => 75000, // Rp 75k fixed
                'description' => 'Video penjelasan 10-15 menit cara penyelesaian & teori penting',
                'icon' => 'bi-play-circle',
                'sort_order' => 8
            ],
            [
                'name' => '🎤 Konsultasi 1 Jam',
                'slug' => 'consultation-1hour',
                'type' => 'fixed',
                'price' => 100000, // Rp 100k fixed
                'description' => 'Sesi bimbingan langsung 1 jam via Zoom/WhatsApp call',
                'icon' => 'bi-camera-video',
                'sort_order' => 9
            ],
            [
                'name' => '🎨 Presentasi Slide Pro',
                'slug' => 'presentation-pro',
                'type' => 'fixed',
                'price' => 120000, // Rp 120k fixed
                'description' => 'Slide presentasi profesional + animasi + script presentasi',
                'icon' => 'bi-file-earmark-slides',
                'sort_order' => 10
            ]
        ];

        foreach ($addons as $addon) {
            Addon::create($addon);
        }
    }
}
