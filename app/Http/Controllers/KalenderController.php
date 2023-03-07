<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SettingHarilibur;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class KalenderController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;
        if ($role == 1) 
        {
            return view('admin.kalender.index');
        }else{
            return redirect()->back();
        }
    }

    public function setting()
    {
        $role = Auth::user()->role;
        if ($role == 1) 
        {
            $settingharilibur = SettingHarilibur::all();
            return view('admin.kalender.setting', compact('settingharilibur'));

        }else{
            return redirect()->back();
        }
    }

    public function storeSetting(Request $request)
    {
         $settingharilibur  = new SettingHarilibur;
         $settingharilibur ->tanggal = \Carbon\Carbon::parse($request->input('tanggal'))->format('Y-m-d');
         $settingharilibur ->keterangan = $request->input('keterangan');
         $settingharilibur ->save();

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $settingharilibur = array(
            'tanggal' => \Carbon\Carbon::parse($request->post('tanggal'))->format('Y-m-d'),
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

    public function getDataHarilibur()
    {
        $events = array();
        $settingharilibur = SettingHarilibur::all();
        if($settingharilibur->count())
        {
            foreach ($settingharilibur as $key => $value) {
                // $events[] = Calendar::event(
                    $value->keterangan,
                    true,
                    new \DateTime($value->tanggal),
                    new \DateTime($value->tanggal.' +1 day'),
                    null,
                    // Add color and link on event
                    [
                        'color' => '#f05050',
                        'url' => '#'
                    ]
                );
            }
        }
        $calendar = Calendar::addEvents($events);
        return $calendar->toJson();
    }

}
