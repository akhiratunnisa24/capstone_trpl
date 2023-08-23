<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SalaryStructure;
use App\Models\DetailSalaryStructure;
use App\Models\Benefit;
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

        $selectedBenefits = [1, 2, 3]; // Tambahkan ID benefit yang ingin di-set otomatis tercentang
        $benefits = $request->input('benefits');

        if ($benefits) {
            $benefits = array_merge($selectedBenefits, $benefits);
        } else {
            $benefits = $selectedBenefits;
        }
        // $benefits = $request->input('benefits');
        $detailData = [];
        foreach ($benefits as $benefitId) {
            $detailData[] = [
                'id_salary_structure' => $salaryStructure->id,
                'id_benefit' => $benefitId,
            ];
        }

        DB::table('detail_salary_structure')->insert($detailData);

        return redirect()->back()->with('pesan', 'Data berhasil disimpan.');
    }

    public function update(Request $request, $id)
    {
        $salaryStructure = SalaryStructure::findOrFail($id);
        $salaryStructures = SalaryStructure::with('benefits')->get();
        $salaryStructure = SalaryStructure::with('benefits')->find($id);
        $salaryStructures = SalaryStructure::with('level_jabatans')->get();
        $selectedBenefits = $salaryStructure->benefits->pluck('id')->toArray();
        $role = Auth::user()->role;
        $userPartner = Auth::user()->partner;
        $benefits = Benefit::where(function ($query) use ($userPartner) {
            $query->where('partner', 0)
                  ->orWhere('partner', $userPartner);
        })->get();

        $salaryStructures = SalaryStructure::with('level_jabatans')
                                           ->where('partner', $userPartner)
                                           ->get();

        $levelJabatanOptions = LevelJabatan::all()->pluck('nama_level', 'id')->prepend('Pilih Level Jabatan', '');
        $statusKaryawanOptions = ['' => 'Pilih Status','Karyawan Kontrak' => 'Karyawan Kontrak', 'Karyawan Tetap' => 'Karyawan Tetap', 'Probation' => 'Probation'];
        $salaryStructures = SalaryStructure::with('level_jabatans')->get();

        $salaryStructure->update([
            'nama' => $request->input('nama'),
            'level_jabatan_id' => $request->input('level_jabatan'),
            'status_karyawan' => $request->input('status_karyawan'),
        ]);

        // Simpan data benefit yang dipilih
        $selectedBenefits = [1, 2, 3]; // Tambahkan ID benefit yang ingin di-set otomatis tercentang
        $benefits = $request->input('benefits');

        if ($benefits) {
            $benefits = array_merge($selectedBenefits, $benefits);
        } else {
            $benefits = $selectedBenefits;
        }
        $benefits = Benefit::whereIn('id', $benefits)->get();
        $salaryStructure->benefits()->sync($benefits);

        return redirect()->back()->with('pesan', 'Data berhasil disimpan.',compact('benefits','selectedBenefits','salaryStructures','salaryStructure','levelJabatanOptions','statusKaryawanOptions'));
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
