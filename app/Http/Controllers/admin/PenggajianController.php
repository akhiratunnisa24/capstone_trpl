<?php

namespace App\Http\Controllers\admin;

use PDF;
use Carbon\Carbon;
use App\Models\Cuti;
use App\Models\Izin;
use App\Models\Jadwal;
use App\Models\Absensi;
use App\Models\Benefit;
use App\Models\Jabatan;
use App\Models\Karyawan;
use App\Models\Departemen;
use App\Models\Penggajian;
use App\Models\Tidakmasuk;
use Illuminate\Support\Str;
use App\Models\LevelJabatan;
use Illuminate\Http\Request;
use App\Models\Informasigaji;
use App\Models\PenggajianGrup;
use App\Models\Detailkehadiran;
use App\Models\SalaryStructure;
use App\Models\DetailPenggajian;
use App\Models\SettingOrganisasi;
use App\Mail\SlipgajiNotification;
use Illuminate\Support\Facades\DB;
use App\Models\Detailinformasigaji;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\DetailSalaryStructure;

class PenggajianController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $role = Auth::user()->role;
        if ($role == 1 ||$role == 6)
        {
            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
            $karyawan = Karyawan::where('partner', $row->partner)
                ->where('status_kerja', 'Aktif')
                ->whereNull('tglkeluar')
                ->get();        

            $slipgaji = Penggajian::where('partner',$row->partner)->get();

            return view('admin.penggajian.index',compact('row','role','karyawan','slipgaji'));
        }else {

            return redirect()->back();
        }
    }

    public function getkaryawan(Request $request)
    {
        try {
            $getKaryawan = Karyawan::leftjoin('departemen', 'karyawan.divisi', '=', 'departemen.id')
                ->select('karyawan.nama_jabatan','karyawan.id' ,'karyawan.divisi', 'karyawan.nip', 'departemen.nama_departemen','karyawan.nama_bank','karyawan.no_rek','karyawan.tglmasuk')
                ->where('karyawan.id','=', $request->id_karyawan)
                ->first();

            if (!$getKaryawan) {
                 throw new \Exception('Data not found');
            }

            return response()->json( $getKaryawan,200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function storeGaji(Request $request)
    {
        $validateData = $request->validate([
            'tglgajian' => 'required',
            'id_karyawan' => 'required',
            'tgl_awal' => 'required',
            'tgl_akhir' => 'required',
            'nama_bank' => 'required',
            'nomor_rekening' => 'required',
            'partner' => 'required',
        ]);

        $tgl_awal = date_format(date_create_from_format('d/m/Y', $request->tgl_awal), 'Y-m-d');
        $tgl_akhir= date_format(date_create_from_format('d/m/Y', $request->tgl_akhir), 'Y-m-d');
        $tglgajian= date_format(date_create_from_format('d/m/Y', $request->tglgajian), 'Y-m-d');

        $getKaryawan = Karyawan::leftjoin('departemen', 'karyawan.divisi', '=', 'departemen.id')
            ->select('karyawan.nama_jabatan','karyawan.id' ,'karyawan.partner','karyawan.nama','karyawan.divisi', 'karyawan.nip', 'departemen.nama_departemen','karyawan.nama_bank','karyawan.no_rek','karyawan.divisi',
            'karyawan.jabatan','karyawan.status_karyawan')
            ->where('karyawan.id','=', $request->id_karyawan)
            ->first();

        if($getKaryawan->nama_bank == null || $getKaryawan->no_rek == null)
        {
            $data = [
                'nama_bank' => $request->nama_bank,
                'no_rek' =>  $request->nomor_rekening,
            ];
            Karyawan::where('id', $request->id_karyawan)->update($data);
        }

        $lembur = DB::table('detail_kehadiran')
            ->where('id_karyawan',$getKaryawan->id)
            ->where('tgl_awal',$tgl_awal)
            ->where('tgl_akhir',$tgl_akhir)
            ->first();

        $informasigaji = Informasigaji::where('id_karyawan',$request->id_karyawan)->where('status',1)->first();
        if($informasigaji === null)
        {
            if($getKaryawan->divisi === null && $getKaryawan->jabatan !== null && $getKaryawan->status_karyawan !== null){
                $pesan = "Data <strong><span style='color: red;'>Divisi</span></strong> karyawan belum lengkap,<br> silahkan lengkapi dan Coba lagi. <br><br><strong><a href='" . route('editidentitas', ['id' => $getKaryawan->id]) . "' class='btn btn-sm btn-info' target='_blank'>Lengkapi Data</a></strong> <br>";
            }elseif($getKaryawan->status_karyawan === null && $getKaryawan->jabatan !== null && $getKaryawan->divisi !== null){
                $pesan = "Data <strong><span style='color: red;'>Status Karyawan</span></strong> belum lengkap,<br> silahkan lengkapi dan Coba lagi. <br><br><strong><a href='" . route('editidentitas', ['id' => $getKaryawan->id]) . "' class='btn btn-sm btn-info' target='_blank'>Lengkapi Data</a></strong> <br>";
            }elseif($getKaryawan->jabatan === null && $getKaryawan->status_karyawan !== null && $getKaryawan->divisi !== null)
            {
                $pesan = "Data <strong><span style='color: red;'>Level Jabatan</span></strong> karyawan belum lengkap,<br> silahkan lengkapi dan Coba lagi. <br><br><strong><a href='" . route('editidentitas', ['id' => $getKaryawan->id]) . "' class='btn btn-sm btn-info' target='_blank'>Lengkapi Data</a></strong> <br>";
            }elseif($getKaryawan->jabatan === null && $getKaryawan->status_karyawan === null && $getKaryawan->divisi !== null)
            {
                $pesan = "Data <strong><span style='color: red;'>Status dan Level Jabatan</span></strong> karyawan belum lengkap,<br> silahkan lengkapi dan Coba lagi. <br><br><strong><a href='" . route('editidentitas', ['id' => $getKaryawan->id]) . "' class='btn btn-sm btn-info' target='_blank'>Lengkapi Data</a></strong> <br>";
            }elseif($getKaryawan->jabatan === null && $getKaryawan->status_karyawan === null && $getKaryawan->divisi === null)
            {
                $pesan = "Data <strong><span style='color: red;'>Status,Divisi dan Level Jabatan</span></strong> karyawan belum lengkap,<br> silahkan lengkapi dan Coba lagi. <br><br><strong><a href='" . route('editidentitas', ['id' => $getKaryawan->id]) . "' class='btn btn-sm btn-info' target='_blank'>Lengkapi Data</a></strong> <br>";
            }elseif($informasigaji === null)
            {
                $pesan = "Data <strong><span style='color: red;'>Informasi Gaji</span></strong> karyawan belum lengkap,<br> silahkan lengkapi dan Coba lagi. <br><br><strong><a href='". route('showinformasigaji',['id' => $getKaryawan->id])."' class='btn btn-sm btn-info'>Lengkapi Data</a></strong> <br>";
            }
            else{
                //$pesan = "Data tidak lengkap, silahkan lengkapi <strong><a href='/editidentitas" . $karyawan->id . "'>Status/Level Jabatan Karyawan</a></strong> dan Coba kembali.";
                $pesan = "Data <strong><span style='color: red;'>Status,Divisi dan Level Jabatan</span></strong> karyawan belum lengkap,<br> silahkan lengkapi dan Coba lagi. <br><br><strong><a href='" . route('editidentitas', ['id' => $getKaryawan->id]) . "' class='btn btn-sm btn-info' target='_blank'>Lengkapi Data</a></strong> <br>";
            }
            $pesan = '<div class="text-center">' . $pesan . '</div>';
            $pesan = nl2br(html_entity_decode($pesan));
            return redirect()->back()->with('message',$pesan);
        }else{
            $detail = Detailinformasigaji::where('id_informasigaji',$informasigaji->id)->get();

            $penggajian = Penggajian::firstOrNew([
                        'id_karyawan' => $request->id_karyawan,
                        'tglawal' => $tgl_awal,
                        'tglakhir' => $tgl_akhir,
                    ]);

            $penggajian->tglgajian = $tglgajian;
            $penggajian->id_informasigaji = $informasigaji->id;
            $penggajian->id_strukturgaji  = $informasigaji->id_strukturgaji;
            $penggajian->gaji_pokok = $informasigaji->gaji_pokok;
            $penggajian->lembur     = null;
            $penggajian->tunjangan  = null;
            $penggajian->gaji_kotor = null;
            $penggajian->asuransi   = null;
            $penggajian->potongan   = null;
            $penggajian->pajak      = null;
            $penggajian->gaji_bersih = null;
            $penggajian->nama_bank   = $request->nama_bank;
            $penggajian->no_rekening = $request->nomor_rekening;
            $penggajian->partner    = $request->partner;
            $penggajian->statusmail = 0;

            $penggajian->save();

            //create detail kehadiran karyawan jika belum ada
            $detailkehadiran = Detailkehadiran::where('id_karyawan',  $request->id_karyawan)
            ->where(function ($query) use ($tgl_awal,$tgl_akhir) {
                $query->whereBetween('tgl_awal', [$tgl_awal, $tgl_akhir])
                    ->orWhereBetween('tgl_akhir', [$tgl_awal, $tgl_akhir]);
            })
            ->first();

            if($detailkehadiran == null)
            {
                //jumlah hadir dalam rentahg tanggal gajian
                $awal = date_format(date_create_from_format('d/m/Y', $request->tgl_awal), 'Y-m-d');
                $akhir = date_format(date_create_from_format('d/m/Y', $request->tgl_akhir), 'Y-m-d');
                $hadir = Absensi::where('id_karyawan', $getKaryawan->id)
                    ->whereBetween('tanggal', [$tgl_awal, $tgl_akhir])
                    ->count();

                $jamhadir = Absensi::selectRaw('SUM(TIME_TO_SEC(TIME(jml_jamkerja))) / 3600 AS total_jam')
                    ->where('id_karyawan', $getKaryawan->id)
                    ->whereBetween('tanggal', [$tgl_awal, $tgl_akhir])
                    ->value('total_jam');
                // dd($jamhadir);

                //menghitung jumlah dan jam lembur karyawan
                $lembur = Absensi::where('id_karyawan', $getKaryawan->id)
                    ->where('lembur', '!=', null)
                    ->whereBetween('tanggal', [$tgl_awal, $tgl_akhir])
                    ->where('lembur','>','01:00:00')
                    ->count();

                $jamlembur = Absensi::selectRaw('SUM(TIME_TO_SEC(TIME(lembur))) / 3600 AS total_jam')
                    ->where('id_karyawan', $getKaryawan->id)
                    ->whereBetween('tanggal', [$tgl_awal, $tgl_akhir])
                    ->where('lembur','>','01:00:00')
                    ->value('total_jam');

                $jadwal = Jadwal::where('partner',$getKaryawan->partner)
                    ->whereBetween('tanggal',[$tgl_awal, $tgl_akhir])
                    ->count();

                //hitung jumlah sakit dalam 1 bulan
                $izinSakit = Izin::where('id_karyawan', $getKaryawan->id)->where('id_jenisizin', 1)
                    ->where(function ($query) use ($tgl_awal, $tgl_akhir) {
                        $query->where(function ($q) use ($tgl_awal, $tgl_akhir) {
                            $q->where('tgl_mulai', '>=', $tgl_awal)->where('tgl_mulai', '<=', $tgl_akhir);
                        })->orWhere(function ($q) use ($tgl_awal, $tgl_akhir) {
                            $q->where('tgl_selesai', '>=', $tgl_awal)->where('tgl_selesai', '<=', $tgl_akhir);
                        })->orWhere(function ($q) use ($tgl_awal, $tgl_akhir) {
                            $q->where('tgl_mulai', '<', $tgl_awal)->where('tgl_selesai', '>', $tgl_akhir);
                        });
                    })
                    ->get();

                $totalHariIzinSakit = 0;
                $totalJamSakit = 0;
                foreach ($izinSakit as $izinsakit)
                {
                    $tglMulai = \Carbon\Carbon::parse($izinsakit->tgl_mulai);
                    $tglSelesai = \Carbon\Carbon::parse($izinsakit->tgl_selesai);

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
                    
                    $cocokkanTanggal = Jadwal::where('partner', $getKaryawan->partner)
                        ->whereBetween('tanggal', [$tglHitungAwal, $tglHitungAkhir])
                        ->count();

                    if ($cocokkanTanggal > 0) {
                        $totalHariIzinSakit = $cocokkanTanggal;
                    }

                    $jamTanggal = Jadwal::where('partner', $getKaryawan->partner)
                        ->whereBetween('tanggal', [$tglHitungAwal, $tglHitungAkhir])
                        ->get();

                    foreach ($jamTanggal as $j) {
                        $jamMasuk = \Carbon\Carbon::parse($j->jadwal_masuk);
                        $jamPulang = \Carbon\Carbon::parse($j->jadwal_pulang);

                        $selisihJam = $jamMasuk->diffInHours($jamPulang);

                       $totalJamSakit += $selisihJam;
                    }
                }

                //menghitung jumlah dan jam izin biasa karyawan
                $izin = Izin::where('id_karyawan', $getKaryawan->id)->where('id_jenisizin', [2,5])
                    ->where(function ($query) use ($tgl_awal, $tgl_akhir) {
                        $query->where(function ($q) use ($tgl_awal, $tgl_akhir) {
                            $q->where('tgl_mulai', '>=', $tgl_awal)->where('tgl_mulai', '<=', $tgl_akhir);
                        })->orWhere(function ($q) use ($tgl_awal, $tgl_akhir) {
                            $q->where('tgl_selesai', '>=', $tgl_awal)->where('tgl_selesai', '<=', $tgl_akhir);
                        })->orWhere(function ($q) use ($tgl_awal, $tgl_akhir) {
                            $q->where('tgl_mulai', '<', $tgl_awal)->where('tgl_selesai', '>', $tgl_akhir);
                        });
                    })
                    ->get();

                $totalHariIzin = 0;
                $totalJamIzin = 0;
                foreach ($izin as $izin)
                {
                    $tglMulai = \Carbon\Carbon::parse($izin->tgl_mulai);
                    $tglSelesai = \Carbon\Carbon::parse($izin->tgl_selesai);

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

                    $cocokkanTanggal = Jadwal::where('partner', $getKaryawan->partner)
                        ->whereBetween('tanggal', [$tglHitungAwal, $tglHitungAkhir])
                        ->count();

                    if ($cocokkanTanggal > 0) {
                        $totalHariIzin = $cocokkanTanggal;
                    }

                    if($izin->id_jenisizin == 2 && $izin->jam_mulai == NULL && $izin->jam_selesai == NULL)
                    {
                        $jamTanggal = Jadwal::where('partner', $getKaryawan->partner)
                            ->whereBetween('tanggal', [$tglHitungAwal, $tglHitungAkhir])
                            ->get();

                        foreach ($jamTanggal as $j) {
                            $jamMasuk = \Carbon\Carbon::parse($j->jadwal_masuk);
                            $jamPulang = \Carbon\Carbon::parse($j->jadwal_pulang);

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

                //menghitung jumlah dan jam cuti  biasa karyawan
                $cuti = Cuti::where('id_karyawan',$getKaryawan->id)
                    ->where(function ($query) use ($tgl_awal, $tgl_akhir) {
                        $query->where(function ($q) use ($tgl_awal, $tgl_akhir) {
                            $q->where('tgl_mulai', '>=', $tgl_awal)->where('tgl_mulai', '<=', $tgl_akhir);
                        })->orWhere(function ($q) use ($tgl_awal, $tgl_akhir) {
                            $q->where('tgl_selesai', '>=', $tgl_awal)->where('tgl_selesai', '<=', $tgl_akhir);
                        })->orWhere(function ($q) use ($tgl_awal, $tgl_akhir) {
                            $q->where('tgl_mulai', '<', $tgl_awal)->where('tgl_selesai', '>', $tgl_akhir);
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

                    $cocokkanTanggal = Jadwal::where('partner', $data->partner)
                        ->whereBetween('tanggal', [$tglHitungAwal, $tglHitungAkhir])
                        ->count();

                    if ($cocokkanTanggal > 0) {
                        $totalHariCuti = $cocokkanTanggal;
                    }
                    $jamTanggal = Jadwal::where('partner', $data->partner)
                        ->whereBetween('tanggal', [$tglHitungAwal, $tglHitungAkhir])
                        ->get();

                    foreach ($jamTanggal as $j) {
                        $jamMasuk = \Carbon\Carbon::parse($j->jadwal_masuk);
                        $jamPulang = \Carbon\Carbon::parse($j->jadwal_pulang);

                        $selisihJam = $jamMasuk->diffInHours($jamPulang);

                       $totalJamCuti += $selisihJam;
                    }
                }

                $detailkehadiran = Detailkehadiran::firstOrNew(
                    [
                        'id_karyawan' => $getKaryawan->id,
                        'tgl_awal' => $awal,
                        'tgl_akhir' => $akhir,
                    ]);

                $detailkehadiran->total_jadwal = $jadwal ? $jadwal : 0;
                $detailkehadiran->jumlah_hadir = $hadir ? $hadir : 0;
                $detailkehadiran->jumlah_lembur= $lembur ? $lembur : 0;
                $detailkehadiran->jumlah_cuti  = $totalHariCuti ? $totalHariCuti : 0;
                $detailkehadiran->jumlah_izin  = $totalHariIzin ? $totalHariIzin : 0;
                $detailkehadiran->jumlah_sakit = $totalHariIzinSakit ? $totalHariIzinSakit : 0;
                $detailkehadiran->jam_hadir    = $jamhadir ? $jamhadir : 0;
                $detailkehadiran->jam_lembur   = $jamlembur ? $jamlembur : 0;
                $detailkehadiran->jam_cuti     = $totalJamCuti ? $totalJamCuti : 0;
                $detailkehadiran->jam_izin     = $totalJamIzin ? $totalJamIzin : 0;
                $detailkehadiran->jam_sakit    = $totalJamSakit ? $totalJamSakit : 0;
                $detailkehadiran->partner      = $getKaryawan->partner;

                $detailkehadiran->save();

            }

            $pesan = "Slip Gaji untuk ". $getKaryawan->nama . " Periode ". $request->tgl_awal . " s/d " .  $request->tgl_akhir . " Berhasil dibuat";
            return redirect()->back()->with('pesan',$pesan);
        }
    }

    public function showslipgaji(Request $request,$id)
    {
        $nip = $request->input('nip');
        // $id = $request->id;
        // dd($nip,$id);
        $role = Auth::user()->role;
        if ($role == 1 ||$role == 6)
        {
            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
            $slipgaji = Penggajian::with('karyawans')->where('id',$id)->first();
            $karyawan = Karyawan::where('id',$slipgaji->id_karyawan)->first();
            $informasigaji = Informasigaji::with('karyawans')->where('id_karyawan',$karyawan->id)->first();
            $detailinformasi= Detailinformasigaji::with('karyawans')->where('id_karyawan',$karyawan->id)->get();

            $kehadiran = Detailkehadiran::where('id_karyawan', $karyawan->id)
            ->where(function ($query) use ($slipgaji) {
                $query->whereBetween('tgl_awal', [$slipgaji->tglawal, $slipgaji->tglakhir])
                    ->orWhereBetween('tgl_akhir', [$slipgaji->tglawal, $slipgaji->tglakhir]);
            })
            ->first();

            $jadwal = Jadwal::whereBetween('tanggal', [$slipgaji->tglawal, $slipgaji->tglakhir])
                ->where('partner', $row->partner)
                ->count();

            $detailgaji = DetailPenggajian::where('id_penggajian',$slipgaji->id)->get();

            // dd($slipgaji,$kehadiran,$id,$detailinformasi);
            return view('admin.penggajian.slip',compact('row','detailgaji','role','karyawan','slipgaji','kehadiran','informasigaji','detailinformasi'));
        }else {

            return redirect()->back();
        }
    }

    public function indexgrup(Request $request)
    {
        $role = Auth::user()->role;
        if ($role == 1 ||$role == 6)
        {
            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
            $karyawan = Karyawan::where('partner', $row->partner)
                ->where('status_kerja', 'Aktif')
                ->whereNull('tglkeluar')
                ->get();  
            // $slipgrupindex = Penggajian::select('id_strukturgaji', 'tglgajian', 'tglawal', 'tglakhir')
            //     ->selectRaw('COUNT(*) as jumlah_penggajian')
            //     ->where('partner', $row->partner)
            //     ->groupBy('id_strukturgaji', 'tglgajian', 'tglawal', 'tglakhir')
            //     ->orderBy('id_strukturgaji','asc')
            //     ->get();
            $slipgrupindex = PenggajianGrup::where('partner', $row->partner)
                ->get();
            $slip = Penggajian::where('partner', $row->partner)->get();
            $slipgrup = SalaryStructure::where('partner',$row->partner)->get();

            return view('admin.penggajian.indexgrup',compact('row','role','karyawan','slip','slipgrup','slipgrupindex'));
        }else {

            return redirect()->back();
        }
    }

    public function create()
    {
        $role = Auth::user()->role; 
        if ($role == 1) {

            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
            $slipgrup = SalaryStructure::where('partner',$row->partner)->get();

            $output = [
                'row' => $row,
                'slipgrup' => $slipgrup,
                'role' => $role
            ];
            return view('admin.penggajian.creategrup', $output);
        } else {

            return redirect()->back();
        }
    }

    public function getkaryawangrup(Request $request)
    {
        try {
            $informasigaji = Informasigaji::select('id_karyawan', 'id_strukturgaji')
                ->where('id_strukturgaji', $request->id_strukturgaji)
                ->get();

            $dataKaryawan = [];
            foreach ($informasigaji as $informasi) {
                $getKaryawan = Karyawan::leftjoin('departemen', 'karyawan.divisi', '=', 'departemen.id')
                    ->select('karyawan.nama_jabatan','karyawan.nama' ,'karyawan.id', 'karyawan.divisi', 'karyawan.nip', 'departemen.nama_departemen', 'karyawan.nama_bank', 'karyawan.no_rek', 'karyawan.tglmasuk')
                    ->where('karyawan.id', '=', $informasi->id_karyawan)
                    ->first();
                if ($getKaryawan) {
                    $dataKaryawan[] = [
                        'id' => $getKaryawan->id,
                        'nama' => $getKaryawan->nama,
                        'nama_bank' => $getKaryawan->nama_bank,
                        'nomor_rekening' => $getKaryawan->no_rek,
                        'jabatan' => $getKaryawan->nama_jabatan,
                    ];
                }
            }

            // dd($request->id_strukturgaji,$informasigaji,$dataKaryawan);
            if (empty($dataKaryawan)) {
                return response()->json(['message' => 'Data not found'], 404); // Ubah kode status ke 404 karena data tidak ditemukan
            }

            return response()->json($dataKaryawan, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function storepenggajian_grup(Request $request)
    {
        $tgl_awal = date_format(date_create_from_format('d/m/Y', $request->tgl_mulai), 'Y-m-d');
        $tgl_akhir= date_format(date_create_from_format('d/m/Y', $request->tgl_selesai), 'Y-m-d');
        $tglgajian= date_format(date_create_from_format('d/m/Y', $request->tgl_penggajian), 'Y-m-d');

        $penggajiangrup = PenggajianGrup::where('tglawal',$tgl_awal)
            ->where('tglakhir', $tgl_akhir)
            ->where('tglgajian', $tglgajian)
            ->where('partner', $request->partner)
            ->exists();
        if(!$penggajiangrup)
        {
            $penggajiangrup = new PenggajianGrup();
            $penggajiangrup->nama_grup = $request->nama_grup;
            $penggajiangrup->tglawal = $tgl_awal;
            $penggajiangrup->tglakhir = $tgl_akhir;
            $penggajiangrup->tglgajian = $tglgajian;
            $penggajiangrup->partner = $request->partner;

            $penggajian = Penggajian::where('tglawal',$tgl_awal)
                ->where('tglakhir',$tgl_akhir)
                ->where('partner',$request->partner)
                ->get();
            $idsudahada = $penggajian->pluck('id_karyawan')->toArray();
            $listkaryawan = DB::table('karyawan')->leftjoin('informasi_gaji','karyawan.id','=','informasi_gaji.id_karyawan')
                ->select('karyawan.*','informasi_gaji.id as id_informasigaji','informasi_gaji.id_strukturgaji','informasi_gaji.status_karyawan as status_karyawan','informasi_gaji.level_jabatan as level_jabatan')
                ->where('karyawan.partner',$request->partner)
                ->where('informasi_gaji.status',1)
                ->where('karyawan.status_kerja', 'Aktif')
                ->whereNull('karyawan.tglkeluar')
                ->whereNotIn('karyawan.id', $idsudahada)
                ->groupBy('karyawan.id','informasi_gaji.id')
                ->get();
           
            $informasigajibelumada = Karyawan::where('partner',$request->partner)
                ->where('status_kerja', 'Aktif')
                ->whereNull('tglkeluar')
                ->whereNotIn('id', $listkaryawan->pluck('id','nama'))
                ->whereNotIn('id', $idsudahada);
            $namaKaryawan = $informasigajibelumada->pluck('nama')->toArray();
            $jumlah = count($namaKaryawan);
            if($jumlah > 0)
            {   
                $pesan = "Sebanyak <strong><span style='color: red;'>" . $jumlah . "</span></strong> karyawan belum memiliki informasi gaji/Identitas Diri yang belum lengkap.,<br> silahkan lengkapi Informasi Gajinya dan Coba lagi. <br> Silahkan klik dan lengkapi data dari karyawan di bawah ini: <br>";
                $pesan .= '<strong><span style="color: blue;">';
    
                foreach ($namaKaryawan as $nama) {
                    $karyawan = Karyawan::where('nama', $nama)->first();
                    $link = route('editidentitas', ['id' => $karyawan->id]);
                    $pesan .= "<a href='$link' target='_blank'>$nama</a>, ";
                }
    
                // Hapus koma terakhir
                $pesan = rtrim($pesan, ', ');
    
                $pesan .= '</span></strong>';
                $pesan = '<div class="text-center">' . $pesan . '</div>';
                $pesan = nl2br(html_entity_decode($pesan));
                return redirect()->back()->with('message',$pesan);
            }
    
            //simpan data grup penggajian
            $penggajiangrup->save();
            $penggajiangrup_id = $penggajiangrup->id;
            $listkary = $listkaryawan;
            // dd($listkary);
            foreach($listkary as $karyawan)
            {
                $strukturgaji = SalaryStructure::where('id',$karyawan->id_strukturgaji)->first();
                
                $nama_bank = $karyawan->nama_bank;
                $no_rekening = $karyawan->no_rek;
                if($karyawan->nama_bank == null && $karyawan->no_rek !== null)
                {
                    $nama_bank = null;
                    $no_rekening = $no_rekening;
                }elseif($karyawan->nama_bank !== null &&  $karyawan->no_rek == null)
                {
                    $nama_bank = $nama_bank;
                    $no_rekening = null;
                }
    
                $informasigaji = Informasigaji::where('id_karyawan',$karyawan->id)->where('status',1)->first();
                $id_informasigaji = $informasigaji->id;
                if($informasigaji === null)
                {
                    $id_informasigaji = null;
                }else
                {
                        $id_informasigaji =  $id_informasigaji;
                        $detail = Detailinformasigaji::where('id_informasigaji',$id_informasigaji)->get();
                        $cek = Penggajian::where( 'id_karyawan', $karyawan->id)
                            ->where('tglawal',$tgl_awal)
                            ->where('tglakhir',$tgl_akhir)
                            ->exists();
                        // $penggajian = Penggajian::firstOrNew([
                        //     'id_karyawan' => $request->id_karyawan,
                        //     'tglawal' => $tgl_awal,
                        //     'tglakhir' => $tgl_akhir,
                        // ]);
                        if(!$cek)
                        {
                            $penggajian = new Penggajian();
                            $penggajian->tglgajian = $tglgajian;
                            $penggajian->id_karyawan = $karyawan->id;
                            $penggajian->id_informasigaji = $id_informasigaji;
                            $penggajian->id_grup = $penggajiangrup_id;
                            $penggajian->id_strukturgaji  = $informasigaji->id_strukturgaji;
                            $penggajian->tglawal = $tgl_awal;
                            $penggajian->tglakhir = $tgl_akhir;
                            $penggajian->gaji_pokok = $karyawan->gaji ? $karyawan->gaji : $informasigaji->gaji_pokok;
                            $penggajian->lembur     = null;
                            $penggajian->tunjangan  = null;
                            $penggajian->gaji_kotor = null;
                            $penggajian->asuransi   = null;
                            $penggajian->potongan   = null;
                            $penggajian->pajak      = null;
                            $penggajian->gaji_bersih = null;
                            $penggajian->nama_bank   = $karyawan->nama_bank ? $karyawan->nama_bank : null;
                            $penggajian->no_rekening = $karyawan->no_rek ? $karyawan->no_rek : null;
                            $penggajian->partner    = $request->partner;
                            $penggajian->statusmail = 0;
                
                            // dd($penggajian->id_karyawan,$penggajian->gaji_pokok);
                            $penggajian->save();
    
                            $detailkehadiran = Detailkehadiran::where('id_karyawan',  $karyawan->id)
                            ->where(function ($query) use ($tgl_awal,$tgl_akhir) {
                                $query->whereBetween('tgl_awal', [$tgl_awal, $tgl_akhir])
                                    ->orWhereBetween('tgl_akhir', [$tgl_awal, $tgl_akhir]);
                            })
                            ->first();
        
                            if($detailkehadiran == null)
                            {
                                //jumlah hadir dalam rentahg tanggal gajian
                                $awal = date_format(date_create_from_format('d/m/Y', $request->tgl_mulai), 'Y-m-d');
                                $akhir = date_format(date_create_from_format('d/m/Y', $request->tgl_selesai), 'Y-m-d');
                                $hadir = Absensi::where('id_karyawan', $karyawan->id)
                                    ->whereBetween('tanggal', [$tgl_awal, $tgl_akhir])
                                    ->count();
        
                                $jamhadir = Absensi::selectRaw('SUM(TIME_TO_SEC(TIME(jml_jamkerja))) / 3600 AS total_jam')
                                    ->where('id_karyawan', $karyawan->id)
                                    ->whereBetween('tanggal', [$tgl_awal, $tgl_akhir])
                                    ->value('total_jam');
                                // dd($jamhadir);
        
                                //menghitung jumlah dan jam lembur karyawan
                                $lembur = Absensi::where('id_karyawan', $karyawan->id)
                                    ->where('lembur', '!=', null)
                                    ->whereBetween('tanggal', [$tgl_awal, $tgl_akhir])
                                    ->where('lembur','>','01:00:00')
                                    ->count();
        
                                $jamlembur = Absensi::selectRaw('SUM(TIME_TO_SEC(TIME(lembur))) / 3600 AS total_jam')
                                    ->where('id_karyawan', $karyawan->id)
                                    ->whereBetween('tanggal', [$tgl_awal, $tgl_akhir])
                                    ->where('lembur','>','01:00:00')
                                    ->value('total_jam');
        
                                $jadwal = Jadwal::where('partner',$karyawan->partner)
                                    ->whereBetween('tanggal',[$tgl_awal, $tgl_akhir])
                                    ->count();
        
                                //hitung jumlah sakit dalam 1 bulan
                                $izinSakit = Izin::where('id_karyawan', $karyawan->id)->where('id_jenisizin', 1)
                                    ->where(function ($query) use ($tgl_awal, $tgl_akhir) {
                                        $query->where(function ($q) use ($tgl_awal, $tgl_akhir) {
                                            $q->where('tgl_mulai', '>=', $tgl_awal)->where('tgl_mulai', '<=', $tgl_akhir);
                                        })->orWhere(function ($q) use ($tgl_awal, $tgl_akhir) {
                                            $q->where('tgl_selesai', '>=', $tgl_awal)->where('tgl_selesai', '<=', $tgl_akhir);
                                        })->orWhere(function ($q) use ($tgl_awal, $tgl_akhir) {
                                            $q->where('tgl_mulai', '<', $tgl_awal)->where('tgl_selesai', '>', $tgl_akhir);
                                        });
                                    })
                                    ->get();
        
                                $totalHariIzinSakit = 0;
                                $totalJamSakit = 0;
                                foreach ($izinSakit as $izinsakit)
                                {
                                    $tglMulai = \Carbon\Carbon::parse($izinsakit->tgl_mulai);
                                    $tglSelesai = \Carbon\Carbon::parse($izinsakit->tgl_selesai);
        
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
                                    
                                    $cocokkanTanggal = Jadwal::where('partner', $karyawan->partner)
                                        ->whereBetween('tanggal', [$tglHitungAwal, $tglHitungAkhir])
                                        ->count();
        
                                    if ($cocokkanTanggal > 0) {
                                        $totalHariIzinSakit = $cocokkanTanggal;
                                    }
        
                                    $jamTanggal = Jadwal::where('partner', $karyawan->partner)
                                        ->whereBetween('tanggal', [$tglHitungAwal, $tglHitungAkhir])
                                        ->get();
        
                                    foreach ($jamTanggal as $j) {
                                        $jamMasuk = \Carbon\Carbon::parse($j->jadwal_masuk);
                                        $jamPulang = \Carbon\Carbon::parse($j->jadwal_pulang);
        
                                        $selisihJam = $jamMasuk->diffInHours($jamPulang);
        
                                    $totalJamSakit += $selisihJam;
                                    }
                                }
        
                                //menghitung jumlah dan jam izin biasa karyawan
                                $izin = Izin::where('id_karyawan', $karyawan->id)->where('id_jenisizin', [2,5])
                                    ->where(function ($query) use ($tgl_awal, $tgl_akhir) {
                                        $query->where(function ($q) use ($tgl_awal, $tgl_akhir) {
                                            $q->where('tgl_mulai', '>=', $tgl_awal)->where('tgl_mulai', '<=', $tgl_akhir);
                                        })->orWhere(function ($q) use ($tgl_awal, $tgl_akhir) {
                                            $q->where('tgl_selesai', '>=', $tgl_awal)->where('tgl_selesai', '<=', $tgl_akhir);
                                        })->orWhere(function ($q) use ($tgl_awal, $tgl_akhir) {
                                            $q->where('tgl_mulai', '<', $tgl_awal)->where('tgl_selesai', '>', $tgl_akhir);
                                        });
                                    })
                                    ->get();
        
                                $totalHariIzin = 0;
                                $totalJamIzin = 0;
                                foreach ($izin as $izin)
                                {
                                    $tglMulai = \Carbon\Carbon::parse($izin->tgl_mulai);
                                    $tglSelesai = \Carbon\Carbon::parse($izin->tgl_selesai);
        
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
        
                                    $cocokkanTanggal = Jadwal::where('partner', $karyawan->partner)
                                        ->whereBetween('tanggal', [$tglHitungAwal, $tglHitungAkhir])
                                        ->count();
        
                                    if ($cocokkanTanggal > 0) {
                                        $totalHariIzin = $cocokkanTanggal;
                                    }
        
                                    if($izin->id_jenisizin == 2 && $izin->jam_mulai == NULL && $izin->jam_selesai == NULL)
                                    {
                                        $jamTanggal = Jadwal::where('partner', $karyawan->partner)
                                            ->whereBetween('tanggal', [$tglHitungAwal, $tglHitungAkhir])
                                            ->get();
        
                                        foreach ($jamTanggal as $j) {
                                            $jamMasuk = \Carbon\Carbon::parse($j->jadwal_masuk);
                                            $jamPulang = \Carbon\Carbon::parse($j->jadwal_pulang);
        
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
        
                                //menghitung jumlah dan jam cuti  biasa karyawan
                                $cuti = Cuti::where('id_karyawan',$karyawan->id)
                                    ->where(function ($query) use ($tgl_awal, $tgl_akhir) {
                                        $query->where(function ($q) use ($tgl_awal, $tgl_akhir) {
                                            $q->where('tgl_mulai', '>=', $tgl_awal)->where('tgl_mulai', '<=', $tgl_akhir);
                                        })->orWhere(function ($q) use ($tgl_awal, $tgl_akhir) {
                                            $q->where('tgl_selesai', '>=', $tgl_awal)->where('tgl_selesai', '<=', $tgl_akhir);
                                        })->orWhere(function ($q) use ($tgl_awal, $tgl_akhir) {
                                            $q->where('tgl_mulai', '<', $tgl_awal)->where('tgl_selesai', '>', $tgl_akhir);
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
        
                                    $cocokkanTanggal = Jadwal::where('partner', $karyawan->partner)
                                        ->whereBetween('tanggal', [$tglHitungAwal, $tglHitungAkhir])
                                        ->count();
        
                                    if ($cocokkanTanggal > 0) {
                                        $totalHariCuti = $cocokkanTanggal;
                                    }
                                    $jamTanggal = Jadwal::where('partner', $karyawan->partner)
                                        ->whereBetween('tanggal', [$tglHitungAwal, $tglHitungAkhir])
                                        ->get();
        
                                    foreach ($jamTanggal as $j) {
                                        $jamMasuk = \Carbon\Carbon::parse($j->jadwal_masuk);
                                        $jamPulang = \Carbon\Carbon::parse($j->jadwal_pulang);
        
                                        $selisihJam = $jamMasuk->diffInHours($jamPulang);
        
                                    $totalJamCuti += $selisihJam;
                                    }
                                }
        
                                $detailkehadiran = Detailkehadiran::firstOrNew(
                                    [
                                        'id_karyawan' => $karyawan->id,
                                        'tgl_awal' => $awal,
                                        'tgl_akhir' => $akhir,
                                    ]);
        
                                $detailkehadiran->total_jadwal = $jadwal ? $jadwal : 0;
                                $detailkehadiran->jumlah_hadir = $hadir ? $hadir : 0;
                                $detailkehadiran->jumlah_lembur= $lembur ? $lembur : 0;
                                $detailkehadiran->jumlah_cuti  = $totalHariCuti ? $totalHariCuti : 0;
                                $detailkehadiran->jumlah_izin  = $totalHariIzin ? $totalHariIzin : 0;
                                $detailkehadiran->jumlah_sakit = $totalHariIzinSakit ? $totalHariIzinSakit : 0;
                                $detailkehadiran->jam_hadir    = $jamhadir ? $jamhadir : 0;
                                $detailkehadiran->jam_lembur   = $jamlembur ? $jamlembur : 0;
                                $detailkehadiran->jam_cuti     = $totalJamCuti ? $totalJamCuti : 0;
                                $detailkehadiran->jam_izin     = $totalJamIzin ? $totalJamIzin : 0;
                                $detailkehadiran->jam_sakit    = $totalJamSakit ? $totalJamSakit : 0;
                                $detailkehadiran->partner      = $karyawan->partner;
        
                                $detailkehadiran->save();
        
                            }
                        }
                    }
            }
            return redirect()->back()->with('pesan','Data berhasil disimpan');
        }else{
            return redirect()->back()->with('pesa','Data sudah ada pada sistem');
        }

        
    }

    public function showslipgrup(Request $request, $id)
    {
        $role = Auth::user()->role;
        if($role === 1 || $role === 6)
        {
            $row = Karyawan::where('id',Auth::user()->id_pegawai)->first();
            $penggajiangrup = PenggajianGrup::where('id',$id)->first();
            $slipgaji = Penggajian::where(function($query) use ($penggajiangrup) {
                $query->where('tglgajian', $penggajiangrup->tglgajian)
                      ->where('tglawal', $penggajiangrup->tglawal)
                      ->where('tglakhir', $penggajiangrup->tglakhir)
                      ->orWhere(function($subquery) use ($penggajiangrup) {
                          $subquery->where('id_grup', $penggajiangrup->id)
                                   ->orWhereNull('id_grup');
                      });
            })->get();
            
            $karyawan = Karyawan::where('partner', $row->partner)
                ->where('status_kerja', 'Aktif')
                ->whereNull('tglkeluar')
                ->get();  

            //notifikasi data karyawan yang elum punya slip gaji bulan ini
            $slipgajiKaryawanIds = $slipgaji->pluck('id_karyawan')->toArray();
            $karyawanBelumAdaSlip = Karyawan::where('partner', $row->partner)
                ->where('status_kerja', 'Aktif')
                ->whereNull('tglkeluar')
                ->whereNotIn('id', $slipgajiKaryawanIds)
                ->get();
            $namajabatan = Jabatan::where('partner',$row->partner)->get();
            $leveljabatan = LevelJabatan::all();
            $departemen = Departemen::where('partner',$row->partner)->get();
            $output = [
                'row' => $row,
                'karyawan' => $karyawan,
                'slipgaji' => $slipgaji,
                'role' => $role,
                'namajabatan' => $namajabatan,
                'leveljabatan' => $leveljabatan,
                'departemen' => $departemen,
                'karyawanBelumAdaSlip'=> $karyawanBelumAdaSlip,
            ];
            return view('admin.penggajian.slipgrup',$output);
        }else{
            return redirect()->back();
        }
    }

    public function updateRekening(Request $request,$id)
    {
        // dd($request->all(),$id);
        $karyawan = Karyawan::find($id);
        $gaji = preg_replace('/[^0-9]/', '', $request->gajiKaryawan);
        $gajiKaryawan = (float) $gaji;

        $data = array(
            'nama' => $request->post('namaKaryawan'),
            'divisi' => $request->post('divisi'),
            'nama_jabatan' => $request->post('namaJabatan'),
            'jabatan' => $request->post('leveljabatanKaryawan'),
            'gaji' => $gaji,
            'nama_bank' => $request->post('nama_bank'),
            'no_rek' => $request->post('nomor_rekening'),
            'status_karyawan' => $request->post('statusKaryawan'),
            'tglmasuk' => \Carbon\Carbon::createFromFormat('d/m/Y', $request->tglmasukKaryawan)->format('Y-m-d'),
        );

        Karyawan::where('id', $id)->update($data);
        $karyawan = $karyawan;
     
        $informasigaji = Informasigaji::where('id_karyawan',$karyawan->id)
            ->where('status',1)
            ->first();
        $penggajian = Penggajian::where('id_karyawan',$karyawan->id)->first();
        $level = Leveljabatan::where('nama_level',$data['jabatan'])->first();
        
        if($karyawan->status_karyawan !== $data['status_karyawan'] || $karyawan->jabatan !== $level->nama_level)
        {
            if (isset($informasigaji))
            {
                $informasigaji = $informasigaji->update([
                    'status' => 0,
                ]);
                $strukturgaji   = SalaryStructure::where('id_level_jabatan',$level->id)
                    ->where('status_karyawan',$data['status_karyawan'])
                    ->first();

                $informasigaji = new Informasigaji();
                $informasigaji->id_karyawan     = $karyawan->id;
                $informasigaji->id_strukturgaji = $strukturgaji->id;
                $informasigaji->status_karyawan = $strukturgaji->status_karyawan;
                $informasigaji->level_jabatan   = $strukturgaji->id_level_jabatan;
                $informasigaji->gaji_pokok      = $karyawan->gaji;
                $informasigaji->partner         = $strukturgaji->partner;
                $informasigaji->status          = 1;

                $informasigaji->save();

                $informasigaji = Informasigaji::where('id_karyawan',$karyawan->id)->where('status',1)->first();
                $detailstruktur = DetailSalaryStructure::where('id_salary_structure', $strukturgaji->id)->get();
                $details = [];
                foreach($detailstruktur as $detail)
                {
                    $benefit  = Benefit::where('id',$detail->id_benefit)->first();

                    $check = Detailinformasigaji::where('id_karyawan', $karyawan->id)
                            ->where('id_informasigaji',$informasigaji->id)
                            ->where('id_struktur',$strukturgaji->id)
                            ->where('id_benefit',$detail->id_benefit)
                            ->where('partner',$karyawan->partner)
                            ->exists();
                    // dd($check);

                    if(!$check)
                    {
                        $nominal = null;
                        if($benefit->id == 1)
                        {
                            $nominal = $informasigaji->gaji_pokok;
                        }else
                        {
                            if($benefit->siklus_pembayaran == "Bulan")
                            {
                                $nominal      = $benefit->besaran_bulanan;
                            }else if($benefit->siklus_pembayaran == "Minggu")
                            {
                                $nominal      = $benefit->besaran_mingguan;
                            }else if($benefit->siklus_pembayaran == "Hari")
                            {
                                $nominal      = $benefit->besaran_harian;
                            }else if($benefit->siklus_pembayaran == "Jam")
                            {
                                $nominal      = $benefit->besaran_jam;
                            }else if($benefit->siklus_pembayaran == "Bonus")
                            {
                                $nominal      = $benefit->besaran;
                            }else
                            {
                                $nominal      = $benefit->besaran;
                            }
                        }

                        $details[] = [
                            'id_karyawan'      =>$informasigaji->id_karyawan,
                            'id_informasigaji' =>$informasigaji->id,
                            'id_struktur'      =>$informasigaji->id_strukturgaji,
                            'id_benefit'       =>$benefit->id,
                            'siklus_bayar'     =>$benefit->siklus_pembayaran,
                            'partner'          =>Auth::user()->partner,
                            'nominal'          =>$nominal,
                        ];
                    }

                }
                Detailinformasigaji::insert($details);
            }
        }
        $informasigaji = Informasigaji::where('id_karyawan', $karyawan->id)->where('status',1)->update([
            'gaji_pokok' => $gajiKaryawan,
        ]);
        $detailinformasigaji = Detailinformasigaji::where('id_karyawan', $karyawan->id)->where('id_benefit',1)->update([
            'nominal' => $gajiKaryawan,
        ]);
        $penggajian = Penggajian::where('id',$request->id_slip)->update([
            'gaji_pokok' => $gajiKaryawan,
            'nama_bank' => $request->nama_bank,
            'no_rekening' => $request->nomor_rekening,
        ]);
        return redirect()->back()->with('pesan','Data Karyawan berhasil di update.');
    }

    public function update(Request $request, $id)
    {

        $tgl_penggajian = Carbon::createFromFormat('d/m/Y', $request->tgl_penggajian)->format('Y-m-d');
        $tgl_mulai = Carbon::createFromFormat('d/m/Y', $request->tgl_mulai)->format('Y-m-d');
        $tgl_selesai = Carbon::createFromFormat('d/m/Y', $request->tgl_selesai)->format('Y-m-d');

        $slipgrupindex = PenggajianGrup::find($id);

        $slipgrupindex->nama_grup = $request->nama;
        // $slipgrupindex->id_struktur = $request->id_struktur;
        $slipgrupindex->tglawal = $tgl_mulai;
        $slipgrupindex->tglakhir = $tgl_selesai;
        $slipgrupindex->tglgajian = $tgl_penggajian;
        $slipgrupindex->partner = $request->partner;
        $slipgrupindex->save();

        return redirect()->back()->with('pesan', 'Data berhasil diupdate');
    }

    public function slipgajipdf (Request $request,$id)
    {
        $setorganisasi = SettingOrganisasi::where('partner', Auth::user()->partner)->first();
        $slipgaji = Penggajian::with('karyawans')->where('id',$id)->first();
        $karyawan = Karyawan::where('id',$slipgaji->id_karyawan)->first();
        $detailgaji = DetailPenggajian::where('id_penggajian',$slipgaji->id)->get();
        $detailinformasi= Detailinformasigaji::with('karyawans','benefit')
                ->where('id_karyawan',$karyawan->id)
                ->whereHas('benefit', function ($query) {
                    $query->where('partner', '!=', 0);
                })
                ->get();


        $pdf = PDF::loadview('admin.penggajian.slipgajipdf',[
            'setorganisasi' => $setorganisasi,
            'slipgaji' => $slipgaji,
            'karyawan' => $karyawan,
            'detailgaji' => $detailgaji,
            'detailinformasi' => $detailinformasi,
        ])
        ->setPaper('a4','potrait');
        return $pdf->stream("Slip Gaji " . \Carbon\Carbon::parse($slipgaji->tglgajian)->format('d/m/Y') ." ". $karyawan->nama . ".pdf");
    }






















    public function hitunggaji(Request $request)
    {
        $role = Auth::user()->role;
        if ($role == 1 ||$role == 6)
        {
            $slipgaji = Penggajian::where('id',$request->id_slip)->first();
            $karyawan = Karyawan::where('id',$request->id_karyawan)->first();
            $informasigaji = Informasigaji::with('karyawans')->where('id_karyawan',$karyawan->id)->where('status',1)->first();
            $kehadiran = Detailkehadiran::where('id_karyawan',$karyawan->id)->first();
            $strukturgaji = SalaryStructure::where('id',$informasigaji->id_strukturgaji)->first();
            $detailstruktur = DetailSalaryStructure::where('id_salary_structure',$strukturgaji->id)->get();

            $detailinformasis = Detailinformasigaji::with('karyawans')
                ->join('benefit', 'detail_informasigaji.id_benefit', '=', 'benefit.id')
                ->join('kategoribenefit', 'benefit.id_kategori', '=', 'kategoribenefit.id')
                ->select('detail_informasigaji.*','benefit.nama_benefit','benefit.id_kategori','benefit.jumlah','benefit.kode','benefit.aktif','benefit.dikenakan_pajak','benefit.kelas_pajak','benefit.muncul_dipenggajian','benefit.siklus_pembayaran','benefit.urutan','benefit.tipe','benefit.gaji_minimum','benefit.gaji_maksimum','benefit.besaran_bulanan','benefit.besaran_mingguan' ,'benefit.besaran_harian' ,'benefit.besaran_jam' ,'benefit.besaran' ,'benefit.dibayarkan_oleh','kategoribenefit.nama_kategori','kategoribenefit.kode as kode_kategori')
                ->where('detail_informasigaji.id_informasigaji', $informasigaji->id)
                ->where('detail_informasigaji.id_karyawan',$informasigaji->id_karyawan)
                ->get();
            // dd($detailinformasis);

            $gajikotor = 0;
            $tunjangan = 0;
            $asuransi = 0;
            $potongan = 0;
            $totalpotongan = 0;
            $gajibersih = 0;
            $lembur = 0;

            foreach ($detailinformasis as $detail)
            {
                // dd($detail);
                switch ($detail->id_kategori) {
                    case 1:
                        $gajipokok = $detail->nominal;
                        break;
                    case 4:
                        // dd($detail,$kehadiran);
                        if ($detail->siklus_bayar == 'Bulan') {
                            $tunjangan += $detail->nominal * $detail->jumlah;
                        } elseif ($detail->siklus_bayar == 'Hari') {
                            // Misalnya, asumsikan Anda memiliki $detail_kehadiran sebagai referensi
                            $jumlah_hadir = $kehadiran->jumlah_hadir;
                            $tunjangan += $detail->nominal * $jumlah_hadir;
                        } elseif ($detail->siklus_bayar == 'Jam') {
                            // dd($detail);
                            if(Str::contains($detail->nama_benefit, 'Lembur'))
                            {
                                $jam = $kehadiran->jam_lembur;
                                $tunjangan += $detail->nominal * $jam;
                                $lembur = $detail->nominal * $jam;
                            }else{
                                $tunjangan += $detail->nominal * $detail->jumlah;
                            }
                        }
                        break;
                    case 5:
                        // dd($detail->nominal);
                        $asuransi += $detail->nominal;
                        // dd($detail,$asuransi);
                        break;
                    case 6:
                        $potongan += $detail->nominal;
                        break;
                }
            }

            $gajikotor = $gajipokok + $tunjangan;
            $totalpotongan = $asuransi + $potongan;
            $gajibersih = $gajikotor - $totalpotongan;
            // dd($gajipokok,$gajikotor, $tunjangan,$totalpotongan,$gajibersih,$lembur);

            $dataupdate = [
                'lembur'     => $lembur ? $lembur : 0,
                'tunjangan'  => $tunjangan ? $tunjangan : 0,
                'gaji_kotor' => $gajikotor ? $gajikotor : 0,
                'asuransi'   => $asuransi ? $asuransi : 0,
                'potongan'   => $totalpotongan ? $totalpotongan : 0,
                'pajak'      => 0,
                'gaji_bersih'=> $gajibersih ? $gajibersih : 0,
            ];
            // dd($dataupdate);

            $slipgaji->update($dataupdate);

            $slipgaji = Penggajian::where('id',$slipgaji->id)->first();
            $kehadiran = Detailkehadiran::where('id_karyawan',$karyawan->id)
                ->where('tgl_awal',$slipgaji->tglawal)
                ->where('tgl_akhir',$slipgaji->tglakhir)
                ->first();
            foreach($detailinformasis as $detail)
            {
                if($detail->id_kategori == 1)
                {
                    $nominal = $gajipokok;
                    $jumlah  = $detail->jumlah;
                    $total   = $gajipokok;
                    // dd($nominal,$jumlah,$total);
                }
                else if($detail->id_kategori == 2)
                {
                    $nominal = $gajikotor;
                    $jumlah  = $detail->jumlah;
                    $total   = $gajikotor;
                    // dd($nominal,$jumlah,$total);
                }else if($detail->id_kategori == 3)
                {
                    $nominal = $gajibersih;
                    $jumlah  = $detail->jumlah;
                    $total   = $gajibersih;
                    // dd($nominal,$jumlah,$total);
                }
                else if($detail->id_kategori == 4)
                {
                    $nominal = $detail->nominal;
                    // dd($detail);
                    if($detail->siklus_pembayaran == "Bulan")
                    {
                        $hadir       = $kehadiran->jumlah_hadir;
                        $totaljadwal = $kehadiran->total_jadwal;
                        $jumlah      = $detail->jumlah;
                        // dd($detail,$jumlah,$totaljadwal,$hadir);
                        if($hadir == $totaljadwal)
                        {
                            $total = $detail->nominal * $jumlah;
                            $total = $total;
                            // dd($detail,$total);
                        }else if($hadir <= $totaljadwal)
                        {
                            $totala = $nominal / $totaljadwal;
                            $total = $totala * $hadir;
                            $total = $total;
                            // dd($total);
                        }

                        // dd($detail,$hadir,$totaljadwal,$jumlah,$total);
                    }else if($detail->siklus_pembayaran == "Hari")
                    {
                        // dd($kehadiran);
                        $jumlah  = $kehadiran->jumlah_hadir;
                        $total   = $detail->nominal * $kehadiran->jumlah_hadir;

                        // dd($detail,$jumlah,$total);
                    }else if($detail->siklus_pembayaran == "Jam")
                    {
                        // dd($detail);
                        if(Str::contains($detail->nama_benefit, 'Lembur'))
                        {
                            $jumlah  = $kehadiran->jam_lembur;
                            $jam = $kehadiran->jam_lembur;
                            $total = $lembur;
                            // dd($detail,$jumlah,$total,$jam);
                        }else{
                            $jumlah = $kehadiran->jumlah_hadir;
                            $total  = $detail->nominal * $jumlah;
                            dd($detail,$jumlah,$total,$jam);
                        }
                        // dd($detail,$total);
                    }
                    else if($detail->siklus_pembayaran == "Bonus")
                    {
                        $jumlah  = $detail->jumlah;
                        $total   = $detail->nominal;
                    }
                }else if($detail->id_kategori == 5)
                {
                    $nominal = $detail->nominal;
                    $jumlah = $detail->jumlah;
                    $total = $nominal * $jumlah;
                }

                //    dd($detail);
                $cek = DetailPenggajian::where('id_karyawan',$slipgaji->id_karyawan)
                    ->where('id_penggajian',$slipgaji->id)
                    ->where('id_benefit',$detail->id_benefit)
                    ->where('id_detailinformasigaji',$detail->id)
                    ->first();
                if($cek === null)
                {
                    $detailgaji = new DetailPenggajian();
                    $detailgaji->id_karyawan            = $slipgaji->id_karyawan;
                    $detailgaji->id_penggajian          = $slipgaji->id;
                    $detailgaji->id_benefit             = $detail->id_benefit;
                    $detailgaji->id_detailinformasigaji = $detail->id;
                    $detailgaji->nominal = isset($nominal) ? $nominal : 0;
                    $detailgaji->jumlah  = isset($jumlah) ?  $jumlah : 0;
                    $detailgaji->total   = isset($total) ? $total : 0;

                    $detailgaji->save();
                }
                // dd($detail,$detail->id_benefit,$slipgaji->id,$slipgaji->id_karyawan,$detail->id_informasigaji);

            }

            $pesan = "Penghitungan Gaji karyawan sudah selesai";

            $a = \Carbon\Carbon::parse($slipgaji->tglawal)->format('d/m/Y');
            $b = \Carbon\Carbon::parse($slipgaji->tglakhir)->format('d/m/Y');
            $periode  = $a . ' s.d ' . $b;
            $tglgajian = \Carbon\Carbon::parse($slipgaji->tglgajian)->format('d/m/Y');
            $tujuan = $karyawan->email;
            $nama = ucwords(strtolower($karyawan->nama));
            $setorganisasi = Settingorganisasi::where('partner',$karyawan->partner)->first();

            //mengirim email notifikasi slip gaji kepada karyawan
            if($slipgaji->statusmail === 0)
            {
                $setorganisasi = SettingOrganisasi::where('partner', Auth::user()->partner)->first();
                $slipgaji = Penggajian::with('karyawans')->where('id',$slipgaji->id)->first();
                $karyawan = Karyawan::where('id',$slipgaji->id_karyawan)->first();
                $detailgaji = DetailPenggajian::where('id_penggajian',$slipgaji->id)->get();
                $detailinformasi= Detailinformasigaji::with('karyawans','benefit')
                        ->where('id_karyawan',$karyawan->id)
                        ->whereHas('benefit', function ($query) {
                            $query->where('partner', '!=', 0);
                        })
                        ->get();
                $tgllahir = $karyawan->tgllahir;
                $passpdf = date('dmY', strtotime($tgllahir));

                $datapdf = [
                    'setorganisasi' => $setorganisasi,
                    'slipgaji' => $slipgaji,
                    'karyawan' => $karyawan,
                    'detailgaji' => $detailgaji,
                    'detailinformasi' => $detailinformasi,
                    'password' => $passpdf
                ];
                $data = [
                    'subject' => "Notifikasi Slip Gaji - " . $nama . " - [" . $periode . "]",
                    'periode' => $periode,
                    'tglgajian' => $tglgajian,
                    'nama' => $nama,
                    'emailperusahaan' => $setorganisasi->email,
                    'notelpperusahaan' => $setorganisasi->no_telp,
                ];
                Mail::to($tujuan)->send(new SlipgajiNotification($data,$datapdf));
                $dataupdate = [
                    'statusmail'=> 1,
                ];
                $pesan = "Email Notifikasi E-slip gaji berhasil diterbitkan.";
            }

            $slipgaji->update($dataupdate);

            // data yang ditampilkan pada form slip gaji
            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
            $detailinformasi= Detailinformasigaji::with('karyawans','benefit')
                ->where('id_karyawan',$karyawan->id)
                ->where('partner','!=',0)
                ->get();

            $detailgaji = DetailPenggajian::where('id_penggajian',$slipgaji->id)->get();
            return view('admin.penggajian.slipgajifix', compact('slipgaji', 'detailinformasi', 'role', 'pesan', 'kehadiran', 'row', 'detailgaji'))
            ->with('pesan', $pesan); 
        }       
        else {

            return redirect()->back();
        }
    }

    public function showslipgajifix(Request $request,$id)
    {
        $nip = $request->input('nip');
        $id = $request->id;
        $role = Auth::user()->role;
        if ($role == 1 ||$role == 6)
        {
            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
            $slipgaji = Penggajian::with('karyawans')->where('id',$id)->first();
            $karyawan = Karyawan::where('id',$slipgaji->id_karyawan)->first();
            $informasigaji = Informasigaji::with('karyawans')
                    ->where('id_karyawan',$karyawan->id)
                    ->first();

            $detailinformasi= Detailinformasigaji::with('karyawans','benefit')
                ->where('id_karyawan',$karyawan->id)
                ->whereHas('benefit', function ($query) {
                    $query->where('partner', '!=', 0);
                })
                ->get();

            $kehadiran = Detailkehadiran::where('id_karyawan',$karyawan->id)->first();

            $jadwal = Jadwal::whereBetween('tanggal', [$slipgaji->tglawal, $slipgaji->tglakhir])
                ->where('partner', $row->partner)
                ->count();

            $detailgaji = DetailPenggajian::where('id_penggajian',$slipgaji->id)->where('status',1)->get();
            dd($detailgaji);
            return view('admin.penggajian.slipgajifix',compact('row','role','karyawan','slipgaji','kehadiran','informasigaji','detailinformasi','detailgaji'));
        }else {

            return redirect()->back();
        }
    }

}
