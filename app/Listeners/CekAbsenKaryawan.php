<?php

namespace App\Listeners;

use App\Events\AbsenKaryawanEvent;
use App\Models\Karyawan;
use App\Models\Absensi;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CekAbsenKaryawan
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\AbsenKaryawanEvent  $event
     * @return void
     */
    public function handle(AbsenKaryawanEvent $event)
    {
            $karyawan = Karyawan::whereDoesntHave('absensi', function ($query) {
            $query->whereDate(DB::raw('DATE(created_at)'), Carbon::today());
        })->get();

        if ($karyawan->count() > 0) {
            foreach ($karyawan as $karyawan) {
                $absen = new Absensi();
                $absen->id_karyawan = $karyawan->id;
                $absen->date = Carbon::today();
                $absen->save();
            }
        }
    }
}


