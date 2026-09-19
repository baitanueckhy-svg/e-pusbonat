<?php

namespace App\Http\Controllers;

use App\Models\KeswaEntry;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class KeswaController extends Controller
{
    public function index(Request $request)
    {
        $query = KeswaEntry::query()->orderByDesc('tanggal');

        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_sampai);
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }

        $entries = $query->paginate(15)->withQueryString();

        return view('kesehatan-jiwa.index', compact('entries'));
    }

    public function create()
    {
        return view('kesehatan-jiwa.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        KeswaEntry::create($data);

        return redirect()
            ->route('kesehatan-jiwa.index')
            ->with('success', 'Data kesehatan jiwa berhasil disimpan.');
    }

    public function edit(KeswaEntry $kesehatan_jiwa)
    {
        return view('kesehatan-jiwa.edit', [
            'entry' => $kesehatan_jiwa,
        ]);
    }

    public function update(Request $request, KeswaEntry $kesehatan_jiwa)
    {
        $data = $this->validateData($request);

        $kesehatan_jiwa->update($data);

        return redirect()
            ->route('kesehatan-jiwa.index')
            ->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(KeswaEntry $kesehatan_jiwa)
    {
        $kesehatan_jiwa->delete();

        return redirect()
            ->route('kesehatan-jiwa.index')
            ->with('success', 'Data berhasil dihapus.');
    }

    public function export(Request $request): StreamedResponse
    {
        $query = KeswaEntry::query()->orderBy('tanggal');

        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_sampai);
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }

        $entries = $query->get();

        $filename = 'E-KESWA-' . now()->format('Ymd-His') . '.csv';

        return response()->streamDownload(function () use ($entries) {

            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'Tanggal',
                'Total ODGJ Berat',
                'SPM Sasaran',
                'SPM Capaian',
                'F23',
                'F20',
                'Manusak',
                'Oelatimo',
                'Pukdale',
                'Nunkurus',
                'Naibonat',
                'Obat Sasaran',
                'Obat Rutin',
                'Obat Tidak Rutin',
                'Obat Putus',
                'ODGJB Baru',
                'Pelacakan Sasaran',
                'Pelacakan Capaian',
                'P3LP Sasaran',
                'Skrining Sasaran',
                'Skrining Capaian',
                'Kendala',
                'Solusi',
                'Rencana Tindak Lanjut',
            ], ';');

            foreach ($entries as $entry) {
                fputcsv($handle, [
                    $entry->tanggal?->format('Y-m-d'),
                    $entry->total_odgj_berat,
                    $entry->spm_sasaran,
                    $entry->spm_capaian,
                    $entry->f23,
                    $entry->f20,
                    $entry->manusak,
                    $entry->oelatimo,
                    $entry->pukdale,
                    $entry->nunkurus,
                    $entry->naibonat,
                    $entry->obat_sasaran,
                    $entry->obat_rutin,
                    $entry->obat_tidak_rutin,
                    $entry->obat_putus,
                    $entry->odgjb_baru,
                    $entry->pelacakan_sasaran,
                    $entry->pelacakan_capaian,
                    $entry->p3lp_sasaran,
                    $entry->skrining_sasaran,
                    $entry->skrining_capaian,
                    $entry->kendala,
                    $entry->solusi,
                    $entry->rencana_tindak_lanjut,
                ], ';');
            }

            fclose($handle);

        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'tanggal' => ['required', 'date'],

            'total_odgj_berat' => ['required', 'integer', 'min:0'],
            'spm_sasaran' => ['required', 'integer', 'min:0'],
            'spm_capaian' => ['required', 'integer', 'min:0'],

            'f23' => ['required', 'integer', 'min:0'],
            'f20' => ['required', 'integer', 'min:0'],

            'manusak' => ['required', 'integer', 'min:0'],
            'oelatimo' => ['required', 'integer', 'min:0'],
            'pukdale' => ['required', 'integer', 'min:0'],
            'nunkurus' => ['required', 'integer', 'min:0'],
            'naibonat' => ['required', 'integer', 'min:0'],

            'obat_sasaran' => ['required', 'integer', 'min:0'],
            'obat_rutin' => ['required', 'integer', 'min:0'],
            'obat_tidak_rutin' => ['required', 'integer', 'min:0'],
            'obat_putus' => ['required', 'integer', 'min:0'],

            'odgjb_baru' => ['required', 'integer', 'min:0'],

            'pelacakan_sasaran' => ['required', 'integer', 'min:0'],
            'pelacakan_capaian' => ['required', 'integer', 'min:0'],

            'p3lp_sasaran' => ['required', 'integer', 'min:0'],

            'skrining_sasaran' => ['required', 'integer', 'min:0'],
            'skrining_capaian' => ['required', 'integer', 'min:0'],

            'kendala' => ['nullable', 'string'],
            'solusi' => ['nullable', 'string'],
            'rencana_tindak_lanjut' => ['nullable', 'string'],
        ]);
    }
}
