<?php

namespace App\Http\Controllers\karyawan;

use Carbon\Carbon;
use App\Models\Izin;
use App\Models\Status;
use App\Models\Karyawan;
use App\Models\Departemen;
use Illuminate\Http\Request;
use App\Mail\IzinNotification;
use App\Models\SettingHarilibur;
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

    public function getLiburdata()
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
        // $karyawan = Auth::user()->karyawans->id;
        $status = Status::find(1);
        
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
            $izin->status      = $status->id;
            $izin->save();

            $emailkry = DB::table('izin')->join('karyawan','izin.id_karyawan','=','karyawan.id')
                ->where('izin.id_karyawan','=',$izin->id_karyawan)
                ->select('karyawan.email','karyawan.nama','karyawan.atasan_pertama')
                ->first();

            $atasan = Karyawan::where('id',$emailkry->atasan_pertama)
                ->select('email as email','nama as nama','jabatan as jabatan','divisi as departemen')
                ->first();

            $tujuan = $atasan['email'];

            $data = [
                'subject'     =>'Pemberitahuan Permintaan Izin '. $izin->jenisizins->jenis_izin,
                'karyawan_email' =>$emailkry->email,
                'id'          =>$izin->id,
                'jenisizin'   =>$izin->jenisizins->jenis_izin,
                'keperluan'   =>$izin->keperluan,
                'tgl_mulai'   =>Carbon::parse($izin->tgl_mulai)->format("d M Y"),
                'tgl_selesai'   =>Carbon::parse($izin->tgl_mulai)->format("d M Y"),
                'jml_hari'    =>0,
                'jam_mulai'   =>$izin->jam_mulai,
                'jam_selesai' =>$izin->jam_selesai,
                'jml_jam'     =>$izin->jml_jam,
                'status'      =>$status->name_status,
                'nama_atasan' =>$atasan->nama,
                'jabatan'     =>strtoupper($atasan['jabatan']),
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
            $izin->status      = $status->id;
            // dd($izin);
            $izin->save();

            $emailkry = DB::table('izin')->join('karyawan','izin.id_karyawan','=','karyawan.id')
                ->where('izin.id_karyawan','=',$izin->id_karyawan)
                ->select('karyawan.email','karyawan.nama','karyawan.atasan_pertama')
                ->first();
            $atasan = Karyawan::where('id',$emailkry->atasan_pertama)
                ->select('email as email','nama as nama','jabatan as jabatan','divisi as departemen')
                ->first();
            $tujuan = $atasan['email'];

            $data = [
                'subject'     =>'Pemberitahuan Permintaan Izin '. $izin->jenisizins->jenis_izin,
                'id'          =>$izin->id,
                'karyawan_email' =>$emailkry->email,
                'jenisizin'   =>$izin->jenisizins->jenis_izin,
                'keperluan'   =>$izin->keperluan,
                'tgl_mulai'   =>Carbon::parse($izin->tgl_mulai)->format("d M Y"),
                'tgl_selesai' =>Carbon::parse($izin->tgl_selesai)->format("d M Y"),
                'jml_hari'    =>$izin->jml_hari,
                'jml_jam'     => 0,
                'status'      =>$status->name_status,
                'jam_mulai'   =>$izin->jam_mulai,
                'jam_selesai' =>$izin->jam_selesai,
                'nama_atasan' =>$atasan->nama,
                'jabatan'     =>strtoupper($atasan->jabatan),
            ];
            Mail::to($tujuan)->send(new IzinNotification($data));
            // dd($data);
            return redirect()->back()->withInput();
        }  

    }
}
