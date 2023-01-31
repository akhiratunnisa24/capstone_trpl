<?php

namespace App\Http\Controllers\admin;

use App\Models\Izin;
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
        $status = 'Disetujui';
        Izin::where('id',$id)->update([
            'status' => $status,
        ]);
        $izin = DB::table('izin')
            ->join('jenisizin','izin.id_jenisizin','=','jenisizin.id')
            ->where('izin.id',$id)
            ->select('izin.*','jenisizin.jenis_izin as jenis_izin')
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
            'status'   =>$izin->status,
        ];
        Mail::to($tujuan)->send(new IzinApproveNotification($data));
        return redirect()->route('permintaancuti.index',['type'=>2]);
    }

    public function reject(Request $request, $id)
    {
        $izin = Izin::where('id',$id)->first();
        $status = 'Ditolak';
        Izin::where('id',$id)->update([
            'status' => $status,
        ]);
        return redirect()->route('permintaancuti.index',['type'=>2])->withInput();
    }
}
