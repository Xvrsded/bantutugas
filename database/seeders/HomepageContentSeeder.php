<?php

namespace Database\Seeders;

use App\Models\Portfolio;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class HomepageContentSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            ['name' => 'Tugas SMA (Matematika, IPA, IPS)', 'category' => 'academic-sma', 'description' => 'Bantuan mengerjakan tugas sekolah menengah atas dengan solusi lengkap dan penjelasan', 'icon' => 'book', 'price_start' => 50000, 'price_end' => 200000],
            ['name' => 'Tugas Kuliah (Semua Jurusan)', 'category' => 'academic-kuliah', 'description' => 'Bantuan mengerjakan tugas perkuliahan dari berbagai disiplin ilmu', 'icon' => 'book', 'price_start' => 75000, 'price_end' => 500000],
            ['name' => 'Penulisan Makalah & Paper', 'category' => 'academic-makalah', 'description' => 'Penulisan makalah ilmiah dengan struktur dan format yang sempurna', 'icon' => 'file-earmark-text', 'price_start' => 150000, 'price_end' => 1000000],
            ['name' => 'Penulisan Skripsi', 'category' => 'academic-skripsi', 'description' => 'Pendampingan lengkap penulisan skripsi dari awal hingga akhir', 'icon' => 'book-half', 'price_start' => 500000, 'price_end' => 5000000],
            ['name' => 'Penulisan Tesis & Disertasi', 'category' => 'academic-tesis', 'description' => 'Pendampingan penulisan tesis untuk program pasca sarjana', 'icon' => 'book-half', 'price_start' => 2000000, 'price_end' => 10000000],
            ['name' => 'Revisi & Editing Dosen', 'category' => 'academic-revisi', 'description' => 'Membantu memperbaiki revisi dari dosen dengan detail dan profesional', 'icon' => 'pencil-square', 'price_start' => 100000, 'price_end' => 800000],
            ['name' => 'Olah Data & Analisis Statistik', 'category' => 'academic-olahdata', 'description' => 'Pengolahan data penelitian menggunakan software statistik profesional', 'icon' => 'graph-up', 'price_start' => 200000, 'price_end' => 2000000],
            ['name' => 'Desain & Fabrikasi PCB', 'category' => 'tech-pcb', 'description' => 'Desain PCB profesional dan layanan fabrikasi untuk proyek elektronik Anda', 'icon' => 'cpu', 'price_start' => 300000, 'price_end' => 3000000],
            ['name' => 'Proyek IoT (Arduino & ESP32)', 'category' => 'tech-iot', 'description' => 'Pengembangan proyek IoT lengkap dengan mikrokontroler Arduino dan ESP32', 'icon' => 'bezier2', 'price_start' => 500000, 'price_end' => 5000000],
            ['name' => 'Web Monitoring & Dashboard', 'category' => 'tech-webmonitoring', 'description' => 'Membuat sistem monitoring real-time dengan dashboard web interaktif', 'icon' => 'graph-up-arrow', 'price_start' => 1000000, 'price_end' => 10000000],
            ['name' => 'Jasa Pemrograman & Development', 'category' => 'tech-programming', 'description' => 'Layanan development website, aplikasi web, dan backend system', 'icon' => 'code-square', 'price_start' => 1500000, 'price_end' => 20000000],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(
                ['name' => $service['name']],
                [
                    ...$service,
                    'features' => json_encode(['Kualitas terjamin', 'Pengerjaan tepat waktu', 'Konsultasi gratis']),
                    'is_active' => true,
                ]
            );
        }

        $portfolios = [
            ['title' => 'IoT Automation Gates', 'category' => 'iot', 'description' => 'Sistem IoT automation gates menggunakan RFID untuk akses gerbang otomatis dengan monitoring real-time.', 'image' => 'portfolio-images/IoT1.jpg|portfolio-images/IoT2.jpg'],
            ['title' => 'Website Monitoring Detak Jantung', 'category' => 'programming', 'description' => 'Website monitoring detak jantung berbasis dashboard real-time untuk menampilkan data sensor secara akurat.', 'image' => 'portfolio-images/websiteMonitoring.png|portfolio-images/websiteMonitoring2.png'],
            ['title' => 'Design PCB', 'category' => 'pcb', 'description' => 'Perancangan design PCB dari skematik hingga layout siap produksi untuk kebutuhan prototipe.', 'image' => 'portfolio-images/DesignPCB1.png|portfolio-images/DesignPCB2.png'],
        ];

        foreach ($portfolios as $portfolio) {
            Portfolio::updateOrCreate(
                ['title' => $portfolio['title']],
                [
                    ...$portfolio,
                    'client_name' => 'Client Bantu Tugas',
                    'project_url' => '#',
                    'technologies' => json_encode(['Laravel', 'MySQL', 'Bootstrap']),
                    'is_featured' => true,
                ]
            );
        }

        if (Testimonial::count() === 0) {
            Testimonial::create([
                'name' => 'Rina A.',
                'email' => 'rina@example.com',
                'rating' => 5,
                'message' => 'Pelayanannya cepat dan hasilnya sesuai ekspektasi. Sangat membantu!',
                'is_approved' => true,
            ]);
        }
    }
}
