<?php

namespace App\Http\Controllers\karyawan;


use Carbon\Carbon;
use App\Models\Cuti;
use App\Models\User;
use App\Models\Users;
use App\Models\Absensi;
use App\Models\Karyawan;
use App\Models\Kdarurat;
use App\Models\Keluarga;
use App\Models\Rpekerjaan;
use App\Models\Alokasicuti;
use App\Models\Rpendidikan;
use App\Models\Departemen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\KaryawanExport;
use App\Imports\karyawanImport;
use App\Events\AbsenKaryawanEvent;


class karyawanController extends Controller
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

    public function index()
    {
        // event(new AbsenKaryawanEvent());
        
        $role = Auth::user()->role;
        
        if ($role == 1) {

        $karyawan = karyawan::all()->sortByDesc('created_at');
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();

        //ambil id_karyawan yang belum punya akun
        $user = DB::table('users')->pluck('id_pegawai');
        $akun = DB::table('karyawan')->whereNotIn("id", $user)->get();

        $output = [
            'row' => $row
        ];
        return view('admin.karyawan.index', compact('karyawan', 'row', 'akun'));

        } else {

            return redirect()->back(); 
        }
    }

    // public function getEmail(Request $request)
    // {
    //     try {
    //         $getEmail = Karyawan::select('email')
    //         ->where('id','=',$request->id_karyawan)->first();

    //         // dd($request->id_karyawan,$getTglmasuk);
    //         if(!$getEmail) {
    //             throw new \Exception('Data not found');
    //         }
    //         return response()->json($getEmail,200);
            
    //     } catch (\Exception $e){
    //         return response()->json([
    //             'message' =>$e->getMessage()
    //         ], 500);
    //     }
    // }

    public function getEmail(Request $request)
    {
        try {
            $getEmail = Karyawan::select('email')
            ->where('id','=',$request->id_pegawai)->first();

            if(!$getEmail) {
                throw new \Exception('Data not found');
            }
            return response()->json($getEmail,200);
            
        } catch (\Exception $e){
            return response()->json([
                'message' =>$e->getMessage()
            ], 500);
        }
    }

    

    public function karyawanDashboard()
    {
        $role = Auth::user()->role;
        
        if ($role == 2 or 3 ) {

        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();

        $absenKaryawan = Absensi::where('id_karyawan', Auth::user()->id_pegawai)
            ->whereDay('created_at', '=', Carbon::now(),)->count('jam_masuk');

        // Absen Terlambat untuk hari ini
        $absenTerlambatkaryawan = Absensi::where('id_karyawan', Auth::user()->id_pegawai)
            ->whereYear('tanggal','=', Carbon::now()->year)
            ->whereMonth('tanggal', '=', Carbon::now()->month)
            ->whereTime('jam_masuk', '>', '08:00:00')
            ->count();
        
        //absen masuk bulan lalu    
        $absenBulanlalu  = Absensi::where('id_karyawan', Auth::user()->id_pegawai)
            ->whereYear('tanggal','=', Carbon::now()->subMonth()->year)
            ->whereMonth('tanggal','=', Carbon::now()->subMonth()->month)
            ->count('jam_masuk');

        //absen terlambat bulan lalu
        $absenTerlambatbulanlalu = Absensi::where('id_karyawan', Auth::user()->id_pegawai)
            ->whereYear('tanggal','=', Carbon::now()->subMonth()->year)
            ->whereMonth('tanggal','=', Carbon::now()->subMonth()->month)
            ->count('terlambat');

        $absenTidakmasuk = Absensi::where('id_karyawan', Auth::user()->id_pegawai)
            ->whereDay('created_at', '=', Carbon::now(),)->count('jam_masuk');

        $alokasicuti = Alokasicuti::where('id_karyawan', Auth::user()->id_pegawai)->get();

        //sisa cuti
        // $sisacuti = DB::table('alokasicuti')
        // ->join('cuti','alokasicuti.id_jeniscuti','cuti.id_jeniscuti') 
        // ->where('alokasicuti.id_karyawan',Auth::user()->id_pegawai)
        // ->where('cuti.id_karyawan',Auth::user()->id_pegawai)
        // ->where('cuti.status','=','Disetujui')
        // ->selectraw('alokasicuti.durasi - cuti.jml_cuti as sisa, cuti.id_jeniscuti,cuti.jml_cuti')
        // ->get();
        
        // dd($sisacuti);

        $output = [
            'row' => $row,
            'absenKaryawan' => $absenKaryawan,
            'absenTerlambatkaryawan' => $absenTerlambatkaryawan,
            'absenTidakmasuk' => $absenTidakmasuk,
            'alokasicuti' => $alokasicuti,
            // 'sisacuti' => $sisacuti,
            'absenBulanlalu'=> $absenBulanlalu,
            'absenTerlambatbulanlalu'=> $absenTerlambatbulanlalu,

        ];
        return view('karyawan.dashboardKaryawan', $output);

        } else {

            return redirect()->back(); 
        }
    }


    public function create()
    {
        $role = Auth::user()->role;
        
        if ($role == 1) {

        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $departemen = Departemen::all();

        $output = [
            'row' => $row,
            'departemen' => $departemen,
        ];
        return view('admin.karyawan.create', $output);

        } else {

            return redirect()->back(); 
        }
    }



    public function store_page(Request $request)
    {
        if ($request->hasfile('foto') ) {

            $fileFoto = $request->file('foto');
            $namaFile = '' . time() . $fileFoto->getClientOriginalName();
            $tujuan_upload = 'Foto_Profile';
            $fileFoto->move($tujuan_upload, $namaFile);

            $maxId = Karyawan::max('id');


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
                'foto' => $namaFile,
                'jabatan' => $request->post('jabatanKaryawan'),
                'tglmasuk' => $request->post('tglmasukKaryawan'),
                'manager' => $request->post('manager'),
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),


                'status_karyawan' => $request->post('status_karyawan'),
                'tipe_karyawan' => $request->post('tipe_karyawan'),
                'no_kk' => $request->post('no_kk'),
                'status_kerja' => $request->post('status_kerja'),
                'cuti_tahunan' => $request->post('cuti_tahunan'),
                'divisi' => $request->post('divisi'),
                'no_rek' => $request->post('no_rek'),
                'no_bpjs_kes' => $request->post('no_bpjs_kes'),
                'no_npwp' => $request->post('no_npwp'),
                'no_bpjs_ket' => $request->post('no_bpjs_ket'),
                'kontrak' => $request->post('kontrak'),
                'gaji' => $request->post('gaji'),

                'tglkeluar' => $request->post('tglkeluar'),
            );




            $data_keluarga = array(
                'id_pegawai' => $maxId + 1,
                'status_pernikahan' => $request->post('status_pernikahan'),

                'nama' => $request->post('namaPasangan'),
                'tgllahir' => $request->post('tgllahirPasangan'),
                'alamat' => $request->post('alamatPasangan'),
                'pendidikan_terakhir' => $request->post('pendidikan_terakhirPasangan'),
                'pekerjaan' => $request->post('pekerjaanPasangan'),



                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),

            );

            $r_pendidikan = array(
                'id_pegawai' => $maxId + 1,

                'tingkat' => $request->post('tingkat_pendidikan'),
                'nama_sekolah' => $request->post('nama_sekolah'),
                'kota_pformal' => $request->post('kotaPendidikanFormal'),
                'kota_pformal' => $request->post('kotaPendidikanFormal'),
                'jurusan' => $request->post('jurusan'),
                'tahun_lulus_formal' => $request->post('tahun_lulusFormal'),

                'jenis_pendidikan' => $request->post('jenis_pendidikan'),
                'kota_pnonformal' => $request->post('kotaPendidikanNonFormal'),
                'tahun_lulus_nonformal' => $request->post('tahunLulusNonFormal'),

                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),

            );

            $r_pekerjaan = array(
                'id_pegawai' => $maxId + 1,

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

            $data_kdarurat = array(

                'id_pegawai' => $maxId + 1,


                'nama' => $request->post('namaKdarurat'),
                'alamat' => $request->post('alamatKdarurat'),
                'no_hp' => $request->post('no_hpKdarurat'),
                'hubungan' => $request->post('hubunganKdarurat'),


            );

            Karyawan::insert($data);
            Keluarga::insert($data_keluarga);
            Kdarurat::insert($data_kdarurat);
            Rpendidikan::insert($r_pendidikan);
            Rpekerjaan::insert($r_pekerjaan);

            return redirect('karyawan');
        } else {


            $maxId = Karyawan::max('id');
            $maxId + 1;

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
                'tglmasuk' => $request->post('tglmasukKaryawan'),
                'manager' => $request->post('manager'),
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),


                'status_karyawan' => $request->post('status_karyawan'),
                'tipe_karyawan' => $request->post('tipe_karyawan'),
                'no_kk' => $request->post('no_kk'),
                'status_kerja' => $request->post('status_kerja'),
                'cuti_tahunan' => $request->post('cuti_tahunan'),
                'divisi' => $request->post('divisi'),
                'no_rek' => $request->post('no_rek'),
                'no_bpjs_kes' => $request->post('no_bpjs_kes'),
                'no_npwp' => $request->post('no_npwp'),
                'no_bpjs_ket' => $request->post('no_bpjs_ket'),
                'kontrak' => $request->post('kontrak'),

                'gaji' => $request->post('gaji'),
                'tglkeluar' => $request->post('tglkeluar'),
            );

            $data_keluarga = array(
                'id_pegawai' => $maxId + 1,

                'status_pernikahan' => $request->post('status_pernikahan'),

                'nama' => $request->post('namaPasangan'),
                'tgllahir' => $request->post('tgllahirPasangan'),
                'alamat' => $request->post('alamatPasangan'),
                'pendidikan_terakhir' => $request->post('pendidikan_terakhirPasangan'),
                'pekerjaan' => $request->post('pekerjaanPasangan'),


                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),

            );

            $r_pendidikan = array(
                'id_pegawai' => $maxId + 1,

                'tingkat' => $request->post('tingkat_pendidikan'),
                'nama_sekolah' => $request->post('nama_sekolah'),
                'kota_pformal' => $request->post('kotaPendidikanFormal'),
                'jurusan' => $request->post('jurusan'),
                'tahun_lulus_formal' => $request->post('tahun_lulusFormal'),

                'jenis_pendidikan' => $request->post('jenis_pendidikan'),
                'kota_pnonformal' => $request->post('kotaPendidikanNonFormal'),
                'tahun_lulus_nonformal' => $request->post('tahunLulusNonFormal'),

                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),
            );

            $r_pekerjaan = array(
                'id_pegawai' => $maxId + 1,

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

            $data_kdarurat = array(
                'id_pegawai' => $maxId + 1,

                'nama' => $request->post('namaKdarurat'),
                'alamat' => $request->post('alamatKdarurat'),
                'no_hp' => $request->post('no_hpKdarurat'),
                'hubungan' => $request->post('hubunganKdarurat'),
            );

            Karyawan::insert($data);
            Keluarga::insert($data_keluarga);
            Kdarurat::insert($data_kdarurat);
            Rpendidikan::insert($r_pendidikan);
            Rpekerjaan::insert($r_pekerjaan);

            return redirect('karyawan');
        }
    }

    public function edit($id)
    {
        $role = Auth::user()->role;
        
        if ($role == 1) {

        $karyawan = Karyawan::findOrFail($id);
        $keluarga = Keluarga::where('id_pegawai', $id)->first();
        $kdarurat = Kdarurat::where('id_pegawai', $id)->first();
        $rpendidikan = Rpendidikan::where('id_pegawai', $id)->first();
        $rpekerjaan = Rpekerjaan::where('id_pegawai', $id)->first();
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();

        $output = [
            'row' => $row
        ];

        return view('admin.karyawan.edit', $output)->with([
            'karyawan' => $karyawan,
            'keluarga' => $keluarga,
            'kdarurat' => $kdarurat,
            'rpendidikan' => $rpendidikan,
            'rpekerjaan' => $rpekerjaan,
        ]);
        } else {
 
            return redirect()->back(); 
        }
    }


    public function update(Request $request, $id)
    {
        $karyawan = karyawan::find($id);
        $maxId = Karyawan::max('id');
        $maxId + 1;

        $request->validate([
            'foto' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);


        if ($file = $request->file('foto')) {

            $extension = $file->getClientOriginalExtension();
            // $filename = md5(time()).'.'.$extension;
            $filename = '' . time() . $file->getClientOriginalName();
            $file->move(public_path() . '\Foto_Profile', $filename);
            $karyawan->foto = $filename;
        

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
            // 'created_at' => new \DateTime(),
            'updated_at' => new \DateTime(),
            'foto' => $filename,
        );

        $data_keluarga = array(
            // 'id_pegawai' => $maxId + 1 , 

            'status_pernikahan' => $request->post('status_pernikahan'),

            'nama' => $request->post('namaPasangan'),
            'tgllahir' => $request->post('tgllahirPasangan'),
            'alamat' => $request->post('alamatPasangan'),
            'pendidikan_terakhir' => $request->post('pendidikan_terakhirPasangan'),
            'pekerjaan' => $request->post('pekerjaanPasangan'),


            // 'created_at' => new \DateTime(),
            'updated_at' => new \DateTime(),

        );

        $r_pendidikan = array(
            // 'id_pegawai' => $maxId + 1 ,

            'tingkat' => $request->post('tingkat_pendidikan'),
            'nama_sekolah' => $request->post('nama_sekolah'),
            'kota_pformal' => $request->post('kotaPendidikanFormal'),
            'jurusan' => $request->post('jurusan'),
            'tahun_lulus_formal' => $request->post('tahun_lulus_formal'),

            'jenis_pendidikan' => $request->post('jenis_pendidikan'),
            'kota_pnonformal' => $request->post('kotaPendidikanNonFormal'),
            'tahun_lulus_nonformal' => $request->post('tahunLulusNonFormal'),

            // 'created_at' => new \DateTime(),
            'updated_at' => new \DateTime(),

        );

        $r_pekerjaan = array(
            // 'id_pegawai' => $maxId + 1 ,

            'nama_perusahaan' => $request->post('namaPerusahaan'),
            'alamat' => $request->post('alamatPerusahaan'),
            'jenis_usaha' => $request->post('jenisUsaha'),
            'jabatan' => $request->post('jabatan'),
            'nama_atasan' => $request->post('namaAtasan'),
            'nama_direktur' => $request->post('namaDirektur'),
            'lama_kerja' => $request->post('lamaKerja'),
            'alasan_berhenti' => $request->post('alasanBerhenti'),
            'gaji' => $request->post('gajiRpekerjaan'),

            // 'created_at' => new \DateTime(),
            'updated_at' => new \DateTime(),

        );

        $data_kdarurat = array(
            // 'id_pegawai' => $maxId + 1 ,

            'nama' => $request->post('namaKdarurat'),
            'alamat' => $request->post('alamatKdarurat'),
            'no_hp' => $request->post('no_hpKdarurat'),
            'hubungan' => $request->post('hubunganKdarurat'),

        );
        $idKaryawan = $request->post('id_karyawan');
        $idPendidikan = $request->post('id_pendidikan');
        $idKeluarga = $request->post('id_keluarga');
        $idPekerjaan = $request->post('id_pekerjaan');
        $id_kdarurat = $request->post('id_kdarurat');

        Karyawan::where('id', $idKaryawan)->update($data);
        Keluarga::where('id', $idKeluarga)->update($data_keluarga);
        Rpendidikan::where('id', $idPendidikan)->update($r_pendidikan);
        Rpekerjaan::where('id', $idPekerjaan)->update($r_pekerjaan);
        Kdarurat::where('id', $id_kdarurat)->update($data_kdarurat);

        return redirect('karyawan')->with("sukses", "berhasil diubah");

        } else {

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
                // 'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),
            );
    
            $data_keluarga = array(
                // 'id_pegawai' => $maxId + 1 , 
    
                'status_pernikahan' => $request->post('status_pernikahan'),
    
                'nama' => $request->post('namaPasangan'),
                'tgllahir' => $request->post('tgllahirPasangan'),
                'alamat' => $request->post('alamatPasangan'),
                'pendidikan_terakhir' => $request->post('pendidikan_terakhirPasangan'),
                'pekerjaan' => $request->post('pekerjaanPasangan'),
    
    
                // 'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),
    
            );
    
            $r_pendidikan = array(
                // 'id_pegawai' => $maxId + 1 ,
    
                'tingkat' => $request->post('tingkat_pendidikan'),
                'nama_sekolah' => $request->post('nama_sekolah'),
                'kota_pformal' => $request->post('kotaPendidikanFormal'),
                'jurusan' => $request->post('jurusan'),
                'tahun_lulus_formal' => $request->post('tahun_lulus_formal'),
    
                'jenis_pendidikan' => $request->post('jenis_pendidikan'),
                'kota_pnonformal' => $request->post('kotaPendidikanNonFormal'),
                'tahun_lulus_nonformal' => $request->post('tahunLulusNonFormal'),
    
                // 'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),
    
            );
    
            $r_pekerjaan = array(
                // 'id_pegawai' => $maxId + 1 ,
    
                'nama_perusahaan' => $request->post('namaPerusahaan'),
                'alamat' => $request->post('alamatPerusahaan'),
                'jenis_usaha' => $request->post('jenisUsaha'),
                'jabatan' => $request->post('jabatan'),
                'nama_atasan' => $request->post('namaAtasan'),
                'nama_direktur' => $request->post('namaDirektur'),
                'lama_kerja' => $request->post('lamaKerja'),
                'alasan_berhenti' => $request->post('alasanBerhenti'),
                'gaji' => $request->post('gajiRpekerjaan'),
    
                // 'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),
    
            );
    
            $data_kdarurat = array(
                // 'id_pegawai' => $maxId + 1 ,
    
                'nama' => $request->post('namaKdarurat'),
                'alamat' => $request->post('alamatKdarurat'),
                'no_hp' => $request->post('no_hpKdarurat'),
                'hubungan' => $request->post('hubunganKdarurat'),
    
            );
            $idKaryawan = $request->post('id_karyawan');
            $idPendidikan = $request->post('id_pendidikan');
            $idKeluarga = $request->post('id_keluarga');
            $idPekerjaan = $request->post('id_pekerjaan');
            $id_kdarurat = $request->post('id_kdarurat');
    
            Karyawan::where('id', $idKaryawan)->update($data);
            Keluarga::where('id', $idKeluarga)->update($data_keluarga);
            Rpendidikan::where('id', $idPendidikan)->update($r_pendidikan);
            Rpekerjaan::where('id', $idPekerjaan)->update($r_pekerjaan);
            Kdarurat::where('id', $id_kdarurat)->update($data_kdarurat);
    
            return redirect('karyawan')->with("sukses", "berhasil diubah");
        }

    }

    public function show($id)
    {
        $role = Auth::user()->role;
        
        if ($role == 1) {

        $karyawan = karyawan::findOrFail($id);
        $keluarga = Keluarga::where('id_pegawai', $id)->first();


        $kdarurat = Kdarurat::where('id_pegawai', $id)->first();
        $rpendidikan = Rpendidikan::where('id_pegawai', $id)->first();
        $rpekerjaan = Rpekerjaan::where('id_pegawai', $id)->first();
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();

        $output = [
            'row' => $row
        ];

        return view('admin.karyawan.show', $output)->with([
            'karyawan' => $karyawan,
            'keluarga' => $keluarga,
            'kdarurat' => $kdarurat,
            'rpendidikan' => $rpendidikan,
            'rpekerjaan' => $rpekerjaan,
        ]);
        } else {
    
            return redirect()->back(); 
        }
    }

    public function showkaryawan($id)
    {
        $karyawan = karyawan::findOrFail($id);
        $keluarga = Keluarga::where('id_pegawai', $id)->first();

        $kdarurat = Kdarurat::where('id_pegawai', $id)->first();
        $rpendidikan = Rpendidikan::where('id_pegawai', $id)->first();
        $rpekerjaan = Rpekerjaan::where('id_pegawai', $id)->first();
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();

        return view('karyawan.showKaryawan')->with([
            'karyawan' => $karyawan,
            'keluarga' => $keluarga,
            'kdarurat' => $kdarurat,
            'rpendidikan' => $rpendidikan,
            'rpekerjaan' => $rpekerjaan,
            'row' => $row
        ]);
    }

    public function destroy(Request $request, $id)
    {
        Karyawan::destroy($id);
        return redirect('karyawan');
    }

    public function editPassword(Request $data, $id)
    {
        $karyawan = Karyawan::findOrFail($id);
        $user = User::where('id_pegawai', $id)->first();
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();

        $output = [
            'row' => $row
        ];

        return view('auth.changePassword', $output)->with([
            'karyawan' => $karyawan,
            'password' => Hash::make($data['password']),
        ]);
    }

    public function updatePassword(Request $request)
    {
        # Validation
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed', 'min:8',
        ]);

        #Match The Old Password
        if (!Hash::check($request->old_password, auth()->user()->password)) {
            return back()->with("error", "Old Password Doesn't match!");
        }

        #Update the new Password
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with("status", "Password changed successfully!");
    }

    public function importexcel(Request $request)
    {
        Excel::import(new karyawanImport, request()->file('file'));
        return redirect()->back();
    }

    public function exportExcel()
    {
        return Excel::download(new KaryawanExport, 'data_karyawan.xlsx');
    }
}