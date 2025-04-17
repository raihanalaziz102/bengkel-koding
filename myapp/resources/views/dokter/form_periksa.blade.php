
@extends('layout.app')

@section('title', 'Form Pemeriksaan')

@section('content')
<div class="container mt-4">
    <h2>Form Edit Pemeriksaan</h2>

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

    <form action="{{ route('dokter.periksa.update', $periksa->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label>Nama Pasien</label>
            <input type="text" class="form-control" value="{{ $periksa->pasien->nama ?? 'Pasien Tidak Ditemukan' }}" readonly>
        </div>

        <div class="form-group mb-3">
            <label>Tanggal Pemeriksaan</label>
            <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($periksa->tgl_periksa)->format('d/m/Y H:i') }}" readonly>
        </div>

        <div class="form-group mb-3">
            <label>Catatan</label>
            <textarea name="catatan" class="form-control @error('catatan') is-invalid @enderror" rows="4" required>{{ old('catatan', $periksa->catatan) }}</textarea>
            @error('catatan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="obat-select">Pilih Obat</label>
            <select class="form-control @error('obat_id') is-invalid @enderror" id="obat-select">
                <option value="">-- Pilih Obat --</option>
                @foreach($obats as $obat)
                    <option value="{{ $obat->id }}" data-nama_obat="{{ $obat->nama_obat ?? 'Nama Tidak Tersedia' }}" data-harga="{{ $obat->harga ?? 0 }}">
                        {{ $obat->nama_obat ?? 'Nama Tidak Tersedia' }} - {{ $obat->kemasan ?? 'Kemasan Tidak Tersedia' }} - Rp {{ number_format($obat->harga ?? 0, 0, ',', '.') }}
                    </option>
                @endforeach
            </select>
            @error('obat_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label>Obat Dipilih:</label>
            <ul class="list-group mb-2" id="obat-list"></ul>
        </div>

        <div class="form-group mb-3">
            <strong>Total Harga:</strong> <span id="total-harga">Rp 0</span>
            <input type="hidden" name="total_harga" id="hidden-total-harga" value="0">
        </div>

        <button type="submit" class="btn btn-primary">Simpan Pemeriksaan</button>
    </form>
</div>

<script>
    const selectEl = document.getElementById('obat-select');
    const listEl = document.getElementById('obat-list');
    const totalEl = document.getElementById('total-harga');
    const hiddenTotalEl = document.getElementById('hidden-total-harga');
    const form = document.querySelector('form');

    let selectedObats = [];
    let basePrice = 150000; // Biaya dasar pemeriksaan

    // Load existing obats if any
    document.addEventListener('DOMContentLoaded', () => {
        @if(isset($periksa->detail_periksa) && $periksa->detail_periksa->count() > 0)
            @foreach($periksa->detail_periksa as $detail)
                @if(isset($detail->obat))
                    selectedObats.push({
                        id: {{ $detail->obat->id }},
                        nama: "{{ $detail->obat->nama_obat ?? 'Nama Tidak Tersedia' }}",
                        harga: {{ $detail->obat->harga ?? 0 }}
                    });
                @endif
            @endforeach
            updateList();
            updateTotal();
        @else
            updateTotal(); // Set initial total to base price
        @endif
    });

    selectEl.addEventListener('change', function () {
        const selectedOption = selectEl.options[selectEl.selectedIndex];
        const id = selectedOption.value;

        if (!id) return;

        const nama = selectedOption.getAttribute('data-nama_obat') || 'Nama Tidak Tersedia';
        const harga = parseInt(selectedOption.getAttribute('data-harga')) || 0;

        if (!selectedObats.find(obat => obat.id == id)) {
            selectedObats.push({ id, nama, harga });
            updateList();
            updateTotal();
        }

        selectEl.value = "";
    });

    function updateList() {
        listEl.innerHTML = '';

        // Hapus input hidden lama
        form.querySelectorAll('input[name="obat_id[]"]').forEach(el => el.remove());

        selectedObats.forEach(obat => {
            const li = document.createElement('li');
            li.classList.add('list-group-item', 'd-flex', 'justify-content-between', 'align-items-center');
            li.innerHTML = `
                ${obat.nama} - Rp ${obat.harga.toLocaleString('id-ID')}
                <button type="button" class="btn btn-sm btn-danger" onclick="hapusObat(${obat.id})">Hapus</button>
            `;
            listEl.appendChild(li);

            // Tambah hidden input ke dalam form
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'obat_id[]';
            input.value = obat.id;
            form.appendChild(input);
        });
    }

    function updateTotal() {
        const totalObat = selectedObats.reduce((sum, obat) => sum + obat.harga, 0);
        const total = basePrice + totalObat;
        totalEl.innerText = `Rp ${total.toLocaleString('id-ID')}`;
        hiddenTotalEl.value = total;
    }

    function hapusObat(id) {
        selectedObats = selectedObats.filter(obat => obat.id != id);
        updateList();
        updateTotal();
    }
</script>
@endsection