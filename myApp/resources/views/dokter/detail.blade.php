<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Pasien | Puskestren</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f7f6;
            color: #19352e;
        }
        header {
            padding: 24px 5%;
            color: white;
            background: linear-gradient(120deg, #047857, #10b981);
        }
        header h2 { margin: 0 0 7px; }
        main { max-width: 1100px; margin: 28px auto; padding: 0 20px; }
        a { color: #047857; text-decoration: none; }
        .back { display: inline-block; margin-bottom: 18px; font-weight: bold; }
        .card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 20px;
            box-shadow: 0 8px 30px #12352b0b;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
        }
        .label { color: #718078; font-size: 13px; margin-bottom: 7px; }
        .value { font-weight: bold; overflow-wrap: anywhere; }
        .badge {
            display: inline-block;
            background: #dcfce7;
            color: #166534;
            border-radius: 20px;
            padding: 6px 10px;
        }
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; min-width: 550px; }
        th, td { text-align: left; padding: 14px 10px; border-bottom: 1px solid #edf1ef; }
        th { background: #f0f8f4; font-size: 12px; }
        .empty { text-align: center; padding: 25px; color: #718078; }
        @media(max-width: 600px) {
            .grid { grid-template-columns: 1fr; }
            .card { padding: 17px; }
        }
    </style>
</head>
<body>
<header>
    <h2>✚ Puskestren</h2>
    <div>Informasi dan Riwayat Pasien</div>
</header>

<main>
    <a class="back" href="{{ route('dokter.pasien') }}">
        ← Kembali ke Daftar Pasien
    </a>

    <section class="card">
        <h2>{{ $pasien->name }}</h2>
        <p>Informasi dasar pasien yang tersimpan di sistem.</p>

        <div class="grid">
            <div>
                <div class="label">Nomor Rekam Data / ID Pasien</div>
                <div class="value">{{ $pasien->id }}</div>
            </div>
            <div>
                <div class="label">Jenis Pasien</div>
                <div class="value">
                    <span class="badge">{{ ucfirst($pasien->jenis_pasien) }}</span>
                </div>
            </div>
            <div>
                <div class="label">Nomor Identitas</div>
                <div class="value">{{ $pasien->no_identitas ?: 'Belum diisi' }}</div>
            </div>
            <div>
                <div class="label">Nomor HP</div>
                <div class="value">{{ $pasien->no_hp ?: 'Belum diisi' }}</div>
            </div>
            <div>
                <div class="label">Alamat</div>
                <div class="value">{{ $pasien->alamat ?: 'Belum diisi' }}</div>
            </div>
        </div>
    </section>

    <section class="card">
        <h2>Riwayat Kunjungan</h2>
        <p>Daftar kunjungan yang terhubung dengan pasien ini.</p>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Keluhan</th>
                        <th>Status</th>
                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($kunjungans as $kunjungan)
                    <tr>
                        <td>{{ $kunjungan->tanggal_kunjungan }}</td>
                        <td>{{ $kunjungan->keluhan ?: '-' }}</td>
                        <td>{{ ucfirst($kunjungan->status) }}</td>
                        <td>
                            <a href="#kunjungan-{{ $kunjungan->id }}">
                                Kunjungan #{{ $kunjungan->id }}
                            </a>
                        </td>
                    </tr>
                    <tr id="kunjungan-{{ $kunjungan->id }}">
                        <td colspan="4">
                            <strong>Informasi kunjungan #{{ $kunjungan->id }}</strong><br>
                            Tanggal: {{ $kunjungan->tanggal_kunjungan }}<br>
                            Keluhan awal: {{ $kunjungan->keluhan ?: 'Belum dicatat' }}<br>
                            Status: {{ ucfirst($kunjungan->status) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="empty">
                            Belum ada riwayat kunjungan.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </section>
</main>
</body>
</html>
