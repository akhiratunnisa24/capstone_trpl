<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use App\Models\Karyawan;
use App\Models\Sisacuti;
use App\Models\Jeniscuti;
use App\Models\Alokasicuti;
use App\Models\Settingcuti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SettingcutiController extends Controller
{

    public function index()
    {
        $role = Auth::user()->role;
        if ($role == 1) 
        {
            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
            $settingcuti = Settingcuti::orderBy('id', 'asc')->get();
            // dd($settingcuti);
            return view('admin.settingcuti.index', compact('settingcuti','row'));

        } else {
    
            return redirect()->back();
        }
    }

    public function resetCutiTahunan(Request $request)
    {
        $jeniscuti = Jeniscuti::findOrFail(1);
        $alokasicuti = Alokasicuti::select('id','id_karyawan', 'id_jeniscuti','durasi','aktif_dari')
            ->where('id_jeniscuti', $jeniscuti->id)
            ->whereYear('aktif_dari', Carbon::now()->subYear()->year)
            ->get();
        $year = Carbon::now()->year;

        // dd($alokasicuti);
        foreach ($alokasicuti as $data) {
            $cek = Settingcuti::where('id_jeniscuti', $data->id_jeniscuti)->where('id_pegawai', $data->id_karyawan)->exists();
            $ceksisa = Sisacuti::where('jenis_cuti', $data->id_jeniscuti)->where('id_pegawai', $data->id_karyawan)->exists();

            // dd($data);
            if(!$cek && !$ceksisa)
            {
                $settingcuti = new Settingcuti;
                $settingcuti->id_pegawai   = $data->id_karyawan;
                $settingcuti->id_jeniscuti = $data->id_jeniscuti;
                $settingcuti->id_alokasi   = $data->id;
                $settingcuti->jumlah_cuti  = $data->durasi;
                $settingcuti->sisa_cuti    = 0;
                $settingcuti->periode      = \Carbon\Carbon::parse($data->aktif_dari)->format('Y');
                $settingcuti->save();

                // insert data ke tabel sisacuti
                $sisacuti = new Sisacuti;
                $sisacuti->id_pegawai   = $settingcuti->id_pegawai;
                $sisacuti->jenis_cuti   = $settingcuti->id_jeniscuti;
                $sisacuti->id_setting   = $settingcuti->id;
                $sisacuti->id_alokasi   = $settingcuti->id_alokasi;
                $sisacuti->jumlah_cuti  = $settingcuti->sisa_cuti;
                $sisacuti->sisa_cuti    = $settingcuti->jumlah_cuti;
                $sisacuti->periode      = $settingcuti->periode;
                $sisacuti->dari         = $year.'-01-01';;
                $sisacuti->sampai       = $year.'-03-31';;
                $sisacuti->status       = 1;
                $sisacuti->save();

                $alokasi = Alokasicuti::where('id_karyawan', $settingcuti->id_pegawai)
                    ->where('id_jeniscuti',$settingcuti->id_jeniscuti)
                    ->whereYear('aktif_dari', Carbon::now()->subYear()->year)
                    ->update([
                        'status' => 0,
                    ]);

                Log::info('Data Reset cuti Tahunan Berhasil Disimpan');
                Log::info('Data Sisa cuti tahun lalu Berhasil Disimpan');
            }
            else{
    
                $alokasicutisaatini = Alokasicuti::select('id','id_karyawan', 'id_jeniscuti','durasi','aktif_dari')
                    ->where('id_jeniscuti', $jeniscuti->id)
                    ->whereYear('aktif_dari', Carbon::now()->year)
                    ->get();
                //untuk mengatasi error Property [durasi] does not exist on this collection instance. gunakan foreach
                foreach($alokasicutisaatini as $alokasi)
                {

                    $id_karyawan = $alokasi->id_karyawan;
                    $durasi = $alokasi->durasi;
                    $aktif = \Carbon\Carbon::parse($alokasi->aktif_dari)->format('Y');

                    $settingcuti = Settingcuti::where('id_jeniscuti', $alokasi->id_jeniscuti)
                        ->where('id_pegawai', $id_karyawan)
                        ->get();
                
                    $sisacuti = Sisacuti::where('jenis_cuti',$alokasi->id_jeniscuti)
                        ->where('id_pegawai', $id_karyawan)
                        ->get();

                    // $chek = Settingcuti::where('id_jeniscuti', $jeniscuti->id)->where('id_pegawai', $alokasi->id_karyawan)->exists();
                    // $ceksisacuti = Sisacuti::where('id_jeniscuti',  $jeniscuti->id)->where('id_pegawai', $alokasi->id_karyawan)->exists();
                    
                    // dd($chek, $ceksisacuti);
                    if($settingcuti && $sisacuti)
                    {   
                        foreach($settingcuti as $settingcuti)
                        {
                            $jumlah_cuti = $settingcuti->jumlah_cuti;
                        }
                        // return  $jumlah_cuti;
                        $settingcuti->id_alokasi = $alokasi->id;
                         // Update data pada settingcuti
                        $settingcuti->jumlah_cuti = $durasi;
                        $settingcuti->sisa_cuti   = $jumlah_cuti;
                        $settingcuti->periode     = $aktif;
                        $settingcuti->update();

                        // dd($settingcuti);
                         // Update data pada sisacuti
                        $sisacuti->id_alokasi  = $settingcuti->id_alokasi;
                        $sisacuti->jumlah_cuti = $durasi;
                        $sisacuti->sisa_cuti   = $jumlah_cuti;
                        $sisacuti->dari         = $year.'-01-01';;
                        $sisacuti->sampai       = $year.'-03-31';;
                        $sisacuti->status       = 1;
                        $sisacuti->update();

                        Log::info('Data Reset Cuti Tahunan Berhasil di UPDATE'); 
                    }
                    else{
                        Log::info('Data Reset Cuti Tahunan Tidak Ditemukan');   
                    }
                }
                
            }
        }
        return redirect()->back();
    }

    public function resetTahunini(Request $request)
    {
        $jeniscuti = Jeniscuti::findOrFail(1);
        $alokasicuti = Alokasicuti::select('id','id_karyawan', 'id_jeniscuti','durasi','aktif_dari')
            ->where('id_jeniscuti', $jeniscuti->id)
            ->whereYear('aktif_dari', Carbon::now()->subYear()->year)
            ->get();
        $year = Carbon::now()->year;

        // dd($alokasicuti);
        foreach($alokasicuti as $data) {
            $cek = Settingcuti::where('id_jeniscuti', $data->id_jeniscuti)->where('id_pegawai', $data->id_karyawan)->exists();
            $ceksisa = Sisacuti::where('jenis_cuti', $data->id_jeniscuti)->where('id_pegawai', $data->id_karyawan)->exists();

            // dd($cek,$ceksisa);
            if(!$cek && !$ceksisa)
            {
                $settingcuti = new Settingcuti;
                $settingcuti->id_pegawai   = $data->id_karyawan;
                $settingcuti->id_jeniscuti = $data->id_jeniscuti;
                $settingcuti->id_alokasi   = $data->id;
                $settingcuti->jumlah_cuti  = $data->durasi;
                $settingcuti->sisa_cuti    = 0;
                $settingcuti->periode      = \Carbon\Carbon::parse($data->aktif_dari)->format('Y');
                $settingcuti->save();

                // insert data ke tabel sisacuti
                $sisacuti = new Sisacuti;
                $sisacuti->id_pegawai   = $settingcuti->id_pegawai;
                $sisacuti->jenis_cuti   = $settingcuti->id_jeniscuti;
                $sisacuti->id_setting   = $settingcuti->id;
                $sisacuti->id_alokasi   = $settingcuti->id_alokasi;
                $sisacuti->jumlah_cuti  = $settingcuti->sisa_cuti;
                $sisacuti->sisa_cuti    = $settingcuti->jumlah_cuti;
                $sisacuti->periode      = $settingcuti->periode;
                $sisacuti->dari         = $year.'-01-01';;
                $sisacuti->sampai       = $year.'-03-31';;
                $sisacuti->status       = 1;
                $sisacuti->save();

                $alokasi = Alokasicuti::where('id_karyawan', $settingcuti->id_pegawai)
                    ->where('id_jeniscuti',$settingcuti->id_jeniscuti)
                    ->whereYear('aktif_dari', Carbon::now()->subYear()->year)
                    ->update([
                        'status' => 0,
                    ]);

                Log::info('Data Reset cuti Tahunan Berhasil Disimpan');
                Log::info('Data Sisa cuti tahun lalu Berhasil Disimpan');
            }

            if($cek && $ceksisa)
            {
                $alokasicutisaatini = Alokasicuti::select('id','id_karyawan', 'id_jeniscuti','durasi','aktif_dari','id_alokasi')
                    ->where('id_jeniscuti', $jeniscuti->id)
                    ->whereYear('aktif_dari', Carbon::now()->year)
                    ->where('durasi','>',0)
                    ->get();
                //untuk mengatasi error Property [durasi] does not exist on this collection instance. gunakan foreach
                foreach($alokasicutisaatini as $alokasi)
                {
                    $id_karyawan = $alokasi->id_karyawan;
                    $durasi = $alokasi->durasi;
                    $aktif = \Carbon\Carbon::parse($alokasi->aktif_dari)->format('Y');

                    $chek = Settingcuti::where('id_jeniscuti', $jeniscuti->id)->where('id_pegawai', $alokasi->id_karyawan)->exists();
                    $ceksisacuti = Sisacuti::where('jenis_cuti',  $jeniscuti->id)->where('id_pegawai', $alokasi->id_karyawan)->exists();
                    
                    // dd($chek, $ceksisacuti);
                    if($chek && $ceksisacuti)
                    {   
                        $settingcuti = Settingcuti::where('id_jeniscuti',$alokasi->id_jeniscuti)
                                        ->where('id_karyawan', $alokasicuti->id_karyawan)
                                        ->update([
                                            'id_alokasi' => $alokasi->id,
                                            'jumlah_cuti'=> 0,
                                            'sisa_cuti'  => $alokasi->durasi,
                                            'periode'    => $aktif,
                                        ]);
            
                        $sisacuti = Settingcuti::where('id_setting',$settingcuti->id)
                                    ->where('id_karyawan', $alokasicuti->id_karyawan)
                                    ->update([
                                        'id_alokasi' => $alokasi->id,
                                        'jumlah_cuti'=> $alokasi->durasi,
                                        'sisa_cuti'  => 0,
                                        'periode'    => $aktif,
                                        'dari'       => $year.'-01-01',
                                        'sampai'     => $year.'-03-31',
                                        'status'     => 0,
                                    ]);
            
                        Log::info('Data Reset Cuti Tahun ini  Berhasil di Perbaharui'); 
                    }
                    else{
                        Log::info('Data Reset Cuti Tahunan Tidak Ditemukan');   
                    }
                }
                
            }
        }
        return redirect()->back();
    }

    public function destroy($id)
    {
        //
    }
}
