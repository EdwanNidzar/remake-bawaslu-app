<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PelanggaranImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $pelanggaranIds = [1, 2, 3]; // Array pelanggaran_id yang ingin Anda gunakan

        foreach ($pelanggaranIds as $pelanggaranId) {
            $numberOfImages = rand(1, 5); // Tentukan jumlah gambar acak untuk setiap pelanggaran_id

            for ($i = 0; $i < $numberOfImages; $i++) {
                // Generate a fake image
                $imagePath = $faker->image(storage_path('app/public/pelanggarans'), 480, 480, null, false);

                // Buat array data
                $data = [
                    'pelanggaran_id' => $pelanggaranId,
                    'image' => $imagePath,
                ];

                // Simpan data ke database
                \App\Models\PelanggaranImages::create($data);
            }
        }
    }
}
