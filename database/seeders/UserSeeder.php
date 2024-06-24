<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $provinsi = User::create([
            'name' => 'Bawaslu Provinsi',
            'email' => 'provinsi@gmail.com',
            'password' => bcrypt('provinsi1234'),
        ]);
        $provinsi->assignRole('bawaslu-provinsi');

        $kota = User::create([
            'name' => 'Bawaslu Kota/Kabupaten',
            'email' => 'kota@gmail.com',
            'password' => bcrypt('kota1234'),
        ]);
        $kota->assignRole('bawaslu-kabupaten-kota');

        $kecamatan = User::create([
            'name' => 'Panwaslu Kecamatan',
            'email' => 'panwascam@gmail.com',
            'password' => bcrypt('panwascam1234'),
        ]);
        $kecamatan->assignRole('panwaslu-kecamatan');
    }
}
