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
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;


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
        if(isset($row['nik']) && isset($row['tanggal']))
        {
            dd($row);
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
                            // 'normal'        => null,
                            // 'riil'          => null,
                            'terlambat'     => isset($formatted_jam['terlambat']) ? $formatted_jam['terlambat'] : null,
                            'plg_cepat'     => isset($formatted_jam['plg_cepat']) ? $formatted_jam['plg_cepat'] : null,
                            'absent'        => null,
                            'lembur'        => isset($formatted_jam['lembur']) ? $formatted_jam['lembur'] : null,
                            'jml_jamkerja'  => isset($formatted_jam['jml_jam_kerja']) ? $formatted_jam['jml_jam_kerja'] : null,
                            // 'pengecualian'  => null,
                            // 'hci'           => null,
                            // 'hco'           => null,
                            'id_departement'=> $karyawan->divisi,
                            // 'h_normal'      => null,
                            // 'ap'            => null,
                            // 'hl'            => null,
                            'jam_kerja'     => isset($formatted_jam['jml_kehadiran']) ? $formatted_jam['jml_kehadiran'] : null,
                            // 'lemhanor'      => null,
                            // 'lemakpek'      => null,
                            // 'lemhali'       => null,                
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

    public function import($file)
    {
        $spreadsheet = IOFactory::load($file);
        $sheet = $spreadsheet->getActiveSheet();
        $data = $sheet->toArray();

        foreach ($data as $row) {
            $this->model($row);
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

    