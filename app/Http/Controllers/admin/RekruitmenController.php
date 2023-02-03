<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Lowongan;
use App\Models\Rekruitmen;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Mail\RekruitmenNotification;
use App\Models\MetodeRekruitmen;
use Illuminate\Support\Facades\Mail;

class RekruitmenController extends Controller
{
    // /**
    //  * Create a new controller instance.
    //  *
    //  * @return void
    //  */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    // /**
    //  * Display a listing of the resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    public function index()
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $posisi = Lowongan::all()->sortBy('status');
        $metode = MetodeRekruitmen::all();

        
        

        return view('admin.rekruitmen.index', compact('row', 'posisi', 'metode'));
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
        
        $user = new Lowongan([]);
        $user->posisi = $request->posisi;
        $user->tahapan = json_encode($request->input('tahapan', []));
        $user->jumlah_dibutuhkan = $request->jumlah_dibutuhkan;
        $user->status = 'Aktif';
        $user->persyaratan = $request->persyaratan;
        $user->save();

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
        $posisi = Lowongan::all();


        if ($role == 1) {

            $lowongan = lowongan::findOrFail($id);

            $totalTahap1 = Rekruitmen::all()
            ->where('id_lowongan', $id)
            ->where('status_lamaran', '=', 'tahap 1')
            ->count('posisi');

            $totalTahap2 = Rekruitmen::all()
            ->where('id_lowongan', $id)
            ->where('status_lamaran', '=', 'tahap 2')
            ->count('posisi');

            $totalTahap3 = Rekruitmen::all()
            ->where('id_lowongan', $id)
            ->where('status_lamaran', '=', 'tahap 3')
            ->count('posisi');

            $totalDiterima = Rekruitmen::all()
            ->where('id_lowongan', $id)
            ->where('status_lamaran', '=', 'Diterima')
            ->count('posisi');

            $dataTahap1 = Rekruitmen::where('id_lowongan', $id)
            ->where('status_lamaran', '=', 'tahap 1')
            ->get();

            $dataTahap2 = Rekruitmen::where('id_lowongan', $id)
            ->where('status_lamaran', '=', 'tahap 2')
            ->get();

            $dataTahap3 = Rekruitmen::where('id_lowongan', $id)
            ->where('status_lamaran', '=', 'tahap 3')
            ->get();

            $dataDiterima = Rekruitmen::where('id_lowongan', $id)
            ->where('status_lamaran', '=', 'Diterima')
            ->get();

           
            // dd($rekrutmen);




            return view('admin.rekruitmen.show', compact('totalDiterima','lowongan', 'totalTahap1', 'totalTahap2', 'totalTahap3', 'dataTahap1', 'dataTahap2', 'dataTahap3', 'row', 'dataDiterima', 'posisi'));

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
            ['status_lamaran' =>$request->post('status_lamaran')]
        );

        $data = Rekruitmen::findOrFail($id);
        $tujuan = $data->email;
        $email = new RekruitmenNotification($data);
        Mail::to($tujuan)->send($email);

        $rekrutmen = Rekruitmen::find($id);

        if ($rekrutmen->status_lamaran == 'Diterima') {
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

    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Lowongan::destroy($id);
        return redirect()->back();
        // return redirect('karyawan'); 
    }

    public function create_pelamar(Request $request)

    {
        // $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $posisi = Lowongan::all()->where('status','=','Aktif');
        $openRekruitmen = Lowongan::where('status', 'Aktif')->get();

        if ($openRekruitmen->count() > 0) {
            return view('admin.rekruitmen.formPelamar', compact( 'posisi'))->with('success', 'Data berhasil disimpan.') ;
        }

        return view('admin.rekruitmen.viewTidakAdaLowongan');
    }

    public function store_pelamar(Request $request)
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
        $user->cv = $namaFile ;

      

        $user->save();

        return redirect('show_formSelesai');
    }

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
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $metode = MetodeRekruitmen::all();



        return view('admin.rekruitmen.createMetode', compact('row', 'metode'));
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
