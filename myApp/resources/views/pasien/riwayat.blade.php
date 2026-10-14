<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Riwayat Kunjungan</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f3f4f6; padding: 25px; }
        .card { max-width: 900px; margin: auto; padding: 24px; background: white; border-radius: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
    </style>
</head>
<body>
<div class="card">
    <h1>Riwayat Kunjungan</h1>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Poli</th>
                <th>Dokter</th>
                <th>Keluhan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($kunjungans as $kunjungan)
            <tr>
                <td>{{ $kunjungan->tanggal?->format('d-m-Y') }}</td>
                <td>{{ $kunjungan->poli?->nama_poli }}</td>
                <td>{{ $kunjungan->dokter?->nama }}</td>
                <td>{{ $kunjungan->keluhan_awal }}</td>
                <td>{{ ucfirst($kunjungan->status) }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5">Belum ada riwayat kunjungan.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <p><a href="{{ route('pasien.dashboard') }}">Kembali ke Dashboard</a></p>
</div>
</body>
</html>
