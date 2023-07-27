<?php

namespace App\Http\Controllers\admin;

use TADPHP\TAD;
use Carbon\Carbon;
use App\Models\Mesin;
use App\Models\Shift;
use TADPHP\TADFactory;
use App\Models\Absensi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MesinController extends Controller
{
    public function tarikAbsen()
    {
        try {
            $ip = '192.168.1.8';
            $com_key = 0;

            // Membuat instance TAD menggunakan TADFactory
            $tad = (new TADFactory(['ip' => $ip, 'com_key' => $com_key]))->get_instance();

            $con = $tad->is_alive();

            if ($con) {
                $attendance = $tad->get_att_log();
                if ($attendance) {
                    $user = $tad->get_user_info();
                    // $u = $user->get_response(['format' => 'json']);
                    $j = $attendance->get_response(['format' => 'json']);
                    $jArray = json_decode($j, true);
                    $usermesin = Mesin::all();
                    $shift = Shift::all();

                    
                    // Loop melalui data $jArray untuk mencocokkan nilai PIN
                    foreach ($jArray['Row'] as $data) {
                        $pin = $data['PIN'];
                        $datetime = Carbon::parse($data['DateTime']);
                        $tanggal = $datetime->format('Y-m-d');
                        $jam = $datetime->format('H:i:s');

                        // Cari data di $usermesin berdasarkan PIN
                        $matchedUser = $usermesin->where('pin', $pin)->first();

                        if ($matchedUser) {
                            // Jika ada data yang cocok, simpan ke dalam tabel absensi
                            $absensi = new Absensi();
        
                            $absensi->id_karyawan = $matchedUser->id_pegawai;
                            $absensi->nik = $matchedUser->nik;
                            $absensi->tanggal = $tanggal;
                            $absensi->shift = null;
                            $absensi->jadwal_masuk = '08:00';
                            $absensi->jadwal_pulang = '17:00';
                            $absensi->jam_masuk = $matchedUser-
                            $absensi->jam_keluar = null;
                            $absensi->normal = '1';
                            $absensi->riil = '0';
                            $absensi->terlambat = $tl;
                            $absensi->plg_cepat = null;
                            $absensi->absent = null;
                            $absensi->lembur = null;
                            $absensi->jml_jamkerja = null;
                            $absensi->pengecualian = null;
                            $absensi->hci = 'True';
                            $absensi->hco = 'True';
                            $absensi->id_departement = $matchedUser->departemen;
                            $absensi->h_normal = 0;
                            $absensi->ap = 0;
                            $absensi->hl = 0;
                            $absensi->jam_kerja = $tl;
                            $absensi->lemhanor = 0;
                            $absensi->lemakpek = 0;
                            $absensi->lemhali = 0;
        
                            $absensi->save();
                        }
                    }
                    // Mengembalikan data dalam format JSON
                    return response()->json([$j]);

                } else {
                    return "Tidak ada data kehadiran.\n";
                }
            } else {
                return 'Koneksi ke ' . $ip . ' Gagal';
            }
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage() . "\n";
        }
    }
}
