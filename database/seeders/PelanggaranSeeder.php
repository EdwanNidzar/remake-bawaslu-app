<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PelanggaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pelanggaran = [
            [
                'parpols_id' => 1,
                'jenis_pelanggaran_id' => 1,
                'status_peserta_pemilu' => 'Tidak',
                'nama_bacaleg' => 'Budi',
                'dapil' => 'Jawa Tengah 1',
                'tanggal_input' => '2021-01-01',
                'keterangan' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                'pelapor_id' => 3,
            ],
            [
                'parpols_id' => 2,
                'jenis_pelanggaran_id' => 2,
                'status_peserta_pemilu' => 'Tidak',
                'nama_bacaleg' => 'Andi',
                'dapil' => 'Jawa Tengah 2',
                'tanggal_input' => '2021-01-02',
                'keterangan' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                'pelapor_id' => 3,
            ],
            [
                'parpols_id' => 3,
                'jenis_pelanggaran_id' => 3,
                'status_peserta_pemilu' => 'Tidak',
                'nama_bacaleg' => 'Caca',
                'dapil' => 'Jawa Tengah 3',
                'tanggal_input' => '2021-01-03',
                'keterangan' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                'pelapor_id' => 3,
            ],
        ];

        foreach ($pelanggaran as $data) {
            \App\Models\Pelanggaran::create($data);
        }
    }
}
