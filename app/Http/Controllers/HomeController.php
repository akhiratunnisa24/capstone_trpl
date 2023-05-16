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
use App\Models\Tidakmasuk;
use App\Models\Alokasicuti;
use App\Models\Rekruitmen;
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
        $absenTerlambatkaryawan = Absensi::where('id_karyawan', Auth::user()->id_pegawai,)->count('terlambat');
        // Absen Karyawan Hari Ini
        $absenKaryawan = Absensi::where('id_karyawan', Auth::user()->id_pegawai)->whereDay('created_at', '=', Carbon::now(),)->count('jam_masuk');

        // Absen Tidak Masuk
        $absenTidakmasuk = Absensi::where('id_karyawan', Auth::user()->id_pegawai)->whereMonth('created_at', '=', Carbon::now()->month)->count('jam_masuk');

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
        $dataIzinHariini = Izin::where(function ($query) use ($today) {
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
            ->count('jml_cuti');
             // Total
        $cutidanizin     = $dataIzinHariini + $cutiHariini;
        // Data Cuti dan Izin Bulan ini 
        $dataIzinPerbulan   = Izin::whereYear('created_at', '=', Carbon::now()->year)
            ->whereMonth('tgl_mulai', '=', Carbon::now()->month)
            ->count('jml_hari');
        $cutiPerbulan       = Cuti::whereYear('created_at', '=', Carbon::now()->year)
            ->whereMonth('tgl_mulai', '=', Carbon::now()->month)
            ->count('jml_cuti');
             // Total
        $cutidanizinPerbulan    = $dataIzinPerbulan + $cutiPerbulan;
        // Data Cuti dan Izin Bulan Lalu
        $dataIzinbulanlalu   = Izin::whereYear('tgl_mulai', '=', Carbon::now()->year)
            ->whereMonth('tgl_mulai', '=', Carbon::now()->subMonth()->month)
            ->count('jml_hari');
        $cutibulanlalu       = Cuti::whereYear('tgl_mulai', '=', Carbon::now()->year)
            ->whereMonth('tgl_mulai', '=', Carbon::now()->subMonth()->month)
            ->count('jml_cuti');
            // Total
        $cutidanizibulanlalu    = $dataIzinbulanlalu + $cutibulanlalu;

        // Absen Hari Ini
        $absenHariini = Absensi::whereYear('tanggal', '=', Carbon::now()->year)
            ->whereMonth('tanggal', '=', Carbon::now()->month)
            ->whereDay('tanggal', '=', Carbon::now())->count('jam_masuk');
        // Absen Bulan Ini
        $absenBulanini  = Absensi::whereYear('tanggal', '=', Carbon::now()->year)
            ->whereMonth('tanggal', '=', Carbon::now()->month)
            ->count('jam_masuk');
        // Absen Bulan Lalu
        $absenBulanlalu  = Absensi::whereYear('tanggal', '=', Carbon::now()->subMonth()->year)
            ->whereMonth('tanggal', '=', Carbon::now()->subMonth()->month)
            ->count('jam_masuk');

        // Absen Terlambat Hari Ini
        $absenTerlambatHariIni = Absensi::whereYear('tanggal', '=', Carbon::now()->year)
            ->whereMonth('tanggal', '=', Carbon::now()->month)
            ->whereDay('tanggal', '=', Carbon::now())
            ->whereTime('jam_masuk', '>', '08:00:00')
            ->count();
            // Absen Terlambat Bulan Ini
        $absenTerlambat = Absensi::whereYear('tanggal', '=', Carbon::now()->year)
            ->whereMonth('tanggal', '=', Carbon::now()->month)
            ->whereTime('jam_masuk', '>', '08:00:00')
            ->count();
            // Absen Terlambat Bulan Lalu
        $absenTerlambatbulanlalu = Absensi::whereYear('tanggal', '=', Carbon::now()->subMonth()->year)
            ->whereMonth('tanggal', '=', Carbon::now()->subMonth()->month)
            ->count('terlambat');

        // DATA KARYAWAN TIDAK MASUK

        

        //ambil jumlah Karyawan       
        $totalKaryawan = karyawan::count('id');

        // ambil jumlah karyawan yang sudah absen
        $totalabsen = DB::table('absensi')
                    ->whereYear('tanggal', '=', Carbon::now()->year)
                    ->whereMonth('tanggal', '=', Carbon::now()->month)
                    ->whereDay('tanggal', '=', Carbon::now())
                    ->count('id_karyawan');

        $totalTidakAbsenHariIni = $totalKaryawan - $totalabsen ;
        $tidakMasukHariIni = Tidakmasuk::whereYear('tanggal', '=', Carbon::now()->year)
            ->whereMonth('tanggal', '=', Carbon::now()->month)
            ->whereDay('tanggal', '=', Carbon::now())
            ->count('nama');
        $tidakMasukBulanIni = Tidakmasuk::whereYear('tanggal', '=',Carbon::now()->year)
            ->whereMonth('tanggal', '=', Carbon::now()->month)
            ->count('nama');
    



        $today =Carbon::now(); //Current Date and Time
        $firstDayofMonth = Carbon::parse($today)->firstOfMonth();
        $lastDayofMonth = Carbon::parse($today)->endOfMonth();

        $to = Carbon::parse($today);
        $weekDay = $firstDayofMonth->diffInWeekdays($to);

        $getLabel = cuti::select(DB::raw("SUM(jml_cuti) as jumlah"), DB::raw("MONTHNAME(tgl_mulai) as month_name"), DB::raw("MONTH(tgl_mulai) as month_number"))
            ->whereYear('tgl_mulai', '=', Carbon::now()->year)
            ->where('status','=',7)
            ->groupBy(DB::raw('MONTHNAME(tgl_mulai)'),DB::raw("MONTH(tgl_mulai)"))
            ->orderBy(DB::raw("MONTH(tgl_mulai)"))
            ->pluck('jumlah', 'month_name');

        $labelBulan = $getLabel->keys();    
        // $labelTahun = $getYear->keys();    
        $data = $getLabel->values();

        $absenBulanLalu = Absensi::whereYear('tanggal', '=', Carbon::now()->year)
        ->whereMonth('tanggal', '=', Carbon::now()->subMonth()->month)
        ->count('jam_masuk');

        //absen masuk bulan ini    
        $absenBulanini  = Absensi::whereYear('tanggal', '=', Carbon::now()->year)
            ->whereMonth('tanggal', '=', Carbon::now()->month)
            ->count('jam_masuk');

        $absenTerlambatbulanlalu = Absensi::whereYear('tanggal', '=', Carbon::now()->subMonth()->year)
        ->whereMonth('tanggal', '=', Carbon::now()->subMonth()->month)
        ->count('terlambat');

        //Data alokasi cuti seljuruh karyawan
        $alokasicuti = Alokasicuti::where('id_karyawan', Auth::user()->id_pegawai)
            ->whereYear('aktif_dari', '=', Carbon::now()->year)
            ->whereYear('sampai', '=', Carbon::now()->year)
            ->where('status', '=', 1)
            ->get();

        //Data alokasi cuti seljuruh karyawan
        $alokasicuti2 = Alokasicuti::all();


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
            ->count('terlambat');
        //  dd($absenTerlambatkaryawan);
        // Absen Karyawan Hari Ini
        $absenKaryawan = Absensi::where('id_karyawan',Auth::user()->id_pegawai)
            ->whereDay('created_at', '=', Carbon::now(), )
            ->count('jam_masuk');

        // Absen Tidak Masuk
        $absenTidakmasuk = Absensi::where('id_karyawan',Auth::user()->id_pegawai)
            ->whereMonth('created_at', '=', Carbon::now()->month)
            ->count('jam_masuk');
        
        $tahun = Carbon::now()->year;

        $posisi = Lowongan::all()->where('status', '=', 'Aktif');

        if($role->role == 3 && $row->jabatan == "Manajer")
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
                            ->where('cuti.catatan', '=', NULL);
                    })
                    ->orWhere(function ($q) {
                        $q->whereIn('cuti.status', [1, 6])
                            ->where('karyawan.atasan_kedua', Auth::user()->id_pegawai)
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
                            ->where('karyawan.atasan_pertama', Auth::user()->id_pegawai);
                    })
                    ->orWhere(function ($q) {
                        $q->whereIn('cuti.catatan', ['Mengajukan Pembatalan', 'Mengajukan Perubahan', 'Pembatalan Disetujui Atasan', 'Perubahan Disetujui Atasan'])
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
                            ->where('karyawan.atasan_pertama', Auth::user()->id_pegawai)
                            ->where('izin.catatan', '=', NULL);
                    })
                    ->orWhere(function ($q) {
                        $q->whereIn('izin.status', [1, 6])
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
                            ->where('karyawan.atasan_pertama', Auth::user()->id_pegawai);
                    })
                    ->orWhere(function ($q) {
                        $q->whereIn('izin.catatan', ['Mengajukan Pembatalan', 'Mengajukan Perubahan', 'Pembatalan Disetujui Atasan', 'Perubahan Disetujui Atasan'])
                            ->where('karyawan.atasan_kedua', Auth::user()->id_pegawai);
                    });
                })
                ->get();
            $jumizin = $ijin->count();
        } 
        elseif($role->role == 1 && $row->jabatan == "Manajer")
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
                            ->where('karyawan.atasan_pertama', Auth::user()->id_pegawai);
                    })
                    ->orWhere(function ($q) {
                        $q->whereIn('cuti.status', [1, 6])
                            ->where('karyawan.atasan_kedua', Auth::user()->id_pegawai);
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
                            ->where('karyawan.atasan_pertama', Auth::user()->id_pegawai);
                    })
                    ->orWhere(function ($q) {
                        $q->whereIn('cuti.catatan', ['Mengajukan Pembatalan', 'Mengajukan Perubahan', 'Pembatalan Disetujui Atasan', 'Perubahan Disetujui Atasan'])
                            ->where('karyawan.atasan_kedua', Auth::user()->id_pegawai);
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
                            ->where('izin.catatan', '=', NULL);
                    })
                    ->orWhere(function ($q) {
                        $q->whereIn('izin.status', [1, 6])
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
                            ->where('karyawan.atasan_pertama', Auth::user()->id_pegawai);
                    })
                    ->orWhere(function ($q) {
                        $q->whereIn('izin.catatan', ['Mengajukan Pembatalan', 'Mengajukan Perubahan', 'Pembatalan Disetujui Atasan', 'Perubahan Disetujui Atasan'])
                            ->where('karyawan.atasan_kedua', Auth::user()->id_pegawai);
                    });
                })
                ->get();
            $jumizin = $ijin->count();

        } 
        elseif($role->role == 3 && $row->jabatan == "Asisten Manajer")
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
                    $query->where('karyawan.atasan_pertama', Auth::user()->id_pegawai)
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
                    $query->where('karyawan.atasan_pertama', Auth::user()->id_pegawai)
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
                    $query->where('karyawan.atasan_pertama', Auth::user()->id_pegawai)
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
                    $query->where('karyawan.atasan_pertama', Auth::user()->id_pegawai)
                        ->orWhere('karyawan.atasan_kedua', Auth::user()->id_pegawai);
                })
                ->whereIn('izin.catatan',['Mengajukan Pembatalan','Mengajukan Perubahan'])
                ->get();
            $jumizin = $ijin->count();
        }
        elseif($role->role == 1 && $row->jabatan == "Asisten Manajer")
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
                    $query->where('karyawan.atasan_pertama', Auth::user()->id_pegawai)
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
                        $query->where('karyawan.atasan_pertama', Auth::user()->id_pegawai)
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
                    $query->where('karyawan.atasan_pertama', Auth::user()->id_pegawai)
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
                    $query->where('karyawan.atasan_pertama', Auth::user()->id_pegawai)
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
                            ->where('karyawan.atasan_pertama', Auth::user()->id_pegawai)
                            ->where('cuti.catatan', '=', NULL);
                    })
                    ->orWhere(function ($q) {
                        $q->whereIn('cuti.status', [1, 6])
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
                            ->where('karyawan.atasan_pertama', Auth::user()->id_pegawai);
                    })
                    ->orWhere(function ($q) {
                        $q->whereIn('cuti.catatan', ['Mengajukan Pembatalan', 'Mengajukan Perubahan', 'Pembatalan Disetujui Atasan', 'Perubahan Disetujui Atasan'])
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
                            ->where('karyawan.atasan_pertama', Auth::user()->id_pegawai)
                            ->where('izin.catatan', '=', NULL);
                    })
                    ->orWhere(function ($q) {
                        $q->whereIn('izin.status', [1, 6])
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
                            ->where('karyawan.atasan_pertama', Auth::user()->id_pegawai);
                    })
                    ->orWhere(function ($q) {
                        $q->whereIn('izin.catatan', ['Mengajukan Pembatalan', 'Mengajukan Perubahan', 'Pembatalan Disetujui Atasan', 'Perubahan Disetujui Atasan'])
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
                        $query->where('karyawan.atasan_pertama', Auth::user()->id_pegawai)
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
                    $query->where('karyawan.atasan_pertama', Auth::user()->id_pegawai)
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
                    $query->where('karyawan.atasan_pertama', Auth::user()->id_pegawai)
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
                    $query->where('karyawan.atasan_pertama', Auth::user()->id_pegawai)
                        ->orWhere('karyawan.atasan_kedua', Auth::user()->id_pegawai);
                })
                ->whereIn('izin.catatan',['Mengajukan Pembatalan','Mengajukan Perubahan'])
                ->get();
            $jumizin = $ijin->count();
        }

        $resign = Resign::where('status', '!=', '7')
            ->where('status', '!=', '5')
            ->get();
        $resignjumlah = $resign->count();

        // $sisacutis = Sisacuti::with(['karyawans','jeniscutis'])->where('status',1)->get();
        $sisacutis = Sisacuti::with(['karyawans','jeniscutis'])
            ->where('status',1)
            ->where('sisa_cuti','>',0)
            ->whereDate('dari', '<=', Carbon::now())
            ->whereDate('sampai', '>=', Carbon::now())
            ->where('sisacuti.id_pegawai','=',Auth::user()->id_pegawai)->get();


        //NOTIFIKASI DATA TINDAKAN TERHADAPA KARYAWAN TIDAK MASUK
       
        $pct = Settingabsensi::where('sanksi_tidak_masuk', '=', 'Potong Uang Makan')->select('jumlah_tidakmasuk')->first();
        $potonguangmakan = Tidakmasuk::leftJoin('setting_absensi', 'tidakmasuk.status', '=', 'setting_absensi.status_tidakmasuk')
            ->leftJoin('karyawan', 'tidakmasuk.id_pegawai', '=', 'karyawan.id')
            ->where('tidakmasuk.status', '=', 'tanpa keterangan')
            ->select('tidakmasuk.id_pegawai as id_pegawai','tidakmasuk.status as keterangan','setting_absensi.jumlah_tidakmasuk as jumlah', 'setting_absensi.sanksi_tidak_masuk as sanksi', DB::raw('COUNT(tidakmasuk.id_pegawai) as total'))
            ->havingRaw('COUNT(tidakmasuk.id_pegawai) = CASE WHEN setting_absensi.sanksi_tidak_masuk = "Potong Uang Makan" THEN ' . $pct->jumlah_tidakmasuk . ' END')
            ->groupBy('setting_absensi.jumlah_tidakmasuk', 'setting_absensi.sanksi_tidak_masuk', 'tidakmasuk.id_pegawai','tidakmasuk.status')
            ->get();
        $jpc = $potonguangmakan->count();

        $pg = Settingabsensi::where('sanksi_tidak_masuk', '=', 'Potong Uang Transportasi')->select('jumlah_tidakmasuk')->first();
        $potongtransport = Tidakmasuk::leftJoin('setting_absensi', 'tidakmasuk.status', '=', 'setting_absensi.status_tidakmasuk')
            ->leftJoin('karyawan', 'tidakmasuk.id_pegawai', '=', 'karyawan.id')
            ->where('tidakmasuk.status', '=', 'tanpa keterangan')
            ->select('tidakmasuk.id_pegawai as id_pegawai', 'setting_absensi.jumlah_tidakmasuk as jumlah', 'setting_absensi.sanksi_tidak_masuk as sanksi', DB::raw('COUNT(tidakmasuk.id_pegawai) as total'))
            ->havingRaw('COUNT(tidakmasuk.id_pegawai) = CASE WHEN setting_absensi.sanksi_tidak_masuk = "Potong Uang Transportasi" THEN ' . $pg->jumlah_tidakmasuk . ' END')
            ->groupBy('setting_absensi.jumlah_tidakmasuk', 'setting_absensi.sanksi_tidak_masuk', 'tidakmasuk.id_pegawai')
            ->get();
        $jpg = $potongtransport->count();
         //data karyawan terlambat
         $tb = Settingabsensi::where('sanksi_terlambat', '=', 'Teguran Biasa')->select('jumlah_terlambat')->first();
         $sp1 = Settingabsensi::where('sanksi_terlambat', '=', 'SP Pertama')->select('jumlah_terlambat')->first();
         $sp2 = Settingabsensi::where('sanksi_terlambat', '=', 'SP Kedua')->select('jumlah_terlambat')->first();
         $sp3 = Settingabsensi::where('sanksi_terlambat', '=', 'SP Ketiga')->select('jumlah_terlambat')->first();
         $terlambat = Absensi::leftJoin('setting_absensi', 'absensi.terlambat', '>', 'setting_absensi.toleransi_terlambat')
             ->leftJoin('karyawan', 'absensi.id_karyawan', '=', 'karyawan.id')
             ->select('absensi.id_karyawan as id_karyawan','setting_absensi.jumlah_terlambat as jumlah', 'setting_absensi.sanksi_terlambat as sanksi', DB::raw('COUNT(absensi.id_karyawan) as total'))
             ->havingRaw('COUNT(absensi.id_karyawan) = CASE WHEN setting_absensi.sanksi_terlambat = "Teguran Biasa" THEN ' . $tb->jumlah_terlambat . ' END')
             ->whereYear('absensi.tanggal', '=', Carbon::now()->subMonth()->year)->whereMonth('absensi.tanggal', '=',Carbon::now()->subMonth()->month)
             ->groupBy('setting_absensi.jumlah_terlambat', 'setting_absensi.sanksi_terlambat', 'absensi.id_karyawan')
             ->get();
         $jumter = $terlambat->count();
         $telat = Absensi::leftJoin('setting_absensi', 'absensi.terlambat', '>', 'setting_absensi.toleransi_terlambat')
             ->leftJoin('karyawan', 'absensi.id_karyawan', '=', 'karyawan.id')
             ->select('absensi.id_karyawan as id_karyawan', 'setting_absensi.jumlah_terlambat as jumlah', 'setting_absensi.sanksi_terlambat as sanksi', DB::raw('COUNT(absensi.id_karyawan) as total'))
             ->havingRaw('COUNT(absensi.id_karyawan) = CASE WHEN setting_absensi.sanksi_terlambat = "SP Pertama" THEN ' . $sp1->jumlah_terlambat . ' END')
             ->whereYear('absensi.tanggal', '=', Carbon::now()->subMonth()->year)->whereMonth('absensi.tanggal', '=',Carbon::now()->subMonth()->month)
             ->groupBy('setting_absensi.jumlah_terlambat', 'setting_absensi.sanksi_terlambat', 'absensi.id_karyawan')
             ->get();
         $jumtel = $telat->count();
         $datatelat = Absensi::leftJoin('setting_absensi', 'absensi.terlambat', '>', 'setting_absensi.toleransi_terlambat')
             ->leftJoin('karyawan', 'absensi.id_karyawan', '=', 'karyawan.id')
             ->select('absensi.id_karyawan as id_karyawan', 'setting_absensi.jumlah_terlambat as jumlah', 'setting_absensi.sanksi_terlambat as sanksi', DB::raw('COUNT(absensi.id_karyawan) as total'))
             ->havingRaw('COUNT(absensi.id_karyawan) = CASE WHEN setting_absensi.sanksi_terlambat = "SP Pertama" THEN ' . $sp2->jumlah_terlambat . ' END')
             ->whereYear('absensi.tanggal', '=', Carbon::now()->subMonth()->year)->whereMonth('absensi.tanggal', '=',Carbon::now()->subMonth()->month)
             ->groupBy('setting_absensi.jumlah_terlambat', 'setting_absensi.sanksi_terlambat', 'absensi.id_karyawan')
             ->get();
         $jumdat = $datatelat->count();

        $rekruitmen = Lowongan::where('status','Aktif');
        $rekruitmenjumlah = $rekruitmen->count();
        // dd($potongcuti);

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

            ];
            return view('admin.karyawan.dashboardhrd', $output);

        } elseif ($role->role == 3 && $row->jabatan == "Asisten Manajer") {

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
                'sisacuti' => $sisacuti,
                'absenBulanini' => $absenBulanini,
                'absenBulanlalu'=> $absenBulanlalu,
                'absenTerlambatbulanlalu'=> $absenTerlambatbulanlalu,
                'sisacutis' => $sisacutis,
                'role' => $role,
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
        elseif($role->role == 3 && $row->jabatan == "Manajer")
        {

            $output = [
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
