<?php

namespace App\Http\Controllers\API;

use App\Models\Tidakmasuk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TidakmasukController extends Controller
{
    public function getAllData(Request $request)
    {
        $limit      = $request->input('limit',10);
        $nik        = $request->input('nik');
        $nama       = $request->input('nama');
        $tidakmasuk = Tidakmasuk::with('departemen');

        if($nik)
        {
            $tidakmasuk = $tidakmasuk->find($nik);
        }

        if ($nama) {
            $tidakmasuk->where('nama', 'like', '%' . $nama . '%');
        }

        if ($tidakmasuk == NULL) {
            return ResponseFormatter::error(null, 'Data Tidakmasuk tidak ditemukan', 404);
        }

        return ResponseFormatter::success(
            $tidakmasuk->paginate($limit),
            'Data Tidak Masuk berhasil diambil'
        );
    }
}
