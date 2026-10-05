<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengguna - Puskestren</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f3f4f6;
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }

        label {
            display: block;
            margin-top: 15px;
            margin-bottom: 6px;
            font-weight: bold;
        }

        input, select {
            width: 100%;
            padding: 11px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 11px 18px;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            cursor: pointer;
        }

        .save {
            background: #2563eb;
            color: white;
        }

        .back {
            background: #6b7280;
            color: white;
        }

        .error {
            padding: 12px;
            background: #fee2e2;
            color: #991b1b;
            border-radius: 8px;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="card">

        <h1>Edit Pengguna</h1>

        @if ($errors->any())
            <div class="error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            method="POST"
            action="{{ route('admin.users.update', $user) }}"
        >
            @csrf
            @method('PUT')

            <label for="name">Nama</label>
            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name', $user->name) }}"
                required
            >

            <label for="email">Email</label>
            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email', $user->email) }}"
                required
            >

            <label for="password">
                Password Baru
                <small>(kosongkan jika tidak ingin mengubah)</small>
            </label>

            <input
                type="password"
                id="password"
                name="password"
                minlength="8"
            >

            <label for="role">Role</label>
            <select id="role" name="role" required>

                <option
                    value="pasien"
                    {{ $user->role === 'pasien' ? 'selected' : '' }}
                >
                    Pasien
                </option>

                <option
                    value="admin"
                    {{ $user->role === 'admin' ? 'selected' : '' }}
                >
                    Admin
                </option>

                <option
                    value="dokter"
                    {{ $user->role === 'dokter' ? 'selected' : '' }}
                >
                    Dokter
                </option>

            </select>

            <label for="status">Status</label>

            <select id="status" name="status" required>

                <option
                    value="aktif"
                    {{ $user->status === 'aktif' ? 'selected' : '' }}
                >
                    Aktif
                </option>

                <option
                    value="nonaktif"
                    {{ $user->status === 'nonaktif' ? 'selected' : '' }}
                >
                    Nonaktif
                </option>

            </select>

            <br>

            <button type="submit" class="btn save">
                Simpan Perubahan
            </button>

            <a
                href="{{ route('admin.users.index') }}"
                class="btn back"
            >
                Kembali
            </a>

        </form>

    </div>

</div>

</body>
</html>