<?php

namespace App\Http\Controllers\karyawan;

use Carbon\Carbon;
use App\Models\Izin;
use App\Models\Status;
use App\Models\Karyawan;
use App\Models\Jenisizin;
use App\Models\Departemen;
use Illuminate\Http\Request;
use App\Mail\IzinNotification;
use App\Models\SettingHarilibur;
use Illuminate\Support\Facades\DB;
use App\Mail\PerubahanNotification;
use App\Http\Controllers\Controller;
use App\Mail\PembatalanNotification;
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
        $status = Status::find(1);

        if($request->id_jenisizin == 5)
        {
            $validate = $request->validate([
                'id_jenisizin'  => 'required',
                'keperluan'     => 'required',
                'tgl_mulai'     => 'required',
                'jam_mulai'     => 'required',
            ]);
            // dd($validate);
            $today = \Carbon\Carbon::today();
            $existingIzin = Izin::where('id_karyawan', $karyawan)
                            ->whereDate('tgl_permohonan', $today)
                            ->first();
            
            if(!$existingIzin)
            {
                $izin = New Izin;
                $izin->tgl_permohonan = \Carbon\Carbon::createFromFormat("d/m/Y", $request->tglpermohonan)->format("Y-m-d");
                $izin->nik            = $request->nik;
                $izin->id_karyawan    = $karyawan;
                $izin->jabatan        = $request->jabatan;
                $izin->departemen     = $request->departemen;
                $izin->id_jenisizin   = $request->id_jenisizin;
                $izin->keperluan      = $request->keperluan;
                $izin->tgl_mulai      = \Carbon\Carbon::createFromFormat("d/m/Y", $request->tgl_mulai)->format("Y-m-d");
                $izin->tgl_selesai    = NULL;
                $izin->jam_mulai      = $request->jam_mulai;
                $izin->jam_selesai    = $request->jam_selesai;
                $izin->jml_hari       = 0;
    
                $jammulai  = Carbon::parse($request->jam_mulai);
                $jamselesai= Carbon::parse($request->jam_selesai);
                $time_range= $jamselesai->diff($jammulai)->format("%H:%I");
    
                $izin->jml_jam     = $time_range;
                $izin->status      = $status->id;
                $izin->catatan     = $request->catatan ?? NULL;
                $izin->save();
    
                $emailkry = DB::table('izin')->join('karyawan','izin.id_karyawan','=','karyawan.id')
                    ->join('departemen','izin.departemen','=','departemen.id')
                    ->where('izin.id_karyawan','=',$izin->id_karyawan)
                    ->select('karyawan.email','karyawan.nama','karyawan.atasan_pertama','karyawan.atasan_kedua','izin.*','karyawan.nama_jabatan','departemen.nama_departemen')
                    ->first();
                $jenisizin = Jenisizin::where('id',$izin->id_jenisizin)->first();
    
                $atasan = Karyawan::where('id',$emailkry->atasan_pertama)
                    ->select('email as email','nama as nama','jabatan as jabatan','divisi as departemen')
                    ->first();
    
                $atasan2 = NULL;
                if($emailkry->atasan_kedua != NULL)
                {
                    $atasan2 = Karyawan::where('id',$emailkry->atasan_kedua)
                    ->select('email as email','nama as nama','nama_jabatan as jabatan','divisi as departemen')
                    ->first();
                }
               
                $tujuan = $atasan->email;
    
                $data = [
                    'subject' => 'Notifikasi Permohonan ' . $jenisizin->jenis_izin . ' ' . '#'. $izin->id. ' ' . ucwords(strtolower($emailkry->nama)) ,
                    'noregistrasi' => $izin->id,
                    'title'  => 'NOTIFIKASI PERSETUJUAN PERMOHONAN IZIN KARYAWAN',
                    'subtitle' => '',
                    'tgl_permohonan' =>Carbon::parse($emailkry->tgl_permohonan)->format("d/m/Y"),
                    'nik' => $emailkry->nik,
                    'namakaryawan' => ucwords(strtolower($emailkry->nama)),
                    'jabatankaryawan' => $emailkry->nama_jabatan,
                    'departemen' => $emailkry->nama_departemen,
                    'karyawan_email' =>$emailkry->email,
                    'id_jenisizin'   =>$jenisizin->jenis_izin,
                    'keperluan'   =>$izin->keperluan,
                    'tgl_mulai'   =>Carbon::parse($izin->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai'   =>Carbon::parse($izin->tgl_selesai)->format("d/m/Y"),
                    'jml_hari'    =>0,
                    'jam_mulai'   =>$izin->jam_mulai,
                    'jam_selesai' =>$izin->jam_selesai,
                    'jml_jam'     =>$izin->jml_jam,
                    'status'      =>$status->name_status,
                    'nama_atasan' =>$atasan->nama,
                    'jabatan'     =>strtoupper($atasan['jabatan']),
                ];
                if($atasan2 !== NULL){
                    $data['atasan2'] = $atasan2->email;
                }
                Mail::to($tujuan)->send(new IzinNotification($data));
                
                return redirect()->back()->with('pesan','Permohonan Izin Berhasil Dibuat dan Email Notifikasi Berhasil Dikirim kepada Atasan');
            }
            else
            {
                return redirect()->back()->with('pesa', 'Anda sudah mengajukan izin pada hari ini!');
            }
        }
        else
        {
            $validate = $request->validate([
                'id_jenisizin'  => 'required',
                'tgl_mulai'     => 'required',
                'tgl_selesai'   => 'required',
                'keperluan'     => 'required',
                'jml_hari'      => 'required',
            ]);

            $today = \Carbon\Carbon::today();
            $existingIzin = Izin::where('id_karyawan', $karyawan)
                            ->whereDate('tgl_permohonan', $today)
                            ->first();
            
            if(!$existingIzin)
            {
                $izin = New Izin;
                $izin->tgl_permohonan = \Carbon\Carbon::createFromFormat("d/m/Y", $request->tglpermohonan)->format("Y-m-d");
                $izin->nik            = $request->nik;
                $izin->id_karyawan    = $karyawan;
                $izin->jabatan        = $request->jabatan;
                $izin->departemen     = $request->departemen;
                $izin->id_jenisizin   = $request->id_jenisizin;
                $izin->keperluan      = $request->keperluan;
                $izin->tgl_mulai      = \Carbon\Carbon::createFromFormat("d/m/Y", $request->tgl_mulai)->format("Y-m-d");
                $izin->tgl_selesai    = \Carbon\Carbon::createFromFormat("d/m/Y", $request->tgl_selesai)->format("Y-m-d");
                $izin->jam_mulai      = $request->jam_mulai ?? NULL;
                $izin->jam_selesai    = NULL;
                $izin->jml_hari       = $request->jml_hari;
                $izin->jml_jam        = $request->jml_jam ?? NULL;
                $izin->status         = $status->id;
                $izin->catatan        = $request->catatan ?? NULL;
                // dd($izin);
                $izin->save();

                $emailkry = DB::table('izin')->join('karyawan','izin.id_karyawan','=','karyawan.id')
                    ->join('departemen','izin.departemen','=','departemen.id')
                    ->where('izin.id_karyawan','=',$izin->id_karyawan)
                    ->select('karyawan.email','karyawan.nama','karyawan.atasan_pertama','karyawan.atasan_kedua','izin.*','karyawan.nama_jabatan','departemen.nama_departemen')
                    ->first();
                $jenisizin = Jenisizin::where('id',$izin->id_jenisizin)->first();

                $atasan = Karyawan::where('id',$emailkry->atasan_pertama)
                    ->select('email as email','nama as nama','nama_jabatan as jabatan','divisi as departemen')
                    ->first();
                $atasan2 = NULL;
                if($emailkry->atasan_kedua != NULL)
                {
                    $atasan2 = Karyawan::where('id',$emailkry->atasan_kedua)
                    ->select('email as email','nama as nama','nama_jabatan as jabatan','divisi as departemen')
                    ->first();
                }

                $tujuan = $atasan->email;
                $data = [
                    'subject' => 'Notifikasi Permohonan ' . $jenisizin->jenis_izin . ' ' . '#'. $izin->id. ' ' . ucwords(strtolower($emailkry->nama)) ,
                    'title'  => 'NOTIFIKASI PERSETUJUAN PERMOHONAN IZIN KARYAWAN',
                    'subtitle' => '',
                    'noregistrasi' => $izin->id,
                    'tgl_permohonan' =>Carbon::parse($emailkry->tgl_permohonan)->format("d/m/Y"),
                    'nik' => $emailkry->nik,
                    'namakaryawan' => ucwords(strtolower($emailkry->nama)),
                    'jabatankaryawan' => $emailkry->nama_jabatan,
                    'departemen' => $emailkry->nama_departemen,
                    'karyawan_email' =>$emailkry->email,
                    'id_jenisizin'   =>$jenisizin->jenis_izin,
                    'keperluan'   =>$izin->keperluan,
                    'tgl_mulai'   =>Carbon::parse($izin->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' =>Carbon::parse($izin->tgl_selesai)->format("d/m/Y"),
                    'jml_hari'    =>$izin->jml_hari,
                    'jml_jam'     => 0,
                    'status'      =>$status->name_status,
                    'jam_mulai'   =>$izin->jam_mulai,
                    'jam_selesai' =>$izin->jam_selesai,
                    'nama_atasan' =>$atasan->nama,
                    'jabatan'     =>strtoupper($atasan->jabatan),
                ];
                if($atasan2 !== NULL){
                    $data['atasan2'] = $atasan2->email;
                }
                Mail::to($tujuan)->send(new IzinNotification($data));
                // dd($data);
                return redirect()->back()->with('pesan','Permohonan Izin Berhasil Dibuat dan Email Notifikasi Berhasil Dikirim kepada Atasan');

            }
            else
            {
                return redirect()->back()->with('pesa', 'Anda sudah mengajukan izin pada hari ini!');
            } 
        }  

    }

    public function batal(Request $request, $id)
    {
        $role = Auth::user()->role;
        $karyawan = Auth::user()->id_pegawai;
        $status = Status::find(11);
        Izin::where('id',$id)->update(
            [
                'catatan' => $status->name_status,
            ]
        );

        $izin = Izin::where('id', $id)->first();
        // return $izin;
        
        $emailkry = DB::table('izin')->join('karyawan','izin.id_karyawan','=','karyawan.id')
            ->join('departemen','izin.departemen','=','departemen.id')
            ->where('izin.id_karyawan','=',$izin->id_karyawan)
            ->select('karyawan.email','karyawan.nama','izin.*','karyawan.atasan_pertama','karyawan.atasan_kedua','karyawan.nama_jabatan','departemen.nama_departemen')
            ->first();
        
        $jenisizin = Jenisizin::where('id',$izin->id_jenisizin)->first();
        //atasan pertama
        $atasan = Karyawan::where('id',$emailkry->atasan_pertama)
            ->select('email as email','nama as nama','nama_jabatan as jabatan')
            ->first();
        $atasan2 = Karyawan::where('id',$emailkry->atasan_kedua)
            ->select('email as email','nama as nama','nama_jabatan as jabatan')
            ->first();
    
        $tujuan = $atasan->email;
        $data = [
            'subject' => 'Notifikasi Pembatalan Permohonan ' . $jenisizin->jenis_izin . ' ' . '#'. $izin->id. ' ' . ucwords(strtolower($emailkry->nama)) ,
            'title'  => 'NOTIFIKASI PERSETUJUAN IZIN KARYAWAN',
            'subtitle'=> '[ PERSETUJUAN PEMBATALAN ]',
            'noregistrasi' => $izin->id,
            'tgl_permohonan' =>Carbon::parse($emailkry->tgl_permohonan)->format("d/m/Y"),
            'nik' => $emailkry->nik,
            'namakaryawan' => ucwords(strtolower($emailkry->nama)),
            'jabatankaryawan' => $emailkry->nama_jabatan,
            'departemen' => $emailkry->nama_departemen,
            'karyawan_email' =>  $emailkry->email,
            'id_jeniscuti' => $jenisizin->jenis_izin,
            'keperluan' => $izin->keperluan,
            'tgl_mulai' => Carbon::parse($izin->tgl_mulai)->format("d/m/Y"),
            'tgl_selesai' => Carbon::parse($izin->tgl_selesai)->format("d/m/Y"),
            'tgldisetujuiatasan'=> "-",
            'tgldisetujuipimpinan' => "-",
            'tglditolak' => "-",
            'jml_cuti' => $izin->jml_hari,
            'status' => $status->name_status,
            'statuss' => $status->id,
            'jabatan' => $atasan->jabatan,
            'nama_atasan' => $atasan->nama,
            'role' => $role,
            'atasan2' => $atasan2->email,
        ];
        // return $data;
        Mail::to($tujuan)->send(new PembatalanNotification($data));
        // return $data;
        // } else {
        //     // proses jika data atasan tidak ada / email tidak ada
        // }

        return redirect()->back()
            ->with('pesan','Email Notifikasi Pembatalan Permohonan Izin Berhasil Dikirim');
    }

    public function update(Request $request, $id)
    {
        $role = Auth::user()->role;
        $karyawan = Auth::user()->id_pegawai;

        $status = Status::find(14);
        $izin = Izin::find($id);
    
        $jenisizin = Jenisizin::where('id',$izin->id_jeniscuti)->first();

        $izin->keperluan      = $request->keperluan;
        $izin->catatan        = $status->name_status;
        if($request->id_jenisizin == 1)
        {
            $izin->jam_mulai = null;
            $izin->jam_selesai= null;
            $izin->jml_jam    = null;
            $izin->tgl_mulai      = \Carbon\Carbon::createFromFormat("d/m/Y", $request->tgl_mulai)->format("Y-m-d");
            $izin->tgl_selesai    = \Carbon\Carbon::createFromFormat("d/m/Y", $request->tgl_selesai)->format("Y-m-d");
            // $izin->saldohakcuti   = $request->durasi;
            // $izin->jml_hari       = $request->jml_hari;
            // $sisa                 = $izin->saldohakcuti -  $izin->jml_hari;  
            // $izin->sisacuti       = $sisa;
            // $izin->keterangan     = "-";

            // dd($izin->jmlharikerja, $izin->jml_hari, $izin->saldohakcuti, $sisa,$izin->sisacuti);
        }
        elseif($request->id_jenisizin == 2)
        {
            $izin->jam_mulai = null;
            $izin->jam_selesai= null;
            $izin->jml_jam    = null;
            $izin->tgl_mulai      = \Carbon\Carbon::createFromFormat("d/m/Y", $request->tgl_mulai)->format("Y-m-d");
            $izin->tgl_selesai    = \Carbon\Carbon::createFromFormat("d/m/Y", $request->tgl_selesai)->format("Y-m-d");
            // $izin->jml_hari       = null;
            // $izin->saldohakcuti   = null;
            // $izin->sisacuti       = null;
            // $izin->keterangan     = $jenisizin->jenis_izin;
            // dd($izin->jmlharikerja, $izin->jml_hari, $izin->saldohakcuti,$izin->sisacuti);
        }
        elseif($request->id_jenisizin == 3)
        {
            $izin->jam_mulai = null;
            $izin->jam_selesai= null;
            $izin->jml_jam    = null;
            $izin->tgl_mulai      = \Carbon\Carbon::createFromFormat("d/m/Y", $request->tgl_mulai)->format("Y-m-d");
            $izin->tgl_selesai    = \Carbon\Carbon::createFromFormat("d/m/Y", $request->tgl_selesai)->format("Y-m-d");
            // $izin->jml_hari       = null;
            // $izin->saldohakcuti   = null;
            // $izin->sisacuti       = null;
            // $izin->keterangan     = $jenisizin->jenis_izin;
            // dd($izin->jmlharikerja, $izin->jml_hari, $izin->saldohakcuti,$izin->sisacuti);
        }
        elseif($request->id_jenisizin == 4)
        {
            $izin->jam_mulai = null;
            $izin->jam_selesai= null;
            $izin->jml_jam    = null;
            $izin->tgl_mulai      = \Carbon\Carbon::createFromFormat("d/m/Y", $request->tgl_mulai)->format("Y-m-d");
            $izin->tgl_selesai    = \Carbon\Carbon::createFromFormat("d/m/Y", $request->tgl_selesai)->format("Y-m-d");
            // $izin->jml_hari       = null;
            // $izin->saldohakcuti   = null;
            // $izin->sisacuti       = null;
            // $izin->keterangan     = $jenisizin->jenis_izin;
            // dd($izin->jmlharikerja, $izin->jml_hari, $izin->saldohakcuti,$izin->sisacuti);
        }
        elseif($request->id_jenisizin == 5)
        {

            $izin->jam_mulai = $request->jam_mulai;
            $izin->jam_selesai= $request->jam_selesai;

            $jammulai  = Carbon::parse($request->jam_mulai);
            $jamselesai= Carbon::parse($request->jam_selesai);
            $time_range= $jamselesai->diff($jammulai)->format("%H:%I");

            $izin->jml_jam     = $time_range;
            $izin->tgl_mulai      = \Carbon\Carbon::createFromFormat("d/m/Y", $request->tgl_mulai)->format("Y-m-d");
            $izin->tgl_selesai    = null;
            // return $izin->jml_jam;
        }
        else{
            return redirect()->back();
        }

        // dd($izin,$request->all());
        $izin->update();
        // dd($izin);

        // return $izin;
        
        $emailkry = DB::table('izin')->join('karyawan','izin.id_karyawan','=','karyawan.id')
            ->join('departemen','izin.departemen','=','departemen.id')
            ->where('izin.id_karyawan','=',$izin->id_karyawan)
            ->select('karyawan.email','karyawan.nama','izin.*','karyawan.atasan_pertama','karyawan.atasan_kedua','karyawan.nama_jabatan','departemen.nama_departemen')
            ->first();
        
        $jenisizin = Jenisizin::where('id',$izin->id_jenisizin)->first();
        //atasan pertama
        $atasan = Karyawan::where('id',$emailkry->atasan_pertama)
            ->select('email as email','nama as nama','nama_jabatan as jabatan')
            ->first();
        $atasan2 = Karyawan::where('id',$emailkry->atasan_kedua)
            ->select('email as email','nama as nama','nama_jabatan as jabatan')
            ->first();
    
        $tujuan = $atasan->email;
        $data = [
            'subject' => 'Notifikasi Perubahan Permohonan ' . $jenisizin->jenis_izin . ' ' . '#'. $izin->id. ' ' . ucwords(strtolower($emailkry->nama)) ,
            'title'  => 'NOTIFIKASI PERSETUJUAN PERMOHONAN IZIN KARYAWAN',
            'subtitle'=> '[ PERSETUJUAN PERUBAHAN DATA ]',
            'noregistrasi' => $izin->id,
            'tgl_permohonan' =>Carbon::parse($emailkry->tgl_permohonan)->format("d/m/Y"),
            'nik' => $emailkry->nik,
            'namakaryawan' => ucwords(strtolower($emailkry->nama)),
            'jabatankaryawan' => $emailkry->nama_jabatan,
            'departemen' => $emailkry->nama_departemen,
            'karyawan_email' =>  $emailkry->email,
            'id_jeniscuti' => $jenisizin->jenis_izin,
            'keperluan' => $izin->keperluan,
            'tgl_mulai' => Carbon::parse($izin->tgl_mulai)->format("d/m/Y"),
            'tgl_selesai' => Carbon::parse($izin->tgl_selesai)->format("d/m/Y"),
            'tgldisetujuiatasan'=> "-",
            'tgldisetujuipimpinan' => "-",
            'tglditolak' => "-",
            'jml_cuti' => $izin->jml_hari,
            'status' => $status->name_status,
            'statuss' => $status->id,
            'jabatan' => $atasan->jabatan,
            'nama_atasan' => $atasan->nama,
            'role' => $role,
            'atasan2' => $atasan2->email,
        ];
        // return $data;
        // return $tujuan;
        Mail::to($tujuan)->send(new PerubahanNotification($data));
        // return $data;
        // } else {
        //     // proses jika data atasan tidak ada / email tidak ada
        // }

        return redirect()->back()->with('success','Email Notifikasi Perubahan Data Permohonan Izin Berhasil Dikirim');
    }
}
