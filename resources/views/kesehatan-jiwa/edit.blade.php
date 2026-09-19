@extends('layouts.app')

@section('page-title', 'Edit Data Kesehatan Jiwa')

@section('content')

<div class="max-w-6xl mx-auto">

    <div class="mb-6">

        <a href="{{ route('kesehatan-jiwa.index') }}"
           class="text-sm font-semibold text-teal-600">
            ← Kembali ke Data
        </a>

        <h2 class="text-3xl font-black text-slate-900 mt-3">
            Edit Data Kesehatan Jiwa
        </h2>

        <p class="text-slate-500 mt-1">
            Perbarui data pelayanan yang sudah tersimpan.
        </p>

    </div>

    <div class="soft-card rounded-3xl p-7">

        <form method="POST"
              action="{{ route('kesehatan-jiwa.update', $entry) }}">

            @method('PUT')

            @include('kesehatan-jiwa.form')

            <div class="mt-8 flex justify-end">

                <button type="submit"
                        class="rounded-2xl bg-teal-500 px-7 py-3
                               font-bold text-white
                               shadow-lg shadow-teal-500/20
                               hover:bg-teal-600">
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

</div>

@endsection
