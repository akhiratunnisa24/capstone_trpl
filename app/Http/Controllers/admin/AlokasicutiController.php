<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use App\Models\Karyawan;
use App\Models\Jeniscuti;
use Illuminate\Http\Request;
use App\Models\Settingalokasi;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AlokasicutiController extends Controller
{
    public function index()
    {
        $jenis_cuti = Jeniscuti::all();

        //create
        $settingalokasi = Settingalokasi::all();
        $jeniscuti= DB::table('settingalokasi')
        ->join('jeniscuti', 'settingalokasi.id_jeniscuti','=','jeniscuti.id')
        ->get();
        $karyawan = Karyawan::all();
        return view('admin.alokasicuti.index', compact('jeniscuti','karyawan','jenis_cuti','settingalokasi'));
    }

    public function store(Request $request)
    {

    }
}
