<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use PhpXmlRpc\Server;
use PhpXmlRpc\Request;
use PhpXmlRpc\Value;
use PhpXmlRpc\Response;
use App\Models\Absensi;

class AbsensiResponseController extends Controller
{

    public function index()
    {
        // Mengambil data absensi dari tabel
        $absensi = Absensi::all();

        // Array untuk menyimpan data hasil query
        $results = [];

        // Loop melalui setiap baris absensi
        foreach ($absensi as $row) {
            // Mendapatkan nama, jam masuk, dan jam keluar
            $nama       = $row->karyawans->nama;
            $tanggal    = \Carbon\Carbon::parse($row->tanggal)->format('d/m/Y');
            $jam_masuk  = \Carbon\Carbon::parse($row->jadwal_masuk)->format('H:i');
            $jam_pulang = \Carbon\Carbon::parse($row->jadwal_pulang)->format('H:i');
            $scan_masuk = \Carbon\Carbon::parse($row->jam_masuk)->format('H:i');
            $scan_keluar= \Carbon\Carbon::parse($row->jam_keluar)->format('H:i');
            $terlambat  = \Carbon\Carbon::parse($row->terlambat)->format('H:i');
            $plg_cepat  = \Carbon\Carbon::parse($row->plg_cepat)->format('H:i');
            $lembur     = \Carbon\Carbon::parse($row->lembur)->format('H:i');
            $jam_kerja  = \Carbon\Carbon::parse($row->jml_jamkerja)->format('H:i');
            $jml_hadir  = \Carbon\Carbon::parse($row-> jam_kerja)->format('H:i');
            // Membuat array dengan nilai XML-RPC
            $data = [
                new Value($nama, 'string'),
                new Value($tanggal, 'string'),
                new Value($jam_masuk, 'string'),
                new Value($jam_pulang, 'string'),
                new Value($scan_masuk, 'string'),
                new Value($scan_keluar, 'string'),
                new Value($terlambat, 'string'),
                new Value($plg_cepat, 'string'),
                new Value($lembur, 'string'),
                new Value($jam_kerja, 'string'),
                new Value($jml_hadir, 'string'),
            ];

            // Menambahkan array data ke hasil query
            $results[] = new Value($data, 'array');
        }

        // Membuat objek response dengan hasil query sebagai argumen
        $response = new Response(new Value($results, 'array'));

        // Mengirim respons XML-RPC
        return response($response->serialize(), 200, ['Content-Type' => 'text/xml']);
    }
}
