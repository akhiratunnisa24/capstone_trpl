<?php

namespace App\Http\Controllers\karyawan;

use Carbon\Carbon;
use App\Models\Karyawan;
use App\Models\Kdarurat;
use App\Models\Keluarga;
use App\Models\Departemen;
use App\Models\Rpekerjaan;
use App\Models\Rpendidikan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class KaryawansController extends Controller
{
    //data karyawan
    public function create(Request $request)
    {
        $role = Auth::user()->role;

        if ($role == 1) {

            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
            $departemen     = Departemen::all();
            $atasan_pertama = Karyawan::whereIn('jabatan', ['Supervisor', 'Manager','Management'])->get();
            $atasan_kedua   = Karyawan::whereIn('jabatan', ['Manager','Management'])->get();

            $karyawan = $request->session()->get('karyawan');
            if(!$karyawan) {
                // Buat instance baru dari model atau objek yang sesuai
                $karyawan = new Karyawan;
            }
            $output = [
                'row' => $row,
                'departemen' => $departemen,
                'atasan_pertama' => $atasan_pertama,
                'atasan_kedua' => $atasan_kedua,
                'karyawan'=>$karyawan
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
            // $karyawan->save();

            if(empty($request->session()->get('karyawan')))
            {
                $karyawan                = new Karyawan;
                $karyawan->nama          = $request->namaKaryawan;
                $karyawan->tgllahir      = $request->tgllahirKaryawan;
                $karyawan->jenis_kelamin = $request->jenis_kelaminKaryawan;
                $karyawan->alamat        = $request->alamatKaryawan;
                $karyawan->no_hp         = $request->no_hpKaryawan;
                $karyawan->email         = $request->emailKaryawan;
                $karyawan->agama         = $request->agamaKaryawan;
                $karyawan->nik           = $request->nikKaryawan;
                $karyawan->gol_darah     = $request->gol_darahKaryawan;
                $karyawan->foto          = $namaFile;
                $karyawan->jabatan       = $request->jabatanKaryawan;
                $karyawan->tglmasuk      = $request->tglmasukKaryawan;
                $karyawan->atasan_pertama= $request->atasan_pertama;
                $karyawan->atasan_kedua  = $request->atasan_kedua;
                $karyawan->status_karyawan= $request->status_karyawan;
                $karyawan->tipe_karyawan = $request->tipe_karyawan;
                $karyawan->no_kk         = $request->no_kk;
                $karyawan->status_kerja  = $request->status_kerja;
                $karyawan->cuti_tahunan  = $request->cuti_tahunan;
                $karyawan->divisi        = $request->divisi;
                $karyawan->no_rek        = $request->no_rek;
                $karyawan->no_bpjs_kes   = $request->no_bpjs_ket;
                $karyawan->no_npwp       = $request->no_npwp;
                $karyawan->no_bpjs_ket   = $request->no_bpjs_ket;
                $karyawan->kontrak       = $request->kontrak;
                $karyawan->gaji          = $request->gaji;
                $karyawan->tglkeluar     = $request->tglkeluar;
                $karyawan->status_kerja  = 'Aktif';

                $request->session()->put('karyawan', $karyawan);
                // dd($karyawan);
            }else
            {
                $karyawan = $request->session()->get('karyawan');

                $karyawan->nama          = $request->namaKaryawan;
                $karyawan->tgllahir      = $request->tgllahirKaryawan;
                $karyawan->jenis_kelamin = $request->jenis_kelaminKaryawan;
                $karyawan->alamat        = $request->alamatKaryawan;
                $karyawan->no_hp         = $request->no_hpKaryawan;
                $karyawan->email         = $request->emailKaryawan;
                $karyawan->agama         = $request->agamaKaryawan;
                $karyawan->nik           = $request->nikKaryawan;
                $karyawan->gol_darah     = $request->gol_darahKaryawan;
                $karyawan->foto          = $namaFile;
                $karyawan->jabatan       = $request->jabatanKaryawan;
                $karyawan->tglmasuk      = $request->tglmasukKaryawan;
                $karyawan->atasan_pertama= $request->atasan_pertama;
                $karyawan->atasan_kedua  = $request->atasan_kedua;
                $karyawan->status_karyawan= $request->status_karyawan;
                $karyawan->tipe_karyawan = $request->tipe_karyawan;
                $karyawan->no_kk         = $request->no_kk;
                $karyawan->status_kerja  = $request->status_kerja;
                $karyawan->cuti_tahunan  = $request->cuti_tahunan;
                $karyawan->divisi        = $request->divisi;
                $karyawan->no_rek        = $request->no_rek;
                $karyawan->no_bpjs_kes   = $request->no_bpjs_ket;
                $karyawan->no_npwp       = $request->no_npwp;
                $karyawan->no_bpjs_ket   = $request->no_bpjs_ket;
                $karyawan->kontrak       = $request->kontrak;
                $karyawan->gaji          = $request->gaji;
                $karyawan->tglkeluar     = $request->tglkeluar;
                $karyawan->status_kerja  = 'Aktif';

                $request->session()->put('karyawan', $karyawan);
                // dd($karyawan);

            }
            return redirect()->route('create.dakel');
             // menyimpan data ke cache dengan key "karyawan_cache" selama 60 menit (1 jam)
            // Cache::put('karyawan_cache', $karyawan, 60);
            //return redirect()->back()->with('karyawan_cache', Cache::get('karyawan_cache'));
           
        }else
        {
            if(empty($request->session()->get('product')))
            {
                $karyawan               = new Karyawan;
                $karyawan->nama         = $request->namaKaryawan;
                $karyawan->tgllahir     = $request->tgllahirKaryawan;
                $karyawan->jenis_kelamin= $request->jenis_kelaminKaryawan; 
                $karyawan->alamat       = $request->alamatKaryawan;
                $karyawan->no_hp        = $request->no_hpKaryawan;
                $karyawan->email        = $request->emailKaryawan;
                $karyawan->agama        = $request->agamaKaryawan;
                $karyawan->nik          = $request->nikKaryawan;
                $karyawan->gol_darah    = $request->gol_darahKaryawan;
                $karyawan->jabatan      = $request->jabatanKaryawan;
                $karyawan->tglmasuk     = $request->tglmasukKaryawan;
                $karyawan->atasan_pertama= $request->atasan_pertama;
                $karyawan->atasan_kedua = $request->atasan_kedua;
                $karyawan->status_karyawan= $request->status_karyawan;
                $karyawan->tipe_karyawan= $request->tipe_karyawan;
                $karyawan->no_kk        = $request->no_kk;
                $karyawan->status_kerja = $request->status_kerja;
                $karyawan->cuti_tahunan = $request->cuti_tahunan;
                $karyawan->divisi       = $request->divisi;
                $karyawan->no_rek       = $request->no_rek;
                $karyawan->no_bpjs_kes  = $request->no_bpjs_ket;
                $karyawan->no_npwp      = $request->no_npwp;
                $karyawan->no_bpjs_ket  = $request->no_bpjs_ket;
                $karyawan->kontrak      = $request->kontrak;
                $karyawan->gaji         = $request->gaji;
                $karyawan->tglkeluar    = $request->tglkeluar;
                $karyawan->status_kerja = 'Aktif';

                $request->session()->put('karyawan', $karyawan);
            }else
            {
                $karyawan = $request->session()->get('karyawan');

                $karyawan->nama          = $request->namaKaryawan;
                $karyawan->tgllahir      = $request->tgllahirKaryawan;
                $karyawan->jenis_kelamin = $request->jenis_kelaminKaryawan;
                $karyawan->alamat        = $request->alamatKaryawan;
                $karyawan->no_hp         = $request->no_hpKaryawan;
                $karyawan->email         = $request->emailKaryawan;
                $karyawan->agama         = $request->agamaKaryawan;
                $karyawan->nik           = $request->nikKaryawan;
                $karyawan->gol_darah     = $request->gol_darahKaryawan;
                $karyawan->jabatan       = $request->jabatanKaryawan;
                $karyawan->tglmasuk      = $request->tglmasukKaryawan;
                $karyawan->atasan_pertama= $request->atasan_pertama;
                $karyawan->atasan_kedua  = $request->atasan_kedua;
                $karyawan->status_karyawan= $request->status_karyawan;
                $karyawan->tipe_karyawan = $request->tipe_karyawan;
                $karyawan->no_kk         = $request->no_kk;
                $karyawan->status_kerja  = $request->status_kerja;
                $karyawan->cuti_tahunan  = $request->cuti_tahunan;
                $karyawan->divisi        = $request->divisi;
                $karyawan->no_rek        = $request->no_rek;
                $karyawan->no_bpjs_kes   = $request->no_bpjs_ket;
                $karyawan->no_npwp       = $request->no_npwp;
                $karyawan->no_bpjs_ket   = $request->no_bpjs_ket;
                $karyawan->kontrak       = $request->kontrak;
                $karyawan->gaji          = $request->gaji;
                $karyawan->tglkeluar     = $request->tglkeluar;
                $karyawan->status_kerja  = 'Aktif';

                $request->session()->put('karyawan', $karyawan);
            }
            return redirect()->route('create.dakel');
            // Cache::put('karyawan_cache', $karyawan, 60);
            //return redirect()->back()->with('karyawan_cache', Cache::get('karyawan_cache'));
           
        }
    }

    //data keluarga
    public function createdakel(Request $request)
    {
        $role = Auth::user()->role;
        if($role == 1) 
        {
            $karyawan    = $request->session()->get('karyawan');
            // $datakeluarga = $request->session()->get('datakeluarga',[]);
            // $datakeluarga = json_decode(session('datakeluarga'), true);
            // dd(session('datakeluarga'), '[]');
            $datakeluarga = json_decode(session('datakeluarga', '[]'), true);
            // dd($datakeluarga);
            if(empty($datakeluarga)) {
                $datakeluarga = [];
                // $datakeluarga = new Keluarga;
            }
            return view('admin.karyawan.createDakel',compact('karyawan','datakeluarga'));
        } else 
        {
            return redirect()->back();
        }
    } 

    public function storedk(Request $request)
    {
        //get data kelaurga yang disimpan dalam array
        // $datakeluarga = $request->session()->get('datakeluarga', []);
        $datakeluarga = json_decode($request->session()->get('datakeluarga', '[]'), true);


        // buat array data keluarga baru
        $datakeluargaBaru = [
            'status_pernikahan' => $request->status_pernikahan,
            'nama' => $request->namaPasangan,
            'tgllahir' => \Carbon\Carbon::parse($request->tgllahirPasangan)->format('Y-m-d'),
            'alamat' => $request->alamatPasangan,
            'pendidikan_terakhir' => $request->pendidikan_terakhirPasangan,
            'pekerjaan' => $request->pekerjaanPasangan,
            'hubungan' => $request->hubungankeluarga
        ];

        // tambahkan data keluarga baru ke dalam array datakeluarga
        $datakeluarga[] = $datakeluargaBaru;

        // dd($datakeluarga);

        // Simpan instance ke dalam session
        session()->put('datakeluarga', json_encode($datakeluarga));
        return redirect()->back();
        // return redirect()->route('create.konrat');
    }

    //data kontak darurat
    public function createkonrat(Request $request)
    {
        $role = Auth::user()->role;
        if($role == 1) 
        {
            $karyawan     = $request->session()->get('karyawan');
            $datakeluarga = $request->session()->get('datakeluarga');
            // $kontakdarurat= $request->session()->get('kontakdarurat');
            $kontakdarurat = json_decode(session('kontakdarurat', '[]'), true);
           
            // if(!$kontakdarurat) {
            if(empty($kontakdarurat)) {    
                // Buat instance baru dari model atau objek yang sesuai
                // $kontakdarurat = new Kdarurat;
                $kontakdarurat = [];
            }
            return view('admin.karyawan.createKonrat',compact('karyawan','datakeluarga','kontakdarurat'));
        } else {

            return redirect()->back();
        }    
    }
     public function storekd(Request $request)
    {
        $kontakdarurat = json_decode($request->session()->get('kontakdarurat', '[]'), true);
        $kontakdaruratBaru = [
            'nama' => $request->namaKdarurat,
            'alamat' => $request->alamatKdarurat,
            'no_hp' => $request->no_hpKdarurat,
            'hubungan' => $request->hubunganKdarurat,
        ];

        $kontakdarurat[] = $kontakdaruratBaru;

        session()->put('kontakdarurat', json_encode($kontakdarurat));
        return redirect()->back();

        //     $kontakdarurat = new Kdarurat;
        //     $kontakdarurat->nama = $request->namaKdarurat;
        //     $kontakdarurat->alamat= $request->alamatKdarurat;
        //     $kontakdarurat->no_hp = $request->no_hpKdarurat;
        //     $kontakdarurat->hubungan = $request->hubunganKdarurat;
           
        //     $request->session()->put('kontakdarurat', $kontakdarurat);

        // return redirect()->route('create.pendidikan');
    }

    //data untuk pendidikan
    public function creatependidikan(Request $request)
    {
        $role = Auth::user()->role;
        if ($role == 1) 
        {
            $karyawan     = $request->session()->get('karyawan');
            $datakeluarga = $request->session()->get('datakeluarga');
            $kontakdarurat= $request->session()->get('kontakdarurat');
            // $pendidikan   = $request->session()->get('pendidikan');
            $pendidikan = json_decode(session('pendidikan', '[]'), true);
            // dd($pendidikan);
            if(empty($pendidikan)) {
                // Buat instance baru dari model atau objek yang sesuai
                // $pendidikan = new Rpendidikan;
                $pendidikan = [];
            }
            return view('admin.karyawan.createPendidikan',compact('karyawan','datakeluarga','kontakdarurat','pendidikan'));
        }else 
        {
            return redirect()->back();
        }
    }

    //store ketika creates data
    public function storepformal(Request $request)
    {
        if($request->tingkat_pendidikan)
        {
            $pendidikan = json_decode($request->session()->get('pendidikan', '[]'), true);
            $pendidikanBaru = [
                'tingkat' => $request->namaKdarurat,
                'nama_sekolah' => $request->alamatKdarurat,
                'kota_pformal' => $request->no_hpKdarurat,
                'jurusan' => $request->hubunganKdarurat,
                'tahun_lulus_formal'=>$request->tahun_lulusFormal,
                'jenis_pendidikan'=>null,
                'kota_pnonformal'=>null,
                'tahun_lulus_nonformal' =>null,
            ];
    
            $pendidikan[] = $pendidikanBaru;
    
            dd($pendidikan);
            session()->put('pendidikan', json_encode($pendidikan));
            return redirect()->back();
    
            // $pendidikan = new Rpendidikan;
            // $pendidikan->tingkat =  $request->tingkat_pendidikan;
            // $pendidikan->nama_sekolah = $request->nama_sekolah;
            // $pendidikan->kota_pformal =  $request->kotaPendidikanFormal;
            // $pendidikan->jurusan = $request->jurusan;
            // $pendidikan->tahun_lulus_formal = $request->tahun_lulusFormal;

            // $pendidikan->jenis_pendidikan = null;
            // $pendidikan->kota_pnonformal =null;
            // $pendidikan->tahun_lulus_nonformal =null;
          
            // $request->session()->put('pendidikan', $pendidikan);
    
            // return redirect()->route('create.pekerjaan');
        }elseif($request->jenis_pendidikan)
        {

            $pendidikan = json_decode($request->session()->get('pendidikan', '[]'), true);
            $pendidikanBaru = [
                'tingkat' =>null,
                'nama_sekolah' =>null,
                'kota_pformal' =>null,
                'jurusan' =>null,
                'tahun_lulus_formal'=>null,
                'jenis_pendidikan'=>$request->jenis_pendidikan,
                'kota_pnonformal'=>$request->kotaPendidikanNonFormal,
                'tahun_lulus_nonformal' =>$request->tahunLulusNonFormal,
            ];
    
            $pendidikan[] = $pendidikanBaru;
    
            session()->put('pendidikan', json_encode($pendidikan));
            return redirect()->back();
        }
        else
        {

            $pendidikan = json_decode($request->session()->get('pendidikan', '[]'), true);
            $pendidikanBaru = [
                'tingkat' => $request->namaKdarurat,
                'nama_sekolah' => $request->alamatKdarurat,
                'kota_pformal' => $request->no_hpKdarurat,
                'jurusan' => $request->hubunganKdarurat,
                'tahun_lulus_formal'=>$request->tahun_lulusFormal,
                'jenis_pendidikan'=>$request->jenis_pendidikan,
                'kota_pnonformal'=>$request->kotaPendidikanNonFormal,
                'tahun_lulus_nonformal' =>$request->tahunLulusNonFormal,
            ];
    
            $pendidikan[] = $pendidikanBaru;
    
            session()->put('pendidikan', json_encode($pendidikan));
            return redirect()->back();

            // $pendidikan = new Rpendidikan;
            // $pendidikan->tingkat = null;
            // $pendidikan->nama_sekolah =null;
            // $pendidikan->kota_pformal = null;
            // $pendidikan->jurusan = null;
            // $pendidikan->tahun_lulus_formal =null;

            // $pendidikan->jenis_pendidikan =  $request->jenis_pendidikan;
            // $pendidikan->kota_pnonformal = $request->kotaPendidikanNonFormal;
            // $pendidikan->tahun_lulus_nonformal = $request->tahunLulusNonFormal;
           
            // $request->session()->put('pendidikan', $pendidikan);
        }
        // return redirect()->route('create.pekerjaan');
    }

    //data untuk pekerjaan
    public function createpekerjaan(Request $request)
    {
        $role = Auth::user()->role;
        if ($role == 1) 
        {
            $karyawan     = $request->session()->get('karyawan');
            $datakeluarga = $request->session()->get('datakeluarga');
            $kontakdarurat= $request->session()->get('kontakdarurat');
            $pendidikan   = $request->session()->get('pendidikan');
            $pekerjaan    = $request->session()->get('pekerjaan');

            if(!$pekerjaan) {
                // Buat instance baru dari model atau objek yang sesuai
                $pekerjaan = new Rpekerjaan;
            }
            return view('admin.karyawan.createPekerjaan',compact('pekerjaan','karyawan','datakeluarga','kontakdarurat','pendidikan'));
        } else 
        {
            return redirect()->back();
        }
    }

     //store ketika creates data
     public function storepekerjaan(Request $request)
     {
        $pekerjaan = new Rpekerjaan;

        $pekerjaan->nama_perusahaan = $request->namaPerusahaan;
        $pekerjaan->alamat = $request->alamatPerusahaan;
        $pekerjaan->jenis_usaha = $request->jenisUsaha;
        $pekerjaan->jabatan = $request->jabatanRpkerejaan;
        $pekerjaan->nama_atasan = $request->namaAtasan;
        $pekerjaan->nama_direktur = $request->namaDirektur;
        $pekerjaan->lama_kerja = $request->lamaKerja;
        $pekerjaan->alasan_berhenti = $request->alasanBerhenti;
        $pekerjaan->gaji = $request->gajiRpekerjaan;

        $request->session()->put('pekerjaan', $pekerjaan);
 
         //meyimpan data ke database
         $karyawan= $request->session()->get('karyawan');
         $karyawan->save();
         $idKaryawan = $karyawan->id;
        //  dd($idKaryawan);    
 
        $datakeluarga = $request->session()->get('datakeluarga');
        $datakeluarga['id_pegawai'] = $idKaryawan;
        $datakeluarga->save();
 
        
        $kontakdarurat= $request->session()->get('kontakdarurat');
        $kontakdarurat['id_pegawai'] = $idKaryawan;
        $kontakdarurat->save();
 
        $pendidikan= $request->session()->get('pendidikan');
        $pendidikan['id_pegawai'] = $idKaryawan;
        $pendidikan->save();
 
        $pekerjaan= $request->session()->get('pekerjaan');
        $pekerjaan['id_pegawai'] = $idKaryawan;
        $pekerjaan->save();  
         
         //hapus data pada session
        $request->session()->forget('karyawan');
        $request->session()->forget('datakeluarga');
        $request->session()->forget('kontakdarurat');
        $request->session()->forget('pendidikan');
        $request->session()->forget('pekerjaan');
         
        return redirect('/karyawan');
    }

    //===================================================================================

    //store daa kelaurga setelah show
    public function storedatakel(Request $request,$id)
    {
        $idk = Karyawan::findorFail($id);

        $data_keluarga = array(
            'id_pegawai'        =>$idk->id,
            'status_pernikahan' => $request->post('status_pernikahan'),
            'nama'              => $request->post('namaPasangan'),
            'tgllahir'          => $request->post('tgllahirPasangan'),
            'alamat'            => $request->post('alamatPasangan'),
            'pendidikan_terakhir'=> $request->post('pendidikan_terakhirPasangan'),
            'pekerjaan'         => $request->post('pekerjaanPasangan'),
            'hubungan'          => $request->post('hubungankeluarga'),
            'created_at'        => new \DateTime(),
            'updated_at'         => new \DateTime(),
        );
        Keluarga::insert($data_keluarga);
        return redirect()->back()->withInput();
    }

    //store kontak darurat ketika show data
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

    //store pendidikan setelah show data karyawan
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

    //store pekerjaan ketika show data
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

     //===================================================================================
    //edit data karyawan
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

            $pegawai = Karyawan::find($id);
            $pegawai->nama = $request->namaKaryawan;
            $pegawai->nik = $request->nikKaryawan;
            $pegawai->tgllahir = $request->tgllahirKaryawan;
            $pegawai->jenis_kelamin = $request->jenis_kelaminKaryawan;
            $pegawai->alamat = $request->alamatKaryawan;
            $pegawai->no_hp = $request->no_hpKaryawan;
            $pegawai->email = $request->emailKaryawan;
            $pegawai->agama = $request->agamaKaryawan;
            $pegawai->gol_darah = $request->gol_darahKaryawan;
            $pegawai->jabatan = $request->jabatanKaryawan;
            $pegawai->divisi = $request->divisi;
            $pegawai->atasan_pertama = $request->atasan_pertama;
            $pegawai->atasan_kedua = $request->atasan_kedua;
            $pegawai->foto = $filename;
          
            $pegawai->update();

            // dd($request->status_pernikahan);
            Keluarga::where('id_pegawai','=',$id)->update([
                'status_pernikahan' =>$request->status_pernikahan,
            ]);
            return redirect()->back();
        }
        else
        {
            // dd($request->all());
            $pegawai = Karyawan::find($id);
            $pegawai->nama = $request->namaKaryawan;
            $pegawai->nik = $request->nikKaryawan;
            $pegawai->tgllahir = $request->tgllahirKaryawan;
            $pegawai->jenis_kelamin = $request->jenis_kelaminKaryawan;
            $pegawai->alamat = $request->alamatKaryawan;
            $pegawai->no_hp = $request->no_hpKaryawan;
            $pegawai->email = $request->emailKaryawan;
            $pegawai->agama = $request->agamaKaryawan;
            $pegawai->gol_darah = $request->gol_darahKaryawan;
            $pegawai->jabatan = $request->jabatanKaryawan;
            $pegawai->divisi = $request->divisi;
            $pegawai->atasan_pertama = $request->atasan_pertama;
            $pegawai->atasan_kedua = $request->atasan_kedua;
          
            $pegawai->update();

            // dd($request->status_pernikahan);
            Keluarga::where('id_pegawai','=',$id)->update([
                'status_pernikahan' =>$request->status_pernikahan,
            ]);
           
            return redirect()->back();
           
        }

    }

    //update data keluarga
    public function updateKeluarga(Request $request,$id)
    {
        // dd($request,$id);
        Keluarga::where('id',$id)->update([
            // 'status_pernikahan' =>$request->status_pernikahan,
            'nama' =>$request->namaPasangan,
            'hubungan' =>$request->hubungan,
            'tgllahir' =>$request->tgllahirPasangan,
            'alamat' =>$request->alamatPasangan,
            'pendidikan_terakhir' =>$request->pendidikan_terakhirPasangan,
            'pekerjaan' =>$request->pekerjaanPasangan,
        ]);
        return redirect()->back();
    }

    //update data kontak darurat
    public function updateKontak(Request $request,$id)
    {
        Kdarurat::where('id', $id)->update([
            'nama' => $request->post('namaKdarurat'),
            'alamat' => $request->post('alamatKdarurat'),
            'no_hp' => $request->post('no_hpKdarurat'),
            'hubungan' => $request->post('hubunganKdarurat'),
            'updated_at' => \Carbon\Carbon::now()->format('Y-m-d'),
        ]);

        return redirect()->back();
    }

    //update data pendidikan
    public function updatePendidikan(Request $request,$id)
    {
        $idp = Rpendidikan::find($id);
        if($request->tingkat_pendidikan)
        {
            $data = Rpendidikan::where('id', $idp->id)->update([
                'tingkat' => $request->tingkat_pendidikan,
                'nama_sekolah' => $request->nama_sekolah,
                'kota_pformal' => $request->kotaPendidikanFormal,
                'jurusan' => $request->jurusan,
                'tahun_lulus_formal' => $request->tahun_lulusFormal,
                'updated_at' => \Carbon\Carbon::now()->format('Y-m-d'),
            ]);
        }else
        {
            $data = Rpendidikan::where('id',$idp->id)->update([
                'jenis_pendidikan' => $request->jenis_pendidikan,
                'kota_pnonformal' => $request->kotaPendidikanNonFormal,
                'tahun_lulus_nonformal' => $request->tahunLulusNonFormal,
                'updated_at' => \Carbon\Carbon::now()->format('Y-m-d'),
            ]);
        }
        return redirect()->back();
    }

    //update data pekerjaan
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

    //hapus data pekerjaan
    public function destroy(Request $request,$id)
    {
        Rpekerjaan::destroy($id);
        return redirect('karyawan');
    }
    
}
