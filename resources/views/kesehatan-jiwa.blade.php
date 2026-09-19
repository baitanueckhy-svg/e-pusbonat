@extends('layouts.app')

@section('page-title', 'Kesehatan Jiwa')

@section('content')

<div class="space-y-6">

    <div>
        <p class="text-sm font-semibold text-teal-500">
            E-KESWA
        </p>

        <h2 class="text-3xl font-black text-slate-900 mt-1">
            Kesehatan Jiwa
        </h2>

        <p class="text-slate-500 mt-2">
            Pengelolaan data pelayanan kesehatan jiwa Puskesmas Naibonat.
        </p>
    </div>

    <div class="soft-card rounded-3xl p-8">

        <div class="w-14 h-14 rounded-2xl teal-icon
                    flex items-center justify-center text-2xl">
            ♥
        </div>

        <h3 class="text-xl font-bold mt-5">
            Data Kesehatan Jiwa
        </h3>

        <p class="text-slate-500 mt-2">
            Modul input, edit, filter, riwayat dan export data
            kesehatan jiwa akan terhubung langsung ke database E-KESWA.
        </p>

    </div>

</div>

@endsection
