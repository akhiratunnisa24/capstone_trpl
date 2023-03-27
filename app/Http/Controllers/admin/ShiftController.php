<?php

namespace App\Http\Controllers\admin;

use App\Models\Shift;
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
        if ($role == 1) 
        {
            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
            $shift = DB::table('shift')->get();
            // dd($shift);
            return view('admin.datamaster.shift.index', compact('shift', 'row'));

        } else {
    
            return redirect()->back();
        }
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nama_shift' => 'required',
            'jam_masuk' => 'required',
            'jam_pulang' => 'required',
        ]);
        $shift = array(
            'id_pegawai' => NULL,
            'nama_shift' => $request->post('nama_shift'),
            'jam_masuk' => \Carbon\Carbon::parse($request->post('jam_masuk'))->format('H:i:s'),
            'jam_pulang' => \Carbon\Carbon::parse($request->post('jam_pulang'))->format('H:i:s')
        );
        // dd($shift);
        DB::table('shift')->insert($shift);
        return redirect('/shift')->with('pesan','Data berhasil disimpan !');
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
