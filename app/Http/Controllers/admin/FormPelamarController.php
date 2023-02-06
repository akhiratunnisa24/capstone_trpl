<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lowongan;
use App\Models\Rekruitmen;



class FormPelamarController extends Controller
{
    public function create(Request $request)

    {
        // $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $posisi = Lowongan::all()->where('status', '=', 'Aktif');
        $openRekruitmen = Lowongan::where('status', 'Aktif')->get();

        if ($openRekruitmen->count() > 0) {
            return view('admin.rekruitmen.formPelamar', compact('posisi'))->with('success', 'Data berhasil disimpan.');
        }

        return view('admin.rekruitmen.viewTidakAdaLowongan');
    }

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

        $user = new Rekruitmen();
        $user->id_lowongan = $request->posisiPelamar;
        $user->nik = $request->nikPelamar;
        $user->nama = $request->namaPelamar;
        $user->tgllahir = $request->tgllahirPelamar;
        $user->email = $request->emailPelamar;
        $user->agama = $request->agamaPelamar;
        $user->jenis_kelamin = $request->jenis_kelaminPelamar;
        $user->alamat = $request->alamatPelamar;
        $user->no_hp = $request->no_hpPelamar;
        $user->no_kk = $request->no_kkPelamar;
        $user->gaji = $request->gajiPelamar;
        $user->status_lamaran = 'tahap 1';
        $user->cv = $namaFile;



        $user->save();

        return redirect('show_formSelesai');
    }
}
