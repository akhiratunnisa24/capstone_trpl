<?php

namespace App\Http\Controllers\API;

use App\Models\Izin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;

class IzinController extends Controller
{
    public function getAllizin(Request $request)
    {
        $limit      = $request->input('limit',10);
        $nik        = $request->input('nik');
        $nama       = $request->input('nama');
        $jenisizins = $request->input('jenisizin');
        $status     = $request->input('status');
        $izin       = Izin::with('jenisizins', 'karyawans', 'statuses', 'departemens');

        if($nik)
        {
            $izin = $izin->find($nik);
        }

        if($nama)
        {
            $izin->whereHas('karyawans', function ($query) use ($nama) {
                $query->where('nama', 'like', '%' . $nama . '%');
            });
        }

        if($jenisizins) 
        {
            $izin->whereHas('jenisizins', function ($query) use ($jenisizins) {
                $query->where('jenisizins.jenis_izin', 'like', '%' . $jenisizins . '%');
            });
        }

        if($status) 
        {
            $izin->whereHas('status', function ($query) use ($status) {
                $query->where('status.name_status', 'like', '%' . $status . '%');
            });
        }


        if ($izin == NULL) {
            return ResponseFormatter::error(null, 'Data Izin tidak ditemukan', 404);
        }

        return ResponseFormatter::success(
            $izin->paginate($limit),
            'Data Izin/Sakit berhasil diambil'
        );

        // foreach($izin as $item)
        // {
        //     $data = [
        //         'id'                => $item->id,
        //         'tgl_permohonan'    => $item->tgl_permohonan,
        //         'nik'               => $item->nik,
        //         'id_karyawan'       => $item->id_karyawan,
        //         'nama'              => $item->karyawans->nama,
        //         'jabatan'           => $item->jabatan,
        //         'departemen'        => $item->departemens->nama_departemen,
        //         'id_jenisizin'      => $item->id_jenisizin,
        //         'jenisizin'         => $item->jenisizins->jenis_izin,
        //         'keperluan'         => $item->keperluan,
        //         'tgl_mulai'         => $item->tgl_mulai ,
        //         'tgl_selesai'       => $item->tgl_selesai ,
        //         'jam_mulai'         => $item->jam_mulai ,
        //         'jam_selesai'       => $item->jam_selesai ,
        //         'tgl_setuju_a'      => $item->tgl_setuju_a,
        //         'tgl_setuju_b'      => $item->tgl_setuju_b,
        //         'tgl_ditolak'       => $item->tgl_ditolak,
        //         'jml_hari'          => $item->jml_hari,
        //         'jml_jam'           => $item->jml_jam,
        //         'batal_atasan'      => $item->batal_atasan,
        //         'batal_pimpinan'    => $item->batal_pimpinan,
        //         'batalditolak'      => $item->batalditolak,
        //         'ubah_atasan'       => $item->ubah_atasan,
        //         'ubah_pimpinan'     => $item->ubah_pimpinan,
        //         'ubahditolak'       => $item->ubahditolak,
        //         'status'            => $item->statuses->name_status ,
        //         'catatan'           => $item->catatan ,
        //     ];

        //     $dataIzin[] = $data;
        // }

        // $dataIzin = collect($dataIzin);
        // $currentPage = LengthAwarePaginator::resolveCurrentPage();
        // $perPage = $limit;

        // $currentPageItems = $dataIzin->slice(($currentPage - 1) * $perPage, $perPage);
        // $paginator = new LengthAwarePaginator($currentPageItems, count($dataIzin), $perPage);
        // $paginator->setPath(url()->current());

        // return ResponseFormatter::success(
        //     $paginator,
        //     'Data Izin/Sakit berhasil diambil'
        // );

    }
}
