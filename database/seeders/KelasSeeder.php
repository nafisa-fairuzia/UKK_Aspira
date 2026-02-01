<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kelas;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $tingkat = ['X', 'XI', 'XII'];
        $jurusan2 = ['TKJ', 'RPL', 'DKV', 'APT', 'ATPH'];
        $jurusan3 = ['TSM', 'TKR'];

        foreach ($tingkat as $t) {
            foreach ($jurusan2 as $j) {
                for ($i = 1; $i <= 2; $i++) {
                    \App\Models\Kelas::updateOrCreate(['nama_kelas' => "$t $j $i"]);
                }
            }
            foreach ($jurusan3 as $j) {
                for ($i = 1; $i <= 3; $i++) {
                    \App\Models\Kelas::updateOrCreate(['nama_kelas' => "$t $j $i"]);
                }
            }
        }
    }
}
