<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class verif extends Model
{
    use HasFactory;

    protected $fillable = [
        'laporan_pelanggaran_id',
        'status',
        'user_id',
        'note',
    ];

    public function laporanPelanggaran()
    {
        return $this->belongsTo(LaporanPelanggaran::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
