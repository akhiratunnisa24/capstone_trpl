<?php

namespace App\Http\Controllers\superadmin;

use Carbon\Carbon;
use App\Models\Jadwal;
use TADPHP\TADFactory;
use App\Models\Absensi;
use App\Models\Partner;
use App\Models\Karyawan;
use App\Models\Listmesin;
use App\Models\UserMesin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ListmesinController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $role = Auth::user()->role;
        if ($role == 5) 
        {
            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
            $listmesin = Listmesin::with('partners')->orderBy('id', 'asc')->get();
            $partner = Partner::all();
            return view('superadmin.listmesin.index', compact('listmesin', 'row','partner'));
        } else {

            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_mesin' => 'required',
            'ip_mesin'  => 'required',
            'port' => 'required',
            'comm_key' => 'required',
            'partner' => 'required'
        ]);

        // Cek apakah data Listmesin sudah ada di dalam database
        $listmesin = Listmesin::where('ip_mesin',$request->ip_mesin)->first();
    
        if ($listmesin) {
            // Jika data Listmesin sudah ada, kembalikan pesan bahwa data sudah ada
            return redirect()->back()->with('pesa', 'Data List Mesin dengan IP :  ' . $request->ip_mesin . ' sudah ada !');
        } else {
            // Jika data Listmesin belum ada, simpan data baru
            $listmesin = new Listmesin;
            $listmesin->nama_mesin  = $request->nama_mesin;
            $listmesin->ip_mesin    = $request->ip_mesin;
            $listmesin->port        = $request->port;
            $listmesin->comm_key    = $request->comm_key;
            $listmesin->partner     = $request->partner;
            $listmesin->status      = 0;
            $listmesin->save();
    
            return redirect()->back()->with('pesan', 'Data berhasil disimpan!');
        }
    }

    public function update(Request $request, $id)
    {
        $role = Auth::user()->role;
        if ($role == 5) 
        {
            $listmesin = Listmesin::find($id);
            
            $listmesin->nama_mesin  = $request->nama_mesin;
            $listmesin->ip_mesin    = $request->ip_mesin;
            $listmesin->port        = $request->port;
            $listmesin->comm_key    = $request->comm_key;
            $listmesin->partner     = $request->partner;
            $listmesin->status      = 0;

            $listmesin->update();

            return redirect()->back()->with('pesan','Data berhasil diupdate !');
        }else{
            return redirect()->back();
        }
    }

    public function connect(Request $request, $id)
    {
        try {
            $mesin = Listmesin::find($id);
            $ip = $mesin->ip_mesin;
            $com_key = $mesin->comm_key;
            $soap_port = $mesin->port;
    
            $tad = (new TADFactory(['ip' => $ip, 'com_key' => $com_key,'soap_port' => $soap_port]))->get_instance();
            $con = $tad->is_alive();

            if ($con) {
                $mesin->status = 1;
                $mesin->update();
                return 'Berhasil terkoneksi ke mesin absensi ' . $ip;
            } else {
                return 'Koneksi ke ' . $ip . ' Gagal';
            }
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage() . "\n";
        }
        
    }

    public function tarikAbsen($id)
    {
        try {
            $mesin = Listmesin::find($id);
            $ip = $mesin->ip_mesin;
            $com_key = $mesin->comm_key;
            $soap_port = $mesin->port;
            $partner = $mesin->partner;

            $tad = (new TADFactory(['ip' => $ip, 'com_key' => $com_key,'soap_port' => $soap_port]))->get_instance();
            $con = $tad->is_alive();
            if ($con) 
            {
                $attendance = $tad->get_att_log();
                if ($attendance) 
                {
                    $filtered_attendance = $attendance->filter_by_date(
                        ['start' => '2023-02-28']
                    );
                    
                    $j = $filtered_attendance->get_response(['format' => 'json']);
                    // $j = $attendance->get_response(['format' => 'json']);
                    $jArray = json_decode($j, true);
                    // dd($jArray);

                    $usermesin = UserMesin::where('partner',$partner)->get();
                   
                    // Loop melalui data $jArray untuk mencocokkan nilai PIN
                    foreach ($jArray['Row'] as $data) 
                    {
                        $pin = $data['PIN'];
                        $datetime = Carbon::parse($data['DateTime']);
                        $tanggal = $datetime->format('Y-m-d');
                        $jam = $datetime->format('H:i:s');

                        $matchedUser = $usermesin->where('noid', $pin)->first();
                        if (isset($matchedUser)) 
                        {
                            $jadwals = Jadwal::where('tanggal', $tanggal)->where('partner', Auth::user()->partner)->get();
                            // dd($data,$matchedUser,$jadwal);
                            foreach ($jadwals as $jadwal) 
                            {
                                if($jadwal)
                                {
                                    $existingAbsensi = Absensi::where('id_karyawan', $matchedUser->id_pegawai)
                                                    ->where('tanggal', $tanggal)->where('partner', $matchedUser->partner)
                                                    ->whereNotNull('jam_masuk')->first();
                                    if($existingAbsensi)
                                    {
                                        $jadwal_masuk  = $jadwal->jadwal_masuk;
                                        $jadwal_pulang = $jadwal->jadwal_pulang;
                                        $jam_keluar    = Carbon::createFromFormat('H:i:s', $jam);

                                        //jika data ada lakukan pembaruan data, karena ada absensi yang terdapat 2 record data
                                        $absensi = $existingAbsensi;
                                        $absensi->jam_keluar   = $jam_keluar;
    
                                        //menghitung jumlah jam kerja
                                        $jam_masuk    = Carbon::createFromFormat('H:i:s', $existingAbsensi->jam_masuk);
                                        $jadwal_pulang = Carbon::createFromFormat('H:i:s', $jadwal_pulang);

                                        $jumkerja     = $jadwal_pulang->diff($jam_masuk);
                                        $absensi->jml_jamkerja = $jumkerja->format('%H:%I:%S');
                                       

                                        if($jam_masuk < $jadwal_masuk && $jam_keluar >= $jadwal_pulang)
                                        {//kondisi normal
                                            $absensi->plg_cepat    = null;
                                            // $jam_kerja             = $jadwal_pulang->diff($jam_masuk);
                                            // $jam_kerja             = $jam_kerja->format('%H:%I:%S');

                                            // $absensi->jml_jamkerja = $jam_kerja;
                                           
                                            // dd($absensi,$absensi->jml_jamkerja);
                                        }
                                        elseif($jam_masuk < $jadwal_masuk && $jam_keluar < $jadwal_pulang)
                                        {//pulangcepat
                                            $absensi->plg_cepat = null;
                                            $absensi->jml_jamkerja = '09:00:00';
                                            
                                            // dd($absensi,$absensi->jml_jamkerja);
                                        }

                                        $jmlhadir           = $jam_keluar->diff($jam_masuk);
                                        $absensi->jam_kerja =  $jmlhadir->format('%H:%I:%S');

                                        // dd($jmlhadir,$jmlhadi,$absensi);
                                        $absensi->update();
                                    }
                                    else
                                    {
                                        $jadwal_masuk  = $jadwal->jadwal_masuk;
                                        $jadwal_pulang = $jadwal->jadwal_pulang;
                                        $jam_masuk     = Carbon::createFromFormat('H:i:s', $jam);
                                        //menghitung keterlambatan karyawan
                            
                                        if($jam_masuk < $jadwal_masuk){
                                            $telat         = $jam_masuk->diff($jadwal_masuk);
                                            $terlambat     = $telat->format('%H:%I:%S');
                                        }
                                        elseif($jam_masuk > $jadwal_masuk)
                                        {
                                            $terlambat     = null;
                                        }
                                        
                                         $absensi = new Absensi();
                                                    
                                         $absensi->id_karyawan   = $matchedUser->id_pegawai;
                                         $absensi->nik           = $matchedUser->nik;
                                         $absensi->tanggal       = $tanggal;
                                         $absensi->shift         = null;
                                         $absensi->jadwal_masuk  = $jadwal_masuk;
                                         $absensi->jadwal_pulang = $jadwal_pulang;
                                         $absensi->jam_masuk     = $jam;
                                         $absensi->jam_keluar    = null;
                                         $absensi->terlambat     = $terlambat;
                                         $absensi->plg_cepat     = null;
                                         $absensi->absent        = null;
                                         $absensi->lembur        = null;
                                         $absensi->jml_jamkerja  = null;
                                         $absensi->id_departement = $matchedUser->departemen;
                                         $absensi->jam_kerja     = null;
                                         $absensi->partner       = $matchedUser->partner;
                                        $absensi->save();
                                    }
                                   
                                }else{
                                }
                            }
                        }
                        else{
                            $matchedUser = $usermesin->where('noid2', $pin)->first();
                            // dd($matchedUser);
                            if (isset($matchedUser)) 
                            {
                                $jadwals = Jadwal::where('tanggal', $tanggal)->where('partner', Auth::user()->partner)->get();
                                // dd($data,$matchedUser,$jadwal);
                                foreach ($jadwals as $jadwal) 
                                {
                                    if($jadwal)
                                    {
                                        $existingAbsensi = Absensi::where('id_karyawan', $matchedUser->id_pegawai)
                                                        ->where('tanggal', $tanggal)->where('partner', $matchedUser->partner)
                                                        ->whereNotNull('jam_masuk')->first();
                                        if($existingAbsensi)
                                        {
                                            $jadwal_masuk  = $jadwal->jadwal_masuk;
                                            $jadwal_pulang = $jadwal->jadwal_pulang;
                                            $jam_keluar    = Carbon::createFromFormat('H:i:s', $jam);

                                            //jika data ada lakukan pembaruan data, karena ada absensi yang terdapat 2 record data
                                            $absensi = $existingAbsensi;
                                            $absensi->jam_keluar   = $jam_keluar;
        
                                            //menghitung jumlah jam kerja
                                            $jam_masuk    = Carbon::createFromFormat('H:i:s', $existingAbsensi->jam_masuk);
                                            $jadwal_pulang = Carbon::createFromFormat('H:i:s', $jadwal_pulang);

                                            $jumkerja     = $jadwal_pulang->diff($jam_masuk);
                                            $absensi->jml_jamkerja = $jumkerja->format('%H:%I:%S');
                                        

                                            if($jam_masuk < $jadwal_masuk && $jam_keluar >= $jadwal_pulang)
                                            {//kondisi normal
                                                $absensi->plg_cepat    = null;
                                                // $jam_kerja             = $jadwal_pulang->diff($jam_masuk);
                                                // $jam_kerja             = $jam_kerja->format('%H:%I:%S');

                                                // $absensi->jml_jamkerja = $jam_kerja;
                                            
                                                // dd($absensi,$absensi->jml_jamkerja);
                                            }
                                            elseif($jam_masuk < $jadwal_masuk && $jam_keluar < $jadwal_pulang)
                                            {//pulangcepat
                                                $absensi->plg_cepat = null;
                                                $absensi->jml_jamkerja = '09:00:00';
                                                
                                                // dd($absensi,$absensi->jml_jamkerja);
                                            }

                                            $jmlhadir           = $jam_keluar->diff($jam_masuk);
                                            $absensi->jam_kerja =  $jmlhadir->format('%H:%I:%S');

                                            // dd($jmlhadir,$jmlhadi,$absensi);
                                            $absensi->update();
                                        }
                                        else
                                        {
                                            $jadwal_masuk  = $jadwal->jadwal_masuk;
                                            $jadwal_pulang = $jadwal->jadwal_pulang;
                                            $jam_masuk     = Carbon::createFromFormat('H:i:s', $jam);
                                            //menghitung keterlambatan karyawan
                                
                                            if($jam_masuk < $jadwal_masuk){
                                                $telat         = $jam_masuk->diff($jadwal_masuk);
                                                $terlambat     = $telat->format('%H:%I:%S');
                                            }
                                            elseif($jam_masuk > $jadwal_masuk)
                                            {
                                                $terlambat     = null;
                                            }
                                            
                                            $absensi = new Absensi();
                                                        
                                            $absensi->id_karyawan   = $matchedUser->id_pegawai;
                                            $absensi->nik           = $matchedUser->nik;
                                            $absensi->tanggal       = $tanggal;
                                            $absensi->shift         = null;
                                            $absensi->jadwal_masuk  = $jadwal_masuk;
                                            $absensi->jadwal_pulang = $jadwal_pulang;
                                            $absensi->jam_masuk     = $jam;
                                            $absensi->jam_keluar    = null;
                                            $absensi->terlambat     = $terlambat;
                                            $absensi->plg_cepat     = null;
                                            $absensi->absent        = null;
                                            $absensi->lembur        = null;
                                            $absensi->jml_jamkerja  = null;
                                            $absensi->id_departement = $matchedUser->departemen;
                                            $absensi->jam_kerja     = null;
                                            $absensi->partner       = $matchedUser->partner;
                                            $absensi->save();
                                        }
                                    
                                    }else{
                                        ///
                                    }
                                }
                            }else{
                                //
                            }

                        }

                          return redirect()->back();
                    }
                    // Mengembalikan data dalam format JSON
                    // return response()->json([$j]);
                
                } else {
                    return "Tidak ada data kehadiran.\n";
                }
            } else {
                return 'Koneksi ke ' . $ip . ' Gagal';
            }
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage() . "\n";
        }
    }
    


    // public function destroy($id)
    // {
    //     $listmesin = Listmesin::find($id);
    
    //     // Cek data ke tabel "karyawan"
    //     $karyawan = Karyawan::where('Listmesin', $listmesin->id)->first();
    //     if ($karyawan !== null) {
    //         return redirect()->back()->with('pesa', 'Listmesin tidak dapat dihapus karena digunakan dalam tabel karyawan.');
    //     } else {
    //         $listmesin->delete();
    //         return redirect()->back()->with('pesan', 'Data Listmesin berhasil dihapus');
    //     }
    // }
}

