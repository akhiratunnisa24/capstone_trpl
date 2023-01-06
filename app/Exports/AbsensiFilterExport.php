<?php

namespace App\Exports;

use App\Models\Absensi;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Contracts\View\View;

class AbsensiFilterExport implements FromView, ShouldAutoSize
{
    //UNTUK SEMUA DATA ABSENSI BERDASARKAN FILTER DATA

    protected $idkaryawan;
    protected $data;
    // protected $middep;

    function __construct($data, $idkaryawan, $middep) {
        $this->data = $data;
        $this->idkaryawan = $idkaryawan;
        $this->middep = $middep->id_departement;
        // dd($data);
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->data;
    }

    public function view(): View    
    {
        $absensi = $this->data;
        $idkaryawan = $this->idkaryawan ;
        
        return view('manager/staff/exportAbsensi', ['absensi' => $absensi], ['idkaryawan' => $idkaryawan]);
    }
}
