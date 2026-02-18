<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

echo "\n=== PACKAGE PRICING STRUCTURE ===\n\n";

$packages = \App\Models\Package::with('service')->get();
$grouped = $packages->groupBy('service_id');

foreach ($grouped as $serviceId => $servicePackages) {
    $service = $servicePackages->first()->service;
    echo "📦 {$service->name}\n";
    
    foreach ($servicePackages->sortBy('sort_order') as $pkg) {
        $price = number_format($pkg->price_per_unit, 0, ',', '.');
        echo "   • {$pkg->name}: Rp {$price}/unit\n";
    }
    echo "\n";
}

echo "\n=== ADDON PRICING STRUCTURE ===\n\n";

$addons = \App\Models\Addon::all();
foreach ($addons as $addon) {
    $priceDisplay = '';
    if ($addon->type === 'percentage') {
        $priceDisplay = "+{$addon->price}% dari harga paket";
    } elseif ($addon->type === 'fixed') {
        $priceDisplay = "Rp " . number_format($addon->price, 0, ',', '.');
    } else {
        $priceDisplay = "Rp " . number_format($addon->price, 0, ',', '.') . "/unit";
    }
    
    echo "• {$addon->name} ({$addon->type}): {$priceDisplay}\n";
}

echo "\n=== PRICING EXAMPLES ===\n\n";

echo "Contoh 1: Makalah 10 halaman\n";
echo "   Paket Hemat: 5.250 × 10 = Rp 52.500\n";
echo "   Paket Standar: 7.500 × 10 = Rp 75.000\n";
echo "   Paket Premium: 11.250 × 10 = Rp 112.500\n";
echo "   + Express (20%): +22.500 → Total: Rp 97.500\n\n";

echo "Contoh 2: Programming Project\n";
echo "   Paket Standar: Rp 350.000\n";
echo "   + Source Code (+200k): +200.000 → Total: Rp 550.000\n";
echo "   + Unlimited Revision (+15%): +82.500 → Total: Rp 632.500\n\n";
