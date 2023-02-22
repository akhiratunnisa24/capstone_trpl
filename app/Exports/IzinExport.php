<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Izin;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class IzinExport implements FromView, ShouldAutoSize
{

    //UNTUK DATA ABSENSI BERDASARKAN FILTER
    protected $idkaryawan;
    protected $data;

    function __construct($data, $idkaryawan)
    {
        $this->data = $data;
        $this->idkaryawan = $idkaryawan;

        // dd($data,$idkaryawan);
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        // $cuti = Cuti::with('karyawans')->get();

        $izin = $this->data;
        $idkaryawan = $this->idkaryawan;

        return view('admin/cuti/izinExcel', ['izin' => $izin]);
    }
}
