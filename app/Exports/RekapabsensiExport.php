<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Contracts\View\View;

// class RekapabsensiExport implements FromCollection, WithHeadings
class RekapabsensiExport implements FromView, ShouldAutoSize
{
    protected $idkaryawan;
    protected $data;

    function __construct($data, $idkaryawan) {
        $this->data = $data;
        $this->idkaryawan = $idkaryawan;

        // dd($data,$idkaryawan);
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return  $this->data;
    }

    public function view(): View    
    {
        $absensi = $this->data;
        
        return view('admin/absensi/rekapabsensiExcel', ['absensi' => $absensi]);
    }
}
