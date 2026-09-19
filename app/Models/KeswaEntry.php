<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeswaEntry extends Model
{
    protected $fillable = [
        'tanggal',
        'total_odgj_berat',
        'spm_sasaran',
        'spm_capaian',
        'f23',
        'f20',
        'manusak',
        'oelatimo',
        'pukdale',
        'nunkurus',
        'naibonat',
        'obat_sasaran',
        'obat_rutin',
        'obat_tidak_rutin',
        'obat_putus',
        'odgjb_baru',
        'pelacakan_sasaran',
        'pelacakan_capaian',
        'p3lp_sasaran',
        'skrining_sasaran',
        'skrining_capaian',
        'kendala',
        'solusi',
        'rencana_tindak_lanjut',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'total_odgj_berat' => 'integer',
        'spm_sasaran' => 'integer',
        'spm_capaian' => 'integer',
        'f23' => 'integer',
        'f20' => 'integer',
        'manusak' => 'integer',
        'oelatimo' => 'integer',
        'pukdale' => 'integer',
        'nunkurus' => 'integer',
        'naibonat' => 'integer',
        'obat_sasaran' => 'integer',
        'obat_rutin' => 'integer',
        'obat_tidak_rutin' => 'integer',
        'obat_putus' => 'integer',
        'odgjb_baru' => 'integer',
        'pelacakan_sasaran' => 'integer',
        'pelacakan_capaian' => 'integer',
        'p3lp_sasaran' => 'integer',
        'skrining_sasaran' => 'integer',
        'skrining_capaian' => 'integer',
    ];
}
