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
use App\Models\GetUser;
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
        if (($role == 5)||$role == 7)
        {
            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
            $listmesin = Listmesin::with('partners')->orderBy('id', 'asc')->get();
            $partner = Partner::all();
            $user_mesin = GetUser::where('status','0')->orderBy('status', 'asc')->get();
            return view('superadmin.listmesin.index', compact('listmesin', 'row','partner','user_mesin'));
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
        if (($role == 5)||$role == 7)
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

            if ($con)
            {
                $mesin->status = 1;
                $mesin->update();
                return redirect()->back()->with('pesan','Berhasil terkoneksi ke mesin absensi ' . $ip);
            } else
            {
                $mesin->status = 0;
                $mesin->update();
                return redirect()->back()->with('pesa','Koneksi ke ' . $ip . ' Gagal');
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
                        // $filtered_attendance = $attendance->filter_by_date(
                        //     ['start' => '2023-02-28']
                        // );

                        // $j = $filtered_attendance->get_response(['format' => 'json']);
                        $j = $attendance->get_response(['format' => 'json']);
                        $jArray = json_decode($j, true);

                        $usermesin = UserMesin::where('partner',$partner)->get();
                        // dd($usermesin);
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
                                dd($matchedUser);
                                $jadwals = Jadwal::where('tanggal', $tanggal)
                                ->where('partner', Auth::user()->partner)
                                ->get();
                                // dd($data,$matchedUser,$jadwal);
                                foreach ($jadwals as $jadwal)
                                {
                                    if($jadwal)
                                    {
                                        $existingAbsensi = Absensi::where('id_karyawan', $matchedUser->id_pegawai)
                                                        ->where('tanggal', $tanggal)
                                                        ->where('partner', $matchedUser->partner)
                                                        ->whereNotNull('jam_masuk')
                                                        ->first();

                                        if($existingAbsensi)
                                        {
                                            if($existingAbsensi->jam_keluar !== $jam || $existingAbsensi->jam_keluar === null)
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

                                                $jmlhadir           = $jam_keluar->diff($jam_masuk);
                                                $total_jmlhadir     = ($jmlhadir->h * 60) + $jmlhadir->i;
                                                $absensi->jam_kerja =  $jmlhadir->format('%H:%I:%S');

                                                if($jam_keluar < $jadwal_pulang)
                                                {
                                                    $plgcpt = $jadwal_pulang->diff($jam_keluar);

                                                    $telatMinutes = ($plgcpt->h * 60) + $plgcpt->i; // Konversi jam ke menit

                                                    if ($telatMinutes > 0)
                                                    {
                                                        $plgcpt  = $plgcpt->format('%H:%I:%S');
                                                    }
                                                    elseif($jam_keluar < "12:00:00")
                                                    {
                                                        $plgcpt = null;
                                                    }
                                                    else
                                                    {
                                                        $plgcpt = null;
                                                    }
                                                }
                                                elseif($jam_keluar > $jadwal_pulang)
                                                {
                                                    $plgcpt     = null;
                                                }
                                                $absensi->plg_cepat = $plgcpt;


                                                if($jam_masuk < $jadwal_masuk && $jam_keluar >= $jadwal_pulang)
                                                {
                                                    $jml_jamkerja = $jadwal_pulang->diff($jadwal_masuk);
                                                    $absensi->jml_jamkerja = $jml_jamkerja->format('%H:%I:%S');

                                                    //lembur
                                                    $lembur = $jam_keluar->diff($jadwal_pulang);
                                                    $absensi->lembur = $lembur->format('%H:%I:%S');
                                                }
                                                elseif($jam_masuk < $jadwal_masuk && $jam_keluar < $jadwal_pulang)
                                                {//pulangcepat
                                                    $jml_jamkerja = $jam_keluar->diff($jadwal_masuk);
                                                    $total_minutes = ($jml_jamkerja->h * 60) + $jml_jamkerja->i;

                                                    if ($total_minutes < 540 || $total_jmlhadir < $total_minutes) { // 9 jam = 540 menit
                                                        $jml_jamkerja = $absensi->jam_kerja;
                                                    } else {
                                                        $jml_jamkerja = $jml_jamkerja->format('%H:%I:%S');
                                                    }

                                                    $absensi->jml_jamkerja = $jml_jamkerja;
                                                    $absensi->lembur = null;
                                                }
                                                elseif($jam_masuk > $jadwal_masuk && $jam_keluar < $jadwal_pulang)
                                                {
                                                    // $jml_jamkerja = $jadwal_pulang->diff($jam_masuk);
                                                    $jml_jamkerja = $jam_keluar->diff($jam_masuk);
                                                    $absensi->jml_jamkerja = $jml_jamkerja->format('%H:%I:%S');

                                                    $absensi->lembur = null;
                                                }
                                                elseif($jam_masuk > $jadwal_masuk && $jam_keluar > $jadwal_pulang)
                                                {
                                                    $lembur = $jam_keluar->diff($jadwal_pulang);
                                                    $absensi->lembur = $lembur->format('%H:%I:%S');

                                                    // $jml_jamkerja = $jadwal_pulang->diff($jadwal_masuk);
                                                    $jml_jamkerja = $jadwal_pulang->diff($jam_masuk);
                                                    $absensi->jml_jamkerja = $jml_jamkerja->format('%H:%I:%S');

                                                }
                                                $absensi->update();
                                            }
                                            else if($existingAbsensi->jam_keluar === $jam)
                                            {
                                                $absensi = $existingAbsensi;
                                            }
                                        }
                                        else
                                        {
                                            $jadwal_masuk  = $jadwal->jadwal_masuk;
                                            $jadwal_masuk     = Carbon::createFromFormat('H:i:s', $jadwal_masuk);

                                            $jadwal_pulang = $jadwal->jadwal_pulang;
                                            $jam_masuk     = Carbon::createFromFormat('H:i:s', $jam);

                                            if($jam_masuk > $jadwal_masuk)
                                            {
                                                $telat = $jadwal_masuk->diff($jam_masuk);

                                                $telatMinutes = ($telat->h * 60) + $telat->i; // Konversi jam ke menit

                                                if ($telatMinutes > 0) {
                                                    $terlambat  = $telat->format('%H:%I:%S');
                                                } else {
                                                    $terlambat = null;
                                                }
                                            }
                                            elseif($jam_masuk < $jadwal_masuk)
                                            {
                                                $terlambat     = null;
                                            }

                                            if(!Absensi::where('id_karyawan',$matchedUser->id_pegawai)->where('tanggal',$tanggal)->where('partner',$matchedUser->partner)->exists())
                                            {
                                                $absensi = new Absensi();

                                                $batasmasuk =Carbon::createFromFormat('H:i:s','16:00:00');

                                                if($jam_masuk > $batasmasuk)
                                                {
                                                    $absensi->jam_masuk     = null;
                                                    $absensi->jam_keluar    = $jam;
                                                }
                                                elseif($jam_masuk < $batasmasuk)
                                                {
                                                    $absensi->jam_masuk     = $jam;
                                                    $absensi->jam_keluar    = null;
                                                }

                                                $absensi->id_karyawan   = $matchedUser->id_pegawai;
                                                $absensi->nik           = $matchedUser->nik;
                                                $absensi->tanggal       = $tanggal;
                                                $absensi->shift         = null;
                                                $absensi->jadwal_masuk  = $jadwal_masuk;
                                                $absensi->jadwal_pulang = $jadwal_pulang;
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
                                        }
                                    }
                                }
                            }
                            else
                            {
                                $matchedUser = $usermesin->where('noid2', $pin)->where('partner', $partner)->first();
                                if (isset($matchedUser))
                                {
                                    // dd($matchedUser);
                                    $jadwals = Jadwal::where('tanggal', $tanggal)
                                    ->where('partner',  $partner)
                                    ->get();
                                // dd($data,$matchedUser,$jadwal);
                                    foreach ($jadwals as $jadwal)
                                    {
                                        if($jadwal)
                                        {
                                            $existingAbsensi = Absensi::where('id_karyawan', $matchedUser->id_pegawai)
                                                            ->where('tanggal', $tanggal)
                                                            ->where('partner', $matchedUser->partner)
                                                            ->whereNotNull('jam_masuk')
                                                            ->first();
                                            if($existingAbsensi)
                                            {
                                                if ($existingAbsensi->jam_keluar != $jam)
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

                                                    $jmlhadir           = $jam_keluar->diff($jam_masuk);
                                                    $total_jmlhadir     = ($jmlhadir->h * 60) + $jmlhadir->i;
                                                    $absensi->jam_kerja =  $jmlhadir->format('%H:%I:%S');

                                                    if($jam_keluar < $jadwal_pulang)
                                                    {
                                                        $plgcpt = $jadwal_pulang->diff($jam_keluar);

                                                        $telatMinutes = ($plgcpt->h * 60) + $plgcpt->i; // Konversi jam ke menit

                                                        if ($telatMinutes > 0)
                                                        {
                                                            $plgcpt  = $plgcpt->format('%H:%I:%S');
                                                        }
                                                        elseif($jam_keluar < "12:00:00")
                                                        {
                                                            $plgcpt = null;
                                                        }
                                                        else {
                                                            $plgcpt = null;
                                                        }
                                                    }
                                                    elseif($jam_keluar > $jadwal_pulang)
                                                    {
                                                        $plgcpt     = null;
                                                    }

                                                    $absensi->plg_cepat = $plgcpt;

                                                    if($jam_masuk < $jadwal_masuk && $jam_keluar >= $jadwal_pulang)
                                                    {//kondisi normal
                                                        $jml_jamkerja = $jadwal_pulang->diff($jadwal_masuk);
                                                        $absensi->jml_jamkerja = $jml_jamkerja->format('%H:%I:%S');

                                                        //lembur
                                                        $lembur = $jam_keluar->diff($jadwal_pulang);
                                                        $absensi->lembur = $lembur->format('%H:%I:%S');
                                                    }
                                                    elseif($jam_masuk < $jadwal_masuk && $jam_keluar < $jadwal_pulang)
                                                    {//pulangcepat
                                                        $jml_jamkerja = $jam_keluar->diff($jadwal_masuk);
                                                        $total_minutes = ($jml_jamkerja->h * 60) + $jml_jamkerja->i;

                                                        if ($total_jmlhadir < $total_minutes) { // 9 jam = 540 menit
                                                            $jml_jamkerja = $absensi->jam_kerja;
                                                        } else {
                                                            $jml_jamkerja = $jml_jamkerja->format('%H:%I:%S');
                                                        }
                                                        $absensi->jml_jamkerja = $jml_jamkerja;
                                                        $absensi->lembur = null;

                                                    }
                                                    elseif($jam_masuk > $jadwal_masuk && $jam_keluar < $jadwal_pulang)
                                                    {
                                                        $jml_jamkerja = $jam_keluar->diff($jam_masuk);
                                                        $absensi->jml_jamkerja = $jml_jamkerja->format('%H:%I:%S');

                                                        $absensi->lembur = null;

                                                    }
                                                    elseif($jam_masuk > $jadwal_masuk && $jam_keluar > $jadwal_pulang)
                                                    {
                                                        $lembur = $jam_keluar->diff($jadwal_pulang);
                                                        $absensi->lembur = $lembur->format('%H:%I:%S');

                                                        $jml_jamkerja = $jadwal_pulang->diff($jam_masuk);
                                                        $absensi->jml_jamkerja = $jml_jamkerja->format('%H:%I:%S');

                                                    }

                                                    $jmlhadir           = $jam_keluar->diff($jam_masuk);
                                                    $absensi->jam_kerja =  $jmlhadir->format('%H:%I:%S');

                                                    $absensi->update();
                                                }
                                                else if($existingAbsensi->jam_keluar == $jam)
                                                {
                                                    $absensi = $existingAbsensi;
                                                }
                                            }
                                            else
                                            {
                                                $jadwal_masuk  = $jadwal->jadwal_masuk;
                                                $jadwal_masuk     = Carbon::createFromFormat('H:i:s', $jadwal_masuk);

                                                $jadwal_pulang = $jadwal->jadwal_pulang;
                                                $jam_masuk     = Carbon::createFromFormat('H:i:s', $jam);

                                                //menghitung keterlambatan karyawan

                                                if($jam_masuk > $jadwal_masuk)
                                                {
                                                    $telat = $jadwal_masuk->diff($jam_masuk);

                                                    $telatMinutes = ($telat->h * 60) + $telat->i; // Konversi jam ke menit

                                                    if ($telatMinutes > 0) {
                                                        $terlambat  = $telat->format('%H:%I:%S');
                                                    } else {
                                                        $terlambat = null;
                                                    }
                                                }
                                                elseif($jam_masuk < $jadwal_masuk)
                                                {
                                                    $terlambat     = null;
                                                }

                                                if(!Absensi::where('id_karyawan',$matchedUser->id_pegawai)->where('tanggal',$tanggal)->where('partner',$matchedUser->partner)->exists())
                                                {

                                                    $batasmasuk =Carbon::createFromFormat('H:i:s','16:00:00');

                                                    $absensi = new Absensi();

                                                    if($jam_masuk > $batasmasuk)
                                                    {
                                                        $absensi->jam_masuk     = null;
                                                        $absensi->jam_keluar    = $jam;
                                                    }
                                                    elseif($jam_masuk < $batasmasuk)
                                                    {
                                                        $absensi->jam_masuk     = $jam;
                                                        $absensi->jam_keluar    = null;
                                                    }

                                                    $absensi->id_karyawan   = $matchedUser->id_pegawai;
                                                    $absensi->nik           = $matchedUser->nik;
                                                    $absensi->tanggal       = $tanggal;
                                                    $absensi->shift         = null;
                                                    $absensi->jadwal_masuk  = $jadwal_masuk;
                                                    $absensi->jadwal_pulang = $jadwal_pulang;
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
                                            }
                                        }   ///
                                    }
                                    return redirect()->back()->with('pesan','Data Absensi Berhasil disimpan');
                                }
                            }
                        }

                    } else {
                        return "Tidak ada data kehadiran.\n";
                    }
                }else {
                    return 'Koneksi ke ' . $ip . ' Gagal';
                }
            }catch(\Exception $e)
            {
                return "Error: " . $e->getMessage() . "\n";
            }
    }

    public function getuser(Request $request, $id)
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        try {
            $mesin = Listmesin::find($id);
            $ip = $mesin->ip_mesin;
            $com_key = $mesin->comm_key;
            $port = $mesin->port;
            $partner = $mesin->partner;

            $tad = (new TADFactory(['ip' => $ip, 'com_key' => $com_key, 'soap_port' => $port]))->get_instance();
            $con = $tad->is_alive();

            if ($con) {
                $user = $tad->get_all_user_info();

                if ($user) {
                    $u = $user->get_response(['format' => 'json']);
                    $uArray = json_decode($u, true);

                    $usermesin = UserMesin::where('partner', $partner)->get();
                    $registeredUsers = [];
                    $unregisteredUsers = [];

                    foreach ($uArray['Row'] as $data) {
                        $pin = $data['PIN'];
                        $pin2 = $data['PIN2'];
                        $nama = $data['Name'];
                        $kartu = $data['Card'];

                        $matchedUser = $usermesin->where('noid', $pin)->first();

                        if (isset($matchedUser)) {
                            // Set the status to 1 for registered users
                            $data['status'] = 1;
                            $registeredUsers[] = $data;
                        } else {
                            $matchedUser = $usermesin->where('noid2', $pin2)->first();

                            if (isset($matchedUser)) {
                                // Set the status to 1 for registered users
                                $data['status'] = 1;
                                $registeredUsers[] = $data;
                            } else {
                                // Set the status to 0 for unregistered users
                                $data['status'] = 0;
                                $unregisteredUsers[] = $data;
                            }
                        }
                    }


                   // Save unregistered users to the "get_user" table with Password as null
                    foreach ($unregisteredUsers as $userData) {
                        $pin2 = $userData['PIN2'];
                        $existingUser = GetUser::where('PIN', $pin2)->where('partner', $partner)->first();

                        if (!$existingUser) {
                            // Data doesn't exist, create a new entry
                            GetUser::create([
                                'PIN' => $pin2,
                                'Name' => json_encode($userData['Name']),
                                'Password' => json_encode($userData['Password']),
                                'Group' => json_encode($userData['Group']),
                                'Privilege' => json_encode($userData['Password']),
                                'Card' => $userData['Card'],
                                'status' => 0,
                                'partner' => $partner,
                            ]);
                        }
                    }

                    // Save registered users to the "get_user" table with Password as null
                    foreach ($registeredUsers as $userData) {
                        $pin2 = $userData['PIN2'];
                        $existingUser = GetUser::where('PIN', $pin2)->where('partner', $partner)->first();

                        if (!$existingUser) {
                            // Data doesn't exist, create a new entry
                            GetUser::create([
                                'PIN' => $pin2,
                                'Name' => json_encode($userData['Name']),
                                'Password' => json_encode($userData['Password']),
                                'Group' => json_encode($userData['Group']),
                                'Privilege' => json_encode($userData['Password']),
                                'Card' => $userData['Card'],
                                'status' => 1, // Set status to 1 for registered users
                                'partner' => $partner,
                            ]);
                        }
                    }

                    $registeredUsersJSON = json_encode($registeredUsers);
                    $unregisteredUsersJSON = json_encode($unregisteredUsers);

                    return redirect()->back()->with('success', 'Data berhasil diambil.');

                }
            }
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage() . "\n";
        }
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


