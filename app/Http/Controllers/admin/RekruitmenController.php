<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Lowongan;
use App\Models\Rekruitmen;
use App\Models\Departemen;
use App\Models\Alokasicuti;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Mail\RekruitmenNotification;
use App\Models\Kdarurat;
use App\Models\Keluarga;
use App\Models\MetodeRekruitmen;
use App\Models\NamaTahap;
use App\Models\Rorganisasi;
use App\Models\Rpekerjaan;
use App\Models\Rpendidikan;
use App\Models\Rprestasi;
use App\Models\StatusRekruitmen;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use PDF;


class RekruitmenController extends Controller
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

    /**2
     */
    public function index()
    {
        $role = Auth::user()->role;
        if ($role == 1) {

            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
            $posisi = Lowongan::all()->sortByDesc('created_at');
            $metode = MetodeRekruitmen::where('status', '=', 'Aktif')->get();


            //pengecekan ke data cuti apakah ada atau tidak

            // $alokasicuti = Alokasicuti::where('id_jeniscuti', '=', 1)
            //     ->first();

            // dd($alokasicuti);



            return view('admin.rekruitmen.index', compact('row', 'posisi', 'metode'));
        } else {

            return redirect()->back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $user = new Lowongan();
        $user->posisi = $request->posisi;
        $user->jumlah_dibutuhkan = $request->jumlah_dibutuhkan;
        $user->status = 'Aktif';
        $user->tgl_mulai =  Carbon::parse($request->tglmulai)->format("Y-m-d");
        $user->tgl_selesai =  Carbon::parse($request->tglselesai)->format("Y-m-d");
        $user->persyaratan = $request->persyaratan;
        $user->save();

        $checkbox = $request->tahapan;
        $data = [];
        $data[] = [
            'id_lowongan' => $user->id,
            'id_mrekruitmen' => 1
        ];

        foreach ($checkbox as $value) {
            $data[] = [
                'id_lowongan' => $user->id,
                'id_mrekruitmen' => $value
            ];
        }

        $data[] = [
            'id_lowongan' => $user->id,
            'id_mrekruitmen' => 6
        ];
        DB::table('namatahapan')->insert($data);


        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Auth::user()->role;
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $posisi = NamaTahap::with('mrekruitmen')
            ->where('id_lowongan', $id)
            // ->orderBy('id', 'desc')
            ->get();

        $metode = NamaTahap::with('mrekruitmen')
            ->where('id_lowongan', $id)->get();

        if ($role == 1) {

            $lowongan = lowongan::findOrFail($id);

            $totalTahap1 = Rekruitmen::all()
                ->where('id_lowongan', $id)
                ->where('status_lamaran', '=', '1')
                ->count('posisi');

            $totalTahap2 = Rekruitmen::all()
                ->where('id_lowongan', $id)
                ->where('status_lamaran', '=', 'Interview ke-1')
                ->count('posisi');

            $totalTahap3 = Rekruitmen::all()
                ->where('id_lowongan', $id)
                ->where('status_lamaran', '=', 'Psikotest')
                ->count('posisi');

            $totalDiterima = Rekruitmen::all()
                ->where('id_lowongan', $id)
                ->where('status_lamaran', '=', '2')
                ->count('posisi');

            // Show data Kanidat di Tahap 1
            $dataTahap1 = Rekruitmen::with('mrekruitmen')->where('id_lowongan', $id)
                ->where('status_lamaran', '=', '1')
                ->get();
            // // Data Keluarga show di Modal
            // foreach ($dataTahap1 as $data) {

            //     $dataKeluarga = Keluarga::where('id_pelamar', $data->id)
            //         ->get();

            //     // $dataKeluarga = Keluarga::leftjoin('rekruitmen', 'keluarga.id_pelamar', 'rekruitmen.id')
            //     // ->select('keluarga.*', 'rekruitmen.id_lowongan as id_rekruitmen')
            //     // ->where('rekruitmen.id_lowongan', '=', $data->id_lowongan)
            //     // ->get();
            // }
            // // Data Riwayat Pendidikan show di Modal
            // foreach ($dataTahap1 as $data) {

            //     $dataPendidikan = Rpendidikan::where('id_pelamar', $data->id)
            //         ->get();
            // }
            // // Data Riwayat Pekerjaan show di Modal
            // foreach ($dataTahap1 as $data) {

            //     $dataPekerjaan = Rpekerjaan::where('id_pelamar', $data->id)
            //     ->get();
            // }
            // foreach ($dataTahap1 as $data) {

            //     $dataOrganisasi = Rorganisasi::where('id_pelamar', $data->id)
            //     ->get();
            // }
            // foreach ($dataTahap1 as $data) {

            //     $dataPrestasi = Rprestasi::where('id_pelamar', $data->id)
            //     ->get();
            // }
            // foreach ($dataTahap1 as $data) {

            //     $dataKdarurat = Kdarurat::where('id_pelamar', $data->id)
            //     ->get();
            // }

            $dataTahap2 = Rekruitmen::with('mrekruitmen', 'namatahap')->where('id_lowongan', $id)
                ->where('status_lamaran', '=', '2')
                ->get();

            $dataTahap3 = Rekruitmen::with('mrekruitmen')->where('id_lowongan', $id)
                ->where('status_lamaran', '=', '3')
                ->get();

            $dataTahap4 = Rekruitmen::with('mrekruitmen')->where('id_lowongan', $id)
                ->where('status_lamaran', '=', '4')
                ->get();

            $dataTahap5 = Rekruitmen::with('mrekruitmen')->where('id_lowongan', $id)
                ->where('status_lamaran', '=', '5')
                ->get();

            $dataDiterima = Rekruitmen::with('mrekruitmen')->where('id_lowongan', $id)
                ->where('status_lamaran', '=', '6')
                ->get();



            return view('admin.rekruitmen.show', compact(
                'totalDiterima',
                'lowongan',
                'totalTahap1',
                'totalTahap2',
                'totalTahap3',
                'dataTahap1',
                'dataTahap2',
                'dataTahap3',
                'dataTahap4',
                'dataTahap5',
                'row',
                'dataDiterima',
                'posisi',
                'metode',
                // 'dataKeluarga',
                // 'dataPendidikan',
                // 'dataPekerjaan',
                // 'dataOrganisasi',
                // 'dataKdarurat',
                // 'dataPrestasi',
            ));
        } else {

            return redirect()->back();
        }
    }

    // show identitas terbaru
    public function showkanidat($id)
    {
        $role = Auth::user()->role;

        if ($role == 1) {

            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
            $pelamar = Rekruitmen::findOrFail($id);
            $datakeluarga = Keluarga::where('id_pelamar', $id)->get();
            $kontakdarurat = Kdarurat::where('id_pelamar', $id)->get();
            $pendidikan = Rpendidikan::where('id_pelamar', $id)->get();
            $pekerjaan = Rpekerjaan::where('id_pelamar', $id)->get();
            $organisasi = Rorganisasi::where('id_pelamar', $id)->get();
            $prestasi = Rprestasi::where('id_pelamar', $id)->get();


            $output = [
                'row' => $row,
                'pelamar' => $pelamar,
                'datakeluarga' => $datakeluarga,
                'kontakdarurat' => $kontakdarurat,
                'pendidikan' => $pendidikan,
                'pekerjaan' => $pekerjaan,
                'organisasi' => $organisasi,
                'prestasi' => $prestasi,
            ];
            return view('admin.rekruitmen.previewKanidat', $output);
        } else {

            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        Rekruitmen::where('id', $id)->update(
            [
                'status_lamaran' => $request->post('status_lamaran'),
                'tanggal_tahapan' => $request->post('tgl_tahapan'),

            ]
        );

        $data = Rekruitmen::findOrFail($id);
        $tujuan = $data->email;
        $email = new RekruitmenNotification($data);
        Mail::to($tujuan)->send($email);

        $rekrutmen = Rekruitmen::find($id);

        if ($rekrutmen->status_lamaran == '6') {
            $lowongan = Lowongan::find($rekrutmen->id_lowongan);
            $lowongan->jumlah_dibutuhkan--;
            if ($lowongan->jumlah_dibutuhkan == 0) {
                $lowongan->status = 'Tidak Aktif';
            }
            $lowongan->save();

            // setelah karyawan diterima masuk ke tabel karyawan

            // $karyawan = new Karyawan();
            // $karyawan->nik = $rekrutmen->nik;
            // $karyawan->tgllahir = $rekrutmen->tgllahir;
            // $karyawan->email = $rekrutmen->email;
            // $karyawan->agama = $rekrutmen->tgllahir;
            // $karyawan->jenis_kelamin = $rekrutmen->jenis_kelamin;
            // $karyawan->alamat = $rekrutmen->alamat;
            // $karyawan->no_hp = $rekrutmen->no_hp;
            // $karyawan->no_kk = $rekrutmen->no_kk;
            // $karyawan->jabatan = $lowongan->jabatan;
            // $karyawan->save();
        }


        return redirect()->back();
    }

    public function rekrutmenupdate(Request $request, $id)
    {

        Lowongan::where('id', $id)->update(
            [
                'jumlah_dibutuhkan' => $request->post('jumlahDibutuhkan'),
                'status' => $request->post('statusLowongan'),
                'tgl_mulai' => $request->post('tglmulai'),
                'tgl_selesai' => $request->post('tglselesai'),

            ]
        );
        return redirect()->back();
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Lowongan::destroy($id);

        $lowongan = Lowongan::find($id);

        // hapus file pdf jika terkait dengan rekruitmen
        // $rekruitmen = $lowongan->rekruitmen2;
        // if ($rekruitmen->cv) {
        //     $pdf_path = public_path('pdf/' . $rekruitmen->cv);
        //     if (file_exists($pdf_path)) {
        //         unlink($pdf_path);
        //     }
        // }

        $rekruitmen = $lowongan->rekruitmen2;
        if ($rekruitmen && $rekruitmen->cv) {
            $pdf_path = public_path('pdf/' . $rekruitmen->cv);
            if (file_exists($pdf_path)) {
                unlink($pdf_path);
            }
        } else {
            // Tidak ada cv terkait dengan rekruitmen
        }

        $lowongan->namatahap()->delete();
        $lowongan->rekruitmen2()->delete();
        $lowongan->delete();

        return redirect()->back();
        // return redirect('karyawan'); 
    }

    // public function create_pelamar(Request $request)

    // {
    //     // $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
    //     $posisi = Lowongan::all()->where('status','=','Aktif');
    //     $openRekruitmen = Lowongan::where('status', 'Aktif')->get();

    //     if ($openRekruitmen->count() > 0) {
    //         return view('admin.rekruitmen.formPelamar', compact( 'posisi'))->with('success', 'Data berhasil disimpan.') ;
    //     }

    //     return view('admin.rekruitmen.viewTidakAdaLowongan');
    // }

    // public function store_pelamar(Request $request)
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
    //     $user->status_lamaran = 'tahap 1';
    //     $user->cv = $namaFile ;



    //     $user->save();

    //     return redirect('show_formSelesai');
    // }

    public function showPdf($id)
    {
        $pelamar = Rekruitmen::findOrFail($id);
        $path = storage_path('pdf/' . $id);
        return response()->file($id);
    }

    public function formSelesai()
    {
        return view('admin.rekruitmen.formSelesaiPelamar');
    }

    public function show_kanidat($id)
    {
        $role = Auth::user()->role;
        if ($role == 1) {

            $lowongan = Rekruitmen::findOrFail($id);
            // dd($karyawan);

            return view('admin.rekruitmen.showKanidat', compact('lowongan'));
        } else {

            return redirect()->back();
        }
    }
    public function create_metode()
    {
        $role = Auth::user()->role;
        if ($role == 1) {

            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
            $metode = MetodeRekruitmen::all();



            return view('admin.rekruitmen.createMetode', compact('row', 'metode'));
        } else {

            return redirect()->back();
        }
    }

    public function store_metode_rekrutmen(Request $request)
    {

        $user = new MetodeRekruitmen();
        $user->nama_tahapan = $request->namaTahapan;
        $user->save();

        return redirect()->back();
    }

    public function update_metode_rekrutmen(Request $request, $id)
    {

        MetodeRekruitmen::where('id', $id)->update(
            ['nama_tahapan' => $request->post('namaTahapan')]
        );

        return redirect()->back();
    }

    public function metode_rekrutmen_destroy($id)
    {
        MetodeRekruitmen::destroy($id);

        return redirect()->back();
        // return redirect('karyawan'); 
    }
}
