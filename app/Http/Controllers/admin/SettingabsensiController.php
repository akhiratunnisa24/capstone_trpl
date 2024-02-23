<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use App\Models\Settingabsensi;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SettingabsensiController extends Controller
{
    public function setting()
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $role = Auth::user()->role;
        if ($role == 1 || $role == 2) {
            $settingabsensi = Settingabsensi::where('partner',Auth::user()->partner)->get();
            return view('admin.settingabsensi.setting',compact('settingabsensi','row'));
        }
        else
        {
            return redirect()->back()->with('error','Anda tidak memiliki hak akses');
        }
    }

    public function store(Request $request)
    {
        $tipeAbsensi = $request->input('tipe');

        // Buat array untuk menyimpan data
        if($tipeAbsensi == 'Terlambat')
        {
            // Validasi data sesuai dengan tipe absensi yang dipilih
            $validatedData = $request->validate([
                'toleransi_terlambat' => $tipeAbsensi == 'Terlambat' ? 'required' : '',
                'jumlah_terlambat' => $tipeAbsensi == 'Terlambat' ? 'required' : '',
                'sanksi_terlambat' => $tipeAbsensi == 'Terlambat' ? 'required' : '',
            ]);

            $toleransiterlambat = Carbon::createFromFormat('H:i', $request->toleransi_terlambat)->format('H:i:s');
            $data = [
                'toleransi_terlambat' => $toleransiterlambat,
                'jumlah_terlambat'    => $request->jumlah_terlambat,
                'sanksi_terlambat'    => $request->sanksi_terlambat,
                'status_tidakmasuk'   => null,
                'jumlah_tidakmasuk'   => null,
                'sanksi_tidak_masuk'  => null,
                'partner' => Auth::user()->partner,
            ];

            $existingData = Settingabsensi::where('partner', $data['partner'])
                ->where('sanksi_terlambat', $data['sanksi_terlambat'])
                ->first();

            if ($existingData) {
                // Jika data sudah ada, berikan pesan error dan kembalikan ke halaman sebelumnya
                return redirect()->back()->with('error', 'Data Setting Absensi sudah ada.');
            }

            Settingabsensi::create($data);
            return redirect()->back()->with('success', 'Data Setting Absensi berhasil disimpan.');
        }
        elseif($tipeAbsensi == 'Tidak Masuk')
        {
            // Validasi data sesuai dengan tipe absensi yang dipilih
            $validatedData = $request->validate([
                'status_tidakmasuk' => $tipeAbsensi == 'Tidak Masuk' ? 'required' : '',
                'jumlah_tidakmasuk' => $tipeAbsensi == 'Tidak Masuk' ? 'required' : '',
                'sanksi_tidak_masuk' => $tipeAbsensi == 'Tidak Masuk' ? 'required' : '',
            ]);

            $data = [
                'toleransi_terlambat' => null ,
                'jumlah_terlambat'    => null,
                'sanksi_terlambat'    => null,
                'status_tidakmasuk'   =>  $request->status_tidakmasuk,
                'jumlah_tidakmasuk'   =>  $request->jumlah_tidakmasuk,
                'sanksi_tidak_masuk'  =>  $request->sanksi_tidak_masuk,
                'partner' => Auth::user()->partner,
            ];

            $existingData = Settingabsensi::where('partner', $data['partner'])
            ->where('sanksi_tidak_masuk', $data['sanksi_tidak_masuk'])
            ->first();

            if ($existingData) {
                // Jika data sudah ada, berikan pesan error dan kembalikan ke halaman sebelumnya
                return redirect()->back()->with('error', 'Data Setting Absensi sudah ada.');
            }
            Settingabsensi::create($data);
            return redirect()->back()->with('success', 'Data Setting Absensi berhasil disimpan.');
        }
        else{
            return redirect()->back()->with('error','Anda tidak memiliki hak akses');
        }
    }


    public function update(Request $request, $id)
    {
        $settingabsensi = Settingabsensi::find($id);
        $settingabsensi->update($request->all());

        return redirect()->back()->with('success','Data berhasil diupdate');
    }
}
