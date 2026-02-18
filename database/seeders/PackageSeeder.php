<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\Package;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        // Get all services
        $services = Service::all();

        foreach ($services as $service) {
            // Determine price per unit based on service name/category
            $basePrice = $this->getBasePrice($service->name);

            // Create 3 packages: Hemat, Standar, Premium
            Package::create([
                'service_id' => $service->id,
                'name' => 'Paket Hemat',
                'slug' => 'hemat',
                'price_per_unit' => $basePrice * 0.7, // 30% discount
                'description' => 'Paket ekonomis tanpa revisi. Cocok untuk tugas sederhana dengan deadline normal.',
                'features' => [
                    'Pengerjaan standar',
                    'Format dasar',
                    'Tanpa revisi',
                    'Deadline normal (5-7 hari)',
                    'WhatsApp support'
                ],
                'min_quantity' => 1,
                'is_active' => true,
                'sort_order' => 1
            ]);

            Package::create([
                'service_id' => $service->id,
                'name' => 'Paket Standar',
                'slug' => 'standar',
                'price_per_unit' => $basePrice, // Base price
                'description' => 'Paket paling populer dengan revisi dan kualitas terjamin. Cocok untuk sebagian besar kebutuhan.',
                'features' => [
                    'Pengerjaan detail',
                    'Format rapi',
                    '1x revisi gratis',
                    'Deadline fleksibel (3-5 hari)',
                    'WhatsApp + Email support',
                    'Konsultasi singkat'
                ],
                'min_quantity' => 1,
                'is_active' => true,
                'sort_order' => 2
            ]);

            Package::create([
                'service_id' => $service->id,
                'name' => 'Paket Premium',
                'slug' => 'premium',
                'price_per_unit' => $basePrice * 1.5, // 50% premium
                'description' => 'Paket terbaik dengan revisi unlimited dan prioritas tinggi. Cocok untuk tugas penting dan deadline ketat.',
                'features' => [
                    'Pengerjaan expert',
                    'Format premium',
                    'Revisi unlimited',
                    'Priority deadline (1-3 hari)',
                    '24/7 WhatsApp support',
                    'Konsultasi detail',
                    'Quality assurance',
                    'Refund guarantee'
                ],
                'min_quantity' => 1,
                'is_active' => true,
                'sort_order' => 3
            ]);
        }
    }

    private function getBasePrice($serviceName)
    {
        // Harga per unit berdasarkan tipe service (STANDAR PASAR INDONESIA 2026)
        $serviceName = strtolower($serviceName);
        
        // ACADEMIC - Per Halaman/Unit
        if (str_contains($serviceName, 'makalah')) {
            return 7500; // 5k-10k/halaman → average 7.5k
        } elseif (str_contains($serviceName, 'proposal')) {
            return 15000; // 15k/halaman standar
        } elseif (str_contains($serviceName, 'skripsi') || str_contains($serviceName, 'thesis')) {
            return 20000; // 20k/halaman
        } elseif (str_contains($serviceName, 'tesis')) {
            return 30000; // 30k/halaman (tertinggi)
        }
        
        // ASSIGNMENTS - Per Paket
        else if (str_contains($serviceName, 'tugas') || str_contains($serviceName, 'homework')) {
            return 75000; // 25k-120k → average 75k
        } elseif (str_contains($serviceName, 'essay') || str_contains($serviceName, 'esai')) {
            return 12000; // Per halaman
        } elseif (str_contains($serviceName, 'ulangan') || str_contains($serviceName, 'test')) {
            return 50000; // Per set
        } elseif (str_contains($serviceName, 'kuis')) {
            return 30000; // Per kuis
        }
        
        // TECHNOLOGY - Per Level/Project
        else if (str_contains($serviceName, 'iot') || str_contains($serviceName, 'mikrokontroler')) {
            return 500000; // 250k-900k → average 500k
        } elseif (str_contains($serviceName, 'programming') || str_contains($serviceName, 'coding')) {
            return 350000; // Per project
        } elseif (str_contains($serviceName, 'web') || str_contains($serviceName, 'website')) {
            return 300000; // Per fitur/page
        } elseif (str_contains($serviceName, 'mobile') || str_contains($serviceName, 'app')) {
            return 400000; // Per fitur
        }
        
        // OTHER
        else if (str_contains($serviceName, 'design') || str_contains($serviceName, 'desain')) {
            return 100000; // Per desain
        } elseif (str_contains($serviceName, 'presentation') || str_contains($serviceName, 'ppt')) {
            return 50000; // Per slide set (20 slides)
        } elseif (str_contains($serviceName, 'video') || str_contains($serviceName, 'editing')) {
            return 200000; // Per menit
        } elseif (str_contains($serviceName, 'translasi') || str_contains($serviceName, 'translation')) {
            return 8000; // Per 100 kata
        }
        
        else {
            return 50000; // Default fallback
        }
    }
}
