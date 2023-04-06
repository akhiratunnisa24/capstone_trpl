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
        if($role == 1 && $izin && $izin->atasan_kedua == Auth::user()->id_pegawai)
        {
            $status = Status::find(7);
            Izin::where('id',$id)->update([
                'status' => $status->id,
            ]);
            $izinn = Izin::where('id',$id)->first();
            $jenisizin = Jenisizin::where('id',$izinn->id_jenisizin)->first();

             //KIRIM EMAIL NOTIFIKASI KE KARYAWAN ATASAN 2 TINGKAT DAN HRD
            $emailkry = DB::table('izin')->join('karyawan','izin.id_karyawan','=','karyawan.id')
                ->where('izin.id_karyawan','=',$izin->id_karyawan)
                ->select('karyawan.email','karyawan.nama','karyawan.atasan_pertama','karyawan.atasan_kedua')
                ->first();
            $atasan1 = Karyawan::where('id',$emailkry->atasan_pertama)
                ->select('email as email','nama as nama','jabatan as jabatan','divisi as departemen')
                ->first();
            $atasan2 = Auth::user()->email;
            $tujuan = $emailkry->email;

            $data = [
                'title'       =>$izinn->id,
                'subject'     =>'Notifikasi Izin Disetujui, Izin '  . $jenisizin->jenis_izin . ' #' . $izinn->id . ' ' . $emailkry->nama,
                'id'          =>$izinn->id,
                'karyawan_email'=>$emailkry->email,
                'id_jenisizin'=>$izinn->jenis_izin,
                'atasan1'     =>$atasan1->email,
                'atasan2'     =>$atasan2,
                'jenisizin'   =>$jenisizin->jenis_izin,
                'keperluan'   =>$izinn->keperluan,
                'tgl_mulai'   =>Carbon::parse($izinn->tgl_mulai)->format("d M Y"),
                'tgl_selesai' =>Carbon::parse($izinn->tgl_selesai)->format("d M Y"),
                'jam_mulai'   =>Carbon::parse($izinn->jam_mulai)->format("H:i"),
                'jam_selesai' =>Carbon::parse($izinn->jam_selesai)->format("H:i"),
                'jml_hari'    =>$izinn->jml_hari,
                'jumlahjam'   =>$izinn->jml_jam,
                'status'      =>$status->name_status,
                'namakaryawan'=>$emailkry->nama,
                'namaatasan2' =>Auth::user()->name,
            ];
            Mail::to($tujuan)->send(new IzinApproveNotification($data));
            return redirect()->route('cuti.Staff',['tp'=>2]);
        }
        elseif($role == 1 && $izin && $izin->atasan_pertama == Auth::user()->id_pegawai)
        {
            $status = Status::find(2);
            Izin::where('id',$id)->update([
                'status' => $status->id,
            ]);

            $izinn = Izin::where('id',$id)->first();
            $jenisizin = Jenisizin::where('id',$izinn->id_jenisizin)->first();

            //KIRIM NOTIFIKASI EMAIL KARYAWAN DAN ATASAN 2
            $emailkry = DB::table('izin')->join('karyawan','izin.id_karyawan','=','karyawan.id')
                ->where('izin.id_karyawan','=',$izinn->id_karyawan)
                ->select('karyawan.email','karyawan.nama','karyawan.atasan_pertama','karyawan.atasan_kedua')
                ->first();

            $atasan2 = Karyawan::where('id',$emailkry->atasan_kedua)
                ->select('email as email','nama as nama','jabatan as jabatan','divisi as departemen')
                ->first();

            //email atasan kedua adalah tujuan utama
            $tujuan = $atasan2->email;
            $data = [
                'subject'     =>'Notifikasi Approval Pertama Izin '  . $jenisizin->jenis_izin . ' #' . $izinn->id . ' ' . $emailkry->nama,
                'id'          =>$izinn->id,
                'karyawan_email'=>$emailkry->email,
                'id_jenisizin'=> $jenisizin->jenis_izin,
                'keperluan'   =>$izinn->keperluan,
                'tgl_mulai'   =>Carbon::parse($izinn->tgl_mulai)->format("d M Y"),
                'tgl_selesai' =>Carbon::parse($izinn->tgl_selesai)->format("d M Y"),
                'jam_mulai'   =>Carbon::parse($izinn->jam_mulai)->format("H:i"),
                'jam_selesai' =>Carbon::parse($izinn->jam_selesai)->format("H:i"),
                'jml_hari'    =>$izinn->jml_hari,
                'jumlahjam'   =>$izinn->jml_jam,
                'status'      =>$status->name_status,
                'namakaryawan'=> $emailkry->nama,
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
        
         //----SEND EMAIL KE KARYAWAN DAN 2 tingkat atasan-------
        //ambil nama jeniscuti
        $izin = DB::table('izin')
            ->join('jenisizin','izin.id_jenisizin','=','jenisizin.id')
            ->join('statuses','izin.status','=','statuses.id')
            ->where('izin.id',$id)
            ->select('izin.*','jenisizin.jenis_izin as jenis_izin','statuses.name_status')
            ->first();
        $alasan = Datareject::where('id_izin',$izin->id)->first();
        $karyawan = DB::table('izin')
            ->join('karyawan','izin.id_karyawan','=','karyawan.id')
            ->where('izin.id',$izin->id)
            ->select('karyawan.email as email','karyawan.nama as nama','karyawan.atasan_pertama','karyawan.atasan_kedua')
            ->first(); 
         //$tujuan = 'akhiratunnisahasanah0917@gmail.com';
       
        $atasan2 = Karyawan::where('id',$karyawan->atasan_kedua)
            ->select('email as email','nama as nama','jabatan')
            ->first();
        $atasan1 = Karyawan::where('id',$karyawan->atasan_pertama)
            ->select('email as email','nama as nama','jabatan')
            ->first();
        $tujuan = $karyawan->email;
        $data = [
            'subject'     =>'Notifikasi Permintaan Izin Ditolak, Izin ' . $izin->jenis_izin . ' #' . $izin->id . ' ' . $karyawan->nama,
            'id'          =>$izin->id,
            'atasan1'     => $atasan1->email,
            'atasan2'     => $atasan2->email,
            'karyawan_email'=>$karyawan->email,
            'id_jenisizin'=>$izin->jenis_izin,
            'keperluan'   =>$izin->keperluan,
            'tgl_mulai'   =>Carbon::parse($izin->tgl_mulai)->format("d M Y"),
            'tgl_selesai' =>Carbon::parse($izin->tgl_selesai)->format("d M Y"),
            'jam_mulai'   =>Carbon::parse($izin->jam_mulai)->format("H:i"),
            'jam_selesai' =>Carbon::parse($izin->jam_selesai)->format("H:i"),
            'status'      =>$status->name_status,
            'jml_hari'    =>$izin->jml_hari,
            'jumlahjam'   =>$izin->jml_jam,
            'status'      =>$status->name_status,
            'namakaryawan'=> $karyawan->nama,
            'namaatasan2' =>$atasan2->nama,
            'nama'        =>$karyawan->nama,
            'jenisizin'   =>$izin->jenis_izin,
            'alasan'      =>$alasan->alasan,
        ];
        // dd($data);
        Mail::to($tujuan)->send(new IzinApproveNotification($data));
        return redirect()->route('permintaancuti.index',['type'=>2])->withInput();
    }

    public function rekapizinExcel(Request $request)
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
            $data = Izin::with('karyawans')
            ->where('id_karyawan', $idkaryawan)
                ->whereMonth('tgl_mulai', $bulan)
                ->whereYear('tgl_mulai', $tahun)
                ->get();
            // dd($data);
        } else {
            $data = Izin::with('karyawans')
            ->get();
        }
        return Excel::download(new IzinExport($data, $idkaryawan), "Rekap Izin Bulan " . $nbulan . " " . $data->first()->karyawans->nama . ".xlsx");
    }

    public function rekapizinpdf(Request $request)
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
            $data = Izin::where('id_karyawan', $idkaryawan)
                ->whereMonth('tgl_mulai', $bulan)
                ->whereYear('tgl_mulai', $tahun)
                ->get();
        } else {
            $data = Izin::all();
        }

        $pdf = PDF::loadview('admin.cuti.izinpdf', ['data' => $data, 'idkaryawan' => $idkaryawan])
            ->setPaper('a4', 'landscape');
        return $pdf->stream("Rekap Izin Bulan " . $nbulan . " " . $data->first()->karyawans->nama . ".pdf");
    }
}
