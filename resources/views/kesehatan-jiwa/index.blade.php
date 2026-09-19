@extends('layouts.app')

@section('page-title', 'Kesehatan Jiwa')

@section('content')

<div class="space-y-6">

    <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">

        <div>
            <p class="text-sm font-bold tracking-widest text-teal-500 uppercase">
                E-KESWA
            </p>

            <h2 class="text-3xl font-black text-slate-900 mt-1">
                Data Kesehatan Jiwa
            </h2>

            <p class="text-slate-500 mt-2">
                Kelola data pelayanan kesehatan jiwa Puskesmas Naibonat.
            </p>
        </div>

        <div class="flex flex-wrap gap-3">

            <a href="{{ route('kesehatan-jiwa.create') }}"
               class="rounded-2xl bg-teal-500 px-5 py-3 text-sm
                      font-bold text-white shadow-lg shadow-teal-500/20
                      hover:bg-teal-600 transition">
                + Tambah Data
            </a>

            <a href="{{ route('kesehatan-jiwa.export', request()->query()) }}"
               class="rounded-2xl border border-teal-200 bg-teal-50
                      px-5 py-3 text-sm font-bold text-teal-700
                      hover:bg-teal-100 transition">
                Export Excel
            </a>

        </div>

    </div>


    @if(session('success'))
        <div class="rounded-2xl border border-emerald-200
                    bg-emerald-50 px-5 py-4 text-sm
                    font-medium text-emerald-700">
            {{ session('success') }}
        </div>
    @endif


    <!-- FILTER -->
    <div class="soft-card rounded-3xl p-6">

        <form method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">

            <div>
                <label class="text-sm font-semibold text-slate-600">
                    Dari tanggal
                </label>

                <input type="date"
                       name="tanggal_dari"
                       value="{{ request('tanggal_dari') }}"
                       class="mt-2 w-full rounded-xl border-slate-200">
            </div>

            <div>
                <label class="text-sm font-semibold text-slate-600">
                    Sampai tanggal
                </label>

                <input type="date"
                       name="tanggal_sampai"
                       value="{{ request('tanggal_sampai') }}"
                       class="mt-2 w-full rounded-xl border-slate-200">
            </div>

            <div>
                <label class="text-sm font-semibold text-slate-600">
                    Bulan
                </label>

                <select name="bulan"
                        class="mt-2 w-full rounded-xl border-slate-200">

                    <option value="">Semua bulan</option>

                    @foreach(range(1,12) as $bulan)
                        <option value="{{ $bulan }}"
                            @selected(request('bulan') == $bulan)>
                            {{ \Carbon\Carbon::create(null,$bulan,1)->translatedFormat('F') }}
                        </option>
                    @endforeach

                </select>
            </div>

            <div>
                <label class="text-sm font-semibold text-slate-600">
                    Tahun
                </label>

                <input type="number"
                       name="tahun"
                       value="{{ request('tahun', now()->year) }}"
                       class="mt-2 w-full rounded-xl border-slate-200">
            </div>

            <div class="flex items-end gap-2">

                <button class="flex-1 rounded-xl bg-teal-500
                               px-4 py-2.5 text-sm font-bold text-white">
                    Filter
                </button>

                <a href="{{ route('kesehatan-jiwa.index') }}"
                   class="rounded-xl bg-slate-100 px-4 py-2.5
                          text-sm font-semibold text-slate-600">
                    Reset
                </a>

            </div>

        </form>

    </div>


    <!-- TABLE -->
    <div class="soft-card rounded-3xl overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="bg-teal-50 border-b border-teal-100">

                    <tr class="text-left text-teal-800">

                        <th class="px-5 py-4">Tanggal</th>
                        <th class="px-5 py-4">ODGJ Berat</th>
                        <th class="px-5 py-4">SPM</th>
                        <th class="px-5 py-4">F20</th>
                        <th class="px-5 py-4">F23</th>
                        <th class="px-5 py-4">Obat</th>
                        <th class="px-5 py-4 text-right">Aksi</th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse($entries as $entry)

                        <tr class="hover:bg-teal-50/40 transition">

                            <td class="px-5 py-4 font-medium">
                                {{ $entry->tanggal->format('d/m/Y') }}
                            </td>

                            <td class="px-5 py-4 font-bold text-teal-600">
                                {{ $entry->total_odgj_berat }}
                            </td>

                            <td class="px-5 py-4">
                                {{ $entry->spm_capaian }} /
                                {{ $entry->spm_sasaran }}
                            </td>

                            <td class="px-5 py-4">
                                {{ $entry->f20 }}
                            </td>

                            <td class="px-5 py-4">
                                {{ $entry->f23 }}
                            </td>

                            <td class="px-5 py-4">
                                {{ $entry->obat_rutin }} rutin
                            </td>

                            <td class="px-5 py-4">

                                <div class="flex justify-end gap-2">

                                    <a href="{{ route('kesehatan-jiwa.edit', $entry) }}"
                                       class="rounded-lg bg-teal-50 px-3 py-2
                                              text-xs font-bold text-teal-700">
                                        Edit
                                    </a>

                                    <form method="POST"
                                          action="{{ route('kesehatan-jiwa.destroy', $entry) }}"
                                          onsubmit="return confirm('Hapus data ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            class="rounded-lg bg-red-50 px-3 py-2
                                                   text-xs font-bold text-red-600">
                                            Hapus
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="7"
                                class="px-5 py-16 text-center text-slate-400">
                                Belum ada data kesehatan jiwa.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="p-5 border-t border-slate-100">
            {{ $entries->links() }}
        </div>

    </div>

</div>

@endsection
