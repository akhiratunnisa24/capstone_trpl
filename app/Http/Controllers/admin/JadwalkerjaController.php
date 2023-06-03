<?php

namespace App\Http\Controllers\admin;

use DateTime;
use Carbon\Carbon;
use App\Models\Shift;
use App\Models\Jadwal;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use App\Models\SettingHarilibur;
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
        if ($role == 1 || $role == 2) 
        {
            $row    = Karyawan::where('id', Auth::user()->id_pegawai)->first();
            // $jadwal = Jadwal::all();
            $jadwal = Jadwal::with('karyawans')->get();
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
        // if($request->tipe_jadwal == 'bulanan')
        if($request->tgl_mulai && $request->tgl_selesai)
        {
            $request->validate([
                'id_shift'     => 'required',
                'tgl_mulai'    => 'required',
                'tgl_selesai'  => 'required',
            ]);

            $karyawan = Karyawan::all();
            foreach($karyawan as $data)
            {
                $tgl_mulai = Carbon::createFromFormat('Y/m/d', $request->tgl_mulai);
                $tgl_selesai = Carbon::createFromFormat('Y/m/d', $request->tgl_selesai);

                $tanggal_kerja = array();
                while($tgl_mulai->lte($tgl_selesai)){
                    if($tgl_mulai->isWeekday()){
                        $tanggal_kerja[] = $tgl_mulai->format('Y-m-d');
                    }
                    $tgl_mulai->addDay();
                }

                // Mengecek tanggal kerja yang tidak ada dalam tabel hari libur
                $tanggal_libur = SettingHarilibur::whereBetween('tanggal', [$request->tgl_mulai, $request->tgl_selesai])->get();
                foreach ($tanggal_libur as $libur) {
                    if (in_array($libur->tanggal, $tanggal_kerja)) {
                        $key = array_search($libur->tanggal, $tanggal_kerja);
                        if ($key !== false) {
                            unset($tanggal_kerja[$key]);
                        }
                    }
                }
                // dd($tanggal_kerja);
                foreach($tanggal_kerja as $tanggal)
                {

                    $jadwal = Jadwal::firstOrCreate([
                        'id_pegawai' => $data->id,
                        // 'tanggal' => Carbon::createFromFormat('d/m/Y', $tanggal)->format("Y-m-d"),
                        'id_shift' => $request->id_shift,
                    ], [
                        'jadwal_masuk' => $request->jadwal_masuk,
                        'jadwal_pulang' => $request->jadwal_pulang
                    ]);

                    if ($jadwal->wasRecentlyCreated) {
                        $pesan = 'Data berhasil disimpan !';
                    } else {
                        $pesan = 'Mohon maaf, Data sudah Ada!';
                    }
                }  
            }
            return redirect('/jadwal')->with('pesan',$pesan);
            
        }else{
            $request->validate([
                'id_pegawai'   => 'required',
                'id_shift'     => 'required',
                'tanggal'      => 'required',
            ]);

            $jadwal = Jadwal::updateOrCreate(
                [
                    'id_pegawai' => $request->id_pegawai, 
                    'tanggal'    => \Carbon\Carbon::createFromFormat('d/m/Y', $request->tanggal)->format("Y-m-d"),
                    'id_shift'   => $request->id_shift,
                ],
                [
                    'jadwal_masuk'  => $request->jadwal_masuk,
                    'jadwal_pulang' => $request->jadwal_pulang
                ]
            );
            // return $jadwal;
            
            if ($jadwal->wasRecentlyCreated) {
                return redirect('/jadwal')->with('pesan','Data berhasil disimpan !');
            } else {
                return redirect('/jadwal')->with('pesa','Data sudah ada !');
            }

        }  
    }
    
    public function update(Request $request, $id)
    {
        $jadwal = Jadwal::find($id);
        $jadwal->id_pegawai = $request->post('id_pegawai');
        $jadwal->id_shift = $request->post('id_shift');
        $jadwal->tanggal = \Carbon\Carbon::createFromFormat('d/m/Y', $request->post('tanggal'))->format('Y-m-d');
        $jadwal->jadwal_masuk = $request->post('jadwal_masuk');
        $jadwal->jadwal_pulang = $request->post('jadwal_pulang');

        $existingData = Jadwal::where('id_pegawai', $jadwal->id_pegawai)
                            ->where('id_shift', $jadwal->id_shift)
                            ->where('tanggal', $jadwal->tanggal)
                            ->exists();

        // dd( $jadwal,$existingData);
       if ($existingData) 
        {
            // Data sudah ada di database
            return redirect()->back()->with('pesa','Data sudah ada.');
        }

        $jadwal->update();

        return redirect()->back()->with('pesan', 'Data berhasil diupdate!');
    }
    
    public function destroy($id)
    {
        DB::table('jadwal')->where('id', $id)->delete();
        return redirect()->back();
    }

}
