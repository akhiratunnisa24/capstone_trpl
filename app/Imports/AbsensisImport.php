<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Cuti;
use App\Models\Izin;
use App\Models\Absensi;
use App\Models\Absensis;
use App\Models\Karyawan;
use App\Models\Jeniscuti;
use App\Models\Jenisizin;
use App\Models\Tidakmasuk;
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
            // dd($row['nama']);
            $this->jumlahdata++;
            $jumlahDatasudahada = 0;
            $jumlahKaryawanTidakTerdaftar = 0; 
            $tidakbisa = 0;
            
            $nama_map = Karyawan::whereRaw('LOWER(nama) = ?', strtolower($row['nama']))->first();
            // dd($nama_map);
            $karyawan = null;
            if($nama_map)
            {
                $karyawan = Karyawan::where('nama', $nama_map->nama)->first();
                // dd($nama_map,$karyawan);
            }

            if ($karyawan)
            {
                // dd($karyawan);
                $tanggal = $row['tanggal'];
                $excelDate = intval($tanggal); // Mengubah string menjadi angka integer
                $carbonDate = Carbon::createFromDate(1900, 1, 1)->addDays($excelDate - 2);
                $tgl = $carbonDate->format('Y-m-d');
                $cek = !Absensis::where('id_karyawan',$karyawan->id)->where('tanggal',$tgl)->first();
                // dd($tgl,$karyawan->id,$cek);
                if($cek)
                {

                    // $departement_map = Departemen::whereRaw('LOWER(nama_departemen) = ?', strtolower($row['departemen']))->first();
                    
                    // dd($tanggal, $excelDate, $carbonDate,$tgl);
                    if($row['scan_masuk'] == NULL)
                    {
                        $cuti = Cuti::where('id_karyawan', $karyawan->id)
                            ->whereBetween('tgl_mulai', [$tgl,$tgl])->OrwhereBetween('tgl_selesai',[$tgl,$tgl])
                            ->where('status', 7)
                            ->select('cuti.id as id_cuti','cuti.id_karyawan','cuti.id_jeniscuti','cuti.tgl_mulai','cuti.tgl_selesai','cuti.status')
                            ->first();
                        $nama = Karyawan::where('id',$karyawan->id)->select('nama','divisi')->first();
                        if($cuti) 
                        {
                            $reason = Jeniscuti::where('id',$cuti->id_jeniscuti)->select('jenis_cuti')->first();

                            for($date = Carbon::parse($cuti->tgl_mulai);$date->lte(Carbon::parse($cuti->tgl_selesai)); $date->addDay())
                            {
                                $cek = Tidakmasuk::where('id_pegawai', $cuti->id_karyawan)->where('tanggal', $date->format('Y-m-d'))->first();
                                if(!$cek){
                                    $tidakmasuk = new Tidakmasuk;
                                    $tidakmasuk->id_pegawai = $cuti->id_karyawan;
                                    $tidakmasuk->nama       = $nama->nama;
                                    $tidakmasuk->divisi     = $nama->divisi;
                                    $tidakmasuk->status     = $reason->jenis_cuti;
                                    $tidakmasuk->tanggal    = $date->format('Y-m-d');
                                    $tidakmasuk->save();

                                    $this->jumlahDataTidakMasuk++; // Increment jumlah data tidak masuk
                                    $this->jumlahimporttidakmasuk++;
                                }
                            }
                        }
                        else
                        {
                            $izin = Izin::where('id_karyawan','=',$karyawan->id)
                                ->whereBetween('tgl_mulai', [$tgl,$tgl])->orWhereBetween('tgl_selesai',[$tgl,$tgl])
                                ->where('status',7)
                                ->select('izin.id','izin.id_karyawan','izin.id_jenisizin','izin.tgl_mulai','izin.tgl_selesai','izin.status')
                                ->first();
                                
                            if($izin->id_jenisizin == 3)
                            {
                                $reason = Jenisizin::where('id',$izin->id_jenisizin)->select('jenis_izin')->first();

                                for($date = Carbon::parse($izin->tgl_mulai);$date->lte(Carbon::parse($izin->tgl_selesai)); $date->addDay())
                                {
                                    $cek = Tidakmasuk::where('id_pegawai', $izin->id_karyawan)->where('tanggal', $date->format('Y-m-d'))->first();
                                    if(!$cek)
                                    {
                                        $tidakmasuk = new Tidakmasuk;
                                        $tidakmasuk->id_pegawai = $izin->id_karyawan;
                                        $tidakmasuk->nama       = $nama->nama;
                                        $tidakmasuk->divisi     = $nama->divisi;
                                        $tidakmasuk->status     = $reason->jenis_izin;
                                        $tidakmasuk->tanggal    = $date->format('Y-m-d');
                                        $tidakmasuk->save();

                                        $this->jumlahDataTidakMasuk++;// Increment jumlah data tidak masuk
                                        $this->jumlahimporttidakmasuk++;     
                                    }
                                }
                            }
                            else
                            {
                                $cek = Tidakmasuk::where('id_pegawai', $karyawan->id)->where('tanggal', $tgl)->first();
                                if(!$cek)
                                {
                                    $nama = Karyawan::where('id',$karyawan->id)->select('nama','divisi')->first();

                                    $tidakmasuk = new Tidakmasuk;
                                    $tidakmasuk->id_pegawai = $karyawan->id;
                                    $tidakmasuk->nama       = $nama->nama;
                                    $tidakmasuk->divisi     = $nama->divisi;
                                    $tidakmasuk->status     = 'tanpa keterangan';
                                    $tidakmasuk->tanggal    =  $tgl;
                                    $tidakmasuk->save();

                                    $this->jumlahDataTidakMasuk++;
                                    $this->jumlahimporttidakmasuk++;
                                }
                                else{
                                    $this->datatidakbisadiimport++;
                                    $this->tidakmasukdatabse++;
                                    $tidakbisa++;
                                    Log::info('JUMLAH DATA TIDAK BISA DIIMPORT KE  DATABASE: : ' . $tidakbisa);         
                                    Log::info('Data tidak masuk karyawan sudah ada');
                                }
                            }
                        }

                    }else
                    {   
                        //dd($row['jam_masuk'],$row['jam_pulang'],$row['scan_masuk'],$row['scan_keluar'], $row['plg_cpt'],$row['lembur'],$row['jam_kerja'],$row['jml_hadir']);
                        // dd($jam_masuk);
                        $jam_excel = [
                            'jam_masuk'   => $row['jam_masuk'],
                            'jam_pulang'  => $row['jam_pulang'],
                            'scan_masuk'  => $row['scan_masuk'],
                            'scan_keluar' => $row['scan_keluar'],
                            'plg_cpt'     => $row['plg_cpt'],
                            'lembur'      => $row['lembur'],
                            'jam_kerja'   => $row['jam_kerja'],
                            'jml_hadir'   => $row['jml_hadir'],
                        ];
                        
                        $formatted_jam = [];
                        
                        foreach ($jam_excel as $key => $value) {

                            // if (strpos($value, ',') !== false) {
                            //     // Jika format nilai awal menggunakan koma, misalnya "08,00"
                            //     $formatted_value = str_replace(',', ':', $value); // Mengganti koma menjadi titik dua (:)
                            //     $formatted_jam[$key] = $formatted_value;
                            // } elseif (strpos($value, '.') !== false) {

                            //     //hasil 07:59 dari nilai 7.59 di excel 07,59
                            //     $formatted_value = str_replace('.', ':', $value); // Mengganti titik desimal menjadi titik dua (:)
                            //     $hours = sprintf('%02d', intval(substr($formatted_value, 0, 2))); // Mengambil dua digit pertama sebagai jam
                            //     $minutes = sprintf('%02d', intval(substr($formatted_value, 3, 2))); // Mengambil dua digit menit dan memastikan format dua digit
                            //     $formatted_jam[$key] = $hours . ':' . $minutes; // Menggabungkan jam dengan menit

                                
                            //     //hasil 0759
                            //     // Jika format nilai awal menggunakan titik desimal, misalnya "08.00"
                            //     // $formatted_value = str_replace('.', ':', $value); // Mengganti titik desimal menjadi titik dua (:)
                            //     // $hours = sprintf('%02d', intval($formatted_value)); // Mengubah jam menjadi dua digit angka
                            //     // $formatted_jam[$key] = $hours . substr($formatted_value, 2); // Menggabungkan jam dengan menit
                                
                            //     //.hasil 7:59
                            //     // $formatted_value = str_replace('.', ':', $value); // Mengganti titik desimal menjadi titik dua (:)
                            //     // $formatted_jam[$key] = $formatted_value;
                            // } else {
                            //     $formatted_jam[$key] = $value;
                            // }
                            

                            // jika bentuk value nya yaitu : 08.00 maka pakai query dibawah ini: 
                            $jam_decimal = floatval($value); // Konversi menjadi tipe data float
                            $jam_decimal *= 24; // Kalikan dengan 24
                            $hours = floor($jam_decimal);
                            $minutes = round(($jam_decimal - $hours) * 60);
                            $formatted_jam[$key] = sprintf('%02d:%02d', $hours, floor($minutes));

                        }
                        
                        dd($formatted_jam);
                        $terlambat = sprintf('%02d:%02d', floor($row['terlambat'] / 60), $row['terlambat'] % 60);                   
                    
                        $data = [
                            'no_id'         => null,
                            'id_karyawan'   => $karyawan->id,
                            'tanggal'       => $tgl,
                            'jam_masuk'     => isset($formatted_jam['jam_masuk']) ? $formatted_jam['jam_masuk'] : null,
                            'jam_pulang'    => isset($formatted_jam['jam_pulang']) ? $formatted_jam['jam_pulang'] : null,
                            'scan_masuk'    => isset($formatted_jam['scan_masuk']) ? $formatted_jam['scan_masuk'] : null,
                            'scan_keluar'   => isset($formatted_jam['scan_keluar']) ? $formatted_jam['scan_keluar'] : null,
                            'terlambat'     => $terlambat !== '' ? $terlambat : null,
                            'plg_cepat'     => isset($formatted_jam['plg_cpt']) ? $formatted_jam['plg_cpt'] : null,
                            'lembur'        => isset($formatted_jam['lembur']) ? $formatted_jam['lembur'] : null,
                            'jam_kerja'     => isset($formatted_jam['jam_kerja']) ? $formatted_jam['jam_kerja'] : null,
                            'jml_hadir'     => isset($formatted_jam['jml_hadir']) ? $formatted_jam['jml_hadir'] : null,
                        ];
                        // dd($data);
                        
                        // $data = [
                        //     'no_id'         => null,
                        //     'id_karyawan'   => $karyawan->id,
                        //     'tanggal'       => $tgl,
                        //     'jam_masuk'     => $jam_masuk !== '' ? $jam_masuk : null,
                        //     'jam_pulang'    => $jam_pulang !== '' ? $jam_pulang : null,
                        //     'scan_masuk'    => $scan_masuk !== '' ? $scan_masuk : null,
                        //     'scan_keluar'   => $scan_keluar !== '' ? $scan_keluar : null,
                        //     'terlambat'     => $terlambat !== '' ? $terlambat : null,
                        //     'plg_cepat'     => $plg_cepat !== '' ? $plg_cepat : null,
                        //     'lembur'        => $lembur !== '' ? $lembur : null,
                        //     'jam_kerja'     => $jam_kerja !== '' ? $jam_kerja : null,
                        //     'jml_hadir'     => $jml_hadir !== '' ? $jml_hadir : null,
                        // ];
                        // dd($data);
                        Absensis::create($data);
                        $this->jumlahdatadiimport++;
                    }
                }else{
                     // Hitung jumlah data berdasarkan id_karyawan dan tanggal pada file Excel
                     $this->datatidakbisadiimport++;
                     $jumlahDatasudahada = Absensis::where('id_karyawan', $karyawan->id)
                         ->where('tanggal', $tgl)
                         ->count();
 
                     Log::info('Jumlah id karaywan dan tanggal absensi sudah ada: '. $jumlahDatasudahada);  
                     $tidakbisa++;
                     Log::info('JUMLAH DATA TIDAK BISA DIIMPORT KE  DATABASE: : ' . $tidakbisa);         
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

        // public function models(array $row)
        // {
        //     if(isset($row['nama']) && isset($row['tanggal']))
        //     if(isset($row['nama']) && isset($row['tanggal']) && isset($row['nik']))
        //     {
        //         // dd($row['nama']);
        //         $this->jumlahdata++;
        //         $jumlahDatasudahada = 0;
        //         $jumlahKaryawanTidakTerdaftar = 0; 
        //         $tidakbisa = 0;
                
        //         //$nama_map = Karyawan::whereRaw('LOWER(nama) = ?', strtolower($row['nama']))->first();
        //         $nama_map = Karyawan::whereRaw('LOWER(nama) = ?', strtolower($row['nama']))
        //             ->where('nip', $row['nik'])
        //             ->first();

        //         $karyawan = null;
        //         if($nama_map)
        //         {
        //             $karyawan = Karyawan::where('nama', $nama_map->nama)->where('nip',$nama_map->nip)->first();
        //         }
    
        //         if ($karyawan)
        //         {
        //             // dd($karyawan);
        //             $tanggal = $row['tanggal'];
        //             $excelDate = intval($tanggal); // Mengubah string menjadi angka integer
        //             $carbonDate = Carbon::createFromDate(1900, 1, 1)->addDays($excelDate - 2);
        //             $tgl = $carbonDate->format('Y-m-d');
        //             $cek = !Absensi::where('id_karyawan',$karyawan->id)->where('tanggal',$tgl)->first();
        //             // dd($tgl,$karyawan->id,$cek);
        //             if($cek)
        //             {
        //                 // $departement_map = Departemen::whereRaw('LOWER(nama_departemen) = ?', strtolower($row['departemen']))->first();
                        
        //                 // dd($tanggal, $excelDate, $carbonDate,$tgl);
        //                 if($row['scan_masuk'] == NULL)
        //                 {
        //                     $cuti = Cuti::where('id_karyawan', $karyawan->id)
        //                         ->whereBetween('tgl_mulai', [$tgl,$tgl])->OrwhereBetween('tgl_selesai',[$tgl,$tgl])
        //                         ->where('status', 7)
        //                         ->select('cuti.id as id_cuti','cuti.id_karyawan','cuti.id_jeniscuti','cuti.tgl_mulai','cuti.tgl_selesai','cuti.status')
        //                         ->first();
        //                     $nama = Karyawan::where('id',$karyawan->id)->select('nama','divisi')->first();
        //                     if($cuti) 
        //                     {
        //                         $reason = Jeniscuti::where('id',$cuti->id_jeniscuti)->select('jenis_cuti')->first();
    
        //                         for($date = Carbon::parse($cuti->tgl_mulai);$date->lte(Carbon::parse($cuti->tgl_selesai)); $date->addDay())
        //                         {
        //                             $cek = Tidakmasuk::where('id_pegawai', $cuti->id_karyawan)->where('tanggal', $date->format('Y-m-d'))->first();
        //                             if(!$cek){
        //                                 $tidakmasuk = new Tidakmasuk;
        //                                 $tidakmasuk->id_pegawai = $cuti->id_karyawan;
        //                                 $tidakmasuk->nama       = $nama->nama;
        //                                 $tidakmasuk->divisi     = $nama->divisi;
        //                                 $tidakmasuk->status     = $reason->jenis_cuti;
        //                                 $tidakmasuk->tanggal    = $date->format('Y-m-d');
        //                                 $tidakmasuk->save();
    
        //                                 $this->jumlahDataTidakMasuk++; // Increment jumlah data tidak masuk
        //                                 $this->jumlahimporttidakmasuk++;
        //                             }
        //                         }
        //                     }
        //                     else
        //                     {
        //                         $izin = Izin::where('id_karyawan','=',$karyawan->id)
        //                             ->whereBetween('tgl_mulai', [$tgl,$tgl])->orWhereBetween('tgl_selesai',[$tgl,$tgl])
        //                             ->where('status',7)
        //                             ->select('izin.id','izin.id_karyawan','izin.id_jenisizin','izin.tgl_mulai','izin.tgl_selesai','izin.status')
        //                             ->first();
                                    
        //                         if($izin->id_jenisizin == 3)
        //                         {
        //                             $reason = Jenisizin::where('id',$izin->id_jenisizin)->select('jenis_izin')->first();
    
        //                             for($date = Carbon::parse($izin->tgl_mulai);$date->lte(Carbon::parse($izin->tgl_selesai)); $date->addDay())
        //                             {
        //                                 $cek = Tidakmasuk::where('id_pegawai', $izin->id_karyawan)->where('tanggal', $date->format('Y-m-d'))->first();
        //                                 if(!$cek)
        //                                 {
        //                                     $tidakmasuk = new Tidakmasuk;
        //                                     $tidakmasuk->id_pegawai = $izin->id_karyawan;
        //                                     $tidakmasuk->nama       = $nama->nama;
        //                                     $tidakmasuk->divisi     = $nama->divisi;
        //                                     $tidakmasuk->status     = $reason->jenis_izin;
        //                                     $tidakmasuk->tanggal    = $date->format('Y-m-d');
        //                                     $tidakmasuk->save();
    
        //                                     $this->jumlahDataTidakMasuk++;// Increment jumlah data tidak masuk
        //                                     $this->jumlahimporttidakmasuk++;     
        //                                 }
        //                             }
        //                         }
        //                         else
        //                         {
        //                             $cek = Tidakmasuk::where('id_pegawai', $karyawan->id)->where('tanggal', $tgl)->first();
        //                             if(!$cek)
        //                             {
        //                                 $nama = Karyawan::where('id',$karyawan->id)->select('nama','divisi')->first();
    
        //                                 $tidakmasuk = new Tidakmasuk;
        //                                 $tidakmasuk->id_pegawai = $karyawan->id;
        //                                 $tidakmasuk->nama       = $nama->nama;
        //                                 $tidakmasuk->divisi     = $nama->divisi;
        //                                 $tidakmasuk->status     = 'tanpa keterangan';
        //                                 $tidakmasuk->tanggal    =  $tgl;
        //                                 $tidakmasuk->save();
    
        //                                 $this->jumlahDataTidakMasuk++;
        //                                 $this->jumlahimporttidakmasuk++;
        //                             }
        //                             else{
        //                                 $this->datatidakbisadiimport++;
        //                                 $this->tidakmasukdatabse++;
        //                                 $tidakbisa++;
        //                                 Log::info('JUMLAH DATA TIDAK BISA DIIMPORT KE  DATABASE: : ' . $tidakbisa);         
        //                                 Log::info('Data tidak masuk karyawan sudah ada');
        //                             }
        //                         }
        //                     }
    
        //                 }else
        //                 {   
        //                     //dd($row['jam_masuk'],$row['jam_pulang'],$row['scan_masuk'],$row['scan_keluar'], $row['plg_cpt'],$row['lembur'],$row['jam_kerja'],$row['jml_hadir']);
        //                     // dd($jam_masuk);
        //                     $jam_excel = [
        //                         'jam_masuk'   => $row['jam_masuk'],
        //                         'jam_pulang'  => $row['jam_pulang'],
        //                         'scan_masuk'  => $row['scan_masuk'],
        //                         'scan_keluar' => $row['scan_keluar'],
        //                         'plg_cpt'     => $row['plg_cpt'],
        //                         'lembur'      => $row['lembur'],
        //                         'jam_kerja'   => $row['jam_kerja'],
        //                         'jml_hadir'   => $row['jml_hadir'],
        //                     ];
                            
        //                     $formatted_jam = [];
                            
        //                     foreach ($jam_excel as $key => $value) {
    
        //                         // if (strpos($value, ',') !== false) {
        //                         //     // Jika format nilai awal menggunakan koma, misalnya "08,00"
        //                         //     $formatted_value = str_replace(',', ':', $value); // Mengganti koma menjadi titik dua (:)
        //                         //     $formatted_jam[$key] = $formatted_value;
        //                         // } elseif (strpos($value, '.') !== false) {
    
        //                         //     //hasil 07:59 dari nilai 7.59 di excel 07,59
        //                         //     $formatted_value = str_replace('.', ':', $value); // Mengganti titik desimal menjadi titik dua (:)
        //                         //     $hours = sprintf('%02d', intval(substr($formatted_value, 0, 2))); // Mengambil dua digit pertama sebagai jam
        //                         //     $minutes = sprintf('%02d', intval(substr($formatted_value, 3, 2))); // Mengambil dua digit menit dan memastikan format dua digit
        //                         //     $formatted_jam[$key] = $hours . ':' . $minutes; // Menggabungkan jam dengan menit
    
                                    
        //                         //     //hasil 0759
        //                         //     // Jika format nilai awal menggunakan titik desimal, misalnya "08.00"
        //                         //     // $formatted_value = str_replace('.', ':', $value); // Mengganti titik desimal menjadi titik dua (:)
        //                         //     // $hours = sprintf('%02d', intval($formatted_value)); // Mengubah jam menjadi dua digit angka
        //                         //     // $formatted_jam[$key] = $hours . substr($formatted_value, 2); // Menggabungkan jam dengan menit
                                    
        //                         //     //.hasil 7:59
        //                         //     // $formatted_value = str_replace('.', ':', $value); // Mengganti titik desimal menjadi titik dua (:)
        //                         //     // $formatted_jam[$key] = $formatted_value;
        //                         // } else {
        //                         //     $formatted_jam[$key] = $value;
        //                         // }
                                
    
        //                         // jika bentuk value nya yaitu : 08.00 maka pakai query dibawah ini: 
        //                         $jam_decimal = floatval($value); // Konversi menjadi tipe data float
        //                         $jam_decimal *= 24; // Kalikan dengan 24
        //                         $hours = floor($jam_decimal);
        //                         $minutes = round(($jam_decimal - $hours) * 60);
        //                         $formatted_jam[$key] = sprintf('%02d:%02d', $hours, floor($minutes));
    
        //                     }
                            
        //                     // dd($formatted_jam);
        //                     $terlambat = sprintf('%02d:%02d', floor($row['terlambat'] / 60), $row['terlambat'] % 60);                   
                        
        //                     $data = [
        //                         'nik'           => $row['nik'],
        //                         'id_karyawan'   => $karyawan->id,
        //                         'tanggal'       => $tgl,
        //                         'jadwal_masuk'  => isset($formatted_jam['jam_masuk']) ? $formatted_jam['jam_masuk'] : null,
        //                         'jadwal_pulang' => isset($formatted_jam['jam_pulang']) ? $formatted_jam['jam_pulang'] : null,
        //                         'jam_masuk'     => isset($formatted_jam['scan_masuk']) ? $formatted_jam['scan_masuk'] : null,
        //                         'jam_keluar'    => isset($formatted_jam['scan_keluar']) ? $formatted_jam['scan_keluar'] : null,
        //                         'terlambat'     => $terlambat !== '' ? $terlambat : null,
        //                         'plg_cepat'     => isset($formatted_jam['plg_cpt']) ? $formatted_jam['plg_cpt'] : null,
        //                         'lembur'        => isset($formatted_jam['lembur']) ? $formatted_jam['lembur'] : null,
        //                         'jml_jamkerja'  => isset($formatted_jam['jam_kerja']) ? $formatted_jam['jam_kerja'] : null,
        //                         'jam_kerja'     => isset($formatted_jam['jml_hadir']) ? $formatted_jam['jml_hadir'] : null,
        //                     ];
        //                     // dd($data);
                            
        //                     // $data = [
        //                     //     'no_id'         => null,
        //                     //     'id_karyawan'   => $karyawan->id,
        //                     //     'tanggal'       => $tgl,
        //                     //     'jam_masuk'     => $jam_masuk !== '' ? $jam_masuk : null,
        //                     //     'jam_pulang'    => $jam_pulang !== '' ? $jam_pulang : null,
        //                     //     'scan_masuk'    => $scan_masuk !== '' ? $scan_masuk : null,
        //                     //     'scan_keluar'   => $scan_keluar !== '' ? $scan_keluar : null,
        //                     //     'terlambat'     => $terlambat !== '' ? $terlambat : null,
        //                     //     'plg_cepat'     => $plg_cepat !== '' ? $plg_cepat : null,
        //                     //     'lembur'        => $lembur !== '' ? $lembur : null,
        //                     //     'jam_kerja'     => $jam_kerja !== '' ? $jam_kerja : null,
        //                     //     'jml_hadir'     => $jml_hadir !== '' ? $jml_hadir : null,
        //                     // ];
        //                     // dd($data);
        //                     Absensis::create($data);
        //                     $this->jumlahdatadiimport++;
        //                 }
        //             }else{
        //                  // Hitung jumlah data berdasarkan id_karyawan dan tanggal pada file Excel
        //                  $this->datatidakbisadiimport++;
        //                  $jumlahDatasudahada = Absensis::where('id_karyawan', $karyawan->id)
        //                      ->where('tanggal', $tgl)
        //                      ->count();
     
        //                  Log::info('Jumlah id karaywan dan tanggal absensi sudah ada: '. $jumlahDatasudahada);  
        //                  $tidakbisa++;
        //                  Log::info('JUMLAH DATA TIDAK BISA DIIMPORT KE  DATABASE: : ' . $tidakbisa);         
        //             }
        //         }
        //         else
        //         {
        //             $this->datatidakbisadiimport++;
        //             $jumlahKaryawanTidakTerdaftar++;
        //             $tidakbisa++;
        //             Log::info('JUMLAH DATA TIDAK BISA DIIMPORT KE  DATABASE: : ' . $tidakbisa);                
        //             Log::info('Jumlah data absensi dengan karyawan tidak terdaftar: ' . $jumlahKaryawanTidakTerdaftar);                
        //         }
        //     }
        //     else
        //     {
        //         Log::info('Row 1 kosong');
        //     }
        // }
    
}
