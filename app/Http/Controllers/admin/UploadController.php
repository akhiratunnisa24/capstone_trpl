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
        if ($role == 1 || $role == 2) {

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
        if (isset($fotoKtp)) {
        $namaKtp = 'KTP-' . time() . $fotoKtp->getClientOriginalName();
        $tujuan_upload = 'File_KTP';
        $fotoKtp->move($tujuan_upload, $namaKtp);
        } else {
          
        }

        $fotoKK = $request->file('fotoKK');
        if (isset($fotoKK)) {
        $namaKK = 'KK-' . time() . $fotoKK->getClientOriginalName();
        $tujuan_upload = 'File_KK';
        $fotoKK->move($tujuan_upload, $namaKK);
        } else {

        }


        $fotoNPWP = $request->file('fotoNPWP');
        if (isset($fotoNPWP)) {
        $namaNPWP = 'NPWP-' . time() . $fotoNPWP->getClientOriginalName();
        $tujuan_upload = 'File_NPWP';
        $fotoNPWP->move($tujuan_upload, $namaNPWP);
        } else {

        }

        $fotoBPJSket = $request->file('fotoBPJSket');
        if (isset($fotoBPJSket)) {
        $namaBPJSket = 'BPJSket-' . time() . $fotoBPJSket->getClientOriginalName();
        $tujuan_upload = 'File_BPJSKet';
        $fotoBPJSket->move($tujuan_upload, $namaBPJSket);
        } else {

        }

        $fotoBPJSkes = $request->file('fotoBPJSkes');
        if (isset($fotoBPJSkes)) {
        $namaBPJSkes = 'BPJSkes-' . time() . $fotoBPJSkes->getClientOriginalName();
        $tujuan_upload = 'File_BPJSKes';
        $fotoBPJSkes->move($tujuan_upload, $namaBPJSkes);
        } else {

        }

        $fotoAKDHK = $request->file('fotoAKDHK');
        if (isset($fotoAKDHK)) {
        $namaAKDHK = 'AKDHK-' . time() . $fotoAKDHK->getClientOriginalName();
        $tujuan_upload = 'File_AKDHK';
        $fotoAKDHK->move($tujuan_upload, $namaAKDHK);
        } else {

        }

        $fotoTabungan = $request->file('fotoTabungan');
        if (isset($fotoTabungan)) {
        $namaTabungan = 'Tabungan-' . time() . $fotoTabungan->getClientOriginalName();
        $tujuan_upload = 'File_Tabungan';
        $fotoTabungan->move($tujuan_upload, $namaTabungan);
        } else {

        }

        $fotoSKCK = $request->file('fotoSKCK');
        if (isset($fotoSKCK)) {
        $namaSKCK = 'SKCK-' . time() . $fotoSKCK->getClientOriginalName();
        $tujuan_upload = 'File_SKCK';
        $fotoSKCK->move($tujuan_upload, $namaSKCK);
        } else {

        }

        $fotoIjazah = $request->file('fotoIjazah');
        if (isset($fotoIjazah)) {
        $namaIjazah = 'Ijazah-' . time() . $fotoIjazah->getClientOriginalName();
        $tujuan_upload = 'File_Ijazah';
        $fotoIjazah->move($tujuan_upload, $namaIjazah);
        } else {
        
        }

        $fotoLamaran = $request->file('fotoLamaran');
        if (isset($fotoLamaran)) {
        $namaLamaran = 'Lamaran-' . time() . $fotoLamaran->getClientOriginalName();
        $tujuan_upload = 'File_Lamaran';
        $fotoLamaran->move($tujuan_upload, $namaLamaran);
        } else {

        }

        $fotoSuratPengalaman = $request->file('fotoSuratPengalaman');
        if (isset($fotoSuratPengalaman)) {
        $namaSuratPengalaman = 'Pengalaman-' . time() . $fotoSuratPengalaman->getClientOriginalName();
        $tujuan_upload = 'File_Pengalaman';
        $fotoSuratPengalaman->move($tujuan_upload, $namaSuratPengalaman);
        } else {

        }

        $fotoSuratPrestasi = $request->file('fotoSuratPrestasi');
        if (isset($fotoSuratPrestasi)) {
        $namaSuratPrestasi = 'Prestasi-' . time() . $fotoSuratPrestasi->getClientOriginalName();
        $tujuan_upload = 'File_Prestasi';
        $fotoSuratPrestasi->move($tujuan_upload, $namaSuratPrestasi);
        } else {

        }

        $fotoSuratPendidikan = $request->file('fotoSuratPendidikan');
        if (isset($fotoSuratPendidikan)) {
        $namaSuratPendidikan = 'Pendidikan-' . time() . $fotoSuratPendidikan->getClientOriginalName();
        $tujuan_upload = 'File_Pendidikan';
        $fotoSuratPendidikan->move($tujuan_upload, $namaSuratPendidikan);
        } else {

        }

        $fotoPerjanjianKerja = $request->file('fotoPerjanjianKerja');
        if (isset($fotoPerjanjianKerja)) {
        $namaPerjanjianKerja = 'PerjanjianKerja-' . time() . $fotoPerjanjianKerja->getClientOriginalName();
        $tujuan_upload = 'File_Perjanjian';
        $fotoPerjanjianKerja->move($tujuan_upload, $namaPerjanjianKerja);
        } else {

        }

        $fotoSuratPengangkatan = $request->file('fotoSuratPengangkatan');
        if (isset($fotoSuratPengangkatan)) {
        $namaPengangkatan = 'SuratPengangkatan-' . time() . $fotoSuratPengangkatan->getClientOriginalName();
        $tujuan_upload = 'File_Pengangkatan';
        $fotoSuratPengangkatan->move($tujuan_upload, $namaPengangkatan);
        } else {

        }

        $fotoSuratKeputusan = $request->file('fotoSuratKeputusan');
        if (isset($fotoSuratKeputusan)) {
        $namaKeputusan = 'SuratKeputusan-' . time() . $fotoSuratKeputusan->getClientOriginalName();
        $tujuan_upload = 'File_Keputusan';
        $fotoSuratKeputusan->move($tujuan_upload, $namaKeputusan);
        } else {

        }

        $file = array('id_pegawai' => $request->post('karyawan'),
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime()
        );

        if (isset($namaKtp) && !empty($namaKtp)) {
            $file['ktp'] = $namaKtp;
        }
        if (isset($namaKK) && !empty($namaKK)) {
            $file['kk'] = $namaKK;
        }
        if (isset($namaNPWP) && !empty($namaNPWP)) {
            $file['npwp'] = $namaNPWP;
        }
        if (isset($namaBPJSket) && !empty($namaBPJSket)) {
            $file['bpjs_ket'] = $namaBPJSket;
        }
        if (isset($namaBPJSkes) && !empty($namaBPJSkes)) {
            $file['bpjs_kes'] = $namaBPJSkes;
        }
        if (isset($namaAKDHK) && !empty($namaAKDHK)) {
            $file['as_akdhk'] = $namaAKDHK;
        }
        if (isset($namaTabungan) && !empty($namaTabungan)) {
            $file['buku_tabungan'] = $namaTabungan;
        }
        if (isset($namaSKCK) && !empty($namaSKCK)) {
            $file['skck'] = $namaSKCK;
        }
        if (isset($namaIjazah) && !empty($namaIjazah)) {
            $file['ijazah'] = $namaIjazah;
        }
        if (isset($namaLamaran) && !empty($namaLamaran)) {
            $file['lamaran'] = $namaLamaran;
        }
        if (isset($namaSuratPengalaman) && !empty($namaSuratPengalaman)) {
            $file['surat_pengalaman_kerja'] = $namaSuratPengalaman;
        }
        if (isset($namaSuratPrestasi) && !empty($namaSuratPrestasi)) {
            $file['surat_penghargaan'] = $namaSuratPrestasi;
        }
        if (isset($namaSuratPendidikan) && !empty($namaSuratPendidikan)) {
            $file['surat_pelatihan'] = $namaSuratPendidikan;
        }
        if (isset($namaPerjanjianKerja) && !empty($namaPerjanjianKerja)) {
            $file['surat_perjanjian_kerja'] = $namaPerjanjianKerja;
        }
        if (isset($namaPengangkatan) && !empty($namaPengangkatan)) {
            $file['surat_pengangkatan_kartap'] = $namaPengangkatan;
        }
        if (isset($namaKeputusan) && !empty($namaKeputusan)) {
            $file['surat_alih_tugas'] = $namaKeputusan;
        }

        File::insert($file);
        return redirect()->back();
    }
}
