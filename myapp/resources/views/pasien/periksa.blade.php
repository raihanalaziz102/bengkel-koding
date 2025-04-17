@extends('layout.app')

@section('title', 'Periksa')

@section('content')
<div class="container mt-4">
    <h3>Periksa</h3>

    {{-- Form Buat Janji --}}
    <div class="card mt-3">
        <div class="card-header bg-primary text-white">Form Periksa</div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('pasien.periksa.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="id_dokter">Pilih Dokter</label>
                    <select name="id_dokter" class="form-control" required>
                        <option value="">-- Pilih Dokter --</option>
                        @foreach ($dokters as $dokter)
                            <option value="{{ $dokter->id }}">{{ $dokter->nama }}</option>
                        @endforeach
                    </select>
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
                            <th>Biaya Periksa</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($riwayat as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->dokter->nama ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tgl_periksa)->isoFormat('dddd, D MMMM Y') }}</td>
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
