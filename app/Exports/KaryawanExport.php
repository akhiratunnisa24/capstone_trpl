<?php

namespace App\Exports;

use App\Models\Karyawan;
use App\Models\Kdarurat;
use App\Models\Keluarga;
use App\Models\Rpekerjaan;
use App\Models\Rpendidikan;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;


class KaryawanExport implements FromView, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Karyawan::all();
    }

    public function view(): View    
    {
        $karyawan = Karyawan::with(
            'kdarurat',
            'keluarga',
            'rpendidikan',
            'rpekerjaan'
            )
        ->get();

        return view('karyawan/karyawanExport', [
        
            'karyawan' => $karyawan,
        ]);
    }
   
}

