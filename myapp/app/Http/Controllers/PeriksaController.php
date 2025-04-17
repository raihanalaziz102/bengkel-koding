<?php

namespace App\Http\Controllers;

use App\Models\Periksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class PeriksaController extends Controller
{
    // Form + Riwayat di halaman pasien/periksa
    public function create()
{
    $dokters = User::where('role', 'dokter')->get();
    $riwayat = Periksa::where('id_pasien', 3)->get(); // GANTI Auth::id() ke 3

    return view('pasien.periksa', compact('dokters', 'riwayat'));
}


    // Simpan janji periksa
    public function store(Request $request)
    {
        $request->validate([
            'id_dokter' => 'required|exists:users,id',
        ]);

        Periksa::create([
            'id_dokter' => $request->id_dokter,
            'id_pasien' => 3,
            'tgl_periksa' => now(),
            'catatan' => '',
            'biaya_pemeriksaan' => 0,
        ]);

        return redirect()->route('pasien.periksa.create')->with('success', 'Janji periksa berhasil dibuat.');
    }

    // Dokter lihat daftar pasien yang akan diperiksa
    public function index()
    {
        $periksas = Periksa::with('pasien')->get();
        return view('dokter.memeriksa', compact('periksas'));
    }
}
