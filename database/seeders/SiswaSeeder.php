<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Siswa;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Siswa::create([
            'nis' => '12345',
            'nama' => 'Siswa Test',
            'kelas' => 'X',
        ]);

        Siswa::create([
            'nis' => '67890',
            'nama' => 'Siswa Lain',
            'kelas' => 'XI',
        ]);
    }
}
