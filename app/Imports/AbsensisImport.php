<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Cuti;
use App\Models\Absensis;
use App\Models\Karyawan;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AbsensisImport implements ToModel,WithHeadingRow
{
    //untuk excel
    public function startRow(): int
    {
        return 2;
    }

    private $jumlahdatadiimport = 0;
    private $jumlahDataTidakMasuk = 0;
    private $tidakmasukdatabse = 0;
    private $jumlahdata = 0; //jumlah data keseluruhan
    private $jumlahimporttidakmasuk = 0;
    private $datatidakbisadiimport = 0; //JUMLAH DATA TIDAK DIIMPORT


    public function model(array $row)
    {
        if(isset($row['nama']) && isset($row['tanggal']))
        {
            $this->jumlahdata++;
            $jumlahDatasudahada = 0;
            $jumlahKaryawanTidakTerdaftar = 0; 
            $tidakbisa = 0;
            
            $nama_map = Karyawan::whereRaw('LOWER(nama) = ?', strtolower($row['nama']))->first();
            if($nama_map)
            {
                $karyawan = Karyawan::where('nama', $nama_map->nama)->first();
            }

            if ($karyawan)
            {
                if(!Absensis::where('id_karyawan',$karyawan->id)->where('tanggal',Carbon::parse($row['tanggal'])->format("Y-m-d"))->exists())
                {
                    // $departement_map = Departemen::whereRaw('LOWER(nama_departemen) = ?', strtolower($row['departemen']))->first();
                    $tanggal = $row['tanggal'];
                    $tanggal = trim($tanggal);
                    $objTanggal = Carbon::createFromFormat('m/d/Y', $tanggal)->format('Y-m-d');
                    $tgl = Carbon::createFromFormat('Y-m-d', $objTanggal);   
                    
                    if($row['scan_masuk'] == NULL)
                    {
                        $cuti = Cuti::where('id_karyawan', $row['emp_no'])
                            ->whereBetween('tgl_mulai', [$tgl,$tgl])->OrwhereBetween('tgl_selesai',[$tgl,$tgl])
                            ->where('status', 7)
                            ->select('cuti.id as id_cuti','cuti.id_karyawan','cuti.id_jeniscuti','cuti.tgl_mulai','cuti.tgl_selesai','cuti.status')
                            ->first();
                    }
                }
            }
            else
            {
                $this->datatidakbisadiimport++;
                $jumlahKaryawanTidakTerdaftar++;
                $tidakbisa++;
                Log::info('JUMLAH DATA TIDAK BISA DIIMPORT KE  DATABASE: : ' . $tidakbisa);                
                Log::info('Jumlah data absensi dengan karyawan tidak terdaftar: ' . $jumlahKaryawanTidakTerdaftar);                
            }
        }
        else
        {
            Log::info('Row 1 kosong');
        }
    }


        //jumlah data keseluruhan dari excel yang akan diimport
        public function getJumlahData()
        {
            return $this->jumlahdata;
        }
        public function getJumlahDataDiimport()
        {
            return $this->jumlahdatadiimport;
        }
    
        //jumlah data yang masuk ke tabekl Tidak Masuk tanpa keterangan, sakit/ijin.
        public function getJumlahDataTidakMasuk()
        {
            return $this->jumlahDataTidakMasuk;
        }
    
        //jumlah data yang diimport ke tabel tidak masuk
        public function getDataImportTidakMasuk()
        {
            return $this->jumlahimporttidakmasuk;
        }
    
        public function getDatatTidakBisaDiimport()
        {
            return $this->datatidakbisadiimport;
        }
}
