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
use App\Models\Rorganisasi;
use App\Models\Rprestasi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class KaryawansController extends Controller
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

    //data karyawan
    public function create(Request $request)
    {
        $role = Auth::user()->role;
        if ($role == 1) 
        {
            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
            $departemen     = Departemen::all();
            $atasan_pertama = Karyawan::whereIn('jabatan', ['Supervisor', 'Manager','Management'])->get();
            $atasan_kedua   = Karyawan::whereIn('jabatan', ['Manager','Management'])->get();

            $karyawan = $request->session()->get('karyawan');
            if(!$karyawan) {
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
        } else 
        {
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

            if(empty($request->session()->get('karyawan')))
            {
                $karyawan                = new Karyawan;
                $karyawan->nip           = $request->nipKaryawan;
                $karyawan->nama          = $request->namaKaryawan;
                $karyawan->tgllahir      = \Carbon\Carbon::parse($request->tgllahirKaryawan)->format('Y-m-d');
                $karyawan->tempatlahir   = $request->tempatlahirKaryawan;
                $karyawan->jenis_kelamin = $request->jenis_kelaminKaryawan;
                $karyawan->alamat        = $request->alamatKaryawan;
                $karyawan->no_hp         = $request->no_hpKaryawan;
                $karyawan->email         = $request->emailKaryawan;
                $karyawan->agama         = $request->agamaKaryawan;
                $karyawan->nik           = $request->nikKaryawan;
                $karyawan->no_kk         = $request->nokkKaryawan;
                $karyawan->no_npwp       = $request->nonpwpKaryawan;
                $karyawan->no_bpjs_ket   = $request->nobpjskerKaryawan;
                $karyawan->no_bpjs_kes   = $request->nobpjskesKaryawan;
                $karyawan->no_akdhk      = $request->noAkdhk;
                $karyawan->no_program_pensiun   = $request->noprogramPensiun;
                $karyawan->no_program_askes   = $request->noprogramAskes;
                $karyawan->no_rek   = $request->norekKaryawan;
                $karyawan->nama_bank   = $request->nama_bank;
                $karyawan->gol_darah     = $request->gol_darahKaryawan;
                $karyawan->foto          = $namaFile;
                $karyawan->jabatan       = $request->jabatanKaryawan;
                $karyawan->status_karyawan       = $request->statusKaryawan;
                $karyawan->tglmasuk      = \Carbon\Carbon::parse($request->tglmasukKaryawan)->format('Y-m-d');
                $karyawan->atasan_pertama= $request->atasan_pertama;
                $karyawan->atasan_kedua  = $request->atasan_kedua;
                $karyawan->tipe_karyawan = $request->tipe_karyawan;
                // $karyawan->no_kk         = $request->no_kk;
                $karyawan->status_kerja  = $request->status_kerja;
                $karyawan->cuti_tahunan  = $request->cuti_tahunan;
                $karyawan->divisi        = $request->divisi;
                // $karyawan->no_rek        = $request->no_rek;
                // $karyawan->no_bpjs_kes   = $request->no_bpjs_ket;
                // $karyawan->no_npwp       = $request->no_npwp;
                // $karyawan->no_bpjs_ket   = $request->no_bpjs_ket;
                $karyawan->kontrak       = $request->kontrak;
                $karyawan->gaji          = $request->gaji;
                $karyawan->tglkeluar     = $request->tglkeluar;
                $karyawan->status_kerja  = 'Aktif';

                $request->session()->put('karyawan', $karyawan);
            }else
            {
                $karyawan = $request->session()->get('karyawan');

                $karyawan->nip          = $request->nipKaryawan;
                $karyawan->nama          = $request->namaKaryawan;
                $karyawan->tgllahir      = \Carbon\Carbon::parse($request->tgllahirKaryawan)->format('Y-m-d');
                $karyawan->tempatlahir   = $request->tempatlahirKaryawan;
                $karyawan->jenis_kelamin = $request->jenis_kelaminKaryawan;
                $karyawan->alamat        = $request->alamatKaryawan;
                $karyawan->no_hp         = $request->no_hpKaryawan;
                $karyawan->email         = $request->emailKaryawan;
                $karyawan->agama         = $request->agamaKaryawan;
                $karyawan->nik           = $request->nikKaryawan;
                $karyawan->no_kk           = $request->nokkKaryawan;
                $karyawan->no_npwp       = $request->nonpwpKaryawan;
                $karyawan->no_bpjs_ket   = $request->nobpjskerKaryawan;
                $karyawan->no_bpjs_kes   = $request->nobpjskesKaryawan;
                $karyawan->no_akdhk   = $request->noAkdhk;
                $karyawan->no_program_pensiun   = $request->noprogramPensiun;
                $karyawan->no_program_askes   = $request->noprogramAskes;
                $karyawan->no_rek   = $request->norekKaryawan;
                $karyawan->nama_bank   = $request->nama_bank;
                $karyawan->gol_darah     = $request->gol_darahKaryawan;
                $karyawan->foto          = $namaFile;
                $karyawan->jabatan       = $request->jabatanKaryawan;
                $karyawan->status_karyawan       = $request->statusKaryawan;
                $karyawan->tglmasuk      = \Carbon\Carbon::parse($request->tglmasukKaryawan)->format('Y-m-d');
                $karyawan->atasan_pertama= $request->atasan_pertama;
                $karyawan->atasan_kedua  = $request->atasan_kedua;
                $karyawan->tipe_karyawan = $request->tipe_karyawan;
                // $karyawan->no_kk         = $request->no_kk;
                $karyawan->status_kerja  = $request->status_kerja;
                $karyawan->cuti_tahunan  = $request->cuti_tahunan;
                $karyawan->divisi        = $request->divisi;
                // $karyawan->no_rek        = $request->no_rek;
                // $karyawan->no_bpjs_kes   = $request->no_bpjs_ket;
                // $karyawan->no_npwp       = $request->no_npwp;
                // $karyawan->no_bpjs_ket   = $request->no_bpjs_ket;
                $karyawan->kontrak       = $request->kontrak;
                $karyawan->gaji          = $request->gaji;
                $karyawan->tglkeluar     = $request->tglkeluar;
                $karyawan->status_kerja  = 'Aktif';

                $request->session()->put('karyawan', $karyawan);
            }
            return redirect()->route('create.dakel');
        }else
        {
            if(empty($request->session()->get('karyawan')))
            {
                $karyawan               = new Karyawan;
                $karyawan->nip          = $request->nipKaryawan;
                $karyawan->nama         = $request->namaKaryawan;
                $karyawan->tgllahir     = \Carbon\Carbon::parse($request->tgllahirKaryawan)->format('Y-m-d');
                $karyawan->tempatlahir  = $request->tempatlahirKaryawan;
                $karyawan->jenis_kelamin= $request->jenis_kelaminKaryawan; 
                $karyawan->alamat       = $request->alamatKaryawan;
                $karyawan->no_hp        = $request->no_hpKaryawan;
                $karyawan->email        = $request->emailKaryawan;
                $karyawan->agama        = $request->agamaKaryawan;
                $karyawan->nik          = $request->nikKaryawan;
                $karyawan->no_kk        = $request->nokkKaryawan;
                $karyawan->no_npwp       = $request->nonpwpKaryawan;
                $karyawan->no_bpjs_ket   = $request->nobpjskerKaryawan;
                $karyawan->no_bpjs_kes   = $request->nobpjskesKaryawan;
                $karyawan->no_akdhk   = $request->noAkdhk;
                $karyawan->no_program_pensiun   = $request->noprogramPensiun;
                $karyawan->no_program_askes   = $request->noprogramAskes;
                $karyawan->no_rek   = $request->norekKaryawan;
                $karyawan->nama_bank   = $request->nama_bank;
                $karyawan->gol_darah    = $request->gol_darahKaryawan;
                $karyawan->jabatan      = $request->jabatanKaryawan;
                $karyawan->status_karyawan       = $request->statusKaryawan;
                $karyawan->tglmasuk     = \Carbon\Carbon::parse($request->tglmasukKaryawan)->format('Y-m-d');
                $karyawan->atasan_pertama= $request->atasan_pertama;
                $karyawan->atasan_kedua = $request->atasan_kedua;
                $karyawan->tipe_karyawan= $request->tipe_karyawan;
                // $karyawan->no_kk        = $request->no_kk;
                $karyawan->status_kerja = $request->status_kerja;
                $karyawan->cuti_tahunan = $request->cuti_tahunan;
                $karyawan->divisi       = $request->divisi;
                // $karyawan->no_rek       = $request->no_rek;
                // $karyawan->no_bpjs_kes  = $request->no_bpjs_ket;
                // $karyawan->no_npwp      = $request->no_npwp;
                // $karyawan->no_bpjs_ket  = $request->no_bpjs_ket;
                $karyawan->kontrak      = $request->kontrak;
                $karyawan->gaji         = $request->gaji;
                $karyawan->tglkeluar    = $request->tglkeluar;
                $karyawan->status_kerja = 'Aktif';

                $request->session()->put('karyawan', $karyawan);
            }else
            {
                $karyawan = $request->session()->get('karyawan');

                $karyawan->nip           = $request->nipKaryawan;
                $karyawan->nama          = $request->namaKaryawan;
                $karyawan->tgllahir      = \Carbon\Carbon::parse($request->tgllahirKaryawan)->format('Y-m-d');
                $karyawan->tempatlahir   = $request->tempatlahirKaryawan;
                $karyawan->jenis_kelamin = $request->jenis_kelaminKaryawan;
                $karyawan->alamat        = $request->alamatKaryawan;
                $karyawan->no_hp         = $request->no_hpKaryawan;
                $karyawan->email         = $request->emailKaryawan;
                $karyawan->agama         = $request->agamaKaryawan;
                $karyawan->nik           = $request->nikKaryawan;
                $karyawan->no_kk         = $request->nokkKaryawan;
                $karyawan->no_npwp       = $request->nonpwpKaryawan;
                $karyawan->no_bpjs_ket   = $request->nobpjskerKaryawan;
                $karyawan->no_bpjs_kes   = $request->nobpjskesKaryawan;
                $karyawan->no_akdhk   = $request->noAkdhk;
                $karyawan->no_program_pensiun   = $request->noprogramPensiun;
                $karyawan->no_program_askes   = $request->noprogramAskes;
                $karyawan->no_rek   = $request->norekKaryawan;
                $karyawan->nama_bank   = $request->nama_bank;   
                $karyawan->gol_darah     = $request->gol_darahKaryawan;
                $karyawan->jabatan       = $request->jabatanKaryawan;
                $karyawan->status_karyawan       = $request->statusKaryawan;
                $karyawan->tglmasuk      = \Carbon\Carbon::parse($request->tglmasukKaryawan)->format('Y-m-d');
                $karyawan->atasan_pertama= $request->atasan_pertama;
                $karyawan->atasan_kedua  = $request->atasan_kedua;
                $karyawan->tipe_karyawan = $request->tipe_karyawan;
                // $karyawan->no_kk         = $request->no_kk;
                $karyawan->status_kerja  = $request->status_kerja;
                $karyawan->cuti_tahunan  = $request->cuti_tahunan;
                // $karyawan->divisi        = $request->divisi;
                // $karyawan->no_rek        = $request->no_rek;
                // $karyawan->no_bpjs_kes   = $request->no_bpjs_ket;
                // $karyawan->no_npwp       = $request->no_npwp;
                // $karyawan->no_bpjs_ket   = $request->no_bpjs_ket;
                $karyawan->kontrak       = $request->kontrak;
                $karyawan->gaji          = $request->gaji;
                $karyawan->tglkeluar     = $request->tglkeluar;
                $karyawan->status_kerja  = 'Aktif';

                $request->session()->put('karyawan', $karyawan);
            }
            return redirect()->route('create.dakel');
        }
    }

    //data keluarga
    public function createdakel(Request $request)
    {
        $role = Auth::user()->role;
        if($role == 1) 
        {
            $karyawan    = $request->session()->get('karyawan');
            $datakeluarga = json_decode(session('datakeluarga', '[]'), true);
            // dd($datakeluarga);
            if(empty($datakeluarga)) 
            {
                $datakeluarga = [];
            }
            return view('admin.karyawan.createDakel',compact('karyawan','datakeluarga'));
        } else 
        {
            return redirect()->back();
        }
    } 

    public function storedk(Request $request)
    {
        $datakeluarga = json_decode($request->session()->get('datakeluarga', '[]'), true);
       
        $datakeluargaBaru = [
            'status_pernikahan' => $request->status_pernikahan,
            'jumlah_anak' => $request->jumlahAnak,
            'nama' => $request->namaPasangan,
            'jenis_kelamin' => $request->jenis_kelaminKeluarga,
            'tgllahir' => \Carbon\Carbon::parse($request->tgllahirPasangan)->format('Y-m-d'),
            'tempatlahir' => $request->tempatlahirKeluarga,
            // 'alamat' => $request->alamatPasangan,
            'pendidikan_terakhir' => $request->pendidikan_terakhirPasangan,
            'pekerjaan' => $request->pekerjaanPasangan,
            'hubungan' => $request->hubungankeluarga
        ];
        $datakeluarga[] = $datakeluargaBaru;    
        session()->put('datakeluarga', json_encode($datakeluarga));
        return redirect()->back();
    }

    //update data pada form create
    public function updatedk(Request $request)
    {
        $datakeluarga = json_decode($request->session()->get('datakeluarga', '[]'), true);

        $index = $request->nomor_index;
        // dd($datakeluarga,$index);
        $datakeluarga[$index]['status_pernikahan'] = $request->status_pernikahan;
        $datakeluarga[$index]['jumlah_anak'] = $request->jumlahAnak;
        $datakeluarga[$index]['nama'] = $request->namaPasangan;
        $datakeluarga[$index]['jenis_kelamin'] = $request->jenis_kelaminKeluarga;
        $datakeluarga[$index]['tgllahir'] = \Carbon\Carbon::parse($request->tgllahirPasangan)->format('Y-m-d');
        $datakeluarga[$index]['tempatlahir'] = $request->tempatlahirKeluarga;
        // $datakeluarga[$index]['alamat'] = $request->alamatPasangan;
        $datakeluarga[$index]['pendidikan_terakhir'] = $request->pendidikan_terakhirPasangan;
        $datakeluarga[$index]['pekerjaan'] = $request->pekerjaanPasangan;
        $datakeluarga[$index]['hubungan'] = $request->hubungankeluarga;

        session()->put('datakeluarga', json_encode($datakeluarga));
        return redirect()->back();
    }

    // //delete data saat form create pertama
    // public function deletedk(Request $request, $key)
    // {
    //     $datakeluarga = json_decode($request->session()->get('datakeluarga', '[]'), true);
    //     if(isset($datakeluarga[$key])) {
    //         unset($datakeluarga[$key]);
    //         session()->put('datakeluarga', json_encode($datakeluarga));
    //     }
    //     return redirect()->back();
    // }
    
    //data kontak darurat
    public function createkonrat(Request $request)
    {
        $role = Auth::user()->role;
        if($role == 1) 
        {
            $karyawan     = $request->session()->get('karyawan');
            $datakeluarga = $request->session()->get('datakeluarga');
            $kontakdarurat = json_decode(session('kontakdarurat', '[]'), true);
            if(empty($kontakdarurat)) 
            {    
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
            'nama'     => $request->namaKdarurat,
            'alamat'   => $request->alamatKdarurat,
            'no_hp'    => $request->no_hpKdarurat,
            'hubungan' => $request->hubunganKdarurat,
        ];

        $kontakdarurat[] = $kontakdaruratBaru;

        session()->put('kontakdarurat', json_encode($kontakdarurat));
        return redirect()->back();
    }

    //update data pada form create
    public function updatekd(Request $request)
    {
        $kontakdarurat = json_decode($request->session()->get('kontakdarurat', '[]'), true);
        $index = $request->nomor_index;

        $kontakdarurat[$index]['nama']    = $request->namaKdarurat;
        $kontakdarurat[$index]['alamat']  = $request->alamatKdarurat;
        $kontakdarurat[$index]['no_hp']   = $request->no_hpKdarurat;
        $kontakdarurat[$index]['hubungan'] = $request->hubunganKdarurat;

        session()->put('kontakdarurat', json_encode($kontakdarurat));
        return redirect()->back();
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
            $pendidikan = json_decode(session('pendidikan', '[]'), true);
            if(empty($pendidikan)) 
            {
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
        $pendidikan = json_decode($request->session()->get('pendidikan', '[]'), true);
        $pendidikanBaru = [
            'tingkat'              => $request->tingkat_pendidikan,
            'nama_sekolah'         => $request->nama_sekolah,
            'nama_lembaga'         => $request->namaLembaga,
            'kota_pformal'         => $request->kotaPendidikanFormal,
            'jurusan'              => $request->jurusan,
            'tahun_lulus_formal'   => $request->tahun_lulusFormal,
            'jenis_pendidikan'     => $request->jenis_pendidikan,
            'kota_pnonformal'      => $request->kotaPendidikanNonFormal,
            'tahun_lulus_nonformal'=> $request->tahunLulusNonFormal,
            'ijazah_formal'=> $request->noijazahPformal,
            'ijazah_nonformal'=> $request->noijazahPnonformal,
        ];
    
        $pendidikan[] = $pendidikanBaru;
    
        session()->put('pendidikan', json_encode($pendidikan));
        return redirect()->back();
    }

    public function updaterPendidikan(Request $request)
    {
        $pendidikan = json_decode($request->session()->get('pendidikan', '[]'), true);
        $index = $request->nomor_index;

        $pendidikan[$index]['tingkat']              = $request->tingkat_pendidikan;
        $pendidikan[$index]['nama_sekolah']         = $request->nama_sekolah;
        $pendidikan[$index]['nama_lembaga']         = $request->namaLembaga;
        $pendidikan[$index]['kota_pformal']         = $request->kotaPendidikanFormal;
        $pendidikan[$index]['jurusan']              = $request->jurusan;
        $pendidikan[$index]['tahun_lulus_formal']   = $request->tahun_lulusFormal;
        $pendidikan[$index]['jenis_pendidikan']     = $request->jenis_pendidikan;
        $pendidikan[$index]['kota_pnonformal']      = $request->kotaPendidikanNonFormal;
        $pendidikan[$index]['tahun_lulus_nonformal']= $request->tahunLulusNonFormal;
        $pendidikan[$index]['ijazah_formal']= $request->noijazahPformal;
        $pendidikan[$index]['ijazah_nonformal']= $request->noijazahPnonformal;

        session()->put('pendidikan', json_encode($pendidikan));
        return redirect()->back();
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
            $pekerjaan = json_decode(session('pekerjaan', '[]'), true);
            // dd($pekerjaan);
            if(empty($pekerjaan)) 
            {
                $pekerjaan = [];
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
        $pekerjaan = json_decode($request->session()->get('pekerjaan', '[]'), true);
        
        $pekerjaanBaru = [
            'nama_perusahaan' => $request->namaPerusahaan,
            'alamat'          => $request->alamatPerusahaan,
            'jenis_usaha'     => $request->jenisUsaha,
            'jabatan'         => $request->jabatanRpekerjaan,
            'level'           => $request->levelRpekerjaan,
            'nama_atasan'     => $request->namaAtasan,
            'nama_direktur'   => $request->namaDirektur,
            'lama_kerja'      => $request->lamaKerja,
            'alasan_berhenti' => $request->alasanBerhenti,
            'gaji'            => $request->gajiRpekerjaan,
        ];

        $pekerjaan[] = $pekerjaanBaru;
    
        session()->put('pekerjaan', json_encode($pekerjaan));
        return redirect()->back();
    }

    public function updaterPekerjaan(Request $request)
    {
        $pekerjaan = json_decode($request->session()->get('pekerjaan', '[]'), true);
        $index = $request->nomor_index;

        // dd($index);
        $pekerjaan[$index]['nama_perusahaan']= $request->namaPerusahaan;
        $pekerjaan[$index]['alamat']         = $request->alamatPerusahaan;
        $pekerjaan[$index]['jenis_usaha']    = $request->jenisUsaha;
        $pekerjaan[$index]['jabatan']        = $request->jabatanRpekerjaan;
        $pekerjaan[$index]['level']          = $request->levelRpekerjaan;
        $pekerjaan[$index]['nama_atasan']    = $request->namaAtasan;
        $pekerjaan[$index]['nama_direktur']  = $request->namaDirektur;
        $pekerjaan[$index]['lama_kerja']     = $request->lamaKerja;
        $pekerjaan[$index]['alasan_berhenti']= $request->alasanBerhenti;
        $pekerjaan[$index]['gaji']           = $request->gajiRpekerjaan;

        // dd($pekerjaan[$index]['gaji']);
        session()->put('pekerjaan', json_encode($pekerjaan));
        
        // $d= json_decode(session('pekerjaan', '[]'), true);
        // dd($d);

        return redirect()->back();
    }

    //data untuk oganisasi
    public function createorganisasi(Request $request)
    {
        $role = Auth::user()->role;
        if ($role == 1) {

            $karyawan     = $request->session()->get('karyawan');
            $datakeluarga = $request->session()->get('datakeluarga');
            $kontakdarurat = $request->session()->get('kontakdarurat');
            $pendidikan   = $request->session()->get('pendidikan');
            $pekerjaan   = $request->session()->get('pekerjaan');
            $organisasi = json_decode(session('organisasi', '[]'), true);
            // dd($pekerjaan);

            if (empty($organisasi)) {
                $organisasi = [];
            }

            return view('admin.karyawan.createOrganisasi', compact('organisasi','pekerjaan', 'karyawan', 'datakeluarga', 'kontakdarurat', 'pendidikan'));
        } else {
            return redirect()->back();
        }
    }

    //store ketika creates data
    public function storeorganisasi(Request $request)
    {
        $organisasi = json_decode($request->session()->get('organisasi', '[]'), true);

        $organisasiBaru = [
            'nama_organisasi' => $request->namaOrganisasi,
            'alamat'          => $request->alamatOrganisasi,
            'tgl_mulai'     => \Carbon\Carbon::parse($request->tglmulai)->format('Y-m-d'),
            'tgl_selesai'         => \Carbon\Carbon::parse($request->tglselesai)->format('Y-m-d'),
            'jabatan'     => $request->jabatanRorganisasi,
            'no_sk'   => $request->noSKorganisasi,
        ];

        $organisasi[] = $organisasiBaru;

        session()->put('organisasi', json_encode($organisasi));
        return redirect()->back();
    }

    public function updaterOrganisasi(Request $request)
    {
        $organisasi = json_decode($request->session()->get('organisasi', '[]'), true);
        $index = $request->nomor_index;

        // dd($index);
        $organisasi[$index]['nama_organisasi'] = $request->namaOrganisasi;
        $organisasi[$index]['alamat']         = $request->alamatOrganisasi;
        $organisasi[$index]['tgl_mulai']    = \Carbon\Carbon::parse($request->tglmulai)->format('Y-m-d');
        $organisasi[$index]['tgl_selesai']        = \Carbon\Carbon::parse($request->tglselesai)->format('Y-m-d');
        $organisasi[$index]['jabatan']          = $request->jabatanRorganisasi;
        $organisasi[$index]['no_sk']    = $request->noSKorganisasi;

        // dd($pekerjaan[$index]['gaji']);
        session()->put('organisasi', json_encode($organisasi));

        // $d= json_decode(session('pekerjaan', '[]'), true);
        // dd($d);

        return redirect()->back();
    }

    //data untuk prestasi
    public function createprestasi(Request $request)
    {
        $role = Auth::user()->role;
        if ($role == 1) {

            $karyawan     = $request->session()->get('karyawan');
            $datakeluarga = $request->session()->get('datakeluarga');
            $kontakdarurat = $request->session()->get('kontakdarurat');
            $pendidikan   = $request->session()->get('pendidikan');
            $pekerjaan   = $request->session()->get('pekerjaan');
            $organisasi   = $request->session()->get('organisasi');
            $prestasi = json_decode(session('prestasi', '[]'), true);
            // dd($pekerjaan);

            if (empty($prestasi)) {
                $prestasi = [];
            }

            return view('admin.karyawan.createPrestasi', compact('prestasi','organisasi', 'pekerjaan', 'karyawan', 'datakeluarga', 'kontakdarurat', 'pendidikan'));
        } else {
            return redirect()->back();
        }
    }

    //store ketika creates data
    public function storeprestasi(Request $request)
    {
        $prestasi = json_decode($request->session()->get('prestasi', '[]'), true);

        $prestasiBaru = [
            'keterangan'    => $request->keterangan,
            'nama_instansi' => $request->namaInstansi,
            'alamat'        => $request->alamatInstansi,
            'no_surat'      => $request->noSurat,
        ];

        $prestasi[] = $prestasiBaru;

        session()->put('prestasi', json_encode($prestasi));
        return redirect()->back();
    }

    public function updaterPrestasi(Request $request)
    {
        $prestasi = json_decode($request->session()->get('prestasi', '[]'), true);
        $index = $request->nomor_index;

        
        $prestasi[$index]['keterangan']       = $request->keterangan;
        $prestasi[$index]['nama_instansi']    = $request->namaInstansi;
        $prestasi[$index]['alamat']           = $request->alamatInstansi;
        $prestasi[$index]['no_surat']         = $request->noSurat;

        session()->put('prestasi', json_encode($prestasi));

        // $d= json_decode(session('pekerjaan', '[]'), true);
        // dd($d);

        return redirect()->back();
    }

    //data untuk Surat Keputusan
    public function createskeputusan(Request $request)
    {
        $role = Auth::user()->role;
        if ($role == 1) {

            $karyawan     = $request->session()->get('karyawan');
            $datakeluarga = $request->session()->get('datakeluarga');
            $kontakdarurat = $request->session()->get('kontakdarurat');
            $pendidikan   = $request->session()->get('pendidikan');
            $pekerjaan   = $request->session()->get('pekerjaan');
            $organisasi   = $request->session()->get('organisasi');
            $prestasi   = $request->session()->get('prestasi');
            $skeputusan = json_decode(session('skeputusan', '[]'), true);
            // dd($pekerjaan);

            if (empty($skeputusan)) {
                $skeputusan = [];
            }

            return view('admin.karyawan.createSkeputusan', compact('prestasi', 'organisasi', 'pekerjaan', 'karyawan', 'datakeluarga', 'kontakdarurat', 'pendidikan', 'skeputusan'));
        } else {
            return redirect()->back();
        }
    }


    public function previewData(Request $request)
    {
        $karyawan = $request->session()->get('karyawan');
        $atasan_pertama_nama = $karyawan->atasan_pertamaa->nama;
        $atasan_kedua_nama = $karyawan->atasan_kedua;
        if(!$atasan_kedua_nama){
            $atasan_kedua_nama = "-";
        }else
        {
            $atasan_kedua_nama = $karyawan->atasan_keduab->nama;
        }
        $datakeluarga = json_decode(session('datakeluarga', '[]'), true);
        $kontakdarurat = json_decode(session('kontakdarurat', '[]'), true);
        $pendidikan = json_decode(session('pendidikan', '[]'), true);
        $pekerjaan = json_decode(session('pekerjaan', '[]'), true);
        $organisasi = json_decode(session('organisasi', '[]'), true);
        $prestasi    = json_decode(session('prestasi', '[]'), true);

        return view('admin.karyawan.preview',compact('karyawan','datakeluarga','kontakdarurat','pendidikan','pekerjaan','atasan_pertama_nama','atasan_kedua_nama', 'organisasi', 'prestasi'));
    }

    public function storetoDatabase(Request $request)
    {
         //meyimpan data ke database
         $karyawan= $request->session()->get('karyawan');
         $karyawan->save();
         $idKaryawan = $karyawan->id;  
 
        $datakeluarga = json_decode($request->session()->get('datakeluarga', []), true);
        $datakeluargaMerged = array_map(function($item) use ($idKaryawan) {
            $item['id_pegawai'] = $idKaryawan;
            return $item;
        }, $datakeluarga);
        $datakeluargaModel = Keluarga::insert($datakeluargaMerged);
        
        $kontakdarurat=json_decode($request->session()->get('kontakdarurat',[]), true);
        $kontakdaruratMerge =  array_map(function($item) use ($idKaryawan) {
            $item['id_pegawai'] = $idKaryawan;
            return $item;
        }, $kontakdarurat);
        $kontakdarurats = Kdarurat::insert($kontakdaruratMerge);
 
        $pendidikan= json_decode($request->session()->get('pendidikan',[]), true);
        $pendidikanMerge =  array_map(function($item) use ($idKaryawan) {
            $item['id_pegawai'] = $idKaryawan;
            return $item;
        }, $pendidikan);
        $pendidikans= Rpendidikan::insert($pendidikanMerge);
 
        $pekerjaan= json_decode($request->session()->get('pekerjaan', []), true);
        $pekerjaanMerge = array_map(function($item) use ($idKaryawan) {
            $item['id_pegawai'] = $idKaryawan;
            return $item;
        }, $pekerjaan);
        $pekerjaans= Rpekerjaan::insert($pekerjaanMerge);

        $organisasi = json_decode($request->session()->get('organisasi', []), true);
        $organisasiMerge = array_map(function ($item) use ($idKaryawan) {
            $item['id_pegawai'] = $idKaryawan;
            return $item;
        }, $organisasi);
        $organisasis = Rorganisasi::insert($organisasiMerge);

        $prestasi = json_decode($request->session()->get('prestasi', []), true);
        $prestasiMerge = array_map(function ($item) use ($idKaryawan) {
            $item['id_pegawai'] = $idKaryawan;
            return $item;
        }, $prestasi);
        $prestasis = Rprestasi::insert($prestasiMerge);
         
         //hapus data pada session
        $request->session()->forget('karyawan');
        $request->session()->forget('datakeluarga');
        $request->session()->forget('kontakdarurat');
        $request->session()->forget('pendidikan');
        $request->session()->forget('pekerjaan');
        $request->session()->forget('organisasi');
        $request->session()->forget('prestasi');

         
        return redirect('/karyawan');
    }

    //===================================================================================

    //store data keluarga setelah show
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
                'ijazah_formal' => $request->post('noijazahPformal'),

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

                
                'nama_lembaga' => $request->post('namaLembaga'),
                'jenis_pendidikan' => $request->post('jenis_pendidikan'),
                'kota_pnonformal' => $request->post('kotaPendidikanNonFormal'),
                'tahun_lulus_nonformal' => $request->post('tahunLulusNonFormal'),
                'ijazah_nonformal' => $request->post('noijazahPnonformal'),
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
            'level' => $request->post('levelRpekerjaan'),
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

    //store pekerjaan ketika show data
    public function storesorganisasi(Request $request, $id)
    {
        $idk = Karyawan::findorFail($id);
        $r_organisasi = array(
            'id_pegawai' => $idk->id,
            'nama_organisasi' => $request->post('namaOrganisasi'),
            'alamat' => $request->post('alamatOrganisasi'),
            'tgl_mulai' => $request->post('tglmulai'),
            'tgl_selesai' => $request->post('tglselesai'),
            'jabatan' => $request->post('jabatanRorganisasi'),
            'no_sk' => $request->post('noSKorganisasi'),
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime(),
        );

        Rorganisasi::insert($r_organisasi);
        return redirect()->back()->withInput();
    }

    public function storesprestasi(Request $request, $id)
    {
        $idk = Karyawan::findorFail($id);
        $r_prestasi = array(
            'id_pegawai' => $idk->id,
            'keterangan' => $request->post('keterangan'),
            'nama_instansi' => $request->post('namaInstansi'),
            'alamat' => $request->post('alamatInstansi'),
            'no_surat' => $request->post('noSurat'),
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime(),
        );

        Rprestasi::insert($r_prestasi);
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
            $pegawai->no_kk         = $request->nokkKaryawan;
            $pegawai->no_npwp       = $request->nonpwpKaryawan;
            $pegawai->no_bpjs_ket   = $request->nobpjskerKaryawan;
            $pegawai->no_bpjs_kes   = $request->nobpjskesKaryawan;
            $pegawai->no_akdhk   = $request->noAkdhk;
            $pegawai->no_program_pensiun   = $request->noprogramPensiun;
            $pegawai->no_program_askes   = $request->noprogramAskes;
            $pegawai->no_rek   = $request->norekKaryawan;
            $pegawai->nama_bank   = $request->nama_bank;
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

            Keluarga::where('id_pegawai','=',$id)->update([
                'status_pernikahan' =>$request->status_pernikahan,
            ]);
            return redirect()->back();
        }
        else
        {
            $pegawai = Karyawan::find($id);
            $pegawai->nama = $request->namaKaryawan;
            $pegawai->nik = $request->nikKaryawan;
            $pegawai->no_kk         = $request->nokkKaryawan;
            $pegawai->no_npwp       = $request->nonpwpKaryawan;
            $pegawai->no_bpjs_ket   = $request->nobpjskerKaryawan;
            $pegawai->no_bpjs_kes   = $request->nobpjskesKaryawan;
            $pegawai->no_akdhk   = $request->noAkdhk;
            $pegawai->no_program_pensiun   = $request->noprogramPensiun;
            $pegawai->no_program_askes   = $request->noprogramAskes;
            $pegawai->no_rek   = $request->norekKaryawan;
            $pegawai->nama_bank   = $request->nama_bank;
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

            Keluarga::where('id_pegawai','=',$id)->update([
                'status_pernikahan' =>$request->status_pernikahan,
            ]);
           
            return redirect()->back();
           
        }

    }

    //update data keluarga
    public function updateKeluarga(Request $request,$id)
    {
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
                'ijazah_formal' => $request->noijazahPformal,
                'updated_at' => \Carbon\Carbon::now()->format('Y-m-d'),
            ]);
        }else
        {
            $data = Rpendidikan::where('id',$idp->id)->update([
                'jenis_pendidikan' => $request->jenis_pendidikan,
                'nama_lembaga' => $request->namaLembaga,
                'kota_pnonformal' => $request->kotaPendidikanNonFormal,
                'tahun_lulus_nonformal' => $request->tahunLulusNonFormal,
                'ijazah_nonformal' => $request->noijazahPnonformal,
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
            'level' => $request->post('levelRpekerjaan'),
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

    //update data Organisasi
    public function updateOrganisasi(Request $request, $id)
    {
        $r_organisasi = array(
            'nama_organisasi' => $request->post('namaOrganisasi'),
            'alamat' => $request->post('alamatOrganisasi'),
            'tgl_mulai' => $request->post('tglmulai'),
            'tgl_selesai' => $request->post('tglselesai'),
            'jabatan' => $request->post('jabatanRorganisasi'),
            'no_sk' => $request->post('noSKorganisasi'),
            'updated_at' => new \DateTime(),
        );

        $idOrganisasi = $request->post('id_organisasi');
        Rorganisasi::where('id', $idOrganisasi)->update($r_organisasi);
        return redirect()->back();
    }

    //update data pekerjaan
    public function updatePrestasi(Request $request, $id)
    {
        $r_prestasi = array(

            'keterangan' => $request->post('keterangan'),
            'nama_instansi' => $request->post('namaInstansi'),
            'alamat' => $request->post('alamatInstansi'),
            'no_surat' => $request->post('noSurat'),
            'updated_at' => new \DateTime(),

        );

        $idOrganisasi = $request->post('id_organisasi');
        Rprestasi::where('id', $idOrganisasi)->update($r_prestasi);
        return redirect()->back();
    }
    
}
