@extends('layouts.app')

@section('content')

@php
    $records = $indicators->getCollection();

    $total = $records->count();

    $baik = $records->filter(fn($x) =>
        $x->target > 0 && ($x->capaian / $x->target * 100) >= 80
    )->count();

    $cukup = $records->filter(fn($x) =>
        $x->target > 0 &&
        ($x->capaian / $x->target * 100) >= 50 &&
        ($x->capaian / $x->target * 100) < 80
    )->count();

    $perhatian = $records->filter(fn($x) =>
        $x->target > 0 && ($x->capaian / $x->target * 100) < 50
    )->count();

    $average = $records->count()
        ? round($records->avg(fn($x) =>
            $x->target > 0
                ? min(100, ($x->capaian / $x->target) * 100)
                : 0
        ), 1)
        : 0;
@endphp

<style>
    .spm-page-title {
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:20px;
    }

    .spm-title-left {
        display:flex;
        align-items:center;
        gap:15px;
    }

    .spm-title-icon {
        width:54px;
        height:54px;
        border-radius:13px;
        background:#e8f9f7;
        color:#08a99d;
        display:flex;
        align-items:center;
        justify-content:center;
    }

    .spm-title {
        font-size:29px;
        font-weight:800;
        color:#0d2142;
        line-height:1.1;
    }

    .spm-subtitle {
        color:#7085a0;
        font-size:14px;
        margin-top:5px;
    }

    .spm-filter {
        display:flex;
        align-items:center;
        gap:10px;
        margin-top:5px;
    }

    .spm-filter select {
        height:42px;
        border:1px solid #d8e2eb;
        border-radius:9px;
        background:white;
        padding:0 38px 0 13px;
        color:#17345f;
        font-size:13px;
    }

    .spm-btn {
        height:42px;
        padding:0 18px;
        border:0;
        border-radius:9px;
        font-weight:700;
        cursor:pointer;
        text-decoration:none;
        display:inline-flex;
        align-items:center;
        justify-content:center;
        gap:7px;
    }

    .spm-btn-teal {
        background:#079f96;
        color:white;
    }

    .spm-btn-light {
        background:#eaf0f5;
        color:#37506b;
    }

    .spm-kpis {
        display:grid;
        grid-template-columns:repeat(5,1fr);
        gap:12px;
        margin-top:20px;
    }

    .spm-kpi {
        min-height:98px;
        background:rgba(255,255,255,.85);
        border:1px solid #e6edf2;
        border-radius:12px;
        padding:13px 15px;
        display:flex;
        align-items:center;
        gap:12px;
        box-shadow:0 5px 20px rgba(15,23,42,.035);
    }

    .kpi-icon {
        width:43px;
        height:43px;
        min-width:43px;
        border-radius:50%;
        display:flex;
        align-items:center;
        justify-content:center;
    }

    .kpi-number {
        font-size:25px;
        line-height:1;
        font-weight:800;
        color:#102a43;
    }

    .kpi-label {
        font-size:12px;
        color:#405b78;
        margin-top:4px;
    }

    .kpi-small {
        font-size:10px;
        color:#8798ab;
        margin-top:3px;
    }

    .spm-grid {
        display:grid;
        grid-template-columns:repeat(4, minmax(0,1fr));
        gap:14px;
        margin-top:14px;
    }

    .spm-card {
        background:white;
        border:1px solid #e8eef3;
        border-radius:13px;
        padding:15px;
        box-shadow:0 5px 20px rgba(15,23,42,.04);
        transition:.18s ease;
    }

    .spm-card:hover {
        transform:translateY(-2px);
        box-shadow:0 12px 28px rgba(15,23,42,.08);
    }

    .indicator-head {
        display:flex;
        gap:12px;
        min-height:70px;
    }

    .indicator-icon {
        width:58px;
        height:58px;
        min-width:58px;
        border-radius:10px;
        display:flex;
        align-items:center;
        justify-content:center;
    }

    .indicator-code {
        color:#087cf0;
        font-size:12px;
        font-weight:700;
    }

    .indicator-name {
        color:#0d2142;
        font-size:15px;
        font-weight:700;
        line-height:1.25;
        margin-top:4px;
    }

    .values {
        display:grid;
        grid-template-columns:1fr 1fr;
        margin-top:13px;
    }

    .value-label {
        color:#66809e;
        font-size:12px;
    }

    .value-number {
        color:#102a43;
        font-size:19px;
        font-weight:800;
        margin-top:2px;
    }

    .value-number.capaian {
        color:#087f78;
    }

    .percent-row {
        display:flex;
        align-items:center;
        gap:9px;
        margin-top:8px;
    }

    .percent {
        min-width:59px;
        font-size:17px;
        font-weight:800;
    }

    .progress-bg {
        flex:1;
        height:8px;
        background:#e8eef2;
        border-radius:99px;
        overflow:hidden;
    }

    .progress-bar {
        height:100%;
        border-radius:99px;
    }

    .card-bottom {
        display:flex;
        align-items:center;
        justify-content:space-between;
        margin-top:11px;
    }

    .status {
        display:inline-flex;
        align-items:center;
        gap:6px;
        padding:6px 11px;
        border-radius:8px;
        font-size:11px;
        font-weight:700;
    }

    .status-dot {
        width:9px;
        height:9px;
        border-radius:50%;
        background:currentColor;
    }

    .detail-btn {
        border:1px solid #dce5ec;
        background:white;
        border-radius:7px;
        padding:7px 11px;
        font-size:11px;
        color:#405b78;
        text-decoration:none;
    }

    @media(max-width:1250px) {
        .spm-grid {
            grid-template-columns:repeat(3,1fr);
        }

        .spm-kpis {
            grid-template-columns:repeat(3,1fr);
        }
    }

    @media(max-width:850px) {
        .spm-page-title {
            flex-direction:column;
            align-items:flex-start;
        }

        .spm-grid {
            grid-template-columns:repeat(2,1fr);
        }

        .spm-kpis {
            grid-template-columns:repeat(2,1fr);
        }

        .spm-filter {
            flex-wrap:wrap;
        }
    }

    @media(max-width:550px) {
        .spm-grid,
        .spm-kpis {
            grid-template-columns:1fr;
        }
    }
</style>

<div>

    {{-- HEADER --}}
    <div class="spm-page-title">

        <div class="spm-title-left">

            <div class="spm-title-icon">
                <svg width="30" height="30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="2.5" stroke-linecap="round" d="M4 19V10M10 19V6M16 19V3M22 19V12"/>
                </svg>
            </div>

            <div>
                <div class="spm-title">SPM Kesehatan</div>
                <div class="spm-subtitle">
                    Monitoring Standar Pelayanan Minimal Puskesmas Naibonat
                </div>
            </div>

        </div>

        <div class="spm-filter">

            <span style="font-size:13px;color:#17345f;">Bulan</span>

            <select name="bulan" form="filter-spm">
                <option value="">Semua</option>
                @foreach(range(1,12) as $bulan)
                    <option value="{{ $bulan }}" @selected(request('bulan') == $bulan)>
                        {{ \Carbon\Carbon::create()->month($bulan)->translatedFormat('F') }}
                    </option>
                @endforeach
            </select>

            <span style="font-size:13px;color:#17345f;">Tahun</span>

            <select name="tahun" form="filter-spm">
                <option value="">Semua</option>
                @foreach(range(now()->year - 2, now()->year + 1) as $tahun)
                    <option value="{{ $tahun }}" @selected(request('tahun') == $tahun)>
                        {{ $tahun }}
                    </option>
                @endforeach
            </select>

            <form id="filter-spm" method="GET" style="display:none"></form>

            <button type="submit" form="filter-spm" class="spm-btn spm-btn-teal">
                ⏷ Filter
            </button>

            <a href="{{ route('spm.index') }}" class="spm-btn spm-btn-light">
                ↻ Reset
            </a>

            <a href="{{ route('spm.create') }}" class="spm-btn spm-btn-teal">
                ＋ Tambah Data
            </a>

        </div>

    </div>

    {{-- KPI --}}
    <div class="spm-kpis">

        <div class="spm-kpi">
            <div class="kpi-icon" style="background:#dff0ff;color:#1788e8;">
                <span style="font-size:23px;">▤</span>
            </div>
            <div>
                <div class="kpi-number">{{ $total }}</div>
                <div class="kpi-label">Total Indikator</div>
                <div class="kpi-small">SPM Kesehatan</div>
            </div>
        </div>

        <div class="spm-kpi">
            <div class="kpi-icon" style="background:#dcf8e9;color:#12a85e;">
                <span style="font-size:25px;">✓</span>
            </div>
            <div>
                <div class="kpi-number">{{ $baik }}</div>
                <div class="kpi-label">≥ 80% (Baik)</div>
                <div class="kpi-small">{{ $total ? round($baik/$total*100,1) : 0 }}% dari total</div>
            </div>
        </div>

        <div class="spm-kpi">
            <div class="kpi-icon" style="background:#fff1c9;color:#e99a00;">
                <span style="font-size:23px;">!</span>
            </div>
            <div>
                <div class="kpi-number">{{ $cukup }}</div>
                <div class="kpi-label">50% - 79% (Cukup)</div>
                <div class="kpi-small">{{ $total ? round($cukup/$total*100,1) : 0 }}% dari total</div>
            </div>
        </div>

        <div class="spm-kpi">
            <div class="kpi-icon" style="background:#ffe1e1;color:#ed4d55;">
                <span style="font-size:23px;">×</span>
            </div>
            <div>
                <div class="kpi-number">{{ $perhatian }}</div>
                <div class="kpi-label">&lt; 50% (Perlu Perhatian)</div>
                <div class="kpi-small">{{ $total ? round($perhatian/$total*100,1) : 0 }}% dari total</div>
            </div>
        </div>

        <div class="spm-kpi">

            <div style="width:64px;height:64px;border-radius:50%;display:flex;align-items:center;justify-content:center;
                        background:conic-gradient(#079f96 {{ $average }}%, #e5edf1 0);
                        position:relative;">

                <div style="width:48px;height:48px;border-radius:50%;background:white;display:flex;align-items:center;justify-content:center;
                            font-size:16px;font-weight:800;color:#087f78;">
                    {{ $average }}%
                </div>

            </div>

            <div>
                <div class="kpi-number" style="font-size:15px;">Rata-rata Capaian</div>
                <div class="kpi-label">Semua Indikator</div>
            </div>

        </div>

    </div>

    {{-- CARDS --}}
    <div class="spm-grid">

        @foreach($indicators as $index => $indicator)

            @php
                $percentage = $indicator->target > 0
                    ? round(($indicator->capaian / $indicator->target) * 100, 1)
                    : 0;

                $width = min(100, max(0, $percentage));

                if ($percentage >= 80) {
                    $color = '#08ad75';
                    $bg = '#e1f7ef';
                    $status = 'Baik';
                } elseif ($percentage >= 50) {
                    $color = '#f1a900';
                    $bg = '#fff4d6';
                    $status = 'Cukup';
                } else {
                    $color = '#e74c55';
                    $bg = '#ffe7e7';
                    $status = 'Perlu Perhatian';
                }

                $iconBg = [
                    '#ffe0e8',
                    '#ffe0e8',
                    '#dff1ff',
                    '#fff0db',
                    '#eee5ff',
                    '#dcf8f5',
                    '#e9edf1',
                    '#ffe1e5',
                    '#e9e1ff',
                    '#dcf5e8',
                    '#fff0d4',
                    '#dff6f5'
                ][$index % 12];

                $iconColor = [
                    '#e82f62',
                    '#e82f62',
                    '#1388ef',
                    '#ed7413',
                    '#7a3ff2',
                    '#079f96',
                    '#526779',
                    '#e52d42',
                    '#6339db',
                    '#1c9d56',
                    '#e89900',
                    '#078b89'
                ][$index % 12];

                $icons = [
                    '♧','♙','♙','♟','▣','♟','♟','♥','◉','✣','◒','♢'
                ];
            @endphp

            <div class="spm-card">

                <div class="indicator-head">

                    <div class="indicator-icon"
                         style="background:{{ $iconBg }};color:{{ $iconColor }};font-size:27px;font-weight:800;">
                        {{ $icons[$index % 12] }}
                    </div>

                    <div>
                        <div class="indicator-code">
                            {{ $indicator->kode }}
                        </div>

                        <div class="indicator-name">
                            {{ $indicator->nama_indikator }}
                        </div>
                    </div>

                </div>

                <div class="values">

                    <div>
                        <div class="value-label">Sasaran</div>
                        <div class="value-number">
                            {{ number_format($indicator->target) }}
                        </div>
                    </div>

                    <div>
                        <div class="value-label">Capaian</div>
                        <div class="value-number capaian">
                            {{ number_format($indicator->capaian) }}
                        </div>
                    </div>

                </div>

                {{-- OTOMATIS --}}
                <div class="percent-row">

                    <div class="percent" style="color:{{ $color }}">
                        {{ number_format($percentage,1) }}%
                    </div>

                    <div class="progress-bg">
                        <div class="progress-bar"
                             style="width:{{ $width }}%;background:{{ $color }}">
                        </div>
                    </div>

                </div>

                <div class="card-bottom">

                    <div class="status"
                         style="background:{{ $bg }};color:{{ $color }}">

                        <span class="status-dot"></span>
                        {{ $status }}

                    </div>

                    <div style="display:flex;gap:5px;">

                        <a href="{{ route('spm.edit', $indicator) }}"
                           class="detail-btn">
                            Lihat Detail
                        </a>

                        <a href="{{ route('spm.edit', $indicator) }}"
                           class="detail-btn"
                           title="Edit">
                            ⋯
                        </a>

                    </div>

                </div>

            </div>

        @endforeach

    </div>

    <div style="margin-top:18px;">
        {{ $indicators->links() }}
    </div>

</div>

@endsection
