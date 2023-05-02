<?php

namespace App\Http\Controllers\admin;

use PDF;
use Carbon\Carbon;
use App\Models\Izin;
use App\Models\Status;
use App\Models\Karyawan;
use App\Models\Jenisizin;
use App\Models\Datareject;
use App\Exports\IzinExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Mail\IzinApproveNotification;
use App\Mail\IzinAtasan2Notification;
use App\Mail\CutiIzinTolakNotification;




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

     public function index(Request $request)
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $role = Auth::user()->role; 
        if ($role == 1) 
        {
            $type = $request->query('type', 1);

            $karyawan = Karyawan::where('id','!=',Auth::user()->id_pegawai)->get();

            // Filter Data Cuti
            $karyawann = Karyawan::all();
            $pegawais = Karyawan::all();

            $karyawan = Karyawan::all();
            $pegawai = Karyawan::all();

             // Filter Data Izin
             $idpegawai = $request->id_karyawan;
             $month = $request->query('month', Carbon::now()->format('m'));
             $year = $request->query('year', Carbon::now()->format('Y'));
 
             // simpan session
             $request->session()->put('idpegawai', $request->id_karyawan);
             $request->session()->put('month', $month);
             $request->session()->put('year', $year);
 
            if(isset($idpegawai) && isset($month) && isset($year)) 
            {
                $izin = DB::table('izin')->leftjoin('statuses','izin.status','=','statuses.id')
                    ->leftjoin('datareject','datareject.id_izin','=','izin.id')
                    ->leftjoin('karyawan', 'izin.id_karyawan', 'karyawan.id')
                    ->leftjoin('jenisizin','izin.id_jenisizin','=','jenisizin.id')
                    ->leftjoin('departemen','izin.departemen','=','departemen.id')
                    ->where('izin.id_karyawan', $idpegawai)
                    ->whereMonth('izin.tgl_mulai', $month)
                    ->whereYear('izin.tgl_mulai', $year)
                    ->select('izin.*','statuses.name_status','departemen.nama_departemen','jenisizin.jenis_izin','datareject.alasan as alasan','datareject.id_izin as id_izin','karyawan.atasan_pertama','karyawan.nama')
                    ->distinct()
                    ->orderBy('created_at','DESC')
                    ->get();
            }
            else
            {
                $izin =DB::table('izin')->leftjoin('statuses','izin.status','=','statuses.id')
                    ->leftjoin('datareject','datareject.id_izin','=','izin.id')
                    ->leftjoin('karyawan', 'izin.id_karyawan', 'karyawan.id')
                    ->leftjoin('jenisizin','izin.id_jenisizin','=','jenisizin.id')
                    ->leftjoin('departemen','izin.departemen','=','departemen.id')
                    ->select('izin.*','statuses.name_status','jenisizin.jenis_izin','departemen.nama_departemen','datareject.alasan as alasan','datareject.id_izin as id_izin','karyawan.atasan_pertama','karyawan.nama')
                    ->distinct()
                    ->orderBy('created_at','DESC')
                    ->get();
            };

            $cuti = DB::table('cuti')
                    ->leftjoin('alokasicuti', 'cuti.id_jeniscuti', 'alokasicuti.id_jeniscuti')
                    ->leftjoin('settingalokasi', 'cuti.id_jeniscuti', 'settingalokasi.id_jeniscuti')
                    ->leftjoin('jeniscuti', 'cuti.id_jeniscuti', 'jeniscuti.id')
                    ->leftjoin('karyawan', 'cuti.id_karyawan', 'karyawan.id')
                    ->leftjoin('statuses', 'cuti.status', '=', 'statuses.id')
                    ->leftjoin('datareject', 'datareject.id_cuti', '=', 'cuti.id')
                    ->leftjoin('departemen','cuti.departemen','=','departemen.id')
                    ->select('cuti.*', 'jeniscuti.jenis_cuti', 'departemen.nama_departemen', 'karyawan.nama','statuses.name_status', 'karyawan.atasan_pertama', 'karyawan.atasan_kedua', 'datareject.alasan as alasan', 'datareject.id_cuti as id_cuti')
                    ->distinct()
                    ->orderBy('created_at', 'DESC')
                    ->get();
        return view('admin.cuti.index', compact('izin','cuti','type','row','karyawann','karyawan','pegawais','role'));
        } else 
        {
            return redirect()->back(); 
        }
    }
    
    public function show($id)
    {
        $izin = Izin::findOrFail($id);
        $karyawan = Auth::user()->id_pegawai;
 
        return view('admin.cuti.index',compact('izin','karyawan',['type'=>2]));
    }

    public function approved(Request $request, $id)
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $role = Auth::user()->role;
        $izn = Izin::where('id',$id)->first();

        $izin = Izin::leftJoin('karyawan', 'izin.id_karyawan', '=', 'karyawan.id')
            ->where(function($query) use ($izn) {
                $query->where('izin.id_jenisizin', '=', $izn->id_jenisizin)
                    ->where('izin.id_karyawan', '=', $izn->id_karyawan);
            })
            ->where(function($query) use ($row) {
                $query->where('karyawan.atasan_pertama', '=', $row->id)
                    ->orWhere('karyawan.atasan_kedua', '=', $row->id);
            })
            ->select('izin.*', 'karyawan.nama', 'karyawan.atasan_pertama', 'karyawan.atasan_kedua')
            ->first();
        // return $izin;
        if($role == 1 && $izin && $izin->atasan_kedua == Auth::user()->id_pegawai)
        {
            $status = Status::find(7);
            Izin::where('id',$id)->update([
                'status' => $status->id,
                'tgl_setuju_b' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
            $izinn = Izin::where('id',$id)->first();
            $jenisizin = Jenisizin::where('id',$izinn->id_jenisizin)->first();

             //KIRIM EMAIL NOTIFIKASI KE KARYAWAN ATASAN 2 TINGKAT DAN HRD
            $emailkry = DB::table('izin')->join('karyawan','izin.id_karyawan','=','karyawan.id')
                ->join('departemen','izin.departemen','=','departemen.id')
                ->where('izin.id_karyawan','=',$izin->id_karyawan)
                ->select('karyawan.email','karyawan.nama','departemen.nama_departemen','karyawan.atasan_pertama','karyawan.atasan_kedua')
                ->first();
            $atasan1 = Karyawan::where('id',$emailkry->atasan_pertama)
                ->select('email as email','nama as nama','nama_jabatan as jabatan','divisi as departemen')
                ->first();
            $atasan2 = Auth::user()->email;
            $tujuan = $emailkry->email;

            $data = [
                'title'       =>$izinn->id,
                'subject'     =>'Notifikasi Izin Disetujui, Izin '  . $jenisizin->jenis_izin . ' #' . $izinn->id . ' ' . $emailkry->nama,
                'id'          =>$izinn->id,
                'noregistrasi'=>$izinn->id,
                'title' =>  'NOTIFIKASI PERSETUJUAN FORMULIR CUTI KARYAWAN',
                'subtitle' => '',
                'tgl_permohonan' =>Carbon::parse($izinn->tgl_permohonan)->format("d/m/Y"),
                'nik'         => $izinn->nik,
                'jabatankaryawan' => $izinn->jabatan,
                'departemen' => $emailkry->nama_departemen,
                'karyawan_email'=>$emailkry->email,
                'id_jenisizin'=>$izinn->jenis_izin,
                'atasan1'     =>$atasan1->email,
                'atasan2'     =>$atasan2,
                'jenisizin'   =>$jenisizin->jenis_izin,
                'keperluan'   =>$izinn->keperluan,
                'tgl_mulai'   =>Carbon::parse($izinn->tgl_mulai)->format("d/m/Y"),
                'tgl_selesai' =>Carbon::parse($izinn->tgl_selesai)->format("d/m/Y"),
                'jam_mulai'   =>Carbon::parse($izinn->jam_mulai)->format("H:i"),
                'jam_selesai' =>Carbon::parse($izinn->jam_selesai)->format("H:i"),
                'jml_hari'    =>$izinn->jml_hari,
                'tgldisetujuiatasan' =>Carbon::parse($izinn->tgl_setuju_b)->format("d/m/Y H:i"),
                'tgldisetujuipimpinan' => Carbon::parse($izinn->tgl_setuju_b)->format("d/m/Y H:i"),
                'jumlahjam'   =>$izinn->jml_jam,
                'status'      =>$status->name_status,
                'namakaryawan'=>$emailkry->nama,
                'namaatasan2' =>Auth::user()->name,
            ];
            // return $data;
            Mail::to($tujuan)->send(new IzinApproveNotification($data));
            return redirect()->route('cuti.Staff',['tp'=>2]);
        }
        elseif($role == 1 && $izin && $izin->atasan_pertama == Auth::user()->id_pegawai)
        {
            $status = Status::find(6);
            Izin::where('id',$id)->update([
                'status' => $status->id,
                'tgl_setuju_a' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);

            $izinn = Izin::where('id',$id)->first();
            $jenisizin = Jenisizin::where('id',$izinn->id_jenisizin)->first();

            //KIRIM NOTIFIKASI EMAIL KARYAWAN DAN ATASAN 2
            $emailkry = DB::table('izin')->join('karyawan','izin.id_karyawan','=','karyawan.id')
                ->join('departemen','izin.departemen','=','departemen.id')
                ->where('izin.id_karyawan','=',$izinn->id_karyawan)
                ->select('karyawan.email','karyawan.nama','departemen.nama_departemen','karyawan.atasan_pertama','karyawan.atasan_kedua')
                ->first();

            $atasan2 = Karyawan::where('id',$emailkry->atasan_kedua)
                ->select('email as email','nama as nama','nama_jabatan as jabatan','divisi as departemen')
                ->first();

            //email atasan kedua adalah tujuan utama
            $tujuan = $atasan2->email;
            $data = [
                'subject'     =>'Notifikasi Approval Pertama Permohonan Izin '  . $jenisizin->jenis_izin . ' #' . $izinn->id . ' ' . $emailkry->nama,
                'id'          =>$izinn->id,
                'noregistrasi'=>$izinn->id,
                'title' =>  'NOTIFIKASI PERSETUJUAN PERTAMA FORMULIR CUTI KARYAWAN',
                'subtitle' => '[PERSETUJUAN ATASAN]',
                'tgl_permohonan' =>Carbon::parse($izinn->tgl_permohonan)->format("d/m/Y"),
                'nik'         => $izinn->nik,
                'jabatankaryawan' => $izinn->jabatan,
                'departemen' => $emailkry->nama_departemen,
                'karyawan_email'=>$emailkry->email,
                'id_jenisizin'=> $jenisizin->jenis_izin,
                'keperluan'   =>$izinn->keperluan,
                'tgl_mulai'   =>Carbon::parse($izinn->tgl_mulai)->format("d/m/Y"),
                'tgl_selesai' =>Carbon::parse($izinn->tgl_selesai)->format("d/m/Y"),
                'jam_mulai'   =>Carbon::parse($izinn->jam_mulai)->format("H:i"),
                'jam_selesai' =>Carbon::parse($izinn->jam_selesai)->format("H:i"),
                'jml_hari'    =>$izinn->jml_hari,
                'jumlahjam'   =>$izinn->jml_jam,
                'status'      =>$status->name_status,
                'namakaryawan'=>ucwords(strtolower($emailkry->nama)),
                'tgldisetujuiatasan' =>  Carbon::parse($izinn->tgl_setuju_a)->format("d/m/Y H:i"),
                'namaatasan2' =>$atasan2->nama,
                'jabatanatasan'=>$atasan2->jabatan,
            ];
            Mail::to($tujuan)->send(new IzinAtasan2Notification($data));
            return redirect()->back()->withInput();
        }
        else{
            return redirect()->back();
        }
    }

    public function reject(Request $request, $id)
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $role = Auth::user()->role;

        $dataizin = Izin::leftjoin('karyawan','izin.id_karyawan','=','karyawan.id')
            ->where('izin.id', '=',$id)
            ->select('karyawan.atasan_pertama','karyawan.atasan_kedua')
            ->first();
        if($dataizin && $role == 1)
        {
            if($dataizin && $dataizin->atasan_kedua == Auth::user()->id_pegawai)
            {
                $status = Status::find(10);
                Izin::where('id',$id)->update([
                    'status' => $status->id,
                    'tgl_ditolak' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $izz = Izin::where('id',$id)->first();
    
                $datareject          = new Datareject;
                $datareject->id_cuti = NULL;
                $datareject->id_izin = $izz->id;
                $datareject->alasan  = $request->alasan;
                $datareject->save();   
        
                $izin = DB::table('izin')
                    ->join('jenisizin','izin.id_jenisizin','=','jenisizin.id')
                    ->join('statuses','izin.status','=','statuses.id')
                    ->where('izin.id',$id)
                    ->select('izin.*','jenisizin.jenis_izin as jenis_izin','statuses.name_status')
                    ->first();
                $alasan = Datareject::where('id_izin',$izin->id)->first();
        
                //KIRIM EMAIL KE KARAYWAN> 2 tingkat atasan
                $karyawan = DB::table('izin')
                    ->join('karyawan','izin.id_karyawan','=','karyawan.id')
                    ->join('departemen','izin.departemen','=','departemen.id')
                    ->where('izin.id',$izin->id)
                    ->select('karyawan.email as email','karyawan.nama as nama','departemen.nama_departemen','karyawan.atasan_pertama','karyawan.atasan_kedua')
                    ->first(); 
                $atasan2 = Karyawan::where('id',$karyawan->atasan_kedua)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
                $atasan1 = Karyawan::where('id',$karyawan->atasan_pertama)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
        
                $tujuan = $karyawan->email;
                $data = [
                    'subject'  =>'Notifikasi Permohonan Izin Ditolak, Izin ' . $izin->jenis_izin . ' #' . $izin->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$izin->id,
                    'tgl_permohonan' =>Carbon::parse($izin->tgl_permohonan)->format("d/m/Y"),
                    'title' =>  'NOTIFIKASI PERSETUJUAN FORMULIR IZIN KARYAWAN',
                    'subtitle' => '[ PENDING PIMPINAN ]',
                    'nik'         => $izin->nik,
                    'jabatankaryawan' => $izin->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'atasan2'     => $atasan2->email,
                    'karyawan_email'=>$karyawan->email,
                    'id_jenisizin'=>$izin->jenis_izin,
                    'keperluan'   =>$izin->keperluan,
                    'tgl_mulai'   =>Carbon::parse($izin->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' =>Carbon::parse($izin->tgl_selesai)->format("d/m/Y"),
                    'jam_mulai'   =>Carbon::parse($izin->jam_mulai)->format("H:i"),
                    'jam_selesai' =>Carbon::parse($izin->jam_selesai)->format("H:i"),
                    'status'   =>$status->name_status,
                    'jml_hari'    =>$izin->jml_hari,
                    'jumlahjam'   =>$izin->jml_jam,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'namaatasan2' =>$atasan2->nama,
                    'nama'        =>$karyawan->nama,
                    'kategori'   =>$izin->jenis_izin,
                    'alasan'      =>$alasan->alasan,
                    'tgldisetujuiatasan' => Carbon::parse($izin->tgl_setuju_a)->format("d/m/Y H:i"),
                    'tgldisetujuipimpinan' => '',
                    'tglditolak' => Carbon::parse($izin->tgl_ditolak)->format("d/m/Y H:i"),
                ];
                // dd($data);
                Mail::to($tujuan)->send(new CutiIzinTolakNotification($data));
                return redirect()->back()->withInput();
                
            }elseif($dataizin && $dataizin->atasan_pertama == Auth::user()->id_pegawai)
            {
                $status = Status::find(9);
                Izin::where('id',$id)->update([
                    'status' => $status->id,
                    'tgl_ditolak' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                $izz = Izin::where('id',$id)->first();
    
                $datareject          = new Datareject;
                $datareject->id_cuti = NULL;
                $datareject->id_izin = $izz->id;
                $datareject->alasan  = $request->alasan;
                $datareject->save();   
        
                $izin = DB::table('izin')
                    ->join('jenisizin','izin.id_jenisizin','=','jenisizin.id')
                    ->join('statuses','izin.status','=','statuses.id')
                    ->where('izin.id',$id)
                    ->select('izin.*','jenisizin.jenis_izin as jenis_izin','statuses.name_status')
                    ->first();
                $alasan = Datareject::where('id_izin',$izin->id)->first();
        
                //KIRIM EMAIL KE KARAYWAN> 2 tingkat atasan
                $karyawan = DB::table('izin')
                    ->join('karyawan','izin.id_karyawan','=','karyawan.id')
                    ->join('departemen','izin.departemen','=','departemen.id')
                    ->where('izin.id',$izin->id)
                    ->select('karyawan.email as email','departemen.nama_departemen','karyawan.nama as nama','karyawan.atasan_pertama','karyawan.atasan_kedua')
                    ->first(); 
                $atasan1 = Karyawan::where('id',$karyawan->atasan_pertama)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
        
                $atasan2 = NULL;
                if($karyawan->atasan_kedua !== NULL){
                    $atasan2 = Karyawan::where('id',$karyawan->atasan_kedua)
                    ->select('email as email','nama as nama','jabatan')
                    ->first();
                }
                $tujuan = $karyawan->email;
                $data = [
                    'subject'  =>'Notifikasi Permohonan Izin Ditolak, Izin ' . $izin->jenis_izin . ' #' . $izin->id . ' ' . $karyawan->nama,
                    'noregistrasi'=>$izin->id,
                    'tgl_permohonan' =>Carbon::parse($izin->tgl_permohonan)->format("d/m/Y"),
                    'title' =>  'NOTIFIKASI PERSETUJUAN FORMULIR IZIN KARYAWAN',
                    'subtitle' => '[ PENDING ATASAN ]',
                    'nik'         => $izin->nik,
                    'jabatankaryawan' => $izin->jabatan,
                    'departemen' => $karyawan->nama_departemen,
                    'atasan1'     => $atasan1->email,
                    'karyawan_email'=>$karyawan->email,
                    'id_jenisizin'=>$izin->jenis_izin,
                    'keperluan'   =>$izin->keperluan,
                    'tgl_mulai'   =>Carbon::parse($izin->tgl_mulai)->format("d/m/Y"),
                    'tgl_selesai' =>Carbon::parse($izin->tgl_selesai)->format("d/m/Y"),
                    'jam_mulai'   =>Carbon::parse($izin->jam_mulai)->format("H:i"),
                    'jam_selesai' =>Carbon::parse($izin->jam_selesai)->format("H:i"),
                    'status'   =>$status->name_status,
                    'jml_hari'    =>$izin->jml_hari,
                    'jumlahjam'   =>$izin->jml_jam,
                    'namakaryawan'=> ucwords(strtolower($karyawan->nama)),
                    'nama'        =>$karyawan->nama,
                    'kategori'   =>$izin->jenis_izin,
                    'alasan'      =>$alasan->alasan,
                    'tgldisetujuiatasan' => '',
                    'tgldisetujuipimpinan' => '',
                    'tglditolak' => Carbon::parse($izin->tgl_ditolak)->format("d/m/Y H:i"),
                ];
                if($atasan2 !== NULL)
                {
                    $data['atasan2'] = $atasan2->email;
                    $data['namaatasan2'] = $atasan2->nama;
                }
                Mail::to($tujuan)->send(new CutiIzinTolakNotification($data));
                return redirect()->back()->withInput();
                
            }else{
                return redirect()->back();
            }
        }
        else{
            return redirect()->back();
        }
        
    }

    public function rekapizinExcel(Request $request)
    {
        $nbulan = $request->query('month', Carbon::now()->format('M Y'));

        $idpegawai = $request->idpegawai;
        $month     = $request->query('month', Carbon::now()->format('m'));
        $year      = $request->query('year', Carbon::now()->format('Y'));

        // simpan session
        $idpegawai = $request->session()->get('idpegawai');
        $month     = $request->session()->get('month');
        $year      = $request->session()->get('year');

        if (isset($idpegawai) && isset($month) && isset($year))
        {
            $data = Izin::leftjoin('statuses', 'izin.status', '=', 'statuses.id')
                ->leftjoin('karyawan', 'izin.id_karyawan', '=', 'karyawan.id')
                ->leftjoin('departemen','izin.departemen','=','departemen.id')
                ->leftjoin('jenisizin','izin.id_jenisizin','=','jenisizin.id')
                ->where('izin.id_karyawan', $idpegawai)
                ->whereMonth('izin.tgl_mulai', $month)
                ->whereYear('izin.tgl_mulai', $year)
                ->get(['izin.*', 'statuses.name_status','karyawan.nama','departemen.nama_departemen','jenisizin.jenis_izin']);
               
                return Excel::download(new IzinExport($data, $idpegawai), "Rekap Izin Bulan " . $nbulan . " " . $data->first()->karyawans->nama . ".xlsx");
        } else {
            $data = Izin::leftjoin('statuses', 'izin.status', '=', 'statuses.id')
                ->leftjoin('karyawan', 'izin.id_karyawan', '=', 'karyawan.id')
                ->leftjoin('departemen','izin.departemen','=','departemen.id')
                ->leftjoin('jenisizin','izin.id_jenisizin','=','jenisizin.id')
                ->get(['izin.*', 'statuses.name_status','karyawan.nama','departemen.nama_departemen','jenisizin.jenis_izin']);
            
            return Excel::download(new IzinExport($data, $idpegawai), "Rekap Izin Karyawan.xlsx");
        }
       
    }

    public function rekapizinpdf(Request $request)
    {
        $nbulan = $request->query('bulan', Carbon::now()->format('M Y'));

        $idpegawai = $request->idpegawai;
        $month     = $request->query('month', Carbon::now()->format('m'));
        $year      = $request->query('year', Carbon::now()->format('Y'));

        // simpan session
        $idpegawai = $request->session()->get('idpegawai');
        $month     = $request->session()->get('month');
        $year      = $request->session()->get('year');

        // dd($idkaryawan,$bulan,$tahun );

        if (isset($idpegawai) && isset($month) && isset($year)) {
            $data = Izin::join('statuses', 'izin.status', '=', 'statuses.id')
                ->join('karyawan', 'izin.id_karyawan', '=', 'karyawan.id')
                ->join('departemen','izin.departemen','=','departemen.id')
                ->where('izin.id_karyawan', $idpegawai)
                ->whereMonth('izin.tgl_mulai', $month)
                ->whereYear('izin.tgl_mulai', $year)
                ->get(['izin.*', 'statuses.name_status','karyawan.nama','departemen.nama_departemen']);
        } else {
            $data = Izin::join('statuses', 'izin.status', '=', 'statuses.id')
                ->join('karyawan', 'izin.id_karyawan', '=', 'karyawan.id')
                ->join('departemen','izin.departemen','=','departemen.id')
                ->get(['izin.*', 'statuses.name_status','karyawan.nama','departemen.nama_departemen']);
        }

        $pdf = PDF::loadview('admin.cuti.izinpdf', ['data' => $data, 'idpegawai' => $idpegawai])
            ->setPaper('a4', 'landscape');
        return $pdf->stream("Rekap Izin Bulan " . $nbulan . " " . $data->first()->karyawans->nama . ".pdf");
    }
}
