<?php

namespace App\Http\Controllers\admin;

use DateTime;
use TADPHP\TAD;
use Carbon\Carbon;
use App\Models\Mesin;
use App\Models\Jadwal;
use TADPHP\TADFactory;
use App\Models\Absensi;
use App\Models\Listmesin;
use App\Models\UserMesin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MesinController extends Controller
{
    public function tarikAbsen()
    {
        try {
            $listmesin = Listmesin::where('partner',Auth::user()->partner)->first();
            $ip = $listmesin->ip_mesin;
            $com_key = $listmesin->comm_key;
            $partner = $listmesin->partner;
            $port = $listmesin->port;
            $tad = (new TADFactory(['ip' => $ip, 'com_key' => $com_key,'soap_port' => $port]))->get_instance();
            $con = $tad->is_alive();
            if ($con) 
            {
                $attendance = $tad->get_att_log();
                if ($attendance) {
                    // $today = Carbon::now()->format('Y-m-d');
                    // $filtered_attendance = $attendance->filter_by_date(
                    //     ['start' => $today]
                    // );
                    // $filtered_attendance = $attendance->filter_by_date(
                    //     ['start' => '2023-03-01','end' => '2014-03-31']
                    // );
                    // $j = $filtered_attendance->get_response(['format' => 'json']);
                    $j = $attendance->get_response(['format' => 'json']);
                    $jArray = json_decode($j, true);
                    // dd($jArray);

                    $usermesin = UserMesin::where('partner',$partner)->get();
                
                    // Loop melalui data $jArray untuk mencocokkan nilai PIN
                    foreach ($jArray['Row'] as $data) 
                    {
                        $pin = $data['PIN'];
                        $datetime = Carbon::parse($data['DateTime']);
                        $tanggal = $datetime->format('Y-m-d');
                        $jam = $datetime->format('H:i:s');
                         
                        // $matchedUser = $usermesin->where('noid', $pin)->where('partner', $partner)->first();
                        $matchedUser = $usermesin->where('partner', $partner)->where('noid', $pin)->first();
                       
                        if (isset($matchedUser)) 
                        {
                            $jadwals = Jadwal::where('tanggal', $tanggal)
                                ->where('partner', $partner)
                                ->get();
                            // dd($data,$matchedUser,$jadwal);
                            foreach ($jadwals as $jadwal) 
                            {
                                if($jadwal)
                                {
                                    $existingAbsensi = Absensi::where('id_karyawan', $matchedUser->id_pegawai)
                                                    ->where('tanggal', $tanggal)
                                                    ->where('partner', $matchedUser->partner)
                                                    ->where('jam_masuk','!=',$jam)
                                                    ->first();
                                    // return $existingAbsensi;
                                    if($existingAbsensi)
                                    {
                                        if ($existingAbsensi->jam_keluar != $jam) 
                                        {
                                            $jadwal_masuk  = $jadwal->jadwal_masuk;
                                            $jadwal_pulang = $jadwal->jadwal_pulang;
                                            $jam_keluar    = Carbon::createFromFormat('H:i:s', $jam);

                                            //jika data ada lakukan pembaruan data, karena ada absensi yang terdapat 2 record data
                                            $absensi = $existingAbsensi;
                                            $absensi->jam_keluar   = $jam_keluar;
    
                                            //menghitung jumlah jam kerja
                                            $jam_masuk    = Carbon::createFromFormat('H:i:s', $existingAbsensi->jam_masuk);
                                            $jadwal_pulang = Carbon::createFromFormat('H:i:s', $jadwal_pulang);

                                            $jmlhadir           = $jam_keluar->diff($jam_masuk);
                                            $total_jmlhadir     = ($jmlhadir->h * 60) + $jmlhadir->i;
                                            $absensi->jam_kerja =  $jmlhadir->format('%H:%I:%S');

                                            if($jam_keluar < $jadwal_pulang)
                                            {
                                                $plgcpt = $jadwal_pulang->diff($jam_keluar);

                                                $telatMinutes = ($plgcpt->h * 60) + $plgcpt->i; // Konversi jam ke menit

                                                if ($telatMinutes > 0)
                                                {
                                                    $plgcpt  = $plgcpt->format('%H:%I:%S');
                                                }
                                                elseif($jam_keluar < "12:00:00")
                                                {
                                                    $plgcpt = null;
                                                }
                                                else {
                                                    $plgcpt = null;
                                                }
                                            }
                                            elseif($jam_keluar > $jadwal_pulang)
                                            {
                                                $plgcpt     = null;
                                            }

                                            $absensi->plg_cepat = $plgcpt;

                                            if($jam_masuk <= $jadwal_masuk && $jam_keluar >= $jadwal_pulang)
                                            {

                                                $jml_jamkerja = $jadwal_pulang->diff($jadwal_masuk);
                                                $absensi->jml_jamkerja = $jml_jamkerja->format('%H:%I:%S');
                                                
                                                //lembur 
                                                $lembur = $jam_keluar->diff($jadwal_pulang);
                                                $absensi->lembur = $lembur->format('%H:%I:%S');
                                            }
                                            elseif($jam_masuk < $jadwal_masuk && $jam_keluar < $jadwal_pulang)
                                            {//pulangcepat
                                                $jml_jamkerja = $jam_keluar->diff($jam_masuk);
                                                $total_minutes = ($jml_jamkerja->h * 60) + $jml_jamkerja->i;

                                                if ($total_minutes < 540 || $total_jmlhadir < $total_minutes) { // 9 jam = 540 menit
                                                    $jml_jamkerja = $absensi->jam_kerja;
                                                } else {
                                                    $jml_jamkerja = $jml_jamkerja->format('%H:%I:%S');
                                                }

                                                $absensi->jml_jamkerja = $jml_jamkerja;
                                                $absensi->lembur = null;   
                                            }
                                            elseif($jam_masuk > $jadwal_masuk && $jam_keluar < $jadwal_pulang)
                                            {
                                                $jml_jamkerja = $jadwal_pulang->diff($jam_masuk);
                                                $absensi->jml_jamkerja = $jml_jamkerja->format('%H:%I:%S');

                                                $absensi->lembur = null;
                                            
                                            }
                                            elseif($jam_masuk > $jadwal_masuk && $jam_keluar > $jadwal_pulang)
                                            {
                                                $lembur = $jam_keluar->diff($jadwal_pulang);
                                                $absensi->lembur = $lembur->format('%H:%I:%S');

                                                $jml_jamkerja = $jadwal_pulang->diff($jadwal_masuk);
                                                $absensi->jml_jamkerja = $jml_jamkerja->format('%H:%I:%S');
                                            
                                            }

                                            $absensi->update();
                                        }
                                        else if($existingAbsensi->jam_keluar == $jam)
                                        {
                                            $absensi = $existingAbsensi;
                                        }
                                    }
                                    else
                                    {
                                        $jadwal_masuk  = $jadwal->jadwal_masuk;
                                        $jadwal_masuk     = Carbon::createFromFormat('H:i:s', $jadwal_masuk);

                                        $jadwal_pulang = $jadwal->jadwal_pulang;
                                        $jam_masuk     = Carbon::createFromFormat('H:i:s', $jam);
                            
                                        if($jam_masuk > $jadwal_masuk)
                                        {
                                            $telat = $jadwal_masuk->diff($jam_masuk);

                                            $telatMinutes = ($telat->h * 60) + $telat->i; // Konversi jam ke menit

                                            if ($telatMinutes > 0) {
                                                $terlambat  = $telat->format('%H:%I:%S');
                                            } else {
                                                $terlambat = null;
                                            }
                                        }
                                        elseif($jam_masuk < $jadwal_masuk)
                                        {
                                            $terlambat     = null;
                                        }
                                        
                                        if(!Absensi::where('id_karyawan',$matchedUser->id_pegawai)->where('tanggal',$tanggal)->where('partner',$matchedUser->partner)->exists())
                                        {
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
                                            $absensi->partner       = $matchedUser->partner;
                                            $absensi->save();
                                        }
                                    }
                                }
                            }
                        }
                        else
                        {
                            $matchedUser = $usermesin->where('noid2', $pin)->where('noid2','!=', null)->where('partner', $partner)->first();
                            // dd($matchedUser);
                            if (isset($matchedUser)) 
                            {
                                $jadwals = Jadwal::where('tanggal', $tanggal)
                                    ->where('partner', $partner)
                                    ->get();
                                // dd($data,$matchedUser,$jadwal);
                                foreach ($jadwals as $jadwal) 
                                {
                                    if($jadwal)
                                    {
                                        $existingAbsensi = Absensi::where('id_karyawan', $matchedUser->id_pegawai)
                                                        ->where('tanggal', $tanggal)
                                                        ->where('partner', $matchedUser->partner)
                                                        ->where('jam_masuk','!=',$jam)
                                                        ->first();
                                        if($existingAbsensi)
                                        {
                                            return $existingAbsensi;
                                            if ($existingAbsensi->jam_keluar != $jam) 
                                            {
                                                $jadwal_masuk  = $jadwal->jadwal_masuk;
                                                $jadwal_pulang = $jadwal->jadwal_pulang;
                                                $jam_keluar    = Carbon::createFromFormat('H:i:s', $jam);

                                                //jika data ada lakukan pembaruan data, karena ada absensi yang terdapat 2 record data
                                                $absensi = $existingAbsensi;
                                                $absensi->jam_keluar   = $jam_keluar;
            
                                                //menghitung jumlah jam kerja
                                                $jam_masuk    = Carbon::createFromFormat('H:i:s', $existingAbsensi->jam_masuk);
                                                $jadwal_pulang = Carbon::createFromFormat('H:i:s', $jadwal_pulang);

                                                $jmlhadir           = $jam_keluar->diff($jam_masuk);
                                                $total_jmlhadir     = ($jmlhadir->h * 60) + $jmlhadir->i;
                                                $absensi->jam_kerja =  $jmlhadir->format('%H:%I:%S');

                                                if($jam_keluar < $jadwal_pulang)
                                                {
                                                    $plgcpt = $jadwal_pulang->diff($jam_keluar);

                                                    $telatMinutes = ($plgcpt->h * 60) + $plgcpt->i; // Konversi jam ke menit

                                                    if ($telatMinutes > 0)
                                                    {
                                                        $plgcpt  = $plgcpt->format('%H:%I:%S');
                                                    }
                                                    elseif($jam_keluar < "12:00:00")
                                                    {
                                                        $plgcpt = null;
                                                    }
                                                    else {
                                                        $plgcpt = null;
                                                    }
                                                }
                                                elseif($jam_keluar > $jadwal_pulang)
                                                {
                                                    $plgcpt     = null;
                                                }

                                                $absensi->plg_cepat = $plgcpt;
        
                                                if($jam_masuk <= $jadwal_masuk && $jam_keluar >= $jadwal_pulang)
                                                {
        
                                                    $jml_jamkerja = $jadwal_pulang->diff($jadwal_masuk);
                                                    $absensi->jml_jamkerja = $jml_jamkerja->format('%H:%I:%S');
                                                    
                                                    //lembur 
                                                    $lembur = $jam_keluar->diff($jadwal_pulang);
                                                    $absensi->lembur = $lembur->format('%H:%I:%S');


                                                }
                                                elseif($jam_masuk < $jadwal_masuk && $jam_keluar < $jadwal_pulang)
                                                {//pulangcepat
                                                    $jml_jamkerja = $jam_keluar->diff($jam_masuk);
                                                    $total_minutes = ($jml_jamkerja->h * 60) + $jml_jamkerja->i;

                                                    if ($total_jmlhadir < $total_minutes) { // 9 jam = 540 menit
                                                        $jml_jamkerja = $absensi->jam_kerja;
                                                    } else {
                                                        $jml_jamkerja = $jml_jamkerja->format('%H:%I:%S');
                                                    }
                                                    $absensi->jml_jamkerja = $jml_jamkerja;
                                                    $absensi->lembur = null;
                                                    
                                                    // dd($absensi,$absensi->jml_jamkerja);
                                                }
                                                elseif($jam_masuk > $jadwal_masuk && $jam_keluar < $jadwal_pulang)
                                                {
                                                    $jml_jamkerja = $jadwal_pulang->diff($jam_masuk);
                                                    $absensi->jml_jamkerja = $jml_jamkerja->format('%H:%I:%S');

                                                    $absensi->lembur = null;
                                                
                                                }
                                                elseif($jam_masuk > $jadwal_masuk && $jam_keluar > $jadwal_pulang)
                                                {
                                                    $lembur = $jam_keluar->diff($jadwal_pulang);
                                                    $absensi->lembur = $lembur->format('%H:%I:%S');

                                                    $jml_jamkerja = $jadwal_pulang->diff($jadwal_masuk);
                                                    $absensi->jml_jamkerja = $jml_jamkerja->format('%H:%I:%S');
                                                
                                                }

                                                $absensi->update();
                                            }
                                            else if($existingAbsensi->jam_keluar == $jam)
                                            {
                                                $absensi = $existingAbsensi;
                                            }
                                        }
                                        else
                                        {
                                            $jadwal_masuk  = $jadwal->jadwal_masuk;
                                            $jadwal_masuk     = Carbon::createFromFormat('H:i:s', $jadwal_masuk);

                                            $jadwal_pulang = $jadwal->jadwal_pulang;
                                            $jam_masuk     = Carbon::createFromFormat('H:i:s', $jam);
                                          
                                            //menghitung keterlambatan karyawan
                                
                                            if($jam_masuk > $jadwal_masuk)
                                            {
                                                $telat = $jadwal_masuk->diff($jam_masuk);

                                                $telatMinutes = ($telat->h * 60) + $telat->i; // Konversi jam ke menit

                                                if ($telatMinutes > 0) {
                                                    $terlambat  = $telat->format('%H:%I:%S');
                                                } else {
                                                    $terlambat = null;
                                                }
                                            }
                                            elseif($jam_masuk < $jadwal_masuk)
                                            {
                                                $terlambat     = null;
                                            }
                                            
                                            if(!Absensi::where('id_karyawan',$matchedUser->id_pegawai)->where('tanggal',$tanggal)->where('partner',$matchedUser->partner)->exists())
                                            {
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
                                                $absensi->partner       = $matchedUser->partner;
                                                $absensi->save();
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
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
