<?php

namespace App\Http\Controllers\karyawan;

use App\Models\Karyawan;
use App\Models\Kdarurat;
use App\Models\Keluarga;
use App\Models\Rpekerjaan;
use App\Models\Rpendidikan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class karyawanController extends Controller
{
    
    public function index()
    {
        
        $karyawan = karyawan::all()->sortByDesc('created_at');
        return view('karyawan.index', compact(['karyawan']));
    }


    public function create()
    {
       return view('karyawan.create');
    }


    // public function stores(Request $request)
    // {
    //     $fileFoto = $request->file('foto');
    //     $namaFile = ''.time().$fileFoto->getClientOriginalName();
    //     $tujuan_upload = 'Foto_Profile';
    //     $fileFoto->move($tujuan_upload, $namaFile);
                
    //     $data = $request->all();
        

    //     Karyawan::create($request->except(['_token', 'submit']));      
    //     return redirect('karyawan');
    // }
    // if($request->hasFile('foto')){
	// 	// ada file yang diupload
	// }else{
	// 	// tidak ada file yang diupload
	// }

    public function store(Request $request)
    {
        if( $request->hasfile('foto')){

              
        $fileFoto = $request->file('foto');
        $namaFile = ''.time().$fileFoto->getClientOriginalName();
        $tujuan_upload = 'Foto_Profile';
        $fileFoto->move($tujuan_upload, $namaFile);

        
    //    $fileFoto = $request->file('foto');
    //    $namaFile = ''.time().$fileFoto->getClientOriginalName();
    //    $tujuan_upload = 'Foto_Profile';
    //    $fileFoto->move($tujuan_upload, $namaFile);
       
       $data = array(
        'nip' => $request->post('nip'),
        'nik' => $request->post('nik'),
        'nama' => $request->post('nama'),
        'tgllahir' => $request->post('tgllahir'),
        'email' => $request->post('email'),
        'jenis_kelamin' => $request->post('jenis_kelamin'),
        'alamat' => $request->post('alamat'),
        'no_hp' => $request->post('no_hp'),
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
        'jabatan' => $request->post('jabatan'),
        'gaji' => $request->post('gaji'),
        'tglmasuk' => $request->post('tglmasuk'),
        'tglkeluar' => $request->post('tglkeluar'),
        'foto' => $namaFile,
        'created_at' => new \DateTime(),
        'updated_at' => new \DateTime(),
        
        // $data['created_at'] =new \DateTime();
       ); 

       Karyawan::insert($data);
    //    DB::table('karyawan')->insert($data);
        return redirect('karyawan');

        }else{
            
       $data = array(
        'nip' => $request->post('nip'),
        'nik' => $request->post('nik'),
        'nama' => $request->post('nama'),
        'tgllahir' => $request->post('tgllahir'),
        'email' => $request->post('email'),
        'jenis_kelamin' => $request->post('jenis_kelamin'),
        'alamat' => $request->post('alamat'),
        'no_hp' => $request->post('no_hp'),
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
        'jabatan' => $request->post('jabatan'),
        'gaji' => $request->post('gaji'),
        'tglmasuk' => $request->post('tglmasuk'),
        'tglkeluar' => $request->post('tglkeluar'),
        'created_at' => new \DateTime(),
        'updated_at' => new \DateTime(),
        
        // $data['created_at'] =new \DateTime();
       ); 

       Karyawan::insert($data);
    //    DB::table('karyawan')->insert($data);
        return redirect('karyawan');
        }
        
    }


    public function store_page(Request $request)
    {
        if( $request->hasfile('foto')){

        $fileFoto = $request->file('foto');
        $namaFile = ''.time().$fileFoto->getClientOriginalName();
        $tujuan_upload = 'Foto_Profile';
        $fileFoto->move($tujuan_upload, $namaFile);

        $maxId = Karyawan::max('id');
        
       
       $data = array(
        'nama' => $request->post('namaKaryawan'),
        'tgllahir' => $request->post('tgllahirKaryawan'),
        'jenis_kelamin' => $request->post('jenis_kelaminKaryawan'),
        'tgllahir' => $request->post('tgllahirKaryawan'),        
        'jenis_kelamin' => $request->post('jenis_kelaminKaryawan'),
        'alamat' => $request->post('alamatKaryawan'),
        'no_hp' => $request->post('no_hpKaryawan'),
        'email' => $request->post('emailKaryawan'),
        'agama' => $request->post('agamaKaryawan'),
        'nik' => $request->post('nikKaryawan'),
        'gol_darah' => $request->post('gol_darahKaryawan'),
        'foto' => $namaFile,
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
        'jabatan' => $request->post('jabatan'),
        'gaji' => $request->post('gaji'),
        'tglmasuk' => $request->post('tglmasuk'),
        'tglkeluar' => $request->post('tglkeluar'),
       ); 

       
      
       
       $data_keluarga = array(
        'id_pegawai' => $maxId + 1 , 
        'status_pernikahan' => $request->post('status_pernikahan'),

        'nama' => $request->post('namaPasangan'),
        'tgllahir' => $request->post('tgllahirPasangan'),
        'alamat' => $request->post('alamatPasangan'),
        'pendidikan_terakhir' => $request->post('pendidikan_terakhirPasangan'),
        'pekerjaan' => $request->post('pekerjaanPasangan'),

        'nama' => $request->post('namaAnak'),
        'tgllahir' => $request->post('tgllahirAnak'),
        'pendidikan_terakhir' => $request->post('pendidikan_terakhirAnak'),

        'nama' => $request->post('namaOrtu'),
        'tgllahir' => $request->post('tgllahirOrtu'),
        'pekerjaan' => $request->post('pekerjaanOrtu'),

        'nama' => $request->post('namaSaudara'),
        'tgllahir' => $request->post('tgllahirSaudara'),
        'pendidikan_terakhir' => $request->post('pendidikan_terakhirSaudara'),
        

        'created_at' => new \DateTime(),
        'updated_at' => new \DateTime(),

       );

       $r_pendidikan = array(
        'id_pegawai' => $maxId + 1 ,

        'tingkat' => $request->post('tingkat_pendidikan'),
        'nama_sekolah' => $request->post('nama_sekolah'),
        'kota' => $request->post('kota'),
        'jurusan' => $request->post('jurusan'),
        'tahun_lulus' => $request->post('tahun_lulus'),

        'jenis_pendidikan' => $request->post('jenis_pendidikan'),
        'kota' => $request->post('kotaPendidikanNonFormal'),
        'tahun_lulus' => $request->post('tahunLulusNonFormal'),

        'created_at' => new \DateTime(),
        'updated_at' => new \DateTime(),

       );

       $r_pekerjaan = array(
        'id_pegawai' => $maxId + 1 ,

        'nama_perusahaan' => $request->post('namaPerusahaan'),
        'alamat' => $request->post('alamatPerusahaan'),
        'jenis_usaha' => $request->post('jenisUsaha'),
        'jabatan' => $request->post('jabatan'),
        'nama_atasan' => $request->post('namaAtasan'),
        'nama_direktur' => $request->post('namaDirektur'),
        'lama_kerja' => $request->post('lamaKerja'),
        'alasan_berhenti' => $request->post('alasanBerhenti'),
        'gaji' => $request->post('gajiRpekerjaan'),

        'created_at' => new \DateTime(),
        'updated_at' => new \DateTime(),

       );

       $data_kdarurat = array(
        
        'id_pegawai' => $maxId + 1 ,
        

        'nama' => $request->post('namaKdarurat'),
        'alamat' => $request->post('alamatKdarurat'),
        'no_hp' => $request->post('no_hpKdarurat'),
        
        
       ); 

       Karyawan::insert($data);
       Keluarga::insert($data_keluarga);
       Kdarurat::insert($data_kdarurat);
       Rpendidikan::insert($r_pendidikan);
       Rpekerjaan::insert($r_pekerjaan);

        return redirect('karyawan');

        }else{

                
            $maxId = Karyawan::max('id');
            $maxId + 1;
            
            $data = array(
                'nama' => $request->post('namaKaryawan'),
                'tgllahir' => $request->post('tgllahirKaryawan'),
                'jenis_kelamin' => $request->post('jenis_kelaminKaryawan'),
                'tgllahir' => $request->post('tgllahirKaryawan'),        
                'jenis_kelamin' => $request->post('jenis_kelaminKaryawan'),
                'alamat' => $request->post('alamatKaryawan'),
                'no_hp' => $request->post('no_hpKaryawan'),
                'email' => $request->post('emailKaryawan'),
                'agama' => $request->post('agamaKaryawan'),
                'nik' => $request->post('nikKaryawan'),
                'gol_darah' => $request->post('gol_darahKaryawan'),
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
                'jabatan' => $request->post('jabatan'),
                'gaji' => $request->post('gaji'),
                'tglmasuk' => $request->post('tglmasuk'),
                'tglkeluar' => $request->post('tglkeluar'),
               ); 
               
                $data_keluarga = array(
                'id_pegawai' => $maxId + 1 , 
                
                'status_pernikahan' => $request->post('status_pernikahan'),
        
                'nama' => $request->post('namaPasangan'),
                'tgllahir' => $request->post('tgllahirPasangan'),
                'alamat' => $request->post('alamatPasangan'),
                'pendidikan_terakhir' => $request->post('pendidikan_terakhirPasangan'),
                'pekerjaan' => $request->post('pekerjaanPasangan'),
        
                'nama' => $request->post('namaAnak'),
                'tgllahir' => $request->post('tgllahirAnak'),
                'pendidikan_terakhir' => $request->post('pendidikan_terakhirAnak'),
        
                'nama' => $request->post('namaOrtu'),
                'tgllahir' => $request->post('tgllahirOrtu'),
                'pekerjaan' => $request->post('pekerjaanOrtu'),
        
                'nama' => $request->post('namaSaudara'),
                'tgllahir' => $request->post('tgllahirSaudara'),
                'pendidikan_terakhir' => $request->post('pendidikan_terakhirSaudara'),
                
        
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),
        
               );
        
               $r_pendidikan = array(
                'id_pegawai' => $maxId + 1 ,
        
                'tingkat' => $request->post('tingkat_pendidikan'),
                'nama_sekolah' => $request->post('nama_sekolah'),
                'kota' => $request->post('kota'),
                'jurusan' => $request->post('jurusan'),
                'tahun_lulus' => $request->post('tahun_lulus'),
        
                'jenis_pendidikan' => $request->post('jenis_pendidikan'),
                'kota' => $request->post('kotaPendidikanNonFormal'),
                'tahun_lulus' => $request->post('tahunLulusNonFormal'),
        
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),
        
               );
        
               $r_pekerjaan = array(
                'id_pegawai' => $maxId + 1 ,
        
                'nama_perusahaan' => $request->post('namaPerusahaan'),
                'alamat' => $request->post('alamatPerusahaan'),
                'jenis_usaha' => $request->post('jenisUsaha'),
                'jabatan' => $request->post('jabatan'),
                'nama_atasan' => $request->post('namaAtasan'),
                'nama_direktur' => $request->post('namaDirektur'),
                'lama_kerja' => $request->post('lamaKerja'),
                'alasan_berhenti' => $request->post('alasanBerhenti'),
                'gaji' => $request->post('gajiRpekerjaan'),
        
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),
        
               );
        
               $data_kdarurat = array(
                'id_pegawai' => $maxId + 1 ,
        
                'nama' => $request->post('namaKdarurat'),
                'alamat' => $request->post('alamatKdarurat'),
                'no_hp' => $request->post('no_hpKdarurat'),
                
                
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
        $karyawan = karyawan::findOrFail($id);

        return view('karyawan.edit')->with([
            'karyawan' => $karyawan,
        ]);
    }


    public function update(Request $request, $id )
    {
        $karyawan = karyawan::find($id);

        $request->validate([
            'foto' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        
        if ($file = $request->file('foto')){
            
            $extension = $file->getClientOriginalExtension();
            // $filename = md5(time()).'.'.$extension;
            $filename = ''.time().$file->getClientOriginalName();
            $file->move(public_path().'\Foto_Profile',$filename);
            $karyawan->foto=$filename;

        }

        $karyawan->nip = $request->nip;
        $karyawan->nik = $request->nik;
        $karyawan->no_kk = $request->no_kk;
        $karyawan->nama = $request->nama;
        $karyawan->tgllahir = $request->tgllahir;
        $karyawan->email = $request->email;
        $karyawan->jenis_kelamin = $request->jenis_kelamin;
        $karyawan->alamat = $request->alamat;
        $karyawan->no_hp = $request->no_hp;
        $karyawan->status_karyawan = $request->status_karyawan;
        $karyawan->status_kerja = $request->status_kerja;
        $karyawan->tipe_karyawan = $request->tipe_karyawan;
        $karyawan->tglmasuk = $request->tglmasuk;
        $karyawan->no_npwp = $request->no_npwp;
        $karyawan->divisi = $request->divisi;
        $karyawan->no_rek = $request->no_rek;
        $karyawan->no_bpjs_kes = $request->no_bpjs_kes;
        $karyawan->no_bpjs_ket = $request->no_bpjs_ket;
        $karyawan->kontrak = $request->kontrak;
        $karyawan->tglkeluar = $request->tglkeluar;
        $karyawan->jabatan = $request->jabatan;
        $karyawan->gaji = $request->gaji;
        $karyawan->foto = $karyawan->foto;
            

        $karyawan->save();  
        return view('karyawan.show')->with([
            'karyawan' => $karyawan,
        ]);
    }

    public function show($id)
    {
        $karyawan = karyawan::findOrFail($id);
        $keluarga = Keluarga::with('karyawan');
        $kdarurat = Kdarurat::with('karyawan');
        $rpendidikan = Rpendidikan::with('karyawan');
        $rpekerjaan = Rpekerjaan::with('karyawan');


        return view('karyawan.show')->with([
            'karyawan' => $karyawan,
            'keluarga' => $keluarga,
            'kdarurat' => $kdarurat,
            'rpendidikan' => $rpendidikan,
            'rpekerjaan' => $rpekerjaan,
        ]);
    }
 
    public function destroy(Request $request, $id )
    {
        Karyawan::destroy($id);
        return redirect('karyawan');
    }
}

