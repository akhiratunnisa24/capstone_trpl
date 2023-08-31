<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SalaryStructure;
use App\Models\DetailSalaryStructure;
use App\Models\Benefit;
use App\Models\Detailinformasigaji;
use App\Models\Informasigaji;
use App\Models\Karyawan;
use App\Models\LevelJabatan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SalaryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $role = Auth::user()->role;
        $userPartner = Auth::user()->partner;

        // Dapatkan benefit yang sesuai dengan partner user
        $benefits = Benefit::where(function ($query) use ($userPartner) {
            $query->where('partner', 0)
                ->orWhere('partner', $userPartner);

        })->get();

        $salaryStructures = SalaryStructure::with('level_jabatans')
                                        ->where('partner', $userPartner)
                                        ->orderBy('created_at', 'desc')
                                        ->get();

        $levelJabatanOptions = LevelJabatan::all()->pluck('nama_level', 'id');
        $statusKaryawanOptions = [
            '' => 'Pilih Status',
            'Pengurus' => 'Pengurus',
            'Kontrak' => 'Kontrak',
            'Tetap' => 'Tetap',
            'Percobaan' => 'Percobaan'
        ];
        $selectedBenefits = [1, 2, 3];
        return view('admin.datamaster.salary.data.index', compact(
            'row', 'benefits', 'role', 'selectedBenefits', 'salaryStructures',
            'levelJabatanOptions', 'statusKaryawanOptions'
        ));
    }


    public function store(Request $request)
    {
        $cek = SalaryStructure::where('id_level_jabatan',$request->id_level_jabatan)
            ->where('status_karyawan',$request->status_karyawan)
            ->where('partner',$request->partner)
            ->first();

        if(isset($cek))
        {
            return redirect()->back()->with('pesa','Data Struktur Sudah Ada pada sistem');
        }
        else
        {

            $salaryStructure = new SalaryStructure();
            $salaryStructure->nama = $request->nama;
            $salaryStructure->partner = $request->partner;
            $salaryStructure->id_level_jabatan = $request->id_level_jabatan;
            $salaryStructure->status_karyawan = $request->status_karyawan;
            $salaryStructure->save();

            $selectedBenefits = [1, 2, 3];
            $benefits = $request->input('benefits');

            if ($benefits) {
                $benefits = array_merge($selectedBenefits, $benefits);
            } else {
                $benefits = $selectedBenefits;
            }

            $detailData = [];
            foreach ($benefits as $benefitId)
            {
                $detailData[] = [
                    'id_salary_structure' => $salaryStructure->id,
                    'id_benefit' => $benefitId,
                ];
            }

            DB::table('detail_salary_structure')->insert($detailData);


            $strukturgaji = $salaryStructure;
            $leveljabatan = LevelJabatan::where('id', $strukturgaji->id_level_jabatan)->first();

            $karyawan = Karyawan::where('status_karyawan', $strukturgaji->status_karyawan)
                ->where('jabatan', $leveljabatan->nama_level)
                ->where('partner', $strukturgaji->partner)
                ->get();

            // return $karyawan;
            foreach ($karyawan as $data)
            {
                $check = Informasigaji::where('id_karyawan', $data->id)
                            ->where('partner', $data->partner)
                            ->where('status_karyawan', $strukturgaji->status_karyawan)
                            ->where('level_jabatan', $strukturgaji->id_level_jabatan)
                            ->first();

                if (!$check)
                {
                    $informasigaji = new Informasigaji();
                    $informasigaji->id_karyawan = $data->id;
                    $informasigaji->id_strukturgaji = $strukturgaji->id;
                    $informasigaji->status_karyawan = $strukturgaji->status_karyawan;
                    $informasigaji->level_jabatan   = $strukturgaji->id_level_jabatan;
                    $informasigaji->gaji_pokok      = $data->gaji;
                    $informasigaji->partner         = $strukturgaji->partner;

                    $informasigaji->save();

                    $informasigaji = Informasigaji::where('id_karyawan', $data->id)->first();
                    $detailstruktur = DetailSalaryStructure::where('id_salary_structure', $strukturgaji->id)->get();
                    $details = [];

                    foreach ($detailstruktur as $detail) {
                        $benefit = Benefit::where('id', $detail->id_benefit)->first();

                        $check = Detailinformasigaji::where('id_karyawan', $data->id)
                                    ->where('id_informasigaji', $informasigaji->id)
                                    ->where('id_struktur', $strukturgaji->id)
                                    ->where('id_benefit', $detail->id_benefit)
                                    ->where('partner', $data->partner)
                                    ->exists();

                        if (!$check)
                        {
                            $nominal = null;
                            if($benefit->id == 1)
                            {
                                $nominal = $informasigaji->gaji_pokok;
                            }else
                            {
                                if ($benefit->siklus_pembayaran == "Bulan") {
                                    $nominal = $benefit->besaran_bulanan;
                                } else if ($benefit->siklus_pembayaran == "Minggu") {
                                    $nominal = $benefit->besaran_mingguan;
                                } else if ($benefit->siklus_pembayaran == "Hari") {
                                    $nominal = $benefit->besaran_harian;
                                } else if ($benefit->siklus_pembayaran == "Jam") {
                                    $nominal = $benefit->besaran_jam;
                                } else if ($benefit->siklus_pembayaran == "Bonus") {
                                    $nominal = $benefit->besaran;
                                } else {
                                    $nominal = $benefit->besaran;
                                }
                            }
                            $details[] = [
                                'id_karyawan' => $data->id,
                                'id_informasigaji' => $informasigaji->id,
                                'id_struktur' => $informasigaji->id_strukturgaji,
                                'id_benefit' => $benefit->id,
                                'siklus_bayar' => $benefit->siklus_pembayaran,
                                'partner' => Auth::user()->partner,
                                'nominal' => $nominal,
                            ];
                        }
                    }
                    Detailinformasigaji::insert($details);
                }
                // else
                // {
                //     $informasigaji = Informasigaji::where('id_karyawan', $data->id)->first();
                //     $detailstruktur = DetailSalaryStructure::where('id_salary_structure', $strukturgaji->id)->get();
                //     $details = [];
                //     // return $detailstruktur;
                //     foreach ($detailstruktur as $detail)
                //     {
                //         $benefit  = Benefit::where('id',$detail->id_benefit)->first();

                //         $check = Detailinformasigaji::where('id_karyawan', $data->id)
                //                 ->where('id_informasigaji',$informasigaji->id)
                //                 ->where('id_struktur',$strukturgaji->id)
                //                 ->where('id_benefit',$detail->id_benefit)
                //                 ->where('partner',$data->partner)
                //                 ->exists();
                //             dd($check);

                //             if(!$check)
                //             {
                //                 $nominal = null;
                //                 if($benefit->id == 1)
                //                 {
                //                     $nominal = $informasigaji->gaji_pokok;
                //                 }else
                //                 {
                //                     if($benefit->siklus_pembayaran == "Bulan")
                //                     {
                //                         $nominal      = $benefit->besaran_bulanan;
                //                     }else if($benefit->siklus_pembayaran == "Minggu")
                //                     {
                //                         $nominal      = $benefit->besaran_mingguan;
                //                     }else if($benefit->siklus_pembayaran == "Hari")
                //                     {
                //                         $nominal      = $benefit->besaran_harian;
                //                     }else if($benefit->siklus_pembayaran == "Jam")
                //                     {
                //                         $nominal      = $benefit->besaran_jam;
                //                     }else if($benefit->siklus_pembayaran == "Bonus")
                //                     {
                //                         $nominal      = $benefit->besaran;
                //                     }else
                //                     {
                //                         $nominal      = $benefit->besaran;
                //                     }

                //                 }

                //                 $details[] = [
                //                 'id_karyawan' => $informasigaji->id_karyawan,
                //                 'id_informasigaji' =>$informasigaji->id,
                //                 'id_struktur'      =>$informasigaji->id_strukturgaji,
                //                 'id_benefit'       =>$benefit->id,
                //                 'siklus_bayar'     =>$benefit->siklus_pembayaran,
                //                 'partner'          =>Auth::user()->partner,
                //                 'nominal'          =>$nominal,
                //                 ];
                //             }
                //     }
                //     Detailinformasigaji::insert($details);
                // }
            }

            return redirect()->back()->with('pesan', 'Data berhasil disimpan.');
        }
    }


    public function update(Request $request, $id)
    {
        $levelJabatanOptions = LevelJabatan::all()->pluck('nama_level', 'id');
        $statusKaryawanOptions = [
            '' => 'Pilih Status',
            'Pengurus' => 'Pengurus',
            'Kontrak' => 'Kontrak',
            'Tetap' => 'Tetap',
            'Percobaan' => 'Percobaan'
        ];
        $salaryStructure = SalaryStructure::findOrFail($id);
        $selectedBenefits = [1, 2, 3];
        $benefits = $request->input('benefits', []);

        $salaryStructure->update([
            'nama' => $request->input('nama'),
            'level_jabatan_id' => $request->input('level_jabatan'),
            'status_karyawan' => $request->input('status_karyawan'),
        ]);

        $selectedBenefits = array_merge($selectedBenefits, $benefits);
        $benefits = Benefit::whereIn('id', $selectedBenefits)->get();
        $salaryStructure->benefits()->sync($benefits);

        $role = Auth::user()->role;
        $userPartner = Auth::user()->partner;

        $benefits = Benefit::where('partner', 0)
                        ->orWhere('partner', $userPartner)
                        ->get();

        // Update detail informasigaji berdasarkan perubahan benefit
        $karyawan = Karyawan::where('status_karyawan', $salaryStructure->status_karyawan)
            ->where('jabatan', $salaryStructure->level_jabatans->nama_level)
            ->where('partner', $salaryStructure->partner)
            ->get();

        foreach ($karyawan as $data) {
            $informasigaji = Informasigaji::updateOrCreate(
                [
                    'id_karyawan' => $data->id,
                    'partner' => $data->partner,
                    'status_karyawan' => $salaryStructure->status_karyawan,
                    'level_jabatan' => $salaryStructure->id_level_jabatan,
                ],
                []
            );

            $detailstruktur = DetailSalaryStructure::where('id_salary_structure', $salaryStructure->id)->get();
            $details = [];

            foreach ($detailstruktur as $detail) {
                $benefit = Benefit::where('id', $detail->id_benefit)->first();

                $check = Detailinformasigaji::where('id_karyawan', $data->id)
                    ->where('id_informasigaji', $informasigaji->id)
                    ->where('id_struktur', $salaryStructure->id)
                    ->where('id_benefit', $detail->id_benefit)
                    ->where('partner', $data->partner)
                    ->exists();

                if (!$check) {
                    // Hitung nominal sesuai dengan logika bisnis
                    $nominal = null;
                    if($benefit->id == 1)
                    {
                        $nominal = $informasigaji->gaji_pokok;
                    }else
                    {
                        if($benefit->siklus_pembayaran == "Bulan")
                        {
                            $nominal      = $benefit->besaran_bulanan;
                        }else if($benefit->siklus_pembayaran == "Minggu")
                        {
                            $nominal      = $benefit->besaran_mingguan;
                        }else if($benefit->siklus_pembayaran == "Hari")
                        {
                            $nominal      = $benefit->besaran_harian;
                        }else if($benefit->siklus_pembayaran == "Jam")
                        {
                            $nominal      = $benefit->besaran_jam;
                        }else if($benefit->siklus_pembayaran == "Bonus")
                        {
                            $nominal      = $benefit->besaran;
                        }else
                        {
                            $nominal      = $benefit->besaran;
                        }
                    }

                    $details[] = [
                        'id_karyawan' => $data->id,
                        'id_informasigaji' => $informasigaji->id,
                        'id_struktur' => $salaryStructure->id,
                        'id_benefit' => $detail->id_benefit,
                        'siklus_bayar' => $benefit->siklus_pembayaran,
                        'partner' => $data->partner,
                        'nominal' => $nominal,
                    ];
                }
            }
            Detailinformasigaji::insert($details);
        }

        return redirect()->back()
                        ->with('pesan', 'Data berhasil disimpan.')
                        ->with(compact('benefits', 'selectedBenefits', 'salaryStructure', 'levelJabatanOptions', 'statusKaryawanOptions'));
    }

    public function destroy($id)
    {
        $salaryStructure = SalaryStructure::findOrFail($id);

        // Delete related detail records
        $salaryStructure->detail_salary()->delete();

        // Delete the main salary structure record
        $salaryStructure->delete();

        return redirect()->route('salary')->with('pesan', 'Data berhasil dihapus.');
    }


}
