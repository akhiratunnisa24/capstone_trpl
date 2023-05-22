<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Cuti;
use App\Models\Izin;
use App\Models\Absensi;
use App\Models\Karyawan;
use App\Models\Jeniscuti;
use App\Models\Jenisizin;
use App\Models\Departemen;
use App\Models\Tidakmasuk;
use Illuminate\Support\Facades\Log;
use App\Mail\TidakmasukNotification;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AttendanceImport implements ToModel,WithHeadingRow
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

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    private $jumlahdatadiimport = 0;
    private $jumlahDataTidakMasuk = 0;
    private $tidakmasukdatabse = 0;
    private $jumlahdata = 0; //jumlah data keseluruhan
    private $jumlahimporttidakmasuk = 0;
    private $datatidakbisadiimport = 0;

    public function model(array $row)
    {
        if(isset($row['emp_no']) && isset($row['tanggal']))
        {
            $this->jumlahdata++;
            $jumlahKaryawanTidakTerdaftar = 0;
            $jumlahDatasudahada = 0;

            if(!Absensi::where('id_karyawan',$row['emp_no'])->where('tanggal',Carbon::parse($row['tanggal'])->format("Y-m-d"))->exists())
            {
                // $departement_map = Departemen::where('nama_departemen', $row['departemen'])->first();
                $departement_map = Departemen::whereRaw('LOWER(nama_departemen) = ?', strtolower($row['departemen']))->first();
                if ($departement_map) {
                    $karyawan = Karyawan::where('id', $row['emp_no'])
                        ->where('divisi', $departement_map->id)
                        ->first();
                }

                if($karyawan)
                {
                    if(!Absensi::where('id_karyawan',$row['emp_no'])->where('tanggal',Carbon::parse($row['tanggal'])->format("Y-m-d"))->exists())
                    {
                        // $departement_map = Departemen::where('nama_departemen', $row['departemen'])->first();
                        $departement_map = Departemen::whereRaw('LOWER(nama_departemen) = ?', strtolower($row['departemen']))->first();
                        $tanggal = $row['tanggal'];
                        $tanggal = trim($tanggal);
                        $objTanggal = Carbon::createFromFormat('m/d/Y', $tanggal)->format('Y-m-d');
                        $tgl = Carbon::createFromFormat('Y-m-d', $objTanggal);                
    
                        if($row['absent'] == 'True')
                        {
                            //pengecekan ke data cuti apakah ada atau tidak
                            $cuti = Cuti::where('id_karyawan', $row['emp_no'])
                                ->whereBetween('tgl_mulai', [$tgl,$tgl])->OrwhereBetween('tgl_selesai',[$tgl,$tgl])
                                ->where('status', 7)
                                ->select('cuti.id as id_cuti','cuti.id_karyawan','cuti.id_jeniscuti','cuti.tgl_mulai','cuti.tgl_selesai','cuti.status')
                                ->first();
    
                            $nama = Karyawan::where('id',$row['emp_no'])->select('nama')->first();
                            if($cuti) 
                            {
                                // dd($cuti,$row,$nama);
                                $reason = Jeniscuti::where('id',$cuti->id_jeniscuti)->select('jenis_cuti')->first();
    
                                for($date = Carbon::parse($cuti->tgl_mulai);$date->lte(Carbon::parse($cuti->tgl_selesai)); $date->addDay())
                                {
                                    $cek = Tidakmasuk::where('id_pegawai', $cuti->id_karyawan)->where('tanggal', $date->format('Y-m-d'))->first();
                                    if(!$cek){
                                        $tidakmasuk = new Tidakmasuk;
                                        $tidakmasuk->id_pegawai = $cuti->id_karyawan;
                                        $tidakmasuk->nama       = $nama->nama;
                                        $tidakmasuk->divisi = $departement_map->id;
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
                                $izin = Izin::where('id_karyawan','=',$row['emp_no'])
                                    ->whereBetween('tgl_mulai', [$tgl,$tgl])->orWhereBetween('tgl_selesai',[$tgl,$tgl])
                                    ->where('status',7)
                                    ->select('izin.id','izin.id_karyawan','izin.id_jenisizin','izin.tgl_mulai','izin.tgl_selesai','izin.status')
                                    ->first();
                               
                                if($izin)
                                {
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
                                                $tidakmasuk->divisi = $departement_map->id;
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
                                    $cek = Tidakmasuk::where('id_pegawai', $row['emp_no'])->where('tanggal', Carbon::createFromFormat('m/d/Y', $row['tanggal'])->format("Y-m-d"))->first();
                                    if(!$cek)
                                    {
                                        $nama = Karyawan::where('id',$row['emp_no'])->select('nama')->first();
    
                                        $tidakmasuk = new Tidakmasuk;
                                        $tidakmasuk->id_pegawai = $row['emp_no'];
                                        $tidakmasuk->nama       = $nama->nama;
                                        $tidakmasuk->divisi = $departement_map->id;
                                        $tidakmasuk->status     = 'tanpa keterangan';
                                        $tidakmasuk->tanggal    = Carbon::createFromFormat('m/d/Y', $row['tanggal'])->format('Y-m-d');
                                        $tidakmasuk->save();
    
                                        $this->jumlahDataTidakMasuk++;
                                        $this->jumlahimporttidakmasuk++;
                                        // Log::info('Jumlah data karyawan tidakmasuk '.  $jumlahDataTidakMasuk);  
    
                                        //PENGURANGAN JATAH CUTI TAHUNAN
                                        // $alokasicuti = Alokasicuti::where('id_jeniscuti','=',1)
                                        //     ->where('id_karyawan',  $tidakmasuk->id_pegawai)
                                        //     ->first();
                                        // $durasi_baru = $alokasicuti->durasi - 1;
    
                                        // //update durasi di alokasicutikaryawan
                                        // Alokasicuti::where('id_jeniscuti',$alokasicuti->id_jeniscuti)
                                        //     ->where('id_karyawan',  $tidakmasuk->id_pegawai)
                                        //     ->update(
                                        //         ['durasi' => $durasi_baru]
                                        // );
    
                                        // $epegawai = Karyawan::select('email as email','nama as nama')->where('id','=',$tidakmasuk->id_pegawai)->first();
                                        // $tujuan = $epegawai->email;
                                        // $data = [
                                        //     'subject'     =>'Notifikasi Pengurangan Jatah Cuti Tahunan',
                                        //     'id'          =>$alokasicuti->id_jeniscuti,
                                        //     'id_jeniscuti'=>$alokasicuti->jeniscutis->jenis_cuti,
                                        //     'keterangan'   =>$tidakmasuk->status,
                                        //     'tanggal'     =>Carbon::parse($tidakmasuk->tanggal)->format("d M Y"),
                                        //     'jml_cuti'    =>1,
                                        //     'nama'        =>$epegawai->nama,
                                        //     'jatahcuti'   =>$durasi_baru,
                                        // ];
                                        // Mail::to($tujuan)->send(new TidakmasukNotification($data));
                                        // return redirect()->back();
                                        // dd($nama,$tidakmasuk,$alokasicuti,$durasi_baru,$epegawai,$tujuan,$data);
                                    }
                                    else{
                                        $this->datatidakbisadiimport++;
                                        $this->tidakmasukdatabse++;
                                        Log::info('Data tidak masuk karyawan sudah ada');
                                    }
                                } 
                            }
                        }else
                        {
                            $data = [
                                'id_karyawan'   => $row['emp_no'],
                                'nik'           => $row['nik'] ?? null,
                                'tanggal'       => Carbon::createFromFormat('m/d/Y', $row['tanggal'])->format('Y-m-d'),
                                'shift'         => $row['jam_kerja'] ?? null,
                                'jadwal_masuk'  => $row['jam_masuk'] ?? null,
                                'jadwal_pulang' => $row['jam_pulang'] ?? null,
                                'jam_masuk'     => $row['scan_masuk'] ?? null,
                                'jam_keluar'    => $row['scan_pulang'] ?? null,
                                'normal'        => $row['normal'] ?? null,
                                'riil'          => (Double) $row['riil'] ?? null,
                                'terlambat'     => $row['terlambat'] ?? null,
                                'plg_cepat'     => $row['plg_cepat'] ?? null,
                                'absent'        => $row['absent'] ?? null,
                                'lembur'        => $row['lembur'] ?? null,
                                'jml_jamkerja'  => $row['jml_jam_kerja'] ?? null,
                                'pengecualian'  => $row['pengecualian'] ?? null,
                                'hci'           => $row['harus_cin'],
                                'hco'           => (String) $row['harus_cout'],
                                'id_departement'=> $departement_map ? $departement_map->id : null,
                                'h_normal'      => (Double) $row['hari_normal']?? null,
                                'ap'            => (Double) $row['akhir_pekan']?? null,
                                'hl'            => (Double) $row['hari_libur']?? null,
                                'jam_kerja'     => $row['jml_kehadiran'] ?? null,
                                'lemhanor'      => (Double) $row['lembur_hari_normal'] ?? null,
                                'lemakpek'      => (Double) $row['lembur_akhir_pekan'] ?? null,
                                'lemhali'       => (Double) $row['lembur_hari_libur'] ?? null,                
                            ];
                            //  dd($data);
                            Absensi::create($data);
                            $this->jumlahdatadiimport++;
                        }
                    }
                    else
                    {
                        $this->datatidakbisadiimport++;
                        $jumlahDatasudahada = Absensi::where('id_karyawan', $row['emp_no'])
                            ->where('tanggal', Carbon::parse($row['tanggal'])->format('Y-m-d'))
                            ->count();
    
                        Log::info('Jumlah id karaywan dan tanggal absensi sudah ada: '. $jumlahDatasudahada);  
                    }
                }
                else
                {
                    $this->datatidakbisadiimport++;
                    $jumlahKaryawanTidakTerdaftar++;
                    Log::info('Jumlah data absensi dengan karyawan tidak terdaftar: ' . $jumlahKaryawanTidakTerdaftar);                
                }
            }else
            {
                Log::info('id karaywan dan tanggal absensi sudah ada');
            }
        }else
        {
            Log::info('Row 1 kosong');
        }
    }

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
    
    //    public function model(array $row)
    // {
    //     if(isset($row[0]) && isset($row[2])) 
    //     {
    //         if(!Absensi::where('id_karyawan',$row[0])->where('tanggal',Carbon::parse($row[2])->format("Y-m-d"))->exists())
    //         {
    //             return new Absensi([
    //                 'id_karyawan'   => $row[0],
    //                 'nik'           => $row[1] ?? null,
    //                 'tanggal'       => Carbon::parse($row[2])->format("Y-m-d"),
    //                 'shift'         => $row[3] ?? null,
    //                 'jadwal_masuk'  => $row[4] ?? null,
    //                 'jadwal_pulang' => $row[5] ?? null,
    //                 'jam_masuk'     => $row[6] ?? null,
    //                 'jam_keluar'    => $row[7] ?? null,
    //                 'normal'        => $row[8] ?? null,
    //                 'riil'          => (Double) $row[9] ?? null,
    //                 'terlambat'     => $row[10] ?? null,
    //                 'plg_cepat'     => $row[11] ?? null,
    //                 'absent'        => (String) $row[12] ?? null,
    //                 'lembur'        => $row[13] ?? null,
    //                 'jml_jamkerja'  => $row[14] ?? null,
    //                 'pengecualian'  => $row[15] ?? null,
    //                 'hci'           => $row[16] ?? null,
    //                 'hco'           => $row[17] ?? null,
    //                 'id_departement'=> $row[18] ?? null,
    //                 'h_normal'      => (Double) $row[19] ?? null,
    //                 'ap'            => (Double) $row[20] ?? null,
    //                 'hl'            => (Double) $row[21] ?? null,
    //                 'jam_kerja'     => $row[22] ?? null,
    //                 'lemhanor'      => (Double) $row[23] ?? null,
    //                 'lemakpek'      => (Double) $row[24] ?? null,
    //                 'lemhali'       => (Double) $row[25] ?? null,
    //             ]);

    //             dd($row);
    //         }
    //         // else{
    //         //     Log::info('id karyawan dan tanggal absensi sudah ada');
    //         // }
    //     }
    //     // else{
    //     //     Log::info('Row 0  dan 2 kosong');
    //     // }
    // }
}
