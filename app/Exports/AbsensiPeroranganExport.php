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
    protected $iduser;

    function __construct($data,$iduser) {
        $this->data = $data;
        $this->iduser = $iduser;
    }

    /**
    * @return \Illuminate\Support\Collection
    */

    public function view(): View    
    {
        $absensi = $this->data;
        $iduser = $this->iduser;
        
        return view('karyawan/absensi/rekapabsenExcel', ['absensi' => $absensi],['iduser' => $iduser]);
    }
}
