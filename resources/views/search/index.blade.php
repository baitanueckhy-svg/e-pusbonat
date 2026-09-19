@extends('layouts.app')

@section('content')

<div class="p-8">

    <h1 class="text-3xl font-black text-slate-900 mb-2">
        Hasil Pencarian
    </h1>

    <p class="text-slate-500 mb-6">
        Pencarian untuk: <b>{{ $q }}</b>
    </p>

    @forelse($spm as $item)

        <a href="{{ route('spm.edit', $item->id) }}"
           class="block bg-white p-5 rounded-xl mb-3
                  hover:bg-teal-50 border">

            <b class="text-teal-700">{{ $item->kode }}</b>
            — {{ $item->nama_indikator }}

        </a>

    @empty

        @if($keswa->isEmpty())

            <div class="bg-white p-6 rounded-xl border">
                Data tidak ditemukan.
            </div>

        @endif

    @endforelse

    @foreach($keswa as $item)

        <a href="{{ route('kesehatan-jiwa.edit', $item->id) }}"
           class="block bg-white p-5 rounded-xl mb-3
                  hover:bg-teal-50 border">

            <b>Kesehatan Jiwa</b>
            — {{ $item->tanggal }}

        </a>

    @endforeach

</div>

@endsection
