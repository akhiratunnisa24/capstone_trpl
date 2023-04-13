<?php

namespace App\Http\Controllers\karyawan;

use Carbon\Carbon;
use App\Models\Cuti;
use App\Models\Izin;
use App\Models\Status;
use App\Models\Karyawan;
use App\Models\Jenisizin;
use App\Models\Datareject;
use App\Models\Departemen;
use App\Models\Alokasicuti;
use Illuminate\Http\Request;
use App\Mail\CutiNotification;
use App\Models\SettingHarilibur;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\Jeniscuti;

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
            ->select('cuti.*', 'jeniscuti.jenis_cuti','statuses.name_status','datareject.alasan as alasan_cuti','datareject.id_cuti as id_cuti')
            ->distinct()
            ->orderBy('created_at','DESC')
            ->get();
        
        //index izin
        $izin = Izin::leftjoin('statuses','izin.status','=','statuses.id')
            ->leftjoin('datareject','datareject.id_izin','=','izin.id')
            ->leftjoin('jenisizin','izin.id_jenisizin','jenisizin.id')
            ->select('izin.*','jenisizin.jenis_izin','statuses.name_status','datareject.alasan as alasan','datareject.id_izin as id_izin')
            ->distinct()
            ->orderBy('created_at','DESC')
            ->get();

        //create cuti
        $karyawan = Auth::user()->id_pegawai;
        $datakry = Karyawan::where('id', $karyawan)->first();
        $departemen = Departemen::where('id',$datakry->divisi)->first();
        $jeniscuti = DB::table('alokasicuti')
            ->join('jeniscuti','alokasicuti.id_jeniscuti','=','jeniscuti.id')
            ->join('settingalokasi','alokasicuti.id_settingalokasi','=','settingalokasi.id')
            ->select('alokasicuti.id','alokasicuti.id_jeniscuti','jeniscuti.jenis_cuti', 'settingalokasi.id as id_settingalokasi', 'alokasicuti.durasi','alokasicuti.aktif_dari','alokasicuti.sampai')
            ->where('alokasicuti.id_karyawan','=', Auth::user()->id_pegawai)
            ->whereYear('sampai', '=', Carbon::now()->year)
            ->distinct()
            ->get();
        // return $jeniscuti;
        //form izin
        $jenisizin = Jenisizin::all();
        $tipe = $request->query('tipe', 1);
        
        return view('karyawan.cuti.index', compact('row','izin','jenisizin','cuti','datakry','departemen','jeniscuti','karyawan','tipe'));
    }

    public function getDurasi(Request $request)
    {
        try {
            $getDurasi = Alokasicuti::select('alokasicuti.id', 'settingalokasi.id as id_settingalokasi', 'alokasicuti.durasi', 'alokasicuti.aktif_dari', 'alokasicuti.sampai','alokasicuti.id_jeniscuti')
                ->join('settingalokasi', 'alokasicuti.id_settingalokasi', '=', 'settingalokasi.id')
                ->where('alokasicuti.id_jeniscuti','=',$request->id_jeniscuti)
                ->where('alokasicuti.id_karyawan','=',Auth::user()->id_pegawai)
                ->whereYear('sampai', '=', Carbon::now()->year)
                ->first();
            // return $getDurasi;

            if(!$getDurasi) {
                throw new \Exception('Data not found');
            }
            return response()->json($getDurasi,200);
            
        } catch (\Exception $e){
            return response()->json([
                'message' =>$e->getMessage()
            ], 500);
        } 
    }

    public function getLibur()
    {
        try {
            $getLibur = SettingHarilibur::all();
            if(!$getLibur) {
                throw new \Exception('Data not found');
            }
            return response()->json($getLibur,200);
            
        } catch (\Exception $e){
            return response()->json([
                'message' =>$e->getMessage()
            ], 500);
        } 
    }

    public function store(Request $request)
    {
        $karyawan = Auth::user()->id_pegawai;
        $role = Auth::user()->role;
        $status = Status::find(1);

        $jeniscuti = Jeniscuti::where('id',$request->id_jeniscuti)->first();

        $cuti = New Cuti;
        $cuti->tgl_permohonan = \Carbon\Carbon::createFromFormat("d/m/Y", $request->tgl_permohonan)->format("Y-m-d");
        $cuti->nik            = $request->nik;
        $cuti->id_karyawan    = $karyawan;
        $cuti->jabatan        = $request->jabatan;
        $cuti->departemen     = $request->departemen;
        $cuti->id_jeniscuti   = $request->id_jeniscuti;
        $cuti->id_alokasi     = $request->id_alokasi;
        $cuti->id_settingalokasi= $request->id_settingalokasi;
        $cuti->keperluan      = $request->keperluan;
        $cuti->jmlharikerja   = $request->jml_cuti;
        if($request->id_jeniscuti == 1)
        {
            $cuti->saldohakcuti   = $request->durasi;
            $cuti->jml_cuti       = $request->jml_cuti;
            $sisa                 = $cuti->saldohakcuti -  $cuti->jml_cuti;  
            $cuti->sisacuti       = $sisa;
            $cuti->keterangan     = "-";
            // dd($cuti->jmlharikerja, $cuti->jml_cuti, $cuti->saldohakcuti, $sisa,$cuti->sisacuti);
        }
        elseif($request->id_jeniscuti == 2)
        {
            $cuti->jml_cuti       = null;
            $cuti->saldohakcuti   = null;
            $cuti->sisacuti       = null;
            $cuti->keterangan     = $jeniscuti->jenis_cuti;
            dd($cuti->jmlharikerja, $cuti->jml_cuti, $cuti->saldohakcuti,$cuti->sisacuti);
        }
        elseif($request->id_jeniscuti == 3)
        {
            $cuti->jml_cuti       = null;
            $cuti->saldohakcuti   = null;
            $cuti->sisacuti       = null;
            $cuti->keterangan     = $jeniscuti->jenis_cuti;
            dd($cuti->jmlharikerja, $cuti->jml_cuti, $cuti->saldohakcuti,$cuti->sisacuti);
        }else{

        }
        $cuti->tgl_mulai      = \Carbon\Carbon::createFromFormat("d/m/Y", $request->tgl_mulai)->format("Y-m-d");
        $cuti->tgl_selesai    = \Carbon\Carbon::createFromFormat("d/m/Y", $request->tgl_selesai)->format("Y-m-d");
      
        $cuti->status         = $status->id;
        // return $cuti;
        $cuti->save();

        // return $cuti;

        $emailkry = DB::table('cuti')->join('karyawan','cuti.id_karyawan','=','karyawan.id')
            ->join('departemen','cuti.departemen','=','departemen.id')
            ->where('cuti.id_karyawan','=',$cuti->id_karyawan)
            ->select('karyawan.email','karyawan.nama','cuti.*','karyawan.atasan_pertama','karyawan.jabatan','departemen.nama_departemen')
            ->first();
        $jeniscuti = Jeniscuti::where('id',$cuti->id_jeniscuti)->first();
        // return $emailkry;
        //atasan pertama
        $atasan = Karyawan::where('id',$emailkry->atasan_pertama)
            ->select('email as email','nama as nama','jabatan as jabatan')
            ->first();
        
        // if ($atasan) {
        $tujuan = $atasan->email;
        $data = [
            'subject' => 'Notifikasi Permohonan ' . $jeniscuti->jenis_cuti . ' ' . '#'. $cuti->id. ' ' . ucwords(strtolower($emailkry->nama)) ,
            'noregistrasi' => $cuti->id,
            'tgl_permohonan' =>Carbon::parse($emailkry->tgl_permohonan)->format("d/m/Y"),
            'nik' => $emailkry->nik,
            'namakaryawan' => ucwords(strtolower($emailkry->nama)),
            'jabatankaryawan' => $emailkry->jabatan,
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
        // return $data;
        Mail::to($tujuan)->send(new CutiNotification($data));
        // } else {
        //     // proses jika data atasan tidak ada / email tidak ada
        // }

        return redirect()->back()
            ->with('success','Email Notifikasi Berhasil Dikirim');
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
