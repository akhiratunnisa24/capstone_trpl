<?php

namespace App\Http\Controllers\karyawan;

use App\Models\Karyawan;
use App\Models\Kdarurat;
use App\Models\Keluarga;
use App\Models\Departemen;
use App\Models\Rpekerjaan;
use App\Models\Rpendidikan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class KaryawansController extends Controller
{
    public function create()
    {
        $role = Auth::user()->role;

        if ($role == 1) {

            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
            $departemen     = Departemen::all();
            $atasan_pertama = Karyawan::whereIn('jabatan', ['Supervisor', 'Manager','Management'])->get();
            $atasan_kedua   = Karyawan::whereIn('jabatan', ['Manager','Management'])->get();
            $user = Karyawan::max('id');
            $datakeluarga = Keluarga::where('id_pegawai',$user)->get();
            $kontakdarurat = Kdarurat::where('id_pegawai',$user)->get();
            $pformal = Rpendidikan::where('id_pegawai',$user)->where('jenis_pendidikan','=',null)->get();
            $nonformal = Rpendidikan::where('id_pegawai',$user)->where('jenis_pendidikan','!=',null)->get();
            $pekerjaan = Rpekerjaan::where('id_pegawai',$user)->get();
            $output = [
                'row' => $row,
                'departemen' => $departemen,
                'atasan_pertama' => $atasan_pertama,
                'atasan_kedua' => $atasan_kedua,
                'user' => $user,
                'datakeluarga' => $datakeluarga,
                'kontakdarurat'=> $kontakdarurat,
                'pformal' =>  $pformal,
                'nonformal' => $nonformal,
                'pekerjaan' =>$pekerjaan,
            ];
            return view('admin.karyawan.creates', $output);
        } else {

            return redirect()->back();
        }
    }

    public function store_page(Request $request)
    {
        if ($request->hasfile('foto')) 
        {
            $fileFoto = $request->file('foto');
            $namaFile = '' . time() . $fileFoto->getClientOriginalName();
            $tujuan_upload = 'Foto_Profile';
            $fileFoto->move($tujuan_upload, $namaFile);

            $user = new Karyawan;
            $user->nama = $request->namaKaryawan;
            $user->tgllahir = $request->tgllahirKaryawan;
            $user->jenis_kelamin = $request->jenis_kelaminKaryawan;
            $user->alamat = $request->alamatKaryawan;
            $user->no_hp = $request->no_hpKaryawan;
            $user->email = $request->emailKaryawan;
            $user->agama = $request->agamaKaryawan;
            $user->nik = $request->nikKaryawan;
            $user->gol_darah = $request->gol_darahKaryawan;
            $user->foto = $namaFile;
            $user->jabatan = $request->jabatanKaryawan;
            $user->tglmasuk = $request->tglmasukKaryawan;
            $user->atasan_pertama = $request->atasan_pertama;
            $user->atasan_kedua = $request->atasan_kedua;
            $user->status_karyawan = $request->status_karyawan;
            $user->tipe_karyawan = $request->tipe_karyawan;
            $user->no_kk = $request->no_kk;
            $user->status_kerja = $request->status_kerja;
            $user->cuti_tahunan = $request->cuti_tahunan;
            $user->divisi = $request->divisi;
            $user->no_rek = $request->no_rek;
            $user->no_bpjs_kes = $request->no_bpjs_ket;
            $user->no_npwp = $request->no_npwp;
            $user->no_bpjs_ket = $request->no_bpjs_ket;
            $user->kontrak = $request->kontrak;
            $user->gaji = $request->gaji;
            $user->tglkeluar = $request->tglkeluar;
            $user->save();
            
             // menyimpan data ke cache dengan key "karyawan_cache" selama 60 menit (1 jam)
            Cache::put('karyawan_cache', $user, 60);
    
            return redirect()->back()->with('karyawan_cache', Cache::get('karyawan_cache'));
           
        }else
        {
            $user = new Karyawan;
            $user->nama = $request->namaKaryawan;
            $user->tgllahir = $request->tgllahirKaryawan;
            $user->jenis_kelamin = $request->jenis_kelaminKaryawan; 
            $user->alamat = $request->alamatKaryawan;
            $user->no_hp = $request->no_hpKaryawan;
            $user->email = $request->emailKaryawan;
            $user->agama = $request->agamaKaryawan;
            $user->nik = $request->nikKaryawan;
            $user->gol_darah = $request->gol_darahKaryawan;
            $user->jabatan = $request->jabatanKaryawan;
            $user->tglmasuk = $request->tglmasukKaryawan;
            $user->atasan_pertama = $request->atasan_pertama;
            $user->atasan_kedua = $request->atasan_kedua;
            $user->status_karyawan = $request->status_karyawan;
            $user->tipe_karyawan = $request->tipe_karyawan;
            $user->no_kk = $request->no_kk;
            $user->status_kerja = $request->status_kerja;
            $user->cuti_tahunan = $request->cuti_tahunan;
            $user->divisi = $request->divisi;
            $user->no_rek = $request->no_rek;
            $user->no_bpjs_kes = $request->no_bpjs_ket;
            $user->no_npwp = $request->no_npwp;
            $user->no_bpjs_ket = $request->no_bpjs_ket;
            $user->kontrak = $request->kontrak;
            $user->gaji = $request->gaji;
            $user->tglkeluar = $request->tglkeluar;
            $user->save();


            Cache::put('karyawan_cache', $user, 60);
            return redirect()->back()->with('karyawan_cache', Cache::get('karyawan_cache'));
            // dd(Cache::get('karyawan_cache'));
            // return view('admin.karyawan.creates', compact('user'));
            // return redirect()->route('karyawancreates', ['tab' => 'datakeluarga']);
           
        }
    }

    public function storedk(Request $request)
    {
        $userFromCache = Cache::get('karyawan_cache');
        $id = $userFromCache->id;

        $data_keluarga = array(
            'id_pegawai' =>$id,
            'status_pernikahan' => $request->post('status_pernikahan'),
            'nama' => $request->post('namaPasangan'),
            'tgllahir' => $request->post('tgllahirPasangan'),
            'alamat' => $request->post('alamatPasangan'),
            'pendidikan_terakhir' => $request->post('pendidikan_terakhirPasangan'),
            'pekerjaan' => $request->post('pekerjaanPasangan'),
            'hubungan' => $request->post('hubungankeluarga'),
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime(),
        );
        // Keluarga::insert($data_keluarga);user
       
        $cache_key = 'data_keluarga_' . $id;
        Cache::put($cache_key, $data_keluarga, 60);
        dd($userFromCache,$id,$data_keluarga,$cache_key);

        return view('admin.karyawan.creates', compact('user','cache_key'));
    }

    public function storedatakel(Request $request,$id)
    {
        $idk = Karyawan::findorFail($id);

        $data_keluarga = array(
            'id_pegawai' =>$idk->id,
            'status_pernikahan' => $request->post('status_pernikahan'),
            'nama' => $request->post('namaPasangan'),
            'tgllahir' => $request->post('tgllahirPasangan'),
            'alamat' => $request->post('alamatPasangan'),
            'pendidikan_terakhir' => $request->post('pendidikan_terakhirPasangan'),
            'pekerjaan' => $request->post('pekerjaanPasangan'),
            'hubungan' => $request->post('hubungankeluarga'),
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime(),
        );
        Keluarga::insert($data_keluarga);
        return redirect()->back()->withInput();
    }


    public function storekd(Request $request)
    {
        $user = Karyawan::max('id');

        if($user)
        {
            $data_kdarurat = array(
                'id_pegawai' => $user,
                'nama' => $request->post('namaKdarurat'),
                'alamat' => $request->post('alamatKdarurat'),
                'no_hp' => $request->post('no_hpKdarurat'),
                'hubungan' => $request->post('hubunganKdarurat'),
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),
            );
            Kdarurat::insert($data_kdarurat);
            return redirect()->back()->withInput();
        }else
        {
            $data_kdarurat = array(
                'id_pegawai' => $request->post('idpegawai'),
                'nama' => $request->post('namaKdarurat'),
                'alamat' => $request->post('alamatKdarurat'),
                'no_hp' => $request->post('no_hpKdarurat'),
                'hubungan' => $request->post('hubunganKdarurat'),
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),
            );
            Kdarurat::insert($data_kdarurat);
            return redirect()->back()->withInput();
        }
    }

    public function storekonrat(Request $request,$id)
    {
        $idk = Karyawan::findorFail($id);

        $data_kdarurat = array(
            'id_pegawai' => $idk->id,
            'nama' => $request->post('namaKdarurat'),
            'alamat' => $request->post('alamatKdarurat'),
            'no_hp' => $request->post('no_hpKdarurat'),
            'hubungan' => $request->post('hubunganKdarurat'),
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime(),
        );
        Kdarurat::insert($data_kdarurat);
        return redirect()->back()->withInput();
    }

    public function storepformal(Request $request)
    {
        $user = Karyawan::max('id');

        if($request->tingkat_pendidikan)
        {
            $r_pendidikan = array(
                'id_pegawai' => $user,
                'tingkat' => $request->post('tingkat_pendidikan'),
                'nama_sekolah' => $request->post('nama_sekolah'),
                'kota_pformal' => $request->post('kotaPendidikanFormal'),
                'jurusan' => $request->post('jurusan'),
                'tahun_lulus_formal' => $request->post('tahun_lulusFormal'),

                'jenis_pendidikan' =>null,
                'kota_pnonformal' => null,
                'tahun_lulus_nonformal' =>null,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),
            );
    
            Rpendidikan::insert($r_pendidikan);
        }else
        {
            $r_pendidikan = array(
                'id_pegawai' => $user,
                'tingkat' => null,
                'nama_sekolah' =>null,
                'kota_pformal' => null,
                'jurusan' => null,
                'tahun_lulus_formal' =>null,

                'jenis_pendidikan' => $request->post('jenis_pendidikan'),
                'kota_pnonformal' => $request->post('kotaPendidikanNonFormal'),
                'tahun_lulus_nonformal' => $request->post('tahunLulusNonFormal'),
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),
            );
    
            Rpendidikan::insert($r_pendidikan);
        }
        return redirect()->back()->withInput();
    }

    //store setelah show data karyawan
    public function storespformal(Request $request,$id)
    {
        $idk = Karyawan::findorFail($id);
        if($request->tingkat_pendidikan)
        {
            $r_pendidikan = array(
                'id_pegawai' => $idk->id,
                'tingkat' => $request->post('tingkat_pendidikan'),
                'nama_sekolah' => $request->post('nama_sekolah'),
                'kota_pformal' => $request->post('kotaPendidikanFormal'),
                'jurusan' => $request->post('jurusan'),
                'tahun_lulus_formal' => $request->post('tahun_lulusFormal'),

                'jenis_pendidikan' =>null,
                'kota_pnonformal' => null,
                'tahun_lulus_nonformal' =>null,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),
            );
    
            Rpendidikan::insert($r_pendidikan);
            return redirect()->back()->withInput();
        }else
        {
            $r_pendidikan = array(
                'id_pegawai' => $idk->id,
                'tingkat' => null,
                'nama_sekolah' =>null,
                'kota_pformal' => null,
                'jurusan' => null,
                'tahun_lulus_formal' =>null,

                'jenis_pendidikan' => $request->post('jenis_pendidikan'),
                'kota_pnonformal' => $request->post('kotaPendidikanNonFormal'),
                'tahun_lulus_nonformal' => $request->post('tahunLulusNonFormal'),
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),
            );
    
            Rpendidikan::insert($r_pendidikan);
            return redirect()->back()->withInput();
        }
    }

    //store ketika creates data
    public function storepekerjaan(Request $request)
    {
    
        $user = Karyawan::max('id');
        $r_pekerjaan = array(
            'id_pegawai' => $user,
            'nama_perusahaan' => $request->post('namaPerusahaan'),
            'alamat' => $request->post('alamatPerusahaan'),
            'jenis_usaha' => $request->post('jenisUsaha'),
            'jabatan' => $request->post('jabatanRpkerejaan'),
            'nama_atasan' => $request->post('namaAtasan'),
            'nama_direktur' => $request->post('namaDirektur'),
            'lama_kerja' => $request->post('lamaKerja'),
            'alasan_berhenti' => $request->post('alasanBerhenti'),
            'gaji' => $request->post('gajiRpekerjaan'),
    
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime(),
        );
        Rpekerjaan::insert($r_pekerjaan);
        return redirect()->back()->withInput();
    }

    //store ketika show data
    public function storespekerjaan(Request $request,$id)
    {
        $idk = Karyawan::findorFail($id);
        $r_pekerjaan = array(
            'id_pegawai' => $idk->id,
            'nama_perusahaan' => $request->post('namaPerusahaan'),
            'alamat' => $request->post('alamatPerusahaan'),
            'jenis_usaha' => $request->post('jenisUsaha'),
            'jabatan' => $request->post('jabatanRpkerejaan'),
            'nama_atasan' => $request->post('namaAtasan'),
            'nama_direktur' => $request->post('namaDirektur'),
            'lama_kerja' => $request->post('lamaKerja'),
            'alasan_berhenti' => $request->post('alasanBerhenti'),
            'gaji' => $request->post('gajiRpekerjaan'),
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime(),
        );
        Rpekerjaan::insert($r_pekerjaan);
        return redirect()->back()->withInput();
    }

    public function update(Request $request,$id)
    {
        $karyawan = Karyawan::find($id);
        $request->validate(['foto' => 'image|mimes:jpeg,png,jpg|max:2048']);
        $fotoLama = $karyawan->foto;

        if ($file = $request->file('foto')) 
        {
            // hapus foto lama dari storage
            if($fotoLama !== null){
                $oldImage = public_path('Foto_Profile/'.$fotoLama);
                if(file_exists($oldImage)){
                    unlink($oldImage);
                }
            }
            $extension = $file->getClientOriginalExtension();
            $filename = '' . time() . $file->getClientOriginalName();
            $file->move(public_path() . '\Foto_Profile', $filename);
            $karyawan->foto = $filename;
            $karyawan->save();
            
            $data = array(

                'nama' => $request->post('namaKaryawan'),
                'tgllahir' => $request->post('tgllahirKaryawan'),
                'jenis_kelamin' => $request->post('jenis_kelaminKaryawan'),
                'alamat' => $request->post('alamatKaryawan'),
                'no_hp' => $request->post('no_hpKaryawan'),
                'email' => $request->post('emailKaryawan'),
                'agama' => $request->post('agamaKaryawan'),
                'nik' => $request->post('nikKaryawan'),
                'gol_darah' => $request->post('gol_darahKaryawan'),
                'jabatan' => $request->post('jabatanKaryawan'),
                'divisi'=>$request->post('divisi'),
                'atasan_pertama'=>$request->post('atasan_pertama'),
                'atasan_kedua'=>$request->post('atasan_kedua'),
                'updated_at' => new \DateTime(),
                'foto' => $filename,
            );
            // $idKaryawan = $request->post('id_karyawan');
            // Karyawan::where('id', $idKaryawan)->update($data);
            Karyawan::where('id', $id)->update($data);

            return redirect()->back();
            dd($data);
        }
        else
        {
          
            $data = array(

                'nama' => $request->post('namaKaryawan'),
                'tgllahir' => $request->post('tgllahirKaryawan'),
                'jenis_kelamin' => $request->post('jenis_kelaminKaryawan'),
                'alamat' => $request->post('alamatKaryawan'),
                'no_hp' => $request->post('no_hpKaryawan'),
                'email' => $request->post('emailKaryawan'),
                'agama' => $request->post('agamaKaryawan'),
                'nik' => $request->post('nikKaryawan'),
                'gol_darah' => $request->post('gol_darahKaryawan'),
                'jabatan' => $request->post('jabatanKaryawan'),
                'divisi'=>$request->post('divisi'),
                'atasan_pertama'=>$request->post('atasan_pertama'),
                'atasan_kedua'=>$request->post('atasan_kedua'),
                // 'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),
            );
            // $idKaryawan = $request->post('id_karyawan');
            // Karyawan::where('id', $idKaryawan)->update($data);
            Karyawan::where('id', $id)->update($data);
            return redirect()->back();
            dd($karyawan,$data);
           
        }

    }

    public function updateKeluarga(Request $request,$id)
    {
        $data_keluarga = array(
            'status_pernikahan' => $request->post('status_pernikahan'),
            'nama' => $request->post('namaPasangan'),
            'tgllahir' => $request->post('tgllahirPasangan'),
            'alamat' => $request->post('alamatPasangan'),
            'pendidikan_terakhir' => $request->post('pendidikan_terakhirPasangan'),
            'pekerjaan' => $request->post('pekerjaanPasangan'),
            // 'hubungan' =>$request->post('pekerjaanPasangan'),
            'updated_at' => new \DateTime(),

        );
        $idKeluarga = $request->post('id_keluarga');
        Keluarga::where('id', $idKeluarga)->update($data_keluarga);
        return redirect()->back();
    }

    public function updateKontak(Request $request,$id)
    {
        $data_kdarurat = array(
            'nama' => $request->post('namaKdarurat'),
            'alamat' => $request->post('alamatKdarurat'),
            'no_hp' => $request->post('no_hpKdarurat'),
            'hubungan' => $request->post('hubunganKdarurat'),

        );

        $id_kdarurat = $request->post('id_kdarurat');
        Kdarurat::where('id', $id_kdarurat)->update($data_kdarurat);
        return redirect()->back();
    }

    public function updatePendidikan(Request $request,$id)
    {
        if($request->tingkat_pendidikan)
        {
            $r_pendidikan = array(
                'tingkat' => $request->post('tingkat_pendidikan'),
                'nama_sekolah' => $request->post('nama_sekolah'),
                'kota_pformal' => $request->post('kotaPendidikanFormal'),
                'jurusan' => $request->post('jurusan'),
                'tahun_lulus_formal' => $request->post('tahun_lulus_formal'),
                'updated_at' => new \DateTime(),
            );

            $idPendidikan = $request->post('id_pendidikan');
            Rpendidikan::where('id', $idPendidikan)->update($r_pendidikan);
        }else
        {
            $r_pendidikan = array(
                'jenis_pendidikan' => $request->post('jenis_pendidikan'),
                'kota_pnonformal' => $request->post('kotaPendidikanNonFormal'),
                'tahun_lulus_nonformal' => $request->post('tahunLulusNonFormal'),
                'updated_at' => new \DateTime(),
            );

            $idPendidikan = $request->post('id_pendidikan');
            Rpendidikan::where('id', $idPendidikan)->update($r_pendidikan);
        }
        return redirect()->back();
    }

    public function updatePekerjaan(Request $request,$id)
    {
        $r_pekerjaan = array(
            'nama_perusahaan' => $request->post('namaPerusahaan'),
            'alamat' => $request->post('alamatPerusahaan'),
            'jenis_usaha' => $request->post('jenisUsaha'),
            'jabatan' => $request->post('jabatan'),
            'nama_atasan' => $request->post('namaAtasan'),
            'nama_direktur' => $request->post('namaDirektur'),
            'lama_kerja' => $request->post('lamaKerja'),
            'alasan_berhenti' => $request->post('alasanBerhenti'),
            'gaji' => $request->post('gajiRpekerjaan'),
            'updated_at' => new \DateTime(),
        );

        $idPekerjaan = $request->post('id_pekerjaan');
        Rpekerjaan::where('id', $idPekerjaan)->update($r_pekerjaan);
        return redirect()->back();
    }

    public function destroy(Request $request,$id)
    {
        Rpekerjaan::destroy($id);
        return redirect('karyawan');
    }
    
}
