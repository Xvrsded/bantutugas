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
        // Base price per unit (halaman/soal/project) based on service name
        $serviceName = strtolower($serviceName);
        
        if (str_contains($serviceName, 'essay') || str_contains($serviceName, 'esai')) {
            return 15000;
        } elseif (str_contains($serviceName, 'skripsi') || str_contains($serviceName, 'thesis')) {
            return 25000;
        } elseif (str_contains($serviceName, 'coding') || str_contains($serviceName, 'programming')) {
            return 75000;
        } elseif (str_contains($serviceName, 'design') || str_contains($serviceName, 'desain')) {
            return 50000;
        } elseif (str_contains($serviceName, 'presentation') || str_contains($serviceName, 'ppt')) {
            return 20000;
        } elseif (str_contains($serviceName, 'video')) {
            return 40000;
        } else {
            return 12000; // Default
        }
    }
}
