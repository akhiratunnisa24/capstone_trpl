<?php

namespace App\Http\Controllers\karyawan;

use App\Models\Karyawan;
use App\Models\Departemen;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class KaryawansController extends Controller
{
    public function create()
    {
        $role = Auth::user()->role;

        if ($role == 1) {

            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
            $departemen     = Departemen::all();
            $atasan_pertama = Karyawan::whereIn('jabatan', ['Supervisor', 'Manager','Direktur'])->get();
            $atasan_kedua   = Karyawan::whereIn('jabatan', ['Manager','Direktur'])->get();

            $output = [
                'row' => $row,
                'departemen' => $departemen,
                'atasan_pertama' => $atasan_pertama,
                'atasan_kedua' => $atasan_kedua,
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

            return redirect()->back()->withInput();
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
            //  return redirect('karyawan');
            return redirect()->back()->withInput();
        }
    }
}
