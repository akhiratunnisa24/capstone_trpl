<?php

namespace App\Http\Controllers\API;

use App\Models\Absensi;
use App\Models\Absensis;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AbsensiController extends Controller
{
    public function getAllAbsensi(Request $request)
    {
        $limit      = $request->input('limit',10);
        $nik        = $request->input('nik');
        $nama       = $request->input('nama');

        $absensi    = Absensi::with('karyawans','departemens');
        if($nik)
        {
            $absensi->where('nik', $nik);
        }

        if($nama)
        {
            $absensi->whereHas('karyawans', function ($query) use ($nama) {
                $query->where('nama', 'like', '%' . $nama . '%');
            });
        }

        $absensi = $absensi->paginate($limit);
        if ($absensi == NULL) {
            return ResponseFormatter::error(null, 'Data Absensi tidak ditemukan', 404);
        }

        return ResponseFormatter::success(
            $absensi,
            'Data Absensi berhasil diambil'
        );
    }
}
