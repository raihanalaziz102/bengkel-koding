<?php

namespace App\Http\Controllers;

use App\Models\Periksa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeriksaController extends Controller
{
    /**
     * Menampilkan form buat janji periksa dan riwayat periksa pasien.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $dokters = User::where('role', 'dokter')->get();
        $riwayat = Periksa::with('dokter')
            ->where('id_pasien', Auth::id())
            ->orderBy('tgl_periksa', 'desc')
            ->get();

        return view('pasien.periksa', compact('dokters', 'riwayat'));
    }

    /**
     * Menyimpan janji periksa baru.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_dokter' => 'required|exists:users,id,role,dokter',
            'tgl_periksa' => 'required|date|after_or_equal:today',
        ], [
            'id_dokter.required' => 'Dokter wajib dipilih.',
            'id_dokter.exists' => 'Dokter tidak valid.',
            'tgl_periksa.required' => 'Tanggal periksa wajib diisi.',
            'tgl_periksa.date' => 'Tanggal periksa tidak valid.',
            'tgl_periksa.after_or_equal' => 'Tanggal periksa harus hari ini atau setelahnya.',
        ]);

        Periksa::create([
            'id_dokter' => $request->id_dokter,
            'id_pasien' => Auth::id(),
            'tgl_periksa' => $request->tgl_periksa,
            'catatan' => '',
            'biaya_pemeriksaan' => 0,
        ]);

        return redirect()->route('pasien.periksa.create')
            ->with('success', 'Janji periksa berhasil dibuat.');
    }

    /**
     * Menampilkan daftar pasien yang akan diperiksa oleh dokter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $query = Periksa::with(['pasien', 'dokter'])
            ->where('id_dokter', Auth::id())
            ->orderBy('tgl_periksa', 'asc');

        if ($search) {
            $query->whereHas('pasien', function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%');
            });
        }

        $periksas = $query->get();

        return view('dokter.memeriksa', compact('periksas'));
    }
}