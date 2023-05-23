<?php

namespace App\Http\Controllers\karyawan;


use PDF;
use Carbon\Carbon;
use App\Models\Cuti;
use App\Models\File;
use App\Models\Izin;
use App\Models\Role;
use App\Models\User;
use App\Models\Users;
use App\Models\Atasan;
use App\Models\Resign;
use App\Models\Status;
use App\Models\Absensi;
use App\Models\Jabatan;
use App\Models\Karyawan;
use App\Models\Kdarurat;
use App\Models\Keluarga;
use App\Models\Lowongan;
use App\Models\Sisacuti;
use App\Models\Rprestasi;
use App\Models\Departemen;
use App\Models\Rekruitmen;
use App\Models\Rpekerjaan;
use App\Models\Tidakmasuk;
use App\Models\Alokasicuti;
use App\Models\Rorganisasi;
use App\Models\Rpendidikan;
use Illuminate\Http\Request;
use App\Models\LevelJabatan ;
use App\Mail\CutiNotification;
use App\Models\Settingabsensi;
use App\Exports\KaryawanExport;
use App\Imports\karyawanImport;
use App\Events\AbsenKaryawanEvent;
use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class karyawanController extends Controller
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

    public function index(Request $request)
    {   
        $role = Auth::user()->role;
        if ($role == 1 || $role == 2) {

            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
            $karyawan = karyawan::all()->sortByDesc('created_at');

            $posisi = Lowongan::all()->where('status', '=', 'Aktif')->where('tgl_selesai', '<', Carbon::now());

            $query = $request->input('query');
            $results = Karyawan::where('nama', 'LIKE', '%' . $query . '%')->get();
            
            //ambil id_karyawan yang belum punya akun
            $user = DB::table('users')->pluck('id_pegawai');
            $akun = DB::table('karyawan')->whereNotIn("id", $user)->get();

            $role = Role::where('status','1')->get();

            $output = [
                'row' => $row,
                'query' => $query,
            ];
            return view('admin.karyawan.index', compact('karyawan', 'row', 'akun', 'query', 'results', 'posisi', 'role'));
        } else {

            return redirect()->back();
        }
    }


    // public function getEmail(Request $request)
    // {
    //     try {
    //         $getEmail = Karyawan::select('email')
    //         ->where('id','=',$request->id_karyawan)->first();

    //         // dd($request->id_karyawan,$getTglmasuk);
    //         if(!$getEmail) {
    //             throw new \Exception('Data not found');
    //         }
    //         return response()->json($getEmail,200);

    //     } catch (\Exception $e){
    //         return response()->json([
    //             'message' =>$e->getMessage()
    //         ], 500);
    //     }
    // }

    public function getEmail(Request $request)
    {
        try {
            $getEmail = Karyawan::select('email')
                ->where('id', '=', $request->id_pegawai)->first();

            if (!$getEmail) {
                throw new \Exception('Data not found');
            }
            return response()->json($getEmail, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getEmail2(Request $request)
    {
        try {
            $getEmail = Lowongan::select('persyaratan')
            ->where('id', '=', $request->id_pegawai)->first();

            if (!$getEmail) {
                throw new \Exception('Data not found');
            }
            return response()->json($getEmail, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getSisacuti(Request $request)
    {
        try {
            $year = Carbon::now()->subYear()->format('Y');
            $getSisacuti = Sisacuti::leftjoin('settingalokasi', 'sisacuti.jenis_cuti', '=', 'settingalokasi.id_jeniscuti')
                ->leftjoin('alokasicuti', 'sisacuti.jenis_cuti', '=', 'alokasicuti.id_jeniscuti')
                ->leftjoin('jeniscuti','sisacuti.jenis_cuti','=','jeniscuti.id')
                ->where('alokasicuti.id_jeniscuti','=',$request->id_jeniscuti)
                ->where('alokasicuti.id_karyawan','=',Auth::user()->id_pegawai)
                ->whereYear('alokasicuti.sampai',$year)
                ->where('sisacuti.id_pegawai','=',Auth::user()->id_pegawai)
                ->select('sisacuti.jenis_cuti as jenis_cuti','jeniscuti.jenis_cuti as jeniscutis','alokasicuti.id as id_alokasi', 'settingalokasi.id as id_settingalokasi', 'sisacuti.sisa_cuti','alokasicuti.id_karyawan')
                ->first();
           
            if(!$getSisacuti) {
                throw new \Exception('Data not found');
            }
            return response()->json($getSisacuti,200);
            
        } catch (\Exception $e){
            return response()->json([
                'message' =>$e->getMessage()
            ], 500);
        } 
    }

    public function storeSisacuti(Request $request)
    {
        $karyawan = Auth::user()->id_pegawai;
        $role = Auth::user()->role;
        $status = Status::find(1);

        $cuti = New Cuti;
        $cuti->id_karyawan = $karyawan;
        $cuti->id_jeniscuti= $request->id_jeniscutis;
        $cuti->id_alokasi  = $request->id_alokasi;
        $cuti->id_settingalokasi= $request->id_settingalokasi;
        $cuti->keperluan   = $request->keperluan;
        $cuti->tgl_mulai   = Carbon::parse($request->tgl_mulai)->format("Y-m-d");
        $cuti->tgl_selesai = Carbon::parse($request->tgl_selesai)->format("Y-m-d");
        $cuti->jml_cuti    = $request->jml_cuti;
        $cuti->status      = $status->id;

        // dd($cuti);
        $cuti->save();

        $emailkry = DB::table('cuti')->join('karyawan','cuti.id_karyawan','=','karyawan.id')
            ->where('cuti.id_karyawan','=',$cuti->id_karyawan)
            ->select('karyawan.email')
            ->first();

        //atasan pertama
        $idatasan = DB::table('karyawan')
            ->join('cuti','karyawan.id','=','cuti.id_karyawan')
            ->where('cuti.id_karyawan','=',$cuti->id_karyawan)
            ->select('karyawan.atasan_pertama as atasan_pertama')
            ->first();
        $atasan = Karyawan::where('id',$idatasan->atasan_pertama)
            ->select('email as email','nama as nama','nama_jabatan as jabatan')
            ->first();
        
        //atasan kedua
        $idatasan2 = DB::table('karyawan')
            ->join('cuti','karyawan.id','=','cuti.id_karyawan')
            ->where('cuti.id_karyawan','=',$cuti->id_karyawan)
            ->select('karyawan.atasan_kedua as atasan_kedua')
            ->first();
        $atasan2 = Karyawan::where('id',$idatasan2->atasan_kedua)
            ->select('email as email','nama as nama','nama_jabatan as jabatan')
            ->first();

        if ($atasan) {
            $tujuan = $atasan->email;
            $data = [
                'subject' => 'Pemberitahuan Permintaan '. $cuti->jeniscutis->jenis_cuti,
                'body' => 'Anda Memiliki 1 Permintaan Cuti yang harus di Approved',
                'id' => $cuti->id,
                'karyawan_email' =>  $emailkry->email,
                'id_jeniscuti' => $cuti->jeniscutis->jenis_cuti,
                'atasan2'     =>$atasan2->email,
                'keperluan' => $cuti->keperluan,
                'tgl_mulai' => Carbon::parse($cuti->tgl_mulai)->format("d M Y"),
                'tgl_selesai' => Carbon::parse($cuti->tgl_selesai)->format("d M Y"),
                'jml_cuti' => $cuti->jml_cuti,
                'status' => $cuti->status,
                'atasan_depar' => $atasan->jabatan,
                'nama_atasan' => $atasan->nama,
                'role' => $role,
                ];
            Mail::to($tujuan)->send(new CutiNotification($data));
        } else {
            // proses jika data atasan tidak ada / email tidak ada
        }

        return redirect()->back()
            ->with('success','Email Notifikasi Berhasil Dikirim');
    }

    public function karyawanDashboard()
    {
        $role = Auth::user()->role;
       
        if ($role == 2 or 3) 
        {
            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
            $absenKaryawan = Absensi::where('id_karyawan', Auth::user()->id_pegawai)
                ->whereDay('created_at', '=', Carbon::now(),)->count('jam_masuk');

            // Absen Terlambat untuk hari ini
            $absenTerlambatkaryawan = Absensi::where('id_karyawan', Auth::user()->id_pegawai)
                ->whereYear('tanggal', '=', Carbon::now()->year)
                ->whereMonth('tanggal', '=', Carbon::now()->month)
                ->whereTime('jam_masuk', '>', '08:00:00')
                ->count();

            //absen masuk bulan ini    
            $absenBulanini  = Absensi::where('id_karyawan', Auth::user()->id_pegawai)
                ->whereYear('tanggal', '=', Carbon::now()->year)
                ->whereMonth('tanggal', '=', Carbon::now()->month)
                ->count('jam_masuk');

            //absen masuk bulan lalu    
            $absenBulanlalu  = Absensi::where('id_karyawan', Auth::user()->id_pegawai)
                ->whereYear('tanggal', '=', Carbon::now()->subMonth()->year)
                ->whereMonth('tanggal', '=', Carbon::now()->subMonth()->month)
                ->count('jam_masuk');

            //absen terlambat bulan lalu
            $absenTerlambatbulanlalu = Absensi::where('id_karyawan', Auth::user()->id_pegawai)
                ->whereYear('tanggal', '=', Carbon::now()->subMonth()->year)
                ->whereMonth('tanggal', '=', Carbon::now()->subMonth()->month)
                ->count('terlambat');

            $absenTidakmasuk = Absensi::where('id_karyawan', Auth::user()->id_pegawai)
                ->whereDay('created_at', '=', Carbon::now(),)->count('jam_masuk');

            $alokasicuti = Alokasicuti::where('id_karyawan', Auth::user()->id_pegawai)
                ->whereYear('aktif_dari', '=', Carbon::now()->year)
                ->whereYear('sampai', '=', Carbon::now()->year)
                ->where('status', '=', 1)
                ->get();
                // return $alokasicuti;
            

            $sisacutis = Sisacuti::with(['karyawans','jeniscutis'])
                ->where('status',1)
                ->where('sisa_cuti','>',0)
                ->whereDate('dari', '<=', Carbon::now())
                ->whereDate('sampai', '>=', Carbon::now())
                ->where('sisacuti.id_pegawai','=',Auth::user()->id_pegawai)->get();
            

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

            $posisi = Lowongan::all()->sortByDesc('created_at');

            if($role == 3 && $row->jabatan == "Manager")
            {
                // $cuti = DB::table('cuti')
                    // ->leftjoin('alokasicuti', 'cuti.id_jeniscuti', 'alokasicuti.id_jeniscuti')
                    // ->leftjoin('settingalokasi', 'cuti.id_jeniscuti', 'settingalokasi.id_jeniscuti')
                    // ->leftjoin('jeniscuti', 'cuti.id_jeniscuti', 'jeniscuti.id')
                    // ->leftjoin('karyawan', 'cuti.id_karyawan', 'karyawan.id')
                    // ->leftjoin('statuses', 'cuti.status', '=', 'statuses.id')
                    // ->leftjoin('departemen','cuti.departemen','=','departemen.id')
                    // ->leftjoin('datareject', 'datareject.id_cuti', '=', 'cuti.id')
                    // ->select('cuti.*', 'jeniscuti.jenis_cuti', 'departemen.nama_departemen','karyawan.nama', 'statuses.name_status', 'karyawan.atasan_pertama', 'karyawan.atasan_kedua', 'datareject.alasan as alasan', 'datareject.id_cuti as id_cuti')
                    // ->distinct()
                    // ->where(function ($query) {
                    //     $query->where('karyawan.atasan_pertama', Auth::user()->id_pegawai)
                    //         ->orWhere('karyawan.atasan_kedua', Auth::user()->id_pegawai);
                    // })
                    // ->whereIn('cuti.status', [1, 6])
                    // ->where('cuti.catatan', '=', NULL)
                    // ->get();

                
                // $cutis = DB::table('cuti')
                //     ->leftJoin('alokasicuti', 'cuti.id_jeniscuti', 'alokasicuti.id_jeniscuti')
                //     ->leftJoin('settingalokasi', 'cuti.id_jeniscuti', 'settingalokasi.id_jeniscuti')
                //     ->leftJoin('jeniscuti', 'cuti.id_jeniscuti', 'jeniscuti.id')
                //     ->leftJoin('karyawan', 'cuti.id_karyawan', 'karyawan.id')
                //     ->leftJoin('statuses', 'cuti.status', '=', 'statuses.id')
                //     ->leftJoin('departemen', 'cuti.departemen', '=', 'departemen.id')
                //     ->leftJoin('datareject', 'datareject.id_cuti', '=', 'cuti.id')
                //     ->select('cuti.*', 'jeniscuti.jenis_cuti', 'departemen.nama_departemen', 'karyawan.nama', 'statuses.name_status', 'karyawan.atasan_pertama', 'karyawan.atasan_kedua', 'datareject.alasan as alasan', 'datareject.id_cuti as id_cuti')
                //     ->where(function ($query) {
                //         $query->where('karyawan.atasan_pertama', Auth::user()->id_pegawai)
                //             ->orWhere('karyawan.atasan_kedua', Auth::user()->id_pegawai);
                //     })
                //     ->whereIn('cuti.catatan', ['Mengajukan Pembatalan', 'Mengajukan Perubahan', 'Pembatalan Disetujui Atasan', 'Perubahan Disetujui Atasan'])
                //     ->distinct()
                //     ->get();
    
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
            elseif($role == 1 && $row->jabatan == "Manager")
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
            elseif($role == 3 && $row->jabatan == "Asistant Manager")
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
            elseif($role == 1 && $row->jabatan == "Asistant Manager")
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
            elseif($role == 3 && $row->jabatan == "Direksi")
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
           
            // return $row->jabatan;
            // // dd($cutijumlah);
            // return $role;

            $resign = Resign::orderBy('created_at', 'desc')->get();
            $resignjumlah = $resign->count();
            $rekruitmen = Rekruitmen::orderBy('created_at', 'desc')->get();
            $rekruitmenjumlah = $rekruitmen->count();

            $output = [
                'row' => $row,
                'absenKaryawan' => $absenKaryawan,
                'absenTerlambatkaryawan' => $absenTerlambatkaryawan,
                'absenTidakmasuk' => $absenTidakmasuk,
                'alokasicuti' => $alokasicuti,
                'absenBulanini' => $absenBulanini,
                'absenBulanlalu' => $absenBulanlalu,
                'absenTerlambatbulanlalu' => $absenTerlambatbulanlalu,
                'cuti' => $cuti,
                'cutijumlah' => $cutijumlah,
                'cutis' => $cutis,
                'jumct' => $jumct,
                'izin' => $izin,
                'izinjumlah' => $izinjumlah,
                'ijin' =>$ijin,
                'jumizin' =>$jumizin,
                'resign' => $resign,
                'resignjumlah' => $resignjumlah,
                'posisi' => $posisi,
                'sisacutis' =>$sisacutis,
                'rekruitmenjumlah' => $rekruitmenjumlah,

            ];
            return view('karyawan.dashboardKaryawan', $output);

        }elseif($role == 4){
            // return $role;
            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();

            $absenKaryawan = Absensi::where('id_karyawan', Auth::user()->id_pegawai)
                ->whereDay('created_at', '=', Carbon::now(),)->count('jam_masuk');

            // Absen Terlambat untuk hari ini
            $absenTerlambatkaryawan = Absensi::where('id_karyawan', Auth::user()->id_pegawai)
                ->whereYear('tanggal', '=', Carbon::now()->year)
                ->whereMonth('tanggal', '=', Carbon::now()->month)
                ->whereTime('jam_masuk', '>', '08:00:00')
                ->count();

            //absen masuk bulan ini    
            $absenBulanini  = Absensi::where('id_karyawan', Auth::user()->id_pegawai)
                ->whereYear('tanggal', '=', Carbon::now()->year)
                ->whereMonth('tanggal', '=', Carbon::now()->month)
                ->count('jam_masuk');

            //absen masuk bulan lalu    
            $absenBulanlalu  = Absensi::where('id_karyawan', Auth::user()->id_pegawai)
                ->whereYear('tanggal', '=', Carbon::now()->subMonth()->year)
                ->whereMonth('tanggal', '=', Carbon::now()->subMonth()->month)
                ->count('jam_masuk');

            //absen terlambat bulan lalu
            $absenTerlambatbulanlalu = Absensi::where('id_karyawan', Auth::user()->id_pegawai)
                ->whereYear('tanggal', '=', Carbon::now()->subMonth()->year)
                ->whereMonth('tanggal', '=', Carbon::now()->subMonth()->month)
                ->count('terlambat');

            $absenTidakmasuk = Absensi::where('id_karyawan', Auth::user()->id_pegawai)
                ->whereDay('created_at', '=', Carbon::now(),)->count('jam_masuk');

            $alokasicuti = Alokasicuti::where('id_karyawan', Auth::user()->id_pegawai)
                ->whereYear('aktif_dari', '=', Carbon::now()->year)
                ->whereYear('sampai', '=', Carbon::now()->year)
                ->where('status', '=', 1)
                ->get();
                // return $alokasicuti;

            // $sisacutis = Sisacuti::with(['karyawans','jeniscutis'])
            //     ->where('status',1)
            //     ->where('sisa_cuti','>',0)
            //     ->orWhere('sampai',Carbon::now())
            //     ->where('sisacuti.id_pegawai','=',Auth::user()->id_pegawai)->get();
            $sisacutis = Sisacuti::with(['karyawans','jeniscutis'])
                ->where('status',1)
                ->where('sisa_cuti','>',0)
                ->whereDate('dari', '<=', Carbon::now())
                ->whereDate('sampai', '>=', Carbon::now())
                ->where('sisacuti.id_pegawai','=',Auth::user()->id_pegawai)->get();
          

            $posisi = Lowongan::all()->sortByDesc('created_at');
            $resign = Resign::orderBy('created_at', 'desc')->get();
            $resignjumlah = $resign->count();
            $rekruitmen = Rekruitmen::orderBy('created_at', 'desc')->get();
            $rekruitmenjumlah = $rekruitmen->count();

            $output = [
                'row' => $row,
                'absenKaryawan' => $absenKaryawan,
                'absenTerlambatkaryawan' => $absenTerlambatkaryawan,
                'absenTidakmasuk' => $absenTidakmasuk,
                'alokasicuti' => $alokasicuti,
                'absenBulanini' => $absenBulanini,
                'absenBulanlalu' => $absenBulanlalu,
                'absenTerlambatbulanlalu' => $absenTerlambatbulanlalu,
                'resign' => $resign,
                'resignjumlah' => $resignjumlah,
                'posisi' => $posisi,
                'sisacutis' =>$sisacutis,
                'rekruitmenjumlah' => $rekruitmenjumlah,

            ];
            return view('karyawan.dashboardKaryawan', $output);
        }
        else {

            return redirect()->back();
        }
    }

    public function create()
    {
        $role = Auth::user()->role;

        if ($role == 1) {

            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
            $departemen     = Departemen::all();
            $atasan_pertama = Karyawan::whereIn('jabatan', ['Asistant Manager', 'Manager','Direksi'])->get();
            $atasan_kedua   = Karyawan::whereIn('jabatan', ['Manager','Direksi'])->get();

            $output = [
                'row' => $row,
                'departemen' => $departemen,
                'atasan_pertama' => $atasan_pertama,
                'atasan_kedua' => $atasan_kedua,
            ];
            return view('admin.karyawan.create', $output);
        } else {

            return redirect()->back();
        }
    }

    public function store_page(Request $request)
    {
        if ($request->hasfile('foto')) {

            $fileFoto = $request->file('foto');
            $namaFile = '' . time() . $fileFoto->getClientOriginalName();
            $tujuan_upload = 'Foto_Profile';
            $fileFoto->move($tujuan_upload, $namaFile);

            $maxId = Karyawan::max('id');

            $user = new Karyawan;
            $user->nama = $request->namaKaryawan;
            $user->tgllahir = $request->tgllahirKaryawan;
            $user->jenis_kelamin = $request->jenis_kelaminKaryawan;
            $user->alamat = $request->alamatKaryawan;
            $user->no_hp = $request->no_hpKaryawan;
            $user->email = $request->emailKaryawan;
            $user->agama = $request->agamaKaryawan;
            $user->nik = $request->nikKaryawan;
            $user->gol_darah = $request->gol_darahKaryawan;
            
            $user->foto = $namaFile;
            
            $user->jabatan = $request->jabatanKaryawan;
            $user->tglmasuk = $request->tglmasukKaryawan;
            $user->atasan_pertama = $request->atasan_pertama;
            $user->atasan_kedua = $request->atasan_kedua;
            $user->status_karyawan = $request->status_karyawan;
            $user->tipe_karyawan = $request->tipe_karyawan;
            $user->no_kk = $request->no_kk;
            $user->status_kerja = $request->status_kerja;
            $user->cuti_tahunan = $request->cuti_tahunan;
            $user->divisi = $request->divisi;
            $user->no_rek = $request->no_rek;
            $user->no_bpjs_kes = $request->no_bpjs_ket;
            $user->no_npwp = $request->no_npwp;
            $user->no_bpjs_ket = $request->no_bpjs_ket;
            $user->kontrak = $request->kontrak;
            $user->gaji = $request->gaji;
            $user->tglkeluar = $request->tglkeluar;
            $user->status_kerja = 'Aktif';
            $user->save();

            // $profile = new Kdarurat();
            // $profile->id_pegawai = $user->id;
            // $profile->nama = $request->namaKdarurat;
            // $profile->alamat = $request->alamatKdarurat;
            // $profile->no_hp = $request->no_hpKdarurat;
            // $profile->hubungan = $request->hubunganKdarurat;
            // $profile->save();


            $data = array(
                'nama' => $request->post('namaKaryawan'),
                'tgllahir' => $request->post('tgllahirKaryawan'),
                'jenis_kelamin' => $request->post('jenis_kelaminKaryawan'),
                'alamat' => $request->post('alamatKaryawan'),
                'no_hp' => $request->post('no_hpKaryawan'),
                'email' => $request->post('emailKaryawan'),
                'agama' => $request->post('agamaKaryawan'),
                'nik' => $request->post('nikKaryawan'),
                'gol_darah' => $request->post('gol_darahKaryawan'),
                'foto' => $namaFile,
                'jabatan' => $request->post('jabatanKaryawan'),
                'tglmasuk' => $request->post('tglmasukKaryawan'),
                'atasan_pertama' => $request->post('atasan_pertama'),
                'atasan_kedua' => $request->post('atasan_kedua'),
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),


                'status_karyawan' => $request->post('status_karyawan'),
                'tipe_karyawan' => $request->post('tipe_karyawan'),
                'no_kk' => $request->post('no_kk'),
                'status_kerja' => $request->post('status_kerja'),
                'cuti_tahunan' => $request->post('cuti_tahunan'),
                'divisi' => $request->post('divisi'),
                'no_rek' => $request->post('no_rek'),
                'no_bpjs_kes' => $request->post('no_bpjs_kes'),
                'no_npwp' => $request->post('no_npwp'),
                'no_bpjs_ket' => $request->post('no_bpjs_ket'),
                'kontrak' => $request->post('kontrak'),
                'gaji' => $request->post('gaji'),

                'tglkeluar' => $request->post('tglkeluar'),
            );


            $data_keluarga = array(
                'id_pegawai' => $user->id,
                // 'id_pegawai' => $maxId + 1,
                'status_pernikahan' => $request->post('status_pernikahan'),

                'nama' => $request->post('namaPasangan'),
                'tgllahir' => $request->post('tgllahirPasangan'),
                'alamat' => $request->post('alamatPasangan'),
                'pendidikan_terakhir' => $request->post('pendidikan_terakhirPasangan'),
                'pekerjaan' => $request->post('pekerjaanPasangan'),



                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),

            );

            $r_pendidikan = array(
                'id_pegawai' => $user->id,
                // 'id_pegawai' => $maxId + 1,

                'tingkat' => $request->post('tingkat_pendidikan'),
                'nama_sekolah' => $request->post('nama_sekolah'),
                'kota_pformal' => $request->post('kotaPendidikanFormal'),
                'kota_pformal' => $request->post('kotaPendidikanFormal'),
                'jurusan' => $request->post('jurusan'),
                'tahun_lulus_formal' => Carbon::parse($request->post('tahun_lulusFormal'))->format('Y'),

                'jenis_pendidikan' => $request->post('jenis_pendidikan'),
                'kota_pnonformal' => $request->post('kotaPendidikanNonFormal'),
                'tahun_lulus_nonformal' => Carbon::parse($request->post('tahunLulusNonFormal'))->format('Y'),

                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),

            );

            // dd( $r_pendidikan);

            $r_pekerjaan = array(
                'id_pegawai' => $user->id,
                // 'id_pegawai' => $maxId + 1,

                'nama_perusahaan' => $request->post('namaPerusahaan'),
                'alamat' => $request->post('alamatPerusahaan'),
                'jenis_usaha' => $request->post('jenisUsaha'),
                'jabatan' => $request->post('jabatanRpkerejaan'),
                'nama_atasan' => $request->post('namaAtasan'),
                'nama_direktur' => $request->post('namaDirektur'),
                'lama_kerja' => $request->post('lamaKerja'),
                'alasan_berhenti' => $request->post('alasanBerhenti'),
                'gaji' => $request->post('gajiRpekerjaan'),

                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),

            );

            $data_kdarurat = array(
                'id_pegawai' => $user->id,
                // 'id_pegawai' => $maxId + 1,

                'nama' => $request->post('namaKdarurat'),
                'alamat' => $request->post('alamatKdarurat'),
                'no_hp' => $request->post('no_hpKdarurat'),
                'hubungan' => $request->post('hubunganKdarurat'),
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),

            );

            // Karyawan::insert($data);
            Keluarga::insert($data_keluarga);
            Kdarurat::insert($data_kdarurat);
            Rpendidikan::insert($r_pendidikan);
            Rpekerjaan::insert($r_pekerjaan);

            return redirect('karyawan');
        } else {


            $maxId = Karyawan::max('id');
            $maxId + 1;

            $user = new Karyawan;
            $user->nama = $request->namaKaryawan;
            $user->tgllahir = $request->tgllahirKaryawan;
            $user->jenis_kelamin = $request->jenis_kelaminKaryawan; 
            $user->alamat = $request->alamatKaryawan;
            $user->no_hp = $request->no_hpKaryawan;
            $user->email = $request->emailKaryawan;
            $user->agama = $request->agamaKaryawan;
            $user->nik = $request->nikKaryawan;
            $user->gol_darah = $request->gol_darahKaryawan;
            $user->jabatan = $request->jabatanKaryawan;
            $user->tglmasuk = $request->tglmasukKaryawan;
            $user->atasan_pertama = $request->atasan_pertama;
            $user->atasan_kedua = $request->atasan_kedua;
            $user->status_karyawan = $request->status_karyawan;
            $user->tipe_karyawan = $request->tipe_karyawan;
            $user->no_kk = $request->no_kk;
            $user->status_kerja = $request->status_kerja;
            $user->cuti_tahunan = $request->cuti_tahunan;
            $user->divisi = $request->divisi;
            $user->no_rek = $request->no_rek;
            $user->no_bpjs_kes = $request->no_bpjs_ket;
            $user->no_npwp = $request->no_npwp;
            $user->no_bpjs_ket = $request->no_bpjs_ket;
            $user->kontrak = $request->kontrak;
            $user->gaji = $request->gaji;
            $user->tglkeluar = $request->tglkeluar;
            $user->save();

            $data = array(
                'nama' => $request->post('namaKaryawan'),
                'tgllahir' => $request->post('tgllahirKaryawan'),
                'jenis_kelamin' => $request->post('jenis_kelaminKaryawan'),
                'alamat' => $request->post('alamatKaryawan'),
                'no_hp' => $request->post('no_hpKaryawan'),
                'email' => $request->post('emailKaryawan'),
                'agama' => $request->post('agamaKaryawan'),
                'nik' => $request->post('nikKaryawan'),
                'gol_darah' => $request->post('gol_darahKaryawan'),
                'jabatan' => $request->post('jabatanKaryawan'),
                'tglmasuk' => $request->post('tglmasukKaryawan'),
                'atasan_pertama' => $request->post('atasan_pertama'),
                'atasan_kedua' => $request->post('atasan_kedua'),
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),


                'status_karyawan' => $request->post('status_karyawan'),
                'tipe_karyawan' => $request->post('tipe_karyawan'),
                'no_kk' => $request->post('no_kk'),
                'status_kerja' => $request->post('status_kerja'),
                'cuti_tahunan' => $request->post('cuti_tahunan'),
                'divisi' => $request->post('divisi'),
                'no_rek' => $request->post('no_rek'),
                'no_bpjs_kes' => $request->post('no_bpjs_kes'),
                'no_npwp' => $request->post('no_npwp'),
                'no_bpjs_ket' => $request->post('no_bpjs_ket'),
                'kontrak' => $request->post('kontrak'),

                'gaji' => $request->post('gaji'),
                'tglkeluar' => $request->post('tglkeluar'),
            );

            $data_keluarga = array(
                'id_pegawai' => $maxId + 1,

                'status_pernikahan' => $request->post('status_pernikahan'),

                'nama' => $request->post('namaPasangan'),
                'tgllahir' => $request->post('tgllahirPasangan'),
                'alamat' => $request->post('alamatPasangan'),
                'pendidikan_terakhir' => $request->post('pendidikan_terakhirPasangan'),
                'pekerjaan' => $request->post('pekerjaanPasangan'),


                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),

            );

            $r_pendidikan = array(
                // 'id_pegawai' => $maxId + 1,
                'id_pegawai' => $user->id,

                'tingkat' => $request->post('tingkat_pendidikan'),
                'nama_sekolah' => $request->post('nama_sekolah'),
                'kota_pformal' => $request->post('kotaPendidikanFormal'),
                'jurusan' => $request->post('jurusan'),
                'tahun_lulus_formal' => $request->post('tahun_lulusFormal'),

                'jenis_pendidikan' => $request->post('jenis_pendidikan'),
                'kota_pnonformal' => $request->post('kotaPendidikanNonFormal'),
                'tahun_lulus_nonformal' => $request->post('tahunLulusNonFormal'),

                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),
            );

            $r_pekerjaan = array(
                // 'id_pegawai' => $maxId + 1,
                'id_pegawai' => $user->id,


                'nama_perusahaan' => $request->post('namaPerusahaan'),
                'alamat' => $request->post('alamatPerusahaan'),
                'jenis_usaha' => $request->post('jenisUsaha'),
                'jabatan' => $request->post('jabatanRpkerejaan'),
                'nama_atasan' => $request->post('namaAtasan'),
                'nama_direktur' => $request->post('namaDirektur'),
                'lama_kerja' => $request->post('lamaKerja'),
                'alasan_berhenti' => $request->post('alasanBerhenti'),
                'gaji' => $request->post('gajiRpekerjaan'),

                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),

            );

            $data_kdarurat = array(
                // 'id_pegawai' => $maxId + 1,
                'id_pegawai' => $user->id,


                'nama' => $request->post('namaKdarurat'),
                'alamat' => $request->post('alamatKdarurat'),
                'no_hp' => $request->post('no_hpKdarurat'),
                'hubungan' => $request->post('hubunganKdarurat'),
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),
            );

            
            // Karyawan::insert($data);
            Keluarga::insert($data_keluarga);
            Kdarurat::insert($data_kdarurat);
            Rpendidikan::insert($r_pendidikan);
            Rpekerjaan::insert($r_pekerjaan);

            return redirect('karyawan');
        }
    }

    public function edit($id)
    {
        $role = Auth::user()->role;

        if ($role == 1) {

            $karyawan       = Karyawan::findOrFail($id);
            $keluarga       = Keluarga::where('id_pegawai', $id)->first();
            $kdarurat       = Kdarurat::where('id_pegawai', $id)->first();
            $rpendidikan    = Rpendidikan::where('id_pegawai', $id)->first();
            $rpekerjaan     = Rpekerjaan::where('id_pegawai', $id)->first();
            $row            = Karyawan::where('id', Auth::user()->id_pegawai)->first();
            $departemen     = Departemen::all();
            $atasan_pertama = Atasan::whereIn('level_jabatan', ['Asistant Manager', 'Manager','Direksi'])->get();
            $atasan_kedua   = Atasan::whereIn('level_jabatan', ['Manager','Direksi'])->get();

            $output = [
                'row' => $row
            ];

            // dd($atasan_pertama, $atasan_kedua);
            return view('admin.karyawan.edit', $output)->with([
                'karyawan'   => $karyawan,
                'keluarga'   => $keluarga,
                'kdarurat'   => $kdarurat,
                'rpendidikan'=> $rpendidikan,
                'rpekerjaan' => $rpekerjaan,
                'departemen' =>$departemen,
                'atasan_pertama'=> $atasan_pertama,
                'atasan_kedua'  => $atasan_kedua,
            ]);
        } else {

            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        $karyawan = Karyawan::find($id);
        $maxId = Karyawan::max('id');
        $maxId + 1;
        $request->validate(['foto' => 'image|mimes:jpeg,png,jpg|max:2048']);

        $fotoLama = $karyawan->foto;

        if ($file = $request->file('foto')) 
        {
            // hapus foto lama dari storage
            if($fotoLama !== null){
                $oldImage = public_path('Foto_Profile/'.$fotoLama);
                if(file_exists($oldImage)){
                    unlink($oldImage);
                }
            }

            $extension = $file->getClientOriginalExtension();
            $filename = '' . time() . $file->getClientOriginalName();
            $file->move(public_path() . '\Foto_Profile', $filename);
            $karyawan->foto = $filename;

            $karyawan->save();

            // return redirect()->back();


            $data = array(

                'nama' => $request->post('namaKaryawan'),
                'tgllahir' => $request->post('tgllahirKaryawan'),
                'jenis_kelamin' => $request->post('jenis_kelaminKaryawan'),
                'alamat' => $request->post('alamatKaryawan'),
                'no_hp' => $request->post('no_hpKaryawan'),
                'email' => $request->post('emailKaryawan'),
                'agama' => $request->post('agamaKaryawan'),
                'nik' => $request->post('nikKaryawan'),
                'gol_darah' => $request->post('gol_darahKaryawan'),
                'jabatan' => $request->post('jabatanKaryawan'),
                'divisi'=>$request->post('divisi'),
                'atasan_pertama'=>$request->post('atasan_pertama'),
                'atasan_kedua'=>$request->post('atasan_kedua'),
                'updated_at' => new \DateTime(),
                'foto' => $filename,
            );

            $data_keluarga = array(
                // 'id_pegawai' => $maxId + 1 , 

                'status_pernikahan' => $request->post('status_pernikahan'),

                'nama' => $request->post('namaPasangan'),
                'tgllahir' => $request->post('tgllahirPasangan'),
                'alamat' => $request->post('alamatPasangan'),
                'pendidikan_terakhir' => $request->post('pendidikan_terakhirPasangan'),
                'pekerjaan' => $request->post('pekerjaanPasangan'),


                // 'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),

            );

            $r_pendidikan = array(
                // 'id_pegawai' => $maxId + 1 ,

                'tingkat' => $request->post('tingkat_pendidikan'),
                'nama_sekolah' => $request->post('nama_sekolah'),
                'kota_pformal' => $request->post('kotaPendidikanFormal'),
                'jurusan' => $request->post('jurusan'),
                'tahun_lulus_formal' => $request->post('tahun_lulusFormal'),

                'jenis_pendidikan' => $request->post('jenis_pendidikan'),
                'kota_pnonformal' => $request->post('kotaPendidikanNonFormal'),
                'tahun_lulus_nonformal' => $request->post('tahunLulusNonFormal'),

                // 'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),

            );

            $r_pekerjaan = array(
                // 'id_pegawai' => $maxId + 1 ,

                'nama_perusahaan' => $request->post('namaPerusahaan'),
                'alamat' => $request->post('alamatPerusahaan'),
                'jenis_usaha' => $request->post('jenisUsaha'),
                'jabatan' => $request->post('jabatan'),
                'nama_atasan' => $request->post('namaAtasan'),
                'nama_direktur' => $request->post('namaDirektur'),
                'lama_kerja' => $request->post('lamaKerja'),
                'alasan_berhenti' => $request->post('alasanBerhenti'),
                'gaji' => $request->post('gajiRpekerjaan'),

                // 'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),

            );

            $data_kdarurat = array(
                // 'id_pegawai' => $maxId + 1 ,

                'nama' => $request->post('namaKdarurat'),
                'alamat' => $request->post('alamatKdarurat'),
                'no_hp' => $request->post('no_hpKdarurat'),
                'hubungan' => $request->post('hubunganKdarurat'),

            );
            $idKaryawan = $request->post('id_karyawan');
            $idPendidikan = $request->post('id_pendidikan');
            $idKeluarga = $request->post('id_keluarga');
            $idPekerjaan = $request->post('id_pekerjaan');
            $id_kdarurat = $request->post('id_kdarurat');

            Karyawan::where('id', $idKaryawan)->update($data);
            Keluarga::where('id', $idKeluarga)->update($data_keluarga);
            Rpendidikan::where('id', $idPendidikan)->update($r_pendidikan);
            Rpekerjaan::where('id', $idPekerjaan)->update($r_pekerjaan);
            Kdarurat::where('id', $id_kdarurat)->update($data_kdarurat);

            return redirect('karyawan')->with("sukses", "berhasil diubah");
        } else {

            $data = array(

                'nama' => $request->post('namaKaryawan'),
                'tgllahir' => $request->post('tgllahirKaryawan'),
                'jenis_kelamin' => $request->post('jenis_kelaminKaryawan'),
                'alamat' => $request->post('alamatKaryawan'),
                'no_hp' => $request->post('no_hpKaryawan'),
                'email' => $request->post('emailKaryawan'),
                'agama' => $request->post('agamaKaryawan'),
                'nik' => $request->post('nikKaryawan'),
                'gol_darah' => $request->post('gol_darahKaryawan'),
                'jabatan' => $request->post('jabatanKaryawan'),
                'divisi'=>$request->post('divisi'),
                'atasan_pertama'=>$request->post('atasan_pertama'),
                'atasan_kedua'=>$request->post('atasan_kedua'),
                // 'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),
            );
            // dd($data);

            $data_keluarga = array(
                // 'id_pegawai' => $maxId + 1 , 

                'status_pernikahan' => $request->post('status_pernikahan'),

                'nama' => $request->post('namaPasangan'),
                'tgllahir' => $request->post('tgllahirPasangan'),
                'alamat' => $request->post('alamatPasangan'),
                'pendidikan_terakhir' => $request->post('pendidikan_terakhirPasangan'),
                'pekerjaan' => $request->post('pekerjaanPasangan'),


                // 'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),

            );

            $r_pendidikan = array(
                // 'id_pegawai' => $maxId + 1 ,

                'tingkat' => $request->post('tingkat_pendidikan'),
                'nama_sekolah' => $request->post('nama_sekolah'),
                'kota_pformal' => $request->post('kotaPendidikanFormal'),
                'jurusan' => $request->post('jurusan'),
                'tahun_lulus_formal' => $request->post('tahun_lulus_formal'),

                'jenis_pendidikan' => $request->post('jenis_pendidikan'),
                'kota_pnonformal' => $request->post('kotaPendidikanNonFormal'),
                'tahun_lulus_nonformal' => $request->post('tahunLulusNonFormal'),

                // 'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),

            );

            $r_pekerjaan = array(
                // 'id_pegawai' => $maxId + 1 ,

                'nama_perusahaan' => $request->post('namaPerusahaan'),
                'alamat' => $request->post('alamatPerusahaan'),
                'jenis_usaha' => $request->post('jenisUsaha'),
                'jabatan' => $request->post('jabatan'),
                'nama_atasan' => $request->post('namaAtasan'),
                'nama_direktur' => $request->post('namaDirektur'),
                'lama_kerja' => $request->post('lamaKerja'),
                'alasan_berhenti' => $request->post('alasanBerhenti'),
                'gaji' => $request->post('gajiRpekerjaan'),

                // 'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),

            );

            $data_kdarurat = array(
                'nama' => $request->post('namaKdarurat'),
                'alamat' => $request->post('alamatKdarurat'),
                'no_hp' => $request->post('no_hpKdarurat'),
                'hubungan' => $request->post('hubunganKdarurat'),

            );
            $idKaryawan = $request->post('id_karyawan');
            $idPendidikan = $request->post('id_pendidikan');
            $idKeluarga = $request->post('id_keluarga');
            $idPekerjaan = $request->post('id_pekerjaan');
            $id_kdarurat = $request->post('id_kdarurat');

            //update ke tabel cuti
            
            Karyawan::where('id', $idKaryawan)->update($data);
            Keluarga::where('id', $idKeluarga)->update($data_keluarga);
            Rpendidikan::where('id', $idPendidikan)->update($r_pendidikan);
            Rpekerjaan::where('id', $idPekerjaan)->update($r_pekerjaan);
            Kdarurat::where('id', $id_kdarurat)->update($data_kdarurat);

            return redirect('karyawan')->with("sukses", "berhasil diubah");
        }
    }

    public function show($id)
    {
        $role = Auth::user()->role;

        if ($role == 1) {

            $karyawan = karyawan::findOrFail($id);
            // Memuat nama atasan pertama dan atasan kedua
            $status = Keluarga::where('id_pegawai', $id)->first();
            $keluarga = Keluarga::where('id_pegawai', $id)->get();
            $kdarurat = Kdarurat::where('id_pegawai', $id)->get();
            $rpendidikan = Rpendidikan::where('id_pegawai', $id)->get();
            $nonformal = Rpendidikan::where('id_pegawai',$id)->where('jenis_pendidikan','!=',null)->get();
            $rpekerjaan = Rpekerjaan::where('id_pegawai', $id)->get();
            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();

            $departemen     = Departemen::all();
            $atasan_pertama = Karyawan::whereIn('jabatan', ['Asistant Manager', 'Manager','Direksi'])->get();
            $atasan_kedua   = Karyawan::whereIn('jabatan', ['Manager','Direksi'])->get();

            $output = [
                'row' => $row
            ];

            return view('admin.karyawan.show', $output)->with([
                'karyawan' => $karyawan,
                'keluarga' => $keluarga,
                'kdarurat' => $kdarurat,
                'rpendidikan' => $rpendidikan,
                'rpekerjaan' => $rpekerjaan,
                'status' =>$status,
                'nonformal' =>$nonformal,
                'departemen' =>$departemen,
                'atasan_pertama'=>$atasan_pertama,
                'atasan_kedua'=>$atasan_kedua,
            ]);
        } else {

            return redirect()->back();
        }
    }

    // show identitas terbaru
    public function showidentitas($id)
    {
        $role = Auth::user()->role;

        if ($role == 1 || $role == 2) {

            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();

            $karyawan = karyawan::findOrFail($id);
            $departemen     = Departemen::all();
            $atasan_pertama = Karyawan::whereIn('jabatan', ['Asistant Manager', 'Manager', 'Direksi'])->get();
            $atasan_kedua   = Karyawan::whereIn('jabatan', ['Manager', 'Direksi'])->get();
            $leveljabatan = LevelJabatan::all();
            $namajabatan = Jabatan::all();
            
            $output = [
                'row' => $row,
                'karyawan' => $karyawan,
                'departemen' => $departemen,
                'atasan_pertama' => $atasan_pertama,
                'atasan_kedua' => $atasan_kedua,
                'leveljabatan' => $leveljabatan,
                'namajabatan' => $namajabatan,
            ];

            return view('admin.karyawan.showIdentitas', $output);
        } else {

            return redirect()->back();
        }
    }

    // Edit identitas terbaru

    public function editidentitas($id)
    {
        $role = Auth::user()->role;

        if ($role == 1 || $role == 2) {

            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();

            $karyawan       = Karyawan::findOrFail($id);
            $departemen     = Departemen::all();
            $atasan_pertama = Karyawan::whereIn('jabatan', ['Asistant Manager', 'Manager', 'Direksi'])->get();
            $atasan_kedua   = Karyawan::whereIn('jabatan', ['Manager', 'Direksi'])->get();
            $leveljabatan = LevelJabatan::all();
            $namajabatan = Jabatan::all();

            $output = [
                'row' => $row,
                'karyawan'   => $karyawan,
                'departemen' => $departemen,
                'atasan_pertama' => $atasan_pertama,
                'atasan_kedua'  => $atasan_kedua,
                'leveljabatan' => $leveljabatan,
                'namajabatan' => $namajabatan,
            ];

            return view('admin.karyawan.updateIdentitas', $output);
        } else {

            return redirect()->back();
        }
    }

    public function updateidentitas(Request $request, $id)
    {
        $karyawan = Karyawan::find($id);
        $request->validate(['foto' => 'image|mimes:jpeg,png,jpg|max:2048']);
        $fotoLama = $karyawan->foto;

        if ($file = $request->file('foto')) {
            // hapus foto lama dari storage
            if ($fotoLama !== null) {
                $oldImage = public_path('Foto_Profile/' . $fotoLama);
                if (file_exists($oldImage)) {
                    unlink($oldImage);
                }
            }

            $filename = '' . time() . $file->getClientOriginalName();
            $file->move(public_path() . '/Foto_Profile', $filename);
            $karyawan->foto = $filename;

            $karyawan->save();

            // return redirect()->back();


            $data = array(

                'foto' => $filename,
                'nip' => $request->post('nipKaryawan'),
                'nama' => $request->post('namaKaryawan'),
                'tgllahir' => \Carbon\Carbon::createFromFormat('d/m/Y', $request->tgllahirKaryawan)->format('Y-m-d'),
                'tempatlahir' => $request->post('tempatlahirKaryawan'),
                'jenis_kelamin' => $request->post('jenis_kelaminKaryawan'),
                'divisi' => $request->post('divisi'),
                'atasan_pertama' => $request->post('atasan_pertama'),
                'atasan_kedua' => $request->post('atasan_kedua'),
                'nama_jabatan' => $request->post('namaJabatan'),
                'jabatan' => $request->post('jabatanKaryawan'),
                'status_karyawan' => $request->post('statusKaryawan'),
                'gol_darah' => $request->post('gol_darahKaryawan'),
                'alamat' => $request->post('alamatKaryawan'),
                'status_pernikahan' => $request->post('status_pernikahan'),
                'jumlah_anak' => $request->post('jumlahAnak'),
                'no_hp' => $request->post('no_hpKaryawan'),
                'email' => $request->post('emailKaryawan'),
                'agama' => $request->post('agamaKaryawan'),
                'tglmasuk' => \Carbon\Carbon::createFromFormat('d/m/Y', $request->tglmasukKaryawan)->format('Y-m-d'),
                'nik' => $request->post('nikKaryawan'),
                'no_kk' => $request->post('nokkKaryawan'),
                'no_npwp' => $request->post('nonpwpKaryawan'),
                'no_bpjs_ket' => $request->post('nobpjskerKaryawan'),
                'no_bpjs_kes' => $request->post('nobpjskesKaryawan'),
                'no_akdhk' => $request->post('noAkdhk'),
                'no_program_pensiun' => $request->post('noprogramPensiun'),
                'no_program_askes' => $request->post('noprogramAskes'),
                'nama_bank' => $request->post('nama_bank'),
                'no_rek' => $request->post('norekKaryawan'),
                'updated_at' => new \DateTime(),
            );

            // $idKaryawan = $request->post('id_karyawan');

            Karyawan::where('id', $id)->update($data);

            // Mengambil nama jabatan baru
            $namaJabatanBaru = $request->post('namaJabatan');
            // Mengambil data jabatan dari tabel jabatan
            $jabatan = Jabatan::where('nama_jabatan', $namaJabatanBaru)->first();
            if ($jabatan) {
                // Update tabel alokasicuti
                AlokasiCuti::where('id_karyawan', $id)->update(['jabatan' => $namaJabatanBaru]);
            
                // Update tabel atasan
                Atasan::where('id_karyawan', $id)->update(['jabatan' => $namaJabatanBaru]);
            
                // Update tabel cuti
                Cuti::where('id_karyawan', $id)->update(['jabatan' => $namaJabatanBaru]);
            
                // Update tabel izin
                Izin::where('id_karyawan', $id)->update(['jabatan' => $namaJabatanBaru]);
            }
            
            return redirect()->back();
        } else {

            $data = array(

                'nip' => $request->post('nipKaryawan'),
                'nama' => $request->post('namaKaryawan'),
                // 'tgllahir' => $request->post('tgllahirKaryawan'),
                'tgllahir' => \Carbon\Carbon::createFromFormat('d/m/Y', $request->tgllahirKaryawan)->format('Y-m-d'),

                'tempatlahir' => $request->post('tempatlahirKaryawan'),
                'jenis_kelamin' => $request->post('jenis_kelaminKaryawan'),
                'divisi' => $request->post('divisi'),
                'atasan_pertama' => $request->post('atasan_pertama'),
                'atasan_kedua' => $request->post('atasan_kedua'),
                'nama_jabatan' => $request->post('namaJabatan'),
                'jabatan' => $request->post('jabatanKaryawan'),
                'status_karyawan' => $request->post('statusKaryawan'),
                'gol_darah' => $request->post('gol_darahKaryawan'),
                'alamat' => $request->post('alamatKaryawan'),
                'status_pernikahan' => $request->post('status_pernikahan'),
                'jumlah_anak' => $request->post('jumlahAnak'),
                'no_hp' => $request->post('no_hpKaryawan'),
                'email' => $request->post('emailKaryawan'),
                'agama' => $request->post('agamaKaryawan'),
                'tglmasuk' => \Carbon\Carbon::createFromFormat('d/m/Y', $request->tglmasukKaryawan)->format('Y-m-d'),
                'nik' => $request->post('nikKaryawan'),
                'no_kk' => $request->post('nokkKaryawan'),
                'no_npwp' => $request->post('nonpwpKaryawan'),
                'no_bpjs_ket' => $request->post('nobpjskerKaryawan'),
                'no_bpjs_kes' => $request->post('nobpjskesKaryawan'),
                'no_akdhk' => $request->post('noAkdhk'),
                'no_program_pensiun' => $request->post('noprogramPensiun'),
                'no_program_askes' => $request->post('noprogramAskes'),
                'nama_bank' => $request->post('nama_bank'),
                'no_rek' => $request->post('norekKaryawan'),
                'updated_at' => new \DateTime(),
            );

            // $idKaryawan = $request->post('id_karyawan');

            Karyawan::where('id', $id)->update($data);

            // Mengambil nama jabatan baru
            $namaJabatanBaru = $request->post('namaJabatan');
            // Mengambil data jabatan dari tabel jabatan
            $jabatan = Jabatan::where('nama_jabatan', $namaJabatanBaru)->first();
            if ($jabatan) {
                // Update tabel alokasicuti
                AlokasiCuti::where('id_karyawan', $id)->update(['jabatan' => $namaJabatanBaru]);
            
                // Update tabel atasan
                Atasan::where('id_karyawan', $id)->update(['jabatan' => $namaJabatanBaru]);
            
                // Update tabel cuti
                Cuti::where('id_karyawan', $id)->update(['jabatan' => $namaJabatanBaru]);
            
                // Update tabel izin
                Izin::where('id_karyawan', $id)->update(['jabatan' => $namaJabatanBaru]);
            }

            return redirect()->back();
        }
    }

    public function showpendidikan($id)
    {
        $role = Auth::user()->role;

        if ($role == 1 || $role == 2) {

            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
            $no = 1;
            $no2 = 1;
            $karyawan = karyawan::findOrFail($id);
            $pendidikan = Rpendidikan::where('id_pegawai', $id)->get();
            $nonformal = Rpendidikan::where('id_pegawai', $id)->where('jenis_pendidikan', '!=', null)->get();
            // where('id_pegawai', $id)

            $output = [
                'row' => $row,
                'no' => $no,
                'no2' => $no2,
                'karyawan' => $karyawan,
                'pendidikan' => $pendidikan,
                'nonformal' => $nonformal,
            ];

            return view('admin.karyawan.showPendidikan', $output);
        } else {

            return redirect()->back();
        }
    }
    public function addpformal(Request $request, $id)
    {
        $idk = Karyawan::findorFail($id);
        if ($request->tingkat_pendidikan) {
            $r_pendidikan = array(
                'id_pegawai' => $idk->id,
                'tingkat' => $request->post('tingkat_pendidikan'),
                'nama_sekolah' => $request->post('nama_sekolah'),
                'kota_pformal' => $request->post('kotaPendidikanFormal'),
                'jurusan' => $request->post('jurusan'),
                'tahun_masuk_formal'       => \Carbon\Carbon::createFromFormat('d/m/Y', $request->tahun_masukFormal)->format('Y-m-d'),
                'tahun_lulus_formal' => \Carbon\Carbon::createFromFormat('d/m/Y', $request->post('tahun_lulusFormal'))->format('Y-m-d'),
                
                // 'tahun_lulus_formal'       => \Carbon\Carbon::createFromFormat('d/m/Y', $request->tahun_lulusFormal)->format('Y-m-d'),

                'ijazah_formal' => $request->post('noijazahPformal'),

                'jenis_pendidikan' => null,
                'kota_pnonformal' => null,
                'tahun_lulus_nonformal' => null,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),
            );

            Rpendidikan::insert($r_pendidikan);
            return redirect()->back()->withInput();
        } else {
            $r_pendidikan = array(
                'id_pegawai' => $idk->id,
                'tingkat' => null,
                'nama_sekolah' => null,
                'kota_pformal' => null,
                'jurusan' => null,
                'tahun_lulus_formal' => null,


                'nama_lembaga' => $request->post('namaLembaga'),
                'jenis_pendidikan' => $request->post('jenis_pendidikan'),
                'kota_pnonformal' => $request->post('kotaPendidikanNonFormal'),

                'tahun_masuk_nonformal' => \Carbon\Carbon::createFromFormat('d/m/Y', $request->tahun_masukNonFormal)->format('Y-m-d'),
                'tahun_lulus_nonformal' => \Carbon\Carbon::createFromFormat('d/m/Y', $request->post('tahun_lulusNonFormal'))->format('Y-m-d'),
                
                // 'tahun_lulus_nonformal' => $request->post('tahunLulusNonFormal'),
                'ijazah_nonformal' => $request->post('noijazahPnonformal'),
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),
            );

            Rpendidikan::insert($r_pendidikan);
            return redirect()->back()->withInput();
        }
    }

    public function destroyPendidikan(Request $request, $id)
    {
        // $rpendidikan = Rpendidikan::where('id_pegawai', $id)->find($id);
        //     dd($rpendidikan);
        Rpendidikan::destroy($id);

        // $rpendidikan->delete();

        return redirect()->back();
    }

    public function showpekerjaan($id)
    {
        $role = Auth::user()->role;

        if ($role == 1 || $role == 2) {

            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();

            $karyawan = karyawan::findOrFail($id);
            $pekerjaan= Rpekerjaan::where('id_pegawai', $id)->get();
            // where('id_pegawai', $id)

            $output = [
                'row' => $row,
                'karyawan' => $karyawan,
                'pekerjaan' => $pekerjaan,
            ];

            return view('admin.karyawan.showPekerjaan', $output);
        } else {

            return redirect()->back();
        }
    }
    public function destroyPekerjaan($id)
    {
        Rpekerjaan::destroy($id);

        return redirect()->back();
    }

    public function showorganisasi($id)
    {
        $role = Auth::user()->role;

        if ($role == 1 || $role == 2) {

            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();

            $karyawan = karyawan::findOrFail($id);
            $organisasi = Rorganisasi::where('id_pegawai', $id)->get();
            // where('id_pegawai', $id)

            $output = [
                'row' => $row,
                'karyawan' => $karyawan,
                'organisasi' => $organisasi,
            ];

            return view('admin.karyawan.showOrganisasi', $output);
        } else {

            return redirect()->back();
        }
    }
    public function destroyOrganisasi(Request $request, $id)
    {
        Rorganisasi::destroy($id);

        return redirect()->back();
    }

    public function showprestasi($id)
    {
        $role = Auth::user()->role;

        if ($role == 1 || $role == 2) {

            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();

            $karyawan = karyawan::findOrFail($id);
            $prestasi = Rprestasi::where('id_pegawai', $id)->get();
            // where('id_pegawai', $id)

            $output = [
                'row' => $row,
                'karyawan' => $karyawan,
                'prestasi' => $prestasi,
            ];

            return view('admin.karyawan.showPrestasi', $output);
        } else {

            return redirect()->back();
        }
    }
    public function destroyPrestasi(Request $request, $id)
    {
        Rprestasi::destroy($id);

        return redirect()->back();
    }
    public function showkeluarga($id)
    {
        $role = Auth::user()->role;

        if ($role == 1 || $role == 2) {

            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();

            $karyawan = karyawan::findOrFail($id);
            $keluarga = Keluarga::where( 'id_pegawai' , $id )->get();
            // where('id_pegawai', $id)

            $output = [
                'row' => $row,
                'karyawan' => $karyawan,
                'keluarga' => $keluarga,
            ];

            return view('admin.karyawan.showKeluarga', $output);
        } else {

            return redirect()->back();
        }
    }
    public function destroyKeluarga($id)
    {
        Keluarga::destroy($id);

        return redirect()->back();
    }
    public function showkontakdarurat($id)
    {
        $role = Auth::user()->role;

        if ($role == 1 || $role == 2) {

            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();

            $karyawan = karyawan::findOrFail($id);
            $kontakdarurat = Kdarurat::where('id_pegawai', $id)->get();
            // where('id_pegawai', $id)

            $output = [
                'row' => $row,
                'karyawan' => $karyawan,
                'kontakdarurat' => $kontakdarurat,
            ];

            return view('admin.karyawan.showKontakdarurat', $output);
        } else {

            return redirect()->back();
        }
    }
    public function destroyKonrat($id)
    {
        Kdarurat::destroy($id);

        return redirect()->back();
    }

    

    // show 1 page non aktif
    public function showkaryawan($id)
    {
        $karyawan = karyawan::findOrFail($id);
        $atasan_pertama_nama = $karyawan->atasan_pertamaa->nama;
        $atasan_kedua_nama = $karyawan->atasan_kedua;
        if(!$atasan_kedua_nama){
            $atasan_kedua_nama = "-";
        }else
        {
            $atasan_kedua_nama = $karyawan->atasan_keduab->nama;
        }
       
        $keluarga = Keluarga::where('id_pegawai', $id)->get();
        $kdarurat = Kdarurat::where('id_pegawai', $id)->get();
        $rpendidikan = Rpendidikan::where('id_pegawai', $id)->get();
        $pendidikan = Rpendidikan::where('id_pegawai', $id)->get();
        $rpekerjaan = Rpekerjaan::where('id_pegawai', $id)->get();
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();

        $jumkaryawan = $keluarga->count();

        return view('karyawan.showKaryawan')->with([
            'karyawan' => $karyawan,
            'keluarga' => $keluarga,
            'kdarurat' => $kdarurat,
            'rpendidikan' => $rpendidikan,
            'pendidikan' => $pendidikan,
            'rpekerjaan' => $rpekerjaan,
            'atasan_pertama_nama'=> $atasan_pertama_nama,
            'atasan_kedua_nama'=>$atasan_kedua_nama,
            'row' => $row
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $karyawan = Karyawan::find($id);
        $karyawan->keluarga()->delete();
        $karyawan->kdarurat()->delete();
        $karyawan->rpekerjaan()->delete();
        $karyawan->rpendidikan()->delete();
        $karyawan->rorganisasi()->delete();
        $karyawan->rprestasi()->delete();
        $karyawan->tidakmasuk()->delete();
        $karyawan->user2()->delete();
        $karyawan->delete();

        return redirect()->back();
    }

    public function editPassword(Request $data, $id)
    {
        $karyawan = Karyawan::findOrFail($id);
        $user = User::where('id_pegawai', $id)->first();
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();

        $output = [
            'row' => $row
        ];

        return view('auth.changePassword', $output)->with([
            'karyawan' => $karyawan,
            'password' => Hash::make($data['password']),
        ]);
    }

    public function updatePassword(Request $request)
    {
        # Validation
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed', 'min:8',
        ]);

        #Match The Old Password
        if (!Hash::check($request->old_password, auth()->user()->password)) {
            return back()->with("error", "Old Password Doesn't match!");
        }

        #Update the new Password
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with("status", "Password changed successfully!");
    }

    public function importexcel(Request $request)
    {
        Excel::import(new karyawanImport, request()->file('file'));
        return redirect()->back();
    }

    public function exportExcel()
    {
        return Excel::download(new KaryawanExport, 'data_karyawan.xlsx');
    }

    public function showKaryawanCuti()
    {
        $role = Auth::user()->role;

        if ($role == 1 || $role == 2) {

            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();

            // $izin = Izin::with('karyawan','statuses')
            //     ->whereYear('tgl_mulai', '=', Carbon::now()->year)
            //     ->whereMonth('tgl_mulai', '=', Carbon::now()->month)
            //     ->whereDay('tgl_mulai', '=', Carbon::now())
            //     ->where('status','=',7)
            //     ->get();

            // $cuti = Cuti::with('karyawan', 'jeniscuti')
            //     ->whereYear('tgl_mulai', '=', Carbon::now()->year)
            //     ->whereMonth('tgl_mulai', '=', Carbon::now()->month)
            //     ->whereDay('tgl_mulai', '=', Carbon::now())
            //     ->get();
            $today = Carbon::now()->format('Y-m-d');

            $izin = Izin::where(function ($query) use ($today) {
                    $query->where('tgl_mulai', '<=', $today)
                    ->where('tgl_selesai', '>=', $today);
                })
                ->where('status', '=', 7)
                ->get();

            $cuti = Cuti::where(function ($query) use ($today) {
                    $query->where('tgl_mulai', '<=', $today)
                        ->where('tgl_selesai', '>=', $today);
                })
                ->where('status', '=', 7)
                ->get();

            $izinBulanIni = Izin::with('karyawan','statuses')
                ->whereYear('tgl_mulai', '=', Carbon::now()->year)
                ->whereMonth('tgl_mulai', '=', Carbon::now()->month)
                ->where('status','=',7)
                ->get();

            $cutiBulanIni = Cuti::with('karyawan', 'jeniscuti')
                ->whereYear('tgl_mulai', '=', Carbon::now()->year)
                ->whereMonth('tgl_mulai', '=', Carbon::now()->month)
                ->where('status','=',7)
                ->get();

            $izinBulanLalu = Izin::with('karyawan','statuses')
                ->whereYear('tgl_mulai', '=', Carbon::now()->year)
                ->whereMonth('tgl_mulai', '=', Carbon::now()->subMonth()->month)
                ->get();

            $cutiBulanLalu = Cuti::with('karyawan', 'jeniscuti')
            ->whereYear('tgl_mulai', '=', Carbon::now()->year)
            ->whereMonth('tgl_mulai', '=', Carbon::now()->subMonth()->month)
            ->get();

            $output = [
                'row' => $row,
            ];
            return view('admin.karyawan.showKaryawanCuti', compact('izin', 'row', 'cuti', 'izinBulanIni', 'cutiBulanIni', 'izinBulanLalu', 'cutiBulanLalu'));
        } else {

            return redirect()->back();
        }
    }

    public function showkaryawanabsen()
    {
        $role = Auth::user()->role;

        if ($role == 1 || $role == 2) {

            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();


            $absen = Absensi::with('karyawan',)
            ->whereYear('tanggal', '=', Carbon::now()->year)
                ->whereMonth('tanggal', '=', Carbon::now()->month)
                ->whereDay('tanggal', '=', Carbon::now())
                ->get();

            $absenBulanIni = Absensi::with('karyawan')
            ->whereYear('tanggal', '=', Carbon::now()->year)
                ->whereMonth('tanggal', '=', Carbon::now()->month)
                ->get();

            $absenBulanLalu = Absensi::with('karyawan',)
            ->whereYear('tanggal', '=', Carbon::now()->year)
            ->whereMonth('tanggal', '=', Carbon::now()->subMonth()->month)
            ->get();

            $output = [
                'row' => $row,
            ];
            return view('admin.karyawan.showKaryawanAbsen', compact('absen', 'row', 'absenBulanIni', 'absenBulanLalu'));
        } else {

            return redirect()->back();
        }
    }

    public function showkaryawanterlambat()
    {
        $role = Auth::user()->role;

        if ($role == 1 || $role == 2) {

            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();

            $terlambat = Absensi::with('karyawan',)
            ->whereYear('tanggal', '=', Carbon::now()->year)
                ->whereMonth('tanggal', '=', Carbon::now()->month)
                ->whereDay('tanggal', '=', Carbon::now())
                ->whereTime('jam_masuk', '>', '08:00:00')
                ->get();

            $terlambatBulanIni = Absensi::with('karyawan')
            ->whereYear('tanggal', '=', Carbon::now()->year)
                ->whereMonth('tanggal', '=', Carbon::now()->month)
                ->whereTime('jam_masuk', '>', '08:00:00')
                ->get();

            $terlambatBulanLalu = Absensi::with('karyawan',)
            ->whereYear('tanggal', '=', Carbon::now()->year)
                ->whereMonth('tanggal', '=', Carbon::now()->subMonth()->month)
                ->whereTime('jam_masuk', '>', '08:00:00')
                ->get();

            $output = [
                'row' => $row,
            ];
            return view('admin.karyawan.showKaryawanTerlambat', compact('terlambat', 'row', 'terlambatBulanIni', 'terlambatBulanLalu'));
        } else {

            return redirect()->back();
        }
    }

    public function showkaryawantidakmasuk()
    {
        $role = Auth::user()->role;

        //ambil id_karyawan yang udah absen
        

        if ($role == 1 || $role == 2) {
 
            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();

            // $karyawanSudahAbsen = DB::table('absensi')->pluck('id_karyawan');
            // $karyawanBelumAbsen = Karyawan::with('departemen')
            // ->whereYear('tanggal', '=', Carbon::now()->year)
            // ->whereMonth('tanggal', '=', Carbon::now()->month)
            // ->whereDay('tanggal', '=', Carbon::now())
            // ->whereNotIn('id', $karyawanSudahAbsen)
            // ->get();

            $tidakMasuk = Tidakmasuk::whereYear('tanggal', '=', Carbon::now()->year)
                ->whereMonth('tanggal', '=', Carbon::now()->month)
                ->whereDay('tanggal', '=', Carbon::now())
                ->get();
            // dd($tidakMasuk);

            $tidakMasukBulanIni = Tidakmasuk::whereYear('tanggal', '=', Carbon::now()->year)
                ->whereMonth('tanggal', '=', Carbon::now()->month)
                ->get();
            // dd($tidakMasukBulanIni);

            $tidakMasukBulanLalu = Tidakmasuk::whereYear('tanggal', '=', Carbon::now()->year)
                ->whereMonth('tanggal', '=', Carbon::now()->subMonth()->month)
                ->get();
            
            // dd($tidakMasukBulanLalu);

            $output = [
                'row' => $row,
            ];
            return view('admin.karyawan.showKaryawanTidakMasuk', compact('tidakMasuk', 'row', 'tidakMasukBulanIni', 'tidakMasukBulanLalu'));
        } else {

            return redirect()->back();
        }
    }
    public function downloadpdf(Request $request, $id)
    {
            $data = karyawan::findOrFail($id);
            $pendidikan = Rpendidikan::where('id_pegawai', $id)->get();
            $pekerjaan = Rpekerjaan::where('id_pegawai', $id)->get();
            $organisasi = Rorganisasi::where('id_pegawai', $id)->get();
            $prestasi = Rprestasi::where('id_pegawai', $id)->get();
            $keluarga = Keluarga::where('id_pegawai', $id)->get();
            $kontakdarurat = Kdarurat::where('id_pegawai', $id)->get();

            $pdf = PDF::loadview('admin.karyawan.downloadpdf', [
                'data' => $data,
                'pendidikan' => $pendidikan,
                'pekerjaan' => $pekerjaan,
                'organisasi' => $organisasi,
                'prestasi' => $prestasi,
                'keluarga' => $keluarga,
                'kontakdarurat' => $kontakdarurat,
                
                ])
            ->setPaper('a4', 'landscape');
            return $pdf->stream("Data Karyawan "  . $data->nama . ".pdf");
    }
    public function showfile($id)
    {
        $role = Auth::user()->role;

        if ($role == 1 || $role == 2) {

            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();

            $karyawan = karyawan::findOrFail($id);
            $file = File::where('id_pegawai', $id)->first();

            $output = [
                'row' => $row,
                'karyawan' => $karyawan,
                'file' => $file,
            ];

            return view('admin.karyawan.showFile', $output);
        } else {

            return redirect()->back();
        }
    }
    public function editfile($id)
    {
        $role = Auth::user()->role;

        if ($role == 1 || $role == 2) {

            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();

            $karyawan = Karyawan::findOrFail($id);
            $file = File::where('id_pegawai', $id)->first();

            $output = [
                'row' => $row,
                'karyawan'   => $karyawan,
                'file'   => $file,
            ];

            return view('admin.karyawan.editUpload', $output);
        } else {

            return redirect()->back();
        }
    }
    public function updatefile(Request $request, $id)
    {
        $karyawan = Karyawan::find($id);
        $digital = File::where('id_pegawai', $id)->first();

        $ktpLama = $digital->ktp;
        if ($file = $request->file('fotoKTP')
        ){
            // hapus KTP lama dari storage
            if($ktpLama !== null){
                $ktp = public_path('File_KTP/'. $ktpLama);
                if(file_exists($ktp)){
                    unlink($ktp);
                }
            }

            $namaKtp = 'KTP-' . time() . '-' . $file->getClientOriginalName();
            $file->move(public_path() . '\File_KTP', $namaKtp );
            $digital->ktp = $namaKtp;
            // $digital->save();
        }
        

        // $kkLama = $digital->kk;
        if ($file = $request->file('fotoKK')) {
            // hapus KK lama dari storage
            // if ($kkLama !== null) {
            //     $kk = public_path('File_KK/' . $kkLama);
            //     if (file_exists($kk)) {
            //         unlink($kk);
            //     }
            // }

            $namaKK = 'KK-' . time() . '-' . $file->getClientOriginalName();
            $file->move(public_path() . '\File_KK', $namaKK);
            $digital->kk = $namaKK;
            // $digital->save();
        }

        $npwpLama = $digital->npwp;
        if ($file = $request->file('fotoNPWP')) {
            // hapus NPWP lama dari storage
            if ($npwpLama !== null) {
                $npwp = public_path('File_NPWP/' . $npwpLama);
                if (file_exists($npwp)) {
                    unlink($npwp);
                }
            }

            $namaNPWP = 'NPWP-' . time() . '-' . $file->getClientOriginalName();
            $file->move(public_path() . '\File_NPWP', $namaNPWP);
            $digital->npwp = $namaNPWP;
        }

        $bpjsketlama = $digital->bpjs_ket;
        if ($file = $request->file('fotoBPJSket')) {
            // hapus BPJS Ketenagakerjaan lama dari storage
            if ($bpjsketlama !== null) {
                $bpjsket = public_path('File_BPJSKet/' . $bpjsketlama);
                if (file_exists($bpjsket)) {
                    unlink($bpjsket);
                }
            }

            $namaBPJSKET = 'BPJSket-' . time() . '-' . $file->getClientOriginalName();
            $file->move(public_path() . '\File_BPJSKet', $namaBPJSKET);
            $digital->bpjs_ket = $namaBPJSKET;
        }

        $bpjskeslama = $digital->bpjs_kes;
        if ($file = $request->file('fotoBPJSkes')) {
            // hapus BPJS Kesehatan lama dari storage
            if ($bpjskeslama !== null) {
                $bpjskes = public_path('File_BPJSKes/' . $bpjskeslama);
                if (file_exists($bpjskes)) {
                    unlink($bpjskes);
                }
            }

            $namaBPJSKES = 'BPJSkes-' . time() . '-' . $file->getClientOriginalName();
            $file->move(public_path() . '\File_BPJSKes', $namaBPJSKES);
            $digital->bpjs_kes = $namaBPJSKES;
        }

        $akdhklama = $digital->as_akdhk;
        if ($file = $request->file('fotoAKDHK')) {
            // hapus AKDHK lama dari storage
            if ($akdhklama !== null) {
                $akdhk = public_path('File_AKDHK/' . $akdhklama);
                if (file_exists($akdhk)) {
                    unlink($akdhk);
                }
            }

            $namaAKDHK = 'AKDHK-' . time() . '-' . $file->getClientOriginalName();
            $file->move(public_path() . '\File_AKDHK', $namaAKDHK);
            $digital->as_akdhk = $namaAKDHK;
        }

        $tabunganlama = $digital->buku_tabungan;
        if ($file = $request->file('fotoTabungan')) {
            // hapus Tabungan lama dari storage
            if ($tabunganlama !== null) {
                $tabungan = public_path('File_Tabungan/' . $tabunganlama);
                if (file_exists($tabungan)) {
                    unlink($tabungan);
                }
            }

            $namaTabungan = 'Tabungan-' . time() . '-' . $file->getClientOriginalName();
            $file->move(public_path() . '\File_Tabungan', $namaTabungan);
            $digital->buku_tabungan = $namaTabungan;
        }

        $skcklama = $digital->skck;
        if ($file = $request->file('fotoSKCK')) {
            // hapus SKCK lama dari storage
            if ($skcklama !== null) {
                $skck = public_path('File_SKCK/' . $skcklama);
                if (file_exists($skck)) {
                    unlink($skck);
                }
            }

            $namaSKCK = 'SKCK-' . time() . '-' . $file->getClientOriginalName();
            $file->move(public_path() . '\File_SKCK', $namaSKCK);
            $digital->skck = $namaSKCK;
        }

        $ijazahlama = $digital->ijazah;
        if ($file = $request->file('fotoIjazah')) {
            // hapus Ijazah lama dari storage
            if ($ijazahlama !== null) {
                $ijazah = public_path('File_Ijazah/' . $ijazahlama);
                if (file_exists($ijazah)) {
                    unlink($ijazah);
                }
            }

            $namaIjazah = 'Ijazah-' . time() . '-' . $file->getClientOriginalName();
            $file->move(public_path() . '\File_Ijazah', $namaIjazah);
            $digital->ijazah = $namaIjazah;
        }

        $lamaranlama = $digital->lamaran;
        if ($file = $request->file('fotoLamaran')) {
            // hapus Lamaran lama dari storage
            if ($lamaranlama !== null) {
                $lamaran = public_path('File_Lamaran/' . $lamaranlama);
                if (file_exists($lamaran)) {
                    unlink($lamaran);
                }
            }

            $namaLamaran = 'Lamaran-' . time() . '-' . $file->getClientOriginalName();
            $file->move(public_path() . '\File_Lamaran', $namaLamaran);
            $digital->lamaran = $namaLamaran;
        }

        $suratpengalamanLama = $digital->surat_pengalaman_kerja;
        if ($file = $request->file('fotoSuratPengalaman')) {
            // hapus Pengalaman Kerja lama dari storage
            if ($suratpengalamanLama !== null) {
                $pengalaman = public_path('File_Pengalaman/' . $suratpengalamanLama);
                if (file_exists($pengalaman)) {
                    unlink($pengalaman);
                }
            }

            $namaPengalaman = 'Pengalaman-' . time() . '-' . $file->getClientOriginalName();
            $file->move(public_path() . '\File_Pengalaman', $namaPengalaman);
            $digital->surat_pengalaman_kerja = $namaPengalaman;
        }

        $suratprestasiLama = $digital->surat_penghargaan;
        if ($file = $request->file('fotoSuratPrestasi')) {
            // hapus Penghargaan lama dari storage
            if ($suratprestasiLama !== null) {
                $prestasi = public_path('File_Prestasi/' . $suratprestasiLama);
                if (file_exists($prestasi)) {
                    unlink($prestasi);
                }
            }

            $namaPrestasi = 'Prestasi-' . time() . '-' . $file->getClientOriginalName();
            $file->move(public_path() . '\File_Prestasi', $namaPrestasi);
            $digital->surat_penghargaan = $namaPrestasi;
        }

        $suratpendidikanLama = $digital->surat_pelatihan;
        if ($file = $request->file('fotoSuratPendidikan')) {
            // hapus Pendidikan lama dari storage
            if ($suratpendidikanLama !== null) {
                $pendidikan = public_path('File_Pendidikan/' . $suratpendidikanLama);
                if (file_exists($pendidikan)) {
                    unlink($pendidikan);
                }
            }

            $namaPendidikan = 'Pendidikan-' . time() . '-' . $file->getClientOriginalName();
            $file->move(public_path() . '\File_Pendidikan', $namaPendidikan);
            $digital->surat_pelatihan = $namaPendidikan;
        }

        $suratperjanjianLama = $digital->surat_perjanjian_kerja;
        if ($file = $request->file('fotoPerjanjianKerja')) {
            // hapus Perjanjian Kerja lama dari storage
            if ($suratperjanjianLama !== null) {
                $perjanjian = public_path('File_Perjanjian/' . $suratperjanjianLama);
                if (file_exists($perjanjian)) {
                    unlink($perjanjian);
                }
            }

            $namaPerjanjian = 'PerjanjianKerja-' . time() . '-' . $file->getClientOriginalName();
            $file->move(public_path() . '\File_Perjanjian', $namaPerjanjian);
            $digital->surat_perjanjian_kerja = $namaPerjanjian;
        }

        $suratpengangkatanLama = $digital->surat_pengangkatan_kartap;
        if ($file = $request->file('fotoSuratPengangkatan')) {
            // hapus Perjanjian Kerja lama dari storage
            if ($suratpengangkatanLama !== null) {
                $pengangkatan = public_path('File_Pengangkatan/' . $suratpengangkatanLama);
                if (file_exists($pengangkatan)) {
                    unlink($pengangkatan);
                }
            }

            $namaPengangkatan = 'SuratPengangkatan-' . time() . '-' . $file->getClientOriginalName();
            $file->move(public_path() . '\File_Pengangkatan', $namaPengangkatan);
            $digital->surat_pengangkatan_kartap = $namaPengangkatan;
        }

        $suratalihtugasLama = $digital->surat_alih_tugas;
        if ($file = $request->file('fotoSuratKeputusan')) {
            // hapus Surat Alih Tugas lama dari storage
            if ($suratalihtugasLama !== null) {
                $alihtugas = public_path('File_Keputusan/' . $suratalihtugasLama);
                if (file_exists($alihtugas)) {
                    unlink($alihtugas);
                }
            }

            $namaalihTugas = 'SuratKeputusan-' . time() . '-' . $file->getClientOriginalName();
            $file->move(public_path() . '\File_Keputusan', $namaalihTugas);
            $digital->surat_alih_tugas = $namaalihTugas;
        }

        
        $digital->save();
        return redirect()->back();
    }
}