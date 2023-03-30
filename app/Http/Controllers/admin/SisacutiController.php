<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use App\Models\Karyawan;
use App\Models\Sisacuti;
use App\Models\Jeniscuti;
use Illuminate\Http\Request;
use App\Mail\SisacutiNotification;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SisacutiController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;
        if ($role == 1) 
        {
            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
            $sisacuti = Sisacuti::where('sisa_cuti','!=',0)->get();
            
            return view('admin.sisacuti.index', compact('sisacuti','row'));

        } else {
    
            return redirect()->back();
        }
       
    }

    public function sendEmail($id)
    {
        // dd($id);
        $jeniscuti = Jeniscuti::find(1);
        $sisacuti = Sisacuti::leftjoin('karyawan','sisacuti.id_pegawai','=','karyawan.id')
            ->leftjoin('jeniscuti','jeniscuti.id','=','sisacuti.id_jeniscuti')
            ->where('sisacuti.id_jeniscuti',$jeniscuti->id)
            ->where('sisacuti.id_pegawai',$id)
            ->select('sisacuti.id_pegawai as id','karyawan.email as email','karyawan.nama as nama','sisacuti.id_jeniscuti as jeniscuti','jeniscuti.jenis_cuti as kategori','sisacuti.sisa_cuti as sisa','sisacuti.periode as tahun')
            ->first();
        // dd($email);
        foreach($sisacuti as $sisa){
            $tujuan = $sisa->email;

            $data = [
                'subject'     => 'Notifikasi Sisa Cuti Tahunan Tahun Sebelumnya',
                'id'          => $sisa->id,
                'kategori'    => $sisa->kategori,
                'nama'        => $sisa->nama,
                'tahun'       => $sisa->tahun,
                'sisacuti'    => $sisa->sisa,
            ];
            Mail::to($tujuan)->send(new SisacutiNotification($data));
            
        }
        return redirect()->back();
        
    }
    
}
