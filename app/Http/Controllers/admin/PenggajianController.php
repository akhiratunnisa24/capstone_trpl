<?php

namespace App\Http\Controllers\admin;

use App\Models\Jadwal;
use App\Models\Absensi;
use App\Models\Karyawan;
use App\Models\Penggajian;
use App\Models\Tidakmasuk;
use Illuminate\Http\Request;
use App\Models\Informasigaji;
use App\Models\Detailkehadiran;
use Illuminate\Support\Facades\DB;
use App\Models\Detailinformasigaji;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PenggajianController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    { 
        $role = Auth::user()->role;
        if ($role == 1 ||$role == 6) 
        {
            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
            $karyawan = Karyawan::where('partner',$row->partner)->get();
            $slipgaji = Penggajian::where('partner',$row->partner)->get();

            return view('admin.penggajian.index',compact('row','role','karyawan','slipgaji'));
        }else {

            return redirect()->back();
        }
    }

    public function getkaryawan(Request $request)
    {
        try {
            $getKaryawan = Karyawan::leftjoin('departemen', 'karyawan.divisi', '=', 'departemen.id')
                ->select('karyawan.nama_jabatan','karyawan.id' ,'karyawan.divisi', 'karyawan.nip', 'departemen.nama_departemen','karyawan.nama_bank','karyawan.no_rek','karyawan.tglmasuk')
                ->where('karyawan.id','=', $request->id_karyawan)
                ->first();
            
            if (!$getKaryawan) {
                 throw new \Exception('Data not found');
            }

            return response()->json( $getKaryawan,200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function storeGaji(Request $request)
    {
        $validateData = $request->validate([
            'tglgajian' => 'required',
            'id_karyawan' => 'required',
            'tgl_awal' => 'required',
            'tgl_akhir' => 'required',
            'nama_bank' => 'required',
            'nomor_rekening' => 'required',
            'partner' => 'required',
        ]);

        $tgl_awal = date_format(date_create_from_format('d/m/Y', $request->tgl_awal), 'Y-m-d');
        $tgl_akhir= date_format(date_create_from_format('d/m/Y', $request->tgl_akhir), 'Y-m-d');   
        $tglgajian= date_format(date_create_from_format('d/m/Y', $request->tglgajian), 'Y-m-d');        

        $getKaryawan = Karyawan::leftjoin('departemen', 'karyawan.divisi', '=', 'departemen.id')
        ->select('karyawan.nama_jabatan','karyawan.id' ,'karyawan.divisi', 'karyawan.nip', 'departemen.nama_departemen','karyawan.nama_bank','karyawan.no_rek')
        ->where('karyawan.id','=', $request->id_karyawan)
        ->first();

        if($getKaryawan->nama_bank == null || $getKaryawan->no_rek == null)
        {
            $data = [
                'nama_bank' => $request->nama_bank,
                'no_rek' =>  $request->nomor_rekening,
            ];
            Karyawan::where('id', $request->id_karyawan)->update($data);
        }

        $lembur = DB::table('detail_kehadiran')
            ->where('id_karyawan',$getKaryawan->id)
            ->where('tgl_awal',$tgl_awal)
            ->where('tgl_akhir',$tgl_akhir)
            ->first();
        
        $informasigaji = Informasigaji::where('id_karyawan',$request->id_karyawan)->first();
        $detail = Detailinformasigaji::where('id_informasigaji',$informasigaji->id)->get();

        $penggajian = Penggajian::firstOrNew([
                    'id_karyawan' => $request->id_karyawan,
                    'tglawal' => $tgl_awal,
                    'tglakhir' => $tgl_akhir,
                ]);

        $penggajian->tglgajian = $tglgajian;
        $penggajian->gaji_pokok = $informasigaji->gaji_pokok;
        $penggajian->lembur = null;
        $penggajian->tunjangan = null;
        $penggajian->gaji_kotor = null;
        $penggajian->asuransi = null;
        $penggajian->potongan = null;
        $penggajian->pajak = null;
        $penggajian->gaji_bersih = null;
        $penggajian->nama_bank = $request->nama_bank;
        $penggajian->no_rekening = $request->nomor_rekening;
        $penggajian->partner = $request->partner;
                
        $penggajian->save();

        $pesan = "Slip Gaji untuk ". $getKaryawan->nama . "Periode ". $request->tgl_awal . " s/d " .  $request->tgl_akhir . "Berhasil dibuat";
        return redirect()->back()->with('pesan',$pesan);
    }

    public function showslipgaji(Request $request)
    { 
        $nip = $request->input('nip');
        $id = $request->id;
        $role = Auth::user()->role;
        if ($role == 1 ||$role == 6) 
        {
            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
            $karyawan = Karyawan::where('partner',$row->partner)->first();
            $informasigaji = Informasigaji::with('karyawans')->where('id_karyawan',$karyawan->id)->first();
            $detailinformasi= Detailinformasigaji::with('karyawans')->where('id_karyawan',$karyawan->id)->get();
        
            $kehadiran = Detailkehadiran::where('id_karyawan',$karyawan->id)->first();
            $slipgaji = Penggajian::with('karyawans')->where('id',$id)->first();
            $jadwal = Jadwal::whereBetween('tanggal', [$slipgaji->tglawal, $slipgaji->tglakhir])
            ->where('partner', $row->partner)
            ->count();        

            return view('admin.penggajian.slip',compact('row','role','karyawan','slipgaji','kehadiran','informasigaji','detailinformasi'));
        }else {

            return redirect()->back();
        }
    }


    //konfigurasi kehadiran
    public function indexs(Request $request)
    { 
        $role = Auth::user()->role;
        if ($role == 1 ||$role == 6) 
        {
            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
            $kehadiran = Detailkehadiran::where('partner',$row->partner)->get();
            return view('admin.penggajian.konfigurasi.index',compact('row','role','kehadiran'));
        }else {

            return redirect()->back();
        }
    }

    public function storehadir(Request $request)
    {
        $karyawan = Karyawan::where('partner',$request->partner)->select('id','nama','partner')->get();
        $awal = date_format(date_create_from_format('d/m/Y', $request->tgl_awal), 'Y-m-d');
        $akhir = date_format(date_create_from_format('d/m/Y', $request->tgl_akhir), 'Y-m-d');
        foreach($karyawan as $data)
        {
            $lembur = Absensi::where('id_karyawan', $data->id)
                ->where('lembur', '!=', null)
                ->whereBetween('tanggal', [$awal, $akhir])
                ->where('lembur','>','01:00:00')
                ->count();
            $sakit = Tidakmasuk::where('id_pegawai',$data->id)
                ->whereBetween('tanggal', [$awal, $akhir])
                ->where('status','Sakit')
                ->count();
            $cuti = Tidakmasuk::where('id_pegawai', $data->id)
                ->whereBetween('tanggal', [$awal, $akhir])
                ->where('status', 'LIKE', '%Cuti%')
                ->count();
            $izin = Tidakmasuk::where('id_pegawai', $data->id)
                ->whereBetween('tanggal', [$awal, $akhir])
                ->where('status', 'LIKE', '%Izin%')
                ->count();
            $hadir = Absensi::where('id_karyawan', $data->id)
                ->whereBetween('tanggal', [$awal, $akhir])
                ->count();
            
            $data = [
                'id_karyawan' => $data->id,
                'tgl_awal'    => $awal,
                'tgl_akhir'   => $akhir,
                'jumlah_hadir'=> $hadir,
                'jumlah_lembur'=>$lembur,
                'jumlah_cuti' => $cuti,
                'jumlah_izin' => $izin,
                'jumlah_sakit'=> $sakit,
                'partner'     => $request->partner,
            ];
            Detailkehadiran::insert($data);
        }

        return redirect()->back()->with('pesan','Data berhasil disimpan');
       
    }
}
