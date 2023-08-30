<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SalaryStructure;
use App\Models\DetailSalaryStructure;
use App\Models\Benefit;
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
                                        ->orderBy('created_at', 'asc') 
                                        ->get();

        $levelJabatanOptions = LevelJabatan::all()->pluck('nama_level', 'id');
        $statusKaryawanOptions = [
            '' => 'Pilih Status',
            'Pengurus' => 'Pengurus',
            'Kontrak' => 'Kontrak',
            'Tetap' => 'Tetap',
            'Probation' => 'Probation'
        ];
        $selectedBenefits = [1, 2, 3];
        return view('admin.datamaster.salary.data.index', compact(
            'row', 'benefits', 'role', 'selectedBenefits', 'salaryStructures',
            'levelJabatanOptions', 'statusKaryawanOptions'
        ));
    }


    public function store(Request $request)
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
        foreach ($benefits as $benefitId) {
            $detailData[] = [
                'id_salary_structure' => $salaryStructure->id,
                'id_benefit' => $benefitId,
            ];
        }

        DB::table('detail_salary_structure')->insert($detailData);

        // Generate informasi gaji langsung di dalam metode store
        $leveljabatan = LevelJabatan::where('id', $salaryStructure->id_level_jabatan)->first();
        $detailstruktur = DetailSalaryStructure::where('id_salary_structure', $salaryStructure->id)->get();

        foreach ($detailstruktur as $detail) {
            $benefit = Benefit::where('id', $detail->id_benefit)->get();
        }

        $karyawan = Karyawan::where('status_karyawan', $salaryStructure->status_karyawan)
            ->where('jabatan', $leveljabatan->nama_level)
            ->where('partner', $salaryStructure->partner)
            ->get();

        foreach ($karyawan as $data) {
            $check = Informasigaji::where('id_karyawan', $data->id)
                ->where('partner', $salaryStructure->partner)
                ->where('status_karyawan', $salaryStructure->status_karyawan)
                ->where('level_jabatan', $salaryStructure->id_level_jabatan)
                ->first();

            if (!$check) {
                $informasigaji = new Informasigaji();
                $informasigaji->id_karyawan = $data->id;
                $informasigaji->id_strukturgaji = $salaryStructure->id;
                $informasigaji->status_karyawan = $salaryStructure->status_karyawan;
                $informasigaji->level_jabatan = $salaryStructure->id_level_jabatan;
                $informasigaji->gaji_pokok = $data->gaji;
                $informasigaji->partner = $salaryStructure->partner;

                $informasigaji->save();
            }
        }

        return redirect()->back()->with('pesan', 'Data berhasil disimpan.');
    }


    public function update(Request $request, $id)
    {
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

        $levelJabatanOptions = LevelJabatan::all()->pluck('nama_level', 'id')->prepend('Pilih Level Jabatan', '');
        $statusKaryawanOptions = [
            '' => 'Pilih Status',
            'Pengurus' => 'Pengurus',
            'Kontrak' => 'Kontrak',
            'Tetap' => 'Tetap',
            'Probation' => 'Probation'
        ];

        $salaryStructures = SalaryStructure::with('level_jabatans')->where('partner', $userPartner)->get();

        return redirect()->back()
                         ->with('pesan', 'Data berhasil disimpan.')
                         ->with(compact('benefits', 'selectedBenefits', 'salaryStructures', 'salaryStructure', 'levelJabatanOptions', 'statusKaryawanOptions'));
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
