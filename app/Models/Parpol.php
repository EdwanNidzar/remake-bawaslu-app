<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parpol extends Model
{
    use HasFactory;

    protected $fillable = [
        'parpol_number',
        'parpol_name',
        'parpol_picture',
    ];

    public function pelanggaran()
    {
        return $this->hasMany(Pelanggaran::class);
    }
}
