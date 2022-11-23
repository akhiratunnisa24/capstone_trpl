<?php

namespace App\Http\Controllers\karyawan;

use App\Models\Karyawan;
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
       //
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

        return view('karyawan.show')->with([
            'karyawan' => $karyawan,
        ]);
    }
 
    public function destroy(Request $request, $id )
    {
        Karyawan::destroy($id);
        return redirect('karyawan');
    }
}

