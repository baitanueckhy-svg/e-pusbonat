@csrf

<div class="space-y-8">

    <div>
        <label class="font-bold text-slate-700">Tanggal</label>

        <input type="date"
               name="tanggal"
               value="{{ old('tanggal', isset($entry) ? $entry->tanggal?->format('Y-m-d') : now()->format('Y-m-d')) }}"
               required
               class="mt-2 w-full rounded-xl border-slate-200">

        @error('tanggal')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>


    <div>
        <h3 class="text-lg font-black text-teal-700">
            01. Data Utama
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">

            @foreach([
                'total_odgj_berat' => 'Total ODGJ Berat',
                'spm_sasaran' => 'SPM Sasaran',
                'spm_capaian' => 'SPM Capaian',
                'f20' => 'F20',
                'f23' => 'F23',
                'odgjb_baru' => 'ODGJB Baru',
            ] as $field => $label)

                <div>
                    <label class="text-sm font-semibold text-slate-600">
                        {{ $label }}
                    </label>

                    <input type="number"
                           min="0"
                           name="{{ $field }}"
                           value="{{ old($field, $entry->$field ?? 0) }}"
                           required
                           class="mt-2 w-full rounded-xl border-slate-200">

                </div>

            @endforeach

        </div>
    </div>


    <div>
        <h3 class="text-lg font-black text-teal-700">
            02. Sebaran Wilayah
        </h3>

        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mt-4">

            @foreach([
                'manusak' => 'Manusak',
                'oelatimo' => 'Oelatimo',
                'pukdale' => 'Pukdale',
                'nunkurus' => 'Nunkurus',
                'naibonat' => 'Naibonat',
            ] as $field => $label)

                <div>
                    <label class="text-sm font-semibold text-slate-600">
                        {{ $label }}
                    </label>

                    <input type="number"
                           min="0"
                           name="{{ $field }}"
                           value="{{ old($field, $entry->$field ?? 0) }}"
                           required
                           class="mt-2 w-full rounded-xl border-slate-200">
                </div>

            @endforeach

        </div>
    </div>


    <div>
        <h3 class="text-lg font-black text-teal-700">
            03. Monitoring Obat
        </h3>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">

            @foreach([
                'obat_sasaran' => 'Sasaran',
                'obat_rutin' => 'Rutin',
                'obat_tidak_rutin' => 'Tidak Rutin',
                'obat_putus' => 'Putus',
            ] as $field => $label)

                <div>
                    <label class="text-sm font-semibold text-slate-600">
                        {{ $label }}
                    </label>

                    <input type="number"
                           min="0"
                           name="{{ $field }}"
                           value="{{ old($field, $entry->$field ?? 0) }}"
                           required
                           class="mt-2 w-full rounded-xl border-slate-200">
                </div>

            @endforeach

        </div>
    </div>


    <div>
        <h3 class="text-lg font-black text-teal-700">
            04. Pelacakan, P3LP & Skrining
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">

            @foreach([
                'pelacakan_sasaran' => 'Pelacakan Sasaran',
                'pelacakan_capaian' => 'Pelacakan Capaian',
                'p3lp_sasaran' => 'P3LP Sasaran',
                'skrining_sasaran' => 'Skrining Sasaran',
                'skrining_capaian' => 'Skrining Capaian',
            ] as $field => $label)

                <div>
                    <label class="text-sm font-semibold text-slate-600">
                        {{ $label }}
                    </label>

                    <input type="number"
                           min="0"
                           name="{{ $field }}"
                           value="{{ old($field, $entry->$field ?? 0) }}"
                           required
                           class="mt-2 w-full rounded-xl border-slate-200">
                </div>

            @endforeach

        </div>
    </div>


    <div>
        <h3 class="text-lg font-black text-teal-700">
            05. Kendala & RTL
        </h3>

        <div class="grid grid-cols-1 gap-4 mt-4">

            <textarea name="kendala"
                      rows="3"
                      placeholder="Kendala"
                      class="w-full rounded-xl border-slate-200">{{ old('kendala', $entry->kendala ?? '') }}</textarea>

            <textarea name="solusi"
                      rows="3"
                      placeholder="Solusi"
                      class="w-full rounded-xl border-slate-200">{{ old('solusi', $entry->solusi ?? '') }}</textarea>

            <textarea name="rencana_tindak_lanjut"
                      rows="3"
                      placeholder="Rencana Tindak Lanjut"
                      class="w-full rounded-xl border-slate-200">{{ old('rencana_tindak_lanjut', $entry->rencana_tindak_lanjut ?? '') }}</textarea>

        </div>
    </div>

</div>
