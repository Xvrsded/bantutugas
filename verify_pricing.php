<?php
require 'bootstrap/app.php';

$app = app();

$services = \App\Models\Service::with('activePackages')->limit(6)->get();

foreach($services as $s) {
    echo $s->name . ":\n";
    foreach($s->activePackages as $p) {
        echo "  " . $p->name . " - Rp" . number_format($p->price_per_unit, 0) . "/" . $p->unit_label . " (min " . $p->min_quantity . ")\n";
    }
    echo "\n";
}
