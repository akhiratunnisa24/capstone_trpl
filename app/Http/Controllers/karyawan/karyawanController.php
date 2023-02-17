<?php

namespace App\Http\Controllers\karyawan;


use Carbon\Carbon;
use App\Models\Cuti;
use App\Models\User;
use App\Models\Users;
use App\Models\Absensi;
use App\Models\Karyawan;
use App\Models\Izin;
use App\Models\Kdarurat;
use App\Models\Keluarga;
use App\Models\Rpekerjaan;
use App\Models\Alokasicuti;
use App\Models\Rpendidikan;
use App\Models\Departemen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\KaryawanExport;
use App\Imports\karyawanImport;
use App\Events\AbsenKaryawanEvent;
use App\Models\Tidakmasuk;
use Illuminate\Support\Facades\Storage;

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


            // $karyawanSudahAbsen = DB::table('absensi')->whereDay('created_at', '=', Carbon::now())->pluck('id_karyawan');
            // $karyawan = DB::table('karyawan')->whereNotIn('id', $karyawanSudahAbsen)->get();

            // if ($karyawan->count() > 0) {
            //     foreach ($karyawan as $karyawan) {
            //         $absen = new Tidakmasuk();
            //         $absen->id_pegawai = $karyawan->id;
            //         $absen->nama = $karyawan->nama;
            //         $absen->divisi = $karyawan->divisi;
            //         $absen->status = 'tanpa keterangan';
            //         $absen->tanggal = Carbon::today();
            //         $absen->save();
            //     }
            // }    
            // dd($karyawan);


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



    public function karyawanDashboard()
    {
        $role = Auth::user()->role;

        if ($role == 2 or 3) {

            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();

            $absenKaryawan = Absensi::where('id_karyawan', Auth::user()->id_pegawai)
                ->whereDay('created_at', '=', Carbon::now(),)->count('jam_masuk');

            // Absen Terlambat untuk hari ini
            $absenTerlambatkaryawan = Absensi::where('id_karyawan', Auth::user()->id_pegawai)
                ->whereYear('tanggal', '=', Carbon::now()->year)
                ->whereMonth('tanggal', '=', Carbon::now()->month)
                ->whereTime('jam_masuk', '>', '08:00:00')
                ->count();

            //absen masuk bulan lalu    
            $absenBulanlalu  = Absensi::where('id_karyawan', Auth::user()->id_pegawai)
                ->whereYear('tanggal', '=', Carbon::now()->subMonth()->year)
                ->whereMonth('tanggal', '=', Carbon::now()->subMonth()->month)
                ->count('jam_masuk');

            //absen terlambat bulan lalu
            $absenTerlambatbulanlalu = Absensi::where('id_karyawan', Auth::user()->id_pegawai)
                ->whereYear('tanggal', '=', Carbon::now()->subMonth()->year)
                ->whereMonth('tanggal', '=', Carbon::now()->subMonth()->month)
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
                'absenBulanlalu' => $absenBulanlalu,
                'absenTerlambatbulanlalu' => $absenTerlambatbulanlalu,

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
            $departemen     = Departemen::all();
            $atasan_pertama = Karyawan::whereIn('jabatan', ['Supervisor', 'Manager','Managemen'])->get();
            $atasan_kedua   = Karyawan::whereIn('jabatan', ['Manager','Managemen'])->get();

            $output = [
                'row' => $row,
                'departemen' => $departemen,
                'atasan_pertama' => $atasan_pertama,
                'atasan_kedua' => $atasan_kedua,
            ];
            return view('admin.karyawan.create', $output);
        } else {

            return redirect()->back();
        }
    }



    public function store_page(Request $request)
    {
        if ($request->hasfile('foto')) {

            $fileFoto = $request->file('foto');
            $namaFile = '' . time() . $fileFoto->getClientOriginalName();
            $tujuan_upload = 'Foto_Profile';
            $fileFoto->move($tujuan_upload, $namaFile);

            $maxId = Karyawan::max('id');

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

            // $profile = new Kdarurat();
            // $profile->id_pegawai = $user->id;
            // $profile->nama = $request->namaKdarurat;
            // $profile->alamat = $request->alamatKdarurat;
            // $profile->no_hp = $request->no_hpKdarurat;
            // $profile->hubungan = $request->hubunganKdarurat;
            // $profile->save();


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
                'atasan_pertama' => $request->post('atasan_pertama'),
                'atasan_kedua' => $request->post('atasan_kedua'),
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
                'id_pegawai' => $user->id,
                // 'id_pegawai' => $maxId + 1,
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
                'id_pegawai' => $user->id,
                // 'id_pegawai' => $maxId + 1,

                'tingkat' => $request->post('tingkat_pendidikan'),
                'nama_sekolah' => $request->post('nama_sekolah'),
                'kota_pformal' => $request->post('kotaPendidikanFormal'),
                'kota_pformal' => $request->post('kotaPendidikanFormal'),
                'jurusan' => $request->post('jurusan'),
                'tahun_lulus_formal' => Carbon::parse($request->post('tahun_lulusFormal'))->format('Y'),

                'jenis_pendidikan' => $request->post('jenis_pendidikan'),
                'kota_pnonformal' => $request->post('kotaPendidikanNonFormal'),
                'tahun_lulus_nonformal' => Carbon::parse($request->post('tahunLulusNonFormal'))->format('Y'),

                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),

            );

            // dd( $r_pendidikan);

            $r_pekerjaan = array(
                'id_pegawai' => $user->id,
                // 'id_pegawai' => $maxId + 1,

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
                'id_pegawai' => $user->id,
                // 'id_pegawai' => $maxId + 1,

                'nama' => $request->post('namaKdarurat'),
                'alamat' => $request->post('alamatKdarurat'),
                'no_hp' => $request->post('no_hpKdarurat'),
                'hubungan' => $request->post('hubunganKdarurat'),
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),

            );

            // Karyawan::insert($data);
            Keluarga::insert($data_keluarga);
            Kdarurat::insert($data_kdarurat);
            Rpendidikan::insert($r_pendidikan);
            Rpekerjaan::insert($r_pekerjaan);

            return redirect('karyawan');
        } else {


            $maxId = Karyawan::max('id');
            $maxId + 1;

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
                'atasan_pertama' => $request->post('atasan_pertama'),
                'atasan_kedua' => $request->post('atasan_kedua'),
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
                // 'id_pegawai' => $maxId + 1,
                'id_pegawai' => $user->id,

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
                // 'id_pegawai' => $maxId + 1,
                'id_pegawai' => $user->id,


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
                // 'id_pegawai' => $maxId + 1,
                'id_pegawai' => $user->id,


                'nama' => $request->post('namaKdarurat'),
                'alamat' => $request->post('alamatKdarurat'),
                'no_hp' => $request->post('no_hpKdarurat'),
                'hubungan' => $request->post('hubunganKdarurat'),
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),
            );

            
            // Karyawan::insert($data);
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

            $karyawan       = Karyawan::findOrFail($id);
            $keluarga       = Keluarga::where('id_pegawai', $id)->first();
            $kdarurat       = Kdarurat::where('id_pegawai', $id)->first();
            $rpendidikan    = Rpendidikan::where('id_pegawai', $id)->first();
            $rpekerjaan     = Rpekerjaan::where('id_pegawai', $id)->first();
            $row            = Karyawan::where('id', Auth::user()->id_pegawai)->first();
            $departemen     = Departemen::all();
            $atasan_pertama = Karyawan::whereIn('jabatan', ['Supervisor', 'Manager','Direktur'])->get();
            $atasan_kedua   = Karyawan::whereIn('jabatan', ['Manager','Direktur'])->get();

            $output = [
                'row' => $row
            ];

            return view('admin.karyawan.edit', $output)->with([
                'karyawan'   => $karyawan,
                'keluarga'   => $keluarga,
                'kdarurat'   => $kdarurat,
                'rpendidikan'=> $rpendidikan,
                'rpekerjaan' => $rpekerjaan,
                'departemen' =>$departemen,
                'atasan_pertama'=> $atasan_pertama,
                'atasan_kedua'  => $atasan_kedua,
            ]);
        } else {

            return redirect()->back();
        }
    }


    public function update(Request $request, $id)
    {
        $karyawan = Karyawan::find($id);
        $maxId = Karyawan::max('id');
        $maxId + 1;
        $request->validate(['foto' => 'image|mimes:jpeg,png,jpg|max:2048']);

$fotoLama = $karyawan->foto;

if ($file = $request->file('foto')) {

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

    return redirect()->back();




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
                'tahun_lulus_formal' => $request->post('tahun_lulusFormal'),

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
                'divisi'=>$request->post('divisi'),
                'atasan_pertama'=>$request->post('atasan_pertama'),
                'atasan_kedua'=>$request->post('atasan_kedua'),
                // 'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),
            );
            // dd($data);

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
            $status = Keluarga::where('id_pegawai', $id)->first();
            $keluarga = Keluarga::where('id_pegawai', $id)->get();
            $kdarurat = Kdarurat::where('id_pegawai', $id)->get();
            $rpendidikan = Rpendidikan::where('id_pegawai', $id)->get();
            $nonformal = Rpendidikan::where('id_pegawai',$id)->where('jenis_pendidikan','!=',null)->get();
            $rpekerjaan = Rpekerjaan::where('id_pegawai', $id)->get();
            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();

            $departemen     = Departemen::all();
            $atasan_pertama = Karyawan::whereIn('jabatan', ['Supervisor', 'Manager','Managemen'])->get();
            $atasan_kedua   = Karyawan::whereIn('jabatan', ['Manager','Managemen'])->get();

            $output = [
                'row' => $row
            ];

            return view('admin.karyawan.show', $output)->with([
                'karyawan' => $karyawan,
                'keluarga' => $keluarga,
                'kdarurat' => $kdarurat,
                'rpendidikan' => $rpendidikan,
                'rpekerjaan' => $rpekerjaan,
                'status' =>$status,
                'nonformal' =>$nonformal,
                'departemen' =>$departemen,
                'atasan_pertama'=>$atasan_pertama,
                'atasan_kedua'=>$atasan_kedua,
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
        $karyawan = Karyawan::find($id);
        $karyawan->keluarga()->delete();
        $karyawan->kdarurat()->delete();
        $karyawan->rpekerjaan()->delete();
        $karyawan->rpendidikan()->delete();
        $karyawan->delete();

        return redirect()->back();
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

    public function showKaryawanCuti()
    {
        $role = Auth::user()->role;

        if ($role == 1) {

            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();

            $izin = Izin::with('karyawan',)
                ->whereYear('tgl_mulai', '=', Carbon::now()->year)
                ->whereMonth('tgl_mulai', '=', Carbon::now()->month)
                ->whereDay('tgl_mulai', '=', Carbon::now())
                ->get();

            $cuti = Cuti::with('karyawan', 'jeniscuti')
                ->whereYear('tgl_mulai', '=', Carbon::now()->year)
                ->whereMonth('tgl_mulai', '=', Carbon::now()->month)
                ->whereDay('tgl_mulai', '=', Carbon::now())
                ->get();

            $izinBulanIni = Izin::with('karyawan',)
                ->whereYear('tgl_mulai', '=', Carbon::now()->year)
                ->whereMonth('tgl_mulai', '=', Carbon::now()->month)
                ->get();

            $cutiBulanIni = Cuti::with('karyawan', 'jeniscuti')
                ->whereYear('tgl_mulai', '=', Carbon::now()->year)
                ->whereMonth('tgl_mulai', '=', Carbon::now()->month)
                ->get();

            $izinBulanLalu = Izin::with('karyawan',)
                ->whereYear('tgl_mulai', '=', Carbon::now()->year)
                ->whereMonth('tgl_mulai', '=', Carbon::now()->subMonth()->month)
                ->get();

            $cutiBulanLalu = Cuti::with('karyawan', 'jeniscuti')
            ->whereYear('tgl_mulai', '=', Carbon::now()->year)
            ->whereMonth('tgl_mulai', '=', Carbon::now()->subMonth()->month)
            ->get();

            $output = [
                'row' => $row,
            ];
            return view('admin.karyawan.showKaryawanCuti', compact('izin', 'row', 'cuti', 'izinBulanIni', 'cutiBulanIni', 'izinBulanLalu', 'cutiBulanLalu'));
        } else {

            return redirect()->back();
        }
    }

    public function showkaryawanabsen()
    {
        $role = Auth::user()->role;

        if ($role == 1) {

            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();


            $absen = Absensi::with('karyawan',)
            ->whereYear('tanggal', '=', Carbon::now()->year)
                ->whereMonth('tanggal', '=', Carbon::now()->month)
                ->whereDay('tanggal', '=', Carbon::now())
                ->get();

            $absenBulanIni = Absensi::with('karyawan')
            ->whereYear('tanggal', '=', Carbon::now()->year)
                ->whereMonth('tanggal', '=', Carbon::now()->month)
                ->get();

            $absenBulanLalu = Absensi::with('karyawan',)
            ->whereYear('tanggal', '=', Carbon::now()->year)
            ->whereMonth('tanggal', '=', Carbon::now()->subMonth()->month)
            ->get();

            $output = [
                'row' => $row,
            ];
            return view('admin.karyawan.showKaryawanAbsen', compact('absen', 'row', 'absenBulanIni', 'absenBulanLalu'));
        } else {

            return redirect()->back();
        }
    }

    public function showkaryawanterlambat()
    {
        $role = Auth::user()->role;

        if ($role == 1) {

            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();

            $terlambat = Absensi::with('karyawan',)
            ->whereYear('tanggal', '=', Carbon::now()->year)
                ->whereMonth('tanggal', '=', Carbon::now()->month)
                ->whereDay('tanggal', '=', Carbon::now())
                ->whereTime('jam_masuk', '>', '08:00:00')
                ->get();

            $terlambatBulanIni = Absensi::with('karyawan')
            ->whereYear('tanggal', '=', Carbon::now()->year)
                ->whereMonth('tanggal', '=', Carbon::now()->month)
                ->whereTime('jam_masuk', '>', '08:00:00')
                ->get();

            $terlambatBulanLalu = Absensi::with('karyawan',)
            ->whereYear('tanggal', '=', Carbon::now()->year)
                ->whereMonth('tanggal', '=', Carbon::now()->subMonth()->month)
                ->whereTime('jam_masuk', '>', '08:00:00')
                ->get();

            $output = [
                'row' => $row,
            ];
            return view('admin.karyawan.showKaryawanTerlambat', compact('terlambat', 'row', 'terlambatBulanIni', 'terlambatBulanLalu'));
        } else {

            return redirect()->back();
        }
    }

    public function showkaryawantidakmasuk()
    {
        $role = Auth::user()->role;

        //ambil id_karyawan yang udah absen
        

        if ($role == 1) {

            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();

            // $karyawanSudahAbsen = DB::table('absensi')->pluck('id_karyawan');
            // $karyawanBelumAbsen = Karyawan::with('departemen')
            // ->whereYear('tanggal', '=', Carbon::now()->year)
            // ->whereMonth('tanggal', '=', Carbon::now()->month)
            // ->whereDay('tanggal', '=', Carbon::now())
            // ->whereNotIn('id', $karyawanSudahAbsen)
            // ->get();

            $tidakMasuk = Tidakmasuk::with('departemen','karyawan2')
                ->whereYear('tanggal', '=', Carbon::now()->year)
                ->whereMonth('tanggal', '=', Carbon::now()->month)
                ->whereDay('tanggal', '=', Carbon::now())
                ->get();

            $tidakMasukBulanIni = Tidakmasuk::with('departemen', 'karyawan2')
                ->whereYear('tanggal', '=', Carbon::now()->year)
                ->whereMonth('tanggal', '=', Carbon::now()->month)
                ->get();

            $tidakMasukBulanLalu = Tidakmasuk::with('departemen', 'karyawan2')
                ->whereYear('tanggal', '=', Carbon::now()->year)
                ->whereMonth('tanggal', '=', Carbon::now()->subMonth()->month)
                ->get();
            // dd($tidakMasukBulanLalu);

            $output = [
                'row' => $row,
            ];
            return view('admin.karyawan.showKaryawanTidakMasuk', compact('tidakMasuk', 'row', 'tidakMasukBulanIni', 'tidakMasukBulanLalu'));
        } else {

            return redirect()->back();
        }
    }
}