<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Cuti;
use App\Models\Izin;
use App\Models\User;
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
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();

        // Absen Terlambat Karyawan
        $absenTerlambatkaryawan = Absensi::where('partner',$row->partner)
            ->where('partner',Auth::user()->partner)
            ->where('id_karyawan', Auth::user()->id_pegawai)
            ->count('terlambat');
        // Absen Karyawan Hari Ini
        $absenKaryawan = Absensi::where('id_karyawan', Auth::user()->id_pegawai)
            ->where('partner',Auth::user()->partner)
            ->whereDay('created_at', '=', Carbon::now(),)
            ->count('jam_masuk');

        // Absen Tidak Masuk
        $absenTidakmasuk = Absensi::where('id_karyawan', Auth::user()->id_pegawai)
            ->where('partner',Auth::user()->partner)
            ->whereMonth('created_at', '=', Carbon::now()->month)
            ->count('jam_masuk');

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

        $today = Carbon::now()->format('Y-m-d');
        // $dataIzinHariini = Izin::where(function ($query) use ($today) {
        //         $query->where('tgl_mulai', '<=', $today)
        //         ->where('tgl_selesai', '>=', $today);
        //     })
        //     ->where('status', '=', 7)
        //     ->count('jml_hari');

        $dataIzinHariini = Izin::whereHas('karyawan', function ($query) use ($today) {
                $query->where('partner', '=', Auth::user()->partner);
            })
            ->where(function ($query) use ($today) {
                $query->where('tgl_mulai', '<=', $today)
                    ->where('tgl_selesai', '>=', $today);
            })
            ->where('status', '=', 7)
            ->count('jml_hari');

        $cutiHariini = Cuti::where(function ($query) use ($today) {
                $query->where('tgl_mulai', '<=', $today)
                    ->where('tgl_selesai', '>=', $today);
            })
            ->where('status', '=', 7)
            ->whereHas('karyawans', function ($query) use ($row) {
                $query->where('partner', $row->partner);
            })
            ->count('jml_cuti');
             // Total
        $cutidanizin     = $dataIzinHariini + $cutiHariini;
        // Data Cuti dan Izin Bulan ini
        $dataIzinPerbulan   = Izin::whereYear('created_at', '=', Carbon::now()->year)
            ->whereMonth('tgl_mulai', '=', Carbon::now()->month)
            ->whereHas('karyawans', function ($query) use ($row) {
                $query->where('partner', $row->partner);
            })
            ->count('jml_hari');

        $cutiPerbulan       = Cuti::whereYear('created_at', '=', Carbon::now()->year)
            ->whereMonth('tgl_mulai', '=', Carbon::now()->month)
            ->whereHas('karyawans', function ($query) use ($row) {
                $query->where('partner', $row->partner);
            })
            ->count('jml_cuti');
             // Total
        $cutidanizinPerbulan    = $dataIzinPerbulan + $cutiPerbulan;
        // Data Cuti dan Izin Bulan Lalu
        $dataIzinbulanlalu   = Izin::whereYear('tgl_mulai', '=', Carbon::now()->year)
            ->whereMonth('tgl_mulai', '=', Carbon::now()->subMonth()->month)
            ->whereHas('karyawans', function ($query) use ($row) {
                $query->where('partner', $row->partner);
            })
            ->count('jml_hari');

        $cutibulanlalu       = Cuti::whereYear('tgl_mulai', '=', Carbon::now()->year)
            ->whereMonth('tgl_mulai', '=', Carbon::now()->subMonth()->month)
            ->whereHas('karyawans', function ($query) use ($row) {
                $query->where('partner', $row->partner);
            })
            ->count('jml_cuti');
            // Total
        $cutidanizibulanlalu    = $dataIzinbulanlalu + $cutibulanlalu;

        // Absen Hari Ini
        $absenHariini = Absensi::whereYear('tanggal', '=', Carbon::now()->year)
            ->whereMonth('tanggal', '=', Carbon::now()->month)
            ->whereDay('tanggal', '=', Carbon::now())
            ->where('partner',Auth::user()->partner)
            ->count('jam_masuk');
        $absenHarini = Absensi::with('karyawans')
            ->where('partner',Auth::user()->partner)
            ->whereYear('tanggal', '=', Carbon::now()->year)
            ->whereMonth('tanggal', '=', Carbon::now()->month)
            ->whereDay('tanggal', '=', Carbon::now())
            ->get();
        $jumAbsen = $absenHarini->count();

        // dd($absenHarini);
        // Absen Bulan Ini
        $absenBulanini  = Absensi::where('partner',Auth::user()->partner)
            ->whereYear('tanggal', '=', Carbon::now()->year)
            ->whereMonth('tanggal', '=', Carbon::now()->month)
            ->count('jam_masuk');
        // Absen Bulan Lalu
        $absenBulanlalu  = Absensi::where('partner',$row->partner)
            ->whereYear('tanggal', '=', Carbon::now()->subMonth()->year)
            ->whereMonth('tanggal', '=', Carbon::now()->subMonth()->month)
            ->count('jam_masuk');

        
        // Absen Terlambat Hari Ini
        $absenTerlambatHariIni = Absensi::whereYear('tanggal', '=', Carbon::now()->year)
            ->whereMonth('tanggal', '=', Carbon::now()->month)
            ->whereDay('tanggal', '=', Carbon::now())
            ->where('terlambat','!=', null)
            ->where('partner', $row->partner)
            ->count();
            // Absen Terlambat Bulan Ini
        $absenTerlambat = Absensi::whereYear('tanggal', '=', Carbon::now()->year)
            ->whereMonth('tanggal', '=', Carbon::now()->month)
            ->where('terlambat','!=', null)
            ->where('partner',$row->partner)
            ->count();
            // Absen Terlambat Bulan Lalu
        $absenTerlambatbulanlalu = Absensi::whereYear('tanggal', '=', Carbon::now()->subMonth()->year)
            ->whereMonth('tanggal', '=', Carbon::now()->subMonth()->month)
            ->where('partner',$row->partner)
            ->count('terlambat');

        // DATA KARYAWAN TIDAK MASUK



        //ambil jumlah Karyawan
        $totalKaryawan = Karyawan::where('partner',Auth::user()->partner)->count('id');

        // ambil jumlah karyawan yang sudah absen
        $totalabsen = DB::table('absensi')
                    ->where('partner',Auth::user()->partner)
                    ->whereYear('tanggal', '=', Carbon::now()->year)
                    ->whereMonth('tanggal', '=', Carbon::now()->month)
                    ->whereDay('tanggal', '=', Carbon::now())
                    ->count('id_karyawan');

        $totalTidakAbsenHariIni = $totalKaryawan - $totalabsen;
        $tidakMasukHariIni = Tidakmasuk::with('karyawans')
            ->whereYear('tanggal', '=', Carbon::now()->year)
            ->whereMonth('tanggal', '=', Carbon::now()->month)
            ->whereDay('tanggal', '=', Carbon::now())
            ->whereHas('karyawan', function ($query) use ($row) {
                $query->where('partner', $row->partner);
            })
            ->count('nama');
    
        // dd($totalKaryawan);
        $tidakMasukBulanIni = Tidakmasuk::with('karyawans')
            ->whereYear('tanggal', '=',Carbon::now()->year)
            ->whereMonth('tanggal', '=', Carbon::now()->month)
            ->whereHas('karyawan', function ($query) use ($row) {
                $query->where('partner', $row->partner);
            })
            ->count('nama');

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

        $absenBulanLalu = Absensi::where('partner',Auth::user()->partner)
        ->whereYear('tanggal', '=', Carbon::now()->year)
        ->whereMonth('tanggal', '=', Carbon::now()->subMonth()->month)
        ->where('partner',$row->partner)
        ->count('jam_masuk');

        //absen masuk bulan ini
        $absenBulanini  = Absensi::where('partner',Auth::user()->partner)
            ->whereYear('tanggal', '=', Carbon::now()->year)
            ->whereMonth('tanggal', '=', Carbon::now()->month)
            ->count('jam_masuk');

        $absenTerlambatbulanlalu = Absensi::whereYear('tanggal', '=', Carbon::now()->subMonth()->year)
        ->whereMonth('tanggal', '=', Carbon::now()->subMonth()->month)
        ->where('partner',$row->partner)
        ->count('terlambat');

        //Data alokasi cuti seljuruh karyawan
        $alokasicuti = Alokasicuti::where('id_karyawan', Auth::user()->id_pegawai)
            ->whereYear('aktif_dari', '=', Carbon::now()->year)
            ->whereYear('sampai', '=', Carbon::now()->year)
            ->where('status', '=', 1)
            ->get();
        $alokasi = Alokasicuti::where('id_karyawan', Auth::user()->id_pegawai)
            ->whereYear('aktif_dari', '=', Carbon::now()->year)
            ->whereYear('sampai', '=', Carbon::now()->year)
            ->where('status', '=', 1)
            ->where('id_jeniscuti','=',1)
            ->get();

        $currentDate = Carbon::now()->toDateString();

        $informasi = Informasi::where('partner', $row->partner)->whereRaw('? BETWEEN tanggal_aktif AND tanggal_berakhir', [$currentDate])->get();
        // return $informasi;
        $jmlinfo = $informasi->count();

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


        // Absen Terlambat Karyawan
        $absenTerlambatkaryawan = Absensi::where('id_karyawan', Auth::user()->id_pegawai)
            ->whereMonth('tanggal', '=', Carbon::now()->month)
            ->whereYear('tanggal', '=', Carbon::now()->year)
            ->where('partner',$row->partner)
            ->count('terlambat');
        //  dd($absenTerlambatkaryawan);
        // Absen Karyawan Hari Ini
        $absenKaryawan = Absensi::where('id_karyawan',Auth::user()->id_pegawai)
            ->whereDay('created_at', '=', Carbon::now())
            ->count('jam_masuk');

        // Absen Tidak Masuk
        $absenTidakmasuk = Absensi::where('id_karyawan',Auth::user()->id_pegawai)
            ->whereMonth('created_at', '=', Carbon::now()->month)
            ->count('jam_masuk');

        $tahun = Carbon::now()->year;

        $posisi = Lowongan::where('partner',Auth::user()->partner)->where('status', '=', 'Aktif')->get();

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
        $karyawan = Karyawan::groupBy('nama_jabatan')
            ->where('partner',Auth::user()->partner)
            ->select('nama_jabatan', DB::raw('count(*) as total'))
            ->get();
        $karyawan2 = Karyawan::where('partner',Auth::user()->partner)->get();
        $jumlahkaryawan = $karyawan2->count();

        $jabatan = ['Komisaris', 'Direksi', 'Manager'];
        $jumlahKaryawanPerJabatan = Karyawan::groupBy('nama_jabatan')
            ->whereIn('jabatan', $jabatan)
            ->where('partner',Auth::user()->partner)
            ->select('nama_jabatan', DB::raw('count(*) as total'))
            ->get();

        $jumlahKaryawanPerJabatan2 = Karyawan::whereIn('jabatan', $jabatan)
            ->where('partner',Auth::user()->partner)
            ->count();



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
                'cutiPerbulan' => $cutiPerbulan,
                'cutiHariini' => $cutiHariini,
                'absenHariini' => $absenHariini,
                'absenHarini' => $absenHarini,
                'jumAbsen' =>  $jumAbsen,
                'absenBulanini' => $absenBulanini,
                'absenBulanlalu' => $absenBulanlalu,
                'absenTerlambat' => $absenTerlambat,
                'absenTerlambatbulanlalu' => $absenTerlambatbulanlalu,
                'data' => $data,
                'labelBulan' => $labelBulan,
                'absenTerlambatHariIni' => $absenTerlambatHariIni,
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
                'absenBulanini' => $absenBulanini,
                'absenBulanlalu'=> $absenBulanlalu,
                'absenTerlambatbulanlalu'=> $absenTerlambatbulanlalu,
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
                // 'cekSisacuti' => $cekSisacuti,
            ];
            return view('karyawan.dashboardKaryawan', $output);

        } elseif ($role->role == 2) {

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
                'absenBulanini' => $absenBulanini,
                'absenBulanlalu'=> $absenBulanlalu,
                'absenTerlambatbulanlalu'=> $absenTerlambatbulanlalu,
                'data' => $data,
                'labelBulan' => $labelBulan,
                'absenTerlambatHariIni' => $absenTerlambatHariIni,
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
                'absenTerlambatHariIni' => $absenTerlambatHariIni,
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
                // 'cekSisacuti' => $cekSisacuti,
            ];
            return view('karyawan.dashboardKaryawan', $output);
        }
        elseif($role->role == 7)
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
                'absenTerlambatHariIni' => $absenTerlambatHariIni,
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
                // 'cekSisacuti' => $cekSisacuti,
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
                'absenTerlambatHariIni' => $absenTerlambatHariIni,
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
