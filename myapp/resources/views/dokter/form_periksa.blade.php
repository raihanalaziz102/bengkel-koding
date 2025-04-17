@extends('layout.app')

@section('title','Form Pemeriksaan')

@section('content')
<div class="container mt-4">
    <h2>Form Edit Pemeriksaan</h2>

    <form action="{{ route('dokter.periksa.update', $periksa->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nama Pasien</label>
            <input type="text" class="form-control" value="{{ $periksa->pasien->nama }}" readonly>
        </div>

        <div class="form-group">
            <label>Tanggal Pemeriksaan</label>
            <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($periksa->tgl_periksa)->format('d/m/Y') }}" readonly>
        </div>

        <div class="form-group">
            <label>Catatan</label>
            <textarea name="catatan" class="form-control" rows="3" required>{{ $periksa->catatan }}</textarea>
        </div>

        <div class="form-group">
            <label for="obat-select">Pilih Obat</label>
            <select class="form-control" id="obat-select">
                <option value="">-- Pilih Obat --</option>
                @foreach($obats as $obat)
                    <option value="{{ $obat->id }}" data-nama="{{ $obat->nama }}" data-harga="{{ $obat->harga }}">
                        {{ $obat->nama }} - {{ $obat->kemasan }} - Rp {{ number_format($obat->harga) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group mt-3">
            <label>Obat Dipilih:</label>
            <ul class="list-group mb-2" id="obat-list"></ul>
        </div>

        <div class="form-group">
            <strong>Total Harga:</strong> <span id="total-harga">Rp 150.000</span>
            <input type="hidden" name="total_harga" id="hidden-total-harga" value="150000">
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
    let total = 150000;

    // Load existing obats if any
    document.addEventListener('DOMContentLoaded', () => {
        @if(isset($periksa->detail_periksa) && count($periksa->detail_periksa) > 0)
            @foreach($periksa->detail_periksa as $detail)
                @if(isset($detail->obat))
                    selectedObats.push({
                        id: {{ $detail->obat->id }}, 
                        nama: "{{ $detail->obat->nama }}", 
                        harga: {{ $detail->obat->harga }}
                    });
                @endif
            @endforeach
            updateList();
            updateTotal();
        @endif
    });

    selectEl.addEventListener('change', function () {
        const selectedOption = selectEl.options[selectEl.selectedIndex];
        const id = selectedOption.value;
        
        if (!id) return;
        
        const nama = selectedOption.getAttribute('data-nama');
        const harga = parseInt(selectedOption.getAttribute('data-harga'));

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
        total = 150000 + selectedObats.reduce((sum, obat) => sum + obat.harga, 0);
        totalEl.innerText = "Rp " + total.toLocaleString('id-ID');
        hiddenTotalEl.value = total; // Update hidden field with the new total
    }

    function hapusObat(id) {
        selectedObats = selectedObats.filter(obat => obat.id != id);
        updateList();
        updateTotal();
    }
</script>
@endsection