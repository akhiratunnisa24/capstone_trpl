<?php

namespace App\Exports;

use App\Models\Absensi;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class RekapabsensiExport implements FromCollection, WithHeadings
{
    protected $idkaryawan;
    protected $data;

    function __construct($data, $idkaryawan) {
        $this->data = $data;
        $this->idkaryawan = $idkaryawan;

        // dd($data,$idkaryawan);
    }

    public function headings(): array {
        return [
            "No. ID","ID Karyawan","NIK","Tanggal","Jam Kerja","Jam Masuk","Jam Pulang",
            "Scan Masuk","Scan Pulang","Normal","Riil","Terlambat","Plg Cepat","Absent",
            "Lembur","Jml Jam Kerja","pengecualian","Harus C/I","Harus C/O","Departemen",
            "Hari Normal","Akhir Pekan","Hari Libur","Jml Kehadiran","Lembur Hari Normal",
            "Lembur Akhir Pekan","Lembur Hari Libur"
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Absensi::where('id_karyawan',$this->idkaryawan)->get();
    }

    // public function collection()
    // {
    //     return Absensi::all();
    // }
}
