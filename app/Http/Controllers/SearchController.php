<?php

namespace App\Http\Controllers;

use App\Models\SpmIndicator;
use App\Models\KeswaEntry;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $q = trim($request->q ?? '');

        $spm = SpmIndicator::when($q, function ($query) use ($q) {
            $query->where('kode', 'like', "%$q%")
                  ->orWhere('nama_indikator', 'like', "%$q%");
        })->get();

        $keswa = KeswaEntry::when($q, function ($query) use ($q) {
            $query->where('tanggal', 'like', "%$q%")
                  ->orWhere('kendala', 'like', "%$q%")
                  ->orWhere('solusi', 'like', "%$q%");
        })->get();

        return view('search.index', compact('q', 'spm', 'keswa'));
    }
}
