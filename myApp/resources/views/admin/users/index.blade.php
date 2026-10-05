<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Management Pengguna - Puskestren</title>

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
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }

        .top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            padding: 10px 16px;
            border-radius: 8px;
            text-decoration: none;
            color: white;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: #2563eb;
        }

        .btn-warning {
            background: #f59e0b;
        }

        .btn-danger {
            background: #dc2626;
        }

        .btn-secondary {
            background: #6b7280;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #f9fafb;
        }

        .badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 13px;
        }

        .aktif {
            background: #dcfce7;
            color: #166534;
        }

        .nonaktif {
            background: #fee2e2;
            color: #991b1b;
        }

        .success {
            padding: 12px;
            background: #dcfce7;
            color: #166534;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .error {
            padding: 12px;
            background: #fee2e2;
            color: #991b1b;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .actions {
            display: flex;
            gap: 6px;
        }
    </style>
</head>

<body>

<div class="navbar">
    <strong>Puskestren</strong> — Management Pengguna
</div>

<div class="container">

    <div class="card">

        <div class="top">
            <div>
                <h1>Management Pengguna</h1>
                <p>Daftar seluruh pengguna sistem.</p>
            </div>

            <div>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                    Dashboard
                </a>

                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                    + Tambah Pengguna
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="error">
                {{ $errors->first() }}
            </div>
        @endif

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>

                        <td>{{ $user->name }}</td>

                        <td>{{ $user->email }}</td>

                        <td>
                            {{ ucfirst($user->role) }}
                        </td>

                        <td>
                            <span class="badge {{ $user->status }}">
                                {{ ucfirst($user->status) }}
                            </span>
                        </td>

                        <td>
                            <div class="actions">

                                <a
                                    href="{{ route('admin.users.edit', $user) }}"
                                    class="btn btn-warning"
                                >
                                    Edit
                                </a>

                                @if ($user->id !== auth()->id())
                                    <form
                                        action="{{ route('admin.users.destroy', $user) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-danger"
                                        >
                                            Hapus
                                        </button>
                                    </form>
                                @endif

                            </div>
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="6">
                            Belum ada data pengguna.
                        </td>
                    </tr>

                @endforelse
            </tbody>
        </table>

    </div>

</div>

</body>
</html>