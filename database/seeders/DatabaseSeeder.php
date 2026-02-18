<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Service;
use App\Models\Portfolio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        User::factory()->create([
            'name' => 'Admin Academy',
            'email' => 'admin@academictechsupport.com',
            'password' => bcrypt('password123'),
        ]);

        // Create Services
        Service::create([
            'name' => 'Tugas SMA (Matematika, IPA, IPS)',
            'category' => 'academic-sma',
            'description' => 'Bantuan mengerjakan tugas sekolah menengah atas dengan solusi lengkap dan penjelasan',
            'icon' => 'book',
            'price_start' => 50000,
            'price_end' => 200000,
            'features' => json_encode(['Solusi lengkap', 'Penjelasan detail', 'Revisi unlimited', 'Dijamin akurat']),
            'is_active' => true
        ]);

        Service::create([
            'name' => 'Tugas Kuliah (Semua Jurusan)',
            'category' => 'academic-kuliah',
            'description' => 'Bantuan mengerjakan tugas perkuliahan dari berbagai disiplin ilmu',
            'icon' => 'book',
            'price_start' => 75000,
            'price_end' => 500000,
            'features' => json_encode(['Sesuai kurikulum', 'Sumber terpercaya', 'Format APA/Harvard', 'Konsultasi gratis']),
            'is_active' => true
        ]);

        Service::create([
            'name' => 'Penulisan Makalah & Paper',
            'category' => 'academic-makalah',
            'description' => 'Penulisan makalah ilmiah dengan struktur dan format yang sempurna',
            'icon' => 'file-earmark-text',
            'price_start' => 150000,
            'price_end' => 1000000,
            'features' => json_encode(['Plagiasi 0%', 'Referensi lengkap', 'Edit berkali-kali', 'Pengumpulan tepat waktu']),
            'is_active' => true
        ]);

        Service::create([
            'name' => 'Penulisan Skripsi',
            'category' => 'academic-skripsi',
            'description' => 'Pendampingan lengkap penulisan skripsi dari awal hingga akhir',
            'icon' => 'book-half',
            'price_start' => 500000,
            'price_end' => 5000000,
            'features' => json_encode(['Konsultasi langsung', 'Siap revisi dosen', 'Panduan presentasi', 'Garansi lulus']),
            'is_active' => true
        ]);

        Service::create([
            'name' => 'Penulisan Tesis & Disertasi',
            'category' => 'academic-tesis',
            'description' => 'Pendampingan penulisan tesis untuk program pasca sarjana',
            'icon' => 'book-half',
            'price_start' => 2000000,
            'price_end' => 10000000,
            'features' => json_encode(['Mentor profesional', 'Publikasi siap', 'Defendable content', 'Support penuh']),
            'is_active' => true
        ]);

        Service::create([
            'name' => 'Revisi & Editing Dosen',
            'category' => 'academic-revisi',
            'description' => 'Membantu memperbaiki revisi dari dosen dengan detail dan profesional',
            'icon' => 'pencil-square',
            'price_start' => 100000,
            'price_end' => 800000,
            'features' => json_encode(['Cepat & efisien', 'Sesuai feedback', 'Garansi revisi diterima', 'Update real-time']),
            'is_active' => true
        ]);

        Service::create([
            'name' => 'Olah Data & Analisis Statistik',
            'category' => 'academic-olahdata',
            'description' => 'Pengolahan data penelitian menggunakan software statistik profesional',
            'icon' => 'graph-up',
            'price_start' => 200000,
            'price_end' => 2000000,
            'features' => json_encode(['SPSS, R, Python', 'Interpretasi lengkap', 'Siap publikasi', 'Konsultasi analisis']),
            'is_active' => true
        ]);

        Service::create([
            'name' => 'Desain & Fabrikasi PCB',
            'category' => 'tech-pcb',
            'description' => 'Desain PCB profesional dan layanan fabrikasi untuk proyek elektronik Anda',
            'icon' => 'cpu',
            'price_start' => 300000,
            'price_end' => 3000000,
            'features' => json_encode(['Desain KiCad/Eagle', 'Simulasi lengkap', 'Produksi prototype', 'Testing support']),
            'is_active' => true
        ]);

        Service::create([
            'name' => 'Proyek IoT (Arduino & ESP32)',
            'category' => 'tech-iot',
            'description' => 'Pengembangan proyek IoT lengkap dengan mikrokontroler Arduino dan ESP32',
            'icon' => 'bezier2',
            'price_start' => 500000,
            'price_end' => 5000000,
            'features' => json_encode(['Program microcontroller', 'Cloud integration', 'Sensor interfacing', 'Mobile app']),
            'is_active' => true
        ]);

        Service::create([
            'name' => 'Web Monitoring & Dashboard',
            'category' => 'tech-webmonitoring',
            'description' => 'Membuat sistem monitoring real-time dengan dashboard web interaktif',
            'icon' => 'graph-up-arrow',
            'price_start' => 1000000,
            'price_end' => 10000000,
            'features' => json_encode(['Real-time data', 'API integration', 'Database design', 'Responsive design']),
            'is_active' => true
        ]);

        Service::create([
            'name' => 'Jasa Pemrograman & Development',
            'category' => 'tech-programming',
            'description' => 'Layanan development website, aplikasi web, dan backend system',
            'icon' => 'code-square',
            'price_start' => 1500000,
            'price_end' => 20000000,
            'features' => json_encode(['Full stack dev', 'Database design', 'API development', 'Testing & QA']),
            'is_active' => true
        ]);

        // Create Portfolio
        Portfolio::create([
            'title' => 'Sistem Monitoring Suhu Real-time IoT',
            'category' => 'iot',
            'description' => 'Sistem monitoring suhu ruangan real-time menggunakan ESP32 dan web dashboard',
            'image' => null,
            'client_name' => 'PT Teknologi Maju',
            'project_url' => '#',
            'technologies' => json_encode(['ESP32', 'Firebase', 'React', 'Arduino IDE']),
            'is_featured' => true
        ]);

        Portfolio::create([
            'title' => 'Website E-Learning untuk Universitas',
            'category' => 'programming',
            'description' => 'Platform e-learning lengkap dengan fitur kelas, assignment, dan grading otomatis',
            'image' => null,
            'client_name' => 'Universitas Mitra',
            'project_url' => '#',
            'technologies' => json_encode(['Laravel', 'Vue.js', 'MySQL', 'Docker']),
            'is_featured' => true
        ]);

        Portfolio::create([
            'title' => 'Skripsi IoT Smart Home',
            'category' => 'academic',
            'description' => 'Pendampingan penyelesaian skripsi tentang sistem smart home berbasis Arduino',
            'image' => null,
            'client_name' => 'Mahasiswa Teknik Elektro',
            'project_url' => '#',
            'technologies' => json_encode(['Arduino', 'Blynk', 'IoT', 'Dokumentasi']),
            'is_featured' => true
        ]);
    }
}
