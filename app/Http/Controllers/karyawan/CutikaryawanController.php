<?php

namespace App\Http\Controllers\karyawan;

use Carbon\Carbon;
use App\Models\Cuti;
use App\Models\Izin;
use App\Models\Status;
use App\Models\Karyawan;
use App\Models\Jeniscuti;
use App\Models\Jenisizin;
use App\Models\Datareject;
use App\Models\Departemen;
use App\Models\Alokasicuti;
use Illuminate\Http\Request;
use App\Mail\CutiNotification;
use App\Models\SettingHarilibur;
use Illuminate\Support\Facades\DB;
use App\Mail\PerubahanNotification;
use App\Http\Controllers\Controller;
use App\Mail\PembatalanNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CutikaryawanController extends Controller
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
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();

        //index cuti
        $cuti = DB::table('cuti')
            ->leftjoin('jeniscuti','cuti.id_jeniscuti','jeniscuti.id')
            ->leftjoin('statuses','cuti.status','=','statuses.id')
            ->leftjoin('datareject','datareject.id_cuti','=','cuti.id')
            ->leftjoin('departemen','cuti.departemen','=','departemen.id')
            ->select('cuti.*', 'departemen.nama_departemen','jeniscuti.jenis_cuti','statuses.name_status','datareject.alasan as alasan','datareject.id_cuti as id_cuti')
            ->where('cuti.id_karyawan', Auth::user()->id_pegawai)
            ->distinct()
            ->orderBy('id','DESC')
            ->get();

        //index izin
        $izin = Izin::leftjoin('statuses','izin.status','=','statuses.id')
            ->leftjoin('datareject','izin.id','=','datareject.id_izin')
            ->leftjoin('jenisizin','izin.id_jenisizin','jenisizin.id')
            ->leftjoin('departemen','izin.departemen','=','departemen.id')
            ->select('izin.*','jenisizin.jenis_izin','departemen.nama_departemen','statuses.name_status','datareject.alasan as alasan','datareject.id_izin as id_izin')
            ->where('izin.id_karyawan', Auth::user()->id_pegawai)
            ->distinct()
            ->orderBy('id','DESC')
            ->get();

        //create cuti
        $karyawan = Auth::user()->id_pegawai;
        $datakry = Karyawan::where('id', $karyawan)->first();
        $departemen = Departemen::where('id', $datakry->divisi)->first();
        $jeniscuti = DB::table('alokasicuti')
            ->join('jeniscuti', 'alokasicuti.id_jeniscuti', '=', 'jeniscuti.id')
            ->join('settingalokasi', 'alokasicuti.id_settingalokasi', '=', 'settingalokasi.id')
            ->select('alokasicuti.id', 'alokasicuti.id_jeniscuti', 'jeniscuti.jenis_cuti', 'settingalokasi.id as id_settingalokasi', 'alokasicuti.durasi', 'alokasicuti.aktif_dari', 'alokasicuti.sampai')
            ->where('alokasicuti.id_karyawan', '=', Auth::user()->id_pegawai)
            ->whereYear('sampai', '=', Carbon::now()->year)
            ->distinct()
            ->get();
        // return $jeniscuti;
        //form izin
        $jenisizin = Jenisizin::all();
        $tipe = $request->query('tipe', 1);

        return view('karyawan.cuti.index', compact('row', 'izin', 'jenisizin', 'cuti', 'datakry', 'departemen', 'jeniscuti', 'karyawan', 'tipe'));
    }

    public function getDurasi(Request $request)
    {
        try {
            $getDurasi = Alokasicuti::select('alokasicuti.id', 'settingalokasi.id as id_settingalokasi', 'alokasicuti.durasi', 'alokasicuti.aktif_dari', 'alokasicuti.sampai', 'alokasicuti.id_jeniscuti')
                ->join('settingalokasi', 'alokasicuti.id_settingalokasi', '=', 'settingalokasi.id')
                ->where('alokasicuti.id_jeniscuti', '=', $request->id_jeniscuti)
                ->where('alokasicuti.id_karyawan', '=', Auth::user()->id_pegawai)
                ->whereYear('sampai', '=', Carbon::now()->year)
                ->first();
            // return $getDurasi;

            if (!$getDurasi) {
                throw new \Exception('Data not found');
            }
            return response()->json($getDurasi, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getLibur()
    {
        try {
            $getLibur = SettingHarilibur::all();
            if (!$getLibur) {
                throw new \Exception('Data not found');
            }
            return response()->json($getLibur, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $karyawan = Auth::user()->id_pegawai;
        $role = Auth::user()->role;
        $status = Status::find(1);

        $jeniscuti = Jeniscuti::where('id', $request->id_jeniscuti)->first();

        $today = \Carbon\Carbon::today();
        $existingCuti = Cuti::where('id_karyawan', $karyawan)
                        ->whereDate('tgl_permohonan', $today)
                        ->first();

        if (!$existingCuti) 
        {
            $cuti = new Cuti;
            $cuti->tgl_permohonan = \Carbon\Carbon::createFromFormat("d/m/Y", $request->tgl_permohonan)->format("Y-m-d");
            $cuti->nik            = $request->nik;
            $cuti->id_karyawan    = $karyawan;
            $cuti->jabatan        = $request->jabatan;
            $cuti->departemen     = $request->departemen;
            $cuti->id_jeniscuti   = $request->id_jeniscuti;
            $cuti->id_alokasi     = $request->id_alokasi;
            $cuti->id_settingalokasi = $request->id_settingalokasi;
            $cuti->keperluan      = $request->keperluan;
            $cuti->jmlharikerja   = $request->jml_cuti;
            $cuti->catatan   = null;

            if ($request->id_jeniscuti == 1) {
                $cuti->saldohakcuti   = $request->durasi;
                $cuti->jml_cuti       = $request->jml_cuti;
                $sisa                 = $cuti->saldohakcuti -  $cuti->jml_cuti;
                $cuti->sisacuti       = $sisa;
                $cuti->keterangan     = "-";
                // dd($cuti->jmlharikerja, $cuti->jml_cuti, $cuti->saldohakcuti, $sisa,$cuti->sisacuti);
            } elseif ($request->id_jeniscuti == 2) {
                $cuti->jml_cuti       = null;
                $cuti->saldohakcuti   = null;
                $cuti->sisacuti       = null;
                $cuti->keterangan     = $jeniscuti->jenis_cuti;
                // dd($cuti->jmlharikerja, $cuti->jml_cuti, $cuti->saldohakcuti,$cuti->sisacuti);
            } elseif ($request->id_jeniscuti == 3) {
                $cuti->jml_cuti       = null;
                $cuti->saldohakcuti   = null;
                $cuti->sisacuti       = null;
                $cuti->keterangan     = $jeniscuti->jenis_cuti;
                // dd($cuti->jmlharikerja, $cuti->jml_cuti, $cuti->saldohakcuti,$cuti->sisacuti);
            } else {
            }

            $cuti->tgl_mulai      = \Carbon\Carbon::createFromFormat("d/m/Y", $request->tgl_mulai)->format("Y-m-d");
            $cuti->tgl_selesai    = \Carbon\Carbon::createFromFormat("d/m/Y", $request->tgl_selesai)->format("Y-m-d");
    
            $cuti->status         = $status->id;
            $cuti->save();

            $emailkry = DB::table('cuti')->join('karyawan', 'cuti.id_karyawan', '=', 'karyawan.id')
                ->join('departemen', 'cuti.departemen', '=', 'departemen.id')
                ->where('cuti.id_karyawan', '=', $cuti->id_karyawan)
                ->select('karyawan.email', 'karyawan.nama', 'cuti.*', 'karyawan.atasan_pertama', 'karyawan.atasan_kedua', 'karyawan.nama_jabatan', 'departemen.nama_departemen')
                ->first();

            $jeniscuti = Jeniscuti::where('id', $cuti->id_jeniscuti)->first();
        
            $atasan = Karyawan::where('id', $emailkry->atasan_pertama)
                ->select('email as email', 'nama as nama', 'nama_jabatan as jabatan')
                ->first();

            $atasan2 = NULL;
            if($emailkry->atasan_kedua != NULL)
            {
                $atasan2 = Karyawan::where('id', $emailkry->atasan_kedua)
                    ->select('email as email', 'nama as nama', 'nama_jabatan as jabatan')
                    ->first();
            }
            $tujuan = $atasan->email;

     
            $data = [
                'subject' => 'Notifikasi Permohonan ' . $jeniscuti->jenis_cuti . ' ' . '#' . $cuti->id . ' ' . ucwords(strtolower($emailkry->nama)),
                'noregistrasi' => $cuti->id,
                'title'  => 'NOTIFIKASI PERSETUJUAN FORMULIR CUTI KARYAWAN',
                'subtitle' => '',
                'tgl_permohonan' => Carbon::parse($emailkry->tgl_permohonan)->format("d/m/Y"),
                'nik' => $emailkry->nik,
                'namakaryawan' => ucwords(strtolower($emailkry->nama)),
                'jabatankaryawan' => $emailkry->nama_jabatan,
                'departemen' => $emailkry->nama_departemen,
                'karyawan_email' =>  $emailkry->email,
                'id_jeniscuti' => $jeniscuti->jenis_cuti,
                'keperluan' => $cuti->keperluan,
                'tgl_mulai' => Carbon::parse($cuti->tgl_mulai)->format("d/m/Y"),
                'tgl_selesai' => Carbon::parse($cuti->tgl_selesai)->format("d/m/Y"),
                'jml_cuti' => $cuti->jml_cuti,
                'status' => $status->name_status,
                'jabatan' => $atasan->jabatan,
                'nama_atasan' => $atasan->nama,
                'role' => $role,
            ];
            if($atasan2 !== NULL){
                $data['atasan2'] = $atasan2->email;
            }
            Mail::to($tujuan)->send(new CutiNotification($data));
    
            return redirect()->back()->with('pesan', 'Permohonan Cuti Berhasil Dibuat dan Email Notifikasi Berhasil Dikirim kepada Atasan');

        }else{
            return redirect()->back()->with('pesa', 'Anda sudah mengajukan cuti pada hari ini!');
        }
    }

    public function batal(Request $request, $id)
    {
        $role = Auth::user()->role;
        $karyawan = Auth::user()->id_pegawai;
        $status = Status::find(11);
        Cuti::where('id', $id)->update(
            [
                'catatan' => $status->name_status,
            ]
        );

        $cuti = Cuti::where('id', $id)->first();
        // return $cuti;

        $emailkry = DB::table('cuti')->join('karyawan', 'cuti.id_karyawan', '=', 'karyawan.id')
            ->join('departemen', 'cuti.departemen', '=', 'departemen.id')
            ->where('cuti.id_karyawan', '=', $cuti->id_karyawan)
            ->select('karyawan.email', 'karyawan.nama', 'cuti.*', 'karyawan.atasan_pertama', 'karyawan.atasan_kedua', 'karyawan.nama_jabatan', 'departemen.nama_departemen')
            ->first();

        $jeniscuti = Jeniscuti::where('id', $cuti->id_jeniscuti)->first();
        //atasan pertama
        $atasan = Karyawan::where('id', $emailkry->atasan_pertama)
            ->select('email as email', 'nama as nama', 'nama_jabatan as jabatan')
            ->first();
        $atasan2 = NULL;
        if($emailkry->atasan_kedua != NULL)
        {
            $atasan2 = Karyawan::where('id', $emailkry->atasan_kedua)
                ->select('email as email', 'nama as nama', 'nama_jabatan as jabatan')
                ->first();
        }
        $tujuan = $atasan->email;
        $data = [
            'subject' => 'Notifikasi Pembatalan Permohonan ' . $jeniscuti->jenis_cuti . ' ' . '#' . $cuti->id . ' ' . ucwords(strtolower($emailkry->nama)),
            'title'  => 'NOTIFIKASI PERSETUJUAN CUTI KARYAWAN',
            'subtitle' => '[ PERSETUJUAN PEMBATALAN ]',
            'noregistrasi' => $cuti->id,
            'tgl_permohonan' => Carbon::parse($emailkry->tgl_permohonan)->format("d/m/Y"),
            'nik' => $emailkry->nik,
            'namakaryawan' => ucwords(strtolower($emailkry->nama)),
            'jabatankaryawan' => $emailkry->nama_jabatan,
            'departemen' => $emailkry->nama_departemen,
            'karyawan_email' =>  $emailkry->email,
            'id_jeniscuti' => $jeniscuti->jenis_cuti,
            'keperluan' => $cuti->keperluan,
            'tgl_mulai' => Carbon::parse($cuti->tgl_mulai)->format("d/m/Y"),
            'tgl_selesai' => Carbon::parse($cuti->tgl_selesai)->format("d/m/Y"),
            'tgldisetujuiatasan' => "-",
            'tgldisetujuipimpinan' => "-",
            'tglditolak' => "-",
            'jml_cuti' => $cuti->jml_cuti,
            'status' => $status->name_status,
            'statuss' => $status->id,
            'jabatan' => $atasan->jabatan,
            'nama_atasan' => $atasan->nama,
            'role' => $role,
        ];
         if($atasan2 !== NULL){
            $data['atasan2'] = $atasan2->email;
        }
        Mail::to($tujuan)->send(new PembatalanNotification($data));
        // return $data;
        // } else {
        //     // proses jika data atasan tidak ada / email tidak ada
        // }
        return redirect()->back()
            ->with('pesan', 'Email Notifikasi Pembatalan Permohonan Cuti Berhasil Dikirim');
    }

    public function update(Request $request, $id)
    {
        $role = Auth::user()->role;
        $karyawan = Auth::user()->id_pegawai;
        $status = Status::find(14);
        $cuti = Cuti::find($id);
        
        // $saldo = $cuti->saldohakcuti;
        // $jmlcuti = $request->jml_cuti;
        // $selisih = $saldo - $jmlcuti;

        // dd($cuti, $saldo,$jmlcuti,$request->all(),$selisih);

        $jeniscuti = Jeniscuti::where('id', $cuti->id_jeniscuti)->first();

        $cuti->tgl_permohonan = $cuti->tgl_permohonan;
        $cuti->nik            = $cuti->nik;
        $cuti->id_karyawan    = $karyawan;
        $cuti->jabatan        = $cuti->jabatan;
        $cuti->departemen     = $cuti->departemen;
        $cuti->id_jeniscuti   = $cuti->id_jeniscuti;
        $cuti->id_alokasi     = $cuti->id_alokasi;
        $cuti->id_settingalokasi = $cuti->id_settingalokasi;
        $cuti->keperluan      = $request->keperluan;
        $cuti->catatan        = $status->name_status;
        $cuti->jmlharikerja   = $request->jml_cuti;
        
        if($request->id_jeniscuti == 1)
        {  
            $cuti->saldohakcuti   = $cuti->saldohakcuti;
            $cuti->jml_cuti       = $request->jml_cuti;
            $sisa                 = $cuti->saldohakcuti -  $cuti->jml_cuti;
            $cuti->sisacuti       = $sisa;
            $cuti->keterangan     = "-";
           
            // dd($cuti->saldohakcuti, $cuti->jml_cuti, $cuti->sisacuti);

            // dd($cuti->jmlharikerja, $cuti->jml_cuti, $cuti->saldohakcuti, $sisa,$cuti->sisacuti);
        } elseif ($request->id_jeniscuti == 2) {
            $cuti->jml_cuti       = null;
            $cuti->saldohakcuti   = null;
            $cuti->sisacuti       = null;
            $cuti->keterangan     = $jeniscuti->jenis_cuti;
            // dd($cuti->jmlharikerja, $cuti->jml_cuti, $cuti->saldohakcuti,$cuti->sisacuti);
        } elseif ($request->id_jeniscuti == 3) {
            $cuti->jml_cuti       = null;
            $cuti->saldohakcuti   = null;
            $cuti->sisacuti       = null;
            $cuti->keterangan     = $jeniscuti->jenis_cuti;
            // dd($cuti->jmlharikerja, $cuti->jml_cuti, $cuti->saldohakcuti,$cuti->sisacuti);
        }else{
            $cuti->jml_cuti       = null;
            $cuti->saldohakcuti   = null;
            $cuti->sisacuti       = null;
            $cuti->keterangan     = $jeniscuti->jenis_cuti;
        }
        // return $cuti->id;
        $cuti->tgl_mulai      = \Carbon\Carbon::createFromFormat("d/m/Y", $request->tgl_mulai)->format("Y-m-d");
        $cuti->tgl_selesai    = \Carbon\Carbon::createFromFormat("d/m/Y", $request->tgl_selesai)->format("Y-m-d");

        $cuti->status         = $cuti->status;
        // dd($cuti,$request->all());
        $cuti->update();

        // return $cuti;

        $emailkry = DB::table('cuti')->join('karyawan', 'cuti.id_karyawan', '=', 'karyawan.id')
            ->join('departemen', 'cuti.departemen', '=', 'departemen.id')
            ->where('cuti.id_karyawan', '=', $cuti->id_karyawan)
            ->select('karyawan.email', 'karyawan.nama', 'cuti.*', 'karyawan.atasan_pertama', 'karyawan.atasan_kedua', 'karyawan.nama_jabatan', 'departemen.nama_departemen')
            ->first();

        $jeniscuti = Jeniscuti::where('id', $cuti->id_jeniscuti)->first();
        //atasan pertama
        $atasan = Karyawan::where('id', $emailkry->atasan_pertama)
            ->select('email as email', 'nama as nama', 'nama_jabatan as jabatan')
            ->first();
        
        $atasan2 = NULL;
        if($emailkry->atasan_kedua != NULL)
        {
            $atasan2 = Karyawan::where('id', $emailkry->atasan_kedua)
                ->select('email as email', 'nama as nama', 'nama_jabatan as jabatan')
                ->first();
        }
        $tujuan = $atasan->email;
        $data = [
            'subject' => 'Notifikasi Perubahan Permohonan ' . $jeniscuti->jenis_cuti . ' ' . '#' . $cuti->id . ' ' . ucwords(strtolower($emailkry->nama)),
            'title'  => 'NOTIFIKASI PERSETUJUAN PERMOHONAN CUTI KARYAWAN',
            'subtitle' => '[ PERSETUJUAN PERUBAHAN DATA ]',
            'noregistrasi' => $cuti->id,
            'tgl_permohonan' => Carbon::parse($emailkry->tgl_permohonan)->format("d/m/Y"),
            'nik' => $emailkry->nik,
            'namakaryawan' => ucwords(strtolower($emailkry->nama)),
            'jabatankaryawan' => $emailkry->nama_jabatan,
            'departemen' => $emailkry->nama_departemen,
            'karyawan_email' =>  $emailkry->email,
            'id_jeniscuti' => $jeniscuti->jenis_cuti,
            'keperluan' => $cuti->keperluan,
            'tgl_mulai' => Carbon::parse($cuti->tgl_mulai)->format("d/m/Y"),
            'tgl_selesai' => Carbon::parse($cuti->tgl_selesai)->format("d/m/Y"),
            'tgldisetujuiatasan' => "-",
            'tgldisetujuipimpinan' => "-",
            'tglditolak' => "-",
            'jml_cuti' => $cuti->jml_cuti,
            'status' => $status->name_status,
            'statuss' => $status->id,
            'jabatan' => $atasan->jabatan,
            'nama_atasan' => $atasan->nama,
            'role' => $role,
        ];
        if($atasan2 !== NULL){
            $data['atasan2'] = $atasan2->email;
        }
        Mail::to($tujuan)->send(new PerubahanNotification($data));

        return redirect()->back()
            ->with('pesan','Email Notifikasi Perubahan Data Permohonan Cuti Berhasil Dikirim');
    }
}
 // $tujuan = 'andiny700@gmail.com';
        // $tujuan = $atasan->email;
        // $data = [
        //     'subject'     =>'Pemberitahuan Permintaan Cuti',
        //     'body'        =>'Anda Memiliki 1 Permintaan Cuti yang harus di Approved',
        //     'id'          =>$cuti->id,
        //     'id_jeniscuti'=>$cuti->jeniscutis->jenis_cuti,
        //     'keperluan'   =>$cuti->keperluan,
        //     'tgl_mulai'   =>Carbon::parse($cuti->tgl_mulai)->format("d M Y"),
        //     'tgl_selesai' =>Carbon::parse($cuti->tgl_selesai)->format("d M Y"),
        //     'jml_cuti'    =>$cuti->jml_cuti,
        //     'status'      =>$cuti->status,
        //     'atasan_depar'=>$atasan->jabatan,
        //     'nama_atasan' =>$atasan->nama,
        //     'role'        =>$role,
        // ];
        // Mail::to($tujuan)->send(new CutiNotification($data));

         // public function show($id)
    // {
    //     $cuti = Cuti::findOrFail($id);
    //     $karyawan = Auth::user()->id_pegawai;

    //     return view('karyawan.kategori.index',compact('cuti','karyawan'));
    // }
