<?php

namespace App\Http\Controllers\admin;

use App\Models\Shift;
use App\Models\Jadwal;
use App\Models\Partner;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ShiftController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $role = Auth::user()->role;
        if ($role == 1 || $role == 2)
        {
            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
            $shift = DB::table('shift')->where('partner',Auth::user()->partner)->get();
            // dd($shift);
            $partner = Partner::all();
            return view('admin.datamaster.shift.index', compact('shift', 'row','role','partner'));

        }elseif(($role == 5)||$role == 7)
        {
            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
            $shift = DB::table('shift')->get();
            if($role == 7)
            {
                $shift = Shift::where('partner',Auth::user()->partner)->get();
            }
            $partner = Partner::all();
            // dd($shift);
            return view('admin.datamaster.shift.index', compact('shift', 'row','role','partner'));
        }
        else {

            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_shift' => 'required',
            'jam_masuk' => 'required',
            'jam_pulang' => 'required',
            'partner' => 'required',
        ]);

        $nama_shift = $request->nama_shift;
        $jam_masuk = \Carbon\Carbon::parse($request->jam_masuk)->format('H:i:s');
        $jam_pulang = \Carbon\Carbon::parse($request->jam_pulang)->format('H:i:s');
        $partner = $request->partner;
        // Cek apakah data shift sudah ada di dalam database
        $shift = DB::table('shift')
            ->where('nama_shift', $nama_shift)
            ->where('jam_masuk', $jam_masuk)
            ->where('jam_pulang', $jam_pulang)
            ->where('partner', $partner)
            ->first();

        if ($shift) {
            // Jika data shift sudah ada, kembalikan pesan bahwa data sudah ada
            return redirect()->back()->with('pesa', 'Data Shift sudah ada !');
        } else {
            // Jika data shift belum ada, simpan data baru
            $shiftData = array(
                'id_pegawai' => NULL,
                'nama_shift' => $nama_shift,
                'jam_masuk' => $jam_masuk,
                'jam_pulang' => $jam_pulang,
                'partner' => $partner
            );

            DB::table('shift')->insert($shiftData);

            return redirect()->back()->with('pesan', 'Data berhasil disimpan!');
        }
    }

    public function update(Request $request, $id)
    {
        // $shift = Shift::find($id);
        $shift = array(
            'id_pegawai' => NULL,
            'nama_shift' => $request->post('nama_shift'),
            'jam_masuk' => \Carbon\Carbon::parse($request->post('jam_masuk'))->format('H:i:s'),
            'jam_pulang' => \Carbon\Carbon::parse($request->post('jam_pulang'))->format('H:i:s')
        );
        // dd($shift);
        DB::table('shift')->where('id',$id)->update($shift);
        return redirect()->back()->with('pesan','Data berhasil diupdate !');;
    }

    public function destroy($id)
    {
        $shift = Shift::find($id);

        $jadwal = Jadwal::where('id_shift', $id)->first();
        if ($jadwal != null) {
            return redirect()->back()->with('pesa', 'Shift tidak dapat dihapus karena digunakan pada Jadwal');
        } else {
            $shift->delete();
            return redirect()->back()->with('pesan', 'Shift berhasil dihapus');
        }
    }

}
