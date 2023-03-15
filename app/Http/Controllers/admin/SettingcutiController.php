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
        $alokasicuti = Alokasicuti::select('id_karyawan', 'id_jeniscuti','durasi','aktif_dari')
            ->where('id_jeniscuti', $jeniscuti->id)
            ->whereYear('aktif_dari', Carbon::now()->subYear()->year)
            ->get();

        // dd($alokasicuti);
        foreach ($alokasicuti as $data) {
            $cek = Settingcuti::where('id_jeniscuti', $data->id_jeniscuti)->where('id_pegawai', $data->id_karyawan)->exists();
            $ceksisa = Sisacuti::where('id_jeniscuti', $data->id_jeniscuti)->where('id_pegawai', $data->id_karyawan)->exists();

            // dd($data);
            if(!$cek && !$ceksisa)
            {
                $settingcuti = new Settingcuti;
                $settingcuti->id_pegawai   = $data->id_karyawan;
                $settingcuti->id_jeniscuti = $data->id_jeniscuti;
                $settingcuti->jumlah_cuti  = $data->durasi;
                $settingcuti->sisa_cuti    = 0;
                $settingcuti->periode      = \Carbon\Carbon::parse($data->aktif_dari)->format('Y');
                $settingcuti->save();

                // insert data ke tabel sisacuti
                $sisacuti = new Sisacuti;
                $sisacuti->id_pegawai   = $settingcuti->id_pegawai;
                $sisacuti->id_jeniscuti = $settingcuti->id_jeniscuti;
                $sisacuti->id_setting   = $settingcuti->id;
                $sisacuti->jumlah_cuti  = $settingcuti->jumlah_cuti;
                $sisacuti->sisa_cuti    = $settingcuti->sisa_cuti;
                $sisacuti->periode      = $settingcuti->periode;
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
    
                $alokasicutisaatini = Alokasicuti::select('id_karyawan', 'id_jeniscuti','durasi','aktif_dari')
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
                        ->first();
                
                    $sisacuti = Sisacuti::where('id_jeniscuti',$alokasi->id_jeniscuti)
                        ->where('id_pegawai', $id_karyawan)
                        ->first();

                    // $chek = Settingcuti::where('id_jeniscuti', $jeniscuti->id)->where('id_pegawai', $alokasi->id_karyawan)->exists();
                    // $ceksisacuti = Sisacuti::where('id_jeniscuti',  $jeniscuti->id)->where('id_pegawai', $alokasi->id_karyawan)->exists();
                    
                    // dd($chek, $ceksisacuti);
                    if($settingcuti && $sisacuti)
                    {   
                        $jumlah_cuti = $settingcuti->jumlah_cuti;
                         // Update data pada settingcuti
                        $settingcuti->jumlah_cuti = $durasi;
                        $settingcuti->sisa_cuti   = $jumlah_cuti;
                        $settingcuti->periode     = $aktif;
                        $settingcuti->update();

                        // dd($settingcuti);
                         // Update data pada sisacuti
                        $sisacuti->jumlah_cuti = $durasi;
                        $sisacuti->sisa_cuti   = $jumlah_cuti;
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

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
