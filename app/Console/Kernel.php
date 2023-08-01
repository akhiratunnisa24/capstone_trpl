<?php

namespace App\Console;

use Carbon\Carbon;
use App\Models\Cuti;
use App\Models\Izin;
use App\Models\User;
use App\Models\Mesin;
use App\Models\Jadwal;
use App\Models\Resign;
use TADPHP\TADFactory;
use App\Models\Absensi;
use App\Models\Karyawan;
use App\Models\Sisacuti;
use App\Models\Jeniscuti;
use App\Models\Listmesin;
use App\Models\UserMesin;
use App\Models\Departemen;
use App\Models\Tidakmasuk;
use App\Models\Alokasicuti;
use App\Mail\SisacutiNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Mail\TidakmasukNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
     /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        
    ];
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        
            // $karyawanSudahAbsen = DB::table('absensi')->whereDay('created_at', '=', Carbon::now())->pluck('id_karyawan');
            // $karyawan = DB::table('karyawan')->whereNotIn('id', $karyawanSudahAbsen)
            // ->get();
            // dd($karyawan);

        // $schedule->command('AbsenKaryawanEvent')->dailyAt('23:59');
        $schedule->call(function ()
        {
                $karyawanSudahAbsen = DB::table('absensi')
                    ->whereYear('tanggal', '=', Carbon::now()->year)
                    ->whereMonth('tanggal', '=', Carbon::now()->month)
                    ->whereDay('tanggal', '=', Carbon::now())->pluck('id_karyawan');
                $karyawan = DB::table('karyawan')->whereNotIn('id', $karyawanSudahAbsen)->get();
                // dd($karyawan);
            
                //pengecekan ke data cuti apakah ada atau tidak

                $cuti = Cuti::whereDate('tgl_mulai', Carbon::today())
                    ->whereDate('tgl_selesai', '>=', Carbon::today())
                    ->where('status', 7)
                    ->get();
    
            if ($karyawan->count() > 0) 
            {
                foreach ($karyawan as $karyawan) {
                    $absen = new Tidakmasuk();
                    $absen->id_pegawai = $karyawan->id;
                    $absen->nama = $karyawan->nama;
                    $absen->divisi = $karyawan->divisi;
                    $absen->status = 'tanpa keterangan';
                    $absen->tanggal = Carbon::today();

                    // cek apakah karyawan memiliki cuti pada hari ini

                    // $cuti = Cuti::join('jeniscuti', 'cuti.id_jeniscuti', '=', 'jeniscuti.id')
                    //     ->where('id_karyawan', $karyawan->id)
                    //     ->whereDate('tgl_mulai', '=', Carbon::today())
                    //     ->first();
                    // $izin = Izin::join('jenisizin', 'izin.id_jenisizin', '=', 'jenisizin.id')
                    //     ->where('id_karyawan', $karyawan->id)
                    //     ->whereDate('tgl_mulai', '=', Carbon::today())
                    //     ->first();


                    $today = Carbon::now()->format('Y-m-d');
                    $cuti = Cuti::where('tgl_mulai', '<=', $today)
                        ->where('tgl_selesai', '>=', $today)
                        ->where('status', 7)
                        ->where('id_karyawan', $karyawan->id)
                        ->first();
                

                     // Cek apakah karyawan memiliki izin pada hari ini
                    $izin = Izin::where('tgl_mulai', '<=', $today)
                        ->where('tgl_selesai', '>=', $today)
                        ->where('status', 7)
                        ->where('id_karyawan', $karyawan->id)
                        ->first();
            

                    if ($cuti) {
                        $absen->status = $cuti->jeniscuti->jenis_cuti;
                    } else if ($izin) {
                        $absen->status = $izin->jenisizins->jenis_izin;
                    } else {
                        $absen->status = 'tanpa keterangan';

                        // $alokasicuti = Alokasicuti::where('id_jeniscuti', '=', 3)
                        //     ->where('id_karyawan',  $absen->id_pegawai)
                        //     ->first();
                        // $durasi_baru = $alokasicuti->durasi - 1;

                        // //update durasi di alokasicutikaryawan
                        // Alokasicuti::where('id_jeniscuti', $alokasicuti->id_jeniscuti)
                        //     ->where('id_karyawan',  $absen->id_pegawai)
                        //     ->update(
                        //         ['durasi' => $durasi_baru]
                        //     );
                    }

                    $absen->save();

                    // Pengiriman Email Notifikasi jgn di hapus 

                    // $alokasicuti2 = Alokasicuti::where('id_jeniscuti', '=', 3)
                    //     ->where('id_karyawan',  $absen->id_pegawai)
                    //     ->first();
                    // $durasi_baru = $alokasicuti2->durasi - 1;

                    // $epegawai = Karyawan::select('email as email', 'nama as nama')->where('id', '=', $absen->id_pegawai)->first();
                    // $tujuan = $epegawai->email;
                    // $data = [
                    //     'subject'     => 'Notifikasi Pengurangan Jatah Cuti Tahunan',
                    //     'id'          => $alokasicuti2->id_jeniscuti,
                    //     'id_jeniscuti' => $alokasicuti2->jeniscutis->jenis_cuti,
                    //     'keterangan'   => $absen->status,
                    //     'tanggal'     => Carbon::parse($absen->tanggal)->format("d M Y"),
                    //     'jml_cuti'    => 1,
                    //     'nama'        => $epegawai->nama,
                    //     'jatahcuti'   => $durasi_baru,
                    // ];
                    // Mail::to($tujuan)->send(new TidakmasukNotification($data));
                    
                }

                $resigns = Resign::whereDate('tgl_resign', '=', now())
                ->where('status', 3)
                ->get();
                foreach ($resigns as $resign) {
                    $karyawan = Karyawan::find($resign->id_karyawan);
                    if ($karyawan && $karyawan->status_kerja == 'Aktif') {
                        $karyawan->update(['status_kerja' => 'Non-Aktif']);
                    }
                }

                
            }
                $inactiveUsers = User::whereHas('karyawan', function ($query) {
                    $query->where('status_kerja', 'Non-Aktif');
                })->get();
                
                    foreach ($inactiveUsers as $user) {
                    Log::info("Updating status_akun for user with ID: " . $user->id);
                    $user->update(['status_akun' => 0]);
                    Log::info("Status_akun for user with ID: " . $user->id . " has been updated to 0");
                }

        })
        ->dailyAt('23:59');

        //schedule untuk mengubah status alokasi cuti tahun selain cuti tsahunan lalu menjadi tidak aktif
        $schedule->call(function () 
        {
            $year = Carbon::now()->year;
            // $year = Carbon::now()->subYear()->year;

            $alokasitahunlalu = Alokasicuti::where('sampai', '<=', Carbon::create($year, 12, 31)->toDateString())
                ->where('status', '=', '1')
                ->where('id_jeniscuti','!=',1)
                ->get();
            
            foreach ($alokasitahunlalu as $cut) {
                Alokasicuti::where('id', '=', $cut->id)
                    ->update(['status' => 0]);
            }

        })->yearlyOn(12, 31, '23:59');
        //->yearlyOn(03, 29, '10:27'); 


        //scheduler untuk notifikasi sisacuti tahunan kepada karyawan
        $schedule->call(function () 
        {
            $jeniscuti = Jeniscuti::find(1);
            $sisacuti = Sisacuti::leftjoin('karyawan', 'sisacuti.id_pegawai', '=', 'karyawan.id')
                ->leftjoin('jeniscuti', 'jeniscuti.id', '=', 'sisacuti.jenis_cuti')
                ->where('sisacuti.jenis_cuti', $jeniscuti->id)
                ->where('sisacuti.sisa_cuti', '>', 0)
                ->select('sisacuti.id_pegawai as id', 'karyawan.email as email', 'karyawan.nama as nama','karyawan.atasan_pertama', 'karyawan.atasan_kedua','sisacuti.jenis_cuti as jeniscuti', 'jeniscuti.jenis_cuti as kategori', 'sisacuti.sisa_cuti as sisa', 'sisacuti.periode as tahun','sisacuti.dari as dari','sisacuti.sampai as sampai')
                ->get();
        
            foreach($sisacuti as $sisa) {
                $currentDate = Carbon::now();
                $isEligible = $currentDate->month == 1 || $currentDate->month == 2 || $currentDate->month == 3;
                $isInPeriod = $currentDate->between($sisa->dari, $sisa->sampai);
        
                if ($isEligible && $isInPeriod) {
                    $tujuan = $sisa->email;

                    $atasan1 = Karyawan::where('id',$sisa->atasan_pertama)->select('nama','email')->first();
                    $atasan2 = null;
                    if($sisa->atasan_kedua != NULL){
                        $atasan2 = Karyawan::where('id',$sisa->atasan_kedua)->select('nama','email')->first();
                    }
        
                    $data = [
                        'subject' => 'Notifikasi Sisa Cuti Tahunan '. $sisa->tahun . ' ' . $sisa->nama ,
                        'id' => $sisa->id,
                        'kategori' => $sisa->kategori,
                        'nama' => $sisa->nama,
                        'emailatasan1'=> $atasan1->email,
                        'tahun' => $sisa->tahun,
                        'sisacuti' => $sisa->sisa,
                        'aktifdari' =>Carbon::parse($sisa->dari)->format('d F Y'),
                        'sampai' => Carbon::parse($sisa->sampai)->format('d F Y'),
                    ];

                    if($atasan2 != NULL){
                        $data['emailatasan2'] = $atasan2->email;
                    }

                    Mail::to($tujuan)->send(new SisacutiNotification($data));
                }        
            }
        })->monthlyOn(01, '01,02,03')->at('23:59');
        
        //schedule untuk update status sisacuti tahunan karyawan tahun lalu.
        $schedule->call(function () 
        {
            $year = Carbon::now()->subYear()->year;

            $jeniscuti = Jeniscuti::find(1);
            $sisacuti = Sisacuti::leftJoin('karyawan', 'sisacuti.id_pegawai', '=', 'karyawan.id')
                ->leftJoin('jeniscuti', 'jeniscuti.id', '=', 'sisacuti.id_jeniscuti')
                ->where('sisacuti.id_jeniscuti', $jeniscuti->id)
                ->where('sisacuti.sisa_cuti', '>=', 0)
                ->where('sisacuti.status', '=', 1)
                ->where('periode','=',$year)
                ->select('sisacuti.id_pegawai as id', 'karyawan.email as email', 'karyawan.nama as nama', 'sisacuti.id_jeniscuti as jeniscuti', 'jeniscuti.jenis_cuti as kategori', 'sisacuti.sisa_cuti as sisa', 'sisacuti.periode as tahun', 'sisacuti.dari as dari', 'sisacuti.sampai as sampai', 'sisacuti.status')
                ->get();

            foreach ($sisacuti as $sisa) {
                $currentDate = Carbon::today();
                $isInPeriod = $currentDate->between($sisa->dari, $sisa->sampai);
                if (!$isInPeriod) {
                    Sisacuti::where('id', '=', $sisa->id)
                    ->update(['status' => 0]);
                }
            }

        })->yearlyOn(03, 31, '23:59');
        //->yearlyOn(04, 03, '10:09');


        //schedule untuk menarik data dari mesin absensi secara berkala per menit
        $schedule->call(function () 
        {
            try {
                // $ip = '192.168.1.8';
                // $com_key = 0;
                $mesin = Listmesin::all();
                foreach($mesin as $listmesin)
                {
                    $ip = $listmesin->ip_mesin;
                    $com_key = $listmesin->comm_key;
                    $partner = $listmesin->partner;
                    $tad = (new TADFactory(['ip' => $ip, 'com_key' => $com_key]))->get_instance();
                    $con = $tad->is_alive();
                    if ($con) 
                    {
                        $attendance = $tad->get_att_log();
                        if ($attendance) {
                            $filtered_attendance = $attendance->filter_by_date(
                                ['start' => '2023-07-31']
                            );
                            $j = $filtered_attendance->get_response(['format' => 'json']);
                            $jArray = json_decode($j, true);
                        
                            
                            
                            // Loop melalui data $jArray untuk mencocokkan nilai PIN
                            foreach ($jArray['Row'] as $data) 
                            {
                               

                                $pin = $data['PIN'];
                                $datetime = Carbon::parse($data['DateTime']);
                                $tanggal = $datetime->format('Y-m-d');
                                $jam = $datetime->format('H:i:s');
                                
                                $usermesin = UserMesin::where('partner',$partner)->get();
                                // Cari data di $usermesin berdasarkan PIN
                                $matchedUser = $usermesin->where('noid', $pin)->first();
        
                                if ($matchedUser) 
                                {
                                    $jadwals = Jadwal::where('tanggal', $tanggal)->where('partner',$matchedUser->partner)->get();
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
            
                                                //menghitung jumlah jam kerja
                                                $jam_masuk    = Carbon::createFromFormat('H:i:s', $existingAbsensi->jam_masuk);
                                                $jadwalpulang = Carbon::createFromFormat('H:i:s', $jadwal_pulang);
                                                $jumkerja     = $jadwalpulang->diff($jam_masuk);
                                                $jamkerja     = $jumkerja->format('%H:%I:%S');
            
                                                //jumlah kehadiran
                                                $jmlhadir        =  $jam_keluar->diff($jadwal_masuk);
                                                $jumlahkehadiran = $jmlhadir->format('%H:%I:%S');
                                                
            
                                                
                                                //jika data ada lakukan pembaruan data, karena ada absensi yang terdapat 2 record data
                                                $absensi = $existingAbsensi;
                                                $absensi->jam_keluar   = $jam_keluar;
            
                                                if($jam_keluar < $jadwal_pulang)
                                                {
                                                    //menghitung plg cepat
                                                    $selisih       = $jam_keluar->diff($jadwal_pulang);
                                                    $plgcepat      = $selisih->format('%H:%I:%S');
                                                    $absensi->plg_cepat = $plgcepat;
                                                }
                                                elseif($jam_keluar >= $jadwal_pulang)
                                                {
                                                    $absensi->plg_cepat = null;
                                                }
                                                else{
                                                    $absensi->plg_cepat = null;
                                                }
            
            
                                                if($jam_masuk >= $jadwal_masuk)
                                                {
                                                    $absensi->jml_jamkerja = $jamkerja;
                                                }
                                                elseif($jam_masuk < $jadwal_masuk)
                                                {
                                                    $absensi->jml_jamkerja = '09:00:00';
                                                }
                                                else{
                                                    $absensi->jml_jamkerja = null;
                                                }
            
                                                $absensi->jam_kerja    = $jumlahkehadiran;
                                                
                                                // dd($absensi);
                                                $absensi->update();
                                            }
                                            else
                                            {
                                                $jadwal_masuk  = $jadwal->jadwal_masuk;
                                                $jadwal_pulang = $jadwal->jadwal_pulang;
                                                $jam_masuk     = Carbon::createFromFormat('H:i:s', $jam);
                                                //menghitung keterlambatan karyawan
                                    
                                                $telat         = $jam_masuk->diff($jadwal_masuk);
                                                $terlambat     = $telat->format('%H:%I:%S');
                                                
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
                                
                                }
                                else{
                                    //jika data tidak cocok skip
                                }
                            }
                            // Mengembalikan data dalam format JSON
                            return response()->json([$j]);
        
                        } else {
                            return "Tidak ada data kehadiran.\n";
                        }
                    } else {
                        return 'Koneksi ke ' . $ip . ' Gagal';
                    }
                }

                return Absensi::whereDate('Tanggal', Carbon::now()->today())->get();
                
                
            } catch (\Exception $e) {
                return "Error: " . $e->getMessage() . "\n";
            }

        })->everyMinute();
    
    }

    /** 
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
