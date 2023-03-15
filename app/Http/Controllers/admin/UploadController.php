<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Karyawan;
use App\Models\File;


class UploadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $role = Auth::user()->role;
        if ($role == 1) {

            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
            $karyawan = Karyawan::all();

            // // ambil data karyawan yang sudah upload file digital
            // $karyawansudah = DB::table('file')->pluck('id_pegawai');
            // // ambil data karyawan yang belum upload file digital
            // $karyawanbelum = DB::table('karyawan')->whereNotIn("id", $karyawansudah)->get();

            $output = [
                'row' => $row,
                // 'karyawanbelum' => $karyawanbelum,
                'karyawan' => $karyawan,
            ];
            return view('admin.karyawan.createUpload', $output);
        } else {

            return redirect()->back();
        }
    }

    public function store(Request $request)
    {

        $fotoKtp = $request->file('fotoKTP');
        $namaKtp = '' . time() . $fotoKtp->getClientOriginalName();
        $tujuan_upload = 'File_KTP';
        $fotoKtp->move($tujuan_upload, $namaKtp);

        $fotoKK = $request->file('fotoKK');
        $namaKK = '' . time() . $fotoKK->getClientOriginalName();
        $tujuan_upload = 'File_KK';
        $fotoKK->move($tujuan_upload, $namaKK);

        $fotoNPWP = $request->file('fotoNPWP');
        $namaNPWP = '' . time() . $fotoNPWP->getClientOriginalName();
        $tujuan_upload = 'File_NPWP';
        $fotoNPWP->move($tujuan_upload, $namaNPWP);

        $fotoBPJSket = $request->file('fotoBPJSket');
        $namaBPJSket = '' . time() . $fotoBPJSket->getClientOriginalName();
        $tujuan_upload = 'File_BPJSKet';
        $fotoBPJSket->move($tujuan_upload, $namaBPJSket);

        $fotoBPJSkes = $request->file('fotoBPJSkes');
        $namaBPJSkes = '' . time() . $fotoBPJSkes->getClientOriginalName();
        $tujuan_upload = 'File_BPJSKes';
        $fotoBPJSkes->move($tujuan_upload, $namaBPJSkes);

        $fotoAKDHK = $request->file('fotoAKDHK');
        $namaAKDHK = '' . time() . $fotoAKDHK->getClientOriginalName();
        $tujuan_upload = 'File_AKDHK';
        $fotoAKDHK->move($tujuan_upload, $namaAKDHK);

        $fotoTabungan = $request->file('fotoTabungan');
        $namaTabungan = '' . time() . $fotoTabungan->getClientOriginalName();
        $tujuan_upload = 'File_Tabungan';
        $fotoTabungan->move($tujuan_upload, $namaTabungan);

        $fotoSKCK = $request->file('fotoSKCK');
        $namaSKCK = '' . time() . $fotoSKCK->getClientOriginalName();
        $tujuan_upload = 'File_SKCK';
        $fotoSKCK->move($tujuan_upload, $namaSKCK);

        $fotoIjazah = $request->file('fotoIjazah');
        $namaIjazah = '' . time() . $fotoIjazah->getClientOriginalName();
        $tujuan_upload = 'File_Ijazah';
        $fotoIjazah->move($tujuan_upload, $namaIjazah);

        $fotoLamaran = $request->file('fotoLamaran');
        $namaLamaran = '' . time() . $fotoLamaran->getClientOriginalName();
        $tujuan_upload = 'File_Lamaran';
        $fotoLamaran->move($tujuan_upload, $namaLamaran);

        $fotoSuratPengalaman = $request->file('fotoSuratPengalaman');
        $namaSuratPengalaman = '' . time() . $fotoSuratPengalaman->getClientOriginalName();
        $tujuan_upload = 'File_Pengalaman';
        $fotoSuratPengalaman->move($tujuan_upload, $namaSuratPengalaman);

        $fotoSuratPrestasi = $request->file('fotoSuratPrestasi');
        $namaSuratPrestasi = '' . time() . $fotoSuratPrestasi->getClientOriginalName();
        $tujuan_upload = 'File_Prestasi';
        $fotoSuratPrestasi->move($tujuan_upload, $namaSuratPrestasi);

        $fotoSuratPendidikan = $request->file('fotoSuratPendidikan');
        $namaSuratPendidikan = '' . time() . $fotoSuratPendidikan->getClientOriginalName();
        $tujuan_upload = 'File_Pendidikan';
        $fotoSuratPendidikan->move($tujuan_upload, $namaSuratPendidikan);

        $fotoPerjanjianKerja = $request->file('fotoPerjanjianKerja');
        $namaPerjanjianKerja = '' . time() . $fotoPerjanjianKerja->getClientOriginalName();
        $tujuan_upload = 'File_Perjanjian';
        $fotoPerjanjianKerja->move($tujuan_upload, $namaPerjanjianKerja);

        $fotoSuratPengangkatan = $request->file('fotoSuratPengangkatan');
        $namaPengangkatan = '' . time() . $fotoSuratPengangkatan->getClientOriginalName();
        $tujuan_upload = 'File_Pengangkatan';
        $fotoSuratPengangkatan->move($tujuan_upload, $namaPengangkatan);

        $fotoSuratKeputusan = $request->file('fotoSuratKeputusan');
        $namaKeputusan = '' . time() . $fotoSuratKeputusan->getClientOriginalName();
        $tujuan_upload = 'File_Keputusan';
        $fotoSuratKeputusan->move($tujuan_upload, $namaKeputusan);

        $file = array(

            'id_pegawai' => $request->post('karyawan'),
            
            'ktp' => $namaKtp,
            'kk' => $namaKK,
            'npwp' => $namaNPWP,
            'bpjs_ket' => $namaBPJSket,
            'bpjs_kes' => $namaBPJSkes,
            'as_akdhk' => $namaAKDHK,
            'buku_tabungan' => $namaTabungan,
            'skck' => $namaSKCK,
            'ijazah' => $namaIjazah,
            'lamaran' => $namaLamaran,
            'surat_pengalaman_kerja' => $namaSuratPengalaman,
            'surat_penghargaan' => $namaSuratPrestasi,
            'surat_pelatihan' => $namaSuratPendidikan,
            'surat_perjanjian_kerja' => $namaPerjanjianKerja,
            'surat_pengangkatan_kartap' => $namaPengangkatan,
            'surat_alih_tugas' => $namaKeputusan,

            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime(),

        );

        File::insert($file);
        return redirect()->back();
    }
}
