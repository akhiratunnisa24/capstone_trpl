<?php

namespace App\Exports;

use App\Models\Absensi;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Contracts\View\View;

class AbsensiExport implements FromView, ShouldAutoSize
{

    /**
    * @return \Illuminate\Support\Collection
    */

    public function view(): View    
    {
        $absensi = Absensi::with('karyawans','departemens')->get();
        
        return view('admin/absensi/absensiExcel', ['absensi' => $absensi]);
    }
}
