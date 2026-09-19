<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpmIndicator extends Model
{
    protected $fillable = [
        'kode',
        'nama_indikator',
        'deskripsi',
        'satuan',
        'target',
        'capaian',
        'tanggal',
        'keterangan',
    ];

    protected $casts = [
        'target' => 'integer',
        'capaian' => 'integer',
        'tanggal' => 'date',
    ];
}
