@extends('layouts.app')

@section('page-title', 'SPM')

@section('content')

<div class="space-y-6">

    <div>
        <p class="text-sm font-semibold text-teal-500">
            STANDAR PELAYANAN MINIMAL
        </p>

        <h2 class="text-3xl font-black text-slate-900 mt-1">
            Monitoring SPM
        </h2>

        <p class="text-slate-500 mt-2">
            Modul pengelolaan dan monitoring indikator SPM.
        </p>
    </div>

    <div class="soft-card rounded-3xl p-8">

        <div class="w-14 h-14 rounded-2xl teal-icon
                    flex items-center justify-center text-2xl">
            ▦
        </div>

        <h3 class="text-xl font-bold mt-5">
            Modul SPM
        </h3>

        <p class="text-slate-500 mt-2">
            Modul ini akan kita isi dengan indikator SPM,
            target, capaian, persentase, riwayat dan export Excel.
        </p>

    </div>

</div>

@endsection
