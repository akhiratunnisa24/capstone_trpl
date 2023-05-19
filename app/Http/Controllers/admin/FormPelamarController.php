<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lowongan;
use App\Models\Rekruitmen;
use App\Models\Karyawan;
use App\Models\Kdarurat;
use App\Models\Keluarga;
use App\Models\Departemen;
use App\Models\Rpekerjaan;
use App\Models\Rpendidikan;
use App\Models\Rorganisasi;
use App\Models\Rprestasi;
// use Illuminate\Support\Facades\Auth;
use App\Mail\RekruitmenApplyNotification;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;




class FormPelamarController extends Controller
{


    public function getPersyaratan(Request $request)
    {
        try {
            $getEmail = Lowongan::select('persyaratan')
            ->where('id', '=', $request->id_pegawai)->first();

            if (!$getEmail) {
                throw new \Exception('Data not found');
            }
            return response()->json($getEmail, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function create(Request $request)

    {
        // $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        // $posisi = Lowongan::all()->where('status', '=', 'Aktif');
        $posisi = Lowongan::all()->where('status', '=', 'Aktif')->where('tgl_selesai','>',Carbon::now());
        $openRekruitmen = Lowongan::where('status', 'Aktif')->get();

        $pelamar = $request->session()->get('pelamar');
        if (!$pelamar) {
            $pelamar = new Rekruitmen;
        }

        if ($openRekruitmen->count() > 0) {
            return view('admin.rekruitmen.formPelamar', compact('posisi', 'pelamar'))->with('success', 'Data berhasil disimpan.');
        }

        return view('admin.rekruitmen.viewTidakAdaLowongan');
    }

    // Create Data Identitas Pelamar
    public function store(Request $request)
    {
        $request->validate([
            'pdfPelamar' => 'required|mimes:pdf'
        ]);
        $posisi = Rekruitmen::with('lowongan')
            ->get();
        // dd($posisi);


        // Simpan file ke folder public/pdf
        $filePdf = $request->file('pdfPelamar');
        $namaFile = '' . time() . $filePdf->getClientOriginalName();
        $tujuan_upload = 'pdf';
        $filePdf->move($tujuan_upload, $namaFile);

        if (empty($request->session()->get('pelamar'))) {

            $pelamar = new Rekruitmen();
            $pelamar->id_lowongan = $request->posisiPelamar;
            $pelamar->nik = $request->nikPelamar;
            $pelamar->nama = $request->namaPelamar;
            $pelamar->tgllahir = Carbon::parse($request->tgllahirPelamar)->format('Y-m-d');
            $pelamar->tempatlahir = $request->tempatlahirPelamar;
            $pelamar->jenis_kelamin = $request->jenis_kelaminPelamar;
            $pelamar->gol_darah = $request->gol_darahPelamar;
            $pelamar->alamat = $request->alamatPelamar;
            $pelamar->status_pernikahan = $request->status_pernikahan;
            $pelamar->jumlah_anak = $request->jumlahAnak;
            $pelamar->no_hp = $request->no_hpPelamar;
            $pelamar->email = $request->emailPelamar;
            $pelamar->agama = $request->agamaPelamar;
            $pelamar->no_kk = $request->no_kkPelamar;
            $pelamar->no_npwp = $request->nonpwpPelamar;
            $pelamar->no_bpjs_ket = $request->nobpjsketPelamar;
            $pelamar->no_bpjs_kes = $request->nobpjskesPelamar;
            $pelamar->no_akdhk = $request->noAkdhk;
            $pelamar->no_program_pensiun = $request->noprogramPensiun;
            $pelamar->no_program_askes = $request->noprogramAskes;
            $pelamar->nama_bank = $request->nama_bank;
            $pelamar->no_rek = $request->norekPelamar;
            $pelamar->gaji = $request->gajiPelamar;
            $pelamar->cv = $namaFile;
            $pelamar->status_lamaran = '1';
            $pelamar->tanggal_tahapan = Carbon::now();

            $request->session()->put('pelamar', $pelamar);
        } else {
            $pelamar = $request->session()->get('pelamar');

            $pelamar->id_lowongan = $request->posisiPelamar;
            $pelamar->nik = $request->nikPelamar;
            $pelamar->nama = $request->namaPelamar;
            $pelamar->tgllahir = Carbon::parse($request->tgllahirPelamar)->format('Y-m-d');
            $pelamar->tempatlahir = $request->tempatlahirPelamar;
            $pelamar->jenis_kelamin = $request->jenis_kelaminPelamar;
            $pelamar->gol_darah = $request->gol_darahPelamar;
            $pelamar->alamat = $request->alamatPelamar;
            $pelamar->status_pernikahan = $request->status_pernikahan;
            $pelamar->jumlah_anak = $request->jumlahAnak;
            $pelamar->no_hp = $request->no_hpPelamar;
            $pelamar->email = $request->emailPelamar;
            $pelamar->agama = $request->agamaPelamar;
            $pelamar->no_kk = $request->no_kkPelamar;
            $pelamar->no_npwp = $request->nonpwpPelamar;
            $pelamar->no_bpjs_ket = $request->nobpjsketPelamar;
            $pelamar->no_bpjs_kes = $request->nobpjskesPelamar;
            $pelamar->no_akdhk = $request->noAkdhk;
            $pelamar->no_program_pensiun = $request->noprogramPensiun;
            $pelamar->no_program_askes = $request->noprogramAskes;
            $pelamar->nama_bank = $request->nama_bank;
            $pelamar->no_rek = $request->norekPelamar;
            $pelamar->gaji = $request->gajiPelamar;
            $pelamar->cv = $namaFile;
            $pelamar->status_lamaran = '1';
            $pelamar->tanggal_tahapan = Carbon::now();

            $request->session()->put('pelamar', $pelamar);
        }
        return redirect()->route('createKeluarga');
    }

    // Create Data Keluarga
    public function createKeluarga(Request $request)
    {
            $pelamar    = $request->session()->get('pelamar');
            $datakeluarga = json_decode(session('datakeluarga', '[]'), true);
            if (empty($datakeluarga)) {
                $datakeluarga = [];
            }
            return view('admin.rekruitmen.createDakel', compact('pelamar', 'datakeluarga'));
        
    }

    public function storedk(Request $request)
    {
        $datakeluarga = json_decode($request->session()->get('datakeluarga', '[]'), true);

        $datakeluargaBaru = [
            'hubungan' => $request->hubungankeluarga,
            'nama' => $request->namaPasangan,
            'jenis_kelamin' => $request->jenis_kelaminKeluarga,
            'tgllahir' => Carbon::parse($request->tgllahirPasangan)->format('Y-m-d'),
            'tempatlahir' => $request->tempatlahirKeluarga,
            'pendidikan_terakhir' => $request->pendidikan_terakhirPasangan,
            'pekerjaan' => $request->pekerjaanPasangan,
        ];
        $datakeluarga[] = $datakeluargaBaru;
        session()->put('datakeluarga', json_encode($datakeluarga));
        return redirect()->back();
        // return view('admin.rekruitmen.createDakel');
         
    }

    //update data pada form Pelamar
    public function updatedk(Request $request)
    {
        $datakeluarga = json_decode($request->session()->get('datakeluarga', '[]'), true);

        $index = $request->nomor_index;
        // dd($datakeluarga,$index);
        $datakeluarga[$index]['hubungan'] = $request->hubungankeluarga;
        $datakeluarga[$index]['nama'] = $request->namaPasangan;
        $datakeluarga[$index]['jenis_kelamin'] = $request->jenis_kelaminKeluarga;
        $datakeluarga[$index]['tgllahir'] = Carbon::parse($request->tgllahirPasangan)->format('Y-m-d');
        $datakeluarga[$index]['tempatlahir'] = $request->tempatlahirKeluarga;
        // $datakeluarga[$index]['alamat'] = $request->alamatPasangan;
        $datakeluarga[$index]['pendidikan_terakhir'] = $request->pendidikan_terakhirPasangan;
        $datakeluarga[$index]['pekerjaan'] = $request->pekerjaanPasangan;

        session()->put('datakeluarga', json_encode($datakeluarga));
        return redirect()->back();
    }

    //data kontak darurat
    public function createkonrat(Request $request)
    {

            $pelamar     = $request->session()->get('pelamar');
            $datakeluarga = $request->session()->get('datakeluarga');
            $kontakdarurat = json_decode(session('kontakdarurat', '[]'), true);
            if (empty($kontakdarurat)) {
                $kontakdarurat = [];
            }
            return view('admin.rekruitmen.createKonrat', compact('pelamar', 'datakeluarga', 'kontakdarurat'));
        
    }

    public function storekd(Request $request)
    {
        $kontakdarurat = json_decode($request->session()->get('kontakdarurat', '[]'), true);
        $kontakdaruratBaru = [
            'nama'     => $request->namaKdarurat,
            'hubungan' => $request->hubunganKdarurat,
            'alamat'   => $request->alamatKdarurat,
            'no_hp'    => $request->no_hpKdarurat,
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
            $pelamar     = $request->session()->get('pelamar');
            $datakeluarga = $request->session()->get('datakeluarga');
            $kontakdarurat = $request->session()->get('kontakdarurat');
            $pendidikan = json_decode(session('pendidikan', '[]'), true);
            if (empty($pendidikan)) {
                $pendidikan = [];
            }
            return view('admin.rekruitmen.createPendidikan', compact('pelamar', 'datakeluarga', 'kontakdarurat', 'pendidikan'));
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
            'tahun_lulus_nonformal'=> $request->tahunLulusNonFormal,
            'jenis_pendidikan'     => $request->jenis_pendidikan,
            'kota_pnonformal'      => $request->kotaPendidikanNonFormal,
            'ijazah_formal' => $request->noijazahPformal,
            'ijazah_nonformal' => $request->noijazahPnonformal,
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
        $pendidikan[$index]['tahun_lulus_nonformal'] = $request->tahunLulusNonFormal;
        $pendidikan[$index]['ijazah_formal'] = $request->noijazahPformal;
        $pendidikan[$index]['ijazah_nonformal'] = $request->noijazahPnonformal;

        session()->put('pendidikan', json_encode($pendidikan));
        return redirect()->back();
    }

    //data untuk pekerjaan
    public function createpekerjaan(Request $request)
    {
            $pelamar     = $request->session()->get('pelamar');
            $datakeluarga = $request->session()->get('datakeluarga');
            $kontakdarurat = $request->session()->get('kontakdarurat');
            $pendidikan   = $request->session()->get('pendidikan');
            $pekerjaan = json_decode(session('pekerjaan', '[]'), true);
            // dd($pekerjaan);
            if (empty($pekerjaan)) {
                $pekerjaan = [];
            }
            return view('admin.rekruitmen.createPekerjaan', compact('pekerjaan', 'pelamar', 'datakeluarga', 'kontakdarurat', 'pendidikan'));
    }

    //store ketika creates data
    public function storepekerjaan(Request $request)
    {
        $pekerjaan = json_decode($request->session()->get('pekerjaan', '[]'), true);

        $pekerjaanBaru = [
            'nama_perusahaan' => $request->namaPerusahaan,
            'alamat'          => $request->alamatPerusahaan,
            // 'jenis_usaha'     => $request->jenisUsaha,
            'tgl_mulai'       => Carbon::parse($request->tglmulai)->format('Y-m-d'),
            'tgl_selesai'     => Carbon::parse($request->tglselesai)->format('Y-m-d'),
            'jabatan'         => $request->jabatanRpekerjaan,
            'level'           => $request->levelRpekerjaan,
            // 'nama_atasan'     => $request->namaAtasan,
            // 'nama_direktur'   => $request->namaDirektur,
            'gaji'            => $request->gajiRpekerjaan,
            'alasan_berhenti' => $request->alasanBerhenti,
        ];

        $pekerjaan[] = $pekerjaanBaru;

        session()->put('pekerjaan', json_encode($pekerjaan));
        return redirect()->back();
    }

    public function updaterPekerjaan(Request $request)
    {
        $pekerjaan = json_decode($request->session()->get('pekerjaan', '[]'), true);
        $index = $request->nomor_index;

        $pekerjaan[$index]['nama_perusahaan'] = $request->namaPerusahaan;
        $pekerjaan[$index]['alamat']         = $request->alamatPerusahaan;
        $pekerjaan[$index]['jenis_usaha']    = $request->jenisUsaha;
        $pekerjaan[$index]['jabatan']        = $request->jabatanRpekerjaan;
        $pekerjaan[$index]['level']          = $request->levelRpekerjaan;
        $pekerjaan[$index]['nama_atasan']    = $request->namaAtasan;
        $pekerjaan[$index]['nama_direktur']  = $request->namaDirektur;
        $pekerjaan[$index]['tgl_mulai'] = Carbon::parse($request->tglmulai)->format('Y-m-d');
        $pekerjaan[$index]['tgl_selesai'] = Carbon::parse($request->tglselesai)->format('Y-m-d');
        $pekerjaan[$index]['alasan_berhenti'] = $request->alasanBerhenti;
        $pekerjaan[$index]['gaji']           = $request->gajiRpekerjaan;
        
        session()->put('pekerjaan', json_encode($pekerjaan));
        return redirect()->back();
    }

    //data untuk oganisasi
    public function createorganisasi(Request $request)
    {

            $pelamar     = $request->session()->get('pelamar');
            $datakeluarga = $request->session()->get('datakeluarga');
            $kontakdarurat = $request->session()->get('kontakdarurat');
            $pendidikan   = $request->session()->get('pendidikan');
            $pekerjaan   = $request->session()->get('pekerjaan');
            $organisasi = json_decode(session('organisasi', '[]'), true);
            // dd($pekerjaan);

            if (empty($organisasi)) {
                $organisasi = [];
            }

            return view('admin.rekruitmen.createOrganisasi', compact('organisasi', 'pekerjaan', 'pelamar', 'datakeluarga', 'kontakdarurat', 'pendidikan'));
    }

    //store ketika creates data
    public function storeorganisasi(Request $request)
    {
        $organisasi = json_decode($request->session()->get('organisasi', '[]'), true);

        $organisasiBaru = [
            'nama_organisasi' => $request->namaOrganisasi,
            'alamat'          => $request->alamatOrganisasi,
            'tgl_mulai'     => Carbon::parse($request->tglmulai)->format('Y-m-d'),
            'tgl_selesai'   => Carbon::parse($request->tglselesai)->format('Y-m-d'),
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
        $organisasi[$index]['tgl_mulai']    = Carbon::parse($request->tglmulai)->format('Y-m-d');
        $organisasi[$index]['tgl_selesai']        = Carbon::parse($request->tglselesai)->format('Y-m-d');
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
            $pelamar     = $request->session()->get('pelamar');
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

            return view('admin.rekruitmen.createPrestasi', compact('prestasi', 'organisasi', 'pekerjaan', 'pelamar', 'datakeluarga', 'kontakdarurat', 'pendidikan'));
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
        return redirect()->back();
    }

    public function previewData(Request $request)
    {
        $pelamar = $request->session()->get('pelamar');

        $datakeluarga = json_decode(session('datakeluarga', '[]'), true);
        $kontakdarurat = json_decode(session('kontakdarurat', '[]'), true);
        $pendidikan = json_decode(session('pendidikan', '[]'), true);
        $pekerjaan = json_decode(session('pekerjaan', '[]'), true);
        $organisasi = json_decode(session('organisasi', '[]'), true);
        $prestasi    = json_decode(session('prestasi', '[]'), true);


        return view('admin.rekruitmen.preview', compact('pelamar', 'datakeluarga', 'kontakdarurat', 'pendidikan', 'pekerjaan', 'organisasi', 'prestasi'));
    }

    public function storetoDatabase(Request $request)
    {
        //meyimpan data ke database
        $pelamar = $request->session()->get('pelamar');
        $pelamar->save();
        $idKaryawan = $pelamar->id;

        // $datakeluarga = json_decode($request->session()->get('datakeluarga', []), true);

        if ($request->session()->has('datakeluarga')) {
            $datakeluarga = json_decode($request->session()->get('datakeluarga'), true);
        } else {
            $datakeluarga = [];
        }

        $datakeluargaMerge = array_map(function ($item) use ($idKaryawan) {
            $item['id_pelamar'] = $idKaryawan;
            return $item;
        }, $datakeluarga);
        $datakeluargas = Keluarga::insert($datakeluargaMerge);

        // $kontakdarurat = json_decode($request->session()->get('kontakdarurat', []), true);

        if ($request->session()->has('kontakdarurat')) {
            $kontakdarurat = json_decode($request->session()->get('kontakdarurat'), true);
        } else {
            $kontakdarurat = [];
        }

        $kontakdaruratMerge =  array_map(function ($item) use ($idKaryawan) {
            $item['id_pelamar'] = $idKaryawan;
            return $item;
        }, $kontakdarurat);
        $kontakdarurats = Kdarurat::insert($kontakdaruratMerge);

        // $pendidikan = json_decode($request->session()->get('pendidikan', []), true);
        if ($request->session()->has('pendidikan')) {
            $pendidikan = json_decode($request->session()->get('pendidikan'), true);
        } else {
            $pendidikan = [];
        }
        $pendidikanMerge =  array_map(function ($item) use ($idKaryawan) {
            $item['id_pelamar'] = $idKaryawan;
            return $item;
        }, $pendidikan);
        $pendidikans = Rpendidikan::insert($pendidikanMerge);

        // $pekerjaan = json_decode($request->session()->get('pekerjaan', []), true);
        if ($request->session()->has('pekerjaan')) {
            $pekerjaan = json_decode($request->session()->get('pekerjaan'), true);
        } else {
            $pekerjaan = [];
        }
        $pekerjaanMerge = array_map(function ($item) use ($idKaryawan) {
            $item['id_pelamar'] = $idKaryawan;
            return $item;
        }, $pekerjaan);
        $pekerjaans = Rpekerjaan::insert($pekerjaanMerge);

        // $organisasi = json_decode($request->session()->get('organisasi', []), true);
        if ($request->session()->has('organisasi')) {
            $organisasi = json_decode($request->session()->get('organisasi'), true);
        } else {
            $organisasi = [];
        }
        $organisasiMerge = array_map(function ($item) use ($idKaryawan) {
            $item['id_pelamar'] = $idKaryawan;
            return $item;
        }, $organisasi);
        $organisasis = Rorganisasi::insert($organisasiMerge);

        // $prestasi = json_decode($request->session()->get('prestasi', []), true);
        if ($request->session()->has('prestasi')) {
            $prestasi = json_decode($request->session()->get('prestasi'), true);
        } else {
            $prestasi = [];
        }
        $prestasiMerge = array_map(function ($item) use ($idKaryawan) {
            $item['id_pelamar'] = $idKaryawan;
            return $item;
        }, $prestasi);
        $prestasis = Rprestasi::insert($prestasiMerge);

        //hapus data pada session
        $request->session()->forget('pelamar');
        $request->session()->forget('datakeluarga');
        $request->session()->forget('kontakdarurat');
        $request->session()->forget('pendidikan');
        $request->session()->forget('pekerjaan');
        $request->session()->forget('organisasi');
        $request->session()->forget('prestasi');

        $data = Rekruitmen::findOrFail($idKaryawan);
        // Email HRD
        $tujuan = 'hrd@gmail.com';
        $tujuan2 = 'hrd2@gmail.com';
        $email = new RekruitmenApplyNotification($data);
        Mail::to($tujuan)->send($email);
        Mail::to($tujuan2)->send($email);


        // return redirect('/karyawan');
        return view('admin.rekruitmen.formSelesaiPelamar');

    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'pdfPelamar' => 'required|mimes:pdf'
    //     ]);
    //     $posisi = Rekruitmen::with('lowongan')
    //     ->get();
    //     // dd($posisi);


    //     // Simpan file ke folder public/pdf
    //     $filePdf = $request->file('pdfPelamar');
    //     $namaFile = '' . time() . $filePdf->getClientOriginalName();
    //     $tujuan_upload = 'pdf';
    //     $filePdf->move($tujuan_upload, $namaFile);

    //     $user = new Rekruitmen();
    //     $user->id_lowongan = $request->posisiPelamar;
    //     $user->nik = $request->nikPelamar;
    //     $user->nama = $request->namaPelamar;
    //     $user->tgllahir = $request->tgllahirPelamar;
    //     $user->email = $request->emailPelamar;
    //     $user->agama = $request->agamaPelamar;
    //     $user->jenis_kelamin = $request->jenis_kelaminPelamar;
    //     $user->alamat = $request->alamatPelamar;
    //     $user->no_hp = $request->no_hpPelamar;
    //     $user->no_kk = $request->no_kkPelamar;
    //     $user->gaji = $request->gajiPelamar;
    //     $user->status_lamaran = '1';
    //     $user->tanggal_tahapan = Carbon::now();
    //     $user->cv = $namaFile;



    //     $user->save();

    //     return view('admin.rekruitmen.formSelesaiPelamar');
    // }

    public function create_karyawan_baru(Request $request)

    {
        $posisi = Lowongan::all()->where('status', '=', 'Aktif');
        $openRekruitmen = Lowongan::where('status', 'Aktif')->get();

        // $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $departemen     = Departemen::all();
        $atasan_pertama = Karyawan::whereIn('jabatan', ['Asistant Manager', 'Manager', 'Direksi'])->get();
        $atasan_kedua   = Karyawan::whereIn('jabatan', ['Manager', 'Direksi'])->get();
        $user = Karyawan::max('id');
        $datakeluarga = Keluarga::where('id_pegawai', $user)->get();
        $kontakdarurat = Kdarurat::where('id_pegawai', $user)->get();
        $pformal = Rpendidikan::where('id_pegawai', $user)->where('jenis_pendidikan', '=', null)->get();
        $nonformal = Rpendidikan::where('id_pegawai', $user)->where('jenis_pendidikan', '!=', null)->get();
        $pekerjaan = Rpekerjaan::where('id_pegawai', $user)->get();
        $output = [
            // 'row' => $row,
            'departemen' => $departemen,
            'atasan_pertama' => $atasan_pertama,
            'atasan_kedua' => $atasan_kedua,
            'user' => $user,
            'datakeluarga' => $datakeluarga,
            'kontakdarurat' => $kontakdarurat,
            'pformal' =>  $pformal,
            'nonformal' => $nonformal,
            'pekerjaan' => $pekerjaan,
        ];

        return view('admin.rekruitmen.tambahKaryawanBaru', $output);
    }
}
