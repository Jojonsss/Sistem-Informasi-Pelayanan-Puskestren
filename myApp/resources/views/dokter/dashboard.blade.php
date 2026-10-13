<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Dokter | Puskestren</title>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f7f6;
            color: #19352e;
        }

        .navbar {
            background: linear-gradient(120deg, #047857, #10b981);
            color: white;
            padding: 22px 5%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
        }

        .navbar h2 { margin: 0 0 5px; }
        .navbar p { margin: 0; opacity: .9; }

        .container {
            max-width: 1200px;
            margin: 32px auto;
            padding: 0 20px;
        }

        .welcome {
            background: white;
            padding: 26px;
            border-radius: 18px;
            box-shadow: 0 8px 30px #12352b0b;
            margin-bottom: 24px;
        }

        .welcome h1 { margin-top: 0; }
        .muted { color: #718078; }

        .stats {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 8px 30px #12352b08;
        }

        .stat-label { color: #718078; font-size: 13px; }
        .stat-number { font-size: 30px; font-weight: bold; margin-top: 10px; }

        .menus {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .menu {
            display: flex;
            gap: 16px;
            align-items: flex-start;
            background: white;
            padding: 23px;
            border-radius: 16px;
            text-decoration: none;
            color: inherit;
            border: 1px solid #e8f0ec;
            transition: .2s;
        }

        .menu:hover {
            transform: translateY(-3px);
            border-color: #10b981;
            box-shadow: 0 10px 25px #04785712;
        }

        .icon {
            width: 48px;
            height: 48px;
            border-radius: 13px;
            display: grid;
            place-items: center;
            background: #dcfce7;
            font-size: 24px;
            flex-shrink: 0;
        }

        .menu h3 { margin: 3px 0 8px; }
        .menu p { margin: 0; color: #718078; line-height: 1.5; }
        .arrow { color: #047857; font-weight: bold; margin-top: 12px; }

        .panel {
            margin-top: 24px;
            background: white;
            border-radius: 16px;
            padding: 24px;
            overflow-x: auto;
        }

        table { width: 100%; border-collapse: collapse; min-width: 500px; }
        th, td { text-align: left; padding: 14px 10px; border-bottom: 1px solid #edf1ef; }
        th { color: #718078; font-size: 12px; background: #f0f8f4; }
        .status { background: #dcfce7; color: #166534; padding: 6px 10px; border-radius: 20px; font-size: 12px; }

        .logout {
            border: 0;
            padding: 11px 16px;
            border-radius: 9px;
            background: #fff;
            color: #047857;
            cursor: pointer;
            font-weight: bold;
        }

        @media(max-width: 850px) {
            .stats { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }

        @media(max-width: 600px) {
            .menus { grid-template-columns: 1fr; }
            .navbar { align-items: flex-start; }
            .stat-number { font-size: 24px; }
        }
    </style>
</head>

<body>
<header class="navbar">
    <div>
        <h2>✚ Puskestren</h2>
        <p>Portal Pelayanan Dokter</p>
    </div>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="logout" type="submit">Keluar ↗</button>
    </form>
</header>

<main class="container">
    <section class="welcome">
        <p class="muted">DASHBOARD DOKTER</p>
        <h1>Selamat datang, {{ auth()->user()->name }} 👋</h1>
        <p class="muted">
            Kelola pasien, pemeriksaan, diagnosis, dan riwayat
            pelayanan dari satu halaman.
        </p>
    </section>

    <section class="stats">
        <div class="stat">
            <div class="stat-label">Total Pasien Terdaftar</div>
            <div class="stat-number">{{ $totalPasien }}</div>
        </div>

        <div class="stat">
            <div class="stat-label">Kunjungan Hari Ini</div>
            <div class="stat-number">{{ $kunjunganHariIni }}</div>
        </div>

        <div class="stat">
            <div class="stat-label">Menunggu Pelayanan</div>
            <div class="stat-number">{{ $menunggu }}</div>
        </div>

        <div class="stat">
            <div class="stat-label">Kunjungan Selesai</div>
            <div class="stat-number">{{ $selesai }}</div>
        </div>
    </section>

    <h2>Menu Pelayanan</h2>

    <section class="menus">
        <a href="{{ route('dokter.pasien') }}" class="menu">
            <div class="icon">👥</div>
            <div>
                <h3>Melihat Pasien</h3>
                <p>Cari pasien, filter jenis pasien, dan lihat detail identitas.</p>
                <div class="arrow">Buka daftar pasien →</div>
            </div>
        </a>

        <a href="{{ route('dokter.pemeriksaan') }}" class="menu">
            <div class="icon">🩺</div>
            <div>
                <h3>Melakukan Pemeriksaan</h3>
                <p>Buka daftar pasien untuk memilih kunjungan yang akan diperiksa.</p>
                <div class="arrow">Pilih pasien →</div>
            </div>
        </a>

        <a href="{{ route('dokter.diagnosis') }}" class="menu">
            <div class="icon">📋</div>
            <div>
                <h3>Catat Diagnosis</h3>
                <p>Temukan pasien dan kunjungan sebelum mencatat diagnosis.</p>
                <div class="arrow">Cari kunjungan →</div>
            </div>
        </a>

        <a href="{{ route('dokter.riwayat') }}" class="menu">
            <div class="icon">🕘</div>
            <div>
                <h3>Riwayat Pasien</h3>
                <p>Buka detail pasien untuk melihat daftar kunjungan sebelumnya.</p>
                <div class="arrow">Lihat riwayat →</div>
            </div>
        </a>
    </section>

    <section class="panel">
        <h2>Kunjungan Terbaru</h2>

        <table>
            <thead>
                <tr>
                    <th>Pasien</th>
                    <th>Tanggal Kunjungan</th>
                    <th>Keluhan</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            @forelse ($kunjunganTerbaru as $kunjungan)
                <tr>
                    <td>{{ $kunjungan->name }}</td>
                    <td>{{ $kunjungan->tanggal_kunjungan }}</td>
                    <td>{{ $kunjungan->keluhan ?: '-' }}</td>
                    <td><span class="status">{{ ucfirst($kunjungan->status) }}</span></td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Belum ada data kunjungan.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </section>
</main>
</body>
</html>
