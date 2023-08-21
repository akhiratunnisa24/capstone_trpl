<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use App\Models\Benefit;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use App\Models\Kategoribenefit;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BenefitController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $role = Auth::user()->role;
        
        if ($role == 1 || $role == 6) {
            $benefit = Benefit::where('partner',Auth::user()->partner)->get();
            $kategori = Kategoribenefit::where(function($query) {
                        $query->where('partner', Auth::user()->partner)
                            ->whereNotIn('id', [1, 2, 3]);
                    })
                    ->orWhere(function($query) {
                        $query->where('partner', 0)
                            ->whereNotIn('id', [1, 2, 3]);
                    })
                    ->get();

            return view('admin.datamaster.benefit.data.index',compact('kategori','benefit','row','role'));
        }
        else
        {
            return redirect()->back(); 
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_benefit' => 'required',
            'id_kategori' => 'required',
        ]);

        $aktif              = $request->has('aktif') ? 'Aktif' : 'Tidak Aktif';
        $dikenakanPajak     = $request->has('dikenakan_pajak') ? 'Ya' : 'Tidak';
        $munculDiPenggajian = $request->has('muncul_dipenggajian') ? 'Ya' : 'Tidak';
        $jenis              = $request->siklus_pembayaran;
        $kategoribenefit    = $request->id_kategori;

        $besaranBulanan = str_replace(['.', ','], '', $request['besaran_bulanan']);
        $besaranBulanan = floatval($besaranBulanan);

        $besaranMingguan = str_replace(['.', ','], '', $request['besaran_mingguan']);
        $besaranMingguan = floatval($besaranMingguan);

        $besaranHarian = str_replace(['.', ','], '', $request['besaran_harian']);
        $besaranHarian = floatval($besaranHarian);

        $besaranJam = str_replace(['.', ','], '', $request['besaran_jam']);
        $besaranJam = floatval($besaranJam);

        $besaran = str_replace(['.', ','], '', $request['besaran']);
        $besaran = floatval($besaran);

        $benefit = new Benefit;
        $benefit->nama_benefit = $request->nama_benefit;
        $benefit->id_kategori  = $request->id_kategori;
        $benefit->kode         = $request->kode;
        $benefit->aktif        = $aktif;
        $benefit->kelas_pajak  = $request->kelas_pajak;
        $benefit->dikenakan_pajak    = $dikenakanPajak;
        $benefit->tipe               = $request->tipe;
        $benefit->siklus_pembayaran  = $jenis;
        $benefit->muncul_dipenggajian= $munculDiPenggajian;
        $benefit->partner            = $request->partner;

        if($kategoribenefit !== '1' && $kategoribenefit !== '2' && $kategoribenefit !== '3')
        {
            if($jenis == "Bulan")
            {
                $benefit->besaran_bulanan  = $besaranBulanan;
                $benefit->besaran_mingguan = null;
                $benefit->besaran_harian   = null;
                $benefit->besaran_jam      = null;
                $benefit->besaran          = null;
            }
            else if($jenis == "Minggu")
            {
                $benefit->besaran_bulanan  = null;
                $benefit->besaran_mingguan = $besaranMingguan;
                $benefit->besaran_harian   = null;
                $benefit->besaran_jam      = null;
                $benefit->besaran          = null;
            }
            else if($jenis == "Hari")
            {
                $benefit->besaran_bulanan  = null;
                $benefit->besaran_mingguan = null;
                $benefit->besaran_harian   = $besaranHarian;
                $benefit->besaran_jam      = null;
                $benefit->besaran          = null;
            }
            else if($jenis == "Jam")
            {
                $benefit->besaran_bulanan  = null;
                $benefit->besaran_mingguan = null;
                $benefit->besaran_harian   = null;
                $benefit->besaran_jam      = $besaranJam;
                $benefit->besaran          = null;
            }
            else
            {
                $benefit->besaran_bulanan  = null;
                $benefit->besaran_mingguan = null;
                $benefit->besaran_harian   = null;
                $benefit->besaran_jam      = null;
                $benefit->besaran          = $besaran;
            }
        }
        else
        {
            $benefit->besaran_bulanan  = null;
            $benefit->besaran_mingguan = null;
            $benefit->besaran_harian   = null;
            $benefit->besaran_jam      = null;
            $benefit->besaran          = null;
        }

        $benefit->save();

        return redirect()->back()->with('pesan', 'Data Benefit berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $benefit = Benefit::find($id);

        $aktif              = $request->has('aktif') ? 'Aktif' : 'Tidak Aktif';
        $dikenakanPajak     = $request->has('dikenakan_pajak') ? 'Ya' : 'Tidak';
        $munculDiPenggajian = $request->has('muncul_dipenggajian') ? 'Ya' : 'Tidak';
        $jenis              = $request->has('siklus_pembayaran') ? $request->siklus_pembayaran : $benefit->siklus_pembayaran;
        $kategoribenefit    = $request->has('id_kategori') ? $request->id_kategori : $benefit->id_kategori;


        $besaranBulanan  = $request->has('besaran_bulanan') ? floatval(str_replace(['.', ','], '', $request['besaran_bulanan'])) : $benefit->besaran_bulanan;
        $besaranMingguan = $request->has('besaran_mingguan') ? floatval(str_replace(['.', ','], '', $request['besaran_mingguan'])) : $benefit->besaran_mingguan;
        $besaranHarian   = $request->has('besaran_harian') ? floatval(str_replace(['.', ','], '', $request['besaran_harian'])) : $benefit->besaran_harian;
        $besaranJam      = $request->has('besaran_jam') ? floatval(str_replace(['.', ','], '', $request['besaran_jam'])) : $benefit->besaran_jam;
        $besaran         = $request->has('besaran') ? floatval(str_replace(['.', ','], '', $request['besaran'])) : $benefit->besaran;

        $benefit->nama_benefit          = $request->nama_benefit;
        $benefit->id_kategori           = $request->id_kategori !== null ? $request->id_kategori : $benefit->id_kategori;
        $benefit->kode                  = $request->kode !== null ? $request->kode : $benefit->kode;
        $benefit->aktif                 = $aktif;
        $benefit->kelas_pajak           = $request->kelas_pajak !== null ? $request->kelas_pajak : $benefit->kelas_pajak;
        $benefit->dikenakan_pajak       = $dikenakanPajak;
        $benefit->tipe                  = $request->tipe !== null ? $request->tipe : $benefit->tipe;
        $benefit->siklus_pembayaran     = $jenis;
        $benefit->muncul_dipenggajian   = $munculDiPenggajian;
        $benefit->partner               = $benefit->partner;

        if($kategoribenefit !== '1' && $kategoribenefit !== '2' && $kategoribenefit !== '3')
        {
            if($jenis == "Bulan")
            {
                $benefit->besaran_bulanan  = $besaranBulanan ? $besaranBulanan : $benefit->besaran_bulanan;
                $benefit->besaran_mingguan = null;
                $benefit->besaran_harian   = null;
                $benefit->besaran_jam      = null;
                $benefit->besaran          = null;
            }
            else if($jenis == "Minggu")
            {
                $benefit->besaran_bulanan  = null;
                $benefit->besaran_mingguan = $besaranMingguan ? $besaranMingguan : $benefit->besaran_mingguan;
                $benefit->besaran_harian   = null;
                $benefit->besaran_jam      = null;
                $benefit->besaran          = null;
            }
            else if($jenis == "Hari")
            {
                $benefit->besaran_bulanan  = null;
                $benefit->besaran_mingguan = null;
                $benefit->besaran_harian   = $besaranHarian ? $besaranHarian : $benefit->besaran_harian;
                $benefit->besaran_jam      = null;
                $benefit->besaran          = null;
            }
            else if($jenis == "Jam")
            {
                $benefit->besaran_bulanan  = null;
                $benefit->besaran_mingguan = null;
                $benefit->besaran_harian   = null;
                $benefit->besaran_jam      = $besaranJam ? $besaranJam : $benefit->besaran_jam;
                $benefit->besaran          = null;
            }
            else
            {
                $benefit->besaran_bulanan  = null;
                $benefit->besaran_mingguan = null;
                $benefit->besaran_harian   = null;
                $benefit->besaran_jam      = null;
                $benefit->besaran          = $besaran ? $besaran : $benefit->besaran;
            }
        }
        else
        {
            $benefit->besaran_bulanan  = null;
            $benefit->besaran_mingguan = null;
            $benefit->besaran_harian   = null;
            $benefit->besaran_jam      = null;
            $benefit->besaran          = null;
        }

        $benefit->update();

        return redirect()->back()->with('pesan', 'Data Benefit berhasil diupdate.');
    }

    public function destroy($id)
    {
        //
    }
}
