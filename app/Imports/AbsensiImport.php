<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Cuti;
use App\Models\Izin;
use App\Models\Absensi;
use App\Models\Karyawan;
use App\Models\Jeniscuti;
use App\Models\Jenisizin;
use App\Models\Tidakmasuk;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class AbsensiImport implements ToModel,WithHeadingRow
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
        static $counter = 0;
        dd($row);
        if(isset($row['nik']) && isset($row['tanggal']))
        {
            // dd($row);
            $this->jumlahdata++;
            // Inisialisasi jumlah data yang sudah ada menjadi 0
            $jumlahDatasudahada = 0;
            $jumlahKaryawanTidakTerdaftar = 0; 
            $tidakbisa = 0;

            $karyawan = Karyawan::where('nik', $row['nik'])->first();
            // dd($karyawan);

            if (isset($karyawan))
            {
                // dd($karyawan);
                // dd($row,$karyawan);
                $tgl = \Carbon\Carbon::createFromFormat('d/m/Y', $row['tanggal'])->format('Y-m-d');
                $absensicek = !Absensi::where('id_karyawan',$karyawan->id)->where('tanggal',$tgl)->first();
                // dd($absensicek);
                if($absensicek)
                {
                    $scan_masuk = $row['scan_masuk'];
                    $scan_pulang= $row['scan_pulang'];
                    // dd($scan_masuk, $scan_pulang);
                    if($scan_masuk === "" && $scan_pulang === "")
                    {
                        $cuti = Cuti::where('id_karyawan', $karyawan->id)
                            ->whereDate('tgl_mulai', '<=', $tgl)
                            ->whereDate('tgl_selesai', '>=', $tgl)
                            ->where('status', 7)
                            ->select('cuti.id as id_cuti','cuti.id_karyawan','cuti.id_jeniscuti','cuti.tgl_mulai','cuti.tgl_selesai','cuti.status')
                            ->first();
                        // dd($cuti);
                        $nama = Karyawan::where('id',$karyawan->id)->select('nama','divisi')->first();
                        if($cuti !== NULL) 
                        {
                            // dd($cuti,$row,$nama);
                            // dd($cuti);
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
                                ->whereDate('tgl_mulai', '<=', $tgl)
                                ->whereDate('tgl_selesai', '>=', $tgl)
                                ->where('status',7)
                                ->select('izin.id','izin.id_karyawan','izin.id_jenisizin','izin.tgl_mulai','izin.tgl_selesai','izin.status')
                                ->first();
                            // dd($izin);
                            if($izin !== NULL)
                            {
                                // dd($izin);
                                if($izin->id_jenisizin !== 5)
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
                            }
                            else
                            {
                                // dd($izin);
                                $cek = Tidakmasuk::where('id_pegawai', $karyawan->id)->where('tanggal',$tgl)->first();
                                // dd($cek);
                                //jika tidak ada data atau $cek == null
                                if(!$cek)
                                {
                                    // dd($cek);
                                    $nama = Karyawan::where('nik',$row['nik'])->first();
                                    // dd($nama);
                                    $tidakmasuk = new Tidakmasuk;
                                    $tidakmasuk->id_pegawai = $nama->id;
                                    $tidakmasuk->nama       = $nama->nama;
                                    $tidakmasuk->divisi     = $nama->divisi;
                                    $tidakmasuk->status     = 'tanpa keterangan';
                                    $tidakmasuk->tanggal    = $tgl;
                            
                                    // dd($tidakmasuk);
                                    $tidakmasuk->save();
                                    // dd($tidakmasuk);

                                    $this->jumlahDataTidakMasuk++;
                                    $this->jumlahimporttidakmasuk++;
                                }
                                else{

                                    return $cek;
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
                        // dd($scan_masuk, $scan_pulang,$row);
                        $jam_excel = [
                            'jam_masuk'   => $row['jam_masuk'],
                            'jam_pulang'  => $row['jam_pulang'],
                            'scan_masuk'  => $row['scan_masuk'],
                            'scan_pulang' => $row['scan_pulang'],
                            'terlambat'   => $row['terlambat'],
                            'plg_cepat'   => $row['plg_cepat'],
                            'lembur'      => $row['lembur'],
                            'jml_jam_kerja'   => $row['jml_jam_kerja'],
                            'jml_kehadiran'   => $row['jml_kehadiran'],
                        ];
                        // dd($row,$karyawan,$jam_excel);
                        
                        $formatted_jam = [];
                        
                        foreach ($jam_excel as $key => $value) {
                            if (!empty($value)) {
                                $time = Carbon::createFromFormat('H.i', $value); // Create Carbon instance from the time string
                                $formatted_jam[$key] = $time->format('H:i:s'); // Format the time as HH:MM:SS
                            } else {
                                $formatted_jam[$key] = null; // Assign null if the value is empty
                            }
                        }
                        // dd($row,$karyawan,$jam_excel,$formatted_jam);
            
                        $data = [
                            'id_karyawan'   => $karyawan->id,
                            'nik'           => $karyawan->nip ?? null,
                            'tanggal'       => $tgl,
                            'shift'         => null,
                            'jadwal_masuk'  => isset($formatted_jam['jam_masuk']) ? $formatted_jam['jam_masuk'] : null,
                            'jadwal_pulang' => isset($formatted_jam['jam_pulang']) ? $formatted_jam['jam_pulang'] : null,
                            'jam_masuk'     => isset($formatted_jam['scan_masuk']) ? $formatted_jam['scan_masuk'] : null,
                            'jam_keluar'    => isset($formatted_jam['scan_pulang']) ? $formatted_jam['scan_pulang'] : null,
                            'normal'        => null,
                            'riil'          => null,
                            'terlambat'     => isset($formatted_jam['terlambat']) ? $formatted_jam['terlambat'] : null,
                            'plg_cepat'     => isset($formatted_jam['plg_cepat']) ? $formatted_jam['plg_cepat'] : null,
                            'absent'        => null,
                            'lembur'        => isset($formatted_jam['lembur']) ? $formatted_jam['lembur'] : null,
                            'jml_jamkerja'  => isset($formatted_jam['jml_jam_kerja']) ? $formatted_jam['jml_jam_kerja'] : null,
                            'pengecualian'  => null,
                            'hci'           => null,
                            'hco'           => null,
                            'id_departement'=> $karyawan->divisi,
                            'h_normal'      => null,
                            'ap'            => null,
                            'hl'            => null,
                            'jam_kerja'     => isset($formatted_jam['jml_kehadiran']) ? $formatted_jam['jml_kehadiran'] : null,
                            'lemhanor'      => null,
                            'lemakpek'      => null,
                            'lemhali'       => null,                
                        ];
                        //  dd($data);
                        $absensi = Absensi::create($data);
                        // dd($absensi,$absensi->id);
                        $this->jumlahdatadiimport++;
                    }
                }
                else
                {
                    // Hitung jumlah data berdasarkan id_karyawan dan tanggal pada file Excel
                    $this->datatidakbisadiimport++;
                    $jumlahKaryawanTidakTerdaftar++;
                    $tidakbisa++;
                    Log::info('JUMLAH DATA TIDAK BISA DIIMPORT KE  DATABASE: : ' . $tidakbisa);    
                         
                }
            }
            else
            {
                // dd($row);
                $this->datatidakbisadiimport++;
                $jumlahKaryawanTidakTerdaftar++;
                $tidakbisa++;
                // dd($row,$this->datatidakbisadiimport++);
                // dd($tidakbisa);
                Log::info('TIDAK BISA DIIMPORT KE  DATABASE: : ' . $tidakbisa);                
                Log::info('Jumlah data absensi dengan karyawan tidak terdaftar: ' . $jumlahKaryawanTidakTerdaftar);                
            }
        }
        elseif($row['nik'] === NULL)
        {
            // dd($row);
            Log::info('NIK karyawan kosong');
        }
        else
        {
            // $this->datatidakbisadiimport++;
            dd($row);
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

    // public function model(array $row)
    // {
        // static $counter = 0;
        // if(isset($row['nik']) && isset($row['tanggal']))
        // if(isset($row['nik']) && isset($row['tanggal']))
        // {
        //     $this->jumlahdata++;
            // Inisialisasi jumlah data yang sudah ada menjadi 0
            // $jumlahDatasudahada = 0;
            // $jumlahKaryawanTidakTerdaftar = 0; 
            // $tidakbisa = 0;

            // $departments = Departemen::pluck('id', 'nama_departemen')->toArray();
            // $departement_map = isset($departments[$row['departemen']]) ? $departments[$row['departemen']] : 0;
            // $karyawan = Karyawan::where('id', $row['nik'])
            //     ->where('divisi', $departement_map)
            //     ->first();
            // $departement_map = Departemen::where('nama_departemen', $row['departemen'])->first();
            // $departement_map = Departemen::whereRaw('LOWER(nama_departemen) = ?', strtolower($row['departemen']))->first();
            // if ($departement_map) {
            //     $karyawan = Karyawan::where('id', $row['nik'])
            //         ->where('divisi', $departement_map->id)
            //         ->first();
            // }
            // $karyawan = Karyawan::where('nik', $row['nik'])->first();

            // if ($karyawan)
            // {
            //     if(!Absensi::where('id_karyawan',$karyawan->id)->where('tanggal',Carbon::parse($row['tanggal'])->format("Y-m-d"))->exists())
            //     {
                    // $departments = Departemen::pluck('id', 'nama_departemen')->toArray();
                    // $departement_map = isset($departments[$row['departemen']]) ? $departments[$row['departemen']] : 0;
                // $departement_map = Departemen::where('nama_departemen', $row['departemen'])->first();
                    // $departement_map = Departemen::whereRaw('LOWER(nama_departemen) = ?', strtolower($row['departemen']))->first();
                    // $tanggal = $row['tanggal'];
                    // $tanggal = trim($tanggal);
                    // $objTanggal = Carbon::createFromFormat('d/m/Y', $tanggal)->format('Y-m-d');
                    // $tgl = Carbon::createFromFormat('Y-m-d', $objTanggal);                

                    // Ubah format objek Carbon menjadi objek DateTime
                    // $objTanggal = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($objTanggal);
                    // $tgl = $objTanggal->format("Y-m-d");
                    // $tgl = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal'])->format("Y-m-d");

                    // Inisialisasi jumlah data dari excel yang masuk ke tabel tidak masuk


                    // if($row['absent'] == 'True')
                    // {
                    //     //pengecekan ke data cuti apakah ada atau tidak
                    //     $cuti = Cuti::where('id_karyawan', $row['nik'])
                    //         ->whereBetween('tgl_mulai', [$tgl,$tgl])->OrwhereBetween('tgl_selesai',[$tgl,$tgl])
                    //         ->where('status', 7)
                    //         ->select('cuti.id as id_cuti','cuti.id_karyawan','cuti.id_jeniscuti','cuti.tgl_mulai','cuti.tgl_selesai','cuti.status')
                    //         ->first();

                    //     $nama = Karyawan::where('id',$row['nik'])->select('nama')->first();
                    //     if($cuti) 
                    //     {
                    //         // dd($cuti,$row,$nama);
                    //         $reason = Jeniscuti::where('id',$cuti->id_jeniscuti)->select('jenis_cuti')->first();

                    //         for($date = Carbon::parse($cuti->tgl_mulai);$date->lte(Carbon::parse($cuti->tgl_selesai)); $date->addDay())
                    //         {
                    //             $cek = Tidakmasuk::where('id_pegawai', $cuti->id_karyawan)->where('tanggal', $date->format('Y-m-d'))->first();
                    //             if(!$cek){
                    //                 $tidakmasuk = new Tidakmasuk;
                    //                 $tidakmasuk->id_pegawai = $cuti->id_karyawan;
                    //                 $tidakmasuk->nama       = $nama->nama;
                    //                 $tidakmasuk->divisi = $departement_map->id;
                    //                 $tidakmasuk->status     = $reason->jenis_cuti;
                    //                 $tidakmasuk->tanggal    = $date->format('Y-m-d');
                    //                 $tidakmasuk->save();

                    //                 $this->jumlahDataTidakMasuk++; // Increment jumlah data tidak masuk
                    //                 $this->jumlahimporttidakmasuk++;
                    //             }
                    //         }
                    //     }
                    //     else
                    //     {
                    //         // dd($tgl);
                    //         $izin = Izin::where('id_karyawan','=',$row['nik'])
                    //             ->whereBetween('tgl_mulai', [$tgl,$tgl])->orWhereBetween('tgl_selesai',[$tgl,$tgl])
                    //             ->where('status',7)
                    //             ->select('izin.id','izin.id_karyawan','izin.id_jenisizin','izin.tgl_mulai','izin.tgl_selesai','izin.status')
                    //             ->first();
                    //         // $nama = Karyawan::where('id',$row['nik'])->select('nama')->first();
                    //         // dd($tgl,$izin,$nama->nama);

                    //         if($izin)
                    //         {
                    //             if($izin->id_jenisizin == 3)
                    //             {
                    //                 $reason = Jenisizin::where('id',$izin->id_jenisizin)->select('jenis_izin')->first();

                    //                 for($date = Carbon::parse($izin->tgl_mulai);$date->lte(Carbon::parse($izin->tgl_selesai)); $date->addDay())
                    //                 {
                    //                     $cek = Tidakmasuk::where('id_pegawai', $izin->id_karyawan)->where('tanggal', $date->format('Y-m-d'))->first();
                    //                     if(!$cek)
                    //                     {
                    //                         $tidakmasuk = new Tidakmasuk;
                    //                         $tidakmasuk->id_pegawai = $izin->id_karyawan;
                    //                         $tidakmasuk->nama       = $nama->nama;
                    //                         $tidakmasuk->divisi = $departement_map->id;
                    //                         //$tidakmasuk->divisi     = isset($departement_map[$row['departemen']]) ? $departement_map[$row['departemen']] : 0;
                    //                         $tidakmasuk->status     = $reason->jenis_izin;
                    //                         $tidakmasuk->tanggal    = $date->format('Y-m-d');
                    //                         $tidakmasuk->save();

                    //                         $this->jumlahDataTidakMasuk++;// Increment jumlah data tidak masuk
                    //                         $this->jumlahimporttidakmasuk++;
                    //                         // Log::info('Jumlah data karyawan tidakmasuk '.  $jumlahDataTidakMasuk);  
                                            
                    //                     }
                    //                 }
                    //             }
                    //         }
                    //         else
                    //         {
                    //             //$cek = Tidakmasuk::where('id_pegawai', $row['nik'])->where('tanggal',\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal'])->format("Y-m-d"))->first();
                    //             $cek = Tidakmasuk::where('id_pegawai', $row['nik'])->where('tanggal', Carbon::createFromFormat('m/d/Y', $row['tanggal'])->format("Y-m-d"))->first();
                    //             if(!$cek)
                    //             {
                    //                 $nama = Karyawan::where('id',$row['nik'])->select('nama')->first();

                    //                 $tidakmasuk = new Tidakmasuk;
                    //                 $tidakmasuk->id_pegawai = $row['nik'];
                    //                 $tidakmasuk->nama       = $nama->nama;
                    //                 $tidakmasuk->divisi = $departement_map->id;
                    //                 //$tidakmasuk->divisi     = isset($departement_map[$row['departemen']]) ? $departement_map[$row['departemen']] : 0;
                    //                 $tidakmasuk->status     = 'tanpa keterangan';
                    //                 $tidakmasuk->tanggal    = Carbon::createFromFormat('m/d/Y', $row['tanggal'])->format('Y-m-d');
                    //                 //$tidakmasuk->tanggal    = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal'])->format("Y-m-d");
                    //                 $tidakmasuk->save();

                    //                 // $jumlahDataTidakMasuk =  $jumlahDataTidakMasuk + 1; // Increment jumlah data tidak masuk
                    //                 $this->jumlahDataTidakMasuk++;
                    //                 $this->jumlahimporttidakmasuk++;
                    //                 // Log::info('Jumlah data karyawan tidakmasuk '.  $jumlahDataTidakMasuk);  

                    //                 //PENGURANGAN JATAH CUTI TAHUNAN
                    //                 // $alokasicuti = Alokasicuti::where('id_jeniscuti','=',1)
                    //                 //     ->where('id_karyawan',  $tidakmasuk->id_pegawai)
                    //                 //     ->first();
                    //                 // $durasi_baru = $alokasicuti->durasi - 1;

                    //                 // //update durasi di alokasicutikaryawan
                    //                 // Alokasicuti::where('id_jeniscuti',$alokasicuti->id_jeniscuti)
                    //                 //     ->where('id_karyawan',  $tidakmasuk->id_pegawai)
                    //                 //     ->update(
                    //                 //         ['durasi' => $durasi_baru]
                    //                 // );

                    //                 // $epegawai = Karyawan::select('email as email','nama as nama')->where('id','=',$tidakmasuk->id_pegawai)->first();
                    //                 // $tujuan = $epegawai->email;
                    //                 // $data = [
                    //                 //     'subject'     =>'Notifikasi Pengurangan Jatah Cuti Tahunan',
                    //                 //     'id'          =>$alokasicuti->id_jeniscuti,
                    //                 //     'id_jeniscuti'=>$alokasicuti->jeniscutis->jenis_cuti,
                    //                 //     'keterangan'   =>$tidakmasuk->status,
                    //                 //     'tanggal'     =>Carbon::parse($tidakmasuk->tanggal)->format("d M Y"),
                    //                 //     'jml_cuti'    =>1,
                    //                 //     'nama'        =>$epegawai->nama,
                    //                 //     'jatahcuti'   =>$durasi_baru,
                    //                 // ];
                    //                 // Mail::to($tujuan)->send(new TidakmasukNotification($data));
                    //                 // return redirect()->back();
                    //                 // dd($nama,$tidakmasuk,$alokasicuti,$durasi_baru,$epegawai,$tujuan,$data);
                    //             }
                    //             else{
                    //                 $this->datatidakbisadiimport++;
                    //                 $this->tidakmasukdatabse++;
                    //                 $tidakbisa++;
                    //                 Log::info('JUMLAH DATA TIDAK BISA DIIMPORT KE  DATABASE: : ' . $tidakbisa);         
                    //                 Log::info('Data tidak masuk karyawan sudah ada');
                    //             }
                    //         } 
                    //     }
                    // }else
                    // {
                        // dd($row);
                        //'tanggal'       => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal'])->format("Y-m-d"),
                        //'id_departement'=> isset($departement_map[$row['departemen']]) ? $departement_map[$row['departemen']] : null,
                        // $data = [
                        //     'id_karyawan'   => $row['nik'],
                        //     'nik'           => $row['nik'] ?? null,
                        //     'tanggal'       => Carbon::createFromFormat('m/d/Y', $row['tanggal'])->format('Y-m-d'),
                        //     'shift'         => $row['jam_kerja'] ?? null,
                        //     'jadwal_masuk'  => $row['jam_masuk'] ?? null,
                        //     'jadwal_pulang' => $row['jam_pulang'] ?? null,
                        //     'jam_masuk'     => $row['scan_masuk'] ?? null,
                        //     'jam_keluar'    => $row['scan_pulang'] ?? null,
                        //     'normal'        => $row['normal'] ?? null,
                        //     'riil'          => (Double) $row['riil'] ?? null,
                        //     'terlambat'     => $row['terlambat'] ?? null,
                        //     'plg_cepat'     => $row['plg_cepat'] ?? null,
                        //     'absent'        => $row['absent'] ?? null,
                        //     'lembur'        => $row['lembur'] ?? null,
                        //     'jml_jamkerja'  => $row['jml_jam_kerja'] ?? null,
                        //     'pengecualian'  => $row['pengecualian'] ?? null,
                        //     'hci'           => $row['harus_cin'],
                        //     'hco'           => (String) $row['harus_cout'],
                        //     'id_departement'=> $departement_map ? $departement_map->id : null,
                        //     'h_normal'      => (Double) $row['hari_normal']?? null,
                        //     'ap'            => (Double) $row['akhir_pekan']?? null,
                        //     'hl'            => (Double) $row['hari_libur']?? null,
                        //     'jam_kerja'     => $row['jml_kehadiran'] ?? null,
                        //     'lemhanor'      => (Double) $row['lembur_hari_normal'] ?? null,
                        //     'lemakpek'      => (Double) $row['lembur_akhir_pekan'] ?? null,
                        //     'lemhali'       => (Double) $row['lembur_hari_libur'] ?? null,                
                        // ];
                        //  dd($data);
                //         Absensi::create($data);
                //         $this->jumlahdatadiimport++;
                //     }
                // }
                // else
                // {
                    // Hitung jumlah data berdasarkan id_karyawan dan tanggal pada file Excel
            //         $this->datatidakbisadiimport++;
            //         $jumlahDatasudahada = Absensi::where('id_karyawan', $row['nik'])
            //             ->where('tanggal', Carbon::parse($row['tanggal'])->format('Y-m-d'))
            //             ->count();

            //         Log::info('Jumlah id karaywan dan tanggal absensi sudah ada: '. $jumlahDatasudahada);  
            //         $tidakbisa++;
            //         Log::info('JUMLAH DATA TIDAK BISA DIIMPORT KE  DATABASE: : ' . $tidakbisa);         
            //     }
            // }
            // else
            // {
            //     $this->datatidakbisadiimport++;
            //     $jumlahKaryawanTidakTerdaftar++;
            //     $tidakbisa++;
        //         Log::info('JUMLAH DATA TIDAK BISA DIIMPORT KE  DATABASE: : ' . $tidakbisa);                
        //         Log::info('Jumlah data absensi dengan karyawan tidak terdaftar: ' . $jumlahKaryawanTidakTerdaftar);                
        //     }
        // }
        // else
        // {
        //     Log::info('Row 1 kosong');
        // }
    
    // }

