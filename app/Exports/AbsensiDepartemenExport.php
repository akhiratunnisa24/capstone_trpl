<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Contracts\View\View;

class AbsensiDepartemenExport implements FromView, ShouldAutoSize
{
     //UNTUK SEMUA DATA ABSENSI YANG DEPARTEMEN SAMA DENGAN MANAGER
    protected $data;
    function __construct($data) {
        $this->data   = $data;
    }
    public function view(): View    
    {
        $absensi = $this->data;
        
        return view('manager/staff/AbsensidepartemenExcel', ['absensi' => $absensi]);
    }

}
