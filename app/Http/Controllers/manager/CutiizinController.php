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
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class CutiizinController extends Controller
{
    public function rekapcutiExcel(Request $request)
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $role= Auth::user()->role;

        $idkaryawan = $request->id_karyawan;
        $bulan      = $request->query('bulan', Carbon::now()->format('m'));
        $tahun      = $request->query('tahun', Carbon::now()->format('Y'));

        // simpan session
        $idkaryawan = $request->session()->get('idkaryawan');
        $bulan      = $request->session()->get('bulan');
        $tahun      = $request->session()->get('tahun');

        if ($idkaryawan !=="Semua" && isset($idkaryawan) && isset($bulan) && isset($tahun)) 
        {
            $data = Cuti::join('statuses', 'cuti.status', '=', 'statuses.id')
                ->leftjoin('jeniscuti','cuti.id_jeniscuti','jeniscuti.id')
                ->leftjoin('karyawan','cuti.id_karyawan','karyawan.id')
                ->leftjoin('alokasicuti','cuti.id_alokasi','alokasicuti.id')
                ->leftjoin('settingalokasi','cuti.id_settingalokasi','settingalokasi.id')
                ->leftjoin('departemen','cuti.departemen','departemen.id')
                ->where(function($query){
                    $query->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                    ->orWhere(function($query) {
                        $query->where('karyawan.atasan_kedua',Auth::user()->id_pegawai);
                    });    
                })
                ->where('cuti.id_karyawan', $idkaryawan)
                ->whereMonth('cuti.tgl_mulai', $bulan)
                ->whereYear('cuti.tgl_mulai', $tahun)
                ->select('cuti.*', 'jeniscuti.jenis_cuti','statuses.name_status', 'karyawan.nama','karyawan.atasan_pertama','karyawan.atasan_kedua','statuses.name_status')
                ->distinct()
                ->orderBy('cuti.id', 'desc')
                ->get();
            // dd($data);
                
            if ($data->isEmpty()) 
            {
                // dd($data);
                return redirect()->back()->with('pesa','Tidak Ada Data');
            } 
            else {
                $nbulan = \Carbon\Carbon::parse($data->first()->tgl_mulai)->format('M Y');
                return Excel::download(new CutiExpor($data, $idkaryawan), "Rekap Cuti Bulan " . $nbulan . " " . ucwords(strtolower($data->first()->karyawans->nama)) . ".xlsx");
            }
           
        }elseif($idkaryawan =="Semua" && isset($bulan) && isset($tahun))
        {
            $data = Cuti::join('statuses', 'cuti.status', '=', 'statuses.id')
                ->leftjoin('jeniscuti','cuti.id_jeniscuti','jeniscuti.id')
                ->leftjoin('karyawan','cuti.id_karyawan','karyawan.id')
                ->leftjoin('alokasicuti','cuti.id_alokasi','alokasicuti.id')
                ->leftjoin('settingalokasi','cuti.id_settingalokasi','settingalokasi.id')
                ->leftjoin('departemen','cuti.departemen','departemen.id')
                ->where(function($query){
                    $query->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                    ->orWhere(function($query) {
                        $query->where('karyawan.atasan_kedua',Auth::user()->id_pegawai);
                    });    
                })
                ->whereMonth('cuti.tgl_mulai', $bulan)
                ->whereYear('cuti.tgl_mulai', $tahun)
                ->select('cuti.*', 'jeniscuti.jenis_cuti','statuses.name_status', 'karyawan.nama','karyawan.atasan_pertama','karyawan.atasan_kedua','statuses.name_status')
                ->distinct()
                ->orderBy('cuti.id', 'desc')
                ->get();
            // dd($data);

            if ($data->isEmpty()) 
            {
                // dd($data);
                return redirect()->back()->with('pesa','Tidak Ada Data');
            } 
            else {
                $nbulan = \Carbon\Carbon::parse($data->first()->tgl_mulai)->format('M Y');
                return Excel::download(new CutiExpor($data, $idkaryawan), "Rekap Cuti Karyawan Bulan " . $nbulan . ".xlsx");
            }
           
        }
         else {
            $data = DB::table('cuti')
            ->leftjoin('alokasicuti', 'cuti.id_alokasi', 'alokasicuti.id')
            ->leftjoin('settingalokasi', 'cuti.id_jeniscuti', 'settingalokasi.id_jeniscuti')
            ->leftjoin('jeniscuti', 'cuti.id_jeniscuti', 'jeniscuti.id')
            ->leftjoin('karyawan', 'cuti.id_karyawan', 'karyawan.id')
            ->leftjoin('statuses', 'cuti.status', 'statuses.id')
            ->leftjoin('departemen','cuti.departemen','departemen.id')
            ->where(function($query){
                $query->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                ->orWhere(function($query) {
                    $query->where('karyawan.atasan_kedua',Auth::user()->id_pegawai);
                });    
            })
            ->select('cuti.*', 'jeniscuti.jenis_cuti', 'departemen.nama_departemen', 'karyawan.nama','statuses.name_status', 'karyawan.atasan_pertama', 'alokasicuti.tgl_masuk', 'karyawan.atasan_kedua','alokasicuti.jatuhtempo_awal','alokasicuti.jatuhtempo_akhir','karyawan.atasan_pertama', 'karyawan.atasan_kedua')
            ->distinct()
            ->orderBy('cuti.id', 'DESC')
            ->get();

            // $data =DB::table('cuti')
            // ->leftjoin('alokasicuti', 'cuti.id_jeniscuti', 'alokasicuti.id_jeniscuti')
            // ->leftjoin('statuses', 'cuti.status', '=', 'statuses.id')
            // ->leftjoin('jeniscuti', 'cuti.id_jeniscuti', 'jeniscuti.id')
            // ->leftjoin('karyawan', 'cuti.id_karyawan', 'karyawan.id')
            // ->leftjoin('departemen', 'cuti.departemen', 'departemen.id')
            // ->where(function($query) use ($row){
            //     $query->where('karyawan.atasan_pertama', Auth::user()->id_pegawai)
            //         ->orWhere('karyawan.atasan_kedua', Auth::user()->id_pegawai);
            // })
            // ->select('cuti.*', 'jeniscuti.jenis_cuti', 'departemen.nama_departemen', 'karyawan.nama','statuses.name_status', 'alokasicuti.tgl_masuk',)
            // ->distinct()
            // ->orderBy('cuti.id', 'DESC')
            // ->get();

            // $data = Cuti::join('statuses', 'cuti.status', '=', 'statuses.id')
            //     ->leftjoin('alokasicuti', 'cuti.id_jeniscuti', 'alokasicuti.id_jeniscuti')
            //     ->leftjoin('settingalokasi', 'cuti.id_jeniscuti', 'settingalokasi.id_jeniscuti')
            //     ->leftjoin('jeniscuti', 'cuti.id_jeniscuti', 'jeniscuti.id')
            //     ->leftjoin('karyawan', 'cuti.id_karyawan', 'karyawan.id')
            //     ->leftjoin('departemen','cuti.departemen','departemen.id')
            //     ->select('cuti.*', 'jeniscuti.jenis_cuti', 'departemen.nama_departemen', 'karyawan.nama','statuses.name_status', 'alokasicuti.tgl_masuk','alokasicuti.jatuhtempo_awal','alokasicuti.jatuhtempo_akhir','karyawan.atasan_pertama', 'karyawan.atasan_kedua')
            //     ->where(function($query) use ($row){
            //         $query->where('karyawan.atasan_pertama', Auth::user()->id_pegawai)
            //               ->orWhere('karyawan.atasan_kedua', Auth::user()->id_pegawai);
            //     })
            //     ->where()
            //     ->distinct()
            //     ->orderBy('cuti.id', 'DESC')
            //     ->get();

            // $data = Cuti::join('statuses', 'cuti.status', '=', 'statuses.id')
            // ->join('alokasicuti', 'cuti.id_jeniscuti', 'alokasicuti.id_jeniscuti')
            // ->join('karyawan', 'cuti.id_karyawan', '=', 'karyawan.id')
            // ->join('jeniscuti', 'cuti.id_jeniscuti', '=', 'jeniscuti.id')
            // ->join('departemen','cuti.departemen','=','departemen.id')
            // ->where(function($query){
            //     $query->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
            //     ->orWhere(function($query){
            //         $query->where('karyawan.atasan_kedua',Auth::user()->id_pegawai);
            //     });    
            // })
            // ->get(['cuti.*', 'jeniscuti.jenis_cuti', 'departemen.nama_departemen', 'karyawan.nama','statuses.name_status', 'alokasicuti.tgl_masuk','alokasicuti.jatuhtempo_awal','alokasicuti.jatuhtempo_akhir','karyawan.atasan_pertama', 'karyawan.atasan_kedua']);

                // $data = Cuti::leftjoin('alokasicuti', 'cuti.id_jeniscuti', 'alokasicuti.id_jeniscuti')
                // ->leftjoin('settingalokasi', 'cuti.id_jeniscuti', 'settingalokasi.id_jeniscuti')
                // ->leftjoin('jeniscuti', 'cuti.id_jeniscuti', 'jeniscuti.id')
                // ->leftjoin('karyawan', 'cuti.id_karyawan', 'karyawan.id')
                // ->leftjoin('statuses', 'cuti.status', 'statuses.id')
                // ->leftjoin('departemen','cuti.departemen','departemen.id')
                // ->where(function($query){
                //     $query->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                //     ->orWhere(function($query) {
                //         $query->where('karyawan.atasan_kedua',Auth::user()->id_pegawai);
                //     });    
                // })
                // ->select('cuti.*', 'jeniscuti.jenis_cuti', 'departemen.nama_departemen', 'karyawan.nama','statuses.name_status', 'alokasicuti.tgl_masuk','alokasicuti.jatuhtempo_awal','alokasicuti.jatuhtempo_akhir','karyawan.atasan_pertama', 'karyawan.atasan_kedua')
                // ->distinct()
                // ->orderBy('cuti.id', 'DESC')
                // ->get();
            
            if ($data->isEmpty()) 
            {
                // return $data;
                return redirect()->back()->with('pesa','Tidak Ada Data');
            } 
            else {
                // return $data;
                // dd($data);
                return Excel::download(new CutiExpor($data, $idkaryawan), "Rekap Cuti Karyawan.xlsx");

            }

        }
       
    }

    public function rekapcutipdf(Request $request)
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $setorganisasi = SettingOrganisasi::where('partner', Auth::user()->partner)->first();

        $idkaryawan = $request->id_karyawan;
        $bulan      = $request->query('bulan', Carbon::now()->format('m'));
        $tahun      = $request->query('tahun', Carbon::now()->format('Y'));

        // simpan session
        $idkaryawan = $request->session()->get('idkaryawan');
        $bulan      = $request->session()->get('bulan');
        $tahun      = $request->session()->get('tahun',);

        // dd($idkaryawan,$bulan,$tahun );

        if ($idkaryawan !=="Semua" && isset($idkaryawan) && isset($bulan) && isset($tahun)) 
        {
            $data = Cuti::where('id_karyawan', $idkaryawan)
                ->whereMonth('tgl_mulai', $bulan)
                ->whereYear('tgl_mulai', $tahun)
                ->get();
            
            if ($data->isEmpty()) 
            {
                return redirect()->back()->with('pesa','Tidak Ada Data');
            } else {
                $nbulan = \Carbon\Carbon::parse($data->first()->tgl_mulai)->format('M Y');
                $pdf = PDF::loadview('admin.cuti.cutipdf', ['data' => $data, 'idkaryawan' => $idkaryawan,'setorganisasi'=> $setorganisasi])
                ->setPaper('a4', 'landscape');
                $pdfName = "Rekap Cuti Bulan " . $nbulan . " " . ucwords(strtolower($data->first()->karyawans->nama)) . ".pdf";
                return $pdf->stream($pdfName);
            } 
        } 
        elseif($idkaryawan =="Semua" && isset($bulan) && isset($tahun))
        {
            $data = Cuti::join('statuses', 'cuti.status', '=', 'statuses.id')
            ->join('karyawan', 'cuti.id_karyawan', '=', 'karyawan.id')
            ->join('jeniscuti', 'cuti.id_jeniscuti', '=', 'jeniscuti.id')
            ->join('departemen','cuti.departemen','=','departemen.id')
            ->where(function($query) use ($row){
                $query->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                ->orWhere(function($query) use ($row){
                    $query->where('karyawan.atasan_kedua',Auth::user()->id_pegawai);
                });    
            })
            ->whereMonth('tgl_mulai', $bulan)
            ->whereYear('tgl_mulai', $tahun)
            ->where('karyawan.partner',Auth::user()->partner)
            ->where('karyawan.divisi',$row->divisi)
            ->get(['cuti.*', 'statuses.name_status','karyawan.nama','departemen.nama_departemen']);
            // dd($data);

            if ($data->isEmpty()) 
            {
                // dd($data);
                return redirect()->back()->with('pesa','Tidak Ada Data');
            } 
            else {
                $nbulan = \Carbon\Carbon::parse($data->first()->tgl_mulai)->format('M Y');
                $pdf = PDF::loadview('admin.cuti.cutipdf', ['data' => $data, 'idkaryawan' => $idkaryawan,'setorganisasi'=> $setorganisasi])
                ->setPaper('a4', 'landscape');
                $pdfName = "Rekap Cuti Karyawan Bulan ".$nbulan. " ". ".pdf";
                return $pdf->stream($pdfName);
            }
           
        }
        else 
        {
            $data = Cuti::join('statuses', 'cuti.status', '=', 'statuses.id')
                ->join('karyawan', 'cuti.id_karyawan', '=', 'karyawan.id')
                ->join('jeniscuti', 'cuti.id_jeniscuti', '=', 'jeniscuti.id')
                ->join('departemen','cuti.departemen','=','departemen.id')
                ->where(function($query) use ($row){
                    $query->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                    ->orWhere(function($query) use ($row){
                        $query->where('karyawan.atasan_kedua',Auth::user()->id_pegawai);
                    });    
                })
                ->where('karyawan.partner',Auth::user()->partner)
                ->where('karyawan.divisi',$row->divisi)
                ->get(['cuti.*', 'statuses.name_status','karyawan.nama','departemen.nama_departemen']);

            // $data = Cuti::all();

            if ($data->isEmpty()) 
            {
                return redirect()->back()->with('pesa','Tidak Ada Data');
            } else {
                $pdf = PDF::loadview('admin.cuti.cutipdf', ['data' => $data, 'idkaryawan' => $idkaryawan,'setorganisasi'=> $setorganisasi])
                ->setPaper('a4', 'landscape');
                $pdfName = "Rekap Cuti Karyawan.pdf";
                return $pdf->stream($pdfName);
            } 
        }

        // if ($data->first()) {
        //     $pdfName = "Rekap Cuti Bulan " . $nbulan . " " . $data->first()->karyawans->nama . ".pdf";
        // } else {
        //     $pdfName = "Rekapan Cuti Tidak Ditemukan.pdf";
        // }

        // $pdf = PDF::loadview('admin.cuti.cutipdf', ['data' => $data, 'idkaryawan' => $idkaryawan, 'setorganisasi'=> $setorganisasi])
        //     ->setPaper('a4', 'landscape');
        // return $pdf->stream($pdfName);
    }

    public function rekapizinExcel(Request $request)
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        // $nbulan = $request->query('month', Carbon::now()->format('M Y'));

        $idpegawai = $request->idpegawai;
        $month     = $request->query('month', Carbon::now()->format('m'));
        $year      = $request->query('year', Carbon::now()->format('Y'));

        // simpan session
        $idpegawai = $request->session()->get('idpegawai');
        $month     = $request->session()->get('month');
        $year      = $request->session()->get('year');


        if ($idpegawai !== "Semua" && isset($idpegawai) && isset($month) && isset($year))
        {
            $data = Izin::leftjoin('statuses', 'izin.status', '=', 'statuses.id')
                ->leftjoin('karyawan', 'izin.id_karyawan', '=', 'karyawan.id')
                ->leftjoin('departemen','izin.departemen','=','departemen.id')
                ->leftjoin('jenisizin','izin.id_jenisizin','=','jenisizin.id')
                ->where(function($query) use ($row){
                    $query->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                    ->orWhere(function($query) use ($row){
                        $query->where('karyawan.atasan_kedua',Auth::user()->id_pegawai);
                    });    
                })
                ->where('izin.id_karyawan', $idpegawai)
                ->where('karyawan.partner',Auth::user()->partner)
                ->whereMonth('izin.tgl_mulai', $month)
                ->whereYear('izin.tgl_mulai', $year)
                ->get(['izin.*', 'statuses.name_status','karyawan.nama','departemen.nama_departemen','jenisizin.jenis_izin']);
               
            if ($data->isEmpty()) 
            {
                return redirect()->back()->with('pesa','Tidak Ada Data');
            } 
            else {
                $nbulan = \Carbon\Carbon::parse($data->first()->tgl_mulai)->format('M Y');
                return Excel::download(new IzinExpor($data, $idpegawai), "Rekap Ijin dan Sakit Bulan " . $nbulan . " " . ucwords(strtolower($data->first()->nama)) . ".xlsx");
            }
                
        }elseif($idpegawai == "Semua" && isset($month) && isset($year))
        {
            $data = Izin::leftjoin('statuses', 'izin.status', '=', 'statuses.id')
            ->leftjoin('karyawan', 'izin.id_karyawan', '=', 'karyawan.id')
            ->leftjoin('departemen','izin.departemen','=','departemen.id')
            ->leftjoin('jenisizin','izin.id_jenisizin','=','jenisizin.id')
            ->where(function($query) use ($row){
                $query->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                ->orWhere(function($query) use ($row){
                    $query->where('karyawan.atasan_kedua',Auth::user()->id_pegawai);
                });    
            })
            ->where('karyawan.partner',Auth::user()->partner)
            ->where('karyawan.divisi',$row->divisi)
            ->whereMonth('izin.tgl_mulai', $month)
            ->whereYear('izin.tgl_mulai', $year)
            ->get(['izin.*', 'statuses.name_status','karyawan.nama','departemen.nama_departemen','jenisizin.jenis_izin']);
           
            if ($data->isEmpty()) 
            {
                return redirect()->back()->with('pesa','Tidak Ada Data');
            } 
            else {
                $nbulan = \Carbon\Carbon::parse($data->first()->tgl_mulai)->format('M Y');
                return Excel::download(new IzinExpor($data, $idpegawai), "Rekap Ijin dan Sakit Karyawan Bulan " . $nbulan. ".xlsx");
            }
        }
        else {
            $data = Izin::leftjoin('statuses', 'izin.status', '=', 'statuses.id')
                ->leftjoin('karyawan', 'izin.id_karyawan', '=', 'karyawan.id')
                ->leftjoin('departemen','izin.departemen','=','departemen.id')
                ->leftjoin('jenisizin','izin.id_jenisizin','=','jenisizin.id')
                ->where(function($query) use ($row){
                    $query->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                    ->orWhere(function($query) use ($row){
                        $query->where('karyawan.atasan_kedua',Auth::user()->id_pegawai);
                    });    
                })
                ->get(['izin.*', 'statuses.name_status','karyawan.nama','departemen.nama_departemen','jenisizin.jenis_izin']);
            
            if ($data->isEmpty()) 
            {
                return redirect()->back()->with('pesa','Tidak Ada Data');
            } 
            else {
                $nbulan = "-";
                return Excel::download(new IzinExpor($data, $idpegawai), "Rekap Ijin dan Sakit Karyawan.xlsx");
            }
            
        }
       
    }

    public function rekapizinpdf(Request $request)
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $setorganisasi = SettingOrganisasi::where('partner', Auth::user()->partner)->first();
        $nbulan = $request->query('bulan', Carbon::now()->format('M Y'));

        $idpegawai = $request->idpegawai;
        $month     = $request->query('month', Carbon::now()->format('m'));
        $year      = $request->query('year', Carbon::now()->format('Y'));

        // simpan session
        $idpegawai = $request->session()->get('idpegawai');
        $month     = $request->session()->get('month');
        $year      = $request->session()->get('year');

        // dd($idkaryawan,$bulan,$tahun );

        if ($idpegawai !== "Semua" && isset($idpegawai) && isset($month) && isset($year)) 
        {
            $data = Izin::join('statuses', 'izin.status', '=', 'statuses.id')
                ->join('karyawan', 'izin.id_karyawan', '=', 'karyawan.id')
                ->join('departemen','izin.departemen','=','departemen.id')
                ->where('izin.id_karyawan', $idpegawai)
                ->whereMonth('izin.tgl_mulai', $month)
                ->whereYear('izin.tgl_mulai', $year)
                ->where(function($query) use ($row){
                    $query->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                    ->orWhere(function($query) use ($row){
                        $query->where('karyawan.atasan_kedua',Auth::user()->id_pegawai);
                    });    
                })
                ->where('karyawan.partner',Auth::user()->partner)
                ->get(['izin.*', 'statuses.name_status','karyawan.nama','departemen.nama_departemen']);
            
            if ($data->isEmpty()) 
            {
                return redirect()->back()->with('pesa','Tidak Ada Data');
            } 
            else {
                $nbulan = \Carbon\Carbon::parse($data->first()->tgl_mulai)->format('M Y');
                $pdfName = "Rekap Ijin dan Sakit Bulan " . $nbulan . " " . ucwords(strtolower($data->first()->karyawans->nama)) . ".pdf";
                $pdf = PDF::loadview('admin.cuti.izinpdf', ['data' => $data, 'idpegawai' => $idpegawai,'setorganisasi'=> $setorganisasi])
                ->setPaper('a4', 'landscape');
                return $pdf->stream($pdfName);
            }
        }elseif($idpegawai == "Semua" && isset($month) && isset($year))
        {
            $data = Izin::join('statuses', 'izin.status', '=', 'statuses.id')
            ->join('karyawan', 'izin.id_karyawan', '=', 'karyawan.id')
            ->join('departemen','izin.departemen','=','departemen.id')
            ->whereMonth('izin.tgl_mulai', $month)
            ->whereYear('izin.tgl_mulai', $year)
            ->where(function($query) use ($row){
                $query->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                ->orWhere(function($query) use ($row){
                    $query->where('karyawan.atasan_kedua',Auth::user()->id_pegawai);
                });    
            })
            ->where('karyawan.partner',Auth::user()->partner)
            ->where('karyawan.divisi',$row->divisi)
            ->get(['izin.*', 'statuses.name_status','karyawan.nama','departemen.nama_departemen']);

            if ($data->isEmpty()) 
            {
                return redirect()->back()->with('pesa','Tidak Ada Data');
            } 
            else {
                $nbulan = $request->query('bulan', Carbon::now()->format('M Y'));
                $pdfName = "Rekap Ijin dan Sakit Karyawan.pdf";
                $pdf = PDF::loadview('admin.cuti.izinpdf', ['data' => $data, 'idpegawai' => $idpegawai,'setorganisasi'=> $setorganisasi])
                ->setPaper('a4', 'landscape');
                return $pdf->stream($pdfName);
            }
        
        }
         else {
            $data = Izin::join('statuses', 'izin.status', '=', 'statuses.id')
                ->join('karyawan', 'izin.id_karyawan', '=', 'karyawan.id')
                ->join('departemen','izin.departemen','=','departemen.id')
                ->where(function($query) use ($row){
                    $query->where('karyawan.atasan_pertama',Auth::user()->id_pegawai)
                    ->orWhere(function($query) use ($row){
                        $query->where('karyawan.atasan_kedua',Auth::user()->id_pegawai);
                    });    
                })
                ->get(['izin.*', 'statuses.name_status','karyawan.nama','departemen.nama_departemen']);
            
            if ($data->isEmpty()) 
            {
                return redirect()->back()->with('pesa','Tidak Ada Data');
            } 
            else {
                $pdfName = "Rekap Ijin dan Sakit Karyawan.pdf";
                $pdf = PDF::loadview('admin.cuti.izinpdf', ['data' => $data, 'idpegawai' => $idpegawai,'setorganisasi'=> $setorganisasi])
                ->setPaper('a4', 'landscape');
                return $pdf->stream($pdfName);
            }
        }

        // if ($data->first()) {
        //     $pdfName = "Rekap Izin Bulan " . $nbulan . " " . $data->first()->karyawans->nama . ".pdf";
        // } else {
        //     $pdfName = "Rekapan Izin Tidak Ditemukan.pdf";
        // }

        // $pdf = PDF::loadview('admin.cuti.izinpdf', ['data' => $data, 'idpegawai' => $idpegawai,'setorganisasi'=> $setorganisasi])
        //     ->setPaper('a4', 'landscape');
        // return $pdf->stream($pdfName);
    }
}
