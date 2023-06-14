<?php

namespace App\Http\Controllers\API;

use DOMDocument;
use PhpXmlRpc\Value;
use App\Models\Dummy;
use PhpXmlRpc\Client;
use SimpleXMLElement;
use PhpXmlRpc\Request;
use PhpXmlRpc\Response;
use App\Models\Absensis;
use App\Http\Controllers\Controller;
 
class AbsensiRequest extends Controller
{
    public function xmlRpcRequest() 
    {
        // $endpoint = 'http://hrms.test/xmlrpc';
        $client = new Client('http://192.168.100.51/iWsService');
        // $client = new Client('http://hrms.test/api/getabsensi-response');
        $headers = [
        'Content-Type' => 'application/xml'
        ];
        $body = '<GetAttLog>
            <ArgComKey xsi:type=\\"xsd:integer\\">0</ArgComKey>
            <Arg><PIN xsi:type=\\"xsd:integer\\">All</PIN></Arg>
        </GetAttLog>';
        $request = new Request('POST', $headers, $client,$body);
        $res = $client->send($request);
        dd($res);

        if ($res->faultCode()) 
        {
            // Tangani kesalahan jika terjadi saat permintaan XML-RPC
            // Misalnya, tampilkan pesan kesalahan atau kembalikan nilai null

            return null;
        }
        // $results = $res->value(raw_data);

        // return $results;
        // dd($res->raw_data);
        // echo $res;

        // $IP = '192.168.1.27';
        // $endpoint = 'http://hrms.test/xmlrpc';

        // $client = new Client($endpoint);

        // $argComKey = new Value(0, 'int');
        // $argPIN = new Value('All', 'int');

        // // Membuat permintaan XML-RPC
        // $request = new Request('GetAttLog', [
        //     new Value([
        //         'ArgComKey' => $argComKey,
        //         'Arg' => new Value([
        //             'PIN' => $argPIN
        //         ], 'struct')
        //     ], 'struct')
        // ]);
        // //Mengirim permintaan XML-RPC
        // $response = $client->send($request);
        // // Mendapatkan data dari respons XML-RPC
        // $xmlResponse = $response->value();
        // dd($xmlResponse);

        // // Melakukan pemrosesan terhadap hasil respons
        // $results = [];
        // // dd($results);
        // // if(isset($xmlResponse))
        // // {
        // //     $PIN = (integer) $xmlResponse->PIN;
        // //     $dateTime = (string) $xmlResponse->DateTime;
        // //     $verified = (string) $xmlResponse->Verified;
        // //     $status = (string) $xmlResponse->Status;
        // //     $workCode = (string) $xmlResponse->WorkCode;
    
        // //     // Menyimpan hasil pemrosesan dalam array
        // //     $results[] = [
        // //         'PIN' => $PIN,
        // //         'dateTime' => $dateTime,
        // //         'verified' => $verified,
        // //         'status' => $status,
        // //         'workCode' => $workCode,
        // //     ];
        // // }
        // // Menggunakan hasil pemrosesan sesuai kebutuhan Anda
        // // $results = $this->xmlRpcResponse($xmlResponse->value());
        // return $results;
    } 

    public function xmlRpcResponse()
    {
        $results = Dummy::all()->toArray();
        // dd($results);
        // $results = [
        //     [
        //         'PIN' => 'XXXXX1',
        //         'DateTime' => 'YYYY-MM-DD HH:MM:SS1',
        //         'Verified' => 'X1',
        //         'Status' => 'X1',
        //         'WorkCode' => 'XXXXX1',
        //     ],
        //     [
        //         'PIN' => 'XXXXX2',
        //         'DateTime' => 'YYYY-MM-DD HH:MM:SS1',
        //         'Verified' => 'X1',
        //         'Status' => 'X1',
        //         'WorkCode' => 'XXXXX1',
        //     ],
        //     // Tambahkan data dummy lainnya sesuai kebutuhan
        // ];
        // dd($results);
        $processedResults = [];

        foreach ($results as $row) {
            $PIN = (string) $row['noid'];
            $dateTime = (string) $row['tanggal'];
            $verified = (string) $row['scan_masuk'];
            $status = (string) $row['scan_keluar'];
            $workCode = (string) $row['nama'];

            // Menyimpan hasil pemrosesan dalam array
            $data = [
                // new Value($PIN),
                // new Value($dateTime),
                // new Value($verified),
                // new Value($status),
                // new Value($workCode),
                'PIN' => $PIN,
                'DateTime' => $dateTime,
                'Verified' => $verified,
                'Status' => $status,
                'WorkCode' => $workCode,
            ];
            $processedResults[] = $data;
        }
        // foreach ($results as $row) {
        //     $noid       = (string) $row['noid'];
        //     $nama       = (string) $row['nama'];
        //     $tanggal    = (string) $row['tanggal'];
        //     $jam_masuk  = (string) $row['jam_masuk'];
        //     $jam_pulang = (string) $row['jam_pulang'];
        //     $scan_masuk = (string) $row['scan_masuk'];
        //     $scan_keluar= (string) $row['scan_keluar'];
        //     $terlambat  = (string) $row['terlambat'];
        //     $plg_cepat  = (string) $row['plg_cepat'];
        //     $lembur     = (string) $row['lembur'];
        //     $jam_kerja  = (string) $row['jam_kerja'];
        //     $jml_hadir  = (string) $row['jml_hadir'];

        //     // Menyimpan hasil pemrosesan dalam array
        //     $data = [
        //         'noid'       => $noid,
        //         'nama'       => $nama,
        //         'tanggal'    => $tanggal,
        //         'jam_masuk'  => $jam_masuk,
        //         'jam_pulang' => $jam_pulang,
        //         'scan_masuk' => $scan_masuk,
        //         'scan_keluar'=> $scan_keluar,
        //         'terlambat'  => $terlambat,
        //         'plg_cepat'  => $plg_cepat,
        //         'lembur'     => $lembur,
        //         'jam_kerja'  => $jam_kerja,
        //         'jml_hadir'  => $jml_hadir,

        //     ];
        //     $processedResults[] = $data;
        // }

        // Membuat objek response dengan hasil query sebagai argumen
        $response = [
            'GetAttLogResponse' => [
                'Row' => $processedResults,
            ],
        ];

        $xmlstr = <<<XML
            <?xml version='1.0'?>
            <methodResponse>
            </methodResponse>
            XML;
        // Mengubah array response menjadi XML
        $xml = new SimpleXMLElement($xmlstr);
        
        $this->arrayToXml($response, $xml);

        // Mengirim respons XML-RPC
        return response($xml->asXML(), 200, ['Content-Type' => 'text/xml']);
    }

    private function arrayToXml($data, &$xml)
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                if (is_numeric($key)) {
                    $key = 'item' . $key;
                }
                $subnode = $xml->addChild($key);
                $this->arrayToXml($value, $subnode);
            } else {
                $xml->addChild("$key", htmlspecialchars("$value"));
            }
        }
    }

}

 // dd($xmlResponse);
            // foreach ($xmlResponse as $row) 
            // {
            //     $PIN = (string) $row->PIN;
            //     $dateTime = (string) $row->DateTime;
            //     $verified = (string) $row->Verified;
            //     $status = (string) $row->Status;
            //     $workCode = (string) $row->WorkCode;
        
            //     // Menyimpan hasil pemrosesan dalam array
            //     $results[] = [
            //         'PIN' => $PIN,
            //         'dateTime' => $dateTime,
            //         'verified' => $verified,
            //         'status' => $status,
            //         'workCode' => $workCode,
            //     ];
            // }


 // foreach ($results as $row) {
        //     $PIN = (string) $row->PIN;
        //     $dateTime = (string) $row->DateTime;
        //     $verified = (string) $row->Verified;
        //     $status = (string) $row->Status;
        //     $workCode = (string) $row->WorkCode;
        //     // Menyimpan hasil pemrosesan dalam array
        //     $data = [
        //         new Value($PIN, 'string'),
        //         new Value($dateTime, 'string'),
        //         new Value($verified, 'string'),
        //         new Value($status, 'string'),
        //         new Value($workCode, 'string'),
        //     ];
        //     $results[] = new Value($data, 'array');
        // }
        // $data = [
        //     new Value($PIN),
        //     new Value($dateTime),
        //     new Value($verified),
        //     new Value($status),
        //     new Value($workCode),
        // ];
        // $results[] = new Value($data);