<?php

namespace App\Http\Controllers\karyawan;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Resign;
use App\Models\Status;
use App\Models\Karyawan;
use App\Models\Departemen;
use App\Models\Tidakmasuk;
use Illuminate\Http\Request;
use App\Mail\ResignNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResignApproveNotification;
use App\Mail\ResignAtasan2Notification;

class ResignController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $jumlah_resign = Resign::where('id_karyawan', Auth::user()->id_pegawai)->count();
        $status0 = 0;
        $status1 = 0;
        if ($jumlah_resign > 0) {
            $resign0 = Resign::where('id_karyawan', Auth::user()->id_pegawai)->orderBy('id', 'asc')->first();
            $status0 = $resign0->status ?? 0;
            if ($jumlah_resign > 1) {
                $resign1 = Resign::where('id_karyawan', Auth::user()->id_pegawai)->orderBy('id', 'asc')->skip(1)->first();
                $status1 = $resign1->status ?? 0;
            }
        }

        $karyawan = karyawan::where('id', Auth::user()->id_pegawai)->first();
        // dd($karyawan);
        $resign = Resign::orderBy('created_at', 'desc')->get();

        // $tes = Auth::user()->karyawan->divisi;
        $tes = DB::table('karyawan')
            ->join('departemen','karyawan.divisi','=','departemen.id')
            ->where('karyawan.id', Auth::user()->id_pegawai)
            ->select('departemen.id as id_dep','departemen.nama_departemen as departemen')
            ->first();

            return view('karyawan.resign.index', compact('karyawan','tes','resign','row','status0', 'status1','jumlah_resign'));
    }

    public function store(Request $request)
    {
        // $karyawan = Auth::user()->id_pegawai;
        // $status = Status::find(8);
        // $tes = DB::table('karyawan')
        //     ->join('departemen','karyawan.divisi','=','departemen.id')
        //     ->where('karyawan.id', Auth::user()->id_pegawai)
        //     ->select('departemen.id as id_dep')
        //     ->first();

        // $resign = New Resign;
        // $resign->id_karyawan = $karyawan;
        // $resign->departemen = $tes->id_dep;
        // $resign->tgl_masuk = Carbon::parse($request->tgl_masuk)->format("Y-m-d");
        // $resign->tgl_resign  = Carbon::parse($request->tgl_resign)->format("Y-m-d");
        // $resign->tipe_resign = $request->tipe_resign;
        // $resign->alasan      = $request->alasan;
        // $resign->status      = $status->id;

        // // Upload file PDF
        // if ($request->hasFile('filepdf')) {
        //     $file = $request->file('filepdf');
        //     $filename = time() . '.' . $file->getClientOriginalExtension();
        //     $path = public_path('pdf/' . $filename);
        //     $file->move('pdf/', $filename);

        //     $resign->filepdf = $filename;
        // }

        // $resign->save();
        // return redirect()->back();

        // $partner = Auth::user()->partner;
        // mendapatkan id karyawan yang sedang login
        $karyawan = Auth::user()->id_pegawai;

        // mendapatkan data status resign dengan id = 8
        $status = Status::find(8);

        // mendapatkan id departemen karyawan yang sedang login
        $tes = DB::table('karyawan')
            ->join('departemen','karyawan.divisi','=','departemen.id')
            ->where('karyawan.id', Auth::user()->id_pegawai)
            ->select('departemen.id as id_dep')
            ->first();

        // menyimpan file pdf ke dalam folder public/pdf
        $file = $request->file('filepdf');
        $filename = time() . '-' . $file->getClientOriginalName(); // mendapatkan nama asli file
        $file->move(public_path('pdf'), $filename);

        // menyimpan data resign ke dalam database
        $resign = new Resign;
        $resign->id_karyawan = $karyawan;
        $resign->departemen = $tes->id_dep;
        $resign->tgl_masuk = Carbon::createFromFormat('d/m/Y', $request->tgl_masuk)->format("Y-m-d");
        $resign->tgl_resign = Carbon::createFromFormat('d/m/Y', $request->tgl_resign)->format("Y-m-d");
        $resign->tipe_resign = $request->tipe_resign;
        $resign->alasan      = $request->alasan;
        $resign->status      = 1;
        $resign->filepdf     = $filename; // menyimpan nama file di kolom filepdf
        // $resign->partner     = $partner;

        $resign->save();
        $emailkry = DB::table('resign')
            ->join('karyawan', 'resign.id_karyawan', '=', 'karyawan.id')
            ->join('departemen', 'resign.departemen', '=', 'departemen.id')
            ->where('resign.id_karyawan', '=', $resign->id_karyawan)
            ->select('karyawan.email','karyawan.partner','karyawan.nip', 'karyawan.nama', 'resign.*', 'karyawan.atasan_pertama', 'karyawan.atasan_kedua', 'karyawan.nama_jabatan', 'departemen.nama_departemen')
            ->first();
        // dd($emailkry);
        $atasan = Karyawan::where('id', $emailkry->atasan_pertama)
            ->select('email as email', 'nama as nama', 'nama_jabatan as jabatan')
            ->first();

        $atasan2 = NULL;
        if($emailkry->atasan_kedua != NULL)
        {
            $atasan2 = Karyawan::where('id', $emailkry->atasan_kedua)
                ->select('email as email', 'nama as nama', 'nama_jabatan as jabatan')
                ->first();
        }
        $tujuan = $atasan->email;
        // dd($tujuan);
        $partner = $emailkry->partner;
        $hrdmanager = User::where('partner',$partner)->where('role',1)->first();
        if($hrdmanager !== null){
            $hrdmng = Karyawan::where('id',$hrdmanager->id_pegawai)->first();
            $hrdmng = $hrdmng->email;
        }

        $data = [
            'subject' => 'Notifikasi Permohonan ' . ' ' . '#' . $resign->id . ' ' . ucwords(strtolower($emailkry->nama)),
            'noregistrasi' => $resign->id,
            'title'  => 'NOTIFIKASI PERSETUJUAN FORMULIR RESIGN KARYAWAN',
            'subtitle' => '',
            'tgl_permohonan' => Carbon::parse($resign->tgl_resign)->format("d/m/Y"),
            'nik' => $emailkry->nip,
            'namakaryawan' => $emailkry->nama,
            'jabatankaryawan' => $emailkry->nama_jabatan,
            'departemen' => $emailkry->nama_departemen,
            'karyawan_email' =>  $emailkry->email,
            // 'id_jeniscuti' => $jeniscuti->jenis_cuti,
            'alasan' => $resign->alasan,
            'tgl_persetujuan' => Carbon::parse($resign->updated_at)->format("d/m/Y"),
            // 'tgl_mulai' => Carbon::parse($cuti->tgl_mulai)->format("d/m/Y"),
            // 'tgl_resign' => Carbon::parse($resign->tgl_resign)->format("d/m/Y"),
            // 'jml_cuti' => $cuti->jml_cuti,
            // 'status' => $status->name_status,
            'jabatan' => $atasan->jabatan,
            'nama_atasan' => $atasan->nama,
        ];
        if($atasan2 !== NULL){
            $data['atasan2'] = $atasan2->email;
        }
        //  dd($data);
        if($hrdmng !== null)
        {
            $data['hrdmanager'] = $hrdmng;
        }

        $hrdstaff   = User::where('partner',$partner)->where('role',2)->first();
        $data['hrdstaff'] = null;
        if($hrdstaff !== null){
            $hrdstf = $hrdstaff->karyawans->email;
            if($hrdstf !== null)
            {
                $data['hrdstaff'] = $hrdstf;
            }
        }

        Mail::to($tujuan)->send(new ResignNotification($data));

        return redirect()->back()->with('success', 'Permohonan Resign Berhasil Dibuat dan Email Notifikasi Berhasil Dikirim');
    }

    public function show($id)
    {

        $resign = Resign::findOrFail($id);
        // $karyawan = Auth::user()->id_pegawai;

        return view('karyawan.resign.index',compact('resign','karyawan'));
    }

    public function delete($id)
        {
            Resign::destroy($id);
            return redirect()->back();

        }
}
