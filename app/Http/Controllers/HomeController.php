<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Cuti;
use App\Models\Izin;
use App\Models\User;
use App\Models\Jadwal;
use App\Models\Resign;
use App\Models\Absensi;
use App\Models\Karyawan;
use App\Models\Lowongan;
use App\Models\Sisacuti;
use App\Models\Informasi;
use App\Models\Rekruitmen;
use App\Models\Tidakmasuk;
use App\Models\Alokasicuti;
use Illuminate\Http\Request;
use App\Models\Settingabsensi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;
use Carbon\CarbonInterface;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function registrasi(Request $data)
    {
        $karyawan = Karyawan::where('id', $data['id_pegawai'])->first();
        $data = array(
            'role' => $data['role'],
            'id_pegawai' => $data['id_pegawai'],
            'name' => $karyawan['nama'],
            'email' => $data['emailKaryawan'],
            'password' => Hash::make($data['password']),
            'status_akun' => true,
            'partner' => $data['partner'],
        );

        User::insert($data);
        return redirect('/karyawan')->with("pesan", "Akun untuk ". $data['name'] . " berhasil dibuat");
    }

    public function index()
    {
        // $role = Auth::user()->role;
        $role = Auth::user();
        $partner = Auth::user()->partner;
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();

        //========================================================= DAHSBOARD HRD MANAGER ========================================================

        $today = Carbon::now()->format('Y-m-d');
        $yesterday = Carbon::yesterday();

        //data jumlah karyawan perjabatan
        $jabatan = ['Komisaris', 'Direksi', 'Manager'];
        $jumlahKaryawanPerJabatan = Karyawan::groupBy('nama_jabatan')
            ->whereIn('jabatan', $jabatan)
            ->where('partner',Auth::user()->partner)
            ->select('nama_jabatan', DB::raw('count(*) as total'))
            ->get();

        $jumlahKaryawanPerJabatan2 = Karyawan::whereIn('jabatan', $jabatan)
            ->where('partner',Auth::user()->partner)
            ->count();

        //data karyawan
        $karyawan = Karyawan::groupBy('nama_jabatan')
            ->where('partner',Auth::user()->partner)
            ->select('nama_jabatan', DB::raw('count(*) as total'))
            ->get();

        $karyawan2 = Karyawan::where('partner',Auth::user()->partner)->get();
        $jumlahkaryawan = $karyawan2->count();

        //data permintaan resign karyawan
        $resign = Resign::join('karyawan', 'resign.id_karyawan', '=', 'karyawan.id')
            ->where(function ($query) {
                $query->where('resign.status', '=', '1')
                    ->where('karyawan.partner', '=', Auth::user()->partner)
                    ->where('karyawan.atasan_pertama', '=', Auth::user()->id_pegawai);
            })
            ->orWhere(function ($query) {
                $query->where('resign.status', '=', '6')
                    ->where('karyawan.partner', '=', Auth::user()->partner)
                    ->where('karyawan.atasan_kedua', '=', Auth::user()->id_pegawai);
            })

        ->select('resign.*','karyawan.partner')
        ->get();

        $resignjumlah = $resign->count();

        //data izin hari ini hrd
        $dataIzinHariinihrd = Izin::whereHas('karyawan', function ($query) use ($today) {
                $query->where('partner', '=', Auth::user()->partner);
            })
            ->where(function ($query) use ($today) {
                $query->where('tgl_mulai', '<=', $today)
                    ->where('tgl_selesai', '>=', $today);
            })
            ->where('status', '=', 7)
            ->count();

        //cuti hari ini hrd
        $cutiHariinihrd = Cuti::where(function ($query) use ($today) {
                $query->where('tgl_mulai', '<=', $today)
                    ->where('tgl_selesai', '>=', $today);
            })
            ->where('status', '=', 7)
            ->whereHas('karyawans', function ($query) use ($row) {
                $query->where('partner', $row->partner);
            })
            ->count();

        // Total cuti dan izin hrd
        $cutidanizin = $dataIzinHariinihrd + $cutiHariinihrd;
        $posisi = Lowongan::where('partner',Auth::user()->partner)->where('status', '=', 'Aktif')->get();

        // Data Cuti dan Izin Bulan ini hrd
        $dataIzinPerbulan = Izin::whereYear('created_at', '=', Carbon::now()->year)
            ->whereMonth('tgl_mulai', '=', Carbon::now()->month)
            ->whereHas('karyawans', function ($query) use ($row) {
                $query->where('partner', $row->partner);
            })
            ->count('jml_hari');

        //cuti perbulan untuk dashboard hrd
        $cutiPerbulan = Cuti::whereYear('created_at', '=', Carbon::now()->year)
            ->whereMonth('tgl_mulai', '=', Carbon::now()->month)
            ->whereHas('karyawans', function ($query) use ($row) {
                $query->where('partner', $row->partner);
            })
            ->count('jml_cuti');
             // Total
        $cutidanizinPerbulan = $dataIzinPerbulan + $cutiPerbulan;

        //tidakmasuk kemarin hrd
        $tidakMasukKemarinhrd = Tidakmasuk::join('karyawan','tidakmasuk.id_pegawai','karyawan.id')
            ->whereYear('tanggal', '=', $yesterday->year)
            ->whereMonth('tanggal', '=', $yesterday->month)
            ->whereDay('tanggal', '=', $yesterday->day)
            ->where('karyawan.partner',$row->partner)
            ->count('tidakmasuk.nama');

        //data kehadiran kerja karyawan
        $absenHarini = Absensi::with('karyawans')
            ->where('partner',Auth::user()->partner)
            ->whereYear('tanggal', '=', Carbon::now()->year)
            ->whereMonth('tanggal', '=', Carbon::now()->month)
            ->whereDay('tanggal', '=', Carbon::now())
            ->get();
        $jumAbsen = $absenHarini->count();

        //Absen Kemarin HRD
        $absenKemarinhrd = Absensi::with('karyawans')
            ->where('partner', Auth::user()->partner)
            ->whereYear('tanggal', '=', Carbon::yesterday()->year)
            ->whereMonth('tanggal', '=', Carbon::yesterday()->month)
            ->whereDay('tanggal', '=', Carbon::yesterday()->day)
            ->get();

        $jumAbsenKemarin = $absenKemarinhrd->count();

        //informasi HRD
        $currentDate = Carbon::now()->toDateString();
        $informasi = Informasi::where('partner', $row->partner)->whereRaw('? BETWEEN tanggal_aktif AND tanggal_berakhir', [$currentDate])->get();
        // return $informasi;
        $jmlinfo = $informasi->count();

        //-----------------------------------------------------------------------------------------------
        //====================================================== CHART HRD MANAGER ==============================================================
        // Absen Hari Ini HRD
        $absenHariinihrd = Absensi::whereYear('tanggal', '=', Carbon::now()->year)
            ->whereMonth('tanggal', '=', Carbon::now()->month)
            ->whereDay('tanggal', '=', Carbon::now())
            ->where('partner',Auth::user()->partner)
            ->count();

        $jadwal = Jadwal::where('tanggal', today())
            ->where('partner', Auth::user()->partner)
            ->first();

        if($jadwal !== null)
        {
            // Absen Terlambat Hari Ini
            $absenTerlambatHariInihrd = Absensi::whereYear('tanggal', '=', Carbon::now()->year)
                ->whereMonth('tanggal', '=', Carbon::now()->month)
                ->whereDay('tanggal', '=', Carbon::now())
                ->where('jam_masuk','>',$jadwal->jadwal_masuk)
                ->where('partner', $partner)
                ->count();
        }else{
          $absenTerlambatHariInihrd = 0;
        }

        //ambil jumlah Karyawan
        $totalKaryawan = Karyawan::where('partner',Auth::user()->partner)->count('id');

        // ambil jumlah karyawan yang sudah absen
        $totalabsen = DB::table('absensi')
                    ->where('partner',Auth::user()->partner)
                    ->whereYear('tanggal', '=', Carbon::now()->year)
                    ->whereMonth('tanggal', '=', Carbon::now()->month)
                    ->whereDay('tanggal', '=', Carbon::now())
                    ->count('id_karyawan');

        $totalTidakAbsenHariInihrd = $totalKaryawan - $totalabsen;
        $totalTidakAbsenHariIni = $totalKaryawan - $totalabsen;

        // Data Cuti dan Izin Bulan Lalu
        $dataIzinbulanlaluhrd   = Izin::whereYear('tgl_mulai', '=', Carbon::now()->year)
            ->whereMonth('tgl_mulai', '=', Carbon::now()->subMonth()->month)
            ->whereHas('karyawans', function ($query) use ($row) {
                $query->where('partner', $row->partner);
            })
            ->count('jml_hari');

        //cuti bulan lalu dashboard hrd
        $cutibulanlaluhrd = Cuti::whereYear('tgl_mulai', '=', Carbon::now()->year)
            ->whereMonth('tgl_mulai', '=', Carbon::now()->subMonth()->month)
            ->whereHas('karyawans', function ($query) use ($row) {
                $query->where('partner', $row->partner);
            })
            ->count('jml_cuti');
        // Total cuti dan izin bulan lalu
        $cutidanizibulanlalu    = $dataIzinbulanlaluhrd + $cutibulanlaluhrd;

        // Data Izin Kemarin HRD
        $dataIzinKemarinhrd = Izin::whereHas('karyawan', function ($query) use ($yesterday) {
                $query->where('partner', '=', Auth::user()->partner);
            })
            ->where(function ($query) use ($yesterday) {
                $query->where('tgl_mulai', '<=', $yesterday)
                    ->where('tgl_selesai', '>=', $yesterday);
            })
            ->where('status', '=', 7)
            ->count('jml_hari');

        // Data Cuti Kemarin
        $cutiKemarinhrd = Cuti::where(function ($query) use ($yesterday) {
                $query->where('tgl_mulai', '<=', $yesterday)
                    ->where('tgl_selesai', '>=', $yesterday);
            })
            ->where('status', '=', 7)
            ->whereHas('karyawans', function ($query) use ($row) {
                $query->where('partner', $row->partner);
            })
            ->count('jml_cuti');

        // Absen Bulan Ini HRD
        $absenBulaninihrd  = Absensi::where('partner',Auth::user()->partner)
            ->whereYear('tanggal', '=', Carbon::now()->year)
            ->whereMonth('tanggal', '=', Carbon::now()->month)
            ->count();

        //terlambat bulan ini hrd
        $absenTerlambatBulanInihrd = Absensi::whereYear('tanggal', '=', Carbon::now()->year)
            ->whereMonth('tanggal', '=', Carbon::now()->month)
            ->where('terlambat', '!=', null)
            ->where('partner', $partner)
            ->count();

        $cutiBulanInihrd = Cuti::whereYear('tgl_mulai', '=', Carbon::now()->year)
            ->whereMonth('tgl_mulai', '=', Carbon::now()->month)
            ->whereHas('karyawans', function ($query) use ($row) {
                $query->where('partner', $row->partner);
            })
            ->count('jml_cuti');

        $dataIzinBulanInihrd = Izin::whereYear('tgl_mulai', '=', Carbon::now()->year)
            ->whereMonth('tgl_mulai', '=', Carbon::now()->month)
            ->whereHas('karyawans', function ($query) use ($row) {
                $query->where('partner', $row->partner);
            })
            ->count('jml_hari');

        $absenBulanLaluhrd = Absensi::where('partner',Auth::user()->partner)
            ->whereYear('tanggal', '=', Carbon::now()->year)
            ->whereMonth('tanggal', '=', Carbon::now()->subMonth()->month)
            ->where('partner',$row->partner)
            ->count();

        // Absen Terlambat Bulan Lalu HRD
        $absenTerlambatbulanlaluhrd = Absensi::whereYear('tanggal', '=', Carbon::now()->subMonth()->year)
            ->whereMonth('tanggal', '=', Carbon::now()->subMonth()->month)
            ->where('partner',$partner)
            ->count('terlambat');

        $tidakMasukBulanLaluhrd = Tidakmasuk::join('karyawan','tidakmasuk.id_pegawai','karyawan.id')
            ->whereYear('tanggal', '=',Carbon::now()->subMonth()->year)
            ->whereMonth('tanggal', '=', Carbon::now()->subMonth()->month)
            ->where('karyawan.partner',$row->partner)
            ->count('tidakmasuk.nama');

        $tidakMasukBulanInihrd = Tidakmasuk::join('karyawan','tidakmasuk.id_pegawai','karyawan.id')
            ->whereYear('tidakmasuk.tanggal', '=',Carbon::now()->year)
            ->whereMonth('tidakmasuk.tanggal', '=', Carbon::now()->month)
            ->where('karyawan.partner',$row->partner)
            ->count('tidakmasuk.nama');

        //Chart HRD
        $absenTerlambatKemarinhrd = Absensi::whereYear('tanggal', '=', $yesterday->year)
            ->whereMonth('tanggal', '=', $yesterday->month)
            ->whereDay('tanggal', '=', $yesterday->day)
            ->where('terlambat', '!=', null)
            ->where('partner', $partner)
            ->count();
        //======================================================================================================================================


        //========================== DASHBOARD KARYAWAN ========================================================================================
        //STatus hak cuti karyawan
        $alokasi = Alokasicuti::where('id_karyawan', Auth::user()->id_pegawai)
            ->whereYear('aktif_dari', '=', Carbon::now()->year)
            ->whereYear('sampai', '=', Carbon::now()->year)
            ->where('status', '=', 1)
            ->where('id_jeniscuti','=',1)
            ->get();

        //Data alokasi cuti seljuruh karyawan setiap akun
        $alokasicuti = Alokasicuti::where('id_karyawan', Auth::user()->id_pegawai)
            ->whereYear('aktif_dari', '=', Carbon::now()->year)
            ->whereYear('sampai', '=', Carbon::now()->year)
            ->where('status', '=', 1)
            ->get();

        // Absen Terlambat Karyawan bulan ini
        $absenTerlambatkaryawan = Absensi::where('id_karyawan', Auth::user()->id_pegawai)
            ->whereMonth('tanggal', '=', Carbon::now()->month)
            ->whereYear('tanggal', '=', Carbon::now()->year)
            ->where('partner',$partner)
            ->count('terlambat');

        // Absen Karyawan Hari Ini
        $absenKaryawan = Absensi::where('id_karyawan', Auth::user()->id_pegawai)
            ->where('partner',Auth::user()->partner)
            ->whereDay('created_at', '=', Carbon::now(),)
            ->count();

        // Absen Tidak Masuk
        $absenTidakmasuk = Absensi::where('id_karyawan', Auth::user()->id_pegawai)
            ->where('partner',Auth::user()->partner)
            ->whereMonth('created_at', '=', Carbon::now()->month)
            ->count();

        // Absen Bulan Lalu untuk karyawan
        if(Auth::user()->role == 4 || Auth::user()->role !== 7 || Auth::user()->role !== 3 &&  $row->jabatan !== "Direksi" || Auth::user()->role !== 2)
        {
             //absen masuk bulan ini untuk data karyawan
            $absenBulanini  = Absensi::where('id_karyawan', Auth::user()->id_pegawai)
                ->whereYear('tanggal', '=', Carbon::now()->year)
                ->whereMonth('tanggal', '=', Carbon::now()->month)
                ->where('partner',$row->partner)
                ->count();

            //absensi karyawan bulan lalu
            $absenBulanlalu  = Absensi::where('id_karyawan', Auth::user()->id_pegawai)
                ->whereYear('tanggal', '=', Carbon::now()->subMonth()->year)
                ->whereMonth('tanggal', '=', Carbon::now()->subMonth()->month)
                ->where('partner',$partner)
                ->count();

            //absen terlambat bulan lalu
            $absenTerlambatbulanlalu = Absensi::where('id_karyawan', Auth::user()->id_pegawai)
                ->whereYear('tanggal', '=', Carbon::now()->subMonth()->year)
                ->whereMonth('tanggal', '=', Carbon::now()->subMonth()->month)
                ->where('partner', Auth::user()->partner)
                ->count('terlambat');
        }
        else if(Auth::user()->role == 7 || Auth::user()->role == 3 && $row->jabatan == "Direksi" || Auth::user()->role == 2)
        {
            //absen untuk owner, direksi,asisten hrd
            $absenBulanini  = Absensi::where('partner',Auth::user()->partner)
                ->whereYear('tanggal', '=', Carbon::now()->year)
                ->whereMonth('tanggal', '=', Carbon::now()->month)
                ->count();

            //absen untuk owner, direksi,asisten hrd
            $absenBulanlalu = Absensi::where('partner', $row->partner)
                ->whereYear('tanggal', '=', Carbon::now()->subMonth()->year)
                ->whereMonth('tanggal', '=', Carbon::now()->subMonth()->month)
                ->count();
            //absenTerlambatbulanlalu untuk owner,direksi, asisten hrd
            $absenTerlambatbulanlalu = Absensi::whereYear('tanggal', '=', Carbon::now()->subMonth()->year)
                ->whereMonth('tanggal', '=', Carbon::now()->subMonth()->month)
                ->where('partner',$partner)
                ->count('terlambat');
        }

        //==========================================================================================================



        //========================================= MANAGER && ASISTANT DEPARTEMEN =================================

               //cuti dan izin bulanini
               $tahun = Carbon::now()->year;
               $bulan = Carbon::now()->month;
               Carbon::setLocale('id');
               $awalBulanIni = Carbon::now()->startOfMonth();
               $akhirBulanIni = Carbon::now()->endOfMonth();
               $awalBulanLalu = Carbon::now()->subMonth()->startOfMonth();
               $akhirBulanLalu = Carbon::now()->subMonth()->endOfMonth();

               // dd($awalBulanLalu,$akhirBulanLalu);

               $jumCutiBulanInimgr = 0;

               // Hitung cuti bulan ini
               $cutiBulananInimgr = Cuti::with('karyawans','departemens')
                   ->where('status', 7)
                   ->whereHas('karyawans', function ($query) use ($partner) {
                       $query->where('partner', $partner);
                   })
                   ->where('departemen',$row->divisi)
                   ->whereHas('karyawans', function ($query) use($row){
                       $query->where('divisi',$row->divisi)
                           ->where('atasan_pertama', Auth::user()->id_pegawai)
                           ->orWhere('atasan_kedua', Auth::user()->id_pegawai);
                   })
                   ->where(function ($query) use ($awalBulanIni, $akhirBulanIni) {
                       $query->where(function ($q) use ($awalBulanIni, $akhirBulanIni) {
                           $q->where('tgl_mulai', '>=', $awalBulanIni)->where('tgl_mulai', '<=', $akhirBulanIni);
                       })
                           ->orWhere(function ($q) use ($awalBulanIni, $akhirBulanIni) {
                               $q->where('tgl_selesai', '>=', $awalBulanIni)->where('tgl_selesai', '<=', $akhirBulanIni);
                           })
                           ->orWhere(function ($q) use ($awalBulanIni, $akhirBulanIni) {
                               $q->where('tgl_mulai', '<', $awalBulanIni)->where('tgl_selesai', '>', $akhirBulanIni);
                           });
                   })
                   ->get();

               foreach ($cutiBulananInimgr as $cb) {
                   $mulai = \Carbon\Carbon::parse($cb->tgl_mulai);
                   $selesai = \Carbon\Carbon::parse($cb->tgl_selesai);

                   $tglHitungAwal = $mulai->greaterThan($awalBulanIni) ? $mulai : $awalBulanIni;
                   $tglHitungAkhir = $selesai->lessThan($akhirBulanIni) ? $selesai : $akhirBulanIni;

                   $tglHitungAwal = \Carbon\Carbon::parse($tglHitungAwal);
                   $tglHitungAkhir = \Carbon\Carbon::parse($tglHitungAkhir);

                   $cocokkanTanggal = Jadwal::whereYear('tanggal', $tahun)
                       ->whereMonth('tanggal', $tglHitungAwal->month)
                       ->whereBetween('tanggal', [$tglHitungAwal, $tglHitungAkhir])
                       ->where('partner', $partner)
                       ->count();
                   if($cocokkanTanggal >0)
                   {
                       $jumCutiBulanInimgr += $cocokkanTanggal;
                   }

               }

               // Hitung cuti bulan lalu
               $cutiBulananLalumgr = Cuti::with('karyawans','departemens')
                   ->where('status', 7)
                   ->whereHas('karyawans', function ($query) use ($partner) {
                       $query->where('partner', $partner);
                   })
                   ->where('departemen',$row->divisi)
                   ->whereHas('karyawans', function ($query) use($row){
                       $query->where('divisi',$row->divisi)
                           ->where('atasan_pertama', Auth::user()->id_pegawai)
                           ->orWhere('atasan_kedua', Auth::user()->id_pegawai);
                   })
                   ->where(function ($query) use ($awalBulanLalu, $akhirBulanLalu) {
                       $query->where(function ($q) use ($awalBulanLalu, $akhirBulanLalu) {
                           $q->where('tgl_mulai', '>=', $awalBulanLalu)->where('tgl_mulai', '<=', $akhirBulanLalu);
                       })
                           ->orWhere(function ($q) use ($awalBulanLalu, $akhirBulanLalu) {
                               $q->where('tgl_selesai', '>=', $awalBulanLalu)->where('tgl_selesai', '<=', $akhirBulanLalu);
                           })
                           ->orWhere(function ($q) use ($awalBulanLalu, $akhirBulanLalu) {
                               $q->where('tgl_mulai', '<', $awalBulanLalu)->where('tgl_selesai', '>', $akhirBulanLalu);
                           });
                   })
                   ->get();

               $jumCutiBulanLalumgr = 0;
               foreach ($cutiBulananLalumgr as $cb) {
                   $mulai = \Carbon\Carbon::parse($cb->tgl_mulai);
                   $selesai = \Carbon\Carbon::parse($cb->tgl_selesai);

                   $tglHitungAwal = $mulai->greaterThan($awalBulanLalu) ? $mulai : $awalBulanLalu;
                   $tglHitungAkhir = $selesai->lessThan($akhirBulanLalu) ? $selesai : $akhirBulanLalu;

                   $tglHitungAwal = \Carbon\Carbon::parse($tglHitungAwal);
                   $tglHitungAkhir = \Carbon\Carbon::parse($tglHitungAkhir);

                   $cocokkanTanggal = Jadwal::whereYear('tanggal', $tahun)
                       ->whereMonth('tanggal', $tglHitungAwal->month)
                       ->whereBetween('tanggal', [$tglHitungAwal, $tglHitungAkhir])
                       ->where('partner', $partner)
                       ->get();
                   $cocok = $cocokkanTanggal->count();
                   if($cocokkanTanggal)
                   {
                       $jumCutiBulanLalumgr += $cocok;
                   }
               }

            //    dd($cutiBulananLalumgr);

               // ========================IZIN============================

               $izinBulananInimgr = Izin::with('karyawans','departemens')
                   ->where('status', 7)
                   ->whereHas('karyawans', function ($query) use ($partner) {
                       $query->where('partner', $partner);
                   })
                   ->where('departemen',$row->divisi)
                   ->whereHas('karyawans', function ($query) use($row){
                       $query->where('divisi',$row->divisi)
                           ->where('atasan_pertama', Auth::user()->id_pegawai)
                           ->orWhere('atasan_kedua', Auth::user()->id_pegawai);
                   })
                   ->where(function ($query) use ($awalBulanIni, $akhirBulanIni) {
                       $query->where(function ($q) use ($awalBulanIni, $akhirBulanIni) {
                           $q->where('tgl_mulai', '>=', $awalBulanIni)->where('tgl_mulai', '<=', $akhirBulanIni);
                       })
                           ->orWhere(function ($q) use ($awalBulanIni, $akhirBulanIni) {
                               $q->where('tgl_selesai', '>=', $awalBulanIni)->where('tgl_selesai', '<=', $akhirBulanIni);
                           })
                           ->orWhere(function ($q) use ($awalBulanIni, $akhirBulanIni) {
                               $q->where('tgl_mulai', '<', $awalBulanIni)->where('tgl_selesai', '>', $akhirBulanIni);
                           });
                   })
                   ->get();
               $jumIzinBulanInimgr = 0;
               foreach ($izinBulananInimgr as $cb) {
                   $mulai = \Carbon\Carbon::parse($cb->tgl_mulai);
                   $selesai = \Carbon\Carbon::parse($cb->tgl_selesai);

                   $tglHitungAwal = $mulai->greaterThan($awalBulanIni) ? $mulai : $awalBulanIni;
                   $tglHitungAkhir = $selesai->lessThan($akhirBulanIni) ? $selesai : $akhirBulanIni;

                   $tglHitungAwal = \Carbon\Carbon::parse($tglHitungAwal);
                   $tglHitungAkhir = \Carbon\Carbon::parse($tglHitungAkhir);

                   $cocokkanTanggal = Jadwal::whereYear('tanggal', $tahun)
                       ->whereMonth('tanggal', $tglHitungAwal->month)
                       ->whereBetween('tanggal', [$tglHitungAwal, $tglHitungAkhir])
                       ->where('partner', $partner)
                       ->count();
                   if($cocokkanTanggal >0)
                   {
                       $jumIzinBulanInimgr += $cocokkanTanggal;
                   }

               }

               // Hitung izin bulan lalu
               $izinBulananLalumgr = Izin::with('karyawans','departemens')
                   ->where('status', 7)
                   ->whereHas('karyawans', function ($query) use ($partner) {
                       $query->where('partner', $partner);
                   })
                   ->where('departemen',$row->divisi)
                   ->whereHas('karyawans', function ($query) use($row){
                       $query->where('divisi',$row->divisi)
                           ->where('atasan_pertama', Auth::user()->id_pegawai)
                           ->orWhere('atasan_kedua', Auth::user()->id_pegawai);
                   })
                   ->where(function ($query) use ($awalBulanLalu, $akhirBulanLalu) {
                       $query->where(function ($q) use ($awalBulanLalu, $akhirBulanLalu) {
                           $q->where('tgl_mulai', '>=', $awalBulanLalu)->where('tgl_mulai', '<=', $akhirBulanLalu);
                       })
                           ->orWhere(function ($q) use ($awalBulanLalu, $akhirBulanLalu) {
                               $q->where('tgl_selesai', '>=', $awalBulanLalu)->where('tgl_selesai', '<=', $akhirBulanLalu);
                           })
                           ->orWhere(function ($q) use ($awalBulanLalu, $akhirBulanLalu) {
                               $q->where('tgl_mulai', '<', $awalBulanLalu)->where('tgl_selesai', '>', $akhirBulanLalu);
                           });
                   })
                   ->get();

               $jumIzinBulanLalumgr = 0;
               foreach ($izinBulananLalumgr as $cb) {
                   $mulai = \Carbon\Carbon::parse($cb->tgl_mulai);
                   $selesai = \Carbon\Carbon::parse($cb->tgl_selesai);

                   $tglHitungAwal = $mulai->greaterThan($awalBulanLalu) ? $mulai : $awalBulanLalu;
                   $tglHitungAkhir = $selesai->lessThan($akhirBulanLalu) ? $selesai : $akhirBulanLalu;

                   $tglHitungAwal = \Carbon\Carbon::parse($tglHitungAwal);
                   $tglHitungAkhir = \Carbon\Carbon::parse($tglHitungAkhir);

                   $cocokkanTanggal = Jadwal::whereYear('tanggal', $tahun)
                       ->whereMonth('tanggal', $tglHitungAwal->month)
                       ->whereBetween('tanggal', [$tglHitungAwal, $tglHitungAkhir])
                       ->where('partner', $partner)
                       ->get();
                   $cocok = $cocokkanTanggal->count();
                   if($cocokkanTanggal)
                   {
                       $jumIzinBulanLalumgr += $cocok;
                   }
               }

               // dd($jumIzinBulanLalu);

                   // ==================================================================

        $absenBulaninimanager = Absensi::with('karyawans', 'departemens')
            ->whereMonth('tanggal', Carbon::now()->month)
            ->whereYear('tanggal', Carbon::now()->year)
            ->where('partner',$partner)
            ->where('id_departement',$row->divisi)
            ->whereHas('karyawans', function ($query) use($row){
                $query->where('divisi',$row->divisi)
                    ->where('atasan_pertama', Auth::user()->id_pegawai)
                    ->orWhere('atasan_kedua', Auth::user()->id_pegawai);
            })
            ->count();

        $absenBulanlalumanager  =Absensi::with('karyawans', 'departemens')
            ->whereMonth('tanggal', Carbon::now()->subMonth()->month)
            ->whereYear('tanggal', Carbon::now()->subMonth()->year)
            ->where('partner',$row->partner)
            ->where('id_departement',$row->divisi)
            ->whereHas('karyawans', function ($query) use($row){
                $query->where('divisi',$row->divisi)
                    ->where('atasan_pertama', Auth::user()->id_pegawai)
                    ->orWhere('atasan_kedua', Auth::user()->id_pegawai);
            })
            ->count();

         // terlambat bulan ini
         $absenTerlambatBulanini =Absensi::with('karyawans', 'departemens')
            ->whereMonth('tanggal', Carbon::now()->month)
            ->whereYear('tanggal', Carbon::now()->year)
            ->where('partner',$partner)
            ->where('id_departement',$row->divisi)
            ->whereHas('karyawans', function ($query) use($row){
                $query->where('divisi',$row->divisi)
                    ->where('atasan_pertama', Auth::user()->id_pegawai)
                    ->orWhere('atasan_kedua', Auth::user()->id_pegawai);
            })
                ->where('terlambat', '!=',null)
                ->count();

        $absenTerlambatbulanlalumanager =Absensi::with('karyawans', 'departemens')
            ->whereMonth('tanggal', Carbon::now()->subMonth()->month)
            ->whereYear('tanggal', Carbon::now()->subMonth()->year)
            ->where('partner',$partner)
            ->where('id_departement',$row->divisi)
            ->whereHas('karyawans', function ($query) use($row){
                $query->where('divisi',$row->divisi)
                    ->where('atasan_pertama', Auth::user()->id_pegawai)
                    ->orWhere('atasan_kedua', Auth::user()->id_pegawai);
            })
            ->where('terlambat', '!=',null)
            ->count();


        //===========================================================================================



        //=============================== DASHBOARD DIREKSI DAN OWNER ===============================

        //data izin bulan lalu untuk direksi dan owner
        $dataIzinbulanlalu   = Izin::whereYear('tgl_mulai', '=', Carbon::now()->year)
            ->whereMonth('tgl_mulai', '=', Carbon::now()->subMonth()->month)
            ->whereHas('karyawans', function ($query) use ($row) {
                $query->where('partner', $row->partner);
            })
            ->count('jml_hari');

        //cuti bulan lalu untuk dreksi dan owner
        $cutibulanlalu = Cuti::whereYear('tgl_mulai', '=', Carbon::now()->year)
            ->whereMonth('tgl_mulai', '=', Carbon::now()->subMonth()->month)
            ->whereHas('karyawans', function ($query) use ($row) {
                $query->where('partner', $row->partner);
            })
            ->count('jml_cuti');

        // tidak amsuk bulan ini untuk direksi, owner
             $tidakMasukBulanIni = Tidakmasuk::join('karyawan','tidakmasuk.id_pegawai','karyawan.id')
             ->whereYear('tidakmasuk.tanggal', '=',Carbon::now()->year)
             ->whereMonth('tidakmasuk.tanggal', '=', Carbon::now()->month)
             ->where('karyawan.partner',$row->partner)
             ->count('tidakmasuk.nama');
        //===========================================================================================


        // Data Cuti dan Izin Hari ini
        // $dataIzinHariini = Izin::whereYear('tgl_mulai', '=', Carbon::now()->year)
        //     ->whereMonth('tgl_mulai', '=', Carbon::now()->month)
        //     ->whereDay('tgl_mulai', '=', Carbon::now())
        //     ->where('status','=',7)
        //     ->count('jml_hari');

        // $cutiHariini     = Cuti::whereYear('tgl_mulai', '=', Carbon::now()->year)
        // ->whereMonth('tgl_mulai', '=', Carbon::now()->month)
        // ->whereDay('tgl_mulai', '=', Carbon::now())
        // ->where('status','=',7)
        // ->count('jml_cuti');

        // $dataIzinHariini = Izin::where(function ($query) use ($today) {
        //         $query->where('tgl_mulai', '<=', $today)
        //         ->where('tgl_selesai', '>=', $today);
        //     })
        //     ->where('status', '=', 7)
        //     ->count('jml_hari');



        //data izin lainnya
        $dataIzinHariini = Izin::whereHas('karyawan', function ($query) use ($today) {
                $query->where('partner', '=', Auth::user()->partner);
            })
            ->where(function ($query) use ($today) {
                $query->where('tgl_mulai', '<=', $today)
                    ->where('tgl_selesai', '>=', $today);
            })
            ->where('status', '=', 7)
            ->count('jml_hari');

        // Absen Terlambat Bulan Ini
        //Tidak ditemukan pada dashboard manapun
        $absenTerlambat = Absensi::whereYear('tanggal', '=', Carbon::now()->year)
            ->whereMonth('tanggal', '=', Carbon::now()->month)
            ->where('terlambat','!=', null)
            ->where('partner',$partner)
            ->count();

        //tidak ditemukan pada dashboard
        $tidakMasukHariIni = Tidakmasuk::join('karyawan','tidakmasuk.id_pegawai','karyawan.id')
            ->whereYear('tanggal', '=', Carbon::now()->year)
            ->whereMonth('tanggal', '=', Carbon::now()->month)
            ->whereDay('tanggal', '=', Carbon::now())
            ->where('karyawan.partner',$row->partner)
            ->count('tidakmasuk.nama');


        $tidakMasukBulanini = Tidakmasuk::join('karyawan', 'tidakmasuk.id_pegawai', 'karyawan.id')
            ->whereYear('tidakmasuk.tanggal', '=', Carbon::now()->year)
            ->whereMonth('tidakmasuk.tanggal', '=', Carbon::now()->month)
            ->where('karyawan.partner', $row->partner)
            ->where(function ($query) {
                $query->where('karyawan.atasan_pertama', Auth::user()->id_pegawai)
                    ->orWhere('karyawan.atasan_kedua', Auth::user()->id_pegawai);
            })
            ->count('tidakmasuk.nama');
            // dd($tidakMasukBulanini);
        $tidakMasukBulanlalu = Tidakmasuk::join('karyawan','tidakmasuk.id_pegawai','karyawan.id')
            ->whereYear('tanggal', '=',Carbon::now()->subMonth()->year)
            ->whereMonth('tanggal', '=', Carbon::now()->subMonth()->month)
            ->where('karyawan.partner',$row->partner)
            ->where(function ($query) {
                $query->where('karyawan.atasan_pertama', Auth::user()->id_pegawai)
                    ->orWhere('karyawan.atasan_kedua', Auth::user()->id_pegawai);
            })
            ->count('tidakmasuk.nama');


        $today =Carbon::now(); //Current Date and Time
        $firstDayofMonth = Carbon::parse($today)->firstOfMonth();
        $lastDayofMonth = Carbon::parse($today)->endOfMonth();

        $to = Carbon::parse($today);
        $weekDay = $firstDayofMonth->diffInWeekdays($to);

        $getLabel = cuti::select(DB::raw("SUM(jml_cuti) as jumlah"), DB::raw("MONTHNAME(tgl_mulai) as month_name"), DB::raw("MONTH(tgl_mulai) as month_number"))
            ->whereYear('tgl_mulai', '=', Carbon::now()->year)
            ->where('status','=',7)
            ->whereHas('karyawan', function ($query) use ($row) {
                $query->where('partner', $row->partner);
            })
            ->groupBy(DB::raw('MONTHNAME(tgl_mulai)'),DB::raw("MONTH(tgl_mulai)"))
            ->orderBy(DB::raw("MONTH(tgl_mulai)"))
            ->pluck('jumlah', 'month_name');

        $labelBulan = $getLabel->keys();
        // $labelTahun = $getYear->keys();
        $data = $getLabel->values();

        // dd($absenBulanLalu);

        //terlambat bulan lalu lainnya
        $absenTerlambatBulanIni = Absensi::whereYear('tanggal', '=', Carbon::now()->year)
            ->whereMonth('tanggal', '=', Carbon::now()->month)
            ->where('terlambat', '!=', null)
            ->where('partner', $partner)
            ->count();

        //Data alokasi cuti seljuruh karyawan
        $alokasicuti2 = Alokasicuti::all()->where('partner',$row->partner);


        // keterangan absen terhadap login
        $absenKaryawan = Absensi::where('id_karyawan', Auth::user()->id_pegawai)
            ->whereDay('created_at', '=', Carbon::now(),)->count('jam_masuk');

        //untuk mencari sisa cuti karyawan
        $sisacuti = DB::table('alokasicuti')
            ->join('cuti','alokasicuti.id_jeniscuti','cuti.id_jeniscuti')
            ->where('alokasicuti.id_karyawan',Auth::user()->id_pegawai)
            ->where('cuti.id_karyawan',Auth::user()->id_pegawai)
            ->where('cuti.status','=',7)
            ->selectraw('alokasicuti.durasi - cuti.jml_cuti as sisa, cuti.id_jeniscuti,cuti.jml_cuti')
            ->get();

        //  dd($absenTerlambatkaryawan);
        // Absen Karyawan Hari Ini
        $absenKaryawan = Absensi::where('id_karyawan',Auth::user()->id_pegawai)
            ->whereDay('created_at', '=', Carbon::now())
            ->count('jam_masuk');

        // Absen Tidak Masuk
        $absenTidakmasuk = Absensi::where('id_karyawan',Auth::user()->id_pegawai)
            ->whereMonth('created_at', '=', Carbon::now()->month)
            ->count('jam_masuk');



        // ==================================================================

        $tahun = Carbon::now()->year;
        $bulan = Carbon::now()->month;
        Carbon::setLocale('id');
        $awalBulanIni = Carbon::now()->startOfMonth();
        $akhirBulanIni = Carbon::now()->endOfMonth();
        $awalBulanLalu = Carbon::now()->subMonth()->startOfMonth();
        $akhirBulanLalu = Carbon::now()->subMonth()->endOfMonth();

        // dd($awalBulanLalu,$akhirBulanLalu);

        $jumCutiBulanIni = 0;
        $jumCutiBulanLalu = 0;

        // Hitung cuti bulan ini
        $cutiBulananIni = Cuti::with('karyawans')
            ->where('status', 7)
            ->whereHas('karyawans', function ($query) use ($partner) {
                $query->where('partner', $partner);
            })
            ->where(function ($query) use ($awalBulanIni, $akhirBulanIni) {
                $query->where(function ($q) use ($awalBulanIni, $akhirBulanIni) {
                    $q->where('tgl_mulai', '>=', $awalBulanIni)->where('tgl_mulai', '<=', $akhirBulanIni);
                })
                    ->orWhere(function ($q) use ($awalBulanIni, $akhirBulanIni) {
                        $q->where('tgl_selesai', '>=', $awalBulanIni)->where('tgl_selesai', '<=', $akhirBulanIni);
                    })
                    ->orWhere(function ($q) use ($awalBulanIni, $akhirBulanIni) {
                        $q->where('tgl_mulai', '<', $awalBulanIni)->where('tgl_selesai', '>', $akhirBulanIni);
                    });
            })
            ->get();

        foreach ($cutiBulananIni as $cb) {
            $mulai = \Carbon\Carbon::parse($cb->tgl_mulai);
            $selesai = \Carbon\Carbon::parse($cb->tgl_selesai);

            $tglHitungAwal = $mulai->greaterThan($awalBulanIni) ? $mulai : $awalBulanIni;
            $tglHitungAkhir = $selesai->lessThan($akhirBulanIni) ? $selesai : $akhirBulanIni;

            $tglHitungAwal = \Carbon\Carbon::parse($tglHitungAwal);
            $tglHitungAkhir = \Carbon\Carbon::parse($tglHitungAkhir);

            $cocokkanTanggal = Jadwal::whereYear('tanggal', $tahun)
                ->whereMonth('tanggal', $tglHitungAwal->month)
                ->whereBetween('tanggal', [$tglHitungAwal, $tglHitungAkhir])
                ->where('partner', $partner)
                ->count();
            if($cocokkanTanggal >0)
            {
                $jumCutiBulanIni += $cocokkanTanggal;
            }

        }

        // Hitung cuti bulan lalu
        $cutiBulananLalu = Cuti::with('karyawans')
            ->where('status', 7)
            ->whereHas('karyawans', function ($query) use ($partner) {
                $query->where('partner', $partner);
            })
            ->where(function ($query) use ($awalBulanLalu, $akhirBulanLalu) {
                $query->where(function ($q) use ($awalBulanLalu, $akhirBulanLalu) {
                    $q->where('tgl_mulai', '>=', $awalBulanLalu)->where('tgl_mulai', '<=', $akhirBulanLalu);
                })
                    ->orWhere(function ($q) use ($awalBulanLalu, $akhirBulanLalu) {
                        $q->where('tgl_selesai', '>=', $awalBulanLalu)->where('tgl_selesai', '<=', $akhirBulanLalu);
                    })
                    ->orWhere(function ($q) use ($awalBulanLalu, $akhirBulanLalu) {
                        $q->where('tgl_mulai', '<', $awalBulanLalu)->where('tgl_selesai', '>', $akhirBulanLalu);
                    });
            })
            ->get();

        $jumCutiBulanLalu = 0;
        foreach ($cutiBulananLalu as $cb) {
            $mulai = \Carbon\Carbon::parse($cb->tgl_mulai);
            $selesai = \Carbon\Carbon::parse($cb->tgl_selesai);

            $tglHitungAwal = $mulai->greaterThan($awalBulanLalu) ? $mulai : $awalBulanLalu;
            $tglHitungAkhir = $selesai->lessThan($akhirBulanLalu) ? $selesai : $akhirBulanLalu;

            $tglHitungAwal = \Carbon\Carbon::parse($tglHitungAwal);
            $tglHitungAkhir = \Carbon\Carbon::parse($tglHitungAkhir);

            $cocokkanTanggal = Jadwal::whereYear('tanggal', $tahun)
                ->whereMonth('tanggal', $tglHitungAwal->month)
                ->whereBetween('tanggal', [$tglHitungAwal, $tglHitungAkhir])
                ->where('partner', $partner)
                ->get();
            $cocok = $cocokkanTanggal->count();
            if($cocokkanTanggal)
            {
                $jumCutiBulanLalu += $cocok;
            }
        }

        // ========================IZIN============================

        $izinBulananIni = Izin::with('karyawans')
            ->where('status', 7)
            ->whereHas('karyawans', function ($query) use ($partner) {
                $query->where('partner', $partner);
            })
            ->where(function ($query) use ($awalBulanIni, $akhirBulanIni) {
                $query->where(function ($q) use ($awalBulanIni, $akhirBulanIni) {
                    $q->where('tgl_mulai', '>=', $awalBulanIni)->where('tgl_mulai', '<=', $akhirBulanIni);
                })
                    ->orWhere(function ($q) use ($awalBulanIni, $akhirBulanIni) {
                        $q->where('tgl_selesai', '>=', $awalBulanIni)->where('tgl_selesai', '<=', $akhirBulanIni);
                    })
                    ->orWhere(function ($q) use ($awalBulanIni, $akhirBulanIni) {
                        $q->where('tgl_mulai', '<', $awalBulanIni)->where('tgl_selesai', '>', $akhirBulanIni);
                    });
            })
            ->get();
        $jumIzinBulanIni = 0;
        foreach ($izinBulananIni as $cb) {
            $mulai = \Carbon\Carbon::parse($cb->tgl_mulai);
            $selesai = \Carbon\Carbon::parse($cb->tgl_selesai);

            $tglHitungAwal = $mulai->greaterThan($awalBulanIni) ? $mulai : $awalBulanIni;
            $tglHitungAkhir = $selesai->lessThan($akhirBulanIni) ? $selesai : $akhirBulanIni;

            $tglHitungAwal = \Carbon\Carbon::parse($tglHitungAwal);
            $tglHitungAkhir = \Carbon\Carbon::parse($tglHitungAkhir);

            $cocokkanTanggal = Jadwal::whereYear('tanggal', $tahun)
                ->whereMonth('tanggal', $tglHitungAwal->month)
                ->whereBetween('tanggal', [$tglHitungAwal, $tglHitungAkhir])
                ->where('partner', $partner)
                ->count();
            if($cocokkanTanggal >0)
            {
                $jumIzinBulanIni += $cocokkanTanggal;
            }

        }

        // Hitung izin bulan lalu
        $izinBulananLalu = Izin::with('karyawans')
            ->where('status', 7)
            ->whereHas('karyawans', function ($query) use ($partner) {
                $query->where('partner', $partner);
            })
            ->where(function ($query) use ($awalBulanLalu, $akhirBulanLalu) {
                $query->where(function ($q) use ($awalBulanLalu, $akhirBulanLalu) {
                    $q->where('tgl_mulai', '>=', $awalBulanLalu)->where('tgl_mulai', '<=', $akhirBulanLalu);
                })
                    ->orWhere(function ($q) use ($awalBulanLalu, $akhirBulanLalu) {
                        $q->where('tgl_selesai', '>=', $awalBulanLalu)->where('tgl_selesai', '<=', $akhirBulanLalu);
                    })
                    ->orWhere(function ($q) use ($awalBulanLalu, $akhirBulanLalu) {
                        $q->where('tgl_mulai', '<', $awalBulanLalu)->where('tgl_selesai', '>', $akhirBulanLalu);
                    });
            })
            ->get();

        $jumIzinBulanLalu = 0;
        foreach ($izinBulananLalu as $cb) {
            $mulai = \Carbon\Carbon::parse($cb->tgl_mulai);
            $selesai = \Carbon\Carbon::parse($cb->tgl_selesai);

            $tglHitungAwal = $mulai->greaterThan($awalBulanLalu) ? $mulai : $awalBulanLalu;
            $tglHitungAkhir = $selesai->lessThan($akhirBulanLalu) ? $selesai : $akhirBulanLalu;

            $tglHitungAwal = \Carbon\Carbon::parse($tglHitungAwal);
            $tglHitungAkhir = \Carbon\Carbon::parse($tglHitungAkhir);

            $cocokkanTanggal = Jadwal::whereYear('tanggal', $tahun)
                ->whereMonth('tanggal', $tglHitungAwal->month)
                ->whereBetween('tanggal', [$tglHitungAwal, $tglHitungAkhir])
                ->where('partner', $partner)
                ->get();
            $cocok = $cocokkanTanggal->count();
            if($cocokkanTanggal)
            {
                $jumIzinBulanLalu += $cocok;
            }
        }

        // dd($jumIzinBulanLalu);

            // ==================================================================




        //==================================  CHART OWNER =============================================================
        Carbon::setLocale('id');
        $namabulan  = [];
        $attendance = [];
        $terlambats = [];
        $tidakmasuk = [];

        for($bulan = 1; $bulan <= 12; $bulan++)
        {
            //absensi
            $tanggal = Carbon::createFromDate($tahun, $bulan, 1);
            $namaBulan = $tanggal->locale('id')->isoFormat('MMM');
            $namabulan[] = $namaBulan;

            $attendance[] = Absensi::where('partner', $role->partner)
                ->whereYear('tanggal', '=', $tahun)
                ->whereMonth('tanggal', '=', $bulan)
                ->count();

            $terlambats[] = Absensi::where('partner', $role->partner)
                ->whereYear('tanggal', '=', $tahun)
                ->whereMonth('tanggal', '=', $bulan)
                ->whereNotNull('terlambat')
                ->count();
            $karyawann = Karyawan::where('partner',$role->partner)->pluck('id');
            $jum = $karyawann->count();

            $jadwal = Jadwal::whereYear('tanggal', $tahun)
                ->whereMonth('tanggal', $bulan)
                ->where('partner',$role->partner)
                ->count();
            $jumjadwal = $jadwal;
            $totaldata = $jum * $jumjadwal;
            if ($attendance[$bulan - 1] > 0) {
                $tidakmasuk[] = $totaldata - $attendance[$bulan - 1];
            } else {
                $tidakmasuk[] = 0;
            }
        }
        $namabulan = $namabulan;
        $attendance = implode(', ', $attendance);
        $terlambats = implode(', ', $terlambats);
        $tidakmasuk = implode(', ', $tidakmasuk);

        //CHART CUTI DAN IZIN
        $namemonth  = [];
        $leave      = [];
        $permission = [];

        $a = [];
        $b = [];
        $m = null;
        $s = null;
        for($month = 1; $month <= 12; $month++)
        {
            $date = Carbon::createFromDate($tahun, $month, 1);
            $nameMonth = $date->locale('id')->isoFormat('MMM');
            $namemonth[] = $nameMonth;

            $karyawant = Karyawan::where('partner',$role->partner)->pluck('id');
            $jum = $karyawant->count();

            $awal = Carbon::create($tahun, $month, 1)->startOfMonth();
            $akhir = Carbon::create($tahun, $month, 1)->endOfMonth();

            //============= CUTI ================
            $cutiBulanan = Cuti::with('karyawans')
                ->where('status', 7)
                ->whereHas('karyawans', function ($query) use ($role) {
                    $query->where('partner', $role->partner);
                })
                ->where(function ($query) use ($awal, $akhir) {
                    $query->where(function ($q) use ($awal, $akhir) {
                            $q->where('tgl_mulai', '>=', $awal)->where('tgl_mulai', '<=', $akhir);
                        })
                        ->orWhere(function ($q) use ($awal, $akhir) {
                            $q->where('tgl_selesai', '>=', $awal)->where('tgl_selesai', '<=', $akhir);
                        })
                        ->orWhere(function ($q) use ($awal, $akhir) {
                            $q->where('tgl_mulai', '<', $awal)->where('tgl_selesai', '>', $akhir);
                        });
                })
                ->get();

            $jumCutiBulanan = 0;
            $tglHitungAwal = null;
            $tglHitungAkhir = null;
            $mulai = null;
            $selesai = null;
            foreach($cutiBulanan as $cb)
            {

               $mulai = \Carbon\Carbon::parse($cb->tgl_mulai);
               $selesai = \Carbon\Carbon::parse($cb->tgl_selesai);

                if ($mulai->greaterThan($awal)) {
                    $tglHitungAwal = $mulai;
                } else {
                    $tglHitungAwal = $awal;
                }

                if ($selesai->lessThan($akhir)) {
                    $tglHitungAkhir = $selesai;
                } else {
                    $tglHitungAkhir = $akhir;
                }

                $tglHitungAwal = \Carbon\Carbon::parse($tglHitungAwal);
                $tglHitungAkhir= \Carbon\Carbon::parse($tglHitungAkhir);

                $cocokkanTanggal = Jadwal::whereYear('tanggal', $tahun)
                    ->whereMonth('tanggal', $month)
                    ->whereBetween('tanggal', [$tglHitungAwal, $tglHitungAkhir])
                    ->where('partner',$role->partner)
                    ->count();

                if ($cocokkanTanggal > 0) {
                    $jumCutiBulanan += $cocokkanTanggal;
                }
            }
            $leave[$month - 1] = $jumCutiBulanan;

            //============ IZIN ===============
            $izinBulanan = Izin::with('karyawans')
                ->where('status', 7)
                ->whereHas('karyawans', function ($query) use ($role) {
                    $query->where('partner', $role->partner);
                })
                ->where(function ($query) use ($awal, $akhir) {
                    $query->where(function ($q) use ($awal, $akhir) {
                            $q->where('tgl_mulai', '>=', $awal)->where('tgl_mulai', '<=', $akhir);
                        })
                        ->orWhere(function ($q) use ($awal, $akhir) {
                            $q->where('tgl_selesai', '>=', $awal)->where('tgl_selesai', '<=', $akhir);
                        })
                        ->orWhere(function ($q) use ($awal, $akhir) {
                            $q->where('tgl_mulai', '<', $awal)->where('tgl_selesai', '>', $akhir);
                        });
                })
                ->get();

            $jumIzinBulanan = 0;
            foreach($izinBulanan as $ib)
            {
                $m = \Carbon\Carbon::parse($ib->tgl_mulai);
                $s = \Carbon\Carbon::parse($ib->tgl_selesai);

                if ($m->greaterThan($awal)) {
                    $HitungAwal = $m;
                } else {
                    $HitungAwal = $awal;
                }

                if ($s->lessThan($akhir)) {
                    $HitungAkhir = $s;
                } else {
                    $HitungAkhir = $akhir;
                }

                $HitungAwal = \Carbon\Carbon::parse($HitungAwal);
                $HitungAkhir= \Carbon\Carbon::parse($HitungAkhir);

                $cocok = Jadwal::whereYear('tanggal', $tahun)
                    ->whereMonth('tanggal', $month)
                    ->whereBetween('tanggal', [$HitungAwal, $HitungAkhir])
                    ->where('partner',$role->partner)
                    ->count();

                if($cocok > 0) {
                    $jumIzinBulanan += $cocok;
                }
            }
            $permission[$month - 1] = $jumIzinBulanan;
        }
        $namemonth  = $namemonth;
        $leave      = implode(', ', $leave);
        $permission = implode(', ', $permission);

        //============= END CHART OWNER ====================

        if($role->role == 3 && $row->jabatan == "Manager")
        {
            $cuti = DB::table('cuti')
                ->leftjoin('alokasicuti', 'cuti.id_jeniscuti', 'alokasicuti.id_jeniscuti')
                ->leftjoin('settingalokasi', 'cuti.id_jeniscuti', 'settingalokasi.id_jeniscuti')
                ->leftjoin('jeniscuti', 'cuti.id_jeniscuti', 'jeniscuti.id')
                ->leftjoin('karyawan', 'cuti.id_karyawan', 'karyawan.id')
                ->leftjoin('statuses', 'cuti.status', '=', 'statuses.id')
                ->leftjoin('departemen','cuti.departemen','=','departemen.id')
                ->leftjoin('datareject', 'datareject.id_cuti', '=', 'cuti.id')
                ->select('cuti.*', 'jeniscuti.jenis_cuti', 'departemen.nama_departemen','karyawan.nama', 'statuses.name_status', 'karyawan.atasan_pertama', 'karyawan.atasan_kedua', 'datareject.alasan as alasan', 'datareject.id_cuti as id_cuti')
                ->distinct()
                ->where(function ($query) {
                    $query->where(function ($q) {
                        $q->where('cuti.status', 1)
                            ->where('karyawan.atasan_pertama', Auth::user()->id_pegawai)
                            ->where('karyawan.partner', Auth::user()->partner)

                            ->where('cuti.catatan', '=', NULL);
                    })
                    ->orWhere(function ($q) {
                        $q->whereIn('cuti.status', [1, 6])
                            ->where('karyawan.atasan_kedua', Auth::user()->id_pegawai)
                            ->where('karyawan.partner', Auth::user()->partner)
                            ->where('cuti.catatan', '=', NULL);
                    });
                })
                ->get();
            $cutijumlah = $cuti->count();

            $cutis = DB::table('cuti')
                ->leftJoin('alokasicuti', 'cuti.id_jeniscuti', 'alokasicuti.id_jeniscuti')
                ->leftJoin('settingalokasi', 'cuti.id_jeniscuti', 'settingalokasi.id_jeniscuti')
                ->leftJoin('jeniscuti', 'cuti.id_jeniscuti', 'jeniscuti.id')
                ->leftJoin('karyawan', 'cuti.id_karyawan', 'karyawan.id')
                ->leftJoin('statuses', 'cuti.status', '=', 'statuses.id')
                ->leftJoin('departemen', 'cuti.departemen', '=', 'departemen.id')
                ->leftJoin('datareject', 'datareject.id_cuti', '=', 'cuti.id')
                ->select('cuti.*', 'jeniscuti.jenis_cuti', 'departemen.nama_departemen', 'karyawan.nama', 'statuses.name_status', 'karyawan.atasan_pertama', 'karyawan.atasan_kedua', 'datareject.alasan as alasan', 'datareject.id_cuti as id_cuti')
                ->distinct()
                ->where(function ($query) {
                    $query->where(function ($q) {
                        $q->whereIn('cuti.catatan', ['Mengajukan Pembatalan', 'Mengajukan Perubahan'])
                             ->where('karyawan.partner', Auth::user()->partner)
                             ->where('karyawan.atasan_pertama', Auth::user()->id_pegawai);
                    })
                    ->orWhere(function ($q) {
                        $q->whereIn('cuti.catatan', ['Mengajukan Pembatalan', 'Mengajukan Perubahan', 'Pembatalan Disetujui Atasan', 'Perubahan Disetujui Atasan'])
                             ->where('karyawan.partner', Auth::user()->partner)
                             ->where('karyawan.atasan_kedua', Auth::user()->id_pegawai);
                    });
                })
                ->get();

            $jumct = $cutis->count();
            // return $jumct;

            $izin = DB::table('izin')
                ->leftjoin('statuses', 'izin.status', '=', 'statuses.id')
                ->leftjoin('datareject', 'datareject.id_izin', '=', 'izin.id')
                ->leftjoin('karyawan', 'izin.id_karyawan', 'karyawan.id')
                ->leftjoin('jenisizin', 'izin.id_jenisizin', '=', 'jenisizin.id')
                ->leftjoin('departemen','izin.departemen','=','departemen.id')
                ->select('izin.*', 'statuses.name_status', 'departemen.nama_departemen','jenisizin.jenis_izin', 'datareject.alasan as alasan', 'datareject.id_izin as id_izin', 'karyawan.atasan_pertama', 'karyawan.atasan_kedua', 'karyawan.nama')
                ->distinct()
                ->where(function ($query) {
                    $query->where(function ($q) {
                        $q->where('izin.status', 1)
                             ->where('karyawan.partner', Auth::user()->partner)
                             ->where('karyawan.atasan_pertama', Auth::user()->id_pegawai)
                            ->where('izin.catatan', '=', NULL);
                    })
                    ->orWhere(function ($q) {
                        $q->whereIn('izin.status', [1, 6])
                             ->where('karyawan.partner', Auth::user()->partner)
                             ->where('karyawan.atasan_kedua', Auth::user()->id_pegawai)
                            ->where('izin.catatan', '=', NULL);
                    });
                })
                ->get();
            $izinjumlah = $izin->count();

            $ijin =DB::table('izin')
                ->leftjoin('statuses', 'izin.status', '=', 'statuses.id')
                ->leftjoin('datareject', 'datareject.id_izin', '=', 'izin.id')
                ->leftjoin('karyawan', 'izin.id_karyawan', 'karyawan.id')
                ->leftjoin('jenisizin', 'izin.id_jenisizin', '=', 'jenisizin.id')
                ->leftjoin('departemen','izin.departemen','=','departemen.id')
                ->select('izin.*', 'statuses.name_status', 'departemen.nama_departemen','jenisizin.jenis_izin', 'datareject.alasan as alasan', 'datareject.id_izin as id_izin', 'karyawan.atasan_pertama', 'karyawan.atasan_kedua', 'karyawan.nama')
                ->distinct()
                ->where(function ($query) {
                    $query->where(function ($q) {
                        $q->whereIn('izin.catatan', ['Mengajukan Pembatalan', 'Mengajukan Perubahan'])
                             ->where('karyawan.partner', Auth::user()->partner)
                             ->where('karyawan.atasan_pertama', Auth::user()->id_pegawai);
                    })
                    ->orWhere(function ($q) {
                        $q->whereIn('izin.catatan', ['Mengajukan Pembatalan', 'Mengajukan Perubahan', 'Pembatalan Disetujui Atasan', 'Perubahan Disetujui Atasan'])
                             ->where('karyawan.partner', Auth::user()->partner)
                             ->where('karyawan.atasan_kedua', Auth::user()->id_pegawai);
                    });
                })
                ->get();
            $jumizin = $ijin->count();
        }
        elseif($role->role == 1 && $row->jabatan == "Manager")
        {
            $cuti = DB::table('cuti')
                ->leftjoin('alokasicuti', 'cuti.id_jeniscuti', 'alokasicuti.id_jeniscuti')
                ->leftjoin('settingalokasi', 'cuti.id_jeniscuti', 'settingalokasi.id_jeniscuti')
                ->leftjoin('jeniscuti', 'cuti.id_jeniscuti', 'jeniscuti.id')
                ->leftjoin('karyawan', 'cuti.id_karyawan', 'karyawan.id')
                ->leftjoin('statuses', 'cuti.status', '=', 'statuses.id')
                ->leftjoin('datareject', 'datareject.id_cuti', '=', 'cuti.id')
                ->leftjoin('departemen','cuti.departemen','=','departemen.id')
                ->select('cuti.*', 'jeniscuti.jenis_cuti','departemen.nama_departemen', 'karyawan.nama', 'statuses.name_status', 'karyawan.atasan_pertama', 'karyawan.atasan_kedua', 'datareject.alasan as alasan', 'datareject.id_cuti as id_cuti')
                ->distinct()
                ->where(function ($query) {
                    $query->where(function ($q) {
                        $q->where('cuti.status', 1)
                            ->where('karyawan.atasan_pertama', Auth::user()->id_pegawai)
                            ->where('karyawan.partner', Auth::user()->partner);
                    })
                    ->orWhere(function ($q) {
                        $q->whereIn('cuti.status', [1, 6])
                            ->where('karyawan.atasan_kedua', Auth::user()->id_pegawai)
                            ->where('karyawan.partner', Auth::user()->partner);
                    });
                })
                ->where('cuti.catatan', '=', NULL)
                ->get();
            $cutijumlah = $cuti->count();
            // return $cuti;
            $cutis = DB::table('cuti')
                ->leftjoin('alokasicuti', 'cuti.id_jeniscuti', 'alokasicuti.id_jeniscuti')
                ->leftjoin('settingalokasi', 'cuti.id_jeniscuti', 'settingalokasi.id_jeniscuti')
                ->leftjoin('jeniscuti', 'cuti.id_jeniscuti', 'jeniscuti.id')
                ->leftjoin('karyawan', 'cuti.id_karyawan', 'karyawan.id')
                ->leftjoin('statuses', 'cuti.status', '=', 'statuses.id')
                ->leftjoin('departemen','cuti.departemen','=','departemen.id')
                ->leftjoin('datareject', 'datareject.id_cuti', '=', 'cuti.id')
                ->select('cuti.*', 'jeniscuti.jenis_cuti', 'departemen.nama_departemen','karyawan.nama', 'statuses.name_status', 'karyawan.atasan_pertama', 'karyawan.atasan_kedua', 'datareject.alasan as alasan', 'datareject.id_cuti as id_cuti')
                ->distinct()
                ->where(function ($query) {
                    $query->where(function ($q) {
                        $q->whereIn('cuti.catatan', ['Mengajukan Pembatalan', 'Mengajukan Perubahan'])
                            ->where('karyawan.atasan_pertama', Auth::user()->id_pegawai)
                             ->where('karyawan.partner', Auth::user()->partner);
                    })
                    ->orWhere(function ($q) {
                        $q->whereIn('cuti.catatan', ['Mengajukan Pembatalan', 'Mengajukan Perubahan', 'Pembatalan Disetujui Atasan', 'Perubahan Disetujui Atasan'])
                            ->where('karyawan.atasan_kedua', Auth::user()->id_pegawai)
                            ->where('karyawan.partner', Auth::user()->partner);
                    });
                })
                ->whereIn('cuti.catatan', ['Mengajukan Pembatalan', 'Mengajukan Perubahan', 'Pembatalan Disetujui Atasan', 'Perubahan Disetujui Atasan'])
                ->get();
            $jumct = $cutis->count();

            $izin = DB::table('izin')
                ->leftjoin('statuses', 'izin.status', '=', 'statuses.id')
                ->leftjoin('datareject', 'datareject.id_izin', '=', 'izin.id')
                ->leftjoin('karyawan', 'izin.id_karyawan', 'karyawan.id')
                ->leftjoin('jenisizin', 'izin.id_jenisizin', '=', 'jenisizin.id')
                ->leftjoin('departemen','izin.departemen','=','departemen.id')
                ->select('izin.*', 'statuses.name_status','departemen.nama_departemen', 'jenisizin.jenis_izin', 'datareject.alasan as alasan', 'datareject.id_izin as id_izin', 'karyawan.atasan_pertama', 'karyawan.atasan_kedua', 'karyawan.nama')
                ->distinct()
                ->where(function ($query) {
                    $query->where(function ($q) {
                        $q->where('izin.status', 1)
                            ->where('karyawan.atasan_pertama', Auth::user()->id_pegawai)
                            ->where('karyawan.partner', Auth::user()->partner)
                            ->where('izin.catatan', '=', NULL);
                    })
                    ->orWhere(function ($q) {
                        $q->whereIn('izin.status', [1, 6])
                            ->where('karyawan.atasan_kedua', Auth::user()->id_pegawai)
                            ->where('karyawan.partner', Auth::user()->partner)
                            ->where('izin.catatan', '=', NULL);
                    });
                })
                ->get();
            $izinjumlah = $izin->count();

            $ijin =DB::table('izin')
                ->leftjoin('statuses', 'izin.status', '=', 'statuses.id')
                ->leftjoin('datareject', 'datareject.id_izin', '=', 'izin.id')
                ->leftjoin('karyawan', 'izin.id_karyawan', 'karyawan.id')
                ->leftjoin('jenisizin', 'izin.id_jenisizin', '=', 'jenisizin.id')
                ->leftjoin('departemen','izin.departemen','=','departemen.id')
                ->select('izin.*', 'statuses.name_status', 'departemen.nama_departemen','jenisizin.jenis_izin', 'datareject.alasan as alasan', 'datareject.id_izin as id_izin', 'karyawan.atasan_pertama', 'karyawan.atasan_kedua', 'karyawan.nama')
                ->distinct()
                ->where(function ($query) {
                    $query->where(function ($q) {
                        $q->whereIn('izin.catatan', ['Mengajukan Pembatalan', 'Mengajukan Perubahan'])
                            ->where('karyawan.atasan_pertama', Auth::user()->id_pegawai)
                             ->where('karyawan.partner', Auth::user()->partner);
                    })
                    ->orWhere(function ($q) {
                        $q->whereIn('izin.catatan', ['Mengajukan Pembatalan', 'Mengajukan Perubahan', 'Pembatalan Disetujui Atasan', 'Perubahan Disetujui Atasan'])
                            ->where('karyawan.atasan_kedua', Auth::user()->id_pegawai)
                            ->where('karyawan.partner', Auth::user()->partner);
                    });
                })
                ->get();
            $jumizin = $ijin->count();

        }
        elseif($role->role == 3 && $row->jabatan == "Asistant Manager")
        {
            $cuti = DB::table('cuti')
                ->leftjoin('alokasicuti', 'cuti.id_jeniscuti', 'alokasicuti.id_jeniscuti')
                ->leftjoin('settingalokasi', 'cuti.id_jeniscuti', 'settingalokasi.id_jeniscuti')
                ->leftjoin('jeniscuti', 'cuti.id_jeniscuti', 'jeniscuti.id')
                ->leftjoin('karyawan', 'cuti.id_karyawan', 'karyawan.id')
                ->leftjoin('statuses', 'cuti.status', '=', 'statuses.id')
                ->leftjoin('datareject', 'datareject.id_cuti', '=', 'cuti.id')
                ->leftjoin('departemen','cuti.departemen','=','departemen.id')
                ->select('cuti.*', 'karyawan.partner','jeniscuti.jenis_cuti', 'departemen.nama_departemen','karyawan.nama', 'statuses.name_status', 'karyawan.atasan_pertama', 'karyawan.atasan_kedua', 'datareject.alasan as alasan', 'datareject.id_cuti as id_cuti')
                ->distinct()
                ->where(function ($query) {
                    $query->where('karyawan.partner', Auth::user()->partner)
                        ->where('karyawan.atasan_pertama', Auth::user()->id_pegawai)
                        ->orWhere('karyawan.atasan_kedua', Auth::user()->id_pegawai);
                })
                ->where('cuti.status', '=', '1')
                ->where('cuti.catatan','=',NULL)
                ->get();

            $cutijumlah = $cuti->count();

            $cutis = DB::table('cuti')
                ->leftjoin('alokasicuti', 'cuti.id_jeniscuti', 'alokasicuti.id_jeniscuti')
                ->leftjoin('settingalokasi', 'cuti.id_jeniscuti', 'settingalokasi.id_jeniscuti')
                ->leftjoin('jeniscuti', 'cuti.id_jeniscuti', 'jeniscuti.id')
                ->leftjoin('karyawan', 'cuti.id_karyawan', 'karyawan.id')
                ->leftjoin('statuses', 'cuti.status', '=', 'statuses.id')
                ->leftjoin('departemen','cuti.departemen','=','departemen.id')
                ->leftjoin('datareject', 'datareject.id_cuti', '=', 'cuti.id')
                ->select('cuti.*', 'jeniscuti.jenis_cuti', 'departemen.nama_departemen','karyawan.nama', 'statuses.name_status', 'karyawan.atasan_pertama', 'karyawan.atasan_kedua', 'datareject.alasan as alasan', 'datareject.id_cuti as id_cuti')
                ->distinct()
                ->where(function ($query) {
                    $query ->where('karyawan.partner', Auth::user()->partner)
                        ->where('karyawan.atasan_pertama', Auth::user()->id_pegawai)
                        ->orWhere('karyawan.atasan_kedua', Auth::user()->id_pegawai);
                })
                ->whereIn('cuti.catatan', ['Mengajukan Pembatalan', 'Mengajukan Perubahan'])
                ->get();

            $jumct = $cutis->count();

            $izin = DB::table('izin')
                ->leftjoin('statuses', 'izin.status', '=', 'statuses.id')
                ->leftjoin('datareject', 'datareject.id_izin', '=', 'izin.id')
                ->leftjoin('karyawan', 'izin.id_karyawan', 'karyawan.id')
                ->leftjoin('departemen','izin.departemen','=','departemen.id')
                ->leftjoin('jenisizin', 'izin.id_jenisizin', '=', 'jenisizin.id')
                ->select('izin.*', 'statuses.name_status','departemen.nama_departemen', 'jenisizin.jenis_izin', 'datareject.alasan as alasan', 'datareject.id_izin as id_izin', 'karyawan.atasan_pertama', 'karyawan.atasan_kedua', 'karyawan.nama')
                ->distinct()
                ->where(function ($query) {
                    $query->where('karyawan.partner', Auth::user()->partner)
                        ->where('karyawan.atasan_pertama', Auth::user()->id_pegawai)
                        ->orWhere('karyawan.atasan_kedua', Auth::user()->id_pegawai);
                })
                ->where('izin.status', '=', '1')
                ->where('izin.catatan',null)
                ->get();
            $izinjumlah = $izin->count();

            $ijin =DB::table('izin')
                ->leftjoin('statuses', 'izin.status', '=', 'statuses.id')
                ->leftjoin('datareject', 'datareject.id_izin', '=', 'izin.id')
                ->leftjoin('karyawan', 'izin.id_karyawan', 'karyawan.id')
                ->leftjoin('jenisizin', 'izin.id_jenisizin', '=', 'jenisizin.id')
                ->leftjoin('departemen','izin.departemen','=','departemen.id')
                ->select('izin.*', 'statuses.name_status', 'departemen.nama_departemen','jenisizin.jenis_izin', 'datareject.alasan as alasan', 'datareject.id_izin as id_izin', 'karyawan.atasan_pertama', 'karyawan.atasan_kedua', 'karyawan.nama')
                ->distinct()
                ->where(function ($query) {
                    $query->where('karyawan.partner', Auth::user()->partner)
                    ->where('karyawan.atasan_pertama', Auth::user()->id_pegawai)
                        ->orWhere('karyawan.atasan_kedua', Auth::user()->id_pegawai);
                })
                ->whereIn('izin.catatan',['Mengajukan Pembatalan','Mengajukan Perubahan'])
                ->get();
            $jumizin = $ijin->count();
        }
        elseif($role->role == 1 && $row->jabatan == "Asistant Manager")
        {
            $cuti = DB::table('cuti')
                ->leftjoin('alokasicuti', 'cuti.id_jeniscuti', 'alokasicuti.id_jeniscuti')
                ->leftjoin('settingalokasi', 'cuti.id_jeniscuti', 'settingalokasi.id_jeniscuti')
                ->leftjoin('jeniscuti', 'cuti.id_jeniscuti', 'jeniscuti.id')
                ->leftjoin('karyawan', 'cuti.id_karyawan', 'karyawan.id')
                ->leftjoin('statuses', 'cuti.status', '=', 'statuses.id')
                ->leftjoin('datareject', 'datareject.id_cuti', '=', 'cuti.id')
                ->leftjoin('departemen','cuti.departemen','=','departemen.id')
                ->select('cuti.*', 'jeniscuti.jenis_cuti', 'karyawan.nama','departemen.nama_departemen', 'statuses.name_status', 'karyawan.atasan_pertama', 'karyawan.atasan_kedua', 'datareject.alasan as alasan', 'datareject.id_cuti as id_cuti')
                ->distinct()
                ->where(function ($query) {
                    $query->where('karyawan.partner', Auth::user()->partner)
                    ->where('karyawan.atasan_pertama', Auth::user()->id_pegawai)
                        ->orWhere('karyawan.atasan_kedua', Auth::user()->id_pegawai);
                })
                ->where('cuti.status', '=', '1')
                ->where('cuti.catatan','=',NULL)
                ->get();
            $cutijumlah = $cuti->count();
            $cutis = DB::table('cuti')
                    ->leftjoin('alokasicuti', 'cuti.id_jeniscuti', 'alokasicuti.id_jeniscuti')
                    ->leftjoin('settingalokasi', 'cuti.id_jeniscuti', 'settingalokasi.id_jeniscuti')
                    ->leftjoin('jeniscuti', 'cuti.id_jeniscuti', 'jeniscuti.id')
                    ->leftjoin('karyawan', 'cuti.id_karyawan', 'karyawan.id')
                    ->leftjoin('statuses', 'cuti.status', '=', 'statuses.id')
                    ->leftjoin('departemen','cuti.departemen','=','departemen.id')
                    ->leftjoin('datareject', 'datareject.id_cuti', '=', 'cuti.id')
                    ->select('cuti.*', 'jeniscuti.jenis_cuti', 'departemen.nama_departemen','karyawan.nama', 'statuses.name_status', 'karyawan.atasan_pertama', 'karyawan.atasan_kedua', 'datareject.alasan as alasan', 'datareject.id_cuti as id_cuti')
                    ->distinct()
                    ->where(function ($query) {
                        $query->where('karyawan.partner', Auth::user()->partner)
                        ->where('karyawan.atasan_pertama', Auth::user()->id_pegawai)
                            ->orWhere('karyawan.atasan_kedua', Auth::user()->id_pegawai);
                    })
                    ->whereIn('cuti.catatan', ['Mengajukan Pembatalan', 'Mengajukan Perubahan'])
                    ->get();
            $jumct = $cutis->count();

            $izin = DB::table('izin')
                ->leftjoin('statuses', 'izin.status', '=', 'statuses.id')
                ->leftjoin('datareject', 'datareject.id_izin', '=', 'izin.id')
                ->leftjoin('karyawan', 'izin.id_karyawan', 'karyawan.id')
                ->leftjoin('jenisizin', 'izin.id_jenisizin', '=', 'jenisizin.id')
                ->leftjoin('departemen','izin.departemen','=','departemen.id')
                ->select('izin.*', 'statuses.name_status', 'departemen.nama_departemen','jenisizin.jenis_izin', 'datareject.alasan as alasan', 'datareject.id_izin as id_izin', 'karyawan.atasan_pertama', 'karyawan.atasan_kedua', 'karyawan.nama')
                ->distinct()
                ->where(function ($query) {
                    $query->where('karyawan.partner', Auth::user()->partner)
                    ->where('karyawan.atasan_pertama', Auth::user()->id_pegawai)
                        ->orWhere('karyawan.atasan_kedua', Auth::user()->id_pegawai);
                })
                ->where('izin.status', '=', '1')
                ->where('izin.catatan',null)
                ->get();
            $izinjumlah = $izin->count();
            $ijin =DB::table('izin')
                ->leftjoin('statuses', 'izin.status', '=', 'statuses.id')
                ->leftjoin('datareject', 'datareject.id_izin', '=', 'izin.id')
                ->leftjoin('karyawan', 'izin.id_karyawan', 'karyawan.id')
                ->leftjoin('jenisizin', 'izin.id_jenisizin', '=', 'jenisizin.id')
                ->leftjoin('departemen','izin.departemen','=','departemen.id')
                ->select('izin.*', 'statuses.name_status', 'departemen.nama_departemen','jenisizin.jenis_izin', 'datareject.alasan as alasan', 'datareject.id_izin as id_izin', 'karyawan.atasan_pertama', 'karyawan.atasan_kedua', 'karyawan.nama')
                ->distinct()
                ->where(function ($query) {
                    $query->where('karyawan.partner', Auth::user()->partner)
                    ->where('karyawan.atasan_pertama', Auth::user()->id_pegawai)
                        ->orWhere('karyawan.atasan_kedua', Auth::user()->id_pegawai);
                })
                ->whereIn('izin.catatan', ['Mengajukan Pembatalan', 'Mengajukan Perubahan'])
                ->get();
            $jumizin = $ijin->count();
        }
        elseif($role->role == 3 && $row->jabatan == "Direksi")
        {
            $cuti = DB::table('cuti')
                ->leftjoin('alokasicuti', 'cuti.id_jeniscuti', 'alokasicuti.id_jeniscuti')
                ->leftjoin('settingalokasi', 'cuti.id_jeniscuti', 'settingalokasi.id_jeniscuti')
                ->leftjoin('jeniscuti', 'cuti.id_jeniscuti', 'jeniscuti.id')
                ->leftjoin('karyawan', 'cuti.id_karyawan', 'karyawan.id')
                ->leftjoin('statuses', 'cuti.status', '=', 'statuses.id')
                ->leftjoin('datareject', 'datareject.id_cuti', '=', 'cuti.id')
                ->leftjoin('departemen','cuti.departemen','=','departemen.id')
                ->select('cuti.*', 'jeniscuti.jenis_cuti', 'departemen.nama_departemen','karyawan.nama', 'statuses.name_status', 'karyawan.atasan_pertama', 'karyawan.atasan_kedua', 'datareject.alasan as alasan', 'datareject.id_cuti as id_cuti')
                ->distinct()
                ->where(function ($query) {
                    $query->where(function ($q) {
                        $q->where('cuti.status', 1)
                        ->where('karyawan.partner', Auth::user()->partner)
                            ->where('karyawan.atasan_pertama', Auth::user()->id_pegawai)
                            ->where('cuti.catatan', '=', NULL);
                    })
                    ->orWhere(function ($q) {
                        $q->whereIn('cuti.status', [1, 6])
                        ->where('karyawan.partner', Auth::user()->partner)
                            ->where('karyawan.atasan_kedua', Auth::user()->id_pegawai)
                            ->where('cuti.catatan', '=', NULL);
                    });
                })
                ->get();
            $cutijumlah = $cuti->count();

            $cutis = DB::table('cuti')
                ->leftjoin('alokasicuti', 'cuti.id_jeniscuti', 'alokasicuti.id_jeniscuti')
                ->leftjoin('settingalokasi', 'cuti.id_jeniscuti', 'settingalokasi.id_jeniscuti')
                ->leftjoin('jeniscuti', 'cuti.id_jeniscuti', 'jeniscuti.id')
                ->leftjoin('karyawan', 'cuti.id_karyawan', 'karyawan.id')
                ->leftjoin('statuses', 'cuti.status', '=', 'statuses.id')
                ->leftjoin('departemen','cuti.departemen','=','departemen.id')
                ->leftjoin('datareject', 'datareject.id_cuti', '=', 'cuti.id')
                ->select('cuti.*', 'jeniscuti.jenis_cuti', 'departemen.nama_departemen','karyawan.nama', 'statuses.name_status', 'karyawan.atasan_pertama', 'karyawan.atasan_kedua', 'datareject.alasan as alasan', 'datareject.id_cuti as id_cuti')
                ->distinct()
                ->where(function ($query) {
                    $query->where(function ($q) {
                        $q->whereIn('cuti.catatan', ['Mengajukan Pembatalan', 'Mengajukan Perubahan'])
                            ->where('karyawan.partner', Auth::user()->partner)
                            ->where('karyawan.atasan_pertama', Auth::user()->id_pegawai);
                    })
                    ->orWhere(function ($q) {
                        $q->whereIn('cuti.catatan', ['Mengajukan Pembatalan', 'Mengajukan Perubahan', 'Pembatalan Disetujui Atasan', 'Perubahan Disetujui Atasan'])
                            ->where('karyawan.partner', Auth::user()->partner)
                            ->where('karyawan.atasan_kedua', Auth::user()->id_pegawai);
                    });
                })
                ->get();
            $jumct = $cutis->count();

            $izin = DB::table('izin')
                ->leftjoin('statuses', 'izin.status', '=', 'statuses.id')
                ->leftjoin('datareject', 'datareject.id_izin', '=', 'izin.id')
                ->leftjoin('karyawan', 'izin.id_karyawan', 'karyawan.id')
                ->leftjoin('jenisizin', 'izin.id_jenisizin', '=', 'jenisizin.id')
                ->leftjoin('departemen','izin.departemen','=','departemen.id')
                ->select('izin.*', 'statuses.name_status', 'jenisizin.jenis_izin','departemen.nama_departemen', 'datareject.alasan as alasan', 'datareject.id_izin as id_izin', 'karyawan.atasan_pertama', 'karyawan.atasan_kedua', 'karyawan.nama')
                ->distinct()
                ->where(function ($query) {
                    $query->where(function ($q) {
                        $q->where('izin.status', 1)
                            ->where('karyawan.partner', Auth::user()->partner)
                            ->where('karyawan.atasan_pertama', Auth::user()->id_pegawai)
                            ->where('izin.catatan', '=', NULL);
                    })
                    ->orWhere(function ($q) {
                        $q->whereIn('izin.status', [1, 6])
                            ->where('karyawan.partner', Auth::user()->partner)
                            ->where('karyawan.atasan_kedua', Auth::user()->id_pegawai)
                            ->where('izin.catatan', '=', NULL);
                    });
                })
                ->get();
            $izinjumlah = $izin->count();
            $ijin =DB::table('izin')
                ->leftjoin('statuses', 'izin.status', '=', 'statuses.id')
                ->leftjoin('datareject', 'datareject.id_izin', '=', 'izin.id')
                ->leftjoin('karyawan', 'izin.id_karyawan', 'karyawan.id')
                ->leftjoin('jenisizin', 'izin.id_jenisizin', '=', 'jenisizin.id')
                ->leftjoin('departemen','izin.departemen','=','departemen.id')
                ->select('izin.*', 'statuses.name_status', 'departemen.nama_departemen','jenisizin.jenis_izin', 'datareject.alasan as alasan', 'datareject.id_izin as id_izin', 'karyawan.atasan_pertama', 'karyawan.atasan_kedua', 'karyawan.nama')
                ->distinct()
                ->where(function ($query) {
                    $query->where(function ($q) {
                        $q->whereIn('izin.catatan', ['Mengajukan Pembatalan', 'Mengajukan Perubahan'])
                            ->where('karyawan.partner', Auth::user()->partner)
                            ->where('karyawan.atasan_pertama', Auth::user()->id_pegawai);
                    })
                    ->orWhere(function ($q) {
                        $q->whereIn('izin.catatan', ['Mengajukan Pembatalan', 'Mengajukan Perubahan', 'Pembatalan Disetujui Atasan', 'Perubahan Disetujui Atasan'])
                            ->where('karyawan.partner', Auth::user()->partner)
                            ->where('karyawan.atasan_kedua', Auth::user()->id_pegawai);
                    });
                })
                ->get();
            $jumizin = $ijin->count();
        }
        elseif($role->role == 2)
        {
            $cuti = DB::table('cuti')
                ->leftjoin('alokasicuti', 'cuti.id_jeniscuti', 'alokasicuti.id_jeniscuti')
                ->leftjoin('settingalokasi', 'cuti.id_jeniscuti', 'settingalokasi.id_jeniscuti')
                ->leftjoin('jeniscuti', 'cuti.id_jeniscuti', 'jeniscuti.id')
                ->leftjoin('karyawan', 'cuti.id_karyawan', 'karyawan.id')
                ->leftjoin('statuses', 'cuti.status', '=', 'statuses.id')
                ->leftjoin('datareject', 'datareject.id_cuti', '=', 'cuti.id')
                ->leftjoin('departemen','cuti.departemen','=','departemen.id')
                ->select('cuti.*', 'jeniscuti.jenis_cuti','departemen.nama_departemen', 'karyawan.nama', 'statuses.name_status', 'karyawan.atasan_pertama', 'karyawan.atasan_kedua', 'datareject.alasan as alasan', 'datareject.id_cuti as id_cuti')
                ->distinct()
                ->where(function ($query) {
                    $query->where('karyawan.partner', Auth::user()->partner)
                    ->where('cuti.status', [1,6])
                    ->where('cuti.catatan', '=', NULL);
                })->get();

            $cutijumlah = $cuti->count();

            $cutis = DB::table('cuti')
                ->leftjoin('alokasicuti', 'cuti.id_jeniscuti', 'alokasicuti.id_jeniscuti')
                ->leftjoin('settingalokasi', 'cuti.id_jeniscuti', 'settingalokasi.id_jeniscuti')
                ->leftjoin('jeniscuti', 'cuti.id_jeniscuti', 'jeniscuti.id')
                ->leftjoin('karyawan', 'cuti.id_karyawan', 'karyawan.id')
                ->leftjoin('statuses', 'cuti.status', '=', 'statuses.id')
                ->leftjoin('departemen','cuti.departemen','=','departemen.id')
                ->leftjoin('datareject', 'datareject.id_cuti', '=', 'cuti.id')
                ->select('cuti.*', 'jeniscuti.jenis_cuti', 'departemen.nama_departemen','karyawan.nama', 'statuses.name_status', 'karyawan.atasan_pertama', 'karyawan.atasan_kedua', 'datareject.alasan as alasan', 'datareject.id_cuti as id_cuti')
                ->distinct()
                ->where('karyawan.partner', Auth::user()->partner)
                ->whereIn('cuti.catatan', ['Mengajukan Pembatalan', 'Mengajukan Perubahan'])
                ->get();
            $jumct = $cutis->count();

            $izin = DB::table('izin')
                ->leftjoin('statuses', 'izin.status', '=', 'statuses.id')
                ->leftjoin('datareject', 'datareject.id_izin', '=', 'izin.id')
                ->leftjoin('karyawan', 'izin.id_karyawan', 'karyawan.id')
                ->leftjoin('departemen','izin.departemen','=','departemen.id')
                ->leftjoin('jenisizin', 'izin.id_jenisizin', '=', 'jenisizin.id')
                ->select('izin.*', 'statuses.name_status','departemen.nama_departemen', 'jenisizin.jenis_izin', 'datareject.alasan as alasan', 'datareject.id_izin as id_izin', 'karyawan.atasan_pertama', 'karyawan.atasan_kedua', 'karyawan.nama')
                ->distinct()
                ->where('karyawan.partner', Auth::user()->partner)
                ->where('izin.status', '=', '1')
                ->where('izin.catatan',null)
                ->get();
            $izinjumlah = $izin->count();

            $ijin =DB::table('izin')
                ->leftjoin('statuses', 'izin.status', '=', 'statuses.id')
                ->leftjoin('datareject', 'datareject.id_izin', '=', 'izin.id')
                ->leftjoin('karyawan', 'izin.id_karyawan', 'karyawan.id')
                ->leftjoin('jenisizin', 'izin.id_jenisizin', '=', 'jenisizin.id')
                ->leftjoin('departemen','izin.departemen','=','departemen.id')
                ->select('izin.*', 'statuses.name_status', 'departemen.nama_departemen','jenisizin.jenis_izin', 'datareject.alasan as alasan', 'datareject.id_izin as id_izin', 'karyawan.atasan_pertama', 'karyawan.atasan_kedua', 'karyawan.nama')
                ->distinct()
                ->where('karyawan.partner', Auth::user()->partner)
                ->whereIn('izin.catatan',['Mengajukan Pembatalan','Mengajukan Perubahan'])
                ->get();
            $jumizin = $ijin->count();

        }
        elseif($role->role == 7)
        {
            $cuti = DB::table('cuti')
                ->leftjoin('alokasicuti', 'cuti.id_jeniscuti', 'alokasicuti.id_jeniscuti')
                ->leftjoin('settingalokasi', 'cuti.id_jeniscuti', 'settingalokasi.id_jeniscuti')
                ->leftjoin('jeniscuti', 'cuti.id_jeniscuti', 'jeniscuti.id')
                ->leftjoin('karyawan', 'cuti.id_karyawan', 'karyawan.id')
                ->leftjoin('statuses', 'cuti.status', '=', 'statuses.id')
                ->leftjoin('datareject', 'datareject.id_cuti', '=', 'cuti.id')
                ->leftjoin('departemen','cuti.departemen','=','departemen.id')
                ->select('cuti.*', 'jeniscuti.jenis_cuti', 'departemen.nama_departemen','karyawan.nama', 'statuses.name_status', 'karyawan.atasan_pertama', 'karyawan.atasan_kedua', 'datareject.alasan as alasan', 'datareject.id_cuti as id_cuti')
                ->distinct()
                ->where(function ($query) {
                    $query->where(function ($q) {
                        $q->where('cuti.status', 1)
                        ->where('karyawan.partner', Auth::user()->partner)
                            ->where('karyawan.atasan_pertama', Auth::user()->id_pegawai)
                            ->where('cuti.catatan', '=', NULL);
                    })
                    ->orWhere(function ($q) {
                        $q->whereIn('cuti.status', [1, 6])
                        ->where('karyawan.partner', Auth::user()->partner)
                            ->where('karyawan.atasan_kedua', Auth::user()->id_pegawai)
                            ->where('cuti.catatan', '=', NULL);
                    });
                })
                ->get();
            $cutijumlah = $cuti->count();

            $cutis = DB::table('cuti')
                ->leftjoin('alokasicuti', 'cuti.id_jeniscuti', 'alokasicuti.id_jeniscuti')
                ->leftjoin('settingalokasi', 'cuti.id_jeniscuti', 'settingalokasi.id_jeniscuti')
                ->leftjoin('jeniscuti', 'cuti.id_jeniscuti', 'jeniscuti.id')
                ->leftjoin('karyawan', 'cuti.id_karyawan', 'karyawan.id')
                ->leftjoin('statuses', 'cuti.status', '=', 'statuses.id')
                ->leftjoin('departemen','cuti.departemen','=','departemen.id')
                ->leftjoin('datareject', 'datareject.id_cuti', '=', 'cuti.id')
                ->select('cuti.*', 'jeniscuti.jenis_cuti', 'departemen.nama_departemen','karyawan.nama', 'statuses.name_status', 'karyawan.atasan_pertama', 'karyawan.atasan_kedua', 'datareject.alasan as alasan', 'datareject.id_cuti as id_cuti')
                ->distinct()
                ->where(function ($query) {
                    $query->where(function ($q) {
                        $q->whereIn('cuti.catatan', ['Mengajukan Pembatalan', 'Mengajukan Perubahan'])
                            ->where('karyawan.partner', Auth::user()->partner)
                            ->where('karyawan.atasan_pertama', Auth::user()->id_pegawai);
                    })
                    ->orWhere(function ($q) {
                        $q->whereIn('cuti.catatan', ['Mengajukan Pembatalan', 'Mengajukan Perubahan', 'Pembatalan Disetujui Atasan', 'Perubahan Disetujui Atasan'])
                            ->where('karyawan.partner', Auth::user()->partner)
                            ->where('karyawan.atasan_kedua', Auth::user()->id_pegawai);
                    });
                })
                ->get();
            $jumct = $cutis->count();

            $izin = DB::table('izin')
                ->leftjoin('statuses', 'izin.status', '=', 'statuses.id')
                ->leftjoin('datareject', 'datareject.id_izin', '=', 'izin.id')
                ->leftjoin('karyawan', 'izin.id_karyawan', 'karyawan.id')
                ->leftjoin('jenisizin', 'izin.id_jenisizin', '=', 'jenisizin.id')
                ->leftjoin('departemen','izin.departemen','=','departemen.id')
                ->select('izin.*', 'statuses.name_status', 'jenisizin.jenis_izin','departemen.nama_departemen', 'datareject.alasan as alasan', 'datareject.id_izin as id_izin', 'karyawan.atasan_pertama', 'karyawan.atasan_kedua', 'karyawan.nama')
                ->distinct()
                ->where(function ($query) {
                    $query->where(function ($q) {
                        $q->where('izin.status', 1)
                            ->where('karyawan.partner', Auth::user()->partner)
                            ->where('karyawan.atasan_pertama', Auth::user()->id_pegawai)
                            ->where('izin.catatan', '=', NULL);
                    })
                    ->orWhere(function ($q) {
                        $q->whereIn('izin.status', [1, 6])
                            ->where('karyawan.partner', Auth::user()->partner)
                            ->where('karyawan.atasan_kedua', Auth::user()->id_pegawai)
                            ->where('izin.catatan', '=', NULL);
                    });
                })
                ->get();
            $izinjumlah = $izin->count();
            $ijin =DB::table('izin')
                ->leftjoin('statuses', 'izin.status', '=', 'statuses.id')
                ->leftjoin('datareject', 'datareject.id_izin', '=', 'izin.id')
                ->leftjoin('karyawan', 'izin.id_karyawan', 'karyawan.id')
                ->leftjoin('jenisizin', 'izin.id_jenisizin', '=', 'jenisizin.id')
                ->leftjoin('departemen','izin.departemen','=','departemen.id')
                ->select('izin.*', 'statuses.name_status', 'departemen.nama_departemen','jenisizin.jenis_izin', 'datareject.alasan as alasan', 'datareject.id_izin as id_izin', 'karyawan.atasan_pertama', 'karyawan.atasan_kedua', 'karyawan.nama')
                ->distinct()
                ->where(function ($query) {
                    $query->where(function ($q) {
                        $q->whereIn('izin.catatan', ['Mengajukan Pembatalan', 'Mengajukan Perubahan'])
                            ->where('karyawan.partner', Auth::user()->partner)
                            ->where('karyawan.atasan_pertama', Auth::user()->id_pegawai);
                    })
                    ->orWhere(function ($q) {
                        $q->whereIn('izin.catatan', ['Mengajukan Pembatalan', 'Mengajukan Perubahan', 'Pembatalan Disetujui Atasan', 'Perubahan Disetujui Atasan'])
                            ->where('karyawan.partner', Auth::user()->partner)
                            ->where('karyawan.atasan_kedua', Auth::user()->id_pegawai);
                    });
                })
                ->get();
            $jumizin = $ijin->count();
        }
        else
        {
            $cuti = DB::table('cuti')
                    ->leftjoin('alokasicuti', 'cuti.id_jeniscuti', 'alokasicuti.id_jeniscuti')
                    ->leftjoin('settingalokasi', 'cuti.id_jeniscuti', 'settingalokasi.id_jeniscuti')
                    ->leftjoin('jeniscuti', 'cuti.id_jeniscuti', 'jeniscuti.id')
                    ->leftjoin('karyawan', 'cuti.id_karyawan', 'karyawan.id')
                    ->leftjoin('statuses', 'cuti.status', '=', 'statuses.id')
                    ->leftjoin('datareject', 'datareject.id_cuti', '=', 'cuti.id')
                    ->leftjoin('departemen','cuti.departemen','=','departemen.id')
                    ->select('cuti.*', 'jeniscuti.jenis_cuti', 'karyawan.nama','departemen.nama_departemen', 'statuses.name_status', 'karyawan.atasan_pertama', 'karyawan.atasan_kedua', 'datareject.alasan as alasan', 'datareject.id_cuti as id_cuti')
                    ->distinct()
                    ->where(function ($query) {
                        $query->where('karyawan.partner', Auth::user()->partner)
                            ->where('karyawan.atasan_pertama', Auth::user()->id_pegawai)
                            ->orWhere('karyawan.atasan_kedua', Auth::user()->id_pegawai);
                    })
                    ->whereIn('cuti.status',['1','2'])
                    ->where('cuti.catatan','=',NULL)
                    ->get();
            // $cutijumlah = $cuti->count();
            $cutijumlah = $cuti->count();

            $cutis = DB::table('cuti')
                ->leftjoin('alokasicuti', 'cuti.id_jeniscuti', 'alokasicuti.id_jeniscuti')
                ->leftjoin('settingalokasi', 'cuti.id_jeniscuti', 'settingalokasi.id_jeniscuti')
                ->leftjoin('jeniscuti', 'cuti.id_jeniscuti', 'jeniscuti.id')
                ->leftjoin('karyawan', 'cuti.id_karyawan', 'karyawan.id')
                ->leftjoin('statuses', 'cuti.status', '=', 'statuses.id')
                ->leftjoin('departemen','cuti.departemen','=','departemen.id')
                ->leftjoin('datareject', 'datareject.id_cuti', '=', 'cuti.id')
                ->select('cuti.*', 'jeniscuti.jenis_cuti', 'departemen.nama_departemen','karyawan.nama', 'statuses.name_status', 'karyawan.atasan_pertama', 'karyawan.atasan_kedua', 'datareject.alasan as alasan', 'datareject.id_cuti as id_cuti')
                ->distinct()
                ->where(function ($query) {
                    $query->where('karyawan.partner', Auth::user()->partner)
                        ->where('karyawan.atasan_pertama', Auth::user()->id_pegawai)
                        ->orWhere('karyawan.atasan_kedua', Auth::user()->id_pegawai);
                })
                ->whereIn('cuti.catatan', ['Mengajukan Pembatalan', 'Mengajukan Perubahan'])
                ->get();
            $jumct = $cutis->count();

            $izin = DB::table('izin')
                ->leftjoin('statuses', 'izin.status', '=', 'statuses.id')
                ->leftjoin('datareject', 'datareject.id_izin', '=', 'izin.id')
                ->leftjoin('karyawan', 'izin.id_karyawan', 'karyawan.id')
                ->leftjoin('jenisizin', 'izin.id_jenisizin', '=', 'jenisizin.id')
                ->leftjoin('departemen','izin.departemen','=','departemen.id')
                ->select('izin.*', 'statuses.name_status','departemen.nama_departemen', 'jenisizin.jenis_izin', 'datareject.alasan as alasan', 'datareject.id_izin as id_izin', 'karyawan.atasan_pertama', 'karyawan.atasan_kedua', 'karyawan.nama')
                ->distinct()
                ->where(function ($query) {
                    $query->where('karyawan.partner', Auth::user()->partner)
                        ->where('karyawan.atasan_pertama', Auth::user()->id_pegawai)
                        ->orWhere('karyawan.atasan_kedua', Auth::user()->id_pegawai);
                })
                ->whereIn('izin.status',['1','2'])
                ->get();
            $izinjumlah = $izin->count();
            $ijin =DB::table('izin')
                ->leftjoin('statuses', 'izin.status', '=', 'statuses.id')
                ->leftjoin('datareject', 'datareject.id_izin', '=', 'izin.id')
                ->leftjoin('karyawan', 'izin.id_karyawan', 'karyawan.id')
                ->leftjoin('jenisizin', 'izin.id_jenisizin', '=', 'jenisizin.id')
                ->leftjoin('departemen','izin.departemen','=','departemen.id')
                ->select('izin.*', 'statuses.name_status', 'departemen.nama_departemen','jenisizin.jenis_izin', 'datareject.alasan as alasan', 'datareject.id_izin as id_izin', 'karyawan.atasan_pertama', 'karyawan.atasan_kedua', 'karyawan.nama')
                ->distinct()
                ->where(function ($query) {
                    $query->where('karyawan.partner', Auth::user()->partner)
                        ->where('karyawan.atasan_pertama', Auth::user()->id_pegawai)
                        ->orWhere('karyawan.atasan_kedua', Auth::user()->id_pegawai);
                })
                ->whereIn('izin.catatan',['Mengajukan Pembatalan','Mengajukan Perubahan'])
                ->get();
            $jumizin = $ijin->count();
        }

        // $resign = Resign::where('status', '!=', '7')
        //     ->where('status', '!=', '5')
        //     ->get();

        // $resign = Resign::where(function ($query) {
        //     $query->where('status', '=', '1')
        //     ->whereHas('karyawan', function ($query) {
        //         $query->where('atasan_pertama', Auth::user()->id_pegawai);
        //     });
        // })->orWhere(function ($query) {
        //     $query->where('status', '=', '6')
        //     ->whereHas('karyawan', function ($query) {
        //         $query->where('atasan_kedua', Auth::user()->id_pegawai);
        //     });
        // })->get();


        // $sisacutis = Sisacuti::with(['karyawans','jeniscutis'])->where('status',1)->get();
        $sisacutis = Sisacuti::with(['karyawans','jeniscutis'])
            ->where('status',1)
            ->where('sisa_cuti','>',0)
            ->whereDate('dari', '<=', Carbon::now())
            ->whereDate('sampai', '>=', Carbon::now())
            ->whereHas('karyawans', function ($query) use ($row) {
                $query->where('partner', $row->partner);
            })
            ->where('sisacuti.id_pegawai','=',Auth::user()->id_pegawai)->get();


        //NOTIFIKASI DATA TINDAKAN TERHADAPA KARYAWAN TIDAK MASUK

        $pct = Settingabsensi::where('sanksi_tidak_masuk', '=', 'Potong Uang Makan')
            ->where('partner',Auth::user()->partner)
            ->select('jumlah_tidakmasuk','partner')
            ->first();

        if($pct)
        {
            $potonguangmakan = Tidakmasuk::leftJoin('setting_absensi', 'tidakmasuk.status', '=', 'setting_absensi.status_tidakmasuk')
                ->leftJoin('karyawan', 'tidakmasuk.id_pegawai', '=', 'karyawan.id')
                ->where('tidakmasuk.status', '=', 'tanpa keterangan')
                ->where('karyawan.partner',Auth::user()->partner)
                ->where('setting_absensi.partner',$pct->partner)
                ->whereMonth('tidakmasuk.tanggal', '=', Carbon::now()->month)
                ->select('tidakmasuk.id_pegawai as id_pegawai','tidakmasuk.status as keterangan','setting_absensi.jumlah_tidakmasuk as jumlah', 'setting_absensi.sanksi_tidak_masuk as sanksi', DB::raw('COUNT(tidakmasuk.id_pegawai) as total'))
                ->havingRaw('COUNT(tidakmasuk.id_pegawai) = CASE WHEN setting_absensi.sanksi_tidak_masuk = "Potong Uang Makan" THEN ' . $pct->jumlah_tidakmasuk . ' END')
                ->groupBy('setting_absensi.jumlah_tidakmasuk', 'setting_absensi.sanksi_tidak_masuk', 'tidakmasuk.id_pegawai','tidakmasuk.status')
                ->get();
            $jpc = $potonguangmakan->count();
        }else
        {
            $potonguangmakan = collect();
            $jpc = 0;
        }

        $pg = Settingabsensi::where('sanksi_tidak_masuk', '=', 'Potong Uang Transportasi')
            ->where('partner',Auth::user()->partner)
            ->select('jumlah_tidakmasuk','partner')
            ->first();

        if($pg)
        {
            $potongtransport = Tidakmasuk::leftJoin('setting_absensi', 'tidakmasuk.status', '=', 'setting_absensi.status_tidakmasuk')
            ->leftJoin('karyawan', 'tidakmasuk.id_pegawai', '=', 'karyawan.id')
            ->where('tidakmasuk.status', '=', 'tanpa keterangan')
            ->where('karyawan.partner', '=', Auth::user()->partner)
            ->where('setting_absensi.partner',Auth::user()->partner)
            ->whereMonth('tidakmasuk.tanggal', '=', Carbon::now()->month)
            ->select('tidakmasuk.id_pegawai as id_pegawai', 'karyawan.partner','setting_absensi.jumlah_tidakmasuk as jumlah', 'setting_absensi.sanksi_tidak_masuk as sanksi', DB::raw('COUNT(tidakmasuk.id_pegawai) as total'))
            ->havingRaw('COUNT(tidakmasuk.id_pegawai) = CASE WHEN setting_absensi.sanksi_tidak_masuk = "Potong Uang Transportasi" THEN ' . $pg->jumlah_tidakmasuk . ' END')
            ->groupBy('setting_absensi.jumlah_tidakmasuk','karyawan.partner', 'setting_absensi.sanksi_tidak_masuk', 'tidakmasuk.id_pegawai')
            ->get();

            $jpg = $potongtransport->count();
        }
        else
        {
            $potongtransport = collect();
            $jpg = 0;
        }

         //data karyawan terlambat


         $tb = Settingabsensi::where('sanksi_terlambat', '=', 'Teguran Biasa')
            ->where('partner',Auth::user()->partner)
            ->select('jumlah_terlambat','partner')->first();

         $sp1 = Settingabsensi::where('sanksi_terlambat', '=', 'SP Pertama')
            ->where('partner',Auth::user()->partner)
            ->select('jumlah_terlambat','partner')->first();

         $sp2 = Settingabsensi::where('sanksi_terlambat', '=', 'SP Kedua')
            ->where('partner',Auth::user()->partner)
            ->select('jumlah_terlambat','partner')->first();

         $sp3 = Settingabsensi::where('sanksi_terlambat', '=', 'SP Ketiga')->select('jumlah_terlambat')->first();

        if($tb)
        {
            $terlambat = Absensi::leftJoin('setting_absensi', 'absensi.terlambat', '>', 'setting_absensi.toleransi_terlambat')
                ->leftJoin('karyawan', 'absensi.id_karyawan', '=', 'karyawan.id')
                ->select('absensi.id_karyawan as id_karyawan','setting_absensi.jumlah_terlambat as jumlah', 'setting_absensi.sanksi_terlambat as sanksi', DB::raw('COUNT(absensi.id_karyawan) as total'))
                ->havingRaw('COUNT(absensi.id_karyawan) = CASE WHEN setting_absensi.sanksi_terlambat = "Teguran Biasa" THEN ' . $tb->jumlah_terlambat . ' END')
                ->whereYear('absensi.tanggal', '=', Carbon::now()->subMonth()->year)->whereMonth('absensi.tanggal', '=',Carbon::now()->subMonth()->month)
                ->where('karyawan.partner',Auth::user()->partner)
                ->groupBy('setting_absensi.jumlah_terlambat', 'setting_absensi.sanksi_terlambat', 'absensi.id_karyawan')
                ->get();
            $jumter = $terlambat->count();
        }else{
            $terlambat = collect();
            $jumter = 0;
        }

        if($sp1)
        {
            $telat = Absensi::leftJoin('setting_absensi', 'absensi.terlambat', '>', 'setting_absensi.toleransi_terlambat')
                ->leftJoin('karyawan', 'absensi.id_karyawan', '=', 'karyawan.id')
                ->select('absensi.id_karyawan as id_karyawan', 'setting_absensi.jumlah_terlambat as jumlah', 'setting_absensi.sanksi_terlambat as sanksi', DB::raw('COUNT(absensi.id_karyawan) as total'))
                ->havingRaw('COUNT(absensi.id_karyawan) = CASE WHEN setting_absensi.sanksi_terlambat = "SP Pertama" THEN ' . $sp1->jumlah_terlambat . ' END')
                ->whereYear('absensi.tanggal', '=', Carbon::now()->subMonth()->year)
                ->whereMonth('absensi.tanggal', '=',Carbon::now()->subMonth()->month)
                ->where('karyawan.partner',Auth::user()->partner)
                ->groupBy('setting_absensi.jumlah_terlambat', 'setting_absensi.sanksi_terlambat', 'absensi.id_karyawan')
                ->get();
            $jumtel = $telat->count();
        }else{
            $telat= collect();
            $jumtel = 0;
        }

        if($sp2)
        {
            $datatelat = Absensi::leftJoin('setting_absensi', 'absensi.terlambat', '>', 'setting_absensi.toleransi_terlambat')
                ->leftJoin('karyawan', 'absensi.id_karyawan', '=', 'karyawan.id')
                ->select('absensi.id_karyawan as id_karyawan', 'setting_absensi.jumlah_terlambat as jumlah', 'setting_absensi.sanksi_terlambat as sanksi', DB::raw('COUNT(absensi.id_karyawan) as total'))
                ->havingRaw('COUNT(absensi.id_karyawan) = CASE WHEN setting_absensi.sanksi_terlambat = "SP Pertama" THEN ' . $sp2->jumlah_terlambat . ' END')
                ->whereYear('absensi.tanggal', '=', Carbon::now()->subMonth()->year)->whereMonth('absensi.tanggal', '=',Carbon::now()->subMonth()->month)
                ->where('karyawan.partner',Auth::user()->partner)
                ->groupBy('setting_absensi.jumlah_terlambat', 'setting_absensi.sanksi_terlambat', 'absensi.id_karyawan')
                ->get();
            $jumdat = $datatelat->count();
        }else{
            $datatelat= collect();
            $jumdat = 0;
        }

        $rekruitmen = Lowongan::where('status','Aktif')
            ->where('partner',Auth::user()->partner)->get();
        $rekruitmenjumlah = $rekruitmen->count();
        // dd($potongcuti);

        // dd($absenTerlambatbulanlalu);
        // Role Admin
//------------------------------------------------------------------------------------------------------------------------------------------------------------------


        if ($role->role == 5) {

            $output = [
                'row' => $row,

            ];
            return view('admin.datamaster.user.dashboardAdmin', $output);

        }
        elseif ($role->role == 1)
        {

            $output = [
                'row' => $row,
                'sisacutis' => $sisacutis,
                'cutiPerbulan' => $cutiPerbulan,
                'cutiHariinihrd' => $cutiHariinihrd,
                'absenHariinihrd' => $absenHariinihrd,
                'absenHarini' => $absenHarini,
                'jumAbsen' =>  $jumAbsen,
                'absenBulaninihrd' => $absenBulaninihrd,
                'absenBulanlalu' => $absenBulanlalu,
                'absenTerlambat' => $absenTerlambat,
                'absenTerlambatbulanlaluhrd' => $absenTerlambatbulanlaluhrd,
                'data' => $data,
                'labelBulan' => $labelBulan,
                'absenTerlambatHariInihrd' => $absenTerlambatHariInihrd,
                'dataIzinHariinihrd' => $dataIzinHariinihrd,
                'cutidanizin' => $cutidanizin,
                'dataIzinPerbulan' => $dataIzinPerbulan,
                'cutidanizinPerbulan' => $cutidanizinPerbulan,
                'dataIzinbulanlaluhrd' => $dataIzinbulanlaluhrd,
                'cutibulanlaluhrd' => $cutibulanlaluhrd,
                'cutidanizibulanlalu' => $cutidanizibulanlalu,
                'tahun' => $tahun,
                'totalTidakAbsenHariInihrd' => $totalTidakAbsenHariInihrd,
                'tidakMasukBulanInihrd' => $tidakMasukBulanInihrd,
                'tidakMasukHariIni' => $tidakMasukHariIni,
                'alokasicuti' => $alokasicuti,
                'alokasi' => $alokasi,
                'absenKaryawan' => $absenKaryawan,
                'alokasicuti2' => $alokasicuti2,
                'posisi' => $posisi,
                'cuti' => $cuti,
                'cutijumlah' => $cutijumlah,
                'cutis' => $cutis,
                'jumct' => $jumct,
                'izin' => $izin,
                'izinjumlah' => $izinjumlah,
                'ijin' => $ijin,
                'jumizin' => $jumizin,
                'resign' => $resign,
                'resignjumlah' => $resignjumlah,
                'potonguangmakan' =>$potonguangmakan,
                'potongtransport'=>$potongtransport,
                'jpc' => $jpc,
                'jpg' => $jpg,
                'terlambat' => $terlambat,
                'telat'=> $telat,
                'datatelat' => $datatelat,
                'jumter' =>$jumter,
                'jumtel' => $jumtel,
                'jumdat' => $jumdat,
                'rekruitmenjumlah' => $rekruitmenjumlah,
                'role' => $role,
                'karyawan' => $karyawan,
                'jumlahKaryawanPerJabatan' => $jumlahKaryawanPerJabatan,
                'jumlahKaryawanPerJabatan2' => $jumlahKaryawanPerJabatan2,
                'jumlahkaryawan' => $jumlahkaryawan,
                'informasi' =>$informasi,
                'jmlinfo' => $jmlinfo,
                'jumAbsenKemarin' => $jumAbsenKemarin,
                'absenTerlambatKemarinhrd' => $absenTerlambatKemarinhrd,
                'tidakMasukKemarinhrd' => $tidakMasukKemarinhrd,
                'cutiKemarinhrd' => $cutiKemarinhrd,
                'dataIzinKemarinhrd' => $dataIzinKemarinhrd,
                'absenTerlambatBulanInihrd' => $absenTerlambatBulanInihrd,
                'cutiBulanInihrd' => $cutiBulanInihrd,
                'dataIzinBulanInihrd' => $dataIzinBulanInihrd,
                'tidakMasukBulanLaluhrd' => $tidakMasukBulanLaluhrd,
                'absenBulanLaluhrd' => $absenBulanLaluhrd,
                'jumCutiBulanIni' => $jumCutiBulanIni,
                'jumCutiBulanLalu' => $jumCutiBulanLalu,
                'jumIzinBulanIni' => $jumIzinBulanIni,
                'jumIzinBulanLalu' => $jumIzinBulanLalu,
            ];
            return view('admin.karyawan.dashboardhrd', $output);

        } elseif ($role->role == 3 && $row->jabatan == "Asistant Manager") {

            $output = [
                'row' => $row,
                'absenTerlambatkaryawan' => $absenTerlambatkaryawan,
                'absenKaryawan' => $absenKaryawan,
                'absenTidakmasuk' => $absenTidakmasuk,
                'alokasicuti' => $alokasicuti,
                'sisacuti' => $sisacuti,
                // 'absenBulanini' => $absenBulanini,
                // 'absenBulanlalu'=> $absenBulanlalu,
                'absenTerlambatbulanlalumanager'=> $absenTerlambatbulanlalumanager,
                'sisacutis' => $sisacutis,
                'role' => $role,
                'cuti' => $cuti,
                'cutijumlah' => $cutijumlah,
                'cutis' => $cutis,
                'jumct' => $jumct,
                'izin' => $izin,
                'izinjumlah' => $izinjumlah,
                'ijin' => $ijin,
                'jumizin' => $jumizin,
                'resign' => $resign,
                'resignjumlah' => $resignjumlah,
                'posisi' => $posisi,
                'informasi' =>$informasi,
                'jmlinfo' => $jmlinfo,
                'absenTerlambatBulanini' => $absenTerlambatBulanini,
                'absenBulaninimanager' => $absenBulaninimanager,
                'absenBulanlalumanager' => $absenBulanlalumanager,
                'jumIzinBulanInimgr' => $jumIzinBulanInimgr,
                'jumCutiBulanInimgr' => $jumCutiBulanInimgr,
                'jumIzinBulanLalumgr' => $jumIzinBulanLalumgr,
                'jumCutiBulanLalumgr' => $jumCutiBulanLalumgr,
                'absenTerlambatbulanlalumanager' => $absenTerlambatbulanlalumanager,
                'tidakMasukBulanini' => $tidakMasukBulanini,
                'tidakMasukBulanlalu' => $tidakMasukBulanlalu,

                // 'tidakMasukBulanini' => $tidakMasukBulanini,
                // 'tidakMasukBulanlalu' => $tidakMasukBulanlalu,
                // 'jumAbsenKemarin' => $jumAbsenKemarin,
                // 'absenTerlambatKemarin' => $absenTerlambatKemarin,
                // 'tidakMasukKemarin' => $tidakMasukKemarin,
                // 'cutiKemarin' => $cutiKemarin,
                // 'dataIzinKemarin' => $dataIzinKemarin,

                // 'cekSisacuti' => $cekSisacuti,
            ];
            return view('karyawan.dashboardKaryawan', $output);

        } elseif ($role->role == 2) {
            $absenHariini = Absensi::whereYear('tanggal', '=', Carbon::now()->year)
                ->whereMonth('tanggal', '=', Carbon::now()->month)
                ->whereDay('tanggal', '=', Carbon::now())
                ->where('partner',Auth::user()->partner)
                ->count();

            $output = [
                'row' => $row,
                'absenTerlambatkaryawan' => $absenTerlambatkaryawan,
                'absenKaryawan' => $absenKaryawan,
                'absenTidakmasuk' => $absenTidakmasuk,
                'alokasicuti' => $alokasicuti,
                'alokasi' => $alokasi,
                'informasi' => $informasi,
                'jmlinfo' => $jmlinfo,
                'sisacuti' => $sisacuti,
                'absenBulanini' => $absenBulanini,
                'absenBulanlalu'=> $absenBulanlalu,
                'absenTerlambatbulanlalu'=> $absenTerlambatbulanlalu,
                'absenHariini' =>  $absenHariini,
                'absenHarini' => $absenHarini,
                'jumAbsen' =>  $jumAbsen,
                // 'jumAbsenKemarin' => $jumAbsenKemarin,
                'sisacutis' => $sisacutis,
                'role' => $role,
                'informasi' =>$informasi,
                'jmlinfo' => $jmlinfo,
                'cuti' =>$cuti,
                'cutijumlah' => $cutijumlah,
                'cutis' => $cutis,
                'jumct' => $jumct,
                'resign' => $resign,
                'resignjumlah' => $resignjumlah,
                'izin' => $izin,
                'izinjumlah' => $izinjumlah,
                'ijin' => $ijin,
                'jumizin' => $jumizin,
                'absenTerlambatBulanIni' => $absenTerlambatBulanIni,
                'tidakMasukBulanini' => $tidakMasukBulanini,
                'tidakMasukBulanlalu' => $tidakMasukBulanlalu,
                // 'cutijumlah' => $cutijumlah,
                // 'cuti' => $cuti,
                // 'jumct' => $jumct,
                // 'cutis' => $cutis,
                // 'resignjumlah' => $resignjumlah,
                // 'resign' => $resign,
                // 'izinjumlah' => $izinjumlah,
                // 'izin' => $izin,
                // 'jumizin' => $jumizin,
                // 'ijin' => $ijin,
                'posisi' => $posisi,
                // 'cekSisacuti' => $cekSisacuti,
            ];
            return view('karyawan.dashboardKaryawan', $output);
        }
        elseif($role->role == 3 && $row->jabatan == "Manager")
        {

            $output = [
                'informasi' =>$informasi,
                'jmlinfo' => $jmlinfo,
                'row' => $row,
                'role' => $role,
                'absenTerlambatkaryawan' => $absenTerlambatkaryawan,
                'absenKaryawan' => $absenKaryawan,
                'absenTidakmasuk' => $absenTidakmasuk,
                'alokasicuti' => $alokasicuti,
                'sisacuti' => $sisacuti,
                // 'absenBulanini' => $absenBulanini,
                // 'absenBulanlalu'=> $absenBulanlalu,
                'absenTerlambatbulanlalu'=> $absenTerlambatbulanlalu,
                'data' => $data,
                'labelBulan' => $labelBulan,
                // 'absenTerlambatHariIni' => $absenTerlambatHariIni,
                'dataIzinHariini' => $dataIzinHariini,
                'cutidanizin' => $cutidanizin,
                'dataIzinPerbulan' => $dataIzinPerbulan,
                'cutidanizinPerbulan' => $cutidanizinPerbulan,
                'dataIzinbulanlalu' => $dataIzinbulanlalu,
                'cutibulanlalu' => $cutibulanlalu,
                'cutidanizibulanlalu' => $cutidanizibulanlalu,
                'tahun' => $tahun,
                'totalTidakAbsenHariIni' => $totalTidakAbsenHariIni,
                'tidakMasukBulanIni' => $tidakMasukBulanIni,
                'tidakMasukHariIni' => $tidakMasukHariIni,
                'alokasicuti' => $alokasicuti,
                'absenKaryawan' => $absenKaryawan,
                'alokasicuti2' => $alokasicuti2,
                'posisi' => $posisi,
                'cuti' => $cuti,
                'cutijumlah' => $cutijumlah,
                'cutis' => $cutis,
                'jumct' => $jumct,
                'izin' => $izin,
                'izinjumlah' => $izinjumlah,
                'ijin' => $ijin,
                'jumizin' => $jumizin,
                'resign' => $resign,
                'resignjumlah' => $resignjumlah,
                'sisacutis' => $sisacutis,
                'tidakMasukBulanini' => $tidakMasukBulanini,
                'tidakMasukBulanlalu' => $tidakMasukBulanlalu,
                'absenTerlambatBulanini' => $absenTerlambatBulanini,
                'absenBulaninimanager' => $absenBulaninimanager,
                'absenBulanlalumanager' => $absenBulanlalumanager,
                'jumIzinBulanInimgr' => $jumIzinBulanInimgr,
                'jumCutiBulanInimgr' => $jumCutiBulanInimgr,
                'jumIzinBulanLalumgr' => $jumIzinBulanLalumgr,
                'jumCutiBulanLalumgr' => $jumCutiBulanLalumgr,
                'absenTerlambatbulanlalumanager' => $absenTerlambatbulanlalumanager,
                // 'cekSisacuti' => $cekSisacuti,
            ];
            return view('karyawan.dashboardKaryawan', $output);
        }
        elseif($role->role == 3 && $row->jabatan == "Direksi")
        {
            $output = [
                'informasi' =>$informasi,
                'jmlinfo' => $jmlinfo,
                'row' => $row,
                'role' => $role,
                'absenTerlambatkaryawan' => $absenTerlambatkaryawan,
                'absenKaryawan' => $absenKaryawan,
                'absenTidakmasuk' => $absenTidakmasuk,
                'alokasicuti' => $alokasicuti,
                'sisacuti' => $sisacuti,
                'absenBulanini' => $absenBulanini,
                'absenBulanlalu'=> $absenBulanlalu,
                'absenTerlambatbulanlalu'=> $absenTerlambatbulanlalu,
                'data' => $data,
                'labelBulan' => $labelBulan,
                // 'absenTerlambatHariIni' => $absenTerlambatHariIni,
                'dataIzinHariini' => $dataIzinHariini,
                'cutidanizin' => $cutidanizin,
                'dataIzinPerbulan' => $dataIzinPerbulan,
                'cutidanizinPerbulan' => $cutidanizinPerbulan,
                'dataIzinbulanlalu' => $dataIzinbulanlalu,
                'cutibulanlalu' => $cutibulanlalu,
                'cutidanizibulanlalu' => $cutidanizibulanlalu,
                'tahun' => $tahun,
                'totalTidakAbsenHariIni' => $totalTidakAbsenHariIni,
                'tidakMasukBulanIni' => $tidakMasukBulanIni,
                'tidakMasukHariIni' => $tidakMasukHariIni,
                'alokasicuti' => $alokasicuti,
                'absenKaryawan' => $absenKaryawan,
                'alokasicuti2' => $alokasicuti2,
                'posisi' => $posisi,
                'cuti' => $cuti,
                'cutijumlah' => $cutijumlah,
                'cutis' => $cutis,
                'jumct' => $jumct,
                'izin' => $izin,
                'izinjumlah' => $izinjumlah,
                'ijin' => $ijin,
                'jumizin' => $jumizin,
                'resign' => $resign,
                'resignjumlah' => $resignjumlah,
                'sisacutis' => $sisacutis,
                'absenBulaninimanager' => $absenBulaninimanager,
                'absenBulanlalumanager' => $absenBulanlalumanager,
                'absenTerlambatBulanini' => $absenTerlambatBulanini,
                'absenTerlambatbulanlalumanager' => $absenTerlambatbulanlalumanager,
                'tidakMasukBulanini' => $tidakMasukBulanini,
                'tidakMasukBulanlalu' => $tidakMasukBulanlalu,
                'jumIzinBulanInimgr' => $jumIzinBulanInimgr,
                'jumCutiBulanInimgr' => $jumCutiBulanInimgr,
                'jumIzinBulanLalumgr' => $jumIzinBulanLalumgr,
                'jumCutiBulanLalumgr' => $jumCutiBulanLalumgr,
                'namabulan' => $namabulan,
                'attendance'=> $attendance,
                'terlambats'=> $terlambats,
                'tidakmasuk'=> $tidakmasuk,
                'leave'     => $leave,
                'permission'=> $permission,
                'absenTerlambatBulanIni' => $absenTerlambatBulanIni,
                // 'jumAbsenKemarin' => $jumAbsenKemarin,
                // 'cutiKemarin' => $cutiKemarin,
                // 'dataIzinKemarin' => $dataIzinKemarin,
                // 'cekSisacuti' => $cekSisacuti,
            ];

            return view('karyawan.dashboardKaryawan', $output);
        }
        elseif($role->role == 7)
        {

            $absenBulanini  = Absensi::where('partner',Auth::user()->partner)
                ->whereYear('tanggal', '=', Carbon::now()->year)
                ->whereMonth('tanggal', '=', Carbon::now()->month)
                ->count();
            $output = [
                'informasi' =>$informasi,
                'jmlinfo' => $jmlinfo,
                'row' => $row,
                'role' => $role,
                'absenTerlambatkaryawan' => $absenTerlambatkaryawan,
                'absenKaryawan' => $absenKaryawan,
                'absenTidakmasuk' => $absenTidakmasuk,
                'alokasicuti' => $alokasicuti,
                'sisacuti' => $sisacuti,
                'absenBulanini' => $absenBulanini,
                'absenBulanlalu'=> $absenBulanlalu,
                'absenTerlambatBulanini' => $absenTerlambatBulanini,
                'absenTerlambatbulanlalu'=> $absenTerlambatbulanlalu,
                'absenTerlambatBulanIni' => $absenTerlambatBulanIni,
                'data' => $data,
                'labelBulan' => $labelBulan,
                // 'absenTerlambatHariIni' => $absenTerlambatHariIni,
                'dataIzinHariini' => $dataIzinHariini,
                'cutidanizin' => $cutidanizin,
                'dataIzinPerbulan' => $dataIzinPerbulan,
                'cutidanizinPerbulan' => $cutidanizinPerbulan,
                'dataIzinbulanlalu' => $dataIzinbulanlalu,
                'cutibulanlalu' => $cutibulanlalu,
                'cutidanizibulanlalu' => $cutidanizibulanlalu,
                'tahun' => $tahun,
                'totalTidakAbsenHariIni' => $totalTidakAbsenHariIni,
                'tidakMasukBulanIni' => $tidakMasukBulanIni,
                'tidakMasukHariIni' => $tidakMasukHariIni,
                'alokasicuti' => $alokasicuti,
                'absenKaryawan' => $absenKaryawan,
                'alokasicuti2' => $alokasicuti2,
                'posisi' => $posisi,
                'cuti' => $cuti,
                'cutijumlah' => $cutijumlah,
                'cutis' => $cutis,
                'jumct' => $jumct,
                'izin' => $izin,
                'izinjumlah' => $izinjumlah,
                'ijin' => $ijin,
                'jumizin' => $jumizin,
                'resign' => $resign,
                'resignjumlah' => $resignjumlah,
                'sisacutis' => $sisacutis,
                'namabulan' => $namabulan,
                'attendance'=> $attendance,
                'terlambats'=> $terlambats,
                'tidakmasuk'=> $tidakmasuk,
                'leave'     => $leave,
                'permission'=> $permission,
                // 'jumAbsenKemarin' => $jumAbsenKemarin,
                // 'cutiKemarin' => $cutiKemarin,
                // 'dataIzinKemarin' => $dataIzinKemarin,
                // 'cekSisacuti' => $cekSisacuti,
            //   dd($attendance)
            ];
            return view('karyawan.dashboardKaryawan', $output);
        }
        else
        {
            $output = [
                'row' => $row,
                'role' => $role,
                'informasi' =>$informasi,
                'jmlinfo' => $jmlinfo,
                'absenTerlambatkaryawan' => $absenTerlambatkaryawan,
                'absenKaryawan' => $absenKaryawan,
                'absenTidakmasuk' => $absenTidakmasuk,
                'alokasicuti' => $alokasicuti,
                'sisacuti' => $sisacuti,
                'absenBulanini' => $absenBulanini,
                'absenBulanlalu'=> $absenBulanlalu,
                'absenTerlambatbulanlalu'=> $absenTerlambatbulanlalu,
                'data' => $data,
                'labelBulan' => $labelBulan,
                // 'absenTerlambatHariIni' => $absenTerlambatHariIni,
                'dataIzinHariini' => $dataIzinHariini,
                'cutidanizin' => $cutidanizin,
                'dataIzinPerbulan' => $dataIzinPerbulan,
                'cutidanizinPerbulan' => $cutidanizinPerbulan,
                'dataIzinbulanlalu' => $dataIzinbulanlalu,
                'cutibulanlalu' => $cutibulanlalu,
                'cutidanizibulanlalu' => $cutidanizibulanlalu,
                'tahun' => $tahun,
                'totalTidakAbsenHariIni' => $totalTidakAbsenHariIni,
                'tidakMasukBulanIni' => $tidakMasukBulanIni,
                'tidakMasukHariIni' => $tidakMasukHariIni,
                'alokasicuti' => $alokasicuti,
                'absenKaryawan' => $absenKaryawan,
                'alokasicuti2' => $alokasicuti2,
                'posisi' => $posisi,
                'resign' => $resign,
                'resignjumlah' => $resignjumlah,
                'sisacutis' => $sisacutis,
                // 'jumAbsenKemarin' => $jumAbsenKemarin,
                // 'cutiKemarin' => $cutiKemarin,
                // 'dataIzinKemarin' => $dataIzinKemarin,
                // 'cekSisacuti' => $cekSisacuti,
            ];
            return view('karyawan.dashboardKaryawan', $output);
        }
    }

    public function cuti()
    {
        return view('cuti');
    }
}
