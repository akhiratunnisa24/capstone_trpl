<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\UserMesin;
use App\Models\Karyawan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserMesinController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        // $userMesins = UserMesin::with('karyawan')->get();
        $userMesins = UserMesin::with('karyawan')
                       ->where('partner', Auth::user()->partner)
                       ->get();
        //$userMesins = UserMesin::with('karyawan')->where('karyawan.partner', Auth::user()->partner)->get();
        $karyawans = Karyawan::where('partner',Auth::user()->partner)
                    ->whereNotIn('id', UserMesin::pluck('id_pegawai'))->get();
        return view('admin.datamaster.user_mesin.index', compact('userMesins', 'karyawans','row'));
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'id_pegawai' => 'required',
            'noid' => 'required',
            'partner' => 'required', // Tambahkan validasi untuk field "partner"
        ]);

        $karyawan = Karyawan::find($request->id_pegawai);
        if (!$karyawan) {
            return redirect()->route('user_mesin.index')->with('error', 'Karyawan tidak ditemukan.');
        }

        $userMesin = new UserMesin([
            'id_pegawai' => $request->id_pegawai,
            'nik' => $karyawan->nip,
            'noid' => $request->noid,
            'departemen' => $karyawan->departemen->id,
            'partner' => $karyawan->partner, // Ambil nilai "partner" dari form
        ]);

        $userMesin->save();

        return redirect()->route('user_mesin.index')->with('success', 'Data user mesin berhasil ditambahkan.');
    }
    // =====================================Dropdown addModal=============================
    public function getKaryawanInfo($id)
    {
        $karyawan = Karyawan::find($id);
        if (!$karyawan) {
            return response()->json(['error' => 'Karyawan tidak ditemukan'], 404);
        }

        // Mengembalikan data karyawan dalam format JSON
        return response()->json([
            'nik' => $karyawan->nip,
            'departemen' => $karyawan->departemen->nama_departemen,
            'partner' => $karyawan->partner
        ]);
    }

    public function searchKaryawan(Request $request)
    {
        $term = $request->input('term');

        $karyawans = Karyawan::where('nama', 'LIKE', '%' . $term . '%')->get();

        return response()->json($karyawans);
    }
    // ===================================END Dropdown addModal==============================
    public function update(Request $request, $id)
    {
        
        $request->validate([
            'id_pegawai' => 'required',
            'noid' => 'required',
            'partner' => 'required', // Tambahkan validasi untuk field "partner"
        ]);
    
        $karyawan = Karyawan::find($request->id_pegawai);
        if (!$karyawan) {
            return redirect()->route('user_mesin.index')->with('error', 'Karyawan tidak ditemukan.');
        }
    
        $userMesin = UserMesin::find($id);
        if (!$userMesin) {
            return redirect()->route('user_mesin.index')->with('error', 'Data user mesin tidak ditemukan.');
        }
    
        $userMesin->id_pegawai = $request->id_pegawai;
        $userMesin->nik = $karyawan->nip;
        $userMesin->noid = $request->noid;
        $userMesin->departemen = $karyawan->departemen->id;
        $userMesin->partner = $karyawan->partner; // Ambil nilai "partner" dari form
        
        $userMesin->save();
    
        return redirect()->route('user_mesin.index')->with('success', 'Data user mesin berhasil diperbarui.');
    }
    


    public function destroy($id)
    {
        $userMesin = UserMesin::find($id);
        if (!$userMesin) {
            return redirect()->route('user_mesin.index')->with('error', 'Data user mesin tidak ditemukan.');
        }

        $userMesin->delete();

        return redirect()->route('user_mesin.index')->with('success', 'Data user mesin berhasil dihapus.');
    }
}