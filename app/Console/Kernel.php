<?php

namespace App\Console;

use Carbon\Carbon;
use App\Models\Cuti;
use App\Models\Izin;
use App\Models\User;
use App\Models\Resign;
use App\Models\Absensi;
use App\Models\Karyawan;
use App\Models\Sisacuti;
use App\Models\Jeniscuti;
use App\Models\Departemen;
use App\Models\Tidakmasuk;
use App\Models\Alokasicuti;
use App\Mail\SisacutiNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Mail\TidakmasukNotification;
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
