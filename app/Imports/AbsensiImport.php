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
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Readers\Xlsx;
use Maatwebsite\Excel\Facades\Excel;


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
    private $jumlahdatadiimport = 0;
    private $jumlahDataTidakMasuk = 0;
    private $tidakmasukdatabse = 0;
    private $jumlahdata = 0; //jumlah data keseluruhan
    private $jumlahimporttidakmasuk = 0;
    private $datatidakbisadiimport = 0;

    public function model(array $row)
    {
        static $counter = 0;
        if(isset($row['emp_no']) && isset($row['tanggal']))
        {
            $this->jumlahdata++;
            // Inisialisasi jumlah data yang sudah ada menjadi 0
            $jumlahDatasudahada = 0;
            $jumlahKaryawanTidakTerdaftar = 0; 

            // $departments = Departemen::pluck('id', 'nama_departemen')->toArray();
            // $departement_map = isset($departments[$row['departemen']]) ? $departments[$row['departemen']] : 0;
            // $karyawan = Karyawan::where('id', $row['emp_no'])
            //     ->where('divisi', $departement_map)
            //     ->first();
            $departement_map = Departemen::where('nama_departemen', $row['departemen'])->first();
            if ($departement_map) {
                $karyawan = Karyawan::where('id', $row['emp_no'])
                    ->where('divisi', $departement_map->id)
                    ->first();
            }

            if ($karyawan)
            {
                if(!Absensi::where('id_karyawan',$row['emp_no'])->where('tanggal',Carbon::parse($row['tanggal'])->format("Y-m-d"))->exists())
                {
                    // $departments = Departemen::pluck('id', 'nama_departemen')->toArray();
                    // $departement_map = isset($departments[$row['departemen']]) ? $departments[$row['departemen']] : 0;
                    $departement_map = Departemen::where('nama_departemen', $row['departemen'])->first();

                    $tanggal = $row['tanggal'];
                    $tanggal = trim($tanggal);
                    $objTanggal = Carbon::createFromFormat('m/d/Y', $tanggal)->format('Y-m-d');
                    $tgl = Carbon::createFromFormat('Y-m-d', $objTanggal);                

                    // Ubah format objek Carbon menjadi objek DateTime
                    // $objTanggal = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($objTanggal);
                    // $tgl = $objTanggal->format("Y-m-d");
                    // $tgl = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal'])->format("Y-m-d");

                    // Inisialisasi jumlah data dari excel yang masuk ke tabel tidak masuk


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
                                            $tidakmasuk->divisi = $departement_map->id;
                                            //$tidakmasuk->divisi     = isset($departement_map[$row['departemen']]) ? $departement_map[$row['departemen']] : 0;
                                            $tidakmasuk->status     = $reason->jenis_izin;
                                            $tidakmasuk->tanggal    = $date->format('Y-m-d');
                                            $tidakmasuk->save();

                                            $this->jumlahDataTidakMasuk++;// Increment jumlah data tidak masuk
                                            $this->jumlahimporttidakmasuk++;
                                            // Log::info('Jumlah data karyawan tidakmasuk '.  $jumlahDataTidakMasuk);  
                                            
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
                                    $tidakmasuk->divisi = $departement_map->id;
                                    //$tidakmasuk->divisi     = isset($departement_map[$row['departemen']]) ? $departement_map[$row['departemen']] : 0;
                                    $tidakmasuk->status     = 'tanpa keterangan';
                                    $tidakmasuk->tanggal    = Carbon::createFromFormat('m/d/Y', $row['tanggal'])->format('Y-m-d');
                                    //$tidakmasuk->tanggal    = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal'])->format("Y-m-d");
                                    $tidakmasuk->save();

                                    // $jumlahDataTidakMasuk =  $jumlahDataTidakMasuk + 1; // Increment jumlah data tidak masuk
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
                        // dd($row);
                        //'tanggal'       => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal'])->format("Y-m-d"),
                        //'id_departement'=> isset($departement_map[$row['departemen']]) ? $departement_map[$row['departemen']] : null,
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
                    // Hitung jumlah data berdasarkan id_karyawan dan tanggal pada file Excel
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

