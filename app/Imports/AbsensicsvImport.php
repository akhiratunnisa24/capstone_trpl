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
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AbsensicsvImport implements ToModel,WithHeadingRow
{
     //UNTUK CSV
    public function startRow(): int
     {
         return 2;
     }

    public function getCsvSettings(): array
     {
         return [
             'delimiter' => ';'
         ];
     }

    private $jumlahdatadiimport = 0;
    private $jumlahdata = 0; //jumlah data keseluruhan
    private $jumlahimporttidakmasuk = 0;
    private $datatidakbisadiimport = 0; //JUMLAH DATA TIDAK DIIMPORT
    public function model(array $row)
    {
        dd($row);
        // if(isset($row['nama']) && isset($row['tanggal']) && isset($row['NIK']))
        if(isset($row['nik']) && isset($row['tanggal']))
        {
            // dd($row['nama']);
            $this->jumlahdata++;

            $karyawan = Karyawan::where('nik', $row['nik'])->first();

            if(isset($karyawan))
            {
                // dd($karyawan);
                $tanggal = $row['tanggal'];
                $carbonDate = Carbon::createFromFormat('m/d/Y', $tanggal);
                $tgl = $carbonDate->format('Y-m-d');
                $cek = !Absensi::where('id_karyawan',$karyawan->id)->where('tanggal',$tgl)
                        ->where('partner',Auth::user()->partner)->first();

                if($cek)
                {
                    if($row['scan_masuk'] == "" && $row['scan_pulang'] == "")
                    {
                        $cuti = Cuti::where('id_karyawan', $karyawan->id)
                            ->whereBetween('tgl_mulai', [$tgl,$tgl])->OrwhereBetween('tgl_selesai',[$tgl,$tgl])
                            ->where('status', 7)
                            ->select('cuti.id as id_cuti','cuti.id_karyawan','cuti.id_jeniscuti','cuti.tgl_mulai','cuti.tgl_selesai','cuti.status')
                            ->first();
                        $nama = Karyawan::where('id',$karyawan->id)
                            ->where('partner',Auth::user()->partner)
                            ->select('nama','divisi')->first();
                        if($cuti !== NULL)
                        {
                            $reason = Jeniscuti::where('id',$cuti->id_jeniscuti)
                                ->where('partner',Auth::user()->partner)
                                ->select('jenis_cuti')->first();

                            for($date = Carbon::parse($cuti->tgl_mulai);$date->lte(Carbon::parse($cuti->tgl_selesai)); $date->addDay())
                            {
                                $cek = Tidakmasuk::where('id_pegawai', $cuti->id_karyawan)
                                    ->where('tanggal', $date->format('Y-m-d'))->first();
                                if(!$cek){
                                    $tidakmasuk = new Tidakmasuk;
                                    $tidakmasuk->id_pegawai = $cuti->id_karyawan;
                                    $tidakmasuk->nama       = $nama->nama;
                                    $tidakmasuk->divisi     = $nama->divisi;
                                    $tidakmasuk->status     = $reason->jenis_cuti;
                                    $tidakmasuk->tanggal    = $date->format('Y-m-d');
                                    $tidakmasuk->save();

                                    $this->jumlahimporttidakmasuk++;
                                }
                            }
                        }
                        else
                        {
                            $izin = Izin::where('id_karyawan','=',$karyawan->id)
                                ->whereDate('tgl_mulai', '<=', $tgl)
                                ->whereDate('tgl_selesai', '>=', $tgl)
                                ->where('status',7)
                                ->select('izin.id','izin.id_karyawan','izin.id_jenisizin','izin.tgl_mulai','izin.tgl_selesai','izin.status')
                                ->first();

                            if($izin !== NULL)
                            {
                                 //selain 5 karena id 5 itu izin pada jam tertentu
                                 if($izin->id_jenisizin !== 5)
                                 {
                                     $reason = Jenisizin::where('id',$izin->id_jenisizin)
                                     ->select('jenis_izin')->first();

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

                                             $this->jumlahimporttidakmasuk++;

                                         }
                                     }
                                 }
                            } {
                                $cek = Tidakmasuk::where('id_pegawai', $karyawan->id)->where('tanggal',$tgl)->first();
                                if(!$cek)
                                {
                                    $nama = Karyawan::where('nik',$row['NIK'])
                                           ->where('partner',Auth::user()->partner)
                                           ->first();
                                    $tidakmasuk = new Tidakmasuk;
                                    $tidakmasuk->id_pegawai = $nama->id;
                                    $tidakmasuk->nama       = $nama->nama;
                                    $tidakmasuk->divisi     = $nama->divisi;
                                    $tidakmasuk->status     = 'tanpa keterangan';
                                    $tidakmasuk->tanggal    = $tgl;

                                    $tidakmasuk->save();

                                    $this->jumlahimporttidakmasuk++;
                                    Log::info('Data '. $row['NIK'] . $row['Tanggal']. ' berhasil diimport ke Tidak suk');
                                }
                                else{
                                    $this->datatidakbisadiimport++;
                                    Log::info('Data tidak masuk karyawan sudah ada');
                                }
                            }
                        }

                    }else
                    {

                        $jam_csv = [
                            'jam_masuk'   => $row['jam_masuk'],
                            'jam_pulang'  => $row['jam_pulang'],
                            'scan_masuk'  => $row['scan_masuk'],
                            'scan_pulang' => $row['scan_pulang'],
                            'terlambat'   => $row['terlambat'],
                            'plg_cpt'     => $row['plg_cepat'],
                            'lembur'      => $row['lembur'],
                            'jam_kerja'   => $row['jml_jam_kerja'],
                            'jml_hadir'   => $row['jml_kehadiran'],
                        ];

                        $formatted_jam = [];
                        foreach ($jam_csv as $key => $value)
                        {
                            if($value !== NULL)
                            {
                                $exploded_value = explode(':', $value);
                                $hours = intval($exploded_value[0]);

                                // Hanya memproses data dengan format jam antara 0 hingga 9
                                if ($hours >= 0 && $hours <= 9) {
                                    $hours = sprintf('%02d', $hours);
                                    $minutes = sprintf('%02d', intval($exploded_value[1]));
                                    $formatted_jam[$key] = $hours . ':' . $minutes;
                                } else {
                                    $formatted_jam[$key] = $value; // Menyimpan nilai asli jika format jam tidak perlu diubah
                                }
                            }else{
                                $formatted_jam[$key] = $value;
                            }
                        }

                        $data = [
                            'id_karyawan'   => $karyawan->id,
                            'nik'           => $karyawan->nip ?? null,
                            'tanggal'       => $tgl,
                            'shift'         => null,
                            'jadwal_masuk'  => isset($formatted_jam['jam_masuk']) ? $formatted_jam['jam_masuk'] : null,
                            'jadwal_pulang' => isset($formatted_jam['jam_pulang']) ? $formatted_jam['jam_pulang'] : null,
                            'jam_masuk'    => isset($formatted_jam['scan_masuk']) ? $formatted_jam['scan_masuk'] : null,
                            'jam_keluar'   => isset($formatted_jam['scan_pulang']) ? $formatted_jam['scan_keluar'] : null,
                            'terlambat'     => isset($formatted_jam['terlambat']) ? $formatted_jam['terlambat'] : null,
                            'plg_cepat'     => isset($formatted_jam['plg_cpt']) ? $formatted_jam['plg_cpt'] : null,
                            'absent'        => null,
                            'lembur'        => isset($formatted_jam['lembur']) ? $formatted_jam['lembur'] : null,
                            'id_departement'=> $karyawan->divisi,
                            'jml_jamkerja'  => isset($formatted_jam['jml_jam_kerja']) ? $formatted_jam['jml_jam_kerja'] : null,
                            'jam_kerja'     => isset($formatted_jam['jml_kehadiran']) ? $formatted_jam['jml_kehadiran'] : null,
                        ];
                        // dd($data);
                        Absensi::create($data);
                        $this->jumlahdatadiimport++;
                        Log::info('Data '. $row['nik'] . ' '. $row['tanggal']. ' berhasil di import ke database Absensi');
                    }
                }else{
                     // Hitung jumlah data berdasarkan id_karyawan dan tanggal pada file Excel
                     $this->datatidakbisadiimport++;
                     Log::info('Data '. $row['nik'] . $row['tanggal']. ' sudah ada di sistem');
                }
            }
            else
            {
                $this->datatidakbisadiimport++;
                Log::info('Karyawan '. $row['emp_no'] . ' tidak terdaftar di sistem');
            }
        }
        else
        {
            $this->datatidakbisadiimport++;
            $this->jumlahdata++;
            Log::info('NIK karyawan kosong');
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
    //      //if(isset($row['nama']) && isset($row['tanggal']))
    //     if(isset($row['nama']) && isset($row['tanggal']) && isset($row['NIK']))

    //     {
    //         // dd($row['nama']);
    //         $this->jumlahdata++;
    //         $jumlahDatasudahada = 0;
    //         $jumlahKaryawanTidakTerdaftar = 0;
    //         $tidakbisa = 0;

    //         //$nama_map = Karyawan::whereRaw('LOWER(nama) = ?', strtolower($row['nama']))->first();
    //         // dd($nama_map);
    //         $nama_map = Karyawan::whereRaw('LOWER(nama) = ?', strtolower($row['nama']))
    //                 ->where('nip', $row['NIK'])
    //                 ->first();

    //         $karyawan = null;
    //         if($nama_map)
    //         {
    //             $karyawan = Karyawan::where('nama', $nama_map->nama)->where('nip',$nama_map->nip)->first();
    //         }

    //         if ($karyawan)
    //         {
    //             // dd($karyawan);
    //             $tanggal = $row['tanggal'];
    //             $carbonDate = Carbon::createFromFormat('m/d/Y', $tanggal);
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

    //                     $jam_csv = [
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
    //                     foreach ($jam_csv as $key => $value)
    //                     {
    //                         if($value !== NULL)
    //                         {
    //                             $exploded_value = explode(':', $value);
    //                             $hours = intval($exploded_value[0]);

    //                             // Hanya memproses data dengan format jam antara 0 hingga 9
    //                             if ($hours >= 0 && $hours <= 9) {
    //                                 $hours = sprintf('%02d', $hours);
    //                                 $minutes = sprintf('%02d', intval($exploded_value[1]));
    //                                 $formatted_jam[$key] = $hours . ':' . $minutes;
    //                             } else {
    //                                 $formatted_jam[$key] = $value; // Menyimpan nilai asli jika format jam tidak perlu diubah
    //                             }
    //                         }else{
    //                             $formatted_jam[$key] = $value;
    //                         }
    //                     }

    //                     // dd($formatted_jam);
    //                     $terlambat = sprintf('%02d:%02d', floor($row['terlambat'] / 60), $row['terlambat'] % 60);

    //                     $data = [
    //                         'no_id'         => null,
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
