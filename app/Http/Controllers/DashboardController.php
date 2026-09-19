<?php

namespace App\Http\Controllers;

use App\Models\SpmIndicator;

class DashboardController extends Controller
{
    public function index()
    {
        $indicators = SpmIndicator::query()
            ->orderBy('kode')
            ->get();

        $totalIndikator = $indicators->count();

        $totalSasaran = $indicators->sum('target');

        $totalCapaian = $indicators->sum('capaian');

        $rataRata = $totalIndikator > 0
            ? round($indicators->avg(function ($item) {
                return $item->target > 0
                    ? min(100, ($item->capaian / $item->target) * 100)
                    : 0;
            }), 1)
            : 0;

        $indikatorBaik = $indicators->filter(function ($item) {
            return $item->target > 0
                && (($item->capaian / $item->target) * 100) >= 80;
        })->count();

        $indikatorPerhatian = $indicators->filter(function ($item) {
            return $item->target > 0
                && (($item->capaian / $item->target) * 100) < 50;
        })->count();

        return view('dashboard', compact(
            'indicators',
            'totalIndikator',
            'totalSasaran',
            'totalCapaian',
            'rataRata',
            'indikatorBaik',
            'indikatorPerhatian'
        ));
    }
}
