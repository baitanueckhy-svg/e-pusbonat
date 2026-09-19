@extends('layouts.app')

@section('page-title')
SPM
@endsection

@section('content')

<div class="max-w-3xl mx-auto">

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">

        <h1 class="text-2xl font-bold text-slate-800 mb-2">
            {{ $indicator->exists ? 'Edit Data SPM' : 'Tambah Data SPM' }}
        </h1>

        <p class="text-slate-500 mb-8">
            Silakan isi dan simpan data indikator SPM.
        </p>

        <form method="POST"
              action="{{ $indicator->exists ? route('spm.update', $indicator) : route('spm.store') }}">

            @csrf

            @if($indicator->exists)
                @method('PUT')
            @endif

            <div class="space-y-5">

                <div>
                    <label class="block font-semibold mb-2">Kode Indikator</label>
                    <input
                        type="text"
                        name="kode"
                        value="{{ old('kode', $indicator->kode) }}"
                        required
                        class="w-full border border-slate-300 rounded-xl px-4 py-3">
                </div>

                <div>
                    <label class="block font-semibold mb-2">Nama Indikator</label>
                    <input
                        type="text"
                        name="nama_indikator"
                        value="{{ old('nama_indikator', $indicator->nama_indikator) }}"
                        required
                        class="w-full border border-slate-300 rounded-xl px-4 py-3">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    <div>
                        <label class="block font-semibold mb-2">Target</label>
                        <input
                            type="number"
                            name="target"
                            min="0"
                            value="{{ old('target', $indicator->target ?? 0) }}"
                            required
                            class="w-full border border-slate-300 rounded-xl px-4 py-3">
                    </div>

                    <div>
                        <label class="block font-semibold mb-2">Capaian</label>
                        <input
                            type="number"
                            name="capaian"
                            min="0"
                            value="{{ old('capaian', $indicator->capaian ?? 0) }}"
                            required
                            class="w-full border border-slate-300 rounded-xl px-4 py-3">
                    </div>

                </div>

                <div>
                    <label class="block font-semibold mb-2">Tanggal</label>
                    <input
                        type="date"
                        name="tanggal"
                        value="{{ old('tanggal', optional($indicator->tanggal)->format('Y-m-d')) }}"
                        required
                        class="w-full border border-slate-300 rounded-xl px-4 py-3">
                </div>

                <div>
                    <label class="block font-semibold mb-2">Satuan</label>
                    <input
                        type="text"
                        name="satuan"
                        value="{{ old('satuan', $indicator->satuan ?? 'Orang') }}"
                        class="w-full border border-slate-300 rounded-xl px-4 py-3">
                </div>

                <div>
                    <label class="block font-semibold mb-2">Deskripsi</label>
                    <textarea
                        name="deskripsi"
                        rows="3"
                        class="w-full border border-slate-300 rounded-xl px-4 py-3">{{ old('deskripsi', $indicator->deskripsi) }}</textarea>
                </div>

                <div>
                    <label class="block font-semibold mb-2">Keterangan</label>
                    <textarea
                        name="keterangan"
                        rows="3"
                        class="w-full border border-slate-300 rounded-xl px-4 py-3">{{ old('keterangan', $indicator->keterangan) }}</textarea>
                </div>

            </div>

            {{-- TOMBOL SAVE --}}
            <div class="mt-8 pt-6 border-t border-slate-200 flex gap-3">

                <button
                    type="submit"
                    style="background:#0f766e;color:white;padding:14px 28px;border-radius:12px;font-weight:700;border:0;cursor:pointer;"
                >
                    {{ $indicator->exists ? 'SAVE PERUBAHAN' : 'SAVE DATA' }}
                </button>

                <a
                    href="{{ route('spm.index') }}"
                    style="background:#e2e8f0;color:#334155;padding:14px 28px;border-radius:12px;font-weight:600;text-decoration:none;"
                >
                    BATAL
                </a>

            </div>

        </form>

    </div>

</div>

@endsection
