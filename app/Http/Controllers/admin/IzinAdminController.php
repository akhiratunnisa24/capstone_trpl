<?php

namespace App\Http\Controllers\admin;

use App\Models\Izin;
use App\Models\Status;
use App\Models\Datareject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\IzinApproveNotification;

class IzinAdminController extends Controller
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
    
    public function show($id)
    {
        $izin = Izin::findOrFail($id);
        $karyawan = Auth::user()->id_pegawai;
 
        return view('admin.cuti.index',compact('izin','karyawan',['type'=>2]));
    }

    public function approved(Request $request, $id)
    {
        $role = Auth::user()->role;
        $status = Status::find(7);
        Izin::where('id',$id)->update([
            'status' => $status->id,
        ]);
        $izin = DB::table('izin')
            ->join('jenisizin','izin.id_jenisizin','=','jenisizin.id')
            ->join('statuses','izin.status','=','statuses.id')
            ->where('izin.id',$id)
            ->select('izin.*','jenisizin.jenis_izin as jenis_izin','statuses.name_status')
            ->first();

        $karyawan = DB::table('izin')
            ->join('karyawan','izin.id_karyawan','=','karyawan.id')
            ->where('izin.id',$izin->id)
            ->select('karyawan.email as email','karyawan.nama as nama')
            ->first();
        // $tujuan = $karyawan->email;
        $tujuan = 'akhiratunnisahasanah0917@gmail.com';
        $data = [
            'title'    =>$izin->id,
            'subject'  =>'Notifikasi Izin',
            'id'       =>$izin->id,
            'nama'     =>$karyawan->nama,
            'jenisizin'=>$izin->jenis_izin,
            'tgl_mulai'=>$izin->tgl_mulai,
            'status'   =>$izin->name_status,
        ];
        Mail::to($tujuan)->send(new IzinApproveNotification($data));
        return redirect()->route('permintaancuti.index',['type'=>2]);
    }

    public function reject(Request $request, $id)
    {
        $status = Status::find(5);
        Izin::where('id',$id)->update([
            'status' => $status->id,
        ]);
        $izin = Izin::where('id',$id)->first();
        $datareject          = new Datareject;
        $datareject->id_cuti = NULL;
        $datareject->id_izin = $izin->id;
        $datareject->alasan  = $request->alasan;
        $datareject->save(); 
        
         //----SEND EMAIL KE KARYAWAN -------
        //ambil nama jeniscuti
        $izin = DB::table('izin')
            ->join('jenisizin','izin.id_jenisizin','=','jenisizin.id')
            ->join('statuses','izin.status','=','statuses.id')
            ->where('izin.id',$id)
            ->select('izin.*','jenisizin.jenis_izin as jenis_izin','statuses.name_status')
            ->first();
        $karyawan = DB::table('izin')
            ->join('karyawan','izin.id_karyawan','=','karyawan.id')
            ->where('izin.id',$izin->id)
            ->select('karyawan.email as email','karyawan.nama as nama')
            ->first(); 
         //$tujuan = 'akhiratunnisahasanah0917@gmail.com';
         $tujuan = $karyawan->email;
         $data = [
             'title'    =>$izin->id,
             'subject'  =>'Notifikasi Izin',
             'id'       =>$izin->id,
             'nama'     =>$karyawan->nama,
             'jenisizin'=>$izin->jenis_izin,
             'tgl_mulai'=>$izin->tgl_mulai,
             'status'   =>$izin->name_status,
         ];
        Mail::to($tujuan)->send(new IzinApproveNotification($data));
        return redirect()->route('permintaancuti.index',['type'=>2])->withInput();
    }
}
