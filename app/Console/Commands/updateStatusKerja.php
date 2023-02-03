<?php

namespace App\Console\Commands;

use App\Http\Controllers\KaryawanController;
use Illuminate\Console\Command;

class UpdateStatusKerja extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:status-kerja';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update status kerja karyawan jika tgl_resign sudah tercapai';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
 *
 * @return int
 */
public function handle()
{
    $karyawanController = new KaryawanController();
    $karyawanController->updateStatusKerja();

    $this->info('Status kerja karyawan sudah diperbaharui');

    return 0;
}

