<?php

namespace App\Http\Controllers;

use App\Models\Periksa;
use App\Models\Obat;
use App\Models\DetailPeriksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PemeriksaanController extends Controller
{
    /**
     * Menampilkan form edit pemeriksaan untuk dokter.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $periksa = Periksa::with(['pasien', 'dokter', 'detail_periksa.obat'])
            ->where('id_dokter', Auth::id())
            ->findOrFail($id);
        $obats = Obat::all();

        return view('dokter.form_periksa', compact('periksa', 'obats'));
    }

    /**
     * Memperbarui data pemeriksaan dan obat yang dipilih.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'catatan' => 'required|string|max:1000',
            'obat_id' => 'nullable|array',
            'obat_id.*' => 'exists:obats,id',
            'total_harga' => 'required|numeric|min:0',
        ], [
            'catatan.required' => 'Catatan wajib diisi.',
            'catatan.string' => 'Catatan harus berupa teks.',
            'catatan.max' => 'Catatan maksimal 1000 karakter.',
            'obat_id.array' => 'Obat tidak valid.',
            'obat_id.*.exists' => 'Obat yang dipilih tidak valid.',
            'total_harga.required' => 'Total harga wajib diisi.',
            'total_harga.numeric' => 'Total harga harus berupa angka.',
            'total_harga.min' => 'Total harga tidak boleh negatif.',
        ]);

        $periksa = Periksa::where('id_dokter', Auth::id())->findOrFail($id);

        // Hapus detail periksa lama
        $periksa->detail_periksa()->delete();

        // Tambahkan obat baru jika ada
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

        return redirect()->route('dokter.memeriksa')
            ->with('success', 'Pemeriksaan berhasil disimpan.');
    }
}