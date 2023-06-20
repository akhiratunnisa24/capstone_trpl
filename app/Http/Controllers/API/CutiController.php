<?php

namespace App\Http\Controllers\API;

use App\Models\Cuti;
use GuzzleHttp\Client;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;

class CutiController extends Controller
{
    //get All data
    public function getAllCuti(Request $request)
    {
        $limit      = $request->input('limit',10);
        $nik        = $request->input('nik');
        $nama       = $request->input('nama');
        $jeniscutis = $request->input('jeniscuti');
        $status     = $request->input('status');
        $cuti       = Cuti::with('jeniscutis', 'karyawans', 'status', 'departemens');

        if($nik)
        {
            $cuti = Cuti::find($nik);
        }

        if($nama)
        {
            $cuti->whereHas('karyawans', function ($query) use ($nama) {
                $query->where('nama', 'like', '%' . $nama . '%');
            });
        }

        if($jeniscutis) 
        {
            $cuti->whereHas('jeniscutis', function ($query) use ($jeniscutis) {
                $query->where('jeniscutis.jenis_cuti', 'like', '%' . $jeniscutis . '%');
            });
        }

        if($status) 
        {
            $cuti->whereHas('status', function ($query) use ($status) {
                $query->where('status.name_status', 'like', '%' . $status . '%');
            });
        }

        $cuti = $cuti->paginate($limit);

        if ($cuti == NULL) {
            return ResponseFormatter::error(null, 'Data cuti tidak ditemukan', 404);
        }

        $dataCuti = [];
        foreach($cuti as $item)
        {
            $data = [
                'id'                => $item->id,
                'tgl_permohonan'    => $item->tgl_permohonan,
                'nik'               => $item->nik,
                'id_karyawan'       => $item->id_karyawan,
                'nama'              => $item->karyawans->nama,
                'jabatan'           => $item->jabatan,
                'departemen'        => $item->departemens->nama_departemen,
                'id_jeniscuti'      => $item->id_jeniscuti,
                'jeniscuti'         => $item->jeniscuti->jenis_cuti,
                'id_alokasi'        => $item->id_alokasi,
                'id_settingalokasi' => $item->id_settingalokasi,
                'keperluan'         => $item->keperluan,
                'tgl_mulai'         => $item->tgl_mulai ,
                'tgl_selesai'       => $item->tgl_selesai ,
                'jmlharikerja'      => $item->jmlharikerja ,
                'saldohakcuti'      => $item->saldohakcuti ,
                'jml_cuti'          => $item->jml_cuti,
                'sisacuti'          => $item->sisacuti ,
                'keterangan'        => $item->keterangan ,
                'status'            => $item->statuses->name_status ,
                'catatan'           => $item->catatan ,
                'tgldisetujui_a'    => $item->tgldisetujui_a,
                'tgldisetujui_b'    => $item->tgldisetujui_b,
                'tglditolak'        => $item->tglditolak,
                'batal_atasan'      => $item->batal_atasan,
                'batal_pimpinan'    => $item->batal_pimpinan,
                'batalditolak'      => $item->batalditolak,
                'ubah_atasan'       => $item->ubah_atasan,
                'ubah_pimpinan'     => $item->ubah_pimpinan,
                'ubahditolak'       => $item->ubahditolak
            ];

            $dataCuti[] = $data;
        }

        $dataCuti = collect($dataCuti);
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = $limit;

        $currentPageItems = $dataCuti->slice(($currentPage - 1) * $perPage, $perPage);
        $paginator = new LengthAwarePaginator($currentPageItems, count($dataCuti), $perPage);
        $paginator->setPath(url()->current());

        return ResponseFormatter::success(
            $paginator,
            'Data cuti berhasil diambil'
        );
    }
}
