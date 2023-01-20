<?php

namespace App\Listeners;

use App\Events\AbsenKaryawanEvent;
use App\Models\Karyawan;
use App\Models\Absensi;
use App\Models\Tidakmasuk;
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
    public function handle()
    {
            $karyawan = Karyawan::whereDoesntHave('absensi', function ($query) {
            $query->whereDate(DB::raw('DATE(tanggal)'), Carbon::today());
        })->get();

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
        
    }
}


