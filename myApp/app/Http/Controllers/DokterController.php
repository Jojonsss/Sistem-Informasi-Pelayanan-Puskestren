<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DokterController extends Controller
{
    /**
     * Dashboard utama dokter.
     */
    public function dashboard()
    {
        $totalPasien = Pasien::count();

        $kunjunganHariIni = DB::table('kunjungans')
            ->whereDate('tanggal_kunjungan', today())
            ->count();

        $menunggu = DB::table('kunjungans')
            ->where('status', 'menunggu')
            ->count();

        $selesai = DB::table('kunjungans')
            ->where('status', 'selesai')
            ->count();

        $kunjunganTerbaru = DB::table('kunjungans as k')
            ->join('pasiens as p', 'p.id', '=', 'k.pasien_id')
            ->join('users as u', 'u.id', '=', 'p.user_id')
            ->select(
                'k.id',
                'u.name',
                'k.tanggal_kunjungan',
                'k.status',
                'k.keluhan'
            )
            ->orderByDesc('k.tanggal_kunjungan')
            ->limit(5)
            ->get();

        return view('dokter.dashboard', compact(
            'totalPasien',
            'kunjunganHariIni',
            'menunggu',
            'selesai',
            'kunjunganTerbaru'
        ));
    }

    /**
     * Daftar pasien, pencarian, dan filter.
     */
    public function pasien(Request $request)
    {
        
$query = DB::table('pasiens as p')
    ->join('users as u', 'u.id', '=', 'p.user_id')
    ->select(
    'p.id',
    'p.user_id',
    'p.jenis_pasien',
    'p.no_identitas',
    'p.alamat',
    'p.no_hp',
    'u.name',
    'u.email'
);
        if ($request->filled('cari')) {
            $cari = $request->cari;

            $query->where(function ($q) use ($cari) {
                $q->where('u.name', 'like', "%{$cari}%")
                  ->orWhere('p.no_identitas', 'like', "%{$cari}%")
                  ->orWhere('p.no_hp', 'like', "%{$cari}%");
            });
        }

        if ($request->filled('jenis_pasien')) {
            $query->where(
                'p.jenis_pasien',
                $request->jenis_pasien
            );
        }

        $pasiens = $query
            ->orderBy('u.name')
            ->paginate(10)
            ->withQueryString();

        return view('dokter.pasien.index', compact('pasiens'));
    }

    /**
     * Detail pasien beserta riwayat kunjungan.
     */
    public function detailPasien($id)
    {
        $pasien = DB::table('pasiens as p')
            ->join('users as u', 'u.id', '=', 'p.user_id')
            ->where('p.id', $id)
            ->select(
                'p.id',
                'p.jenis_pasien',
                'p.no_identitas',
                'p.alamat',
                'p.no_hp',
                'u.name'
            )
            ->first();

        abort_if(!$pasien, 404, 'Data pasien tidak ditemukan.');

        $kunjungans = DB::table('kunjungans')
    ->where('pasien_id', $id)
    ->select(
        'id',
        'tanggal_kunjungan',
        'keluhan',
        'status'
    )
    ->orderByDesc('tanggal_kunjungan')
    ->get();

        return view('dokter.pasien.detail', compact(
            'pasien',
            'kunjungans'
        ));
    }
    
    public function simpanPasien(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'jenis_pasien' => 'required|in:santri,umum',
            'no_identitas' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:20',
            'password' => 'required|string|min:8',
        ]);

        DB::transaction(function () use ($request) {
            $userId = DB::table('users')->insertGetId([
                'name' => $request->name,
                'email' => $request->email,
                'password' => \Illuminate\Support\Facades\Hash::make($request->password),
                'role' => 'pasien',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('pasiens')->insert([
                'user_id' => $userId,
                'jenis_pasien' => $request->jenis_pasien,
                'no_identitas' => $request->no_identitas,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });

        return redirect()->route('dokter.pasien')
            ->with('success', 'Data pasien berhasil ditambahkan.');
    }

    public function updatePasien(Request $request, $id)
    {
        $pasien = DB::table('pasiens')->where('id', $id)->first();

        abort_if(!$pasien, 404, 'Data pasien tidak ditemukan.');

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $pasien->user_id,
            'jenis_pasien' => 'required|in:santri,umum',
            'no_identitas' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:20',
        ]);

        DB::transaction(function () use ($request, $pasien) {
            DB::table('users')->where('id', $pasien->user_id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'updated_at' => now(),
            ]);

            DB::table('pasiens')->where('id', $pasien->id)->update([
                'jenis_pasien' => $request->jenis_pasien,
                'no_identitas' => $request->no_identitas,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'updated_at' => now(),
            ]);
        });

        return redirect()->route('dokter.pasien')
            ->with('success', 'Data pasien berhasil diperbarui.');
    }

    public function hapusPasien($id)
    {
        $pasien = DB::table('pasiens')->where('id', $id)->first();

        abort_if(!$pasien, 404, 'Data pasien tidak ditemukan.');

        $punyaKunjungan = DB::table('kunjungans')
            ->where('pasien_id', $id)
            ->exists();

        if ($punyaKunjungan) {
            return redirect()->route('dokter.pasien')
                ->with('error', 'Pasien memiliki riwayat kunjungan sehingga tidak dapat dihapus.');
        }

        DB::transaction(function () use ($pasien) {
            DB::table('pasiens')->where('id', $pasien->id)->delete();
            DB::table('users')->where('id', $pasien->user_id)->delete();
        });

        return redirect()->route('dokter.pasien')
            ->with('success', 'Data pasien berhasil dihapus.');
    }
    /**
     * Menampilkan daftar kunjungan untuk pemeriksaan.
     */
    public function pemeriksaan(Request $request)
{
    $request->validate([
        'status' => 'nullable|in:menunggu,diperiksa,selesai,dibatalkan',
        'tanggal' => 'nullable|date',
    ]);

    $query = DB::table('kunjungans as k')
        ->join('pasiens as p', 'p.id', '=', 'k.pasien_id')
        ->join('users as u', 'u.id', '=', 'p.user_id')
        ->leftJoin('pemeriksaans as pm', 'pm.kunjungan_id', '=', 'k.id')
        ->select(
            'k.id as kunjungan_id',
            'u.name',
            'k.tanggal_kunjungan',
            'k.keluhan',
            'k.status',
            'pm.id as pemeriksaan_id'
        );

    if ($request->filled('status')) {
        $query->where('k.status', $request->status);
    }

    if ($request->filled('tanggal')) {
        $query->whereDate('k.tanggal_kunjungan', $request->tanggal);
    }

    $kunjungans = $query
        ->orderByDesc('k.tanggal_kunjungan')
        ->get();

    return view('dokter.pemeriksaan.index', compact('kunjungans'));
}

    /**
     * Menyimpan hasil pemeriksaan pasien.
     */
   
public function simpanPemeriksaan(Request $request, $kunjunganId)
{
    $request->validate([
        'keluhan' => 'nullable|string',
        'riwayat_penyakit' => 'nullable|string',
        'hasil_pemeriksaan' => 'required|string',
    ]);

    $kunjungan = DB::table('kunjungans')
        ->where('id', $kunjunganId)
        ->first();

    abort_if(!$kunjungan, 404, 'Kunjungan tidak ditemukan.');
if (in_array($kunjungan->status, ['selesai', 'dibatalkan'])) {
    return redirect()->route('dokter.pemeriksaan')
        ->with('error', 'Kunjungan yang sudah selesai atau dibatalkan tidak dapat diperiksa kembali.');
}
    $data = [
        'keluhan' => $request->keluhan,
        'riwayat_penyakit' => $request->riwayat_penyakit,
        'hasil_pemeriksaan' => $request->hasil_pemeriksaan,
        'tanggal_periksa' => now(),
        'updated_at' => now(),
    ];

    DB::transaction(function () use ($kunjunganId, $data) {
        $sudahAda = DB::table('pemeriksaans')
            ->where('kunjungan_id', $kunjunganId)
            ->exists();

        if ($sudahAda) {
            DB::table('pemeriksaans')
                ->where('kunjungan_id', $kunjunganId)
                ->update($data);
        } else {
            $data['kunjungan_id'] = $kunjunganId;
            $data['created_at'] = now();

            DB::table('pemeriksaans')->insert($data);
        }

        DB::table('kunjungans')
            ->where('id', $kunjunganId)
            ->update([
                'status' => 'diperiksa',
                'updated_at' => now(),
            ]);
    });

    return redirect()->route('dokter.pemeriksaan')
        ->with('success', 'Hasil pemeriksaan berhasil disimpan.');
}
/**
 * Menampilkan daftar kunjungan untuk mencatat diagnosis.
 */
public function diagnosis()
{
    $kunjungans = DB::table('kunjungans as k')
        ->join('pasiens as p', 'p.id', '=', 'k.pasien_id')
        ->join('users as u', 'u.id', '=', 'p.user_id')
        ->leftJoin('pemeriksaans as pm', 'pm.kunjungan_id', '=', 'k.id')
        ->leftJoin('diagnoses as dg', 'dg.kunjungan_id', '=', 'k.id')
        ->select(
            'k.id as kunjungan_id',
            'u.name',
            'k.tanggal_kunjungan',
            'pm.hasil_pemeriksaan',
            'dg.id as diagnosis_id',
            'dg.diagnosis',
            'dg.tindakan',
            'dg.catatan'
        )
        ->orderByDesc('k.tanggal_kunjungan')
        ->get();

    return view('dokter.diagnosis.index', compact('kunjungans'));
}

/**
 * Menyimpan diagnosis pasien.
 */
public function simpanDiagnosis(Request $request, $kunjunganId)
{
    $request->validate([
        'diagnosis' => 'required|string',
        'tindakan' => 'nullable|string',
        'catatan' => 'nullable|string',
    ]);

    $pemeriksaan = DB::table('pemeriksaans')
        ->where('kunjungan_id', $kunjunganId)
        ->first();

    if (!$pemeriksaan) {
        return redirect()->route('dokter.diagnosis')
            ->with('error', 'Pasien harus menjalani pemeriksaan terlebih dahulu.');
    }

    $sudahAda = DB::table('diagnoses')
        ->where('kunjungan_id', $kunjunganId)
        ->exists();

    $data = [
        'diagnosis' => $request->diagnosis,
        'tindakan' => $request->tindakan,
        'catatan' => $request->catatan,
        'tanggal_diagnosis' => now(),
        'updated_at' => now(),
    ];

    if ($sudahAda) {
        DB::table('diagnoses')
            ->where('kunjungan_id', $kunjunganId)
            ->update($data);
    } else {
        $data['kunjungan_id'] = $kunjunganId;
        $data['created_at'] = now();

        DB::table('diagnoses')->insert($data);
    }

    DB::table('kunjungans')
        ->where('id', $kunjunganId)
        ->update([
            'status' => 'selesai',
            'updated_at' => now(),
        ]);

    return redirect()->route('dokter.diagnosis')
        ->with('success', 'Diagnosis berhasil disimpan.');
}

/**
 * Menampilkan riwayat kunjungan, pemeriksaan, dan diagnosis pasien.
 */
public function riwayat()
{
    $riwayat = DB::table('kunjungans as k')
        ->join('pasiens as p', 'p.id', '=', 'k.pasien_id')
        ->join('users as u', 'u.id', '=', 'p.user_id')
        ->leftJoin('pemeriksaans as pm', 'pm.kunjungan_id', '=', 'k.id')
        ->leftJoin('diagnoses as dg', 'dg.kunjungan_id', '=', 'k.id')
        ->select(
            'p.id as pasien_id',
            'u.name',
            'p.no_identitas',
            'k.id as kunjungan_id',
            'k.tanggal_kunjungan',
            'k.keluhan',
            'k.status',
            'pm.hasil_pemeriksaan',
            'pm.riwayat_penyakit',
            'dg.diagnosis',
            'dg.tindakan',
            'dg.catatan',
            'dg.tanggal_diagnosis'
        )
        ->orderByDesc('k.tanggal_kunjungan')
        ->get();

    return view('dokter.riwayat.index', compact('riwayat'));
}


}
