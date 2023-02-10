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
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AbsensiImport implements ToModel,WithHeadingRow
{
    //untuk excel
    public function startRow(): int
    {
        return 2;
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if(isset($row['emp_no']) && isset($row['tanggal']))
        {
            if(!Absensi::where('id_karyawan',$row['emp_no'])->where('tanggal',Carbon::parse($row['tanggal'])->format("Y-m-d"))->exists())
            {
                $departement_map = [
                    'KONVENSIONAL' => 1,
                    'KEUANGAN' => 2,
                    'TEKNOLOGI INFORMASI' => 3,
                    'HUMAN RESOURCE' => 4,
                    'BOD'=> 5,
                    'BOARD OF DIRECTORS'=>5,
                ];

                $tgl = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal'])->format("Y-m-d");
                if($row['absent'] == 'True')
                {
                    
                    //pengecekan ke data cuti apakah ada atau tidak
                    $cuti = Cuti::where('id_karyawan', $row['emp_no'])
                        ->whereBetween('tgl_mulai', [$tgl,$tgl])->orWhereBetween('tgl_selesai',[$tgl,$tgl])
                        ->where('status', 'Disetujui')
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
                                $tidakmasuk->divisi     = $departement_map[$row['departemen']];
                                $tidakmasuk->status     = $reason->jenis_cuti;
                                $tidakmasuk->tanggal    = $date->format('Y-m-d');
                                $tidakmasuk->save();
                            }
                        }
                    }
                    else
                    {
                        // dd($tgl);
                        $izin = Izin::where('id_karyawan','=',$row['emp_no'])
                            ->whereBetween('tgl_mulai', [$tgl,$tgl])->orWhereBetween('tgl_selesai',[$tgl,$tgl])
                            ->where('status','Disetujui')
                            ->select('izin.id','izin.id_karyawan','izin.id_jenisizin','izin.tgl_mulai','izin.tgl_selesai','izin.status')
                            ->first();
                        // $nama = Karyawan::where('id',$row['emp_no'])->select('nama')->first();
                        // dd($tgl,$izin,$nama->nama);

                        if($izin)
                        {
                            // dd($tgl,$izin->id_jenisizin,$nama->nama);
                            if($izin->id_jenisizin == 3)
                            {
                                // dd($izin);
                                $reason = Jenisizin::where('id',$izin->id_jenisizin)->select('jenis_izin')->first();

                                for($date = Carbon::parse($izin->tgl_mulai);$date->lte(Carbon::parse($izin->tgl_selesai)); $date->addDay())
                                {
                                    $cek = Tidakmasuk::where('id_pegawai', $izin->id_karyawan)->where('tanggal', $date->format('Y-m-d'))->first();
                                    if(!$cek)
                                    {
                                        $tidakmasuk = new Tidakmasuk;
                                        $tidakmasuk->id_pegawai = $izin->id_karyawan;
                                        $tidakmasuk->nama       = $nama->nama;
                                        $tidakmasuk->divisi     = $departement_map[$row['departemen']];
                                        $tidakmasuk->status     = $reason->jenis_izin;
                                        $tidakmasuk->tanggal    = $date->format('Y-m-d');
                                        $tidakmasuk->save();
                                    }
                                }
                            }
                        }
                        // else
                        // {
                        //     $cek = Tidakmasuk::where('id_pegawai', $row['emp_no'])->where('tanggal',\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal'])->format("Y-m-d"))->first();
                        //     dd($row);
                        //     if(!$cek)
                        //     {
                        //         $tidakmasuk = new Tidakmasuk;
                        //         $tidakmasuk->id_pegawai = $row['emp_no'];
                        //         $tidakmasuk->nama       = $nama->nama;
                        //         $tidakmasuk->divisi     = $departement_map[$row['departemen']];
                        //         $tidakmasuk->status     = 'tanpa keterangan';
                        //         $tidakmasuk->tanggal    = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal'])->format("Y-m-d");
                        //         $tidakmasuk->save();
                        //     }
                        // } 
                    }
                }else
                {
                     // dd($row);
                     $data = [
                        'id_karyawan'   => $row['emp_no'],
                        'nik'           => $row['nik'] ?? null,
                        'tanggal'       => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal'])->format("Y-m-d"),
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
                        'id_departement'=> $departement_map[$row['departemen']] ?? null,
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
}
