
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemeriksaan Pasien - Puskestren</title>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f3f7f5;
            color: #243b35;
        }

        .container {
            max-width: 1150px;
            margin: 30px auto;
            padding: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .muted { color: #75827e; }

        .button {
            display: inline-block;
            padding: 10px 14px;
            border: 0;
            border-radius: 7px;
            background: #147d64;
            color: white;
            text-decoration: none;
            cursor: pointer;
            font-size: 14px;
        }

        .secondary { background: #64748b; }
        .blue { background: #2563eb; }

        .card {
            background: white;
            padding: 22px;
            border-radius: 14px;
            margin-top: 22px;
            box-shadow: 0 3px 15px #163b2c0a;
        }

        .message {
            padding: 12px;
            border-radius: 7px;
            margin-top: 15px;
            background: #dcfce7;
            color: #166534;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
        }

        .table-wrap { overflow-x: auto; }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 13px 10px;
            text-align: left;
            border-bottom: 1px solid #edf0ee;
        }

        th { background: #f7faf8; }

        .badge {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 20px;
            background: #fef3c7;
            color: #92400e;
            font-size: 12px;
        }

        .done {
            background: #dcfce7;
            color: #166534;
        }

        .form-group { margin-bottom: 15px; }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 7px;
        }

        input, textarea {
            width: 100%;
            padding: 11px;
            border: 1px solid #d9e2de;
            border-radius: 7px;
            font: inherit;
        }

        textarea {
            min-height: 95px;
            resize: vertical;
        }

        .form-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        @media (max-width: 700px) {
            .table-wrap { overflow-x: auto; }
            table { min-width: 750px; }
        }
    </style>
</head>
<body>
<div class="container">

    <div class="header">
        <div>
            <h1>Melakukan Pemeriksaan</h1>
            <p class="muted">
                Pilih kunjungan pasien untuk mencatat hasil pemeriksaan.
            </p>
        </div>

        <a href="{{ route('dokter.dashboard') }}" class="button secondary">
            ← Kembali ke Dashboard
        </a>
    </div>

    @if(session('success'))
        <div class="message">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="message error">{{ session('error') }}</div>
    @endif

    @if($errors->any())
        <div class="message error">
            <strong>Periksa kembali isian berikut:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    
<div class="card">
    <h2>Daftar Kunjungan Pasien</h2>

    <form method="GET" action="{{ route('dokter.pemeriksaan') }}"
          style="display:flex;gap:12px;flex-wrap:wrap;align-items:end;margin-bottom:20px">

        <div style="min-width:180px;flex:1">
            <label for="status" style="display:block;margin-bottom:7px;font-weight:bold">
                Filter Status
            </label>
            <select name="status" id="status"
                    style="width:100%;padding:11px;border:1px solid #d9e2de;border-radius:7px">
                <option value="">Semua Status</option>
                <option value="menunggu" {{ request('status') === 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                <option value="diperiksa" {{ request('status') === 'diperiksa' ? 'selected' : '' }}>Diperiksa</option>
                <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="dibatalkan" {{ request('status') === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
            </select>
        </div>

        <div style="min-width:180px;flex:1">
            <label for="tanggal" style="display:block;margin-bottom:7px;font-weight:bold">
                Filter Tanggal
            </label>
            <input type="date" name="tanggal" id="tanggal"
                   value="{{ request('tanggal') }}">
        </div>

        <button type="submit" class="button">Terapkan Filter</button>
        <a href="{{ route('dokter.pemeriksaan') }}" class="button secondary">Reset Filter</a>
    </form>
    
    <!-- Tabel kunjungan yang sudah ada tetap diletakkan di bawah sini -->
</div>


        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Pasien</th>
                        <th>Tanggal Kunjungan</th>
                        <th>Keluhan Awal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($kunjungans as $kunjungan)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><strong>{{ $kunjungan->name }}</strong></td>
                        <td>{{ $kunjungan->tanggal_kunjungan }}</td>
                        <td>{{ $kunjungan->keluhan ?? '-' }}</td>
                        <td>
                            <span class="badge {{ $kunjungan->pemeriksaan_id ? 'done' : '' }}">
                                {{ ucfirst($kunjungan->status) }}
                            </span>
                        </td>
                        <td>
                            <a class="button blue"
                               href="#form-{{ $kunjungan->kunjungan_id }}">
                                {{ $kunjungan->pemeriksaan_id ? 'Perbarui' : 'Periksa' }}
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="6">
                            <details id="form-{{ $kunjungan->kunjungan_id }}">
                                <summary style="cursor:pointer;font-weight:bold;padding:10px">
                                    Form Pemeriksaan — {{ $kunjungan->name }}
                                </summary>

                                <form
                                    action="{{ route('dokter.pemeriksaan.simpan', $kunjungan->kunjungan_id) }}"
                                    method="POST"
                                    style="padding:15px">

                                    @csrf

                                    <div class="form-group">
                                        <label>Keluhan Pasien</label>
                                        <textarea name="keluhan">{{ $kunjungan->keluhan }}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>Riwayat Penyakit</label>
                                        <textarea name="riwayat_penyakit"
                                            placeholder="Tuliskan riwayat penyakit pasien jika ada..."></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>Hasil Pemeriksaan *</label>
                                        <textarea name="hasil_pemeriksaan"
                                            required
                                            placeholder="Tuliskan hasil pemeriksaan pasien..."></textarea>
                                    </div>

                                    <div class="form-actions">
                                        <button type="submit" class="button">
                                            Simpan Pemeriksaan
                                        </button>

                                        <button type="reset" class="button secondary">
                                            Reset Form
                                        </button>
                                    </div>
                                </form>
                            </details>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center;padding:30px">
                            Belum ada data kunjungan pasien.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
