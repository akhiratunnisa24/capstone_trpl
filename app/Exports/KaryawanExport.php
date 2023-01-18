<?php

namespace App\Exports;

use App\Models\Karyawan;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Contracts\View\View;


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

        return view('admin.karyawan/karyawanExport', [
        
            'karyawan' => $karyawan,
        ]);
    }
   
}

