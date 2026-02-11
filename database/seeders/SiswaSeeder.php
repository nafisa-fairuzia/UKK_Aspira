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
        Siswa::firstOrCreate(
            ['nis' => '12345'],
            ['nama' => 'Anisa Putri', 'id_kelas' => 1, 'username' => 'anisa', 'password' => 'password123']
        );

        Siswa::firstOrCreate(
            ['nis' => '67890'],
            ['nama' => 'Farhan Akbar', 'id_kelas' => 2, 'username' => 'farhan', 'password' => 'password123']
        );
    }
}
