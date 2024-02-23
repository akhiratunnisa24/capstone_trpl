<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Departemen;
use App\Models\Resign;
use App\Models\Status;
use App\Models\Karyawan;
use App\Models\Tidakmasuk;
use App\Models\User;
use App\Mail\ResignNotification;
use App\Mail\ResignTolakNotification;
use App\Mail\ResignApproveNotification;
use App\Mail\ResignAtasan2Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Input;

class ResignAdminController extends Controller
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
    public function index(Request $request)
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();

        $karyawan = karyawan::where('id', Auth::user()->id_pegawai)->first();

        $karyawan1 = Karyawan::where('status_kerja', 'Aktif')
                     ->where('partner', Auth::user()->partner)
                     ->whereNotIn('id', function($query) {
                         $query->select('id_karyawan')->from('resign');
                     })->get();

        // $karyawan1 = Karyawan::where('status_kerja','Aktif')
        //               ->whereNotIn('id', function($query){
        //                   $query->select('id_karyawan')->from('resign');
        //               })->get();

        $idkaryawan = $request->id_karyawan;
        // dd($karyawan);
        $resign = Resign::join('karyawan', 'resign.id_karyawan','karyawan.id')
            ->where('karyawan.partner',Auth::user()->partner)
            ->select('resign.*')
            ->orderBy('resign.created_at', 'desc')->get();

        // $tes = Auth::user()->karyawan->departemen->nama_departemen;


        return view('admin.resign.index', compact('karyawan','karyawan1','resign','row'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $karyawan = Auth::user()->id_pegawai;
        // $status = Status::find(4);
        // $tes = DB::table('karyawan')
        //     ->join('departemen','karyawan.divisi','=','departemen.id')
        //     ->where('karyawan.id', )
        //     ->select('departemen.id as id_dep')
        //     ->first();

        //     $resign = New Resign;
        //     $resign->id_karyawan = $request->namaKaryawan;
        //     $resign->departemen = $request->departemen;
        //     $resign->tgl_masuk = Carbon::parse($request->tgl_masuk)->format("Y-m-d");
        //     $resign->tgl_resign  = Carbon::parse($request->tgl_resign)->format("Y-m-d");
        //     $resign->tipe_resign = $request->tipe_resign;
        //     $resign->alasan      = $request->alasan;
        //     $resign->status      = $status->id;

        //     $resign->save();
        //     return redirect()->back();

        // $partner = Auth::user()->partner;
        // mendapatkan id karyawan yang sedang login
        $karyawan = Auth::user()->id_pegawai;

        // mendapatkan data status resign dengan id = 8
        $status = Status::find(4);

        // mendapatkan id departemen karyawan yang sedang login
        $tes = DB::table('karyawan')
            ->join('departemen','karyawan.divisi','=','departemen.id')
            ->where('karyawan.id', )
            ->select('departemen.id as id_dep')
            ->first();

        // menyimpan file pdf ke dalam folder public/pdf
        $file = $request->file('filepdf');
        $filename = time() . '-' . $file->getClientOriginalName(); // mendapatkan nama asli file
        $file->move(public_path('pdf'), $filename);

        // menyimpan data resign ke dalam database
        $resign = new Resign;
        $resign->id_karyawan = $request->namaKaryawan;
        $resign->departemen = $request->departemen;
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

        $partner = $emailkry->partner;

        $hrdmanager = User::where('partner',$partner->id)->where('role',1)->first();
        if($hrdmanager !== null){
            $hrdmng = $hrdmanager->karyawans->email;
        }

        $hrdstaff   = User::where('partner',$partner->id)->where('role',2)->first();
        if($hrdstaff !== null){
            $hrdstf = $hrdstaff->karyawans->email;
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

        if($hrdmng !== null)
        {
            $data['hrdmanager'] = $hrdmng;
        }

        if($hrdstf !== null)
        {
            $data['hrdstaff'] = $hrdstf;
        }
        Mail::to($tujuan)->send(new ResignNotification($data));
        // dd($data);

        return redirect()->back()->with('success', 'Permohonan Resign Berhasil Dibuat dan Email Notifikasi Berhasil Dikirim');

        // return redirect()->back();

    }

    public function show($id)
    {

        $resign = Resign::findOrFail($id);
        return view('admin.resign.index',compact('resign','karyawan'));
    }

    public function approve_atasan2( $id)
    {
        $resign = Resign::where('id',$id)->first();
        Resign::where('id',$id)->update([
            'status' => 7,
        ]);

        $sk = Karyawan::where('id',$resign->id_karyawan);
        $resign1 = Resign::where('id',$id)->first();
        // dd($resign1);
        // if ($resign1->tgl_resign <= Carbon::now()) {
        //     $sk->status_kerja = 'Non-Aktif';
        // }
        $emailkry = DB::table('resign')
            ->join('karyawan', 'resign.id_karyawan', '=', 'karyawan.id')
            ->join('departemen', 'resign.departemen', '=', 'departemen.id')
            ->where('resign.id_karyawan', '=', $resign->id_karyawan)
            ->select('karyawan.email','karyawan.partner', 'karyawan.nip', 'karyawan.nama', 'resign.*', 'karyawan.atasan_pertama', 'karyawan.atasan_kedua', 'karyawan.nama_jabatan', 'departemen.nama_departemen')
            ->first();
        // dd($emailkry);
        $atasan1 = Karyawan::where('id',$emailkry->atasan_pertama)
                        ->select('email as email','nama as nama','nama_jabatan as jabatan','divisi as departemen')
                        ->first();

        $atasan2 = NULL;
            if($emailkry->atasan_kedua !== NULL)
        {
            $atasan2 = Karyawan::where('id',$emailkry->atasan_kedua)
                    ->select('email as email','nama as nama','nama_jabatan as jabatan','divisi as departemen')
                    ->first();
        }
        $tujuan = $emailkry->email;
        $alasan ='';

        $partner = $emailkry->partner;

        $hrdmanager = User::where('partner',$partner)->where('role',1)->first();
        if($hrdmanager !== null){
            $hrdmng = Karyawan::where('id',$hrdmanager->id_pegawai)->first();
            $hrdmng = $hrdmng->email;
        }

        $data = [
            'subject' => 'Notifikasi Resign Disetujui ' . ' ' . '#' . $resign->id . ' ' . $emailkry->nama,
            'noregistrasi' => $resign->id,
            'title'  => 'NOTIFIKASI PERSETUJUAN FORMULIR RESIGN KARYAWAN',
            'subtitle' => '',
            'tgl_permohonan' => Carbon::parse($resign->tgl_resign)->format("d/m/Y"),
            'nik' => $emailkry->nip,
            'namakaryawan' => $emailkry->nama,
            'jabatankaryawan' => $emailkry->nama_jabatan,
            'departemen' => $emailkry->nama_departemen,
            'karyawan_email' =>  $emailkry->email,
            'atasan1'=> $atasan1->email,
            'tgl_persetujuan' => Carbon::parse($resign->updated_at)->format("d/m/Y"),
            // 'id_jeniscuti' => $jeniscuti->jenis_cuti,
            'alasan' => $resign->alasan,
            // 'tgl_mulai' => Carbon::parse($cuti->tgl_mulai)->format("d/m/Y"),
            // 'tgl_resign' => Carbon::parse($resign->tgl_resign)->format("d/m/Y"),
            // 'jml_cuti' => $cuti->jml_cuti,
            // 'status' => $status->name_status,
            'jabatan' => $atasan1->jabatan,
            'nama_atasan' => $atasan1->nama,
        ];
        if($atasan2 !== NULL){
            $data['atasan2'] = $atasan2->email;
            $data['namaatasan2'] = $atasan2->nama;
        }

        if($hrdmng !== null)
        {
            $data['hrdmanager'] = $hrdmng;
        }

        $hrdstaff   = User::where('partner',$partner)->where('role',2)->first();
        $data['hrdstaff'] = null;
        if($hrdstaff !== null){
            $hrdstf = Karyawan::where('id',$hrdstaff->id_pegawai)->first();
            $hrdstf = $hrdstf->email;

            if($hrdstf !== null)
            {
                $data['hrdstaff'] = $hrdstf;
            }
        }

        Mail::to($tujuan)->send(new ResignApproveNotification($data));

        return redirect()->back()->withInput()->with('success','Permintaan Resign dari ' . $emailkry->nama . ' disetujui');
    }

    public function approve_atasan1($id)
    {
        $resign = Resign::where('id',$id)->first();
        Resign::where('id',$id)->update([
            'status' =>6,
        ]);
        // dd($resign);
        $emailkry = DB::table('resign')
        ->join('karyawan', 'resign.id_karyawan', '=', 'karyawan.id')
        ->join('departemen', 'resign.departemen', '=', 'departemen.id')
        ->where('resign.id_karyawan', '=', $resign->id_karyawan)
        ->select('karyawan.email','karyawan.nip', 'karyawan.nama', 'resign.*', 'karyawan.atasan_pertama', 'karyawan.atasan_kedua', 'karyawan.nama_jabatan', 'departemen.nama_departemen')
        ->first();
        // dd($emailkry);
       //atasan kedua

       $atasan = NULL;
       if($emailkry->atasan_kedua !== NULL)
       {
           $atasan = Karyawan::where('id',$emailkry->atasan_kedua)
               ->select('email as email','nama as nama','nama_jabatan as jabatan')
               ->first();
       }

       //atasan pertama
       $atasan1 = Auth::user()->email;

       //ambil data karyawan
       // $tujuan = $atasan->email;
       $tujuan =$atasan->email ?? null;

        $data = [
            'subject' => 'Notifikasi Approval Pertama Permohonan' . ' ' . '#' . $resign->id . ' ' . ucwords(strtolower($emailkry->nama)),
            'noregistrasi' => $resign->id,
            'title'  => 'NOTIFIKASI PERSETUJUAN PERTAMA FORMULIR RESIGN KARYAWAN',
            'subtitle' => '[PERSETUJUAN ATASAN]',
            'tgl_permohonan' => Carbon::parse($resign->tgl_resign)->format("d/m/Y"),
            'nik' => $emailkry->nip,
            'namakaryawan' => $emailkry->nama,
            'jabatankaryawan' => $emailkry->nama_jabatan,
            'departemen' => $emailkry->nama_departemen,
            'karyawan_email' =>  $emailkry->email,
            'tgl_persetujuan' => Carbon::parse($resign->updated_at)->format("d/m/Y"),
            // 'id_jeniscuti' => $jeniscuti->jenis_cuti,
            'alasan' => $resign->alasan,
            // 'tgl_mulai' => Carbon::parse($cuti->tgl_mulai)->format("d/m/Y"),
            // 'tgl_resign' => Carbon::parse($resign->tgl_resign)->format("d/m/Y"),
            // 'jml_cuti' => $cuti->jml_cuti,
            // 'status' => $status->name_status,
            'jabatan' => $atasan->jabatan,
            'nama_atasan' => $atasan->nama,
        ];
        if($atasan !== NULL){
            $data['namaatasan2'] = $atasan->nama;
            $data['atasan2']     = $atasan->email;
        }
        Mail::to($tujuan)->send(new ResignAtasan2Notification($data));
        // dd($resign);
        return redirect()->back()->withInput()->with('success','Permintaan Resign dari ' . $emailkry->nama . ' disetujui');
    }

    public function reject( $id)
    {
        $resign = Resign::where('id',$id)->first();
        Resign::where('id',$id)->update([
            'status' => 5,
        ]);

        $emailkry = DB::table('resign')
            ->join('karyawan', 'resign.id_karyawan', '=', 'karyawan.id')
            ->join('departemen', 'resign.departemen', '=', 'departemen.id')
            ->where('resign.id_karyawan', '=', $resign->id_karyawan)
            ->select('karyawan.email','karyawan.partner', 'karyawan.nip', 'karyawan.nama', 'resign.*', 'karyawan.atasan_pertama', 'karyawan.atasan_kedua', 'karyawan.nama_jabatan', 'departemen.nama_departemen')
            ->first();
        // dd($emailkry);
        $atasan1 = Karyawan::where('id',$emailkry->atasan_pertama)
                        ->select('email as email','nama as nama','nama_jabatan as jabatan','divisi as departemen')
                        ->first();

        $atasan2 = NULL;
            if($emailkry->atasan_kedua !== NULL)
        {
            $atasan2 = Karyawan::where('id',$emailkry->atasan_kedua)
                    ->select('email as email','nama as nama','nama_jabatan as jabatan','divisi as departemen')
                    ->first();
        }
        $tujuan = $emailkry->email;
        $alasan ='';

        $partner = $emailkry->partner;

        $hrdmanager = User::where('partner',$partner)->where('role',1)->first();
        if($hrdmanager !== null){
            $hrdmng = Karyawan::where('id',$hrdmanager->id_pegawai)->first();
            $hrdmng = $hrdmng->email;
        }

        $data = [
            'subject' => 'Notifikasi Resign Ditolak ' . ' ' . '#' . $resign->id . ' ' . $emailkry->nama,
            'noregistrasi' => $resign->id,
            'title'  => 'NOTIFIKASI PERSETUJUAN FORMULIR RESIGN KARYAWAN',
            'subtitle' => '',
            'tgl_permohonan' => Carbon::parse($resign->tgl_resign)->format("d/m/Y"),
            'nik' => $emailkry->nip,
            'namakaryawan' => $emailkry->nama,
            'jabatankaryawan' => $emailkry->nama_jabatan,
            'departemen' => $emailkry->nama_departemen,
            'karyawan_email' =>  $emailkry->email,
            'atasan1'=> $atasan1->email,
            'tglditolak' => Carbon::parse($resign->updated_at)->format("d/m/Y"),
            // 'id_jeniscuti' => $jeniscuti->jenis_cuti,
            'alasan' => $resign->alasan,
            // 'tgl_mulai' => Carbon::parse($cuti->tgl_mulai)->format("d/m/Y"),
            // 'tgl_resign' => Carbon::parse($resign->tgl_resign)->format("d/m/Y"),
            // 'jml_cuti' => $cuti->jml_cuti,
            'status' => $resign->name_status,
            'jabatan' => $atasan1->jabatan,
            'nama_atasan' => $atasan1->nama,
        ];
        if($atasan2 !== NULL){
            $data['atasan2'] = $atasan2->email;
            $data['namaatasan2'] = $atasan2->nama;
        }

        if($hrdmng !== null)
        {
            $data['hrdmanager'] = $hrdmng;
        }

        $hrdstaff   = User::where('partner',$partner)->where('role',2)->first();
        $data['hrdstaff'] = null;
        if($hrdstaff !== null){
            $hrdstf = Karyawan::where('id',$hrdstaff->id_pegawai)->first();
            $hrdstf = $hrdstf->email;

            if($hrdstf !== null)
            {
                $data['hrdstaff'] = $hrdstf;
            }
        }

        Mail::to($tujuan)->send(new ResignTolakNotification($data));

        return redirect()->back()->withInput()->with('error','Permintaan Resign dari ' . $emailkry->nama . ' ditolak');
    }

    public function getUserData($id)
    {
        $user = Karyawan::with('Departemen')->find($id);
        return response()->json($user);
    }

    public function destroy($id)
    {
        $resigndelete = Resign::find($id);
        $resigndelete->delete();

        return redirect()->back()->with('success','Data berhasil dihapus');
    }

}
