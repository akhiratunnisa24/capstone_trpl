<?php

namespace App\Http\Controllers\admin;

use PDF;
use Carbon\Carbon;
use App\Models\Cuti;
use App\Models\Izin;
use App\Models\Jadwal;
use App\Models\Absensi;
use App\Models\Benefit;
use App\Models\Karyawan;
use App\Models\Penggajian;
use App\Models\Tidakmasuk;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Informasigaji;
use App\Models\PenggajianGrup;
use App\Models\Detailkehadiran;
use App\Models\SalaryStructure;
use App\Models\DetailPenggajian;
use App\Models\SettingOrganisasi;
use Illuminate\Support\Facades\DB;
use App\Models\Detailinformasigaji;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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
            $karyawan = Karyawan::where('partner',$row->partner)->get();
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
            ->select('karyawan.nama_jabatan','karyawan.id' ,'karyawan.partner','karyawan.nama','karyawan.divisi', 'karyawan.nip', 'departemen.nama_departemen','karyawan.nama_bank','karyawan.no_rek')
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

        $informasigaji = Informasigaji::where('id_karyawan',$request->id_karyawan)->first();
        // dd($informasigaji);
        if($informasigaji == null)
        {
            $pesan = "Data <strong><span style='color: red;'>Informasi Gaji</span></strong> karyawan belum lengkap,<br> silahkan lengkapi dan Coba lagi. <br><br><strong><a href='" . route('editidentitas', ['id' => $karyawan->id]) . "' class='btn btn-sm btn-info'>Lengkapi Data</a></strong> <br>";
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
            $penggajian->gaji_pokok = $informasigaji->gaji_pokok;
            $penggajian->lembur = null;
            $penggajian->tunjangan = null;
            $penggajian->gaji_kotor = null;
            $penggajian->asuransi = null;
            $penggajian->potongan = null;
            $penggajian->pajak = null;
            $penggajian->gaji_bersih = null;
            $penggajian->nama_bank = $request->nama_bank;
            $penggajian->no_rekening = $request->nomor_rekening;
            $penggajian->partner = $request->partner;

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
                    $selisihHari = $tglMulai->diffInDays($tglSelesai) + 1; 

                    $totalHariIzinSakit += $selisihHari;

                    $cocokkanTanggal = Jadwal::where('partner', $getKaryawan->partner)
                        ->whereBetween('tanggal', [$tglMulai, $tglSelesai])
                        ->count();

                    if ($cocokkanTanggal > 0) {
                        $totalHariIzinSakit = $cocokkanTanggal;
                    }

                    $jamTanggal = Jadwal::where('partner', $getKaryawan->partner)
                        ->whereBetween('tanggal', [$tglMulai, $tglSelesai])
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
                    $selisihHari = $tglMulai->diffInDays($tglSelesai) + 1; 

                    $totalHariIzin += $selisihHari;

                    $cocokkanTanggal = Jadwal::where('partner', $getKaryawan->partner)
                        ->whereBetween('tanggal', [$tglMulai, $tglSelesai])
                        ->count();

                    if ($cocokkanTanggal > 0) {
                        $totalHariIzin = $cocokkanTanggal;
                    }

                    if($izin->id_jenisizin == 2 && $izin->jam_mulai == NULL && $izin->jam_selesai == NULL)
                    {
                        $jamTanggal = Jadwal::where('partner', $getKaryawan->partner)
                            ->whereBetween('tanggal', [$tglMulai, $tglSelesai])
                            ->get();

                        foreach ($jamTanggal as $j) {
                            $jamMasuk = \Carbon\Carbon::parse($j->jadwal_masuk);
                            $jamPulang = \Carbon\Carbon::parse($j->jadwal_pulang);
                    
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
                $detailkehadiran->jumlah_lembur = $lembur ? $lembur : 0;
                $detailkehadiran->jumlah_cuti = $totalHariCuti ? $totalHariCuti : 0;
                $detailkehadiran->jumlah_izin = $totalHariIzin ? $totalHariIzin : 0;
                $detailkehadiran->jumlah_sakit = $totalHariIzinSakit ? $totalHariIzinSakit : 0;
                $detailkehadiran->jam_hadir = $jamhadir ? $jamhadir : 0;                    
                $detailkehadiran->jam_lembur = $jamlembur ? $jamlembur : 0;
                $detailkehadiran->jam_cuti = $totalJamCuti ? $totalJamCuti : 0;                    
                $detailkehadiran->jam_izin = $totalJamIzin ? $totalJamIzin : 0;
                $detailkehadiran->jam_sakit = $totalJamSakit ? $totalJamSakit : 0;                   
                $detailkehadiran->partner = $getKaryawan->partner;
                    
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

            // dd($slipgaji,$kehadiran,$id,$detailinformasi);
            return view('admin.penggajian.slip',compact('row','role','karyawan','slipgaji','kehadiran','informasigaji','detailinformasi'));
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
            $karyawan = Karyawan::where('partner',$row->partner)->get();
            $slipgrupindex = PenggajianGrup::where('partner',$row->partner)->get();
            $slipgrup = SalaryStructure::where('partner',$row->partner)->get();

            return view('admin.penggajian.indexgrup',compact('row','role','karyawan','slipgrup','slipgrupindex'));
        }else {

            return redirect()->back();
        }
    }

    public function storepenggajian_grup(Request $request)
    {
        $tgl_penggajian = Carbon::createFromFormat('d/m/Y', $request->tgl_penggajian)->format('Y-m-d');
        $tgl_mulai = Carbon::createFromFormat('d/m/Y', $request->tgl_mulai)->format('Y-m-d');
        $tgl_selesai = Carbon::createFromFormat('d/m/Y', $request->tgl_selesai)->format('Y-m-d');

        PenggajianGrup::create([
            'nama_grup' => $request->nama,
            'id_struktur' => $request->id_struktur,
            'tglawal' => $tgl_mulai,
            'tglakhir' => $tgl_selesai,
            'tglgajian' => $tgl_penggajian,
            'partner' => $request->partner,
        ]);

        return redirect()->back()->with('pesan','Data berhasil disimpan');
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

    public function slipgajipdf (Request $request)
    {
        $setorganisasi = SettingOrganisasi::where('partner', Auth::user()->partner)->first();
        $pdf = PDF::loadview('admin.penggajian.slipgajipdf')
            ->setPaper('a4','potrait');
        return $pdf->stream();
    }






















    public function hitunggaji(Request $request)
    {
        $role = Auth::user()->role;
        if ($role == 1 ||$role == 6)
        {
            $slipgaji = Penggajian::where('id',$request->id_slip)->first();
            $karyawan = Karyawan::where('id',$request->id_karyawan)->first();
            $informasigaji = Informasigaji::with('karyawans')->where('id_karyawan',$karyawan->id)->first();
            $kehadiran = Detailkehadiran::where('id_karyawan',$karyawan->id)->first();
            $strukturgaji = SalaryStructure::where('id',$informasigaji->id_strukturgaji)->first();
            $detailstruktur = DetailSalaryStructure::where('id_salary_structure',$strukturgaji->id)->get();

            $detailinformasis = Detailinformasigaji::with('karyawans')
                ->join('benefit', 'detail_informasigaji.id_benefit', '=', 'benefit.id')
                ->join('kategoribenefit', 'benefit.id_kategori', '=', 'kategoribenefit.id')
                ->select('detail_informasigaji.*','benefit.nama_benefit','benefit.id_kategori','benefit.kode','benefit.aktif','benefit.dikenakan_pajak','benefit.kelas_pajak','benefit.muncul_dipenggajian','benefit.siklus_pembayaran','benefit.urutan','benefit.tipe','benefit.gaji_minimum','benefit.gaji_maksimum','benefit.besaran_bulanan','benefit.besaran_mingguan' ,'benefit.besaran_harian' ,'benefit.besaran_jam' ,'benefit.besaran' ,'benefit.dibayarkan_oleh','kategoribenefit.nama_kategori','kategoribenefit.kode as kode_kategori')
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
                        $asuransi += $detail->nominal;
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
                }

                $detailgaji = DetailPenggajian::firstOrNew([
                    'id_karyawan' => $slipgaji->id_karyawan,
                    'id_penggajian'=> $slipgaji->id,
                    'id_benefit'  => $detail->id_benefit,
                    'id_detailinformasigaji' =>$detail->id,
                ]);
              
                $detailgaji->nominal = isset($nominal) ? $nominal : 0;
                $detailgaji->jumlah  = isset($jumlah) ?  $jumlah : 0;
                $detailgaji->total   = isset($total) ? $total : 0;

                $detailgaji->save();
            }
          
            $pesan = "Penghitungan Gaji karyawan sudah selesai";
            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
            $detailinformasi= Detailinformasigaji::with('karyawans','benefit')
                ->where('id_karyawan',$karyawan->id)
                ->where('partner','!=',0)
                ->get();

            $detailgaji = DetailPenggajian::where('id_penggajian',$slipgaji->id)->get();

            return view('admin.penggajian.slipgajifix', compact('slipgaji', 'detailinformasi','role', 'pesan','kehadiran','row','detailgaji'));
        }
        else {

            return redirect()->back();
        }
    }

    public function showslipgajifix(Request $request)
    {
        $nip = $request->input('nip');
        $id = $request->id;
        $role = Auth::user()->role;
        if ($role == 1 ||$role == 6)
        {
            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
            $karyawan = Karyawan::where('partner',$row->partner)->first();
            $informasigaji = Informasigaji::with('karyawans')
                    ->where('id_karyawan',$karyawan->id)
                    ->first();

            $detailinformasi= Detailinformasigaji::with('karyawans','benefit')
                ->where('id_karyawan',$karyawan->id)
                ->where('benefit.partner','!=',0)
                ->get();
            foreach($detailinformasi as $d){
                dd($d);
            }

            $kehadiran = Detailkehadiran::where('id_karyawan',$karyawan->id)->first();
            $slipgaji = Penggajian::with('karyawans')->where('id',$id)->first();
            $jadwal = Jadwal::whereBetween('tanggal', [$slipgaji->tglawal, $slipgaji->tglakhir])
                ->where('partner', $row->partner)
                ->count();

            $detailgaji = DetailPenggajian::where('id_penggajian',$slipgaji->id)->get();
            dd($detailgaji);

            return view('admin.penggajian.slip',compact('row','role','karyawan','slipgaji','kehadiran','informasigaji','detailinformasi','detailgaji'));
        }else {

            return redirect()->back();
        }
    }

}
