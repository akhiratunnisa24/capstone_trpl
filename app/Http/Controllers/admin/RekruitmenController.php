<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Lowongan;
use Illuminate\Support\Facades\Auth;

class RekruitmenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        $posisi = Lowongan::all()->sortByDesc('created_at');
        

        return view('admin.rekruitmen.index', compact('row', 'posisi'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new Lowongan();
        $user->posisi = $request->posisi;
        $user->jumlah_dibutuhkan = $request->jumlah_dibutuhkan;
        $user->status = 'Aktif';
        $user->persyaratan = $request->persyaratan;
        $user->save();

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Auth::user()->role;
        if ($role == 1) {

            $lowongan = lowongan::findOrFail($id);
            // dd($karyawan);




            return view('admin.rekruitmen.show', compact('lowongan'));

        } else {

            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
