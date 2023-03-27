<?php

namespace App\Http\Controllers\admin;

use App\Models\Shift;
use App\Models\Jadwal;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class JadwalkerjaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request)
    {
        $role = Auth::user()->role;
        if ($role == 1) 
        {
            $row    = Karyawan::where('id', Auth::user()->id_pegawai)->first();
            $jadwal = Jadwal::all();

            $karyawan= Karyawan::all();
            $shift= Shift::all();
            // dd($jadwal);
            return view('admin.datamaster.jadwal.index', compact('jadwal','karyawan','shift','row'));

        } else {
    
            return redirect()->back();
        }
    }

    public function getShift(Request $request)
    {
        try {
            $getShift = Shift::select('id','jam_masuk','jam_pulang')
                ->where('id','=',$request->id_shift)
                ->first();

            if(!$getShift) {
                throw new \Exception('Data not found');
            }
            return response()->json($getShift,200);
            
        } catch (\Exception $e){
            return response()->json([
                'message' =>$e->getMessage()
            ], 500);
        } 
    }
    
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'id_pegawai'   => 'required',
            'id_shift'     => 'required',
            'tanggal'      => 'required',
        ]);

        $jadwal = new Jadwal;
        $jadwal->id_pegawai   = $request->id_pegawai;
        $jadwal->id_shift     = $request->id_shift;
        $jadwal->tanggal      = $request->tanggal;
        $jadwal->jadwal_masuk = $request->jadwal_masuk;
        $jadwal->jadwal_pulang= $request->jadwal_pulang;
        $jadwal->save();

        return redirect('/jadwal')->with('pesan','Data berhasil disimpan !');
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
        return redirect()->back();
    }
    
    public function destroy($id)
    {
        DB::table('shift')->where('id', $id)->delete();
        return redirect('/shift');
    }

}
