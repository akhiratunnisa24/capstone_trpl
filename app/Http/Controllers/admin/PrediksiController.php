<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Cuti;
use App\Models\Izin;
use App\Models\Karyawan;
use App\Models\PredictionHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class PrediksiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $role = Auth::user()->role;
        if ($role == 1  || $role == 2) {
            $karyawan = Karyawan::where('status_kerja','Aktif')->get();
            return view('admin.prediksi.index', compact('row','karyawan'));
        } else {
            return redirect()->back()->with('error', 'Anda tidak memiliki hak akses');
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'karyawan_id' => 'required|numeric|min:0',
            'status_karyawan' => 'required',
            'status_kerja' => 'required',
        ]);

        $query = Karyawan::query();

        if ($request->karyawan_id > 0) {
            $query->where('id', $request->karyawan_id);
        }

        $query->where('status_karyawan', $request->status_karyawan)
            ->where('status_kerja', $request->status_kerja);

        $karyawans = $query->get();

        if ($karyawans->isEmpty()) {
            return redirect()->back()->with('error', 'Karyawan tidak ditemukan.');
        }

        // Ambil data pendukung untuk masing-masing karyawan
        $idList = $karyawans->pluck('id');

        $absensi = Absensi::whereIn('id_karyawan', $idList)->get();
        $izin    = Izin::whereIn('id_karyawan', $idList)->where('status', 3)->where('id_jenisizin', 2)->get();
        $cuti    = Cuti::whereIn('id_karyawan', $idList)->where('status', 3)->get();
        $sakit   = Izin::whereIn('id_karyawan', $idList)->where('status', 3)->where('id_jenisizin', 1)->get();

        // Siapkan payload JSON ke FastAPI
        $payload = [
            'karyawan' => $karyawans->toArray() ?? [],
            'absensi'  => $absensi->toArray() ?? [],
            'izin'     => $izin->toArray() ?? [],
            'cuti'     => $cuti->toArray() ?? [],
            'sakit'    => $sakit->toArray() ?? [],
        ];

        try {
            // Kirim ke FastAPI
            $response = Http::timeout(20)->post('http://127.0.0.1:8000/predict-all', $payload);

            if ($response->successful()) {
                $hasil = $response->json();

                $lastPredictionNumber = PredictionHistory::max('prediction_number');
                $ke_berapa = ($lastPredictionNumber ?? 0) + 1;

                 foreach ($hasil as $data) {
                    // Hitung prediksi keberapa untuk karyawan ini

                    // Simpan ke tabel prediction_histories
                    PredictionHistory::create([
                        'id_karyawan'         => $data['id'],
                        'nama'                => $data['nama'],
                        'status_karyawan'     => $data['status_karyawan'],
                        'status_kerja'        => $data['status_kerja'],
                        'rasio_keterlambatan' => $data['rasio_keterlambatan'],
                        'rasio_pulang_cepat'  => $data['rasio_pulang_cepat'],
                        'total_hari_izin'     => $data['total_hari_izin'] ?? 0,
                        'total_hari_sakit'    => $data['total_hari_sakit'] ?? 0,
                        'jumlah_cuti'         => $data['jumlah_cuti'] ?? 0,
                        'resign_probability'  => $data['resign_probability'],
                        'risk_score'          => $data['risk_score'],
                        'prediksi_resign'     => $data['prediksi_resign'],
                        'prediction_number'   => $ke_berapa
                    ]);
                }

                return redirect()->back()->with('success', 'Prediksi berhasil diproses')->with('prediksi', $hasil);
            } else {
                return redirect()->back()->with('error', 'Gagal memproses prediksi dari FastAPI.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan koneksi ke FastAPI: ' . $e->getMessage());
        }
    }

    // Hitung jumlah keterlambatan dari absensi (contoh sederhana)
    private function calculateLateInstances($absensi)
    {
        $countLate = 0;
        foreach ($absensi as $record) {
            // Asumsikan kolom jadwal_masuk dan jam_masuk berbentuk string "HH:MM:SS"
            if (isset($record->jadwal_masuk, $record->jam_masuk)) {
                $jadwal = strtotime($record->jadwal_masuk);
                $masuk = strtotime($record->jam_masuk);

                if ($masuk > $jadwal) {
                    $countLate++;
                }
            }
        }
        return $countLate;
    }

    // Hitung jumlah pulang cepat dari absensi (contoh sederhana)
    private function calculateEarlyLeave($absensi)
    {
        $countEarly = 0;
        foreach ($absensi as $record) {
            // Asumsikan kolom jadwal_pulang dan jam_keluar berbentuk string "HH:MM:SS"
            if (isset($record->jadwal_pulang, $record->jam_keluar)) {
                $jadwal = strtotime($record->jadwal_pulang);
                $keluar = strtotime($record->jam_keluar);

                if ($keluar < $jadwal) {
                    $countEarly++;
                }
            }
        }
        return $countEarly;
    }
}

