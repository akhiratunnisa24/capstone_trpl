<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use App\Models\Karyawan;
use App\Models\Sisacuti;
use App\Models\Jeniscuti;
use Illuminate\Http\Request;
use App\Models\SettingOrganisasi;
use App\Mail\SisacutiNotification;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SisacutiController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;
        if ($role == 1 || $role == 2)
        {
            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
            $sisacuti = Sisacuti::all();

            return view('admin.sisacuti.index', compact('sisacuti','row'));

        } else {
            return redirect()->back()->with('error','Anda tidak memiliki hak akses');
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
            ->select('sisacuti.id_pegawai as id','karyawan.id as id_karyawan','karyawan.partner','karyawan.email as email','karyawan.nama as nama','sisacuti.id_jeniscuti as jeniscuti','jeniscuti.jenis_cuti as kategori','sisacuti.sisa_cuti as sisa','sisacuti.periode as tahun')
            ->first();

        $partner = $sisacuti->partner;

        $settingorganisasi = SettingOrganisasi::where('partner',$partner)->first();

        $hrdmanager = User::where('partner',$partner->id)->where('role',1)->first();
        if($hrdmanager !== null){
            $hrdmng = $hrdmanager->karyawans->email;
        }

        $hrdstaff   = User::where('partner',$partner->id)->where('role',2)->first();
        if($hrdstaff !== null){
            $hrdstf = $hrdstaff->karyawans->email;
        }

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

            if($settingorganisasi !== NULL)
            {
                $data['emailperusahaan'] = $settingorganisasi->email;
                $data['notelp_perusahaan'] = $settingorganisasi->no_telp;
            }

            if($hrdmng !== null)
            {
                $data['hrdmanager'] = $hrdmng;
            }

            if($hrdstf !== null)
            {
                $data['hrdstaff'] = $hrdstf;
            }

            Mail::to($tujuan)->send(new SisacutiNotification($data));

        }
        return redirect()->back()->with('success','Email berhasil dikirim');

    }

}
