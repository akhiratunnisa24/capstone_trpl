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
        $id_pegawai = $request->input('id_pegawai');
        $nama       = $request->input('nama');
        $tidakmasuk = Tidakmasuk::with('departemen');

        if ($id_pegawai) {
            $tidakmasuk = $tidakmasuk->where('id_pegawai', $id_pegawai);
        }

        if ($nama) {
            $tidakmasuk->where('nama', 'like', '%' . $nama . '%');
        }

        $tidakmasuk = $tidakmasuk->paginate($limit);

        if ($tidakmasuk->isEmpty()) {
            return ResponseFormatter::error(null, 'Data Tidakmasuk tidak ditemukan', 404);
        }

        return ResponseFormatter::success(
            $tidakmasuk,
            'Data Tidak Masuk berhasil diambil'
        );
    }
}
