<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'parpols_id',
        'jenis_pelanggaran_id',
        'status_peserta_pemilu',
        'nama_bacaleg',
        'dapil',
        'tanggal_input',
        'keterangan',
    ];

    public function pelanggaranImages()
    {
        return $this->hasMany(PelanggaranImages::class);
    }

    public function parpol()
    {
        return $this->belongsTo(Parpol::class, 'parpols_id');
    }


    public function jenisPelanggaran()
    {
        return $this->belongsTo(JenisPelanggaran::class);
    }

    public function laporanPelanggaran()
    {
        return $this->hasOne(LaporanPelanggaran::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'pelapor_id');
    }
}
