<?php

namespace App\Http\Controllers\admin;

use App\Models\Cuti;
use App\Models\Izin;
use App\Models\Jadwal;
use App\Models\Absensi;
use App\Models\Karyawan;
use App\Models\Tidakmasuk;
use Illuminate\Http\Request;
use App\Models\Detailkehadiran;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DetailhadirController extends Controller
{
       //konfigurasi kehadiran
       public function indexs(Request $request)
       {
           $role = Auth::user()->role;
           if ($role == 1 ||$role == 6)
           {
               $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
               $kehadiran = Detailkehadiran::where('partner',$row->partner)->get();
               return view('admin.penggajian.konfigurasi.index',compact('row','role','kehadiran'));
           }else {
   
               return redirect()->back();
           }
       }
   
       public function storehadir(Request $request)
       {
           $karyawan = Karyawan::where('partner',$request->partner)->select('id','nama','partner')->get();
           $awal = date_format(date_create_from_format('d/m/Y', $request->tgl_awal), 'Y-m-d');
           $akhir = date_format(date_create_from_format('d/m/Y', $request->tgl_akhir), 'Y-m-d');
           foreach($karyawan as $data)
           {
                //mengtihung jumlah dan jam hadir karyawan
                $hadir = Absensi::where('id_karyawan', $data->id)
                   ->whereBetween('tanggal', [$awal, $akhir])
                   ->count();

                $jamhadir = Absensi::selectRaw('SUM(TIME_TO_SEC(TIME(jml_jamkerja))) / 3600 AS total_jam')
                   ->where('id_karyawan', $data->id)
                   ->whereBetween('tanggal', [$awal, $akhir])
                   ->value('total_jam');
   
                //menghitung jumlah dan jam lembur karyawan
                $lembur = Absensi::where('id_karyawan', $data->id)
                   ->where('lembur', '!=', null)
                   ->whereBetween('tanggal', [$awal, $akhir])
                   ->where('lembur','>','01:00:00')
                   ->count();

                $jamlembur = Absensi::selectRaw('SUM(TIME_TO_SEC(TIME(lembur))) / 3600 AS total_jam')
                   ->where('id_karyawan', $data->id)
                   ->whereBetween('tanggal', [$awal, $akhir])
                   ->where('lembur','>','01:00:00')
                   ->value('total_jam');
                
                //menghitung jumlah hari kerja dalam 1 bulan
                $jadwal = Jadwal::selectRaw('SUM(TIME_TO_SEC(TIMEDIFF(jadwal_pulang, jadwal_masuk))) / 3600 AS total_jam')
                    ->where('partner',$data->partner)
                    ->whereBetween('tanggal', [$awal, $akhir])
                    ->value('total_jam');

                // $sakit = Izin::where('id_karyawan',$data->id)
                //     ->where('id_jenisizin','=',1)
                //     ->whereBetween('tgl_mulai', [$awal, $akhir])
                //     ->whereBetween('tgl_selesai', [$awal, $akhir])
                //     ->count();

                //menghitung jumlah dan jam sakit karyawan
                $izinSakit = Izin::where('id_karyawan', $data->id)->where('id_jenisizin', 1)
                        ->where(function ($query) use ($awal, $akhir) {
                            $query->where(function ($q) use ($awal, $akhir) {
                                $q->where('tgl_mulai', '>=', $awal)->where('tgl_mulai', '<=', $akhir);
                            })->orWhere(function ($q) use ($awal, $akhir) {
                                $q->where('tgl_selesai', '>=', $awal)->where('tgl_selesai', '<=', $akhir);
                            })->orWhere(function ($q) use ($awal, $akhir) {
                                $q->where('tgl_mulai', '<', $awal)->where('tgl_selesai', '>', $akhir);
                            });
                        })
                        ->get();

                $totalHariIzinSakit = 0;
                $totalJamSakit = 0;
                foreach ($izinSakit as $izinsakit) 
                {
                    $tglMulai = \Carbon\Carbon::parse($izinsakit->tgl_mulai);
                    $tglSelesai = \Carbon\Carbon::parse($izinsakit->tgl_selesai);
                    $selisihHari = $tglMulai->diffInDays($tglSelesai) + 1; 

                    $totalHariIzinSakit += $selisihHari;

                    $cocokkanTanggal = Jadwal::where('partner', $data->partner)
                        ->whereBetween('tanggal', [$tglMulai, $tglSelesai])
                        ->count();

                    if ($cocokkanTanggal > 0) {
                        $totalHariIzinSakit = $cocokkanTanggal;
                    }

                    $jamTanggal = Jadwal::where('partner', $data->partner)
                        ->whereBetween('tanggal', [$tglMulai, $tglSelesai])
                        ->get();

                    foreach ($jamTanggal as $jadwal) {
                        $jamMasuk = \Carbon\Carbon::parse($jadwal->jadwal_masuk);
                        $jamPulang = \Carbon\Carbon::parse($jadwal->jadwal_pulang);
                
                        // Hitung selisih jam (dalam jam)
                        $selisihJam = $jamMasuk->diffInHours($jamPulang);
                
                        // Tambahkan selisih jam ke total jam
                       $totalJamSakit += $selisihJam;
                    }
                    // $totalJamSakit = $totalJam * $totalHariIzinSakit;
                }

                //menghitung jumlah dan jam izin biasa karyawan
                $izin = Izin::where('id_karyawan', $data->id)->where('id_jenisizin', [2,5])
                    ->where(function ($query) use ($awal, $akhir) {
                        $query->where(function ($q) use ($awal, $akhir) {
                            $q->where('tgl_mulai', '>=', $awal)->where('tgl_mulai', '<=', $akhir);
                        })->orWhere(function ($q) use ($awal, $akhir) {
                            $q->where('tgl_selesai', '>=', $awal)->where('tgl_selesai', '<=', $akhir);
                        })->orWhere(function ($q) use ($awal, $akhir) {
                            $q->where('tgl_mulai', '<', $awal)->where('tgl_selesai', '>', $akhir);
                        });
                    })
                    ->get();

                $totalHariIzin = 0;
                $totalJamIzin = 0;
                foreach ($izin as $izin) 
                {
                    $tglMulai = \Carbon\Carbon::parse($izin->tgl_mulai);
                    $tglSelesai = \Carbon\Carbon::parse($izin->tgl_selesai);
                    $selisihHari = $tglMulai->diffInDays($tglSelesai) + 1; 

                    $totalHariIzin += $selisihHari;

                    $cocokkanTanggal = Jadwal::where('partner', $data->partner)
                        ->whereBetween('tanggal', [$tglMulai, $tglSelesai])
                        ->count();

                    if ($cocokkanTanggal > 0) {
                        $totalHariIzin = $cocokkanTanggal;
                    }

                    if($izin->id_jenisizin == 2 && $izin->jam_mulai == NULL && $izin->jam_selesai == NULL)
                    {
                        $jamTanggal = Jadwal::where('partner', $data->partner)
                            ->whereBetween('tanggal', [$tglMulai, $tglSelesai])
                            ->get();

                        foreach ($jamTanggal as $jadwal) {
                            $jamMasuk = \Carbon\Carbon::parse($jadwal->jadwal_masuk);
                            $jamPulang = \Carbon\Carbon::parse($jadwal->jadwal_pulang);
                    
                            // Hitung selisih jam (dalam jam)
                            $selisihJam = $jamMasuk->diffInHours($jamPulang);
                
                            $totalJamIzin += $selisihJam;
                        }
                    }else if($izin->id_jenisizin == 5)
                    {
                        $jamMulai   = \Carbon\Carbon::parse($izin->jam_mulai);
                        $jamSelesai = \Carbon\Carbon::parse($izin->jam_selesai);

                        $selisih = $jamMulai->diff($jamSelesai);

                        $jam   = $selisih->format('%h');
                        $menit = $selisih->format('%i');

                        $totalJamIzin = $jam + ($menit / 60);

                    }
                }

                //menghitung jumlah dan jam izin biasa karyawan
                $cuti = Cuti::where('id_karyawan',$data->id)
                    ->where(function ($query) use ($awal, $akhir) {
                        $query->where(function ($q) use ($awal, $akhir) {
                            $q->where('tgl_mulai', '>=', $awal)->where('tgl_mulai', '<=', $akhir);
                        })->orWhere(function ($q) use ($awal, $akhir) {
                            $q->where('tgl_selesai', '>=', $awal)->where('tgl_selesai', '<=', $akhir);
                        })->orWhere(function ($q) use ($awal, $akhir) {
                            $q->where('tgl_mulai', '<', $awal)->where('tgl_selesai', '>', $akhir);
                        });
                    })
                    ->get();
                
                $totalHariCuti = 0;
                $totalJamCuti = 0;
                foreach ($cuti as $cuty) 
                {
                    $tglMulai = \Carbon\Carbon::parse($cuty->tgl_mulai);
                    $tglSelesai = \Carbon\Carbon::parse($cuty->tgl_selesai);

                    if ($tglMulai->greaterThan($awal)) {
                        $tglHitungAwal = $tglMulai;
                    } else {
                        $tglHitungAwal = $awal;
                    }
                
                    if ($tglSelesai->lessThan($akhir)) {
                        $tglHitungAkhir = $tglSelesai;
                    } else {
                        $tglHitungAkhir = $akhir;
                    }
                
                    $tglHitungAwal = \Carbon\Carbon::parse($tglHitungAwal);
                    $tglHitungAkhir= \Carbon\Carbon::parse($tglHitungAkhir);

                    $selisihHari = $tglHitungAwal->diffInDays($tglHitungAkhir) + 1;
                
                    $totalHariCuti += $selisihHari;
                
                    $cocokkanTanggal = Jadwal::where('partner', $data->partner)
                        ->whereBetween('tanggal', [$tglHitungAwal, $tglHitungAkhir])
                        ->count();

                    if ($cocokkanTanggal > 0) {
                        $totalHariCuti = $cocokkanTanggal;
                    }

                    $jamTanggal = Jadwal::where('partner', $data->partner)
                        ->whereBetween('tanggal', [$tglMulai, $tglSelesai])
                        ->get();

                    foreach ($jamTanggal as $jadwal) {
                        $jamMasuk = \Carbon\Carbon::parse($jadwal->jadwal_masuk);
                        $jamPulang = \Carbon\Carbon::parse($jadwal->jadwal_pulang);
                
                        $selisihJam = $jamMasuk->diffInHours($jamPulang);
            
                       $totalJamCuti += $selisihJam;
                    }
                }

                Detailkehadiran::updateOrCreate(
                    [
                        'id_karyawan' => $data->id,
                        'tgl_awal' => $awal,
                        'tgl_akhir' => $akhir,
                    ],
                    [
                        'total_jadwal'=> $jadwal,
                        'jumlah_hadir'=> $hadir,
                        'jumlah_lembur'=>$lembur,
                        'jumlah_cuti' => $totalHariCuti,
                        'jumlah_izin' => $totalHariIzin,
                        'jumlah_sakit'=> $totalHariIzinSakit,
                        'jam_hadir'   => $jamhadir,  
                        'jam_lembur'  => $jamlembur,
                        'jam_cuti'    => $totalJamCuti,
                        'jam_izin'    => $totalJamIzin,
                        'jam_sakit'   => $totalJamSakit,
                        'partner'     => $request->partner,
                    ]
                );
           }
   
           return redirect()->back()->with('pesan','Data berhasil disimpan');
   
       }
}
