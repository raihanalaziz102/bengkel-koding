@extends('layout.app')

@section('title','Edit Obat')

@section('content')
<div class="container mt-4">
    <h1>Edit Obat</h1>

    <form action="{{ route('obat.update', $obat->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nama Obat</label>
            <input type="text" name="nama_obat" class="form-control" value="{{ $obat->nama_obat }}" required>
        </div>
        <div class="form-group">
            <label>Kemasan</label>
            <input type="text" name="kemasan" class="form-control" value="{{ $obat->kemasan }}" required>
        </div>
        <div class="form-group">
            <label>Harga</label>
            <input type="number" name="harga" class="form-control" value="{{ $obat->harga }}" required>
        </div>
        <button class="btn btn-success">Update</button>
        <a href="{{ route('obat.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
