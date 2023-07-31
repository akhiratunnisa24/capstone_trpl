<?php

namespace App\Http\Controllers\superadmin;

use TADPHP\TADFactory;
use App\Models\Partner;
use App\Models\Karyawan;
use App\Models\Listmesin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ListmesinController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $role = Auth::user()->role;
        if ($role == 5) {

            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
            $listmesin = Listmesin::with('partners')->orderBy('id', 'asc')->get();
            $partner = Partner::all();
            return view('superadmin.listmesin.index', compact('listmesin', 'row','partner'));
        } else {

            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_mesin' => 'required',
            'ip_mesin'  => 'required',
            'port' => 'required',
            'comm_key' => 'required',
            'partner' => 'required'
        ]);

        // Cek apakah data Listmesin sudah ada di dalam database
        $listmesin = Listmesin::where('ip_mesin',$request->ip_mesin)->first();
    
        if ($listmesin) {
            // Jika data Listmesin sudah ada, kembalikan pesan bahwa data sudah ada
            return redirect()->back()->with('pesa', 'Data List Mesin dengan IP :  ' . $request->ip_mesin . ' sudah ada !');
        } else {
            // Jika data Listmesin belum ada, simpan data baru
            $listmesin = new Listmesin;
            $listmesin->nama_mesin  = $request->nama_mesin;
            $listmesin->ip_mesin    = $request->ip_mesin;
            $listmesin->port        = $request->port;
            $listmesin->comm_key    = $request->comm_key;
            $listmesin->partner     = $request->partner;
            $listmesin->status      = 0;
            $listmesin->save();
    
            return redirect()->back()->with('pesan', 'Data berhasil disimpan!');
        }
    }

    public function update(Request $request, $id)
    {
        $role = Auth::user()->role;
        if ($role == 5) 
        {
            $listmesin = Listmesin::find($id);
            
            $listmesin->nama_mesin  = $request->nama_mesin;
            $listmesin->ip_mesin    = $request->ip_mesin;
            $listmesin->port        = $request->port;
            $listmesin->comm_key    = $request->comm_key;
            $listmesin->partner     = $request->partner;
            $listmesin->status      = 0;

            $listmesin->update();

            return redirect()->back()->with('pesan','Data berhasil diupdate !');
        }else{
            return redirect()->back();
        }
    }

    public function connect($id)
    {
        try {
             // $ip ='192.168.1.8';
            // $com_key = 0;
            $mesin = Listmesin::find($id);
            $ip = $mesin->ip_mesin;
            $com_key = $mesin->comm_key;

            $tad = (new TADFactory(['ip' => $ip, 'com_key' => $com_key]))->get_instance();
            $con = $tad->is_alive();

            if ($con) {
                $mesin->status = 1;
                $mesin->update();
                return response()->json(['message' => 'Berhasil terkoneksi ke mesin absensi ' . $ip]);
            } else {
                return response()->json(['message' => 'Koneksi ke ' . $ip . ' Gagal']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error: ' . $e->getMessage()]);
        }
    }


    // public function destroy($id)
    // {
    //     $listmesin = Listmesin::find($id);
    
    //     // Cek data ke tabel "karyawan"
    //     $karyawan = Karyawan::where('Listmesin', $listmesin->id)->first();
    //     if ($karyawan !== null) {
    //         return redirect()->back()->with('pesa', 'Listmesin tidak dapat dihapus karena digunakan dalam tabel karyawan.');
    //     } else {
    //         $listmesin->delete();
    //         return redirect()->back()->with('pesan', 'Data Listmesin berhasil dihapus');
    //     }
    // }
}

