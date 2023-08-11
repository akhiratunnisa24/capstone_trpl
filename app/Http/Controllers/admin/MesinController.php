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
            if ($con) {
                $attendance = $tad->get_att_log();
                // return $attendance;
                if ($attendance) {
                    // $today = Carbon::now()->format('Y-m-d');
                    // $filtered_attendance = $attendance->filter_by_date(
                    //     ['start' => $today]
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
                         
                        $matchedUser = $usermesin->where('noid', $pin)->first();
                       
                        if (isset($matchedUser)) 
                        {
                            $jadwals = Jadwal::where('tanggal', $tanggal)->where('partner', Auth::user()->partner)->get();
                            // dd($data,$matchedUser,$jadwal);
                            foreach ($jadwals as $jadwal) 
                            {
                                if($jadwal)
                                {
                                    $existingAbsensi = Absensi::where('id_karyawan', $matchedUser->id_pegawai)
                                                    ->where('tanggal', $tanggal)->where('partner', $matchedUser->partner)
                                                    ->whereNotNull('jam_masuk')
                                                    ->first();
                                    if($existingAbsensi)
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

                                        $jumkerja     = $jadwal_pulang->diff($jam_masuk);
                                        $absensi->jml_jamkerja = $jumkerja->format('%H:%I:%S');
                                       

                                        if($jam_masuk < $jadwal_masuk && $jam_keluar >= $jadwal_pulang)
                                        {//kondisi normal
                                            $absensi->plg_cepat    = null;
                                            // $jam_kerja             = $jadwal_pulang->diff($jam_masuk);
                                            // $jam_kerja             = $jam_kerja->format('%H:%I:%S');

                                            // $absensi->jml_jamkerja = $jam_kerja;
                                           
                                            // dd($absensi,$absensi->jml_jamkerja);
                                        }
                                        elseif($jam_masuk < $jadwal_masuk && $jam_keluar < $jadwal_pulang)
                                        {//pulangcepat
                                            $absensi->plg_cepat = null;
                                            $absensi->jml_jamkerja = '09:00:00';
                                            
                                            // dd($absensi,$absensi->jml_jamkerja);
                                        }

                                        $jmlhadir           = $jam_keluar->diff($jam_masuk);
                                        $absensi->jam_kerja =  $jmlhadir->format('%H:%I:%S');

                                        // dd($jmlhadir,$jmlhadi,$absensi);
                                        $absensi->update();
                                    }
                                    else
                                    {
                                        $jadwal_masuk  = $jadwal->jadwal_masuk;
                                        $jadwal_pulang = $jadwal->jadwal_pulang;
                                        $jam_masuk     = Carbon::createFromFormat('H:i:s', $jam);
                                        //menghitung keterlambatan karyawan
                            
                                        if($jam_masuk < $jadwal_masuk){
                                            $telat         = $jam_masuk->diff($jadwal_masuk);
                                            $terlambat     = $telat->format('%H:%I:%S');
                                        }
                                        elseif($jam_masuk > $jadwal_masuk)
                                        {
                                            $terlambat     = null;
                                        }
                                        
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
                                   
                                }else{
                                    ///
                                }
                            }
                        }
                        else{
                            $matchedUser = $usermesin->where('noid2', $pin)->first();
                            // dd($matchedUser);
                            if (isset($matchedUser)) 
                            {
                                $jadwals = Jadwal::where('tanggal', $tanggal)
                                    ->where('partner', Auth::user()
                                    ->partner)->get();
                                // dd($data,$matchedUser,$jadwal);
                                foreach ($jadwals as $jadwal) 
                                {
                                    if($jadwal)
                                    {
                                        $existingAbsensi = Absensi::where('id_karyawan', $matchedUser->id_pegawai)
                                                        ->where('tanggal', $tanggal)->where('partner', $matchedUser->partner)
                                                        ->whereNotNull('jam_masuk')
                                                        ->first();
                                        if($existingAbsensi)
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

                                            $jumkerja     = $jadwal_pulang->diff($jam_masuk);
                                            $absensi->jml_jamkerja = $jumkerja->format('%H:%I:%S');
                                        
                                            if($jam_masuk < $jadwal_masuk && $jam_keluar >= $jadwal_pulang)
                                            {//kondisi normal
                                                $absensi->plg_cepat    = null;
                                                // $jam_kerja             = $jadwal_pulang->diff($jam_masuk);
                                                // $jam_kerja             = $jam_kerja->format('%H:%I:%S');

                                                // $absensi->jml_jamkerja = $jam_kerja;
                                            
                                                // dd($absensi,$absensi->jml_jamkerja);
                                            }
                                            elseif($jam_masuk < $jadwal_masuk && $jam_keluar < $jadwal_pulang)
                                            {//pulangcepat
                                                $absensi->plg_cepat = null;
                                                $absensi->jml_jamkerja = '09:00:00';
                                                
                                                // dd($absensi,$absensi->jml_jamkerja);
                                            }

                                            $jmlhadir           = $jam_keluar->diff($jam_masuk);
                                            $absensi->jam_kerja =  $jmlhadir->format('%H:%I:%S');

                                            // dd($jmlhadir,$jmlhadi,$absensi);
                                            $absensi->update();
                                        }
                                        else
                                        {
                                            $jadwal_masuk  = $jadwal->jadwal_masuk;
                                            $jadwal_pulang = $jadwal->jadwal_pulang;
                                            $jam_masuk     = Carbon::createFromFormat('H:i:s', $jam);
                                            //menghitung keterlambatan karyawan
                                
                                            if($jam_masuk < $jadwal_masuk){
                                                $telat         = $jam_masuk->diff($jadwal_masuk);
                                                $terlambat     = $telat->format('%H:%I:%S');
                                            }
                                            elseif($jam_masuk > $jadwal_masuk)
                                            {
                                                $terlambat     = null;
                                            }
                                            
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
                                    
                                    }else{
                                        ///
                                    }
                                }
                            }else{
                                //
                            }

                        }
                    }
                    // Mengembalikan data dalam format JSON
                    // return response()->json([$j]);
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
