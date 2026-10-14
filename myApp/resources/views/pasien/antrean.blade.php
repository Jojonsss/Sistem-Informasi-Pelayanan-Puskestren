<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Antrean Saya</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f3f4f6;
            padding: 25px;
            color: #1f2937;
        }

        .card {
            max-width: 850px;
            margin: auto;
            padding: 24px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px #0000000d;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            text-align: left;
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        .notice {
            padding: 14px;
            margin: 16px 0;
            border-radius: 8px;
            background: #eff6ff;
        }

        .called {
            background: #dcfce7;
            color: #166534;
            font-weight: bold;
        }

        button {
            padding: 10px 14px;
            border: 0;
            border-radius: 8px;
            background: #2563eb;
            color: white;
            cursor: pointer;
            margin: 5px 0;
        }

        @media (max-width: 600px) {
            body { padding: 10px; }
            .card { padding: 14px; overflow-x: auto; }
            th, td { padding: 8px; }
        }
    </style>
</head>
<body>
<div class="card">
    <h1>Antrean Saya</h1>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <div class="notice" id="notification-status">
        Aktifkan notifikasi agar kamu mendapat pemberitahuan saat antrean dipanggil.
        <br>
        <button type="button" id="enable-notifications">
            Aktifkan Notifikasi
        </button>
        <button type="button" id="enable-sound">
            Aktifkan Suara
        </button>
        <p id="message" aria-live="polite">
            Status notifikasi belum diperiksa.
        </p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nomor</th>
                <th>Tanggal</th>
                <th>Poli</th>
                <th>Dokter</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody id="queue-table">
        @forelse ($antreans as $antrean)
            <tr>
                <td>{{ $antrean->nomor_antrean }}</td>
                <td>{{ $antrean->kunjungan?->tanggal?->format('d-m-Y') }}</td>
                <td>{{ $antrean->kunjungan?->poli?->nama_poli }}</td>
                <td>{{ $antrean->kunjungan?->dokter?->nama }}</td>
                <td>{{ ucfirst($antrean->status) }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5">Belum ada data antrean.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <p><a href="{{ route('pasien.dashboard') }}">Kembali ke Dashboard</a></p>
</div>

<script>
(() => {
    const statusUrl = @json(route('pasien.status-antrean'));
    const message = document.getElementById('message');
    const notificationButton = document.getElementById('enable-notifications');
    const soundButton = document.getElementById('enable-sound');

    let soundEnabled = false;
    let audioContext = null;
    let previousStatuses = new Map();
    let initialized = false;
    let checking = false;

    function showMessage(text) {
        message.textContent = text;
    }

    async function enableNotifications() {
        if (!('Notification' in window)) {
            showMessage('Browser ini tidak mendukung notifikasi.');
            return;
        }

        try {
            const permission = await Notification.requestPermission();

            if (permission === 'granted') {
                showMessage('Notifikasi browser sudah diizinkan.');
            } else {
                showMessage('Izin notifikasi belum diberikan. Periksa pengaturan browser.');
            }
        } catch (error) {
            showMessage('Notifikasi gagal diaktifkan pada browser ini.');
        }
    }

    async function enableSound() {
        const AudioContextClass = window.AudioContext || window.webkitAudioContext;

        if (!AudioContextClass) {
            showMessage('Browser ini tidak mendukung pemutaran suara otomatis.');
            return;
        }

        try {
            audioContext = audioContext || new AudioContextClass();
            await audioContext.resume();
            soundEnabled = true;
            playAlert();
            showMessage('Suara aktif. Pastikan volume HP tidak dimatikan.');
        } catch (error) {
            showMessage('Suara tidak bisa diaktifkan. Coba tekan tombol lagi.');
        }
    }

    function playAlert() {
        if (!soundEnabled || !audioContext) return;

        try {
            if (audioContext.state !== 'running') return;

            [0, 0.35].forEach((delay) => {
                const oscillator = audioContext.createOscillator();
                const gain = audioContext.createGain();

                oscillator.type = 'sine';
                oscillator.frequency.value = 880;
                gain.gain.setValueAtTime(0.0001, audioContext.currentTime + delay);
                gain.gain.exponentialRampToValueAtTime(
                    0.25,
                    audioContext.currentTime + delay + 0.03
                );
                gain.gain.exponentialRampToValueAtTime(
                    0.0001,
                    audioContext.currentTime + delay + 0.22
                );

                oscillator.connect(gain);
                gain.connect(audioContext.destination);
                oscillator.start(audioContext.currentTime + delay);
                oscillator.stop(audioContext.currentTime + delay + 0.23);
            });
        } catch (error) {
            // Notifikasi visual tetap berjalan jika suara tidak tersedia.
        }
    }

    function notifyCalled(item) {
        const text = 'Nomor antrean ' + item.nomor_antrean +
            ' sedang dipanggil' +
            (item.poli ? ' di ' + item.poli : '') + '.';

        showMessage(text);

        if ('vibrate' in navigator) {
            navigator.vibrate([300, 150, 300]);
        }

        playAlert();

        if ('Notification' in window && Notification.permission === 'granted') {
            try {
                new Notification('Antrean Anda Dipanggil', {
                    body: text,
                    tag: 'antrean-' + item.id_antrean
                });
            } catch (error) {
                // Pesan pada halaman tetap ditampilkan.
            }
        }
    }

    async function checkQueue() {
        if (checking) return;
        checking = true;

        try {
            const response = await fetch(statusUrl, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                cache: 'no-store',
                credentials: 'same-origin'
            });

            if (!response.ok) {
                throw new Error('Gagal mengambil status antrean.');
            }

            const data = await response.json();
            const items = Array.isArray(data)
                ? data
                : (Array.isArray(data.antreans) ? data.antreans : []);

            const currentStatuses = new Map();

            items.forEach((item) => {
                const id = String(item.id_antrean ?? item.id ?? '');
                if (!id) return;

                const status = String(item.status ?? '').toLowerCase();
                currentStatuses.set(id, status);

                if (status === 'dipanggil') {
                    if (initialized && previousStatuses.get(id) !== 'dipanggil') {
                        notifyCalled(item);
                    }
                }
            });

            previousStatuses = currentStatuses;
            initialized = true;
        } catch (error) {
            showMessage('Belum bisa memperbarui antrean. Akan dicoba kembali.');
        } finally {
            checking = false;
        }
    }

    notificationButton.addEventListener('click', enableNotifications);
    soundButton.addEventListener('click', enableSound);

    checkQueue();
    setInterval(checkQueue, 5000);
})();
</script>
</body>
</html>