<?php

namespace App\Http\Controllers\manager;

use PDF;
use Carbon\Carbon;
use App\Models\Cuti;
use App\Models\Izin;
use App\Models\Karyawan;
use App\Exports\CutiExpor;
use App\Exports\IzinExpor;
use Illuminate\Http\Request;
use App\Models\SettingOrganisasi;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class CutiizinController extends Controller
{
    public function rekapcutiExcel(Request $request)
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $role= Auth::user()->role;
        $nbulan = $request->query('bulan', Carbon::now()->format('M Y'));

        $idkaryawan = $request->id_karyawan;
        $bulan      = $request->query('bulan', Carbon::now()->format('m'));
        $tahun      = $request->query('tahun', Carbon::now()->format('Y'));

        // simpan session
        $idkaryawan = $request->session()->get('idkaryawan');
        $bulan      = $request->session()->get('bulan');
        $tahun      = $request->session()->get('tahun',);

        if (isset($idkaryawan) && isset($bulan) && isset($tahun)) 
        {
            $data = Cuti::join('statuses', 'cuti.status', '=', 'statuses.id')
                ->leftjoin('jeniscuti','cuti.id_jeniscuti','jeniscuti.id')
                ->leftjoin('karyawan','cuti.id_karyawan','karyawan.id')
                ->leftjoin('alokasicuti','cuti.id_alokasi','alokasicuti.id')
                ->leftjoin('settingalokasi','cuti.id_settingalokasi','settingalokasi.id')
                ->leftjoin('datareject','datareject.id_cuti','cuti.id')
                ->leftjoin('departemen','cuti.departemen','departemen.id')
                ->where(function($query) use ($row){
                    $query->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                    ->orWhere(function($query) use ($row){
                        $query->where('karyawan.atasan_kedua',Auth::user()->id_pegawai);
                    });    
                })
                ->where('cuti.id_karyawan', $idkaryawan)
                ->whereMonth('cuti.tgl_mulai', $bulan)
                ->whereYear('cuti.tgl_mulai', $tahun)
                ->select('cuti.*', 'jeniscuti.jenis_cuti', 'karyawan.nama','karyawan.atasan_pertama','karyawan.atasan_kedua','statuses.name_status','datareject.alasan','departemen.nama_departemen')
                ->distinct()
                ->orderBy('cuti.id', 'desc')
                ->get(['cuti.*', 'statuses.name_status','karyawan.nama','departemen.nama_departemen','alokasicuti.tgl_masuk','alokasicuti.jatuhtempo_awal','alokasicuti.jatuhtempo_akhir']);
            // dd($data);
            return Excel::download(new CutiExpor($data, $idkaryawan), "Rekap Cuti Bulan " . $nbulan . " " . $data->first()->karyawans->nama . ".xlsx");
        } else {
            $data = Cuti::join('statuses', 'cuti.status', '=', 'statuses.id')
                ->leftjoin('alokasicuti', 'cuti.id_jeniscuti', 'alokasicuti.id_jeniscuti')
                ->leftjoin('settingalokasi', 'cuti.id_jeniscuti', 'settingalokasi.id_jeniscuti')
                ->leftjoin('jeniscuti', 'cuti.id_jeniscuti', 'jeniscuti.id')
                ->leftjoin('karyawan', 'cuti.id_karyawan', 'karyawan.id')
                ->leftjoin('datareject', 'datareject.id_cuti','cuti.id')
                ->leftjoin('departemen','cuti.departemen','departemen.id')
                ->where(function($query) use ($row){
                    $query->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                    ->orWhere(function($query) use ($row){
                        $query->where('karyawan.atasan_kedua',Auth::user()->id_pegawai);
                    });    
                })
                ->select('cuti.*', 'jeniscuti.jenis_cuti', 'departemen.nama_departemen', 'karyawan.nama','statuses.name_status', 'karyawan.atasan_pertama', 'karyawan.atasan_kedua', 'datareject.alasan as alasan', 'datareject.id_cuti as id_cuti')
                ->distinct()
                ->orderBy('cuti.id', 'DESC')
                ->get(['cuti.*', 'statuses.name_status','karyawan.nama','departemen.nama_departemen','alokasicuti.tgl_masuk','alokasicuti.jatuhtempo_awal','alokasicuti.jatuhtempo_akhir']);
            // return $data;
            return Excel::download(new CutiExpor($data, $idkaryawan), "Rekap Cuti Karyawan.xlsx");
        }
       
    }

    public function rekapcutipdf(Request $request)
    {
        $setorganisasi = SettingOrganisasi::find(1);
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

        if ($data->first()) {
            $pdfName = "Rekap Cuti Bulan " . $nbulan . " " . $data->first()->karyawans->nama . ".pdf";
        } else {
            $pdfName = "Rekapan Cuti Tidak Ditemukan.pdf";
        }

        $pdf = PDF::loadview('admin.cuti.cutipdf', ['data' => $data, 'idkaryawan' => $idkaryawan, 'setorganisasi'=> $setorganisasi])
            ->setPaper('a4', 'landscape');
        return $pdf->stream($pdfName);
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
                ->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                ->where('izin.id_karyawan', $idpegawai)
                ->whereMonth('izin.tgl_mulai', $month)
                ->whereYear('izin.tgl_mulai', $year)
                ->get(['izin.*', 'statuses.name_status','karyawan.nama','departemen.nama_departemen','jenisizin.jenis_izin']);
               
                return Excel::download(new IzinExpor($data, $idpegawai), "Rekap Izin Bulan " . $nbulan . " " . $data->first()->nama . ".xlsx");
        } else {
            $data = Izin::leftjoin('statuses', 'izin.status', '=', 'statuses.id')
                ->leftjoin('karyawan', 'izin.id_karyawan', '=', 'karyawan.id')
                ->leftjoin('departemen','izin.departemen','=','departemen.id')
                ->leftjoin('jenisizin','izin.id_jenisizin','=','jenisizin.id')
                ->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                ->get(['izin.*', 'statuses.name_status','karyawan.nama','departemen.nama_departemen','jenisizin.jenis_izin']);
            
            return Excel::download(new IzinExpor($data, $idpegawai), "Rekap Izin Karyawan.xlsx");
        }
       
    }

    public function rekapizinpdf(Request $request)
    {
        $setorganisasi = SettingOrganisasi::find(1);
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

        if ($data->first()) {
            $pdfName = "Rekap Izin Bulan " . $nbulan . " " . $data->first()->karyawans->nama . ".pdf";
        } else {
            $pdfName = "Rekapan Izin Tidak Ditemukan.pdf";
        }

        $pdf = PDF::loadview('admin.cuti.izinpdf', ['data' => $data, 'idpegawai' => $idpegawai,'setorganisasi'=> $setorganisasi])
            ->setPaper('a4', 'landscape');
        return $pdf->stream($pdfName);
    }
}
