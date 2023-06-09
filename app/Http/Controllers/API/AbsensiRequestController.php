<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use PhpXmlRpc\Client;
use PhpXmlRpc\Request;
use PhpXmlRpc\Value;

class AbsensiRequestController extends Controller
{
    public function makeRequest()
    {
        // Membuat objek permintaan XML-RPC
        $request = new Request('getAbsensiData');

        // Menambahkan parameter permintaan XML-RPC
        $params = [
            new Value('your_username', 'string'), // Ganti dengan username yang valid
        ];
        $request->addParam(new Value($params, 'array'));

        // Membuat objek klien XML-RPC dan mengirimkan permintaan
        $client = new Client('http://localhost:8000/api/xmlrpc'); // Ganti dengan URL endpoint XML-RPC yang valid
        $response = $client->send($request);

        // Mendapatkan hasil respons XML-RPC
        $xmlResponse = $response->value();

        // Melakukan pemrosesan terhadap hasil respons
        $results = [];
        foreach ($xmlResponse as $data) {
            $nama = $data->scalarval();
            $jamMasuk = $data->arrayMem(1)->scalarval();
            $jamKeluar = $data->arrayMem(2)->scalarval();

            // Menyimpan hasil pemrosesan dalam array
            $results[] = [
                'nama' => $nama,
                'jam_masuk' => $jamMasuk,
                'jam_keluar' => $jamKeluar,
            ];
        }

        // Menggunakan hasil pemrosesan sesuai kebutuhan Anda
        return $results;
    }
}
