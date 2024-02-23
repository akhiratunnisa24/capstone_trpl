<?php

namespace App\Http\Controllers\superadmin;

use App\Models\Partner;
use App\Models\Karyawan;
use App\Models\Listmesin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BankController extends Controller
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

    public function index(Request $request)
    {
        $role = Auth::user()->role;
        if (($role == 5))
        {
            $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
            $bank = DB::table('bank')->get();
            return view('superadmin.bank.index', compact('bank', 'row'));
        } else {

            return redirect()->back()->with('error','Anda tidak memiliki hak akses');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_bank' => 'required',
        ]);
        $nama_bank = $request->nama_bank;

        $bank = DB::table('bank')->where(function ($query) use ($nama_bank) {
            $query->whereRaw('LOWER(nama_bank) = ?', [strtolower($nama_bank)]);
        })->first();

        if ($bank) {
            return redirect()->back()->with('error', 'Data Bank ' . $nama_bank . ' sudah ada !');
        } else {

            $data = [ 'nama_bank' => $nama_bank];

            DB::table('bank')->insert($data);

            return redirect()->back()->with('success', 'Data berhasil disimpan!');
        }
    }

    public function update(Request $request, $id)
    {
        $role = Auth::user()->role;
        if (($role == 5))
        {
            $bank = DB::table('bank')->where('id',$id)->update([
                'nama_bank' => $request->nama_bank
            ]);

            return redirect()->back()->with('success','Data berhasil diupdate !');
        }else{
            return redirect()->back()->with('error','Anda tidak memiliki hak akses');
        }
    }

    public function destroy($id)
    {
        $bank = DB::table('bank')->find($id);
        $bank->delete();
        return redirect()->back()->with('success', 'Data Bank berhasil dihapus');
    }

}
