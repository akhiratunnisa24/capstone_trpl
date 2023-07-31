<?php

namespace App\Http\Controllers\admin;

use DateTime;
use TADPHP\TAD;
use Carbon\Carbon;
use App\Models\Mesin;
use App\Models\Jadwal;
use TADPHP\TADFactory;
use App\Models\Absensi;
use App\Http\Controllers\Controller;

class MesinController extends Controller
{
    public function tarikAbsen()
    {
        try {
            $ip = '192.168.1.8';
            $com_key = 0;
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
                    
                    // Loop melalui data $jArray untuk mencocokkan nilai PIN
                    foreach ($jArray['Row'] as $data) 
                    {
                        $pin = $data['PIN'];
                        $datetime = Carbon::parse($data['DateTime']);
                        $tanggal = $datetime->format('Y-m-d');
                        $jam = $datetime->format('H:i:s');

                        // Cari data di $usermesin berdasarkan PIN
                        $matchedUser = $usermesin->where('pin', $pin)->first();

                        if ($matchedUser) 
                        {
                            $jadwals = Jadwal::where('tanggal', $tanggal)->get();
                            // dd($data,$matchedUser,$jadwal);
                            foreach ($jadwals as $jadwal) 
                            {
                                if($jadwal)
                                {
                                    $existingAbsensi = Absensi::where('id_karyawan', $matchedUser->id_pegawai)
                                                    ->where('tanggal', $tanggal)->whereNotNull('jam_masuk')->first();
                                    if($existingAbsensi)
                                    {
                                        $jadwal_masuk  = $jadwal->jadwal_masuk;
                                        $jadwal_pulang = $jadwal->jadwal_pulang;
                                        $jam_keluar    = Carbon::createFromFormat('H:i:s', $jam);
    
                                        //menghitung jumlah jam kerja
                                        $jam_masuk    = Carbon::createFromFormat('H:i:s', $existingAbsensi->jam_masuk);
                                        $jadwalpulang = Carbon::createFromFormat('H:i:s', $jadwal_pulang);
                                        $jumkerja     = $jadwalpulang->diff($jam_masuk);
                                        $jamkerja     = $jumkerja->format('%H:%I:%S');
    
                                        //jumlah kehadiran
                                        $jmlhadir        =  $jam_keluar->diff($jadwal_masuk);
                                        $jumlahkehadiran = $jmlhadir->format('%H:%I:%S');
                                        
    
                                        
                                        //jika data ada lakukan pembaruan data, karena ada absensi yang terdapat 2 record data
                                        $absensi = $existingAbsensi;
                                        $absensi->jam_keluar   = $jam_keluar;
    
                                        if($jam_keluar < $jadwal_pulang)
                                        {
                                            //menghitung plg cepat
                                            $selisih       = $jam_keluar->diff($jadwal_pulang);
                                            $plgcepat      = $selisih->format('%H:%I:%S');
                                            $absensi->plg_cepat = $plgcepat;
                                        }
                                        elseif($jam_keluar >= $jadwal_pulang)
                                        {
                                            $absensi->plg_cepat = null;
                                        }
                                        else{
                                            $absensi->plg_cepat = null;
                                        }
    
    
                                        if($jam_masuk >= $jadwal_masuk)
                                        {
                                            $absensi->jml_jamkerja = $jamkerja;
                                        }
                                        elseif($jam_masuk < $jadwal_masuk)
                                        {
                                            $absensi->jml_jamkerja = '09:00:00';
                                        }
                                        else{
                                            $absensi->jml_jamkerja = null;
                                        }
    
                                        $absensi->jam_kerja    = $jumlahkehadiran;
                                        
                                        // dd($absensi);
                                        $absensi->update();
                                    }
                                    else
                                    {
                                        $jadwal_masuk  = $jadwal->jadwal_masuk;
                                        $jadwal_pulang = $jadwal->jadwal_pulang;
                                        $jam_masuk     = Carbon::createFromFormat('H:i:s', $jam);
                                        //menghitung keterlambatan karyawan
                            
                                        $telat         = $jam_masuk->diff($jadwal_masuk);
                                        $terlambat     = $telat->format('%H:%I:%S');
                                        
                                         $absensi = new Absensi();
                                                    
                                         $absensi->id_karyawan   = $matchedUser->id_pegawai;
                                         $absensi->nik           = $matchedUser->nik;
                                         $absensi->tanggal       = $tanggal;
                                         $absensi->shift         = null;
                                         $absensi->jadwal_masuk  = $jadwal_masuk;
                                         $absensi->jadwal_pulang = $jadwal_pulang;
                                         $absensi->jam_masuk     = $jam;
                                         $absensi->jam_keluar    = null;
                                         $absensi->terlambat     = $terlambat;
                                         $absensi->plg_cepat     = null;
                                         $absensi->absent        = null;
                                         $absensi->lembur        = null;
                                         $absensi->jml_jamkerja  = null;
                                         $absensi->id_departement = $matchedUser->departemen;
                                         $absensi->jam_kerja     = null;
                                        $absensi->save();
                                        
                                    }
                                   
                                }else{
                                    ///
                                }
                            }
                           
                           
                        }
                        else{
                            //jika data tidak cocok skip
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
