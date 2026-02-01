<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Kelas;

$kelas = Kelas::orderBy('nama_kelas')->get();
echo "Total Kelas: " . count($kelas) . "\n";

$grouped = $kelas->groupBy(function ($k) {
    return substr($k->nama_kelas, 0, 1);
});

foreach ($grouped as $tingkat => $items) {
    echo "\nTingkat $tingkat: " . count($items) . " kelas\n";
    foreach ($items as $k) {
        echo "  - $k->nama_kelas (ID: $k->id)\n";
    }
}
