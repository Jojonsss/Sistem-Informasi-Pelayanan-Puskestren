
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Pasien - Puskestren</title>
    <style>
        body { margin: 0; font-family: Arial, sans-serif; background: #f3f4f6; color: #1f2937; }
        header { background: #2563eb; color: white; padding: 20px 30px; }
        main { max-width: 900px; margin: 35px auto; padding: 0 20px; }
        .card { background: white; padding: 25px; border-radius: 12px; margin-bottom: 20px; }
        .menu a { display: block; padding: 14px; margin: 10px 0; background: #eff6ff; color: #1d4ed8; text-decoration: none; border-radius: 8px; }
        button { padding: 10px 18px; border: 0; border-radius: 8px; background: #dc2626; color: white; cursor: pointer; }
    </style>
</head>
<body>
<header>
    <strong>Puskestren</strong> — Dashboard Pasien
</header>

<main>
    <section class="card">
        <h1>Dashboard Pasien</h1>
        <p>Selamat datang, <strong>{{ auth()->user()->nama }}</strong>.</p>
        <p>Jenis pasien: <strong>{{ $pasien->jenis_pasien }}</strong></p>
        <p>Total kunjungan: <strong>{{ $totalKunjungan }}</strong></p>

        @if ($antreanAktif)
            <h3>Antrean aktif</h3>
            <p>Nomor: <strong>{{ $antreanAktif->nomor_antrean }}</strong></p>
            <p>Poli: {{ $antreanAktif->kunjungan?->poli?->nama_poli }}</p>
            <p>Status: {{ ucfirst($antreanAktif->status) }}</p>
        @else
            <p>Kamu belum memiliki antrean aktif.</p>
        @endif

        <nav class="menu">
            <a href="{{ route('pasien.pendaftaran') }}">Pendaftaran Kunjungan</a>
            <a href="{{ route('pasien.antrean') }}">Melihat Antrean</a>
            <a href="{{ route('pasien.riwayat') }}">Riwayat Pelayanan</a>
        </nav>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </section>
</main>
</body>
</html>
