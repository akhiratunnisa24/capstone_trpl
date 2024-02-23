<?php

namespace App\Http\Controllers\admin;

use App\Models\Karyawan;
use App\Models\Indikator;
use App\Models\Masterkpi;
use App\Models\Departemen;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class MasterkpiController extends Controller
{
    public function index(Request $request)
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        //form create jobs
        $departemen = Departemen::all();
        //index
        $master = Masterkpi::all();

        return view('admin.kpi.masterkpi.index', compact('master','departemen','row'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_departemen' => 'required',
            'nama_master' => 'required',
            // 'bobot' => 'required',
            // 'target' => 'required',
            'tglaktif' => 'required',
            'tglberakhir' => 'required',
        ]);

        $cek = !Masterkpi::where('nama_master', $request->nama_master)->first();
        if($cek)
        {
            $masterKpi = new Masterkpi();
            $masterKpi->id_departemen   = $request->id_departemen;
            $masterKpi->nama_master     = $request->nama_master;
            // $masterKpi->bobot           = $request->bobot;
            // $masterKpi->target          = $request->target;
            $masterKpi->tglaktif        = \Carbon\Carbon::createFromFormat('d/m/Y', $request->tglaktif)->format('Y-m-d');
            $masterKpi->tglberakhir     = \Carbon\Carbon::createFromFormat('d/m/Y', $request->tglberakhir)->format('Y-m-d');
            $masterKpi->status          = 1;

            $masterKpi->save();

            return redirect()->back()->with('success', 'Master KPI berhasil ditambahkan');
        }else{
            return redirect()->back()->with('error', 'Master KPI dengan nama tersebut sudah ada');
        }

    }

    public function update(Request $request, $id)
    {
        $masterKpi = Masterkpi::findOrFail($id);
        $masterKpi->id_departemen   = $request->id_departemen;
        $masterKpi->nama_master     = $request->nama_master;
        // $masterKpi->bobot           = $request->bobot;
        // $masterKpi->target          = $request->target;
        $masterKpi->tglaktif        = \Carbon\Carbon::createFromFormat('d/m/Y', $request->tglaktif)->format('Y-m-d');
        $masterKpi->tglberakhir     = \Carbon\Carbon::createFromFormat('d/m/Y', $request->tglberakhir)->format('Y-m-d');
        $masterKpi->status          = 1;

        $masterKpi->update();

        return redirect()->back()->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $masterKpi = Masterkpi::find($id);

        // // Cek data ke tabel "indikator"
        // $indikator = Indikator::where('id_master', $masterKpi->id)->first();
        // if ($indikator !== null) {
        //     return redirect()->back()->with('error', 'Master KPI tidak dapat dihapus');
        // } else {
        //     $indikator->delete();
        //     return redirect()->back()->with('success', 'Data Master KPI berhasil dihapus');
        // }
    }

    public function indikator(Request $request)
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $master = Masterkpi::all();
        $indikator = Indikator::all();

        return view('admin.kpi.indicator.index',compact('row','indikator','master'));
    }

    public function stores(Request $request)
    {
        $validatedData = $request->validate([
            'id_master' => 'required',
            'bobot' => 'required',
            'target' => 'required',
            'indikator' => 'required',
        ]);

        // dd($validatedData);
        $cek = Indikator::where('indikator', $request->indikator)->first();
        if(!$cek)
        {
            $indikator = new Indikator();
            $indikator->id_master   = $request->id_master;
            $indikator->indikator   = $request->indikator;
            $indikator->bobot       = $request->bobot;
            $indikator->target      = $request->target;
            $indikator->nilai       = null;

            $indikator->save();
            return redirect()->back()->with('success', 'Indikator KPI berhasil ditambahkan');
        }else
        {
            return redirect()->back()->with('error', 'Indikator KPI dengan nama tersebut sudah ada');
        }

    }

    public function updates(Request $request, $id)
    {
        $indikator = Indikator::findOrFail($id);
        $indikator->id_master   = $request->id_master;
        $indikator->indikator   = $request->indikator;
        $indikator->bobot       = $request->bobot;
        $indikator->target      = $request->target;
        $indikator->nilai       = null;

        $indikator->update();

        return redirect()->back()->with('success', 'Data berhasil diupdate');
    }

}
