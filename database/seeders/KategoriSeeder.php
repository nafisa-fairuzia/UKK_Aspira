<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategori = [
            'AC Rusak',
            'Kursi Rusak',
            'Meja Rusak',
            'Lampu Rusak',
            'Proyektor Rusak',
            'Komputer Rusak',
            'Kabel Rusak',
            'Lainnya'
        ];

        foreach ($kategori as $kat) {
            Kategori::create([
                'ket_kategori' => $kat
            ]);
        }
    }
}
