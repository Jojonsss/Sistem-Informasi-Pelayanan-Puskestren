
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pasien - Puskestren</title>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f3f7f5;
            color: #243b35;
        }

        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 20px;
        }

        .header, .actions, .filters {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            flex-wrap: wrap;
        }

        h1 { margin-bottom: 8px; }
        .muted { color: #75827e; }

        .button {
            display: inline-block;
            padding: 10px 14px;
            background: #147d64;
            color: white;
            border: none;
            border-radius: 7px;
            text-decoration: none;
            cursor: pointer;
            font-size: 14px;
        }

        .secondary { background: #64748b; }
        .blue { background: #2563eb; }
        .red { background: #dc2626; }
        .orange { background: #d97706; }

        .card {
            background: white;
            padding: 22px;
            border-radius: 14px;
            margin-top: 22px;
            box-shadow: 0 3px 15px #163b2c0a;
        }

        .filters { justify-content: flex-start; margin-bottom: 20px; }

        input, select, textarea {
            width: 100%;
            padding: 11px;
            border: 1px solid #d9e2de;
            border-radius: 7px;
            font: inherit;
        }

        .filters input { flex: 1; min-width: 200px; width: auto; }
        .filters select { width: auto; min-width: 150px; }

        .table-wrap { overflow-x: auto; }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 13px 10px;
            text-align: left;
            border-bottom: 1px solid #edf0ee;
        }

        th { background: #f7faf8; }

        .badge {
            padding: 5px 9px;
            border-radius: 20px;
            background: #dcfce7;
            color: #166534;
            font-size: 12px;
        }

        .message {
            padding: 12px;
            border-radius: 7px;
            margin-top: 15px;
            background: #dcfce7;
            color: #166534;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
        }

        .small-form { display: inline; }
        .small-form button { padding: 7px 9px; margin: 2px; }

        .pagination { margin-top: 20px; }

        .modal {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 10;
            background: #0008;
            padding: 20px;
            overflow-y: auto;
        }

        .modal-content {
            max-width: 600px;
            margin: 30px auto;
            background: white;
            border-radius: 12px;
            padding: 24px;
        }

        .form-group { margin-bottom: 14px; }
        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
        }

        .form-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .no-print { }

        @media print {
            body { background: white; }
            .container { margin: 0; max-width: none; padding: 0; }
            .no-print, .pagination, .aksi-column { display: none !important; }
            .card { box-shadow: none; padding: 0; }
            th, td { border: 1px solid #ccc; }
        }

        @media (max-width: 700px) {
            .filters input, .filters select { width: 100%; }
        }
    </style>
</head>
<body>
<div class="container">

    <div class="header">
        <div>
            <h1>Data Pasien</h1>
            <p class="muted">Kelola dan lihat informasi pasien Puskestren.</p>
        </div>

        <div class="actions no-print">
            <a href="{{ route('dokter.dashboard') }}" class="button secondary">
                ← Dashboard
            </a>
            <button type="button" class="button" onclick="bukaTambah()">
                + Tambah Pasien
            </button>
            <button type="button" class="button blue" onclick="window.print()">
                Cetak
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="message">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="message error">{{ session('error') }}</div>
    @endif

    @if($errors->any())
        <div class="message error">
            <strong>Data belum bisa disimpan:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <form action="{{ route('dokter.pasien') }}" method="GET"
              class="filters no-print">

            <input type="text" name="cari"
                   placeholder="Cari nama, identitas, atau HP..."
                   value="{{ request('cari') }}">

            <select name="jenis_pasien">
                <option value="">Semua jenis pasien</option>
                <option value="santri"
                    {{ request('jenis_pasien') == 'santri' ? 'selected' : '' }}>
                    Santri
                </option>
                <option value="umum"
                    {{ request('jenis_pasien') == 'umum' ? 'selected' : '' }}>
                    Umum
                </option>
            </select>

            <button type="submit" class="button">Cari</button>

            <a href="{{ route('dokter.pasien') }}"
               class="button secondary">Reset</a>
        </form>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Pasien</th>
                        <th>Jenis</th>
                        <th>No. Identitas</th>
                        <th>No. HP</th>
                        <th class="aksi-column no-print">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($pasiens as $pasien)
                    <tr>
                        <td>{{ $pasiens->firstItem() + $loop->index }}</td>
                        <td><strong>{{ $pasien->name }}</strong></td>
                        <td>
                            <span class="badge">
                                {{ ucfirst($pasien->jenis_pasien) }}
                            </span>
                        </td>
                        <td>{{ $pasien->no_identitas ?? '-' }}</td>
                        <td>{{ $pasien->no_hp ?? '-' }}</td>

                        <td class="aksi-column no-print">
                            <div class="actions" style="justify-content:flex-start">
                                <a class="button blue"
                                   href="{{ route('dokter.pasien.detail', $pasien->id) }}">
                                    Detail
                                </a>

                                <button type="button"
                                    class="button orange"
                                    onclick="bukaEdit(this)"
                                    data-id="{{ $pasien->id }}"
                                    data-name="{{ $pasien->name }}"
                                    data-email="{{ $pasien->email ?? '' }}"
                                    data-jenis="{{ $pasien->jenis_pasien }}"
                                    data-identitas="{{ $pasien->no_identitas }}"
                                    data-alamat="{{ $pasien->alamat }}"
                                    data-hp="{{ $pasien->no_hp }}">
                                    Edit
                                </button>

                                <form class="small-form"
                                      action="{{ route('dokter.pasien.hapus', $pasien->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus pasien ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="button red">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center;padding:30px">
                            Data pasien belum tersedia atau tidak ditemukan.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination no-print">
            {{ $pasiens->links() }}
        </div>
    </div>
</div>

<!-- Form tambah pasien -->
<div class="modal" id="modalTambah">
    <div class="modal-content">
        <h2>Tambah Pasien</h2>

        <form action="{{ route('dokter.pasien.simpan') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Nama pasien *</label>
                <input name="name" required maxlength="255">
            </div>

            <div class="form-group">
                <label>Email akun pasien *</label>
                <input type="email" name="email" required>
            </div>

            <div class="form-group">
                <label>Password akun pasien *</label>
                <input type="password" name="password" required minlength="8">
            </div>

            <div class="form-group">
                <label>Jenis pasien *</label>
                <select name="jenis_pasien" required>
                    <option value="">Pilih jenis pasien</option>
                    <option value="santri">Santri</option>
                    <option value="umum">Umum</option>
                </select>
            </div>

            <div class="form-group">
                <label>Nomor identitas</label>
                <input name="no_identitas">
            </div>

            <div class="form-group">
                <label>Alamat</label>
                <textarea name="alamat" rows="3"></textarea>
            </div>

            <div class="form-group">
                <label>Nomor HP</label>
                <input name="no_hp">
            </div>

            <div class="form-actions">
                <button class="button" type="submit">Simpan Pasien</button>
                <button class="button secondary" type="button"
                        onclick="tutupModal('modalTambah')">Batal</button>
            </div>
        </form>
    </div>
</div>

<!-- Form edit pasien -->
<div class="modal" id="modalEdit">
    <div class="modal-content">
        <h2>Edit Data Pasien</h2>

        <form id="formEdit" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Nama pasien *</label>
                <input id="edit_name" name="name" required>
            </div>

            <div class="form-group">
                <label>Email *</label>
                <input type="email" id="edit_email" name="email" required>
            </div>

            <div class="form-group">
                <label>Jenis pasien *</label>
                <select id="edit_jenis" name="jenis_pasien" required>
                    <option value="santri">Santri</option>
                    <option value="umum">Umum</option>
                </select>
            </div>

            <div class="form-group">
                <label>Nomor identitas</label>
                <input id="edit_identitas" name="no_identitas">
            </div>

            <div class="form-group">
                <label>Alamat</label>
                <textarea id="edit_alamat" name="alamat" rows="3"></textarea>
            </div>

            <div class="form-group">
                <label>Nomor HP</label>
                <input id="edit_hp" name="no_hp">
            </div>

            <div class="form-actions">
                <button class="button" type="submit">Simpan Perubahan</button>
                <button class="button secondary" type="button"
                        onclick="tutupModal('modalEdit')">Batal</button>
            </div>
        </form>
    </div>
</div>

<script>
    function bukaTambah() {
        document.getElementById('modalTambah').style.display = 'block';
    }

    function bukaEdit(button) {
        const id = button.dataset.id;

        document.getElementById('formEdit').action =
            "{{ url('/dokter/pasien') }}/" + id;

        document.getElementById('edit_name').value = button.dataset.name || '';
        document.getElementById('edit_email').value = button.dataset.email || '';
        document.getElementById('edit_jenis').value = button.dataset.jenis || 'umum';
        document.getElementById('edit_identitas').value = button.dataset.identitas || '';
        document.getElementById('edit_alamat').value = button.dataset.alamat || '';
        document.getElementById('edit_hp').value = button.dataset.hp || '';

        document.getElementById('modalEdit').style.display = 'block';
    }

    function tutupModal(id) {
        document.getElementById(id).style.display = 'none';
    }

    window.addEventListener('click', function(event) {
        if (event.target.classList.contains('modal')) {
            event.target.style.display = 'none';
        }
    });
</script>
</body>
</html>
