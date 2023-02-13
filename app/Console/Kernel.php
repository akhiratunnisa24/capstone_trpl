<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Console\Scheduling\Event;
use App\Events\AbsenKaryawanEvent;
use App\Models\Karyawan;
use App\Models\Absensi;
use App\Models\Tidakmasuk;
use App\Models\Resign;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

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
                $schedule->call(function (){
                $karyawanSudahAbsen = DB::table('absensi')->whereDay('created_at', '=', Carbon::now())->pluck('id_karyawan');
                $karyawan = DB::table('karyawan')->whereNotIn('id', $karyawanSudahAbsen)->get();
    
            if ($karyawan->count() > 0) {
                foreach ($karyawan as $karyawan) {
                    $absen = new Tidakmasuk();
                    $absen->id_pegawai = $karyawan->id;
                    $absen->nama = $karyawan->nama;
                    $absen->divisi = $karyawan->divisi;
                    $absen->status = 'tanpa keterangan';
                    $absen->tanggal = Carbon::today();
                    $absen->save();
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
                    
        })->dailyAt('11:14');
    
    
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
