<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pendaftaran Kunjungan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f3f4f6;
            margin: 0;
            padding: 25px;
        }
        .card {
            max-width: 650px;
            margin: auto;
            padding: 25px;
            background: white;
            border-radius: 12px;
        }
        label { display: block; margin-top: 15px; }
        input, select, textarea {
            width: 100%;
            box-sizing: border-box;
            padding: 10px;
            margin-top: 6px;
        }
        button {
            margin-top: 20px;
            padding: 12px 18px;
            background: #2563eb;
            color: white;
            border: 0;
            border-radius: 6px;
            cursor: pointer;
        }
        .error { color: #b91c1c; }
    </style>
</head>
<body>
<div class="card">
    <h1>Pendaftaran Kunjungan</h1>

    <p>Pasien: <strong>{{ $pasien->nama }}</strong></p>

    @if ($errors->any())
        <div class="error">
            <p>Periksa kembali data berikut:</p>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('pasien.pendaftaran.store') }}">
        @csrf

        <label for="id_poli">Poli</label>
        <select name="id_poli" id="id_poli" required>
            <option value="">-- Pilih Poli --</option>
            @foreach ($polis as $poli)
                <option value="{{ $poli->id_poli }}"
                    @selected(old('id_poli') == $poli->id_poli)>
                    {{ $poli->nama_poli }}
                </option>
            @endforeach
        </select>

        <label for="id_dokter">Dokter</label>
        <select name="id_dokter" id="id_dokter" required>
            <option value="">-- Pilih Dokter --</option>
            @foreach ($dokters as $dokter)
                <option value="{{ $dokter->id_dokter }}"
                    data-poli="{{ $dokter->id_poli }}"
                    @selected(old('id_dokter') == $dokter->id_dokter)>
                    {{ $dokter->nama }} — {{ $dokter->poli?->nama_poli }}
                </option>
            @endforeach
        </select>

        <label for="tanggal">Tanggal Kunjungan</label>
        <input type="date" name="tanggal" id="tanggal"
            min="{{ now()->toDateString() }}"
            value="{{ old('tanggal') }}" required>

        <label for="keluhan_awal">Keluhan Awal</label>
        <textarea name="keluhan_awal" id="keluhan_awal"
            rows="4" required>{{ old('keluhan_awal') }}</textarea>

        <button type="submit">Daftar Kunjungan</button>
    </form>

    <p><a href="{{ route('pasien.dashboard') }}">Kembali ke Dashboard</a></p>
</div>

<script>
    const poliSelect = document.getElementById('id_poli');
    const dokterSelect = document.getElementById('id_dokter');

    function filterDokter() {
        const poliId = poliSelect.value;

        Array.from(dokterSelect.options).forEach(option => {
            if (!option.value) return;

            const sesuai = option.dataset.poli === poliId;
            option.hidden = !sesuai;

            if (!sesuai && option.selected) {
                dokterSelect.value = '';
            }
        });
    }

    poliSelect.addEventListener('change', filterDokter);
    filterDokter();
</script>
</body>
</html>
