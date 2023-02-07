<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use App\Models\Cuti;
use App\Models\Izin;
use App\Models\Status;
use App\Models\Karyawan;
use App\Models\Alokasicuti;
use Illuminate\Http\Request;
use App\Mail\CutiHRDNotification;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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
            $cuti = DB::table('cuti')
                ->leftjoin('alokasicuti','cuti.id_jeniscuti','alokasicuti.id_jeniscuti')
                ->leftjoin('settingalokasi','cuti.id_jeniscuti','settingalokasi.id_jeniscuti')
                ->leftjoin('jeniscuti','cuti.id_jeniscuti','jeniscuti.id')
                ->leftjoin('karyawan','cuti.id_karyawan','karyawan.id')
                ->select('cuti.*', 'jeniscuti.jenis_cuti', 'karyawan.nama','settingalokasi.mode_alokasi')
                ->distinct()
                ->orderBy('created_at','DESC')
                ->get();
            $alasancuti = DB::table('datareject')
                ->join('cuti','datareject.id_cuti','=','cuti.id')
                ->select('datareject.alasan as alasan_cuti','datareject.id_cuti as id_cuti')
                ->first();
            foreach($cuti as $data) {
                $status = Status::where('id','=',$data->status)->select('name_status')->first();
            }
            // $status = Status::where('id','=',$cuti->status)->select('name_status')->get();

            //DATA IZIN
            $izin = Izin::all();
            $alasan = DB::table('datareject')
                ->join('izin','datareject.id_izin','=','izin.id')
                ->select('datareject.alasan as alasan','datareject.id_izin as id_izin')
                ->first();
            return view('admin.cuti.index', compact('cuti','izin','type','row','alasan','alasancuti','karyawan','status'));
            
        } else 
        {
            return redirect()->back(); 
        }
    }

    public function getAlokasiCuti(Request $request)
    {
        try {
            $getAlokasiCuti = Alokasicuti::select('alokasicuti.*','jeniscuti.jenis_cuti')
                ->join('jeniscuti','alokasicuti.id_jeniscuti','=','jeniscuti.id')
                ->where('alokasicuti.id_jeniscuti','=',1)
                ->where('alokasicuti.id_karyawan', '=', $request->id_karyawan)
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
        $status = Status::find(3);

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

        // dd($cuti,$jml_cuti,$durasi_baru,$alokasicuti);
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
        return redirect()->back()->withInput();
    }

    public function show($id)
    {
        $cuti = Cuti::findOrFail($id);
        $karyawan = Auth::user()->id_pegawai;

        return view('admin.cuti.index',compact('cuti','karyawan'));
    }

    // public function update(Request $request, $id)
    // {
    //     $cuti = Cuti::where('id', $id)->first();
    //     // Inisialisasi variable jml_cuti dengan nilai jumlah hari cuti yang diambil
    //     $jml_cuti = $cuti->jml_cuti;

    //     //Update status cuti menjadi 'Disetujui'
    //     Cuti::where('id', $id)->update(
    //         ['status' => 'Disetujui']
    //     );

    //     //Ambil data alokasi cuti yang sesuai dengan id karyawan dan id jenis cuti
    //     $alokasicuti = Alokasicuti::where('id', $cuti->id_alokasi)
    //         ->where('id_karyawan', $cuti->id_karyawan)
    //         ->where('id_jeniscuti', $cuti->id_jeniscuti)
    //         ->first();

    //     // Hitung durasi baru setelah pengurangan
    //     $durasi_baru = $alokasicuti->durasi - $jml_cuti;
    //     // dd($durasi_baru);
    //     Alokasicuti::where('id', $alokasicuti->id)
    //         ->update(
    //             ['durasi' => $durasi_baru]
    //         );
    //     return redirect()->back()->withInput();
    // }

    // public function tolak(Request $request, $id)
    // {
    //     $cuti = Cuti::where('id',$id)->first();
    //     $status = 'Ditolak';
    //     Cuti::where('id',$id)->update([
    //         'status' => $status,
    //     ]);
    //     return redirect()->back()->withInput();
    // }
}
