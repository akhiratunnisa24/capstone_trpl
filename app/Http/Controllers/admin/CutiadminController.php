<?php

namespace App\Http\Controllers\admin;

use PDF;
use Carbon\Carbon;
use App\Models\Cuti;
use App\Models\Izin;
use App\Models\Status;
use App\Models\Karyawan;
use App\Models\Sisacuti;
use App\Models\Jeniscuti;
use App\Models\Datareject;
use App\Exports\CutiExport;
use App\Models\Alokasicuti;
use Illuminate\Http\Request;
use App\Mail\CutiHRDNotification;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Mail\CutiApproveNotification;
use App\Mail\CutiAtasan2Notification;



class CutiadminController extends Controller
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

            //form create cuti untuk karyawan.
            $karyawan = Karyawan::where('id','!=',Auth::user()->id_pegawai)->get();

            //data cuti
            // $cuti = DB::table('cuti')
            //     ->leftjoin('alokasicuti','cuti.id_jeniscuti','alokasicuti.id_jeniscuti')
            //     ->leftjoin('settingalokasi','cuti.id_jeniscuti','settingalokasi.id_jeniscuti')
            //     ->leftjoin('jeniscuti','cuti.id_jeniscuti','jeniscuti.id')
            //     ->leftjoin('karyawan','cuti.id_karyawan','karyawan.id')
            //     ->leftjoin('statuses','cuti.status','=','statuses.id')
            //     ->leftjoin('datareject','datareject.id_cuti','=','cuti.id')
            //     ->select('cuti.*', 'jeniscuti.jenis_cuti', 'karyawan.nama','settingalokasi.mode_alokasi','statuses.name_status','karyawan.atasan_pertama','karyawan.atasan_kedua','datareject.alasan as alasan_cuti','datareject.id_cuti as id_cuti')
            //     ->distinct()
            //     ->orderBy('created_at','DESC')
            //     ->get();

            // Filter Data Cuti
            $karyawan = Karyawan::all();
            $pegawai = Karyawan::all();

            $idkaryawan = $request->id_karyawan;
            $bulan = $request->query('bulan', Carbon::now()->format('m'));
            $tahun = $request->query('tahun', Carbon::now()->format('Y'));

            // simpan session
            $request->session()->put('idkaryawan', $request->id_karyawan);
            $request->session()->put('bulan', $bulan);
            $request->session()->put('tahun', $tahun);

            if (isset($idkaryawan) && isset($bulan) && isset($tahun)) {
                // $cuti = Cuti::with('karyawans', 'jeniscutis')->where('id_karyawan', $idkaryawan)
                //     ->whereMonth('tgl_mulai', $bulan)
                //     ->whereYear('tgl_mulai', $tahun)
                //     ->get();

                $cuti = DB::table('cuti')
                    ->leftjoin('alokasicuti', 'cuti.id_jeniscuti', 'alokasicuti.id_jeniscuti')
                    ->leftjoin('settingalokasi', 'cuti.id_jeniscuti', 'settingalokasi.id_jeniscuti')
                    ->leftjoin('jeniscuti', 'cuti.id_jeniscuti', 'jeniscuti.id')
                    ->leftjoin('karyawan', 'cuti.id_karyawan', 'karyawan.id')
                    ->leftjoin('statuses', 'cuti.status', '=', 'statuses.id')
                    ->leftjoin('datareject', 'datareject.id_cuti', '=', 'cuti.id')
                    ->where('cuti.id_karyawan', $idkaryawan)
                    ->whereMonth('cuti.tgl_mulai', $bulan)
                    ->whereYear('cuti.tgl_mulai', $tahun)
                    ->select('cuti.*', 'jeniscuti.jenis_cuti', 'karyawan.nama', 'statuses.name_status', 'karyawan.atasan_pertama', 'karyawan.atasan_kedua', 'datareject.alasan as alasan_cuti', 'datareject.id_cuti as id_cuti')
                    ->distinct()
                    ->orderBy('created_at', 'DESC')
                    ->get();

            } else {
                $cuti = DB::table('cuti')
                    ->leftjoin('alokasicuti', 'cuti.id_jeniscuti', 'alokasicuti.id_jeniscuti')
                    ->leftjoin('settingalokasi', 'cuti.id_jeniscuti', 'settingalokasi.id_jeniscuti')
                    ->leftjoin('jeniscuti', 'cuti.id_jeniscuti', 'jeniscuti.id')
                    ->leftjoin('karyawan', 'cuti.id_karyawan', 'karyawan.id')
                    ->leftjoin('statuses', 'cuti.status', '=', 'statuses.id')
                    ->leftjoin('datareject', 'datareject.id_cuti', '=', 'cuti.id')
                    ->select('cuti.*', 'jeniscuti.jenis_cuti', 'karyawan.nama','statuses.name_status', 'karyawan.atasan_pertama', 'karyawan.atasan_kedua', 'datareject.alasan as alasan_cuti', 'datareject.id_cuti as id_cuti')
                    ->distinct()
                    ->orderBy('created_at', 'DESC')
                    ->get();
            }   

             // Filter Data Izin
             $idpegawai = $request->id_karyawan;
             $month = $request->query('bulan', Carbon::now()->format('m'));
             $year = $request->query('tahun', Carbon::now()->format('Y'));
 
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
                    ->where('izin.id_karyawan', $idpegawai)
                    ->whereMonth('izin.tgl_mulai', $month)
                    ->whereYear('izin.tgl_mulai', $year)
                    ->select('izin.*','statuses.name_status','jenisizin.jenis_izin','datareject.alasan as alasan','datareject.id_izin as id_izin','karyawan.atasan_pertama','karyawan.nama')
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
                    ->select('izin.*','statuses.name_status','jenisizin.jenis_izin','datareject.alasan as alasan','datareject.id_izin as id_izin','karyawan.atasan_pertama','karyawan.nama')
                    ->distinct()
                    ->orderBy('created_at','DESC')
                    ->get();
            };

        return view('admin.cuti.index', compact('cuti','izin','type','row','karyawan','pegawai'));
        } else 
        {
            return redirect()->back(); 
        }
    }

    public function getAlokasiCuti(Request $request)
    {
        dd($request->id_karyawan);
        try {
            $getAlokasiCuti = Alokasicuti::select('alokasicuti.*','jeniscuti.jenis_cuti')
                ->join('jeniscuti','alokasicuti.id_jeniscuti','=','jeniscuti.id')
                ->where('alokasicuti.id_jeniscuti','=',1)
                ->where('alokasicuti.id_karyawan', '=', $request->id_karyawan)
                ->where('alokasicuti.status','=',1)
                ->first();

            if (!$getAlokasiCuti) {
                throw new \Exception('Data not found');
            }
            return response()->json($getAlokasiCuti, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function storeCuti(Request $request)
    {
        $status = Status::find(7);

        $cuti = New Cuti;
        $cuti->id_karyawan      = $request->id_karyawan;
        $cuti->id_jeniscuti     = $request->id_jeniscuti;
        $cuti->id_alokasi       = $request->id_alokasi;
        $cuti->id_settingalokasi= $request->id_settingalokasi;
        $cuti->keperluan        = $request->keperluan;
        $cuti->tgl_mulai        = Carbon::parse($request->tgl_mulai)->format("Y-m-d");
        $cuti->tgl_selesai      = Carbon::parse($request->tgl_selesai)->format("Y-m-d");
        $cuti->jml_cuti         = $request->jml_cuti;
        $cuti->status           = $status->id;
        $cuti->save();

        // Inisialisasi variable jml_cuti dengan nilai jumlah hari cuti yang diambil
        $jml_cuti = $cuti->jml_cuti;

        $alokasicuti = Alokasicuti::where('id', $cuti->id_alokasi)
            ->where('id_karyawan', $cuti->id_karyawan)
            ->first();
        // Hitung durasi baru setelah pengurangan
        $durasi_baru = $alokasicuti->durasi - $jml_cuti;

        //update durasi di alokasicutikaryawan
        Alokasicuti::where('id', $alokasicuti->id)
            ->update(
                ['durasi' => $durasi_baru]
            );

        // //mengirim email notifikasi kepada karyawan mengenai alasan dibuatnya cuti tersebut.
        $epegawai = Karyawan::select('email as email','nama as nama')->where('id','=',$cuti->id_karyawan)->first();
        $tujuan = $epegawai->email;
        $data = [
            'subject'     =>'Notifikasi Pengurangan Jatah Cuti Tahunan',
            'id'          =>$cuti->id,
            'id_jeniscuti'=>$cuti->jeniscutis->jenis_cuti,
            'keperluan'   =>$cuti->keperluan,
            'tgl_mulai'   =>Carbon::parse($cuti->tgl_mulai)->format("d M Y"),
            'tgl_selesai' =>Carbon::parse($cuti->tgl_selesai)->format("d M Y"),
            'jml_cuti'    =>$cuti->jml_cuti,
            'status'      =>$cuti->status,
            'nama'        =>$epegawai->nama,
            'jatahcuti'   =>$durasi_baru,
        ];
        Mail::to($tujuan)->send(new CutiHRDNotification($data));
        // return redirect()->back()->withInput();
        return redirect('/permintaan_cuti')->with('pesan','Data berhasil disimpan !');
    }

    public function show($id)
    {
        $cuti = Cuti::findOrFail($id);
        $karyawan = Auth::user()->id_pegawai;

        return view('admin.cuti.index',compact('cuti','karyawan'));
    }

    public function update(Request $request, $id)
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $cuti = Cuti::where('id', $id)->first();
        
        $cekSisacuti = Sisacuti::leftJoin('cuti', 'cuti.id_jeniscuti', 'sisacuti.jenis_cuti')
            ->select('cuti.id as id_cuti','cuti.jml_cuti','cuti.tgl_mulai', 'cuti.tgl_selesai','sisacuti.*')
            ->where('cuti.id',$cuti->id)
            ->where('sisacuti.id_pegawai',$cuti->id_karyawan)
            ->first();

        if ($cekSisacuti !== null) 
        {
            $datacuti = DB::table('cuti')
                ->leftjoin('settingalokasi', 'cuti.id_settingalokasi', '=', 'settingalokasi.id')
                ->leftjoin('karyawan','cuti.id_karyawan','karyawan.id')
                ->where('cuti.id',$cuti->id)
                ->where('karyawan.atasan_pertama', Auth::user()->id_pegawai)
                ->orWhere('karyawan.atasan_kedua',Auth::user()->id_pegawai)
                ->select('cuti.*','karyawan.atasan_pertama','karyawan.atasan_kedua')
                ->first();
            $jeniscuti = Jeniscuti::where('id',$datacuti->id)->first();
            if($datacuti && $datacuti->atasan_kedua == Auth::user()->id_pegawai)
            {
               
                // Inisialisasi variable jml_cuti dengan nilai jumlah hari cuti yang diambil
                $jml_cuti = $cuti->jml_cuti;
                //Update status cuti menjadi 'Disetujui'
                $status = Status::find(7);
                Cuti::where('id', $id)->update(
                    ['status' => $status->id,]
                );

                $sisacuti = Sisacuti::where('jenis_cuti', $cuti->id_jeniscuti)
                    ->where('id_pegawai', $cuti->id_karyawan)
                    ->first();
                $sisacuti_baru = $sisacuti->sisacuti - $jml_cuti;
    
                Sisacuti::where('id', $sisacuti->id)
                    ->update(
                        ['sisa_cuti' => $sisacuti_baru]
                );
                //ambil data karyawan
                $emailkry = DB::table('cuti')->join('karyawan','cuti.id_karyawan','=','karyawan.id')
                    ->where('cuti.id_karyawan','=',$datacuti->id_karyawan)
                    ->select('karyawan.email','nama as nama','karyawan.atasan_pertama')
                    ->first();

                $atasan1 = Karyawan::where('id',$emailkry->atasan_pertama)
                    ->select('email as email','nama as nama','jabatan as jabatan','divisi as departemen')
                    ->first();
                
                //atasan yang login
                $atasan2 = Auth::user()->email;
                $tujuan = $emailkry['email'];
                $alasan = '';
                $data = [
                    'subject'     => 'Notifikasi Cuti Disetujui ' . $jeniscuti->jenis_cuti . ' #' . $cuti->id . ' ' . $emailkry->nama,
                    'id'          => $cuti->id,
                    'atasan1'     =>$atasan1->email,
                    'atasan2'     =>$atasan2,
                    'namaatasan1' =>$atasan1->nama,
                    'namaatasan2' =>Auth::user()->name,
                    'namakaryawan'=>$emailkry->nama,
                    'id_jeniscuti' => $cuti->jeniscutis->jenis_cuti,
                    'nama'      => $cuti->karyawans->nama,
                    'keperluan'   => $cuti->keperluan,
                    'tgl_mulai'   => Carbon::parse($cuti->tgl_mulai)->format("d M Y"),
                    'tgl_selesai' => Carbon::parse($cuti->tgl_selesai)->format("d M Y"),
                    'jml_cuti'    => $cuti->jml_cuti,
                    'status'      => $status->name_status,
                    'alasan'      =>$alasan,
                ];
                Mail::to($tujuan)->send(new CutiApproveNotification($data));
        
                return redirect()->back()->withInput();
            }
            elseif($datacuti && $datacuti->atasan_pertama == Auth::user()->id_pegawai)
            {
                $status = Status::find(2);
                Cuti::where('id',$id)->update([
                    'status' => $status->id,
                ]);

                //KIRIM NOTIFIKASI EMAIL
                //ambil data karyawan
                $emailkry = DB::table('cuti')->join('karyawan','cuti.id_karyawan','=','karyawan.id')
                    ->where('cuti.id_karyawan','=',$datacuti->id_karyawan)
                    ->select('karyawan.email','karyawan.nama as nama','karyawan.atasan_pertama','karyawan.atasan_kedua')
                    ->first();
    
                //atasan kedua
                $atasan = Karyawan::where('id',$emailkry->atasan_kedua)
                    ->select('email as email','nama as nama','jabatan as jabatan')
                    ->first();
    
                //atasan pertama
                $atasan1 = Auth::user()->email;

                //ambil data karyawan
                $tujuan = $atasan->email;
                 
                $data = [
                    'subject'     =>'Notifikasi Approval Pertama Permintaan ' . $jeniscuti->jenis_cuti . ' #' . $cuti->id . ' ' . $emailkry->nama,
                    'id'          => $cuti->id,
                    'atasan2'     => $atasan->email,
                    'namaatasan2' => $atasan->nama,
                    'jeniscuti'   => $jeniscuti->jenis_cuti,
                    'karyawan_email' =>$emailkry->email,
                    'namakaryawan'=>$emailkry->nama,
                    'id_jeniscuti'=>$jeniscuti->jenis_cuti,
                    'keperluan'   =>$cuti->keperluan,
                    'tgl_mulai'   =>Carbon::parse($cuti->tgl_mulai)->format("d M Y"),
                    'tgl_selesai' =>Carbon::parse($cuti->tgl_selesai)->format("d M Y"),
                    'jml_cuti'    =>$cuti->jml_cuti,
                    'status'      =>$status->name_status,
                    'jabatanatasan' => $atasan->jabatan
 
                ];
                Mail::to($tujuan)->send(new CutiAtasan2Notification($data));
                return redirect()->back()->withInput();
            }else
            {
                return redirect()->back();
            }

        }
        else
        {
            $datacuti = DB::table('cuti')
                ->leftjoin('alokasicuti', 'cuti.id_alokasi', '=', 'alokasicuti.id')
                ->leftjoin('settingalokasi', 'cuti.id_settingalokasi', '=', 'settingalokasi.id')
                ->leftjoin('karyawan','cuti.id_karyawan','karyawan.id')
                ->where('cuti.id',$cuti->id)
                ->where('karyawan.atasan_pertama', Auth::user()->id_pegawai)
                ->orWhere('karyawan.atasan_kedua',Auth::user()->id_pegawai)
                ->select('cuti.*','alokasicuti.*','karyawan.atasan_pertama','karyawan.atasan_kedua')
                ->first();
                if($datacuti && $datacuti->atasan_kedua == Auth::user()->id_pegawai)
                {
                    // return  Auth::user()->name;
                    $cuti = Cuti::where('id',$id)->first();
                    $jeniscuti = Jeniscuti::where('id',$cuti->id)->first();
                    $jml_cuti = $cuti->jml_cuti;
                    $status = Status::find(7);
                    Cuti::where('id', $id)->update(
                        ['status' => $status->id,]
                    );
            
                    $alokasicuti = Alokasicuti::where('id', $cuti->id_alokasi)
                        ->where('id_karyawan', $cuti->id_karyawan)
                        ->where('id_jeniscuti', $cuti->id_jeniscuti)
                        ->where('id_settingalokasi', $cuti->id_settingalokasi)
                        ->first();
    
                    $durasi_baru = $alokasicuti->durasi - $jml_cuti;
    
                    Alokasicuti::where('id', $alokasicuti->id)
                    ->update(
                        ['durasi' => $durasi_baru]
                    );
    
                    //KIRIM EMAIL NOTIFIKASI KE KARYAWAN,2  atasan dan hrd
    
                    //ambil data karyawan
                    $emailkry = DB::table('cuti')->join('karyawan','cuti.id_karyawan','=','karyawan.id')
                        ->where('cuti.id_karyawan','=',$datacuti->id_karyawan)
                        ->select('karyawan.email','karyawan.atasan_pertama','karyawan.atasan_kedua')
                        ->first();
                    //atasan pertama
                    $idatasan1 = DB::table('karyawan')
                        ->join('cuti','karyawan.id','=','cuti.id_karyawan')
                        ->where('cuti.id_karyawan','=',$datacuti->id_karyawan)
                        ->select('karyawan.atasan_pertama as atasan_pertama')
                        ->first();
    
                    $atasan1 = Karyawan::where('id',$idatasan1->atasan_pertama)
                        ->select('email as email','nama as nama','jabatan as jabatan','divisi as departemen')
                        ->first();
                    
                    //atasan yang login
                    $atasan2 = Auth::user()->email;
    
                    // $tujuan = 'akhiratunnisahasanah0917@gmail.com';
                    $tujuan = $emailkry['email'];
                    $alasan = '';
                    $data = [
                        'subject'     =>'Notifikasi Cuti Disetujui ' . $jeniscuti->jenis_cuti . ' #' . $cuti->id . ' ' . $emailkry->nama,
                        'id'          =>$cuti->id,
                        'atasan1'     =>$atasan1->email,
                        'atasan2'     =>$atasan2,
                        'namaatasan1' =>$atasan1->nama,
                        'namaatasan2' =>Auth::user()->name,
                        'namakaryawan'=>$emailkry->nama,
                        'id_jeniscuti'=>$cuti->jeniscutis->jenis_cuti,
                        'keperluan'   =>$cuti->keperluan,
                        'tgl_mulai'   =>Carbon::parse($cuti->tgl_mulai)->format("d M Y"),
                        'tgl_selesai' =>Carbon::parse($cuti->tgl_selesai)->format("d M Y"),
                        'jml_cuti'    =>$cuti->jml_cuti,
                        'status'      =>$cuti->name_status,
                        'alasan'      =>$alasan,
                    ];
                    Mail::to($tujuan)->send(new CutiApproveNotification($data));
                    return redirect()->back()->withInput();
    
                }
                elseif($datacuti && $datacuti->atasan_pertama == Auth::user()->id_pegawai)
                {
                    // return $datacuti->atasan_pertama;
                    $status = Status::find(2);
                    Cuti::where('id',$id)->update([
                        'status' => $status->id,
                    ]);
                    $cuti = Cuti::where('id',$id)->first();
                    $jeniscuti = Jeniscuti::where('id',$cuti->id_jeniscuti)->first();
    
                    //KIRIM NOTIFIKASI EMAIL KE ATASAN KEDUA DAN KARYAWAN
    
                    //ambil data karyawan
                    $emailkry = DB::table('cuti')->join('karyawan','cuti.id_karyawan','=','karyawan.id')
                        ->where('cuti.id_karyawan','=',$datacuti->id_karyawan)
                        ->select('karyawan.email','karyawan.nama as nama','karyawan.atasan_kedua')
                        ->first();

                    $atasan = Karyawan::where('id',$emailkry->atasan_kedua)
                        ->select('email as email','nama as nama','jabatan as jabatan')
                        ->first();
    
                    //ambil data karyawan
                    $tujuan = $atasan->email;
                    $data = [
                        'subject'     =>'Notifikasi Approval Pertama Permintaan ' . $jeniscuti->jenis_cuti . ' #' . $cuti->id . ' ' . $emailkry->nama,
                        'id'          => $cuti->id,
                        'atasan2'     => $atasan->email,
                        'namaatasan2' => $atasan->nama,
                        'jeniscuti'   => $jeniscuti->jenis_cuti,
                        'karyawan_email' =>$emailkry->email,
                        'namakaryawan'=>$emailkry->nama,
                        'id_jeniscuti'=>$cuti->jeniscutis->jenis_cuti,
                        'keperluan'   =>$cuti->keperluan,
                        'tgl_mulai'   =>Carbon::parse($cuti->tgl_mulai)->format("d M Y"),
                        'tgl_selesai' =>Carbon::parse($cuti->tgl_selesai)->format("d M Y"),
                        'jml_cuti'    =>$cuti->jml_cuti,
                        'status'      =>$status->name_status,
                        'jabatanatasan' => $atasan->jabatan
    
                    ];
                    Mail::to($tujuan)->send(new CutiAtasan2Notification($data));
                    return redirect()->back()->withInput();
                }
                else{
                    return redirect()->back();
                }
        }
    }

    public function tolak(Request $request, $id)
    {
        $status = Status::find(5);
        Cuti::where('id',$id)->update([
            'status' => $status->id,
        ]);
        $cuti = Cuti::where('id',$id)->first();

        $datareject          = new Datareject;
        $datareject->id_cuti = $cuti->id;
        $datareject->id_izin = NULL;
        $datareject->alasan  = $request->alasan;
        $datareject->save(); 

        $cuti = DB::table('cuti')
            ->join('jeniscuti','cuti.id_jeniscuti','=','jeniscuti.id')
            ->join('statuses','cuti.status','=','statuses.id')
            ->where('cuti.id',$id)
            ->select('cuti.*','jeniscuti.jenis_cuti as jenis_cuti','statuses.name_status')
            ->first();
        $alasan = Datareject::where('id_cuti',$cuti->id)->first();
        $karyawan = DB::table('cuti')
            ->join('karyawan','cuti.id_karyawan','=','karyawan.id')
            ->where('cuti.id',$cuti->id)
            ->select('karyawan.email','karyawan.nama','karyawan.atasan_pertama','karyawan.atasan_kedua')
            ->first(); 
        $atasan2 = Karyawan::where('id',$karyawan->atasan_kedua)
            ->select('email as email','nama as nama','jabatan')
            ->first();
        $atasan1 = Karyawan::where('id',$karyawan->atasan_pertama)
            ->select('email as email','nama as nama','jabatan')
            ->first();

        $tujuan = $karyawan->email;

        $data = [
            'subject'     =>'Notifikasi Permintaan Cuti Ditolak, ' . $cuti->jenis_cuti . ' #' . $cuti->id . ' ' . $karyawan->nama,
            'id'          =>$cuti->id,
            'atasan1'     =>$atasan1->email,
            'atasan2'     =>$atasan2->email,
            'namaatasan1' =>$atasan1->nama,
            'karyawan_email'=>$karyawan->email,
            'namaatasan2' =>$atasan2->nama,
            'namakaryawan'=>$karyawan->nama,
            'id_jeniscuti'=>$cuti->jenis_cuti,
            'keperluan'   =>$cuti->keperluan,
            'tgl_mulai'   =>Carbon::parse($cuti->tgl_mulai)->format("d M Y"),
            'tgl_selesai' =>Carbon::parse($cuti->tgl_selesai)->format("d M Y"),
            'jml_cuti'    =>$cuti->jml_cuti,
            'status'      =>$cuti->name_status,
            'alasan'      =>$alasan->alasan,
        ];
        // dd($data,$tujuan);
        Mail::to($tujuan)->send(new CutiApproveNotification($data));
        return redirect()->back()->withInput();

        return redirect()->back()->withInput();
    }

    public function rekapcutiExcel(Request $request)
    {
        $nbulan = $request->query('bulan', Carbon::now()->format('M Y'));

        $idkaryawan = $request->id_karyawan;
        $bulan      = $request->query('bulan', Carbon::now()->format('m'));
        $tahun      = $request->query('tahun', Carbon::now()->format('Y'));

        // simpan session
        $idkaryawan = $request->session()->get('idkaryawan');
        $bulan      = $request->session()->get('bulan');
        $tahun      = $request->session()->get('tahun',);

        if (isset($idkaryawan) && isset($bulan) && isset($tahun)) {
            $data = Cuti::with('karyawans')
            ->where('id_karyawan', $idkaryawan)
                ->whereMonth('tgl_mulai', $bulan)
                ->whereYear('tgl_mulai', $tahun)
                ->get();
            // dd($data);
        } else {
            $data = Cuti::with('karyawans')
            ->get();
        }
        return Excel::download(new CutiExport($data, $idkaryawan), "Rekap Cuti Bulan " . $nbulan . " " . $data->first()->karyawans->nama . ".xlsx");
    }

    public function rekapcutipdf(Request $request)
    {
        $nbulan = $request->query('bulan', Carbon::now()->format('M Y'));

        $idkaryawan = $request->id_karyawan;
        $bulan      = $request->query('bulan', Carbon::now()->format('m'));
        $tahun      = $request->query('tahun', Carbon::now()->format('Y'));

        // simpan session
        $idkaryawan = $request->session()->get('idkaryawan');
        $bulan      = $request->session()->get('bulan');
        $tahun      = $request->session()->get('tahun',);

        // dd($idkaryawan,$bulan,$tahun );

        if (isset($idkaryawan) && isset($bulan) && isset($tahun)) {
            $data = Cuti::where('id_karyawan', $idkaryawan)
                ->whereMonth('tgl_mulai', $bulan)
                ->whereYear('tgl_mulai', $tahun)
                ->get();
        } else {
            $data = Cuti::all();
        }

        $pdf = PDF::loadview('admin.cuti.cutipdf', ['data' => $data, 'idkaryawan' => $idkaryawan])
            ->setPaper('a4', 'landscape');
        return $pdf->stream("Rekap Cuti Bulan " . $nbulan . " " . $data->first()->karyawans->nama . ".pdf");
    }

}
