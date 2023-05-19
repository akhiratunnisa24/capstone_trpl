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
use App\Models\Alokasicuti;
use Illuminate\Support\Facades\Log;
use App\Mail\TidakmasukNotification;
use Illuminate\Support\Facades\Mail;
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
                $departments = Departemen::pluck('id', 'nama_departemen')->toArray();
                $departement_map = isset($departments[$row['departemen']]) ? $departments[$row['departemen']] : 0;

                $tanggal = $row['tanggal'];
                $tanggal = trim($tanggal);
                $objTanggal = Carbon::createFromFormat('m/d/Y', $tanggal)->format('Y-m-d');
                $tgl = Carbon::createFromFormat('Y-m-d', $objTanggal);                

                // Ubah format objek Carbon menjadi objek DateTime
                // $objTanggal = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($objTanggal);
                // $tgl = $objTanggal->format("Y-m-d");
                // $tgl = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal'])->format("Y-m-d");
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
                            ->where('status',7)
                            ->select('izin.id','izin.id_karyawan','izin.id_jenisizin','izin.tgl_mulai','izin.tgl_selesai','izin.status')
                            ->first();
                        // $nama = Karyawan::where('id',$row['emp_no'])->select('nama')->first();
                        // dd($tgl,$izin,$nama->nama);

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
                                        $tidakmasuk->divisi     = isset($departement_map[$row['departemen']]) ? $departement_map[$row['departemen']] : 0;
                                        $tidakmasuk->status     = $reason->jenis_izin;
                                        $tidakmasuk->tanggal    = $date->format('Y-m-d');
                                        $tidakmasuk->save();
                                    }
                                }
                            }
                        }
                        else
                        {
                            //$cek = Tidakmasuk::where('id_pegawai', $row['emp_no'])->where('tanggal',\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal'])->format("Y-m-d"))->first();
                            $cek = Tidakmasuk::where('id_pegawai', $row['emp_no'])->where('tanggal', Carbon::createFromFormat('m/d/Y', $row['tanggal'])->format("Y-m-d"))->first();
                            if(!$cek)
                            {
                                $nama = Karyawan::where('id',$row['emp_no'])->select('nama')->first();

                                $tidakmasuk = new Tidakmasuk;
                                $tidakmasuk->id_pegawai = $row['emp_no'];
                                $tidakmasuk->nama       = $nama->nama;
                                $tidakmasuk->divisi     = isset($departement_map[$row['departemen']]) ? $departement_map[$row['departemen']] : 0;
                                $tidakmasuk->status     = 'tanpa keterangan';
                                $tidakmasuk->tanggal    = Carbon::createFromFormat('m/d/Y', $row['tanggal'])->format('Y-m-d');
                                //$tidakmasuk->tanggal    = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal'])->format("Y-m-d");
                                $tidakmasuk->save();

                                $alokasicuti = Alokasicuti::where('id_jeniscuti','=',1)
                                    ->where('id_karyawan',  $tidakmasuk->id_pegawai)
                                    ->first();
                                $durasi_baru = $alokasicuti->durasi - 1;

                                //update durasi di alokasicutikaryawan
                                Alokasicuti::where('id_jeniscuti',$alokasicuti->id_jeniscuti)
                                    ->where('id_karyawan',  $tidakmasuk->id_pegawai)
                                    ->update(
                                        ['durasi' => $durasi_baru]
                                );

                                $epegawai = Karyawan::select('email as email','nama as nama')->where('id','=',$tidakmasuk->id_pegawai)->first();
                                $tujuan = $epegawai->email;
                                $data = [
                                    'subject'     =>'Notifikasi Pengurangan Jatah Cuti Tahunan',
                                    'id'          =>$alokasicuti->id_jeniscuti,
                                    'id_jeniscuti'=>$alokasicuti->jeniscutis->jenis_cuti,
                                    'keterangan'   =>$tidakmasuk->status,
                                    'tanggal'     =>Carbon::parse($tidakmasuk->tanggal)->format("d M Y"),
                                    'jml_cuti'    =>1,
                                    'nama'        =>$epegawai->nama,
                                    'jatahcuti'   =>$durasi_baru,
                                ];
                                Mail::to($tujuan)->send(new TidakmasukNotification($data));
                                // return redirect()->back();
                                // dd($nama,$tidakmasuk,$alokasicuti,$durasi_baru,$epegawai,$tujuan,$data);
                            }
                        } 
                    }
                }else
                {
                     // dd($row);
                     //'tanggal'       => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal'])->format("Y-m-d"),
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
                        'id_departement'=> isset($departement_map[$row['departemen']]) ? $departement_map[$row['departemen']] : null,
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
