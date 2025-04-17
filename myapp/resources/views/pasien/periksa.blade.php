@extends('layout.app')

@section('title', 'Buat Janji Periksa')

@section('content')
<div class="container mt-4">
    <h3>Buat Janji Periksa</h3>

    {{-- Form Buat Janji --}}
    <div class="card mt-3">
        <div class="card-header bg-primary text-white">Form Buat Janji</div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('pasien.periksa.store') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="id_d Paulaokter">Pilih Dokter</label>
                    <select name="id_dokter" id="id_dokter" class="form-control @error('id_dokter') is-invalid @enderror" required>
                        <option value="">-- Pilih Dokter --</option>
                        @foreach ($dokters as $dokter)
                            <option value="{{ $dokter->id }}" {{ old('id_dokter') == $dokter->id ? 'selected' : '' }}>{{ $dokter->nama }}</option>
                        @endforeach
                    </select>
                    @error('id_dokter')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="tgl_periksa">Tanggal Periksa</label>
                    <input type="datetime-local" name="tgl_periksa" id="tgl_periksa" class="form-control @error('tgl_periksa') is-invalid @enderror" value="{{ old('tgl_periksa') }}" required>
                    @error('tgl_periksa')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary mt-3">Simpan Janji</button>
            </form>
        </div>
    </div>

    {{-- Riwayat Periksa --}}
    <div class="card mt-4">
        <div class="card-header bg-primary text-white">Riwayat Periksa</div>
        <div class="card-body">
            @if ($riwayat->isEmpty())
                <p>Belum ada riwayat periksa.</p>
            @else
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Dokter</th>
                            <th>Tanggal</th>
                            <th>Biaya</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($riwayat as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->dokter->nama ?? 'Dokter Tidak Ditemukan' }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tgl_periksa)->isoFormat('dddd, D MMMM Y, HH:mm') }}</td>
                                <td>
                                    @if ($item->biaya_pemeriksaan > 0)
                                        Rp {{ number_format($item->biaya_pemeriksaan, 0, ',', '.') }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if ($item->biaya_pemeriksaan > 0 && $item->catatan)
                                        <span class="badge bg-success">Sudah Diperiksa</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Menunggu Pemeriksaan</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection