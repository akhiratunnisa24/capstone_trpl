<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use App\Models\Jadwal;
use App\Models\Absensi;
use App\Models\Benefit;
use App\Models\Karyawan;
use App\Models\Penggajian;
use App\Models\Tidakmasuk;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Informasigaji;
use App\Models\PenggajianGrup;
use App\Models\Detailkehadiran;
use App\Models\SalaryStructure;
use Illuminate\Support\Facades\DB;
use App\Models\Detailinformasigaji;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\DetailSalaryStructure;

class PenggajianController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $role = Auth::user()->role;
        if ($role == 1 ||$role == 6)
        {
            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
            $karyawan = Karyawan::where('partner',$row->partner)->get();
            $slipgaji = Penggajian::where('partner',$row->partner)->get();

            return view('admin.penggajian.index',compact('row','role','karyawan','slipgaji'));
        }else {

            return redirect()->back();
        }
    }

    public function getkaryawan(Request $request)
    {
        try {
            $getKaryawan = Karyawan::leftjoin('departemen', 'karyawan.divisi', '=', 'departemen.id')
                ->select('karyawan.nama_jabatan','karyawan.id' ,'karyawan.divisi', 'karyawan.nip', 'departemen.nama_departemen','karyawan.nama_bank','karyawan.no_rek','karyawan.tglmasuk')
                ->where('karyawan.id','=', $request->id_karyawan)
                ->first();

            if (!$getKaryawan) {
                 throw new \Exception('Data not found');
            }

            return response()->json( $getKaryawan,200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function storeGaji(Request $request)
    {
        $validateData = $request->validate([
            'tglgajian' => 'required',
            'id_karyawan' => 'required',
            'tgl_awal' => 'required',
            'tgl_akhir' => 'required',
            'nama_bank' => 'required',
            'nomor_rekening' => 'required',
            'partner' => 'required',
        ]);

        $tgl_awal = date_format(date_create_from_format('d/m/Y', $request->tgl_awal), 'Y-m-d');
        $tgl_akhir= date_format(date_create_from_format('d/m/Y', $request->tgl_akhir), 'Y-m-d');
        $tglgajian= date_format(date_create_from_format('d/m/Y', $request->tglgajian), 'Y-m-d');

        $getKaryawan = Karyawan::leftjoin('departemen', 'karyawan.divisi', '=', 'departemen.id')
            ->select('karyawan.nama_jabatan','karyawan.id' ,'karyawan.divisi', 'karyawan.nip', 'departemen.nama_departemen','karyawan.nama_bank','karyawan.no_rek')
            ->where('karyawan.id','=', $request->id_karyawan)
            ->first();

        if($getKaryawan->nama_bank == null || $getKaryawan->no_rek == null)
        {
            $data = [
                'nama_bank' => $request->nama_bank,
                'no_rek' =>  $request->nomor_rekening,
            ];
            Karyawan::where('id', $request->id_karyawan)->update($data);
        }

        $lembur = DB::table('detail_kehadiran')
            ->where('id_karyawan',$getKaryawan->id)
            ->where('tgl_awal',$tgl_awal)
            ->where('tgl_akhir',$tgl_akhir)
            ->first();

        $informasigaji = Informasigaji::where('id_karyawan',$request->id_karyawan)->first();
        $detail = Detailinformasigaji::where('id_informasigaji',$informasigaji->id)->get();

        $penggajian = Penggajian::firstOrNew([
                    'id_karyawan' => $request->id_karyawan,
                    'tglawal' => $tgl_awal,
                    'tglakhir' => $tgl_akhir,
                ]);

        $penggajian->tglgajian = $tglgajian;
        $penggajian->id_informasigaji = $informasigaji->id;
        $penggajian->gaji_pokok = $informasigaji->gaji_pokok;
        $penggajian->lembur = null;
        $penggajian->tunjangan = null;
        $penggajian->gaji_kotor = null;
        $penggajian->asuransi = null;
        $penggajian->potongan = null;
        $penggajian->pajak = null;
        $penggajian->gaji_bersih = null;
        $penggajian->nama_bank = $request->nama_bank;
        $penggajian->no_rekening = $request->nomor_rekening;
        $penggajian->partner = $request->partner;

        $penggajian->save();

        $pesan = "Slip Gaji untuk ". $getKaryawan->nama . "Periode ". $request->tgl_awal . " s/d " .  $request->tgl_akhir . "Berhasil dibuat";
        return redirect()->back()->with('pesan',$pesan);
    }

    public function showslipgaji(Request $request)
    {
        $nip = $request->input('nip');
        $id = $request->id;
        $role = Auth::user()->role;
        if ($role == 1 ||$role == 6)
        {
            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
            $karyawan = Karyawan::where('partner',$row->partner)->first();
            $informasigaji = Informasigaji::with('karyawans')->where('id_karyawan',$karyawan->id)->first();
            $detailinformasi= Detailinformasigaji::with('karyawans')->where('id_karyawan',$karyawan->id)->get();

            $kehadiran = Detailkehadiran::where('id_karyawan',$karyawan->id)->first();
            $slipgaji = Penggajian::with('karyawans')->where('id',$id)->first();
            $jadwal = Jadwal::whereBetween('tanggal', [$slipgaji->tglawal, $slipgaji->tglakhir])
                ->where('partner', $row->partner)
                ->count();

            return view('admin.penggajian.slip',compact('row','role','karyawan','slipgaji','kehadiran','informasigaji','detailinformasi'));
        }else {

            return redirect()->back();
        }
    }

    public function indexgrup(Request $request)
    {
        $role = Auth::user()->role;
        if ($role == 1 ||$role == 6)
        {
            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
            $karyawan = Karyawan::where('partner',$row->partner)->get();
            $slipgrupindex = PenggajianGrup::where('partner',$row->partner)->get();
            $slipgrup = SalaryStructure::where('partner',$row->partner)->get();

            return view('admin.penggajian.indexgrup',compact('row','role','karyawan','slipgrup','slipgrupindex'));
        }else {

            return redirect()->back();
        }
    }

    public function storepenggajian_grup(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required',
            'id_struktur' => 'required',
            'tgl_penggajian' => 'required',
            'tgl_mulai' => 'required',
            'tgl_selesai' => 'required',
        ]);
        $tgl_penggajian = Carbon::createFromFormat('d/m/Y', $request->tgl_penggajian)->format('Y-m-d');
        $tgl_mulai = Carbon::createFromFormat('d/m/Y', $request->tgl_mulai)->format('Y-m-d');
        $tgl_selesai = Carbon::createFromFormat('d/m/Y', $request->tgl_selesai)->format('Y-m-d');

        PenggajianGrup::create([
            'nama_grup' => $request->nama,
            'id_struktur' => $request->id_struktur,
            'tglawal' => $tgl_mulai,
            'tglakhir' => $tgl_selesai,
            'tglgajian' => $tgl_penggajian,
            'partner' => $request->partner,
        ]);

        return redirect()->back()->with('pesan','Data berhasil disimpan');
    }











    















    public function hitunggaji(Request $request)
    {
        $role = Auth::user()->role;
        if ($role == 1 ||$role == 6)
        {
            $karyawan = Karyawan::where('id',$request->id_karyawan)->first();
            $informasigaji = Informasigaji::with('karyawans')->where('id_karyawan',$karyawan->id)->first();
            $kehadiran = Detailkehadiran::where('id_karyawan',$karyawan->id)->first();
            $strukturgaji = SalaryStructure::where('id',$informasigaji->id_strukturgaji)->first();
            $detailstruktur = DetailSalaryStructure::where('id_salary_structure',$strukturgaji->id)->get();

            $detailinformasi = Detailinformasigaji::with('karyawans')
                ->join('benefit', 'detail_informasigaji.id_benefit', '=', 'benefit.id')
                ->join('kategoribenefit', 'benefit.id_kategori', '=', 'kategoribenefit.id')
                ->where('detail_informasigaji.id_informasigaji', $informasigaji->id)
                ->where('detail_informasigaji.id_karyawan',$informasigaji->id_karyawan)
                ->get();

            $gajikotor = 0;
            $tunjangan = 0;
            $asuransi = 0;
            $potongan = 0;
            $totalpotongan = 0;
            $gajibersih = 0;

            foreach ($detailinformasi as $detail) 
            {
                switch ($detail->id_kategori) {
                    case 1:
                        $gajipokok = $detail->nominal;
                        break;
                    case 4:
                        // dd($detail,$kehadiran);
                        if ($detail->siklus_bayar == 'Bulan') {
                            $tunjangan += $detail->nominal * $detail->jumlah;
                        } elseif ($detail->siklus_bayar == 'Hari') {
                            // Misalnya, asumsikan Anda memiliki $detail_kehadiran sebagai referensi
                            $jumlah_hadir = $kehadiran->jumlah_hadir; 
                            $tunjangan += $detail->nominal * $jumlah_hadir;
                        } elseif ($detail->siklus_bayar == 'Jam') {
                            // dd($detail);
                            if(Str::contains($detail->nama_benefit, 'Lembur'))
                            {
                                $jam = $kehadiran->jam_lembur; 
                                $tunjangan += $detail->nominal * $jam;
                            }else{
                                $tunjangan += $detail->nominal * $detail->jumlah;
                            }
                        }
                        break;
                    case 5:
                        $asuransi += $detail->nominal;
                        break;
                    case 6:
                        $potongan += $detail->nominal;
                        break;
                }
            }

            $gajikotor = $gajipokok + $tunjangan;
            $totalpotongan = $asuransi + $potongan;
            $gajibersih = $gajikotor - $totalpotongan;

            dd($gajipokok,$tunjangan, $gajikotor,$asuransi,$potongan, $totalpotongan,$gajibersih);
             Penggajian::where('id', $$request->id_slip)->update($dataToUpdate);
          
            

                return redirect()->back()->with('pesan','Penghitungan Gaji telah selesai');
        }else {

            return redirect()->back();
        }
    }

}
