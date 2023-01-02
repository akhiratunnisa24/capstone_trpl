<?php

namespace App\Exports;

use App\Models\Absensi;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class AbsensiDepartemenExport implements FromCollection,WithHeadings
{
    protected $data;
    function __construct($data) {
        $this->data   = $data;

        // dd($data,$middep);
    }

    //UNTUK SEMUA DATA ABSENSI YANG DEPARTEMEN SAMA DENGAN MANAGER
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
        return $this->data;
    }
}
