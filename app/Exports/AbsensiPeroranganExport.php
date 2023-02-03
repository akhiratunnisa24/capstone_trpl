<?php

namespace App\Exports;

use App\Models\Absensi;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Contracts\View\View;

class AbsensiPeroranganExport implements FromView, ShouldAutoSize
{
    //UNTUK DATA ABSENSI BERDASARKAN FILTER
    protected $data;
    protected $idkaryawan;

    function __construct($data,$idkaryawan) {
        $this->data = $data;
        $this->idkaryawan = $idkaryawan;
    }

    /**
    * @return \Illuminate\Support\Collection
    */

    public function view(): View    
    {
        $absensi = $this->data;
        $idkaryawan = $this->idkaryawan;
        
        return view('karyawan/absensi/rekapabsenExcel', ['absensi' => $absensi],['idkaryawan' => $idkaryawan]);
    }
}
