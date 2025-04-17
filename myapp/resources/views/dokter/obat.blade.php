@extends('layout.app')

@section('title','Obat')

@section('content')
<div class="container mt-4">
    <h1>Manajemen Obat</h1>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Tambah Obat -->
    <form action="{{ route('obat.store') }}" method="POST" class="mb-4">
        @csrf
        <div class="form-group">
            <label>Nama Obat</label>
            <input type="text" name="nama_obat" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Kemasan</label>
            <input type="text" name="kemasan" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Harga</label>
            <input type="number" name="harga" class="form-control" required>
        </div>
        <button class="btn btn-primary">Tambah</button>
    </form>

    <!-- Daftar Obat -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Obat</th>
                <th>Kemasan</th>
                <th>Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($obats as $obat)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $obat->nama_obat }}</td>
                <td>{{ $obat->kemasan }}</td>
                <td>Rp {{ number_format($obat->harga, 0, ',', '.') }}</td>
                <td>
                    <a href="{{ route('obat.edit', $obat->id) }}" class="btn btn-warning btn-sm">Edit</a>

                    <form action="{{ route('obat.destroy', $obat->id) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('Yakin ingin menghapus obat ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
