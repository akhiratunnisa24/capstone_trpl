<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SalaryStructure;
use App\Models\DetailSalaryStructure;
use App\Models\Benefit;
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
        $role = Auth::user()->role;
        $salaryStructures = SalaryStructure::all();
        $benefits = Benefit::all();

        return view('admin.datamaster.salary.data.index', compact('benefits', 'role','salaryStructures'));
    }

    public function store(Request $request)
    {

        $salaryStructure = new SalaryStructure();
        $salaryStructure->nama = $request->nama;
        $salaryStructure->partner = $request->partner;
        $salaryStructure->save();

        $benefits = $request->input('benefits');
        $detailData = [];
        foreach ($benefits as $benefitId) {
            $detailData[] = [
                'id_salary_structure' => $salaryStructure->id,
                'id_benefit' => $benefitId,
            ];
        }

        DB::table('detail_salary_structure')->insert($detailData);

        return redirect()->back();
    }

}
