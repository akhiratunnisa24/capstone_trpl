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
            return view('admin.benefit.data.index',compact('kategori','benefit','row','role','request'));
        }
        else
        {
            return redirect()->back(); 
        }
    }

    // public function getUrutanPotongan(Request $request)
    // {
    //     try {
    //         $id_kategori = $request->input('id_kategori');
    //         $defaultUrutan = ($id_kategori == 4) ? 2 : (($id_kategori >= 5 && $id_kategori <= 6) ? 101 : null);

    //         $getUrutanPotongan = Benefit::where(function ($query) use ($id_kategori) {
    //             if ($id_kategori == 4) {
    //                 $query->where('id_kategori', 4)
    //                     ->where('urutan', '<', 100);
    //             } elseif ($id_kategori >= 5 && $id_kategori <= 6) {
    //                 $query->whereIn('id_kategori', [4, 5])
    //                     ->where('partner', Auth::user()->partner)
    //                     ->whereBetween('urutan', [101, 199]);
    //             }
    //         })->max('urutan');

    //         if (!$getUrutanPotongan) {
    //             $getUrutanPotongan = $defaultUrutan++;
    //         }else{
    //             $getUrutanPotongan++;
    //         }

    //         return response()->json(['urutan' => $getUrutanPotongan], 200);
    //     } catch (\Exception $e) {
    //         return response()->json(['message' => $e->getMessage()], 500);
    //     }
    // }

    public function store(Request $request)
    {
        $request->validate([
            'nama_benefit' => 'required',
            'id_kategori' => 'required',
        ]);

        $aktif              = $request->has('aktif') ? 'Aktif' : 'Tidak Aktif';
        // $dikenakanPajak     = $request->has('dikenakan_pajak') ? 'Ya' : 'Tidak';
        $munculDiPenggajian = $request->has('muncul_dipenggajian') ? 'Ya' : 'Tidak';
        $jenis              = $request->siklus_pembayaran;
        $kategoribenefit    = $request->id_kategori;
        $tipekondisi        = $request->tipe;

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

        $gaji_minimum = str_replace(['.', ','], '', $request['gaji_minimum']);
        $gaji_minimum = floatval($gaji_minimum);

        $gaji_maksimum = str_replace(['.', ','], '', $request['gaji_maksimum']);
        $gaji_maksimum = floatval($gaji_maksimum);

        $benefit = new Benefit;
        $benefit->nama_benefit = $request->nama_benefit;
        $benefit->id_kategori  = $request->id_kategori;
        $benefit->kode         = $request->kode;
        $benefit->aktif        = $aktif;
        $benefit->kelas_pajak  = null;
        $benefit->urutan       = null;
        $benefit->jumlah       = $request->jumlah;
        $benefit->aktif        = $aktif;
        $benefit->kelas_pajak  = null;
        $benefit->tipe         = $tipekondisi;
        $benefit->dikenakan_pajak    = null;
        $benefit->siklus_pembayaran  = $jenis;
        $benefit->muncul_dipenggajian= $munculDiPenggajian;
        $benefit->partner            = $request->partner;

        if($tipekondisi == "Interval Gaji")
        {
            $benefit->gaji_minimum  = $gaji_minimum;
            $benefit->gaji_maksimum = $gaji_maksimum;
        }else
        {
            $benefit->gaji_minimum  = null;
            $benefit->gaji_maksimum = null;
        }

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
        $tipekondisi        = $request->has('tipe') ? $request->tipe : $benefit->tipe;

        $besaranBulanan  = $request->has('besaran_bulanan') ? floatval(str_replace(['.', ','], '', $request['besaran_bulanan'])) : $benefit->besaran_bulanan;
        $besaranMingguan = $request->has('besaran_mingguan') ? floatval(str_replace(['.', ','], '', $request['besaran_mingguan'])) : $benefit->besaran_mingguan;
        $besaranHarian   = $request->has('besaran_harian') ? floatval(str_replace(['.', ','], '', $request['besaran_harian'])) : $benefit->besaran_harian;
        $besaranJam      = $request->has('besaran_jam') ? floatval(str_replace(['.', ','], '', $request['besaran_jam'])) : $benefit->besaran_jam;
        $besaran         = $request->has('besaran') ? floatval(str_replace(['.', ','], '', $request['besaran'])) : $benefit->besaran;
        
        $gaji_minimum    = $request->has('gaji_minimum') ? floatval(str_replace(['.', ','], '', $request['gaji_minimum'])) : $benefit->gaji_minimum;
        $gaji_maksimum   = $request->has('gaji_maksimum') ? floatval(str_replace(['.', ','], '', $request['gaji_maksimum'])) : $benefit->gaji_maksimum;
        
        $benefit->nama_benefit          = $request->nama_benefit !== null ? $request->nama_benefit : $benefit->nama_benefit;
        $benefit->id_kategori           = $request->id_kategori !== null ? $request->id_kategori : $benefit->id_kategori;
        $benefit->kode                  = $request->kode !== null ? $request->kode : $benefit->kode;
        $benefit->urutan                = null;
        $benefit->jumlah                = $request->jumlah !== null ? $request->jumlah : $benefit->jumlah;
        $benefit->aktif                 = $aktif;
        $benefit->kelas_pajak           = $request->kelas_pajak !== null ? $request->kelas_pajak : $benefit->kelas_pajak;
        $benefit->dikenakan_pajak       = null;
        $benefit->tipe                  = $request->tipe !== null ? $request->tipe : $benefit->tipe;
        $benefit->siklus_pembayaran     = $jenis;
        $benefit->muncul_dipenggajian   = $munculDiPenggajian;

        if($tipekondisi == "Interval Gaji")
        {
            $benefit->gaji_minimum  = $gaji_minimum  !== null ? $gaji_minimum  : $benefit->gaji_minimum;
            $benefit->gaji_maksimum = $gaji_maksimum !== null ? $gaji_maksimum : $benefit->gaji_maksimum;
        }else
        {
            $benefit->gaji_minimum  = null;
            $benefit->gaji_maksimum = null;
        }
        
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

            if($kategoribenefit == '5')
            {
                $benefit->dibayarkan_oleh    = $request->dibayarkan_oleh ? $request->dibayarkan_oleh : $benefit->dibayarkan_oleh;
            }
            else
            {
                $benefit->dibayarkan_oleh  = null;
            }

        }
        else
        {
            $benefit->besaran_bulanan  = null;
            $benefit->besaran_mingguan = null;
            $benefit->besaran_harian   = null;
            $benefit->besaran_jam      = null;
            $benefit->besaran          = null;
            $benefit->dibayarkan_oleh  = null;
        }

        $benefit->update();

        return redirect()->back()->with('pesan', 'Data Benefit berhasil diupdate.');
    }

    public function destroy($id)
    {
        //
    }
}
