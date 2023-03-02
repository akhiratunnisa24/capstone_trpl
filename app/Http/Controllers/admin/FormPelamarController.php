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
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;




class FormPelamarController extends Controller
{
   

    public function create(Request $request)

    {
        // $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        // $posisi = Lowongan::all()->where('status', '=', 'Aktif');
        $posisi = Lowongan::all()->where('status', '=', 'Aktif')->where('tgl_selesai','>',Carbon::now());
        // dd($posisi);
        $openRekruitmen = Lowongan::where('status', 'Aktif')->get();

        if ($openRekruitmen->count() > 0) {
            return view('admin.rekruitmen.formPelamar', compact('posisi'))->with('success', 'Data berhasil disimpan.');
        }

        return view('admin.rekruitmen.viewTidakAdaLowongan');
    }

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
        $user->status_lamaran = '1';
        $user->tanggal_tahapan = Carbon::now();
        $user->cv = $namaFile;



        $user->save();

        return view('admin.rekruitmen.formSelesaiPelamar');
    }

    public function create_karyawan_baru(Request $request)

    {
        $posisi = Lowongan::all()->where('status', '=', 'Aktif');
        $openRekruitmen = Lowongan::where('status', 'Aktif')->get();

        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $departemen     = Departemen::all();
        $atasan_pertama = Karyawan::whereIn('jabatan', ['Supervisor', 'Manager', 'Direktur'])->get();
        $atasan_kedua   = Karyawan::whereIn('jabatan', ['Manager', 'Direktur'])->get();
        $user = Karyawan::max('id');
        $datakeluarga = Keluarga::where('id_pegawai', $user)->get();
        $kontakdarurat = Kdarurat::where('id_pegawai', $user)->get();
        $pformal = Rpendidikan::where('id_pegawai', $user)->where('jenis_pendidikan', '=', null)->get();
        $nonformal = Rpendidikan::where('id_pegawai', $user)->where('jenis_pendidikan', '!=', null)->get();
        $pekerjaan = Rpekerjaan::where('id_pegawai', $user)->get();
        $output = [
            'row' => $row,
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
