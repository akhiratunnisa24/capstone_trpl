<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Izin;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class IzinExpor implements FromView, ShouldAutoSize
{

    //UNTUK DATA ABSENSI BERDASARKAN FILTER
    protected $idpegawai;
    protected $data;

    function __construct($data, $idpegawai)
    {
        $this->data = $data;
        $this->idpegawai = $idpegawai;

        // dd($data,$idkaryawan);
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        // $cuti = Cuti::with('karyawans')->get();

        $izin = $this->data;
        $idkaryawan = $this->idpegawai;

        return view('manager/staff/izinExcel', ['izin' => $izin]);
    }
}
