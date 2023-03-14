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
            ->whereYear('tgl_sekarang', Carbon::now()->subYear()->year)
            ->get();

        // dd($alokasicuti);
        foreach ($alokasicuti as $data) {
            $cek = Settingcuti::where('id_jeniscuti', $data->id_jeniscuti)->where('id_pegawai', $data->id_karyawan)->exists();
            // dd($data);
            if(!$cek)
            {
                $settingcuti = new Settingcuti;
                $settingcuti->id_pegawai   = $data->id_karyawan;
                $settingcuti->id_jeniscuti = $data->id_jeniscuti;
                $settingcuti->jumlah_cuti  = $data->durasi;
                $settingcuti->sisa_cuti    = 0;
                $settingcuti->periode      = \Carbon\Carbon::parse($data->aktif_dari)->format('Y');
                $settingcuti->save();
                // dd($settingcuti);
                Log::info('Data Reset Cuti Tahunan Karyawan Berhasil Disimpan');
            }
            else{
    
                $alokasicutisaatini = Alokasicuti::select('id_karyawan', 'id_jeniscuti','durasi','aktif_dari')
                    ->where('id_jeniscuti', $jeniscuti->id)
                    ->whereYear('tgl_sekarang', Carbon::now()->year)
                    ->get();
                $durasi = 0;
                //untuk mengatasi error Property [durasi] does not exist on this collection instance. gunakan foreach
                foreach($alokasicutisaatini as $alokasi)
                {
                    $aktif = \Carbon\Carbon::parse($alokasi->aktif_dari)->format('Y');
                    $durasi = $alokasi->durasi;

                    $chek = Settingcuti::where('id_jeniscuti', $jeniscuti->id)->where('id_pegawai', $data->id_karyawan)->exists();
                    if($chek)
                    {   
                        $setting_sebelumnya = Settingcuti::where('id_pegawai',$alokasi->id_karyawan)
                            ->select('id_pegawai','id_jeniscuti','id_setting','jumlah_cuti','sisa_cuti','periode')
                            ->first();

                        if ($setting_sebelumnya) {
                            $jumlah = $setting_sebelumnya->jumlah_cuti;

                            $cari = Sisacuti::where('id_jeniscuti', $setting_sebelumnya->id_jeniscuti)->where('id_pegawai', $setting_sebelumnya->id_pegawai)->exists();
                            if(!$cari)
                            {
                                $sisacuti = new Sisacuti;
                                $sisacuti->id_pegawai   = $setting_sebelumnya->id_pegawai;
                                $sisacuti->id_setting   = $setting_sebelumnya->id;
                                $sisacuti->id_jeniscuti = $setting_sebelumnya->id_jeniscuti;
                                $sisacuti->jumlah_cuti  = $setting_sebelumnya->jumlah_cuti;
                                $sisacuti->sisa_cuti    = $setting_sebelumnya->sisa_cuti;
                                $sisacuti->periode      = $setting_sebelumnya->periode;
                                $sisacuti->save();
                                // dd($settingcuti);
                                Log::info('Data Sisa cuti Berhasil Ditambahkan');
                            }
                            else{
                                $sisasaatini = Sisacuti::select('id_pegawai','id_setting','jumlah_cuti','sisa_cuti','periode')
                                    ->where('id_setting', $setting_sebelumnya->id)
                                    ->whereYear('periode', Carbon::now()->year)
                                    ->get();

                                foreach($sisasaatini as $sisasi)
                                {
                                    $jumlah = $sisasi->jumlah_cuti;
                                }
                            }

                        } else {
                            $jumlah = 0; // nilai default jika $setting_sebelumnya bernilai null
                        }

                        $jumlahbaru = $durasi;
                        $sisabaru   = $jumlah;

                        Settingcuti::where('id_pegawai',$setting_sebelumnya->id_pegawai)
                            ->update([
                                'jumlah_cuti' => $jumlahbaru,
                                'sisa_cuti' => $sisabaru,
                                'periode' => $aktif,
                            ]); 
                        
                        Log::info('Data Reset Cuti Tahunan Karyawan Berhasil di Update');   
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
