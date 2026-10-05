<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Puskestren</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f3f4f6;
        }

        .navbar {
            background: #7c3aed;
            color: white;
            padding: 18px 30px;
        }

        .container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }

        .menu a {
            display: block;
            padding: 14px;
            margin: 10px 0;
            background: #f5f3ff;
            color: #6d28d9;
            text-decoration: none;
            border-radius: 8px;
        }

        button {
            margin-top: 20px;
            padding: 10px 18px;
            border: none;
            border-radius: 8px;
            background: #dc2626;
            color: white;
            cursor: pointer;
        }
    </style>
</head>

<body>

<div class="navbar">
    <strong>Puskestren</strong> — Dashboard Admin
</div>

<div class="container">

    <div class="card">

        <h1>Dashboard Admin</h1>

        <p>
            Selamat datang,
            <strong>{{ auth()->user()->name }}</strong>
        </p>

        <p>
            Anda login sebagai:
            <strong>{{ auth()->user()->role }}</strong>
        </p>

        <div class="menu">
            <a href="{{ route('admin.users.index') }}">
                Management Pengguna
            </a>

            <a href="#">Kelola Data Pasien</a>
            <a href="#">Kelola Data Dokter</a>
            <a href="#">Kelola Data Poli</a>
            <a href="#">Kelola Data Kunjungan</a>
            <a href="#">Kelola Antrean</a>
            <a href="#">Lihat Laporan</a>
            <a href="#">Cetak Laporan</a>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Logout</button>
        </form>

    </div>

</div>

</body>
</html>