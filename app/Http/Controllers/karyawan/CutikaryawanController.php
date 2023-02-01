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
        $cuti = Cuti::latest()->paginate(10);
        // $cek  = Cuti::select(DB::raw("COUNT('id_karyawan) as jumlah"))
        //     ->where('id_karyawan', Auth::user()->id_pegawai)
        //     ->whereYear('tgl_mulai', '=', Carbon::now()->year)
        //     ->whereMonth('tgl_mulai', '=', Carbon::now()->month)
        //     ->where('jumlah','>',2)
        //     ->exists();
        $alasancuti = DB::table('datareject')
            ->join('cuti','datareject.id_cuti','=','cuti.id')
            ->select('datareject.alasan as alasan_cuti','datareject.id_cuti as id_cuti')
            ->first();
         //index izin

        $izin = Izin::latest()->paginate(10);
        $alasan = DB::table('datareject')
            ->join('izin','datareject.id_izin','=','izin.id')
            ->select('datareject.alasan as alasan','datareject.id_izin as id_izin')
            ->first();
        // dd($alasan);
 
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
        return view('karyawan.cuti.index', compact('row','izin','jenisizin','cuti','jeniscuti','karyawan','tipe','alasan','alasancuti'));
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
        // $email = Auth::user()->email;
        //ambil divisi karyawan
        $div = DB::table('karyawan')->join('departemen','karyawan.divisi','=','departemen.id')
            ->where('karyawan.id',$cuti->id_karyawan)
            ->select('karyawan.divisi as divisi','departemen.id as dep_id','departemen.nama_departemen as namadepartemen')
            ->first();
        //data manager
        $manager = DB::table('karyawan')
            ->join('departemen','karyawan.divisi','=','departemen.id')
            ->where('divisi',$div->divisi)
            ->where('jabatan','=','Manager')
            ->select('karyawan.*','departemen.nama_departemen as manag_depart')
            ->first();

        
        // $tujuan = 'andiny700@gmail.com';
        $tujuan = $manager->email;
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
            'manag_depart'=>$manager->manag_depart,
            'manag_name'  =>$manager->nama,
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
