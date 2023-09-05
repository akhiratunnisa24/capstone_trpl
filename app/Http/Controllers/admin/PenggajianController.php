<?php

namespace App\Http\Controllers\admin;

use App\Models\Absensi;
use App\Models\Karyawan;
use App\Models\Tidakmasuk;
use Illuminate\Http\Request;
use App\Models\Detailkehadiran;
use App\Http\Controllers\Controller;
use App\Models\PenggajianGrup;
use App\Models\SalaryStructure;
use Carbon\Carbon;
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

            return view('admin.penggajian.index',compact('row','role','karyawan'));
        }else {

            return redirect()->back();
        }
    }
























































































































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

            $data = [
                'id_karyawan' => $data->id,
                'tgl_awal'    => $awal,
                'tgl_akhir'   => $akhir,
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


    public function indexgrup(Request $request)
    {
        $role = Auth::user()->role;
        if ($role == 1 ||$role == 6)
        {
            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
            $karyawan = Karyawan::where('partner',$row->partner)->get();
            $slipgrupindex = PenggajianGrup::where('partner',$row->partner)->get();
            $slipgrup = SalaryStructure::where('partner',$row->partner)->get();

            return view('admin.penggajian.indexgrup',compact('row','role','karyawan','slipgrup','slipgrupindex'));
        }else {

            return redirect()->back();
        }
    }

    public function storepenggajian_grup(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required',
            'id_struktur' => 'required',
            'tgl_penggajian' => 'required',
            'tgl_mulai' => 'required',
            'tgl_selesai' => 'required',
        ]);
        $tgl_penggajian = Carbon::createFromFormat('d/m/Y', $request->tgl_penggajian)->format('Y-m-d');
        $tgl_mulai = Carbon::createFromFormat('d/m/Y', $request->tgl_mulai)->format('Y-m-d');
        $tgl_selesai = Carbon::createFromFormat('d/m/Y', $request->tgl_selesai)->format('Y-m-d');

        PenggajianGrup::create([
            'nama_grup' => $request->nama,
            'id_struktur' => $request->id_struktur,
            'tglawal' => $tgl_mulai,
            'tglakhir' => $tgl_selesai,
            'tglgajian' => $tgl_penggajian,
            'partner' => $request->partner,
        ]);

        return redirect()->back()->with('pesan','Data berhasil disimpan');
    }

}
