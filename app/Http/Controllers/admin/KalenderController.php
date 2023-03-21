<?php

namespace App\Http\Controllers\admin;

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
        if ($role == 1) 
        {
            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
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
           
            return view('admin.kalender.index',compact('row','getHarilibur'),['events'=>$events]);
        }else{
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        $kegiatan = new Kegiatan;
        $kegiatan->judul = $request->judul;
        $kegiatan->tglmulai = $request->tglmulai;
        $kegiatan->tglselesai = $request->tglselesai;
        $kegiatan->id_pegawai = $request->id_pegawai;
    
        return $kegiatan;

        $kegiatan->save();

        return response()->json(['success'=>'Data berhasil disimpan']);
    }

    public function getHarilibur()
    {
        try {
            $getHarilibur = SettingHarilibur::select('id', 'tanggal','tipe', 'keterangan')
                ->get();

            if (!$getHarilibur) {
                throw new \Exception('Data not found');
            }

            $events = [];

            foreach ($getHarilibur as $harilibur) {
                $events[] = [
                    'title' => $harilibur->keterangan,
                    'start' => $harilibur->tanggal,
                    'type' => $harilibur->tipe,
                ];
            }

            return response()->json([
                'events' => $events,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }


    // public function getHarilibur()
    // {
    //     try {
    //         $getHarilibur = SettingHarilibur::select('id', 'tanggal','tipe', 'keterangan')->get();
            
    //         if (!$getHarilibur) {
    //             throw new \Exception('Data not found');
    //         }
    //         return response()->json($getHarilibur, 200);
    //     //     return response()->json([
    //     //         'events' => $getHarilibur,
    //     //    ], 200);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'message' => $e->getMessage()
    //         ], 500);
    //     }
    // }

    public function setting()
    {
        $role = Auth::user()->role;
        if ($role == 1) 
        {
            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
            $settingharilibur = SettingHarilibur::all();
            return view('admin.kalender.setting', compact('settingharilibur','row'));

        }else{
            return redirect()->back();
        }
    }

    public function storeSetting(Request $request)
    {
         $settingharilibur  = new SettingHarilibur;
         $settingharilibur ->tanggal = \Carbon\Carbon::parse($request->input('tanggal'))->format('Y-m-d');
         $settingharilibur ->tipe    = $request->input('tipe');
         $settingharilibur ->keterangan = $request->input('keterangan');
         $settingharilibur ->save();

        return redirect()->back();
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
        return redirect('/setting-kalender');
        
    }

    public function destroy($id)
    {
        DB::table('setting_harilibur')->where('id', $id)->delete();
        return redirect('/setting-kalender');
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
