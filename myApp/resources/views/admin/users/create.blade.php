<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Pengguna - Puskestren</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f3f4f6;
            color: #111827;
        }

        .container {
            max-width: 700px;
            margin: 40px auto;
            padding: 20px;
        }

        .card {
            background: #ffffff;
            padding: 30px;
            border-radius: 14px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        }

        h1 {
            margin-top: 0;
            margin-bottom: 8px;
        }

        .description {
            color: #6b7280;
            margin-bottom: 25px;
        }

        .alert-error {
            padding: 14px 16px;
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .alert-error ul {
            margin: 8px 0 0 20px;
            padding: 0;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
        }

        .required {
            color: #dc2626;
        }

        input,
        select {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 15px;
            background: #fff;
        }

        input:focus,
        select:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        }

        .is-invalid {
            border-color: #dc2626;
        }

        .error-message {
            display: block;
            margin-top: 6px;
            color: #dc2626;
            font-size: 14px;
        }

        .help-text {
            display: block;
            margin-top: 6px;
            color: #6b7280;
            font-size: 13px;
        }

        .actions {
            display: flex;
            gap: 10px;
            margin-top: 25px;
        }

        .btn {
            display: inline-block;
            padding: 11px 18px;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            cursor: pointer;
            font-size: 15px;
        }

        .btn-primary {
            background: #2563eb;
            color: #ffffff;
        }

        .btn-primary:hover {
            background: #1d4ed8;
        }

        .btn-secondary {
            background: #6b7280;
            color: #ffffff;
        }

        .btn-secondary:hover {
            background: #4b5563;
        }

        .admin-info {
            margin-bottom: 20px;
            padding: 12px 14px;
            background: #eff6ff;
            color: #1e40af;
            border-radius: 8px;
            font-size: 14px;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="card">

        <h1>Tambah Pengguna</h1>

        <p class="description">
            Tambahkan akun pengguna baru ke sistem Puskestren.
        </p>

        <div class="admin-info">
            Anda login sebagai:
            <strong>{{ auth()->user()->name }}</strong>
            ({{ auth()->user()->role }})
        </div>

        {{-- Ringkasan seluruh error validasi Laravel --}}
        @if ($errors->any())
            <div class="alert-error">
                <strong>Data belum dapat disimpan.</strong>

                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            method="POST"
            action="{{ route('admin.users.store') }}"
            novalidate
        >
            @csrf

            {{-- Nama --}}
            <div class="form-group">

                <label for="name">
                    Nama <span class="required">*</span>
                </label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    class="@error('name') is-invalid @enderror"
                >

                @error('name')
                    <span class="error-message">
                        {{ $message }}
                    </span>
                @enderror

            </div>

            {{-- Email --}}
            <div class="form-group">

                <label for="email">
                    Email <span class="required">*</span>
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="@error('email') is-invalid @enderror"
                >

                @error('email')
                    <span class="error-message">
                        {{ $message }}
                    </span>
                @enderror

            </div>

            {{-- Password --}}
            <div class="form-group">

                <label for="password">
                    Password <span class="required">*</span>
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    class="@error('password') is-invalid @enderror"
                >

                <span class="help-text">
                    Minimal 8 karakter.
                </span>

                @error('password')
                    <span class="error-message">
                        {{ $message }}
                    </span>
                @enderror

            </div>

            {{-- Role --}}
            <div class="form-group">

                <label for="role">
                    Role <span class="required">*</span>
                </label>

                <select
                    id="role"
                    name="role"
                    class="@error('role') is-invalid @enderror"
                >
                    <option value="">-- Pilih Role --</option>

                    <option
                        value="pasien"
                        {{ old('role') === 'pasien' ? 'selected' : '' }}
                    >
                        Pasien
                    </option>

                    <option
                        value="admin"
                        {{ old('role') === 'admin' ? 'selected' : '' }}
                    >
                        Admin
                    </option>

                    <option
                        value="dokter"
                        {{ old('role') === 'dokter' ? 'selected' : '' }}
                    >
                        Dokter
                    </option>
                </select>

                @error('role')
                    <span class="error-message">
                        {{ $message }}
                    </span>
                @enderror

            </div>

            {{-- Status --}}
            <div class="form-group">

                <label for="status">
                    Status <span class="required">*</span>
                </label>

                <select
                    id="status"
                    name="status"
                    class="@error('status') is-invalid @enderror"
                >
                    <option value="">-- Pilih Status --</option>

                    <option
                        value="aktif"
                        {{ old('status', 'aktif') === 'aktif' ? 'selected' : '' }}
                    >
                        Aktif
                    </option>

                    <option
                        value="nonaktif"
                        {{ old('status') === 'nonaktif' ? 'selected' : '' }}
                    >
                        Nonaktif
                    </option>
                </select>

                @error('status')
                    <span class="error-message">
                        {{ $message }}
                    </span>
                @enderror

            </div>

            {{-- Tombol --}}
            <div class="actions">

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Simpan Pengguna
                </button>

                <a
                    href="{{ route('admin.users.index') }}"
                    class="btn btn-secondary"
                >
                    Kembali
                </a>

            </div>

        </form>

    </div>

</div>

</body>
</html>