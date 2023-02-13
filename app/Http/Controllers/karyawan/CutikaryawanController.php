<?php

namespace App\Http\Controllers\karyawan;

use Carbon\Carbon;
use App\Models\Cuti;
use App\Models\Izin;
use App\Models\Karyawan;
use App\Models\Jenisizin;
use App\Models\Datareject;
use App\Models\Alokasicuti;
use Illuminate\Http\Request;
use App\Mail\CutiNotification;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
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
        $jeniscuti = DB::table('alokasicuti')
            ->join('jeniscuti','alokasicuti.id_jeniscuti','=','jeniscuti.id')
            ->join('settingalokasi','alokasicuti.id_settingalokasi','=','settingalokasi.id')
            ->select('alokasicuti.id','alokasicuti.id_jeniscuti','jeniscuti.jenis_cuti', 'settingalokasi.id as id_settingalokasi', 'alokasicuti.durasi','alokasicuti.aktif_dari','alokasicuti.sampai')
            ->where('alokasicuti.id_karyawan','=', Auth::user()->id_pegawai)
            ->where('alokasicuti.durasi','>',0)
            ->distinct()
            ->get();

        //form izin
        $jenisizin = Jenisizin::all();
        $tipe = $request->query('tipe', 1);
        
        return view('karyawan.cuti.index', compact('row','izin','jenisizin','cuti','jeniscuti','karyawan','tipe'));
    }

    public function getDurasi(Request $request)
    {
        try {
            // $getDurasi = Alokasicuti::select('id','id_settingalokasi','durasi','aktif_dari','sampai')
            // ->where('id_jeniscuti','=',$request->id_jeniscuti)
            // ->where('id_karyawan','=',Auth::user()->id_pegawai)
            // ->first();

            $getDurasi = Alokasicuti::select('alokasicuti.id', 'settingalokasi.id as id_settingalokasi', 'alokasicuti.durasi', 'alokasicuti.aktif_dari', 'alokasicuti.sampai')
                ->join('settingalokasi', 'alokasicuti.id_settingalokasi', '=', 'settingalokasi.id')
                ->where('alokasicuti.id_jeniscuti','=',$request->id_jeniscuti)
                ->where('alokasicuti.id_karyawan','=',Auth::user()->id_pegawai)
                ->first();

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

    public function store(Request $request)
    {
        $karyawan = Auth::user()->id_pegawai;
        $role = Auth::user()->role;

        $cuti = New Cuti;
        $cuti->id_karyawan = $karyawan;
        $cuti->id_jeniscuti= $request->id_jeniscuti;
        $cuti->id_alokasi  = $request->id_alokasi;
        $cuti->id_settingalokasi= $request->id_settingalokasi;
        $cuti->keperluan   = $request->keperluan;
        $cuti->tgl_mulai   = Carbon::parse($request->tgl_mulai)->format("Y-m-d");
        $cuti->tgl_selesai = Carbon::parse($request->tgl_selesai)->format("Y-m-d");
        $cuti->jml_cuti    = $request->jml_cuti;
        $cuti->status      = 'Pending';
        $cuti->save();

        //sending email cuti
        $idatasan = DB::table('karyawan')
            ->join('cuti','karyawan.id','=','cuti.id_karyawan')
            ->where('cuti.id_karyawan','=',$cuti->id_karyawan)
            ->select('karyawan.atasan_pertama as atasan_pertama')
            ->first();
        $atasan = Karyawan::where('id',$idatasan->atasan_pertama)
            ->select('email as email','nama as nama','jabatan as jabatan')
            ->first();
            
        // $tujuan = 'andiny700@gmail.com';
        $tujuan = $atasan->email;
        $data = [
            'subject'     =>'Pemberitahuan Permintaan Cuti',
            'body'        =>'Anda Memiliki 1 Permintaan Cuti yang harus di Approved',
            'id'          =>$cuti->id,
            'id_jeniscuti'=>$cuti->jeniscutis->jenis_cuti,
            'keperluan'   =>$cuti->keperluan,
            'tgl_mulai'   =>Carbon::parse($cuti->tgl_mulai)->format("d M Y"),
            'tgl_selesai' =>Carbon::parse($cuti->tgl_selesai)->format("d M Y"),
            'jml_cuti'    =>$cuti->jml_cuti,
            'status'      =>$cuti->status,
            'atasan_depar'=>$atasan->jabatan,
            'nama_atasan' =>$atasan->nama,
            'role'        =>$role,
        ];
        Mail::to($tujuan)->send(new CutiNotification($data));
        return redirect()->back()
            ->with('success','Email Notifikasi Berhasil Dikirim');
    }

    // public function show($id)
    // {
    //     $cuti = Cuti::findOrFail($id);
    //     $karyawan = Auth::user()->id_pegawai;

    //     return view('karyawan.kategori.index',compact('cuti','karyawan'));
    // }
}
