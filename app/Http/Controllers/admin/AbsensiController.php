<?php

namespace App\Http\Controllers\admin;

use PDF;
use Carbon\Carbon;
use App\Models\Cuti;
use App\Models\Izin;
use App\Helpers\Parse;
use App\Models\Jadwal;
use App\Models\Absensi;
use App\Models\Karyawan;
use App\Models\Jeniscuti;
use App\Models\Jenisizin;

use App\Models\Departemen;
use App\Models\Tidakmasuk;
use Illuminate\Http\Request;
use App\Exports\AbsensiExport;
use App\Helpers\AbsensiHelper;
use App\Helpers\NetworkHelper;
use App\Imports\AbsensiImport;
use App\Imports\AbsensixlsImport;
use App\Imports\AttendanceImport;
use App\Models\SettingOrganisasi;
use Illuminate\Support\Facades\DB;
use App\Exports\RekapabsensiExport;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
// require_once app_path('Helpers/Parse.php');


use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use App\Http\Controllers\API\AbsensiRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;


class AbsensiController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $role = Auth::user()->role;
        
        if ($role == 1 || $role == 2 ) {
            //filter data
            $karyawan = Karyawan::all();

            $idkaryawan = $request->id_karyawan;
            $bulan = $request->query('bulan',Carbon::now()->format('m'));
            $tahun = $request->query('tahun',Carbon::now()->format('Y'));

            // simpan session
            $request->session()->put('idkaryawan', $request->id_karyawan);
            $request->session()->put('bulan', $bulan);
            $request->session()->put('tahun', $tahun);
    
            if(isset($idkaryawan) && isset($bulan) && isset($tahun))
            {
                $absensi = Absensi::with('karyawans','departemens')
                ->where('id_karyawan', $idkaryawan)
                ->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal',$tahun)
                ->get();
            }else
            {
                $absensi = Absensi::with('karyawans','departemens')
                ->orderBy('tanggal','desc')
                ->get();
            }
            return view('admin.absensi.index',compact('absensi','karyawan','row','role'));
        
            //menghapus filter data
            $request->session()->forget('id_karyawan');
            $request->session()->forget('bulan');
            $request->session()->forget('tahun');

        }elseif(($role == 1) || $role == 2)
        {
            $karyawan = Karyawan::all();

            $idkaryawan = $request->id_karyawan;
            $bulan = $request->query('bulan',Carbon::now()->format('m'));
            $tahun = $request->query('tahun',Carbon::now()->format('Y'));

            // simpan session
            $request->session()->put('idkaryawan', $request->id_karyawan);
            $request->session()->put('bulan', $bulan);
            $request->session()->put('tahun', $tahun);
    
            if(isset($idkaryawan) && isset($bulan) && isset($tahun))
            {
                $absensi = Absensi::with('karyawans','departemens')->where('id_karyawan', $idkaryawan)
                ->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal',$tahun)
                ->get();
            }else
            {
                $absensi = Absensi::with('karyawans','departemens')
                ->orderBy('tanggal','desc')
                ->get();
            }
            return view('admin.absensi.index',compact('absensi','karyawan','row','role'));
        
            //menghapus filter data
            $request->session()->forget('id_karyawan');
            $request->session()->forget('bulan');
            $request->session()->forget('tahun');
        }
        else
         {
        
            return redirect()->back(); 
        }
    }

    public function create()
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        // $absensi=Absensi::where('id_user',Auth::user()->id)
        $absensi=Absensi::where('id_karyawan',Auth::user()->id_pegawai)
            ->whereDate('tanggal', Carbon::now()->format("Y-m-d"))
            ->first();//untuk memunculkan data absen pagi dengan pengecekan tanggal

        $jadwalkaryawan = Jadwal::join('shift','jadwal.id_shift','shift.id')
            ->where('jadwal.id_pegawai',Auth::user()->id_pegawai)
            ->whereDate('jadwal.tanggal', Carbon::now()->format("Y-m-d"))
            ->select('jadwal.*','shift.id as idshift','shift.nama_shift')
            ->first();

        $tidakmasuk=Tidakmasuk::where('id_pegawai',Auth::user()->id_pegawai)
            ->whereDate('tanggal', Carbon::now()->format("Y-m-d"))
            ->first();//untuk memunculkan data absen pagi dengan pengecekan tanggal
        $status = Tidakmasuk::where('id_pegawai', Auth::user()->id_pegawai)->first();

        // dd($status);
        // $jk =  Carbon::now()->format("H:i:s");
        return view('karyawan.absensi.absensi_karyawan',compact('absensi','row','status','jadwalkaryawan'));
    }

    public function store(Request $request)
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        //ambil data karyawan dari tabel user dan pengecekan ke tabel karyawan
        $karyawan = Auth::user()->id_pegawai;
        //$depart = Karyawan::select('divisi')->where('id','=', Auth::user()->id_pegawai)->first();
        $depart = DB::table('karyawan')->join('departemen', 'karyawan.divisi','=','departemen.id')
                  ->where('karyawan.id','=',Auth::user()->id_pegawai)->first();
        
        $jadwalkaryawan = Jadwal::join('shift','jadwal.id_shift','shift.id')
            ->where('jadwal.id_pegawai',Auth::user()->id_pegawai)
            ->whereDate('jadwal.tanggal', Carbon::now()->format("Y-m-d"))
            ->select('jadwal.*','shift.id as idshift','shift.nama_shift')
            ->first();

        // dd($depart);

        //mencari nilai keterlambatan karyawan
        // $jdm = '08:00:00';
        // $jdm = Carbon::createFromFormat('H:i:s', '08:00:00');
        $jdm= $jadwalkaryawan->jadwal_masuk;
        $jm = Carbon::now()->format("H:i:s");
        $jmas= Carbon::parse($jm);
        $tl= $jmas->diff($jdm)->format("%H:%I:%S");

        //kalau pakai button, tidak perlu adanya validasi, yg memakai validasi adalah data yg diambil dengan menggunakan form
        $absensi = New Absensi;
        $absensi->id_karyawan  = $karyawan;
        $absensi->nik          = null;
        $absensi->tanggal      = Carbon::now()->format("Y-m-d");
        $absensi->shift        = $jadwalkaryawan->nama_shift;
        $absensi->jadwal_masuk = $jdm;
        // $absensi->jadwal_masuk = $jadwalkaryawan->jadwal_masuk;
        $absensi->jadwal_pulang= $jadwalkaryawan->jadwal_pulang;
        $absensi->jam_masuk    = $jmas;
        $absensi->jam_keluar   = null;
        $absensi->normal       = '1';
        $absensi->riil         = '0';
        $absensi->terlambat    = $tl;
        $absensi->plg_cepat    = null;
        $absensi->absent       = null;
        $absensi->lembur       = null;
        $absensi->jml_jamkerja = null;
        $absensi->pengecualian = null;
        $absensi->hci          = 'True';
        $absensi->hco          = 'True';
        $absensi->id_departement= $depart->divisi;
        $absensi->h_normal     = 0;
        $absensi->ap           = 0;
        $absensi->hl           = 0;
        $absensi->jam_kerja    = $tl;
        $absensi->lemhanor     = 0;
        $absensi->lemakpek     = 0;
        $absensi->lemhali      = 0;

        $absensi->save();
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $absensi = Absensi::where('id',$id)->first(); //mendapatkan data absensi berdasarkan id masing2 user
        //mencari jumlah kehadiran
        $jadwalkaryawan = Jadwal::join('shift','jadwal.id_shift','shift.id')
            ->where('jadwal.id_pegawai',Auth::user()->id_pegawai)
            ->whereDate('jadwal.tanggal', Carbon::now()->format("Y-m-d"))
            ->select('jadwal.*','shift.id as idshift','shift.nama_shift')
            ->first();

        $jk = Carbon::now()->format("H:i:s"); //mendapatkan jam_keluar pada saat ini
        $aw=Carbon::parse($absensi->jam_masuk);//mendapatkan data jam masuk
        $ak=Carbon::parse($jk);//mendapatkan data jam keluar yang disimpan pada variabel $jk
        $diff=$aw->diff($ak)->format("%H:%I:%S");//mencari jumlah jam kerja pegawai pada hari itu yang nantinya disimpan ke dalam database

        // mencari value apakah pegawai pulang cepat
        // $jdp = "17:00:00";
        // $jdp = $jadwalkaryawan->jadwal_pulang;
        // // return $jdp;
        // $jdplg= Carbon::parse($jdp);
        // $jp = $ak;//jadwal pulang sama nilainya dengan $ak
        // $plcpt= $jdplg->diff($jp)->format("%H:%I:%S");//value untuk pulang cepat

        
        // Mencari value apakah pegawai pulang cepat
        // $jdp = $jadwalkaryawan->jadwal_pulang;
        // $jdplg = Carbon::parse($jdp);
        // $jp = $ak; // Jadwal pulang sama nilainya dengan $ak
        // $plcpt = $jp->diff($jdplg)->format("%H:%I:%S"); // Value untuk pulang cepat
        // Mencari value apakah pegawai pulang cepat
        $jdp = $jadwalkaryawan->jadwal_pulang ;
        $jdplg = Carbon::parse($jdp);
        $jp = $ak; // Jadwal pulang sama nilainya dengan $ak

        // Periksa apakah karyawan pulang sebelum jadwal_pulang_default
        if ($jp < $jdplg) {
            $plcpt = $jp->diff($jdplg)->format("%H:%I:%S"); // Value untuk pulang cepat
        } else {
            $plcpt = "00:00:00"; // Karyawan tidak pulang cepat
        }

        //mencari jumlah jam kerja karyawan.
        $aw  = Carbon::parse($absensi->jadwal_masuk);
        $ak  = Carbon::parse($absensi->jadwal_pulang);
        $scan_aw  = Carbon::parse($absensi->jam_masuk);
        $scan_ak  = Carbon::parse($jk);

        // Periksa apakah karyawan scan_masuk lebih awal dari jadwal_masuk
        if ($scan_aw < $aw) {
            $scan_aw = $aw; // Gunakan jadwal_masuk sebagai waktu awal
        }

        // Periksa apakah karyawan scan_pulang lebih lambat dari jadwal_pulang
        if ($scan_ak > $ak) {
            $scan_ak = $ak; // Gunakan jadwal_pulang sebagai waktu akhir
        }

        $jkerja = $scan_aw->diff($scan_ak)->format("%H:%I:%S");
        // dd($aw,$ak,$scan_aw,$scan_ak,$jkerja);

        //update data abbsensi
        Absensi::where('id',$id)->update([
            'jadwal_pulang' => $jdp,
            'jam_keluar' => $jk,
            'jam_kerja' =>$diff,
            'plg_cepat' =>$plcpt,
            'jml_jamkerja' =>$jkerja,
        ]);

        $absensi = Absensi::where('id',$id)->first();
        // return $absensi;

        return redirect()->back()->withInput();
    }

    // public function exportpdf()
    // {
    //      //export data to pdf
    //      $data = Absensi::get();
    //      $pdf = PDF::loadview('admin.absensi.absensipdf',['data',$data],compact('data'))
    //      ->setPaper('A4','landscape');
    //      return $pdf->stream('absensi_report.pdf');

        //mencari jumlah jam kerja harian yang ditampilkan ke dalam pdf secara manual
        //    foreach($data as $key => $value){
        //jika jam keluar isinya null atau tidak ada
        //     $data[$key]['diff'] = null;
            //jika jam_masuk dan jam_keluar ada data
        //     if($value->jam_masuk != null && $value->jam_keluar != null ){
        //         $aw=Carbon::parse($value->jam_masuk);
        //         $ak=Carbon::parse($value->jam_keluar);
        //         $diff=$aw->diff($ak)->format("%H:%I:%S");
        //         $data[$key]['diff'] = $diff;
        //     }   

    //     }
        // dd($data->toArray());
    // }

    // public function exportExcel()
    // {
    //     return Excel::download(new AbsensiExport, 'data_absensi.xlsx');
    // }

    public function importexcel(Request $request)
    {
        try {
            // $file = $request->file('file');
            // $import = new AbsensiImport();
            // Excel::import($import, $file);
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $format = ($extension === 'xls') ? \Maatwebsite\Excel\Excel::XLS : \Maatwebsite\Excel\Excel::XLSX;
            $import = new AbsensiImport();
            Excel::import($import, $file,$format);

            dd($import->getJumlahDataDiimport(),$import->getDataImportTidakMasuk(),$import->getJumlahData());
            
            $pesan = "Data diimport ke Absensi &nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:  <strong>" . $import->getJumlahDataDiimport() . "</strong>" . "<br>" .
            "Data diimport ke Tidak Masuk: <strong>" . $import->getDataImportTidakMasuk() . "</strong>" . "<br>" .
            "Data tidak bisa diimport &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <strong>" . $import->getDatatTidakBisaDiimport() . "</strong>" . "<br>" .
            "Jumlah Data Keseluruhan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <strong>" . $import->getJumlahData(). "</strong>";
            // return $pesan;
        
            $pesan = '<div class="text-left" style="margin-left: 75px;">' . $pesan . '</div>';
            // return $pesan;
            $pesan = nl2br(html_entity_decode($pesan));
            return redirect()->back()->with('pesan', $pesan);  
                
        }catch (\Throwable $th) {
            // Tangani jika terjadi kesalahan
            return redirect()->back()->with('pesa', 'Terjadi kesalahan saat mengimport data dari Excel.');
        }
    }

    public function importdataexcel(Request $request)
    {
        $request->validate([
            'uploaded_file' => 'required|mimes:xls,xlsx',
        ]);

        $file = $request->file('uploaded_file');
        $extension = $file->getClientOriginalExtension();
        dd($file, $extension);
        
        $spreadsheet = IOFactory::load($file);

        $worksheet = $spreadsheet->getActiveSheet();
        $data = $worksheet->toArray();
        // Ambil header
        $header = $data[0];
        for ($i = 1; $i < count($data); $i++) {
            // Ambil data pada baris saat ini
            $rowData = $data[$i];
        
            // Buat array asosiatif menggunakan header sebagai kunci
            $row = [];
            for ($j = 0; $j < count($rowData); $j++) {
                $row[$header[$j]] = $rowData[$j];
            }
            // dd($row);
            if (isset($row['NIK']) && isset($row['Tanggal'])) 
            {
                $karyawan = Karyawan::where('nik', $row['NIK'])->first();
                
                if(isset($karyawan))
                {
                    $tgl = \Carbon\Carbon::createFromFormat('d/m/Y', $row['Tanggal'])->format('Y-m-d');
                    // dd($row,$tgl);
                    $absensicek = !Absensi::where('id_karyawan',$karyawan->id)->where('tanggal',$tgl)->first();
                    
                    if($absensicek)
                    {
                        $scan_masuk = $row['Scan Masuk'];
                        $scan_pulang= $row['Scan Pulang']; 

                        if($scan_masuk === "" && $scan_pulang === "")
                        {
                            $cuti = Cuti::where('id_karyawan', $karyawan->id)
                                ->whereDate('tgl_mulai', '<=', $tgl)
                                ->whereDate('tgl_selesai', '>=', $tgl)
                                ->where('status', 7)
                                ->select('cuti.id as id_cuti','cuti.id_karyawan','cuti.id_jeniscuti','cuti.tgl_mulai','cuti.tgl_selesai','cuti.status')
                                ->first();

                            $nama = Karyawan::where('id',$karyawan->id)->select('nama','divisi')->first();
                            
                            if($cuti !== NULL) 
                            {

                                $reason = Jeniscuti::where('id',$cuti->id_jeniscuti)->select('jenis_cuti')->first();
    
                                for($date = Carbon::parse($cuti->tgl_mulai);$date->lte(Carbon::parse($cuti->tgl_selesai)); $date->addDay())
                                {
                                    $cek = Tidakmasuk::where('id_pegawai', $cuti->id_karyawan)->where('tanggal', $date->format('Y-m-d'))->first();
                                    if(!$cek){
                                        $tidakmasuk = new Tidakmasuk;
                                        $tidakmasuk->id_pegawai = $cuti->id_karyawan;
                                        $tidakmasuk->nama       = $nama->nama;
                                        $tidakmasuk->divisi     = $nama->divisi;
                                        $tidakmasuk->status     = $reason->jenis_cuti;
                                        $tidakmasuk->tanggal    = $date->format('Y-m-d');

                                        dd($tidakmasuk);
                                        $tidakmasuk->save();
    
                                        // $this->jumlahDataTidakMasuk++; // Increment jumlah data tidak masuk
                                        // $this->jumlahimporttidakmasuk++;
                                    }
                                }
                            }
                            else
                            {
                                $izin = Izin::where('id_karyawan','=',$karyawan->id)
                                    ->whereDate('tgl_mulai', '<=', $tgl)
                                    ->whereDate('tgl_selesai', '>=', $tgl)
                                    ->where('status',7)
                                    ->select('izin.id','izin.id_karyawan','izin.id_jenisizin','izin.tgl_mulai','izin.tgl_selesai','izin.status')
                                    ->first();
                                // dd($izin);
                                if($izin !== NULL)
                                {
                                    dd($izin);
                                    if($izin->id_jenisizin !== 5)
                                    {
                                        $reason = Jenisizin::where('id',$izin->id_jenisizin)->select('jenis_izin')->first();
    
                                        for($date = Carbon::parse($izin->tgl_mulai);$date->lte(Carbon::parse($izin->tgl_selesai)); $date->addDay())
                                        {
                                            $cek = Tidakmasuk::where('id_pegawai', $izin->id_karyawan)->where('tanggal', $date->format('Y-m-d'))->first();
                                            if(!$cek)
                                            {
                                                $tidakmasuk = new Tidakmasuk;
                                                $tidakmasuk->id_pegawai = $izin->id_karyawan;
                                                $tidakmasuk->nama       = $nama->nama;
                                                $tidakmasuk->divisi     = $nama->divisi;
                                                $tidakmasuk->status     = $reason->jenis_izin;
                                                $tidakmasuk->tanggal    = $date->format('Y-m-d');
                                                $tidakmasuk->save();
                                                
                                            }
                                        }
                                    }
                                }
                                else
                                {
                                    // dd($izin);
                                    $cek = Tidakmasuk::where('id_pegawai', $karyawan->id)->where('tanggal',$tgl)->first();
                                    // dd($cek);
                                    //jika tidak ada data atau $cek == null
                                    if(!$cek)
                                    {
                                        // dd($cek);
                                        $nama = Karyawan::where('nik',$row['NIK'])->first();
                                        // dd($nama);
                                        $tidakmasuk = new Tidakmasuk;
                                        $tidakmasuk->id_pegawai = $nama->id;
                                        $tidakmasuk->nama       = $nama->nama;
                                        $tidakmasuk->divisi     = $nama->divisi;
                                        $tidakmasuk->status     = 'tanpa keterangan';
                                        $tidakmasuk->tanggal    = $tgl;
                                
                                        // dd($tidakmasuk);
                                        $tidakmasuk->save();
                                        // dd($tidakmasuk);

                                    }
                                    else{
    
                                        // dd($cek);
                                        Log::info('Data tidak masuk karyawan sudah ada');
                                    }
                                } 
                            }
                            
                        }
                        else
                        {
                            dd($data);
                            $jam_excel = [
                                'Jam Masuk'   => $row['Jam Masuk'],
                                'Jam Pulang'  => $row['Jam Pulang'],
                                'Scan Masuk'  => $row['Scan Masuk'],
                                'Scan Pulang' => $row['Scan Pulang'],
                                'Terlambat'   => $row['Terlambat'],
                                'Plg. Cepat'  => $row['Plg. Cepat'],
                                'Lembur'      => $row['Lembur'],
                                'Jml Jam Kerja'   => $row['Jml Jam Kerja'],
                                'Jml Kehadiran'   => $row['Jml Kehadiran'],
                            ];

                            $formatted_jam = [];
                        
                            foreach ($jam_excel as $key => $value) {
                                if (!empty($value)) {
                                    $time = Carbon::createFromFormat('H.i', $value); // Create Carbon instance from the time string
                                    $formatted_jam[$key] = $time->format('H:i:s'); // Format the time as HH:MM:SS
                                } else {
                                    $formatted_jam[$key] = null; // Assign null if the value is empty
                                }
                            }

                            $data = [
                                'id_karyawan'   => $karyawan->id,
                                'nik'           => $karyawan->nip ?? null,
                                'tanggal'       => $tgl,
                                'shift'         => null,
                                'jadwal_masuk'  => isset($formatted_jam['Jam Masuk']) ? $formatted_jam['Jam Masuk'] : null,
                                'jadwal_pulang' => isset($formatted_jam['Jam Pulang']) ? $formatted_jam['Jam Pulang'] : null,
                                'jam_masuk'     => isset($formatted_jam['Scan Masuk']) ? $formatted_jam['Scan Masuk'] : null,
                                'jam_keluar'    => isset($formatted_jam['Scan Pulang']) ? $formatted_jam['Scan Pulang'] : null,
                                'normal'        => null,
                                'riil'          => null,
                                'terlambat'     => isset($formatted_jam['Terlambat']) ? $formatted_jam['Terlambat'] : null,
                                'plg_cepat'     => isset($formatted_jam['Plg. Cepat']) ? $formatted_jam['Plg. Cepat'] : null,
                                'absent'        => null,
                                'lembur'        => isset($formatted_jam['Lembur']) ? $formatted_jam['Lembur'] : null,
                                'jml_jamkerja'  => isset($formatted_jam['Jml Jam Kerja']) ? $formatted_jam['Jml Jam Kerja'] : null,
                                'pengecualian'  => null,
                                'hci'           => null,
                                'hco'           => null,
                                'id_departement'=> $karyawan->divisi,
                                'h_normal'      => null,
                                'ap'            => null,
                                'hl'            => null,
                                'jam_kerja'     => isset($formatted_jam['Jml Kehadiran']) ? $formatted_jam['Jml Kehadiran'] : null,
                                'lemhanor'      => null,
                                'lemakpek'      => null,
                                'lemhali'       => null,                
                            ];
                            //  dd($data);
                            $absensi = Absensi::create($data);
                        }
                    }
                    else
                    {
                        Log::info('Data sudah ada di sistem');    
                    }

                }
                else
                {
                    Log::info('Karyawan tidak terdaftar di sistem');
                }
            }
            else
            {
                return "NIK Kosong";
                Log::info('NIK karyawan kosong');
            }
            // dd($rowDataAssoc['Emp No.'],$rowDataAssoc['Nama'],$rowDataAssoc['Scan Pulang'],$rowDataAssoc['Jml Jam Kerja']);
        }

        return redirect()->back()->with('pesan','Data berhasil di Import');
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
            $import = new AbsensiImport();
            Excel::import($import, $request->file('file'));

            $pesan = "Data diimport ke Absensi &nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:  <strong>" . $import->getJumlahDataDiimport() . "</strong>" . "<br>" .
            "Data diimport ke Tidak Masuk: <strong>" . $import->getDataImportTidakMasuk() . "</strong>" . "<br>" .
            "Data tidak bisa diimport &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <strong>" . $import->getDatatTidakBisaDiimport() . "</strong>" . "<br>" .
            "Jumlah Data Keseluruhan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <strong>" . $import->getJumlahData(). "</strong>";

            $pesan = '<div class="text-left" style="margin-left: 75px;">' . $pesan . '</div>';
            $pesan = nl2br(html_entity_decode($pesan));
            return redirect()->back()->with('pesan', $pesan);

        } catch (\Throwable $th) {
            // Tangani jika terjadi kesalahan
            return redirect()->back()->with('pesa', 'Terjadi kesalahan saat mengimport data dari CSV.');
        }
    }

    public function rekapabsensipdf(Request $request)
    {
        $setorganisasi = SettingOrganisasi::find(1);
        $nbulan = $request->query('bulan',Carbon::now()->format('M Y'));

        $idkaryawan = $request->id_karyawan;
        $bulan      = $request->query('bulan',Carbon::now()->format('m'));
        $tahun      = $request->query('tahun',Carbon::now()->format('Y'));

        // simpan session
        $idkaryawan = $request->session()->get('idkaryawan');
        $bulan      = $request->session()->get('bulan');
        $tahun      = $request->session()->get('tahun');

        $namaBulan = Carbon::createFromDate(null, $bulan, null)->locale('id')->monthName;
        $nbulan    = $namaBulan . ' ' . $tahun;

        // dd($idkaryawan,$bulan,$tahun );
    
        if(isset($idkaryawan) && isset($bulan) && isset($tahun))
        {
            $data = Absensi::where('id_karyawan', $idkaryawan)
                ->with('karyawans','departemens')
                ->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal',$tahun)
                ->get();
        }else{
            $data = Absensi::with('departemens','karyawans')->get();
        }

        if ($data->isEmpty()) 
        {
            return redirect()->back()->with('pesa','Tidak Data Ada.');
        } else {
            $pdfName = "Rekap Absensi Bulan ".$nbulan." ".$data->first()->karyawans->nama.".pdf";
            $pdf = PDF::loadview('admin.absensi.rekapabsensipdf',['data'=>$data, 'idkaryawan'=>$idkaryawan,'nbulan'=>$nbulan,'setorganisasi'=> $setorganisasi])
            ->setPaper('a4','landscape');
            // return $pdf->stream("Rekap Absensi Bulan ".$nbulan." ".$data->first()->karyawans->nama.".pdf");
            return $pdf->stream($pdfName);
        } 
    }

    public function rekapabsensiExcel(Request $request)
    {
        $nbulan = $request->query('bulan',Carbon::now()->format('M Y'));

        $idkaryawan = $request->id_karyawan;
        $bulan      = $request->query('bulan',Carbon::now()->format('m'));
        $tahun      = $request->query('tahun',Carbon::now()->format('Y'));

        // simpan session
        $idkaryawan = $request->session()->get('idkaryawan');
        $bulan      = $request->session()->get('bulan');
        $tahun      = $request->session()->get('tahun',);
    
        if(isset($idkaryawan) && isset($bulan) && isset($tahun))
        {
            $data = Absensi::with('karyawans','departemens')
            ->where('id_karyawan', $idkaryawan)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal',$tahun)
            ->get();
            // dd($data);
            if ($data->isEmpty()) 
            {
                return redirect()->back()->with('pesa','Tidak Ada Data');
            } else {
                return Excel::download(new RekapabsensiExport($data,$idkaryawan),"Rekap Absensi Bulan ".$nbulan." ".$data->first()->karyawans->nama.".xlsx");
            }  
        }else{
            $data = Absensi::with('karyawans','departemens')
            ->get();

            if ($data->isEmpty()) 
            {
                return redirect()->back()->with('pesa','Tidak Ada Data');
            } else {
                return Excel::download(new RekapabsensiExport($data,$idkaryawan),"Rekap Absensi Bulan " . $nbulan .".xlsx");
            }  
        }

        
    }

    public function storeTidakmasuk(Request $data)
    {
        $karyawan = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $status = Tidakmasuk::where('id', Auth::user()->id_pegawai)->first();
        $depart = DB::table('karyawan')->join('departemen', 'karyawan.divisi','=','departemen.id')
                  ->where('karyawan.id','=',Auth::user()->id_pegawai)->first();
 
        $tidakmasuk = array(
            'id_pegawai' => $karyawan->id,
            'nama' => $karyawan->nama,
            'divisi' => $karyawan->divisi,
            'status' => $data->post('status'),
            'tanggal' => Carbon::now()->format("Y-m-d"),
        );

        $absensi = array(
            'id_karyawan' => $karyawan->id,
            'tanggal' => Carbon::now()->format("Y-m-d"),
            'shift' => 'NORMAL' ,
            'jadwal_masuk' => '08:00:00' ,
            'jadwal_pulang' => '17:00:00' ,
            'normal' => '1' ,
            'riil' => '0' ,
            'absent' => 'True' ,
            'hci' => 'True' ,
            'hco' => 'True' ,
            'h_normal' => 0,
            'ap' => 0,
            'hl' => 0,
            'lemhanor' => 0,
            'lemakpek' => 0,
            'lemhali' => 0,
        );
        // dd($absensi); 

        Tidakmasuk::insert($tidakmasuk);
        Absensi::insert($absensi);

        return redirect()->back();
    }

    //Fungsi tes koneksi ke Ip lain

    public function someControllerMethod()
    {
        $ipAddress = '192.168.1.58';
        $networkHelper = new NetworkHelper();
        $isConnected = $networkHelper->connectToIP($ipAddress);


        if ($isConnected) {
            // Koneksi berhasil
            return view('konekip');
            // return "Berhasil Terkoneksi ke ". $IP. " tersebut";
        } else {
            return view('tidakkonekip');
            // return "Koneksi ke IP " . $IP . " Gagal";
        }

        // $networkHelper = new NetworkHelper();
        // $isConnected = $networkHelper->connectToIP('192.168.1.43');

        // if ($isConnected) {
        //     // Koneksi berhasil
        //     return view('konekip');
        // } else {
        //     // Koneksi gagal
        //     return view('tidakkonekip');
        // }

       

    }

    public function indexs(Request $request)
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        return view('php.tarik-data');
    }

    public function tarikdata(Request $request)
    {
        // $IP = '192.168.1.96';
        $IP = '192.168.0.183';
        $absensiHelper = new absensiHelper();
        $isConnected = $absensiHelper->connectToIP($IP);
        
        if ($isConnected) {
            // Koneksi berhasil
            return 'Berhasil terkoneksi ke '. $IP;
            // return view('konekip');
            // return "Berhasil Terkoneksi ke ". $IP. " tersebut";
        } else {
            return response()->json([
                'message' => 'Koneksi Gagal',
                'IP' => $IP
              ]);
            // return 'Gagal terkoneksi ke '. $IP;
            // return view('tidakkonekip');
            // return "Koneksi ke IP " . $IP . " Gagal";
        }

    }

    public function showDownloadLogForm()
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $IP = "192.168.0.183";
        $Key = "10";

        return view('php.tarik-data', compact('IP', 'Key','row'));
    }

    //untuk xmlrpcrequest yang memakai form dan ke ip lain
    public function downloadLogDatas(Request $request)
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $IP = $request->input('ip', '192.168.0.183');
        $Key = $request->input('key', '0');

        $absensiRequest = new AbsensiRequest();
        $logData = $absensiRequest->xmlRpcRequest($IP,$Key);

        if ($logData === null) {
            return "DATA KOSONG";
        }

        return view('php.tarik-data', compact('logData','row'));
    }

    //untuk xmlrpcrequest ambil data ke localhost
    public function downloadLogData(Request $request)
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $IP = $request->input('ip', '192.168.1.205');
        $Key = $request->input('key', '0');

        $absensiRequest = new AbsensiRequest();
        $result = $absensiRequest->xmlRpcRequest($IP, $Key);

        if ($result === null) {
    
            return "DATA KOSONG";
        }
    
        $logData = $result; // Ubah ini sesuai dengan format data yang diterima dari permintaan XML-RPC
    
        return view('php.tarik-data', compact('logData','row')); 
        
    }

}

//isi public function DownladLogData:
 // $absensiHelper = new absensiHelper();
        // $Connect = $absensiHelper->connectToIP($IP,"80", 1);
        // return $IP;
        // $Connect = fsockopen($IP, "80", $errno, $errstr, 1);

        // if ($Connect) {
        //     $soapRequest = "<GetAttLog><ArgComKey xsi:type=\"xsd:integer\">" . $Key . "</ArgComKey><Arg><PIN xsi:type=\"xsd:integer\">All</PIN></Arg></GetAttLog>";
        //     $newLine = "\r\n";

        //     fputs($Connect, "POST /iWsService HTTP/1.0" . $newLine);
        //     fputs($Connect, "Content-Type: text/xml" . $newLine);
        //     fputs($Connect, "Content-Length: " . strlen($soapRequest) . $newLine . $newLine);
        //     fputs($Connect, $soapRequest . $newLine);

        //     $buffer = "";
        //     while ($response = fgets($Connect, 1024)) {
        //         $buffer .= $response;
        //     }

        //     fclose($Connect);

        //     $responseData = Parse_Data($buffer, "<GetAttLogResponse>", "</GetAttLogResponse>");
        //     $responseData = explode("\r\n", $responseData);

        //     $logData = [];
        //     foreach ($responseData as $line) {
        //         $data = Parse_Data($line, "<Row>", "</Row>");
        //         $PIN = Parse_Data($data, "<PIN>", "</PIN>");
        //         $DateTime = Parse_Data($data, "<DateTime>", "</DateTime>");
        //         $Verified = Parse_Data($data, "<Verified>", "</Verified>");
        //         $Status = Parse_Data($data, "<Status>", "</Status>");

        //         $logData[] = [
        //             'PIN' => $PIN,
        //             'DateTime' => $DateTime,
        //             'Verified' => $Verified,
        //             'Status' => $Status
        //         ];
        //     }

        //     return [
        //         'error' => null,
        //         'result' => $logData
        //     ];
        // } else {
        //     return [
        //         'error' => "Koneksi Gagal",
        //         'result' => null
        //     ];
        // }

        // $absensiRequest = new AbsensiRequest();
        // $result = $absensiRequest->xmlRpcRequest($IP, $Key);

