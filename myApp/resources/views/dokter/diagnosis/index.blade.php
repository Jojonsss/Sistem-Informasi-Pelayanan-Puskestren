<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Catat Diagnosis | Puskestren</title>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f7f6;
            color: #19352e;
        }

        .container {
            max-width: 1100px;
            margin: 30px auto;
            padding: 20px;
        }

        .header, .form-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .card {
            background: white;
            padding: 24px;
            margin-top: 22px;
            border-radius: 14px;
            box-shadow: 0 4px 18px #12352b0b;
        }

        .muted { color: #718078; }

        .button {
            display: inline-block;
            padding: 10px 15px;
            border: 0;
            border-radius: 7px;
            background: #047857;
            color: white;
            text-decoration: none;
            cursor: pointer;
            font-size: 14px;
        }

        .secondary { background: #64748b; }

        .message {
            padding: 12px;
            margin-top: 15px;
            border-radius: 7px;
            background: #dcfce7;
            color: #166534;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
        }

        .patient {
            border: 1px solid #e5ece8;
            border-radius: 10px;
            padding: 18px;
            margin-top: 16px;
        }

        .patient h3 { margin-top: 0; }

        .form-group { margin-bottom: 15px; }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
        }

        textarea {
            width: 100%;
            min-height: 85px;
            padding: 11px;
            border: 1px solid #d9e2de;
            border-radius: 7px;
            font: inherit;
        }

        .result {
            background: #f0fdf4;
            border-radius: 8px;
            padding: 12px;
            margin: 12px 0;
        }

        summary {
            cursor: pointer;
            font-weight: bold;
            color: #047857;
            margin-bottom: 15px;
        }

        @media(max-width: 600px) {
            .container { padding: 12px; }
            .card { padding: 16px; }
        }
    </style>
</head>

<body>
<main class="container">

    <div class="header">
        <div>
            <h1>Catat Diagnosis</h1>
            <p class="muted">
                Catat diagnosis, tindakan, dan catatan berdasarkan hasil pemeriksaan pasien.
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
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <section class="card">
        <h2>Daftar Pasien yang Sudah Diperiksa</h2>

        @forelse($kunjungans as $kunjungan)
            <div class="patient">
                <h3>{{ $kunjungan->name }}</h3>

                <p class="muted">
                    Tanggal kunjungan: {{ $kunjungan->tanggal_kunjungan }}
                </p>

                <div class="result">
                    <strong>Hasil pemeriksaan:</strong>
                    <p>{{ $kunjungan->hasil_pemeriksaan ?? 'Belum ada hasil pemeriksaan.' }}</p>
                </div>

                @if($kunjungan->hasil_pemeriksaan)
                    <details>
                        <summary>
                            {{ $kunjungan->diagnosis_id ? 'Perbarui Diagnosis' : 'Catat Diagnosis' }}
                        </summary>

                        <form action="{{ route('dokter.diagnosis.simpan', $kunjungan->kunjungan_id) }}"
                              method="POST">
                            @csrf

                            <div class="form-group">
                                <label>Diagnosis *</label>
                                <textarea name="diagnosis" required>{{ $kunjungan->diagnosis ?? '' }}</textarea>
                            </div>

                            <div class="form-group">
                                <label>Tindakan</label>
                                <textarea name="tindakan">{{ $kunjungan->tindakan ?? '' }}</textarea>
                            </div>

                            <div class="form-group">
                                <label>Catatan Tambahan</label>
                                <textarea name="catatan">{{ $kunjungan->catatan ?? '' }}</textarea>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="button">
                                    Simpan Diagnosis
                                </button>

                                <button type="reset" class="button secondary">
                                    Reset Form
                                </button>
                            </div>
                        </form>
                    </details>
                @else
                    <p class="muted">
                        Pasien harus menjalani pemeriksaan terlebih dahulu sebelum diagnosis dicatat.
                    </p>
                @endif
            </div>
        @empty
            <p class="muted">
                Belum ada data kunjungan pasien. Lakukan pemeriksaan terlebih dahulu.
            </p>
        @endforelse
    </section>

</main>
</body>
</html>
