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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\IOFactory;

class DataImport
{

    private $jumlahdatadiimport = 0;
    private $jumlahdata = 0; //jumlah data keseluruhan
    private $jumlahimporttidakmasuk = 0;
    private $datatidakbisadiimport = 0; //JUMLAH DATA TIDAK DIIMPORT

<<<<<<< HEAD
     public function importDataExcel(Request $request)
=======
    public function importDataExcel(Request $request)
>>>>>>> 001d96e173d1799fd783aa889c8e49b85859c6e3
    {
        $file = $request->file('uploaded_file');
        $extension = $file->getClientOriginalExtension();
        
        $reader = null;
        if ($extension === 'xls') {
            $reader = IOFactory::createReader('Xls');
        } elseif ($extension === 'xlsx') {
            $reader = IOFactory::createReader('Xlsx');
        }

        if ($reader === null) {
            // Handle unsupported file extension
        }
        
        $spreadsheet = $reader->load($file);        
        $worksheet = $spreadsheet->getActiveSheet();
        $data = $worksheet->toArray();
        $header = $data[0];
       
        for ($i = 1; $i < count($data); $i++) 
        {
            $rowData = $data[$i];
            // Buat array asosiatif menggunakan header sebagai kunci
            $row = [];
            for ($j = 0; $j < count($rowData); $j++) {
                $row[$header[$j]] = $rowData[$j];
            }
            $datarow[] = $row;
        }

        foreach ($datarow as $row) {
            if (isset($row['NIK']) && isset($row['Tanggal'])) 
            {
                $this->jumlahdata++;
                $karyawan = Karyawan::where('nik', $row['NIK'])->first();
                
                if(isset($karyawan))
                {
                    $tgl = \Carbon\Carbon::createFromFormat('d/m/Y', $row['Tanggal'])->format('Y-m-d');
                    $absensicek = !Absensi::where('id_karyawan',$karyawan->id)->where('tanggal',$tgl)->first();
                    
                    if($absensicek)
                    {
                        $scan_masuk = $row['Scan Masuk'];
                        $scan_pulang= $row['Scan Pulang']; 

                        if($scan_masuk === "" && $scan_pulang === "")
                        {
                            $cuti = Cuti::where('id_karyawan', $karyawan->id)
                                ->whereDate('tgl_mulai', '<=', $tgl)
                                ->whereDate('tgl_selesai', '>=', $tgl)
                                ->where('status', 7)
                                ->select('cuti.id as id_cuti','cuti.id_karyawan','cuti.id_jeniscuti','cuti.tgl_mulai','cuti.tgl_selesai','cuti.status')
                                ->first();

                            $nama = Karyawan::where('id',$karyawan->id)->select('nama','divisi')->first();
                            
                            if($cuti !== NULL) 
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
                                
                                    //selain 5 karena id 5 itu ijin pada jam tertentu
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

                                                $this->jumlahimporttidakmasuk++;
                                                
                                            }
                                        }
                                    }
                                }
                                else
                                {
                                    $cek = Tidakmasuk::where('id_pegawai', $karyawan->id)->where('tanggal',$tgl)->first();
                                    if(!$cek)
                                    {
                                        $nama = Karyawan::where('nik',$row['NIK'])->first();
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
                        }
                        else
                        {
                            $jam_excel = [
                                'Jam Masuk'   => $row['Jam Masuk'],
                                'Jam Pulang'  => $row['Jam Pulang'],
                                'Scan Masuk'  => $row['Scan Masuk'],
                                'Scan Pulang' => $row['Scan Pulang'],
                                'Terlambat'   => $row['Terlambat'],
                                'Plg. Cepat'  => $row['Plg. Cepat'],
                                'Lembur'      => $row['Lembur'],
                                'Jml Jam Kerja'   => $row['Jml Jam Kerja'],
                                'Jml Kehadiran'   => $row['Jml Kehadiran'],
                            ];
                           
                            $formatted_jam = [];
                        
                            foreach ($jam_excel as $key => $value) {
                                if (!empty($value)) {
                                    $time = Carbon::createFromFormat('H.i', $value); 
                                    $formatted_jam[$key] = $time->format('H:i:s'); 
                                } else {
                                    $formatted_jam[$key] = null; 
                                }
                            }
                          
                            $data = [
                                'id_karyawan'   => $karyawan->id,
                                'nik'           => $karyawan->nip ?? null,
                                'tanggal'       => $tgl,
                                'shift'         => null,
                                'jadwal_masuk'  => isset($formatted_jam['Jam Masuk']) ? $formatted_jam['Jam Masuk'] : null,
                                'jadwal_pulang' => isset($formatted_jam['Jam Pulang']) ? $formatted_jam['Jam Pulang'] : null,
                                'jam_masuk'     => isset($formatted_jam['Scan Masuk']) ? $formatted_jam['Scan Masuk'] : null,
                                'jam_keluar'    => isset($formatted_jam['Scan Pulang']) ? $formatted_jam['Scan Pulang'] : null,
                                'normal'        => null,
                                'riil'          => null,
                                'terlambat'     => isset($formatted_jam['Terlambat']) ? $formatted_jam['Terlambat'] : null,
                                'plg_cepat'     => isset($formatted_jam['Plg. Cepat']) ? $formatted_jam['Plg. Cepat'] : null,
                                'absent'        => null,
                                'lembur'        => isset($formatted_jam['Lembur']) ? $formatted_jam['Lembur'] : null,
                                'jml_jamkerja'  => isset($formatted_jam['Jml Jam Kerja']) ? $formatted_jam['Jml Jam Kerja'] : null,
                                'pengecualian'  => null,
                                'hci'           => null,
                                'hco'           => null,
                                'id_departement'=> $karyawan->divisi,
                                'h_normal'      => null,
                                'ap'            => null,
                                'hl'            => null,
                                'jam_kerja'     => isset($formatted_jam['Jml Kehadiran']) ? $formatted_jam['Jml Kehadiran'] : null,
                                'lemhanor'      => null,
                                'lemakpek'      => null,
                                'lemhali'       => null,                
                            ];
                           
                            $absensi = Absensi::create($data);
                            
                            $this->jumlahdatadiimport++;
                            Log::info('Data '. $row['NIK'] . ' '. $row['Tanggal']. ' berhasil di import ke database Absensi');    
                        }
                    }
                    else
                    {
                        $this->datatidakbisadiimport++;
                        Log::info('Data '. $row['NIK'] . $row['Tanggal']. ' sudah ada di sistem');    
                    }

                }
                else
                {
                    $this->datatidakbisadiimport++;
                    Log::info('Karyawan '. $row['Emp No.'] . ' tidak terdaftar di sistem');
                }
            }
            else
            {
                $this->datatidakbisadiimport++;
                $this->jumlahdata++;
                Log::info('NIK karyawan kosong');
            }
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
     
    public function getDataImportTidakMasuk()
    {
        return $this->jumlahimporttidakmasuk;
    }
     
    public function getDatatTidakBisaDiimport()
    {
        return $this->datatidakbisadiimport;
    } 
}
