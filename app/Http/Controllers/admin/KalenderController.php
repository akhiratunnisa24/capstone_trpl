<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use App\Models\Karyawan;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use App\Models\SettingHarilibur;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class KalenderController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;
        if($role != 5) 
        {
            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
            $id_pegawai = Auth::user()->id_pegawai;
            $getHarilibur = SettingHarilibur::all();
            foreach($getHarilibur as $harilibur)
            {
                $events[] = [
                    'date' => $harilibur->tanggal,
                    'title' => $harilibur->keterangan,
                    'type' => $harilibur->tipe,
                ];
               
            }
            // return $events;
           
            return view('admin.kalender.index',compact('row','id_pegawai','getHarilibur','role'));
        }else{
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        $kegiatan = new Kegiatan;
        $kegiatan->judul = $request->judul;
        $kegiatan->tglmulai = \Carbon\Carbon::createFromTimestamp(strtotime($request->input('tglmulai')))->format('Y-m-d H:i:s');
        $kegiatan->tglselesai = \Carbon\Carbon::createFromTimestamp(strtotime($request->input('tglselesai')))->format('Y-m-d H:i:s') ?? null;
        $kegiatan->id_pegawai = $request->id_pegawai;

        $kegiatan->save();
        // return redirect()->back();

        return redirect('/kalender')->with('pesan','Data berhasil disimpan !');
    }

    public function getHarilibur()
    {
        try {
            $getHarilibur = DB::table('setting_harilibur')->select('id', 'tanggal', 'tipe', 'keterangan')->get();
            $kegiatan = DB::table('kegiatan') ->select('id', 'tglmulai', 'judul', 'tglselesai','id_pegawai')
                ->where('id_pegawai', Auth::user()->id_pegawai)->get();

            //Menggabungkan kedua data
            $getData = collect($getHarilibur)->merge($kegiatan);

            //format data untuk dikembalikan sebagai respon json
            $events = $getData->map(function ($getData) {
                $event = [
                    'id' => $getData->id,
                    'type' => $getData->tipe ?? null,
                ];

                if(isset($getData->id_pegawai)) {
                    $event['user'] = $getData->id_pegawai ?? null;
                }

                if(isset($getData->keterangan))
                {
                    $event['title'] = $getData->keterangan;
                }elseif(isset($getData->judul))
                {
                    $event['title'] = $getData->judul;
                }

                if(isset($getData->tanggal))
                {
                    $event['start'] = $getData->tanggal;
                }elseif(isset($getData->tglmulai))
                {
                    $event['start'] = $getData->tglmulai;
                }

                if(isset($getData->tglselesai)) {
                    $event['end'] = $getData->tglselesai ?? null;
                }

                return $event;
            });

            return response()->json([
                'events' => $events,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function updatekegiatan(Request $request, $id)
    {
        $kegiatan = Kegiatan::findOrFail($id);
        $kegiatan->judul = $request->input('judul');
        $kegiatan->tglmulai = $request->input('tgl');
        $kegiatan->tglselesai = $request->input('end');
        $kegiatan->update();
        
        return redirect()->route('kegiatan.index')->with('success', 'Data kegiatan berhasil diupdate');
    }


    public function delete($id)
    {
        DB::table('kegiatan')->where('id', $id)->where('id_pegawai',Auth::user()->id_pegawai)->delete();
        return redirect('/kalender');
    }

    public function setting()
    {
        $role = Auth::user()->role;
        if ($role == 1 || $role == 2 || $role == 5) 
        {
            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
            $settingharilibur = SettingHarilibur::all();
            return view('admin.kalender.setting', compact('settingharilibur','row'));

        }else{
            return redirect()->back();
        }
    }

    // public function storeSettings(Request $request)
    // {
    //      $settingharilibur  = new SettingHarilibur;
    //      $settingharilibur ->tanggal = \Carbon\Carbon::parse($request->input('tanggal'))->format('Y-m-d');
    //      $settingharilibur ->tipe    = $request->input('tipe');
    //      $settingharilibur ->keterangan = $request->input('keterangan');
    //      $settingharilibur ->save();

    //      return redirect('/setting-kalender')->with('pesan','Data berhasil disimpan !');
    // }

    public function storeSetting(Request $request)
    {
        $request->validate([
            'tanggal' => 'required',
            'tipe' => 'required',
            'keterangan' => 'required',
        ]);
        $tanggal = \Carbon\Carbon::createFromFormat('d/m/Y', $request->tanggal)->format("Y-m-d");
        $keterangan = strtolower($request->input('keterangan'));

        // Cek apakah data dengan tanggal dan keterangan yang sama sudah ada di dalam tabel
        $existingData = SettingHarilibur::where('tanggal', $tanggal)
            ->whereRaw('LOWER(keterangan) = ?', [$keterangan])
            ->first();

        if ($existingData) {
            // Jika data sudah ada, kembalikan pesan bahwa data sudah ada dalam tabel
            return redirect()->back()->with('pesa', 'Data sudah ada dalam tabel!');
        } else {
            // Jika data belum ada, simpan data baru
            $settingharilibur = new SettingHarilibur;
            $settingharilibur->tanggal = $tanggal;
            $settingharilibur->tipe = $request->input('tipe');
            $settingharilibur->keterangan = $request->input('keterangan');
            $settingharilibur->save();

            return redirect()->back()->with('pesan', 'Data berhasil disimpan!');
        }
    }



    public function update(Request $request, $id)
    {
        // dd($request->all());
        $settingharilibur = array(
            'tanggal' => \Carbon\Carbon::parse($request->post('tanggal'))->format('Y-m-d'),
            'tipe'    => $request->post('tipe'),
            'keterangan'=>$request->post('keterangan'),
        );

        DB::table('setting_harilibur')->where('id',$id)->update($settingharilibur);
        return redirect('/manajemen-harilibur');
        
    }

    public function destroy($id)
    {
        DB::table('setting_harilibur')->where('id', $id)->delete();
        return redirect('/manajemen-harilibur');
    }

    // public function getDataHarilibur()
    // {
    //     $events = array();
    //     $settingharilibur = SettingHarilibur::all();
    //     if($settingharilibur->count())
    //     {
    //         foreach ($settingharilibur as $key => $value) {
    //             // $events[] = Calendar::event(
    //                 $value->keterangan,
    //                 true,
    //                 new \DateTime($value->tanggal),
    //                 new \DateTime($value->tanggal.' +1 day'),
    //                 null,
    //                 // Add color and link on event
    //                 [
    //                     'color' => '#f05050',
    //                     'url' => '#'
    //                 ]
    //             );
    //         }
    //     }
    //     $calendar = Calendar::addEvents($events);
    //     return $calendar->toJson();
    // }

}
