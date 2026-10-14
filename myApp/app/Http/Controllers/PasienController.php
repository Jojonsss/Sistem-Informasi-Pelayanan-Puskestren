<?php

namespace App\Http\Controllers;

use App\Models\Antrean;
use App\Models\Dokter;
use App\Models\Kunjungan;
use App\Models\Pasien;
use App\Models\Poli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PasienController extends Controller
{
    /**
     * Mengambil profil pasien berdasarkan akun yang sedang login.
     */
    private function profilPasien(): Pasien
    {
        $user = auth()->user();

        if (!$user) {
            abort(401, 'Silakan login terlebih dahulu.');
        }

        $pasien = Pasien::where('user_id', $user->id_user)->first();

        if (!$pasien) {
            abort(
                404,
                'Profil pasien belum terhubung dengan akun ini. Hubungi administrator.'
            );
        }

        return $pasien;
    }

    /**
     * Dashboard pasien.
     */
    public function dashboard()
    {
        $pasien = $this->profilPasien();

        $totalKunjungan = Kunjungan::where(
            'id_pasien',
            $pasien->id_pasien
        )->count();

        $antreanAktif = Antrean::whereHas(
            'kunjungan',
            fn ($q) => $q->where(
                'id_pasien',
                $pasien->id_pasien
            )
        )
            ->whereIn('status', ['menunggu', 'dipanggil'])
            ->with(['kunjungan.poli', 'kunjungan.dokter'])
            ->latest('id_antrean')
            ->first();

        return view('pasien.dashboard', compact(
            'pasien',
            'totalKunjungan',
            'antreanAktif'
        ));
    }

    /**
     * Menampilkan formulir pendaftaran kunjungan.
     */
    public function createKunjungan()
    {
        $pasien = $this->profilPasien();

        $polis = Poli::orderBy('nama_poli')->get();

        $dokters = Dokter::with('poli')
            ->orderBy('nama')
            ->get();

        return view('pasien.pendaftaran', compact(
            'pasien',
            'polis',
            'dokters'
        ));
    }

    /**
     * Menyimpan pendaftaran dan membuat nomor antrean.
     */
    public function storeKunjungan(Request $request)
    {
        $pasien = $this->profilPasien();

        $data = $request->validate([
            'id_poli' => [
                'required',
                'integer',
                'exists:polis,id_poli',
            ],
            'id_dokter' => [
                'required',
                'integer',
                'exists:dokters,id_dokter',
            ],
            'tanggal' => [
                'required',
                'date',
                'after_or_equal:today',
            ],
            'keluhan_awal' => [
                'required',
                'string',
                'max:2000',
            ],
        ]);

        $dokterSesuaiPoli = Dokter::where(
            'id_dokter',
            $data['id_dokter']
        )
            ->where('id_poli', $data['id_poli'])
            ->exists();

        if (!$dokterSesuaiPoli) {
            return back()
                ->withErrors([
                    'id_dokter' =>
                        'Dokter tidak sesuai dengan poli yang dipilih.',
                ])
                ->withInput();
        }

        DB::transaction(function () use ($data, $pasien) {
            $kunjungan = Kunjungan::create([
                'id_pasien' => $pasien->id_pasien,
                'id_dokter' => $data['id_dokter'],
                'id_poli' => $data['id_poli'],
                'tanggal' => $data['tanggal'],
                'keluhan_awal' => $data['keluhan_awal'],
                'status' => 'terdaftar',
            ]);

            $nomorBerikutnya = Antrean::whereHas(
                'kunjungan',
                fn ($q) => $q
                    ->where('id_poli', $data['id_poli'])
                    ->whereDate('tanggal', $data['tanggal'])
            )->count() + 1;

            Antrean::create([
                'id_kunjungan' => $kunjungan->id_kunjungan,
                'nomor_antrean' => $nomorBerikutnya,
                'status' => 'menunggu',
            ]);
        });

        return redirect()
            ->route('pasien.antrean')
            ->with('success', 'Pendaftaran kunjungan berhasil.');
    }

    /**
     * Menampilkan daftar antrean pasien.
     */
    public function antrean()
    {
        $pasien = $this->profilPasien();

        $antreans = Antrean::whereHas(
            'kunjungan',
            fn ($q) => $q->where(
                'id_pasien',
                $pasien->id_pasien
            )
        )
            ->with(['kunjungan.poli', 'kunjungan.dokter'])
            ->latest('id_antrean')
            ->get();

        return view('pasien.antrean', compact('antreans'));
    }

    /**
     * Menampilkan riwayat kunjungan pasien.
     */
    public function riwayat()
    {
        $pasien = $this->profilPasien();

        $kunjungans = Kunjungan::where(
            'id_pasien',
            $pasien->id_pasien
        )
            ->with(['poli', 'dokter', 'antrean'])
            ->orderByDesc('tanggal')
            ->get();

        return view('pasien.riwayat', compact('kunjungans'));
    }

    /**
     * Endpoint untuk memeriksa status antrean.
     */
    public function statusAntrean()
    {
        $pasien = $this->profilPasien();

        $antreans = Antrean::whereHas(
            'kunjungan',
            fn ($q) => $q->where(
                'id_pasien',
                $pasien->id_pasien
            )
        )
            ->with(['kunjungan.poli', 'kunjungan.dokter'])
            ->whereIn('status', ['menunggu', 'dipanggil'])
            ->get();

        return response()->json($antreans);
    }
}
