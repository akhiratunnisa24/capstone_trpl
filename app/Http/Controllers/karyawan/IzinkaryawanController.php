<?php

namespace App\Http\Controllers\karyawan;

use Carbon\Carbon;
use App\Models\Izin;
use App\Models\Jenisizin;
use Illuminate\Http\Request;
use App\Mail\IzinNotification;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class IzinkaryawanController extends Controller
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
    
    public function index()
    {
        return view('karyawan.cuti.index', compact('izin','jenisizin','cuti','jeniscuti','karyawan'));
    }

    public function store(Request $request)
    {
        $karyawan = Auth::user()->id_pegawai;
        // $karyawan = Auth::user()->karyawans->id;
        if($request->id_jenisizin == 1 || $request->id_jenisizin == 2)
        {
            $validate = $request->validate([
                'id_karyawan'  => 'required',
                'id_jenisizin' => 'required',
                'keperluan'    => 'required',
                'tgl_mulai'    => 'required',
                'jam_mulai'    => 'required',
                'jam_selesai'  => 'required',
            ]);
            // dd($validate);
            $izin = New Izin;
            $izin->id_karyawan = $karyawan;
            $izin->id_jenisizin= $request->id_jenisizin;
            $izin->keperluan   = $request->keperluan;
            $izin->tgl_mulai   = Carbon::parse($request->tgl_mulai)->format("Y-m-d");
            $izin->tgl_selesai = NULL;
            $izin->jam_mulai   = $request->jam_mulai;
            $izin->jam_selesai = $request->jam_selesai;
            $izin->jml_hari    = 0;

            $jammulai  = Carbon::parse($request->jam_mulai);
            $jamselesai= Carbon::parse($request->jam_selesai);
            $time_range= $jamselesai->diff($jammulai)->format("%H:%I");

            $izin->jml_jam     = $time_range;
            $izin->status      = 'Pending';
            $izin->save();

            //email
            $div = DB::table('karyawan')->join('departemen','karyawan.divisi','=','departemen.id')
                ->where('karyawan.id',$izin->id_karyawan)
                ->select('karyawan.divisi as divisi','departemen.id as dep_id','departemen.nama_departemen as namadepartemen')
                ->first();
            $manager = DB::table('karyawan')
                ->join('departemen','karyawan.divisi','=','departemen.id')
                ->where('divisi',$div->divisi)
                ->where('jabatan','=','Manager')
                ->select('karyawan.*','departemen.nama_departemen as manag_depart')
                ->first();
            $tujuan = $manager->email;
            $data = [
                'subject'     =>'Pemberitahuan Permintaan Izin',
                'id'          =>$izin->id,
                'jenisizin'   =>$izin->jenisizins->jenis_izin,
                'keperluan'   =>$izin->keperluan,
                'tgl_mulai'   =>Carbon::parse($izin->tgl_mulai)->format("d M Y"),
                'tgl_selesai'   =>Carbon::parse($izin->tgl_mulai)->format("d M Y"),
                'jml_hari'    =>0,
                'jml_jam'     =>$izin->jml_jam,
                'status'      =>$izin->status,
                'manag_depart'=>$manager->manag_depart,
                'manag_name'  =>$manager->nama,
            ];
            Mail::to($tujuan)->send(new IzinNotification($data));
            return redirect()->back()->withInput();

        }else{
            $validate = $request->validate([
                'id_karyawan'  => 'required',
                'id_jenisizin' => 'required',
                'keperluan'    => 'required',
                'tgl_mulai'    => 'required',
                'tgl_selesai'  => 'required',
                'jml_hari'     => 'required',
            ]);
            //  dd($validate);
    
            $izin = New Izin;
            $izin->id_karyawan = $karyawan;
            $izin->id_jenisizin= $request->id_jenisizin;
            $izin->keperluan   = $request->keperluan;
            $izin->tgl_mulai   = Carbon::parse($request->tgl_mulai)->format("Y-m-d");
            $izin->tgl_selesai = Carbon::parse($request->tgl_selesai)->format("Y-m-d");
            $izin->jam_mulai   = $request->jam_mulai ?? NULL;
            $izin->jam_selesai = NULL;
            $izin->jml_hari    = $request->jml_hari;
            $izin->jml_jam     = $request->jml_jam ?? NULL;
            $izin->status      = 'Pending';
            // dd($izin);
            $izin->save();

            $div = DB::table('karyawan')->join('departemen','karyawan.divisi','=','departemen.id')
                ->where('karyawan.id',$izin->id_karyawan)
                ->select('karyawan.divisi as divisi','departemen.id as dep_id','departemen.nama_departemen as namadepartemen')
                ->first();
            $manager = DB::table('karyawan')
                ->join('departemen','karyawan.divisi','=','departemen.id')
                ->where('divisi',$div->divisi)
                ->where('jabatan','=','Manager')
                ->select('karyawan.*','departemen.nama_departemen as manag_depart')
                ->first();

            $tujuan = $manager->email;
            $data = [
                'subject'     =>'Pemberitahuan Permintaan Izin',
                'id'          =>$izin->id,
                'jenisizin'   =>$izin->jenisizins->jenis_izin,
                'keperluan'   =>$izin->keperluan,
                'tgl_mulai'   =>Carbon::parse($izin->tgl_mulai)->format("d M Y"),
                'tgl_selesai' =>Carbon::parse($izin->tgl_selesai)->format("d M Y"),
                'jml_hari'    =>$izin->jml_hari,
                'jml_jam'     => 0,
                'status'      =>$izin->status,
                'manag_depart'=>$manager->manag_depart,
                'manag_name'  =>$manager->nama,
            ];
            Mail::to($tujuan)->send(new IzinNotification($data));
            return redirect()->back()->withInput();
        }  

    }

    public function show($id)
    {
        $izin = Izin::findOrFail($id);
        $karyawan = Auth::user()->id_pegawai;

        return view('karyawan.kategori.index',compact('cuti','karyawan'));
    }

}
