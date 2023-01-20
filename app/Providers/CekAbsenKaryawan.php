<?php

namespace App\Providers;

use App\Providers\AbsenKaryawanEvent;
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
     * @param  \App\Providers\AbsenKaryawanEvent  $event
     * @return void
     */
    public function handle(AbsenKaryawanEvent $event)
    {
        //
    }
}
