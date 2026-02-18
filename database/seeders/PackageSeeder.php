<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\Package;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        // REALISTIC PRICING FOR INDONESIAN STUDENT MARKET (2026)
        // Based on: 25k-100k+ range for academic work
        
        $services = Service::all();

        foreach ($services as $service) {
            $serviceCategory = strtolower($service->category ?? '');
            
            // TUGAS SMA - Per Paket (1-5 soal per paket)
            if (str_contains($serviceCategory, 'sma')) {
                $this->createPackages($service->id, 'Tugas SMA', [
                    'hemat' => ['price' => 25000, 'qty' => 1, 'unit' => 'paket'],
                    'standar' => ['price' => 40000, 'qty' => 1, 'unit' => 'paket'],
                    'premium' => ['price' => 60000, 'qty' => 1, 'unit' => 'paket']
                ]);
            }
            // TUGAS KULIAH - Per Paket (1-3 assignment per paket)
            elseif (str_contains($serviceCategory, 'kuliah')) {
                $this->createPackages($service->id, 'Tugas Kuliah', [
                    'hemat' => ['price' => 35000, 'qty' => 1, 'unit' => 'paket'],
                    'standar' => ['price' => 55000, 'qty' => 1, 'unit' => 'paket'],
                    'premium' => ['price' => 85000, 'qty' => 1, 'unit' => 'paket']
                ]);
            }
            // MAKALAH - Per Halaman (minimum 5 halaman)
            elseif (str_contains($serviceCategory, 'makalah')) {
                $this->createPackages($service->id, 'Penulisan Makalah', [
                    'hemat' => ['price' => 5000, 'qty' => 5, 'unit' => 'halaman'],
                    'standar' => ['price' => 8000, 'qty' => 5, 'unit' => 'halaman'],
                    'premium' => ['price' => 12000, 'qty' => 5, 'unit' => 'halaman']
                ]);
            }
            // SKRIPSI - Per Halaman (minimum 50 halaman)
            elseif (str_contains($serviceCategory, 'skripsi')) {
                $this->createPackages($service->id, 'Penulisan Skripsi', [
                    'hemat' => ['price' => 8000, 'qty' => 50, 'unit' => 'halaman'],
                    'standar' => ['price' => 12000, 'qty' => 50, 'unit' => 'halaman'],
                    'premium' => ['price' => 18000, 'qty' => 50, 'unit' => 'halaman']
                ]);
            }
            // TESIS - Per Halaman (minimum 80 halaman)
            elseif (str_contains($serviceCategory, 'tesis')) {
                $this->createPackages($service->id, 'Penulisan Tesis', [
                    'hemat' => ['price' => 15000, 'qty' => 80, 'unit' => 'halaman'],
                    'standar' => ['price' => 30000, 'qty' => 80, 'unit' => 'halaman'],
                    'premium' => ['price' => 60000, 'qty' => 80, 'unit' => 'halaman']
                ]);
            }
            // REVISI - Per Halaman (minimum 10 halaman)
            elseif (str_contains($serviceCategory, 'revisi')) {
                $this->createPackages($service->id, 'Revisi & Editing', [
                    'hemat' => ['price' => 3000, 'qty' => 10, 'unit' => 'halaman'],
                    'standar' => ['price' => 5000, 'qty' => 10, 'unit' => 'halaman'],
                    'premium' => ['price' => 8000, 'qty' => 10, 'unit' => 'halaman']
                ]);
            }
            // OTHER SERVICES - Per Item/Project (default pricing)
            else {
                $this->createPackages($service->id, $service->name, [
                    'hemat' => ['price' => 250000, 'qty' => 1, 'unit' => 'item'],
                    'standar' => ['price' => 400000, 'qty' => 1, 'unit' => 'item'],
                    'premium' => ['price' => 600000, 'qty' => 1, 'unit' => 'item']
                ]);
            }
        }
    }

    private function createPackages($serviceId, $serviceName, $pricing)
    {
        // HEMAT PACKAGE
        Package::updateOrCreate(
            [
                'service_id' => $serviceId,
                'slug' => 'hemat'
            ],
            [
            'service_id' => $serviceId,
            'name' => 'Paket Hemat',
            'slug' => 'hemat',
            'price_per_unit' => $pricing['hemat']['price'],
            'unit_label' => $pricing['hemat']['unit'],
            'min_quantity' => $pricing['hemat']['qty'],
            'description' => "Paket ekonomis untuk {$serviceName}. Pengerjaan standar tanpa revisi.",
            'features' => json_encode([
                'Pengerjaan standar',
                'Format dasar',
                'Tanpa revisi',
                'Deadline normal (5-7 hari)',
                'WhatsApp support'
            ]),
            'is_active' => true,
            'sort_order' => 1
            ]
        );

        // STANDAR PACKAGE
        Package::updateOrCreate(
            [
                'service_id' => $serviceId,
                'slug' => 'standar'
            ],
            [
            'service_id' => $serviceId,
            'name' => 'Paket Standar',
            'slug' => 'standar',
            'price_per_unit' => $pricing['standar']['price'],
            'unit_label' => $pricing['standar']['unit'],
            'min_quantity' => $pricing['standar']['qty'],
            'description' => "Paket populer untuk {$serviceName}. Dengan 1x revisi gratis.",
            'features' => json_encode([
                'Pengerjaan detail',
                'Format rapi & profesional',
                '1x revisi gratis',
                'Deadline fleksibel (3-5 hari)',
                'WhatsApp + Email support',
                'Konsultasi singkat'
            ]),
            'is_active' => true,
            'sort_order' => 2
            ]
        );

        // PREMIUM PACKAGE
        Package::updateOrCreate(
            [
                'service_id' => $serviceId,
                'slug' => 'premium'
            ],
            [
            'service_id' => $serviceId,
            'name' => 'Paket Premium',
            'slug' => 'premium',
            'price_per_unit' => $pricing['premium']['price'],
            'unit_label' => $pricing['premium']['unit'],
            'min_quantity' => $pricing['premium']['qty'],
            'description' => "Paket terbaik untuk {$serviceName}. Dengan 2x revisi & priority service.",
            'features' => json_encode([
                'Pengerjaan expert level',
                'Format premium & sempurna',
                '2x revisi gratis',
                'Priority deadline (1-3 hari)',
                '24/7 WhatsApp support',
                'Konsultasi detail',
                'Quality assurance & cek plagiasi'
            ]),
            'is_active' => true,
            'sort_order' => 3
            ]
        );
    }
}
