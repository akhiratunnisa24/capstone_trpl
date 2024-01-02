<?php

namespace App\Http\Controllers\karyawan;

use PDF;
use Carbon\Carbon;
use App\Models\Absensi;
use App\Models\Karyawan;
use App\Models\Departemen;
use Illuminate\Http\Request;
use App\Models\SettingOrganisasi;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AbsensiPeroranganExport;

class AbsensiKaryawanController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $iduser = Auth::user()->id_pegawai;

        $bulan = $request->query('bulan');
        $tahun = $request->query('tahun');

        // Jika bulan dan tahun tidak ada dalam permintaan, gunakan bulan dan tahun saat ini
        $bulanSekarang = $bulan ?? Carbon::now()->format('m');
        $tahunSekarang = $tahun ?? Carbon::now()->format('Y');

        // Ambil data absensi hanya untuk bulan dan tahun yang sedang berjalan
        $absensi = Absensi::with('karyawans', 'departemens')
            ->where('id_karyawan', $iduser)
            ->whereMonth('tanggal', $bulanSekarang)
            ->whereYear('tanggal', $tahunSekarang)
            ->orderBy('id', 'desc')
            ->get();

        // Simpan bulan dan tahun ke dalam session
        $request->session()->put('bulan', $bulan);
        $request->session()->put('tahun', $tahun);

        return view('karyawan.absensi.history_absensi', compact('absensi', 'row'));
    }



    // public function index(Request $request)
    // {
    //     $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
    //      //$absensi = Absensi::latest()->where('id_karyawan',Auth::user()->id_pegawai)->orderBy('tanggal')->get();
    //     $iduser = Auth::user()->id_pegawai;

    //     $bulan = $request->query('bulan',Carbon::now()->format('m'));
    //     $tahun = $request->query('tahun',Carbon::now()->format('Y'));

    //     // simpan session
    //     $request->session()->put('bulan', $bulan);
    //     $request->session()->put('tahun', $tahun);

    //     $absensi = Absensi::where('id_karyawan', $iduser)->get();
    //     dd($absensi);
    //     if(isset($bulan) && isset($tahun))
    //     {
    //         $absensi = Absensi::with('karyawans','departemens')
    //             ->where('id_karyawan', $iduser)
    //             ->whereMonth('tanggal', $bulan)
    //             ->whereYear('tanggal',$tahun)
    //             ->get();
    //     }
    //     return view('karyawan.absensi.history_absensi',compact('absensi','row'));

    //     //menghapus filter data
    //     $request->session()->forget('bulan');
    //     $request->session()->forget('tahun');
    // }

    public function absensiPeroranganExcel(Request $request)
    {
        $iduser = Auth::user()->id_pegawai;
        $nama   = Karyawan::where('id', '=', $iduser)->first();

        $bulan  = $request->query('bulan', Carbon::now()->format('m'));
        $tahun  = $request->query('tahun', Carbon::now()->format('Y'));

        // Cek apakah bulan dan tahun diatur dalam permintaan
        if (isset($bulan) && isset($tahun)) {
            $data = Absensi::with('karyawans', 'departemens')
                ->where('id_karyawan', $iduser)
                ->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun)
                ->get();

            $namaBulan = Carbon::createFromDate(null, $bulan, null)->locale('id')->monthName;
            $nbulan    = $namaBulan . ' ' . $tahun;
        } else {
            // Jika tidak ada filter yang diatur, ambil data untuk bulan saat ini
            $data = Absensi::with('karyawans', 'departemens')
                ->where('id_karyawan', $iduser)
                ->whereMonth('tanggal', Carbon::now()->format('m'))
                ->whereYear('tanggal', Carbon::now()->format('Y'))
                ->get();

            $nbulan = Carbon::now()->locale('id')->monthName . ' ' . Carbon::now()->year;
        }

        if ($data->isEmpty()) {
            return redirect()->back()->with('pesa', 'Tidak Ada Data');
        } else {
            return Excel::download(new AbsensiPeroranganExport($data, $iduser), "Rekap Absensi {$nama->nama} {$nbulan}.xlsx");
        }
    }


    public function absensiPeroranganPdf(Request $request)
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $setorganisasi = SettingOrganisasi::where('partner', Auth::user()->partner)->first();
        $iduser = Auth::user()->id_pegawai;

        $nama = Karyawan::where('id', '=', $iduser)->first();

        $bulan = $request->query('bulan', Carbon::now()->format('m'));
        $tahun = $request->query('tahun', Carbon::now()->format('Y'));

        // Jika bulan dan tahun tidak disetel dalam permintaan, gunakan bulan dan tahun saat ini
        if (!$request->has('bulan') || !$request->has('tahun')) {
            $bulan = Carbon::now()->format('m');
            $tahun = Carbon::now()->format('Y');
        } else {
            // Simpan session jika bulan dan tahun disetel dalam permintaan
            $request->session()->put('bulan', $bulan);
            $request->session()->put('tahun', $tahun);
        }

        $namaBulan = Carbon::createFromDate(null, $bulan, null)->locale('id')->monthName;
        $nbulan = $namaBulan . ' ' . $tahun;

        $data = Absensi::with('karyawans', 'departemens')
            ->where('id_karyawan', $iduser)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get();

        if ($data->isEmpty()) {
            return redirect()->back()->with('pesa', 'Tidak Data Ada.');
        } else {

            $nama = Karyawan::where('id', $iduser)->first();
            $departemen = Departemen::where('id', $nama->divisi)->first();
            $pdf = PDF::loadview('karyawan.absensi.absensistaff_pdf', ['data' => $data, 'departemen' => $departemen, 'iduser' => $iduser, 'nama' => $nama, 'nbulan' => $nbulan, 'setorganisasi' => $setorganisasi])
                ->setPaper('A4', 'landscape');

            return $pdf->stream("Report Absensi {$nama->nama} Bulan {$nbulan}.pdf");
        }
    }
}
