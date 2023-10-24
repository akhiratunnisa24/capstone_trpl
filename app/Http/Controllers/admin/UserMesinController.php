<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\GetUser;
use App\Models\UserMesin;
use App\Models\Karyawan;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Session;
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
        $errorMessage = Session::get('errorMessage');
        $role = Auth::user()->role;
        $user_mesin = GetUser::where('status', 0)->get();
        // Jika rolenya adalah 5, maka tampilkan semua data karyawan
        if ($role == 5) {
            $userMesins = UserMesin::with('karyawan','partners')->get();
            $karyawans = Karyawan::whereNotIn('id', UserMesin::pluck('id_pegawai'))->get();
        } else {
            // Jika bukan role 5, maka tampilkan data karyawan yang sesuai dengan partner
            $userMesins = UserMesin::with('karyawan','partners')->where('partner', Auth::user()->partner)->get();
            $karyawans = Karyawan::where('partner', Auth::user()->partner)
                        ->whereNotIn('id', UserMesin::pluck('id_pegawai'))->get();
        }

        return view('admin.datamaster.user_mesin.index', compact('userMesins', 'karyawans', 'row','errorMessage','role','user_mesin'));
    }


    public function store(Request $request)
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $request->validate([
            'id_pegawai' => 'required',
            'noid' => 'required',
            'noid2' => 'nullable', // Hapus validasi unique untuk noid2
            'partner' => 'required', // Tambahkan validasi untuk field "partner"
        ]);

        // Cek apakah data dengan noid2 sudah ada dengan karyawan lain
        $existingUserMesin = UserMesin::where('partner',$row->partner)
            ->where('noid', $request->noid)
            ->orWhere('noid2', $request->noid2)
            ->where('noid2','!=',null)
            ->first();

        // dd($existingUserMesin);
        // Proses penyimpanan data jika tidak ada data yang sama dengan noid2 pada karyawan lain
        $karyawan = Karyawan::find($request->id_pegawai);
        if (!$karyawan) {
            return back()->withErrors(['id_pegawai' => 'Karyawan tidak ditemukan.'])->withInput();
        }

        if(!$existingUserMesin)
        {
            $userMesin = new UserMesin([
                'id_pegawai' => $request->id_pegawai,
                'nik' => $karyawan->nip,
                'noid' => $request->noid,
                'noid2' => $request->noid2,
                'departemen' => $karyawan->departemen->id,
                'partner' => $karyawan->partner,
            ]);
            $userMesin->save();

            $getUser = GetUser::where('PIN', $request->noid)->first();
            if ($getUser) {
                $getUser->update(['status' => 1]);
            }

            return redirect()->route('user_mesin.index')->with('pesan', 'Data user mesin berhasil ditambahkan.');
        }else
        {
            $pesan = 'Data dengan Nomor ID tersebut sudah ada.';
            Session::flash('pesa', $pesan);
            return redirect()->back()->with('pesa',$pesan);
        }


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
        // dd($request);
        $request->validate([
            'noid2' => 'nullable|unique:user_mesin,noid2,'.$id.',id',
            'partner' => 'required',
        ]);

        if ($request->noid2) {
            $existingUserMesin = UserMesin::where('noid2', $request->noid2)
                ->where('id', '!=', $id)
                ->first();

            if ($existingUserMesin) {
                return redirect()->back()->with('error', 'Nilai Nomor ID 2 sudah digunakan oleh orang lain.');
            }
        }

        $userMesin = UserMesin::find($id);
        if (!$userMesin) {
            return redirect()->route('user_mesin.index')->with('error', 'Data user mesin tidak ditemukan.');
        }

        // $userMesin->noid = $request->noid;
        $userMesin->noid2 = $request->noid2;
        $userMesin->partner = $request->partner;


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
