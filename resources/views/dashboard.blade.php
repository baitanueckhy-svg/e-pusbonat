@extends('layouts.app')

@section('content')

@php
    $maxChart = max(
        1,
        $indicators->max(function ($item) {
            return max($item->target, $item->capaian);
        })
    );
@endphp

<style>
    .dash-header {
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:20px;
    }

    .dash-title-wrap {
        display:flex;
        align-items:center;
        gap:15px;
    }

    .dash-icon {
        width:54px;
        height:54px;
        border-radius:13px;
        background:#e8f9f7;
        color:#079f96;
        display:flex;
        align-items:center;
        justify-content:center;
    }

    .dash-title {
        font-size:29px;
        font-weight:800;
        color:#0d2142;
        line-height:1.1;
    }

    .dash-subtitle {
        color:#7085a0;
        font-size:14px;
        margin-top:5px;
    }

    .live-badge {
        display:flex;
        align-items:center;
        gap:7px;
        padding:9px 13px;
        border-radius:9px;
        background:#e1f7ef;
        color:#07955d;
        font-size:12px;
        font-weight:700;
    }

    .live-dot {
        width:8px;
        height:8px;
        border-radius:50%;
        background:#08ad75;
        box-shadow:0 0 0 4px rgba(8,173,117,.12);
    }

    .dash-kpis {
        display:grid;
        grid-template-columns:repeat(4,1fr);
        gap:13px;
        margin-top:20px;
    }

    .dash-kpi {
        background:white;
        border:1px solid #e6edf2;
        border-radius:13px;
        padding:17px;
        display:flex;
        align-items:center;
        gap:14px;
        box-shadow:0 5px 20px rgba(15,23,42,.04);
    }

    .dash-kpi-icon {
        width:48px;
        height:48px;
        min-width:48px;
        border-radius:12px;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:23px;
        font-weight:800;
    }

    .dash-kpi-number {
        color:#102a43;
        font-size:25px;
        font-weight:800;
        line-height:1;
    }

    .dash-kpi-label {
        color:#506a84;
        font-size:12px;
        margin-top:5px;
    }

    .dashboard-grid {
        display:grid;
        grid-template-columns:minmax(0, 2fr) minmax(280px, 1fr);
        gap:15px;
        margin-top:15px;
    }

    .dash-card {
        background:white;
        border:1px solid #e6edf2;
        border-radius:13px;
        box-shadow:0 5px 20px rgba(15,23,42,.04);
        padding:19px;
    }

    .dash-card-title {
        color:#102a43;
        font-size:16px;
        font-weight:800;
    }

    .dash-card-subtitle {
        color:#8497ab;
        font-size:12px;
        margin-top:3px;
    }

    .legend {
        display:flex;
        gap:17px;
        font-size:11px;
        color:#627990;
    }

    .legend-item {
        display:flex;
        align-items:center;
        gap:5px;
    }

    .legend-dot {
        width:9px;
        height:9px;
        border-radius:3px;
    }

    .chart {
        height:350px;
        margin-top:20px;
        display:flex;
        align-items:flex-end;
        gap:10px;
        padding:10px 4px 30px;
        border-bottom:1px solid #e4ebf0;
        position:relative;
    }

    .chart-column {
        flex:1;
        height:100%;
        display:flex;
        align-items:flex-end;
        justify-content:center;
        position:relative;
    }

    .bars {
        height:100%;
        width:100%;
        display:flex;
        align-items:flex-end;
        justify-content:center;
        gap:4px;
    }

    .bar {
        width:calc(50% - 3px);
        max-width:27px;
        min-height:2px;
        border-radius:5px 5px 0 0;
        transition:.2s ease;
        position:relative;
    }

    .bar:hover {
        opacity:.78;
        transform:translateY(-2px);
    }

    .bar-target {
        background:#a8deda;
    }

    .bar-capaian {
        background:#079f96;
    }

    .chart-label {
        position:absolute;
        bottom:-27px;
        font-size:10px;
        color:#71859a;
        white-space:nowrap;
    }

    .chart-empty {
        height:300px;
        display:flex;
        align-items:center;
        justify-content:center;
        color:#8798ab;
        font-size:13px;
    }

    .progress-list {
        margin-top:18px;
        display:flex;
        flex-direction:column;
        gap:14px;
    }

    .progress-item-head {
        display:flex;
        justify-content:space-between;
        gap:10px;
        font-size:12px;
        margin-bottom:6px;
    }

    .progress-name {
        color:#344e68;
        font-weight:600;
        white-space:nowrap;
        overflow:hidden;
        text-overflow:ellipsis;
    }

    .progress-value {
        font-weight:800;
        color:#079f96;
    }

    .progress-bg {
        height:8px;
        background:#edf2f5;
        border-radius:99px;
        overflow:hidden;
    }

    .progress-fill {
        height:100%;
        border-radius:99px;
        background:#079f96;
    }

    .dashboard-table {
        margin-top:15px;
        width:100%;
        border-collapse:collapse;
    }

    .dashboard-table th {
        text-align:left;
        color:#8294a8;
        font-size:10px;
        text-transform:uppercase;
        letter-spacing:.5px;
        padding:10px;
        border-bottom:1px solid #edf1f4;
    }

    .dashboard-table td {
        padding:11px 10px;
        color:#344e68;
        font-size:12px;
        border-bottom:1px solid #f0f3f5;
    }

    .status-small {
        padding:5px 8px;
        border-radius:7px;
        font-size:10px;
        font-weight:700;
    }

    @media(max-width:1100px) {
        .dash-kpis {
            grid-template-columns:repeat(2,1fr);
        }

        .dashboard-grid {
            grid-template-columns:1fr;
        }
    }

    @media(max-width:650px) {
        .dash-header {
            flex-direction:column;
            align-items:flex-start;
        }

        .dash-kpis {
            grid-template-columns:1fr;
        }

        .chart {
            gap:4px;
        }

        .bar {
            width:45%;
        }
    }
</style>

<div>

    {{-- HEADER --}}
    <div class="dash-header">

        <div class="dash-title-wrap">

            <div class="dash-icon">
                <svg width="30" height="30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="2.5" stroke-linecap="round"
                          d="M4 19V10M10 19V6M16 19V3M22 19V12"/>
                </svg>
            </div>

            <div>
                <div class="dash-title">
                    Dashboard
                </div>

                <div class="dash-subtitle">
                    Monitoring capaian SPM Puskesmas Naibonat
                </div>
            </div>

        </div>

        <div class="live-badge">
            <span class="live-dot"></span>
            Data Live dari SPM
        </div>

    </div>

    {{-- KPI --}}
    <div class="dash-kpis">

        <div class="dash-kpi">
            <div class="dash-kpi-icon"
                 style="background:#dff1ff;color:#1788e8;">
                ▤
            </div>

            <div>
                <div class="dash-kpi-number">
                    {{ $totalIndikator }}
                </div>
                <div class="dash-kpi-label">
                    Total Indikator SPM
                </div>
            </div>
        </div>

        <div class="dash-kpi">
            <div class="dash-kpi-icon"
                 style="background:#e2f8ee;color:#10a563;">
                ◎
            </div>

            <div>
                <div class="dash-kpi-number">
                    {{ number_format($totalSasaran) }}
                </div>
                <div class="dash-kpi-label">
                    Total Sasaran
                </div>
            </div>
        </div>

        <div class="dash-kpi">
            <div class="dash-kpi-icon"
                 style="background:#e1f8f5;color:#079f96;">
                ✓
            </div>

            <div>
                <div class="dash-kpi-number">
                    {{ number_format($totalCapaian) }}
                </div>
                <div class="dash-kpi-label">
                    Total Capaian
                </div>
            </div>
        </div>

        <div class="dash-kpi">
            <div class="dash-kpi-icon"
                 style="background:#fff0d4;color:#e89900;">
                %
            </div>

            <div>
                <div class="dash-kpi-number">
                    {{ number_format($rataRata, 1) }}%
                </div>
                <div class="dash-kpi-label">
                    Rata-rata Capaian
                </div>
            </div>
        </div>

    </div>

    {{-- CHART + SUMMARY --}}
    <div class="dashboard-grid">

        {{-- BAR CHART --}}
        <div class="dash-card">

            <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:15px;">

                <div>
                    <div class="dash-card-title">
                        Grafik Sasaran & Capaian SPM
                    </div>

                    <div class="dash-card-subtitle">
                        Perbandingan data berdasarkan indikator SPM
                    </div>
                </div>

                <div class="legend">

                    <div class="legend-item">
                        <span class="legend-dot" style="background:#a8deda;"></span>
                        Sasaran
                    </div>

                    <div class="legend-item">
                        <span class="legend-dot" style="background:#079f96;"></span>
                        Capaian
                    </div>

                </div>

            </div>

            @if($indicators->count())

                <div class="chart">

                    @foreach($indicators as $indicator)

                        @php
                            $targetHeight = $indicator->target > 0
                                ? max(2, ($indicator->target / $maxChart) * 100)
                                : 2;

                            $capaianHeight = $indicator->capaian > 0
                                ? max(2, ($indicator->capaian / $maxChart) * 100)
                                : 2;
                        @endphp

                        <div class="chart-column">

                            <div class="bars">

                                <div class="bar bar-target"
                                     style="height:{{ $targetHeight }}%;"
                                     title="Sasaran {{ number_format($indicator->target) }}">
                                </div>

                                <div class="bar bar-capaian"
                                     style="height:{{ $capaianHeight }}%;"
                                     title="Capaian {{ number_format($indicator->capaian) }}">
                                </div>

                            </div>

                            <div class="chart-label">
                                {{ $indicator->kode }}
                            </div>

                        </div>

                    @endforeach

                </div>

            @else

                <div class="chart-empty">
                    Belum ada data SPM untuk ditampilkan.
                </div>

            @endif

        </div>

        {{-- SUMMARY --}}
        <div class="dash-card">

            <div class="dash-card-title">
                Ringkasan Capaian
            </div>

            <div class="dash-card-subtitle">
                Status seluruh indikator
            </div>

            <div style="margin-top:20px;display:flex;align-items:center;justify-content:center;">

                <div style="
                    width:155px;
                    height:155px;
                    border-radius:50%;
                    display:flex;
                    align-items:center;
                    justify-content:center;
                    background:conic-gradient(#079f96 {{ $rataRata }}%, #e7eef1 0);
                    position:relative;
                ">

                    <div style="
                        width:121px;
                        height:121px;
                        border-radius:50%;
                        background:white;
                        display:flex;
                        flex-direction:column;
                        align-items:center;
                        justify-content:center;
                    ">

                        <div style="font-size:27px;font-weight:800;color:#102a43;">
                            {{ number_format($rataRata,1) }}%
                        </div>

                        <div style="font-size:11px;color:#8193a6;">
                            rata-rata
                        </div>

                    </div>

                </div>

            </div>

            <div class="progress-list">

                <div>
                    <div class="progress-item-head">
                        <span class="progress-name">Indikator ≥ 80%</span>
                        <span class="progress-value">{{ $indikatorBaik }}</span>
                    </div>

                    <div class="progress-bg">
                        <div class="progress-fill"
                             style="width:{{ $totalIndikator ? ($indikatorBaik / $totalIndikator * 100) : 0 }}%">
                        </div>
                    </div>
                </div>

                <div>
                    <div class="progress-item-head">
                        <span class="progress-name">Perlu perhatian</span>
                        <span style="color:#e74c55;font-weight:800;">
                            {{ $indikatorPerhatian }}
                        </span>
                    </div>

                    <div class="progress-bg">
                        <div class="progress-fill"
                             style="background:#e74c55;width:{{ $totalIndikator ? ($indikatorPerhatian / $totalIndikator * 100) : 0 }}%">
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    {{-- DETAIL TABLE --}}
    <div class="dash-card" style="margin-top:15px;">

        <div style="display:flex;justify-content:space-between;align-items:center;gap:15px;">

            <div>
                <div class="dash-card-title">
                    Monitoring Indikator SPM
                </div>

                <div class="dash-card-subtitle">
                    Data terbaru dari modul SPM
                </div>
            </div>

            <a href="{{ route('spm.index') }}"
               style="font-size:12px;color:#079f96;font-weight:700;text-decoration:none;">
                Kelola SPM →
            </a>

        </div>

        <div style="overflow-x:auto;">

            <table class="dashboard-table">

                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Indikator</th>
                        <th>Sasaran</th>
                        <th>Capaian</th>
                        <th>Persentase</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($indicators as $indicator)

                        @php
                            $percentage = $indicator->target > 0
                                ? round(($indicator->capaian / $indicator->target) * 100, 1)
                                : 0;

                            if ($percentage >= 80) {
                                $status = 'Baik';
                                $statusColor = '#07955d';
                                $statusBg = '#e1f7ef';
                            } elseif ($percentage >= 50) {
                                $status = 'Cukup';
                                $statusColor = '#d58d00';
                                $statusBg = '#fff3d4';
                            } else {
                                $status = 'Perlu Perhatian';
                                $statusColor = '#d9424d';
                                $statusBg = '#ffe7e7';
                            }
                        @endphp

                        <tr>

                            <td style="font-weight:800;color:#087f78;">
                                {{ $indicator->kode }}
                            </td>

                            <td style="font-weight:600;color:#243b53;">
                                {{ $indicator->nama_indikator }}
                            </td>

                            <td>
                                {{ number_format($indicator->target) }}
                            </td>

                            <td style="font-weight:700;color:#087f78;">
                                {{ number_format($indicator->capaian) }}
                            </td>

                            <td style="font-weight:800;color:{{ $statusColor }};">
                                {{ number_format($percentage,1) }}%
                            </td>

                            <td>
                                <span class="status-small"
                                      style="background:{{ $statusBg }};color:{{ $statusColor }};">
                                    {{ $status }}
                                </span>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" style="text-align:center;padding:35px;color:#8798ab;">
                                Belum ada data SPM.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection
