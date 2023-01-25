<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Console\Scheduling\Event;
use App\Events\AbsenKaryawanEvent;
use App\Models\Karyawan;
use App\Models\Absensi;
use App\Models\Tidakmasuk;
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
            }    
        })->dailyAt('23:59');
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
