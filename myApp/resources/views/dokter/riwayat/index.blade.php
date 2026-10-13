<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Riwayat Pasien | Puskestren</title>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f7f6;
            color: #19352e;
        }

        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .muted { color: #718078; }

        .button {
            display: inline-block;
            padding: 10px 15px;
            border-radius: 7px;
            background: #047857;
            color: white;
            text-decoration: none;
            font-size: 14px;
        }

        .secondary { background: #64748b; }

        .card {
            background: white;
            padding: 22px;
            margin-top: 22px;
            border-radius: 14px;
            box-shadow: 0 4px 18px #12352b0b;
        }

        .search {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        input {
            flex: 1;
            min-width: 200px;
            padding: 11px;
            border: 1px solid #d9e2de;
            border-radius: 7px;
            font-size: 14px;
        }

        button {
            border: 0;
            cursor: pointer;
            font: inherit;
        }

        .table-wrap { overflow-x: auto; }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 850px;
        }

        th, td {
            padding: 13px 10px;
            border-bottom: 1px solid #edf1ef;
            text-align: left;
            vertical-align: top;
        }

        th {
            background: #f0f8f4;
            color: #52645b;
            font-size: 13px;
        }

        .detail {
            background: #f0fdf4;
            padding: 14px;
            border-radius: 8px;
            min-width: 200px;
            white-space: normal;
        }

        .empty {
            text-align: center;
            padding: 30px;
            color: #718078;
        }

        @media(max-width: 600px) {
            .container { padding: 12px; }
            .card { padding: 15px; }
        }

        @media print {
            .no-print { display: none !important; }
            body { background: white; }
            .container { max-width: none; margin: 0; padding: 0; }
            .card { box-shadow: none; }
        }
    </style>
</head>

<body>
<main class="container">

    <div class="header no-print">
        <div>
            <h1>Riwayat Pasien</h1>
            <p class="muted">
                Lihat catatan kunjungan, pemeriksaan, dan diagnosis pasien.
            </p>
        </div>

        <a href="{{ route('dokter.dashboard') }}" class="button secondary">
            ← Kembali ke Dashboard
        </a>
    </div>

    <section class="card">
        <div class="search no-print">
            <input
                type="text"
                id="cariRiwayat"
                placeholder="Cari nama pasien atau nomor identitas..."
            >

            <button type="button" class="button" onclick="window.print()">
                Cetak Riwayat
            </button>
        </div>

        <div class="table-wrap">
            <table id="tabelRiwayat">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Pasien</th>
                        <th>Tanggal Kunjungan</th>
                        <th>Keluhan</th>
                        <th>Hasil Pemeriksaan</th>
                        <th>Diagnosis dan Tindakan</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($riwayat as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>
                            <strong>{{ $item->name }}</strong>
                            <p class="muted">
                                {{ $item->no_identitas ?: 'Nomor identitas belum diisi' }}
                            </p>
                        </td>

                        <td>{{ $item->tanggal_kunjungan }}</td>

                        <td>{{ $item->keluhan ?: '-' }}</td>

                        <td>
                            <div class="detail">
                                {{ $item->hasil_pemeriksaan ?: 'Belum ada hasil pemeriksaan.' }}

                                @if($item->riwayat_penyakit)
                                    <hr>
                                    <strong>Riwayat penyakit:</strong>
                                    <p>{{ $item->riwayat_penyakit }}</p>
                                @endif
                            </div>
                        </td>

                        <td>
                            <div class="detail">
                                <strong>Diagnosis:</strong>
                                <p>{{ $item->diagnosis ?: 'Belum dicatat.' }}</p>

                                <strong>Tindakan:</strong>
                                <p>{{ $item->tindakan ?: '-' }}</p>

                                @if($item->catatan)
                                    <strong>Catatan:</strong>
                                    <p>{{ $item->catatan }}</p>
                                @endif
                            </div>
                        </td>

                        <td>{{ ucfirst($item->status) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="empty">
                            Belum ada riwayat kunjungan pasien.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </section>

</main>

<script>
    document.getElementById('cariRiwayat').addEventListener('input', function () {
        const kata = this.value.toLowerCase();

        document.querySelectorAll('#tabelRiwayat tbody tr').forEach(function (baris) {
            baris.style.display = baris.innerText.toLowerCase().includes(kata)
                ? ''
                : 'none';
        });
    });
</script>

</body>
</html>
