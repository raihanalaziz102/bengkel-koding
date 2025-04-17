@extends('layout.app')

@section('title', 'Daftar Pasien Periksa')

@section('nav-item')
    <li class="nav-item">
        <a href="{{ route('dokter.memeriksa') }}" class="nav-link {{ Route::is('dokter.memeriksa') ? 'active' : '' }}">
            <i class="nav-icon fas fa-solid fa-stethoscope"></i>
            <p>Memeriksa</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('obat.index') }}" class="nav-link {{ Route::is('obat.index') ? 'active' : '' }}">
            <i class="nav-icon fas fa-solid fa-capsules"></i>
            <p>Obat</p>
        </a>
    </li>
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Daftar Pasien Periksa</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dokter.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Memeriksa</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Daftar Pasien</h3>
                            <div class="card-tools">
                                <form action="{{ route('dokter.memeriksa') }}" method="GET" class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="search" class="form-control float-right" placeholder="Cari Nama" value="{{ request('search') }}">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-0">
                            @if ($periksas->isEmpty())
                                <p class="p-3">Belum ada pasien yang dijadwalkan untuk diperiksa.</p>
                            @else
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Pasien</th>
                                            <th>Tanggal Periksa</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($periksas as $periksa)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $periksa->pasien->nama ?? 'Pasien Tidak Ditemukan' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($periksa->tgl_periksa)->isoFormat('dddd, D MMMM Y, HH:mm') }}</td>
                                                <td>
                                                    @if ($periksa->biaya_pemeriksaan > 0 && $periksa->catatan)
                                                        <span class="badge bg-success">Sudah Diperiksa</span>
                                                    @else
                                                        <span class="badge bg-warning text-dark">Menunggu Pemeriksaan</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('dokter.periksa.edit', $periksa->id) }}" class="btn btn-sm btn-primary">Periksa</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection