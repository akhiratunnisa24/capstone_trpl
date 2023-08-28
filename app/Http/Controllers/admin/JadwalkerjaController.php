<?php

namespace App\Http\Controllers\admin;

use DateTime;
use Carbon\Carbon;
use App\Models\Shift;
use App\Models\Jadwal;
use App\Models\Partner;
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
            $jadwal = Jadwal::where('partner',Auth::user()->partner)->get();
            $karyawan= Karyawan::where('partner',Auth::user()->partner)->get();
            $shift= Shift::where('partner',Auth::user()->partner)->get();
            // dd($jadwal);
            $partner = Partner::where('id',Auth::user()->partner)->get();
            return view('admin.datamaster.jadwal.index', compact('jadwal','karyawan','role','shift','row','partner'));

        }
        elseif(($role == 5)||$role == 7)
        {
            $row    = Karyawan::where('id', Auth::user()->id_pegawai)->first();
            $jadwal = Jadwal::all();
            $karyawan= Karyawan::all();
            $shift= Shift::all();
            $partner = Partner::all();
            return view('admin.datamaster.jadwal.index', compact('jadwal','karyawan','role','shift','row','partner'));
        }
        else {

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
        $role = Auth::user()->role;

        // if($request->tipe_jadwal == 'bulanan')
        if($role == 1 || $role == 2)
        {
            if($request->tgl_mulai && $request->tgl_selesai)
            {
                $request->validate([
                    'id_shift'     => 'required',
                    'tgl_mulai'    => 'required',
                    'tgl_selesai'  => 'required',
                ]);

                    $tgl_mulai = Carbon::createFromFormat('d/m/Y', $request->tgl_mulai)->startOfDay();
                    $tgl_selesai = Carbon::createFromFormat('d/m/Y', $request->tgl_selesai)->startOfDay();

                    $tanggal_kerja = array();
                    while ($tgl_mulai->lte($tgl_selesai)) {
                        if ($tgl_mulai->isWeekday()) {
                            // Mengecek apakah tanggal ini merupakan hari libur
                            $is_hari_libur = SettingHarilibur::where('tanggal', $tgl_mulai->format('Y-m-d'))->exists();

                            if (!$is_hari_libur) {
                                $tanggal_kerja[] = $tgl_mulai->format('Y-m-d');
                            }
                        }
                        $tgl_mulai->addDay();
                    }
                    // dd($tanggal_kerja);
                    foreach($tanggal_kerja as $tanggal)
                    {
                        $jadwal = Jadwal::firstOrCreate([
                            'tanggal' => $tanggal,
                            'id_shift' => $request->id_shift,
                            'partner' => Auth::user()->partner
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
                // }
                return redirect('/jadwal')->with('pesan',$pesan);
            }else{
                $request->validate([
                    'id_shift'     => 'required',
                    'tanggal'      => 'required',
                ]);

                $jadwal = Jadwal::updateOrCreate(
                    [
                        'tanggal'    => \Carbon\Carbon::createFromFormat('d/m/Y', $request->tanggal)->format("Y-m-d"),
                        'id_shift'   => $request->id_shift,
                        'partner'    => Auth::user()->partner,
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
        }elseif($role == 5)
        {
            if($request->tgl_mulai && $request->tgl_selesai)
            {
                $request->validate([
                    'id_shift'     => 'required',
                    'tgl_mulai'    => 'required',
                    'tgl_selesai'  => 'required',
                ]);

                    $tgl_mulai = Carbon::createFromFormat('d/m/Y', $request->tgl_mulai)->startOfDay();
                    $tgl_selesai = Carbon::createFromFormat('d/m/Y', $request->tgl_selesai)->startOfDay();

                    $tanggal_kerja = array();
                    while ($tgl_mulai->lte($tgl_selesai)) {
                        if ($tgl_mulai->isWeekday()) {
                            // Mengecek apakah tanggal ini merupakan hari libur
                            $is_hari_libur = SettingHarilibur::where('tanggal', $tgl_mulai->format('Y-m-d'))->exists();

                            if (!$is_hari_libur) {
                                $tanggal_kerja[] = $tgl_mulai->format('Y-m-d');
                            }
                        }
                        $tgl_mulai->addDay();
                    }
                    // dd($tanggal_kerja);
                    foreach($tanggal_kerja as $tanggal)
                    {
                        $jadwal = Jadwal::firstOrCreate([
                            'tanggal' => $tanggal,
                            'id_shift' => $request->id_shift,
                            'partner' => $request->partner
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
                // }
                return redirect('/jadwal')->with('pesan',$pesan);
            }else{
                $request->validate([
                    'id_shift'     => 'required',
                    'tanggal'      => 'required',
                ]);
                $jadwal = Jadwal::updateOrCreate(
                    [
                        'tanggal'    => \Carbon\Carbon::createFromFormat('d/m/Y', $request->tanggal)->format("Y-m-d"),
                        'id_shift'   => $request->id_shift,
                        'partner'    => $request->partner
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
        }else
        {
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        $jadwal = Jadwal::find($id);
        // $jadwal->id_pegawai = $request->post('id_pegawai');
        $jadwal->id_shift = $request->post('id_shift');
        $jadwal->tanggal = \Carbon\Carbon::createFromFormat('d/m/Y', $request->post('tanggal'))->format('Y-m-d');
        $jadwal->jadwal_masuk = $request->post('jadwal_masuk');
        $jadwal->jadwal_pulang = $request->post('jadwal_pulang');

        $existingData = Jadwal::where('id_shift', $jadwal->id_shift)
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
