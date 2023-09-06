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
                $hadir = Absensi::where('id_karyawan', $data->id)
                   ->whereBetween('tanggal', [$awal, $akhir])
                   ->count();

                $jamhadir = Absensi::selectRaw('SUM(TIME_TO_SEC(TIME(jml_jamkerja))) / 3600 AS total_jam')
                   ->where('id_karyawan', $data->id)
                   ->whereBetween('tanggal', [$awal, $akhir])
                   ->value('total_jam');
   
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
                
                
                $jadwal = Jadwal::selectRaw('SUM(TIME_TO_SEC(TIMEDIFF(jadwal_pulang, jadwal_masuk))) / 3600 AS total_jam')
                    ->where('partner',$data->partner)
                    ->whereBetween('tanggal', [$awal, $akhir])
                    ->value('total_jam');

                // $sakit = Izin::where('id_karyawan',$data->id)
                //     ->where('id_jenisizin','=',1)
                //     ->whereBetween('tgl_mulai', [$awal, $akhir])
                //     ->whereBetween('tgl_selesai', [$awal, $akhir])
                //     ->count();

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

                foreach ($izinSakit as $izin) {
                    $tglMulai = \Carbon\Carbon::parse($izin->tgl_mulai);
                    $tglSelesai = \Carbon\Carbon::parse($izin->tgl_selesai);
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

                // $jamsakit = 

                $cuti = Cuti::where('id_karyawan',$data->id)
                    ->whereBetween('tgl_mulai', [$awal, $akhir])
                    ->whereBetween('tgl_selesai', [$awal, $akhir])
                    ->count();
                    
                $izin = Izin::where('id_karyawan', $data->id)
                    ->where('id_jenisizin','=',[2,5])
                    ->whereBetween('tgl_mulai', [$awal, $akhir])
                    ->whereBetween('tgl_selesai', [$awal, $akhir])
                    ->count();

                // $sakit = Tidakmasuk::where('id_pegawai',$data->id
                //    ->whereBetween('tanggal', [$awal, $akhir])
                //    ->where('status','Sakit')
                //    ->count();

                // $jamsakit = Izin::selectRaw('SUM(TIME_TO_SEC(TIME(lembur))) / 3600 AS total_jam')
                //    ->where('id_karyawan', $data->id)
                //    ->whereBetween('tanggal', [$awal, $akhir])
                //    ->value('total_jam');

                // $cuti = Tidakmasuk::where('id_pegawai', $data->id)
                //     ->whereBetween('tanggal', [$awal, $akhir])
                //     ->where('status', 'LIKE', '%Cuti%')
                //     ->count();

                // $izin = Tidakmasuk::where('id_pegawai', $data->id)
                //     ->whereBetween('tanggal', [$awal, $akhir])
                //     ->where('status', 'LIKE', '%Izin%')
                //     ->count();

               $data = [
                   'id_karyawan' => $data->id,
                   'tgl_awal'    => $awal,
                   'tgl_akhir'   => $akhir,
                   'jumlah_hadir'=> $hadir,
                   'jumlah_lembur'=>$lembur,
                   'jumlah_cuti' => $cuti,
                   'jumlah_izin' => $izin,
                   'jumlah_sakit'=> $totalHariIzinSakit,
                   'jam_hadir'   => $jamhadir,  
                   'jam_lembur'  => $jamlembur,
                   'jam_cuti'    => null,
                   'jam_izin'    => null,
                   'jam_sakit'   => $totalJamSakit,
                   'partner'     => $request->partner,
               ];
               Detailkehadiran::insert($data);
           }
   
           return redirect()->back()->with('pesan','Data berhasil disimpan');
   
       }
}
