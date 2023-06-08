<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Karyawan; 
use Illuminate\Http\Request;


class KaryawanController extends Controller
{

    public function all(Request $request)
    {

        $id = $request->input('id');
        $limit = $request->input('limit', 6);
        $nama = $request->input('nama');
        $slug = $request->input('slug');
        $email = $request->input('email');
        $agama = $request->input('agama');

        if ($id) {
            $karyawan = Karyawan::find($id);

            if ($karyawan)
                return ResponseFormatter::success($karyawan, 'Data karyawan berhasil diambil');
            else
                return ResponseFormatter::error(null, 'Data produk tidak ada', 404);
        }

        if ($slug) {
            $karyawan = karyawan::where('slug', $slug)
                ->first();

            if ($karyawan)
                return ResponseFormatter::success($karyawan, 'Data produk berhasil diambil');
            else
                return ResponseFormatter::error(null, 'Data produk tidak ada', 404);
        }


        $karyawan = karyawan::with('keluarga');

        if ($nama)
            $karyawan->where('nama', 'like', '%' . $nama . '%');

        if ($email)
            $karyawan->where('email', 'like', '%' . $email . '%');

        if ($agama)
            $karyawan->where('agama', 'like', '%' . $agama . '%');

        return ResponseFormatter::success(
            $karyawan->paginate($limit),
            'Data list karyawan berhasil diambil'
        );
    }
}
