<?php

namespace App\Exports;

use App\Models\Absensi;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class AbsensiFilterExport implements FromCollection,WithHeadings
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
