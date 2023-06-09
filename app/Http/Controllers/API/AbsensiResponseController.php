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
            $nama = $row->karyawans->nama;
            $jamMasuk = $row->jam_masuk;
            $jamKeluar = $row->jam_keluar;

            // Membuat array dengan nilai XML-RPC
            $data = [
                new Value($nama, 'string'),
                new Value($jamMasuk, 'string'),
                new Value($jamKeluar, 'string'),
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
