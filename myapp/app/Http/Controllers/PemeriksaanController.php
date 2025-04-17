<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Periksa;
use App\Models\Obat;
use App\Models\DetailPeriksa;

class PemeriksaanController extends Controller
{
    public function edit($id)
    {
        $periksa = Periksa::with(['pasien', 'detail_periksa.obat'])->findOrFail($id);
        $obats = Obat::all();
        return view('dokter.form_periksa', compact('periksa', 'obats'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'catatan' => 'required|string',
            'obat_id' => 'nullable|array',
            'obat_id.*' => 'exists:obats,id',
            'total_harga' => 'required|numeric'
        ]);

        $periksa = Periksa::findOrFail($id);
        
        // Hapus detail lama
        DetailPeriksa::where('id_periksa', $periksa->id)->delete();

        // Tambahkan obat yang dipilih
        if ($request->has('obat_id') && is_array($request->obat_id)) {
            foreach ($request->obat_id as $obatId) {
                DetailPeriksa::create([
                    'id_periksa' => $periksa->id,
                    'id_obat' => $obatId,
                ]);
            }
        }

        // Update data pemeriksaan
        $periksa->update([
            'catatan' => $request->catatan,
            'biaya_pemeriksaan' => $request->total_harga,
        ]);

        return redirect()->route('dokter.memeriksa')->with('success', 'Pemeriksaan berhasil disimpan.');
    }
}