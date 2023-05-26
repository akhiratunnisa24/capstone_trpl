<?php

namespace App\Http\Controllers\admin;


use Carbon\Carbon;
use App\Models\Jadwal;
use App\Models\Absensi;
use App\Models\Karyawan;
use App\Models\Departemen;
use App\Models\Tidakmasuk;

use App\Exports\AbsensisExport;
// use App\Imports\AttendancesImport;
use Illuminate\Http\Request;
use App\Imports\AbsensiImport;
use App\Imports\AbsensisImport;
use App\Http\Controllers\Controller;
use App\Models\SettingOrganisasi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class AbsensisController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function importexcel(Request $request)
    {
       
        try {
            $file = $request->file('file');
            $import = new AbsensisImport();
            Excel::import($import, $file);
            
            // $jumlahdatadiimport = $import->getJumlahDataDiimport();//SUDAH BENAR 12
            // $jumlahdata         = $import->getJumlahData(); //SUDAH BENAR 22
            // $jumlahimporttidakmasuk =$import->getDataImportTidakMasuk(); //SUDAH BENAR 1
            // $datatidakbisadiimport  = $import->getDatatTidakBisaDiimport(); // 9

            // $pesan = "Data diimport ke Absensi &nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:  <strong>" . $import->getJumlahDataDiimport() . "</strong>" . "<br>" .
            // "Data diimport ke Tidak Masuk: <strong>" . $import->getDataImportTidakMasuk() . "</strong>" . "<br>" .
            // "Data tidak bisa diimport &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <strong>" . $import->getDatatTidakBisaDiimport() . "</strong>" . "<br>" .
            // "Jumlah Data Keseluruhan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <strong>" . $import->getJumlahData(). "</strong>";
           
            // // dd($pesan);
            // $pesan = '<div class="text-left" style="margin-left: 75px;">' . $pesan . '</div>';
            // $pesan = nl2br(html_entity_decode($pesan));
            // return redirect()->back()->with('pesan', $pesan);  
                
        }catch (\Throwable $th) {
            // Tangani jika terjadi kesalahan
            return redirect()->back()->with('pesa', 'Terjadi kesalahan saat mengimport data dari Excel.');
        }
    }


    public function importcsv(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:csv|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        try {
            $import = new AbsensisImport();
            Excel::import($import, $request->file('file'));

            // $pesan = "Data diimport ke Absensi &nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:  <strong>" . $import->getJumlahDataDiimport() . "</strong>" . "<br>" .
            // "Data diimport ke Tidak Masuk: <strong>" . $import->getDataImportTidakMasuk() . "</strong>" . "<br>" .
            // "Data tidak bisa diimport &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <strong>" . $import->getDatatTidakBisaDiimport() . "</strong>" . "<br>" .
            // "Jumlah Data Keseluruhan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <strong>" . $import->getJumlahData(). "</strong>";

            $pesan = '<div class="text-left" style="margin-left: 75px;">' . $pesan . '</div>';
            $pesan = nl2br(html_entity_decode($pesan));
            return redirect()->back()->with('pesan', $pesan);

        } catch (\Throwable $th) {
            // Tangani jika terjadi kesalahan
            return redirect()->back()->with('pesa', 'Terjadi kesalahan saat mengimport data dari CSV.');
        }
    }
}
