<?php

namespace App\Http\Controllers;

use App\Models\SpmIndicator;
use Illuminate\Http\Request;

class SpmController extends Controller
{
    public function index(Request $request)
    {
        $query = SpmIndicator::query();

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        $indicators = $query
            ->orderBy('kode')
            ->orderByDesc('tanggal')
            ->paginate(12)
            ->withQueryString();

        return view('spm.index', compact('indicators'));
    }

    public function create()
    {
        return view('spm.form', [
            'indicator' => new SpmIndicator([
                'tanggal' => now()->toDateString(),
                'target' => 0,
                'capaian' => 0,
                'satuan' => 'Orang',
            ]),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        SpmIndicator::create($data);

        return redirect()
            ->route('spm.index')
            ->with('success', 'Data indikator SPM berhasil disimpan.');
    }

    public function edit(SpmIndicator $spm)
    {
        return view('spm.form', [
            'indicator' => $spm,
        ]);
    }

    public function update(Request $request, SpmIndicator $spm)
    {
        $data = $this->validateData($request);

        $spm->update($data);

        return redirect()
            ->route('spm.index')
            ->with('success', 'Perubahan indikator SPM berhasil disimpan.');
    }

    public function destroy(SpmIndicator $spm)
    {
        $spm->delete();

        return redirect()
            ->route('spm.index')
            ->with('success', 'Data indikator SPM berhasil dihapus.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'kode' => ['required', 'string', 'max:20'],
            'nama_indikator' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'satuan' => ['nullable', 'string', 'max:100'],
            'target' => ['required', 'integer', 'min:0'],
            'capaian' => ['required', 'integer', 'min:0'],
            'tanggal' => ['required', 'date'],
            'keterangan' => ['nullable', 'string'],
        ]);
    }
}
