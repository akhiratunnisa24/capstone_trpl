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
        
        // $karyawan = Karyawan::all();
        // $keluarga = Keluarga::all();
        // $kdarurat = Kdarurat::all();
        // $rpendidikan = Rpendidikan::all();
        // $rpekerjaan = Rpekerjaan::all();

        // $data = DB::table('karyawan')
        // ->join('keluarga', 'karyawan.id', 'keluarga.id_pegawai')->get();

        return view('karyawan/karyawanExport', [
        
            'karyawan' => $karyawan,
        ]);
    }
   
}


// class KaryawanExport implements FromCollection, WithHeadings
// {

//     public function headings(): array
//     {
//         return [
//             'Id ',
//             'nip',
//             'nik',
//             'nama',
//             'tgllahir',
//             'email',
//             'agama',
//             'gol_darah',
//             'jenis_kelamin',
//             'alamat',
//             'no_hp',
//             'status_karyawan',
//             'tipe_karyawan',
//             'manager',
//             'no_kk',
//             'status_kerja',
//             'cuti_tahunan',
//             'divisi',
//             'no_rek',
//             'no_bpjs_kes',
//             'no_npwp',
//             'no_bpjs_ket',
//             'kontrak',
//             'jabatan',
//             'gaji',
//             'tglmasuk',
//             'tglkeluar',
//             'created_at',
//             'update_at',
//             'foto',
//             'foto',
//             'foto',
//             'foto',
//         ];
//     }

//     /**
//      * @return \Illuminate\Support\Collection
//      */
//     public function collection()
//     {
//         return Karyawan::all();
//     }
    
    

    
// }