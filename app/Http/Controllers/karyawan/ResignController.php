<?php

namespace App\Http\Controllers\karyawan;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Resign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResignController extends Controller
{   
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return view('karyawan.resign.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $karyawan = Auth::user()->id_pegawai;
         $validate = $request->validate([
                'id_karyawan'  => 'required',
                'tgl_resign'    => 'required',
                'alasan'    => 'required',
            ]);
            // dd($validate);
            $resign = New Resign;
            $resign->id_karyawan = $karyawan;
            $resign->tgl_resign  = Carbon::parse($request->tgl_resign)->format("Y-m-d");
            $resign->alasan      = $request->alasan;          
            $resign->status      = 'Pending';
            $resign->save();

            return redirect()->back()->withInput();

    }

    public function show($id)
    {
        $resign = Resign::findOrFail($id);
        $karyawan = Auth::user()->id_pegawai;

        return view('karyawan.kategori.index',compact('resign','karyawan'));
    }

}
