<?php

namespace App\Http\Controllers\API;

use DOMDocument;
use PhpXmlRpc\Value;
use App\Models\Dummy;
use PhpXmlRpc\Encoder;
use SimpleXMLElement;
use PhpXmlRpc\Request;
use PhpXmlRpc\Response;
use App\Models\Absensis;
use GuzzleHttp\Client as GuzzleClient;
use App\Http\Controllers\Controller;
 
class AbsensiRequest extends Controller
{
    // public function xmlRpcRequest() 
    // {
        // $client = new Client('http://hrms.test/api/absensi-response');
        // $headers = [
        // 'Content-Type' => 'application/xml'
        // ];
        // $body = '<GetAttLog>
        //     <ArgComKey xsi:type=\\"xsd:integer\\">0</ArgComKey>
        //     <Arg><PIN xsi:type=\\"xsd:integer\\">All</PIN></Arg>
        // </GetAttLog>';
         
        // $request = new Request('GET',$headers, $client,$body);

        // $response = $client->send($request);

    //     $xmlResponse = $response->raw_data;
    //     dd($response);
    //    // Menggunakan preg_match untuk mengekstrak bagian XML dari respons
    //     if (preg_match('/<\?xml version="1.0"\>\n(.*)<\/methodResponse>/s', $xmlResponse, $matches)) 
    //     {
    //         $xml = $matches[1];
    //         dd($xml);
    //         $xmlObject = simplexml_load_string($xml);
    //         // dd($xmlObject);
    //         $json = json_encode($xmlObject);
    //         $array = json_decode($json, true);
    //         // Lakukan perulangan untuk mengakses setiap item
    //         foreach ($array['GetAttLogResponse']['Row'] as $item) {
    //             // Akses data di dalam setiap item
    //             $PIN = $item['PIN'];
    //             $DateTime = $item['DateTime'];
    //             $Verified = $item['Verified'];
    //             $Status = $item['Status'];
    //             $WorkCode = $item['WorkCode'];

    //             $result[] = [
    //                 'PIN' => $PIN,
    //                 'DateTime' => $DateTime,
    //                 'Verified' => $Verified,
    //                 'Status' => $Status,
    //                 'WorkCode' => $WorkCode
    //             ];
    //             dd($result);
    //         }
    //     } else {
    //         // Jika tidak dapat menemukan bagian XML, tangani di sini
    //         // ...
    //         return "tidak ada data";
    //     }
        
    // } 

    // public function xmlRpcResponse()
    // {
    //     $results = Dummy::all()->toArray();
    //     $processedResults = [];

    //     foreach ($results as $row) {
    //         $PIN = (string) $row['noid'];
    //         $dateTime = (string) $row['tanggal'];
    //         $verified = (string) $row['scan_masuk'];
    //         $status = (string) $row['scan_keluar'];
    //         $workCode = (string) $row['nama'];

    //         // Menyimpan hasil pemrosesan dalam array
    //         $data = [
    //             'PIN' => $PIN,
    //             'DateTime' => $dateTime,
    //             'Verified' => $verified,
    //             'Status' => $status,
    //             'WorkCode' => $workCode,
    //         ];
    //         $processedResults[] = $data;
    //     }
    //     // Membuat objek response dengan hasil query sebagai argumen
    //     $response = [
    //         'GetAttLogResponse' => [
    //             'Row' => $processedResults,
    //         ],
    //     ];
    //     $xmlstr = <<<XML
    //         <methodResponse>
    //         </methodResponse>
    //         XML;
    //     // Mengubah array response menjadi XML
    //     $xml = new SimpleXMLElement($xmlstr);
    //     $this->arrayToXml($response, $xml);

    //     // Mengirim respons XML-RPC
    //     return response($xml->asXML(), 200, ['Content-Type' => 'text/xml']);
    // }

    public function xmlRpcRequest()
    {
        //Membuat objek GuzzleHttp\Client
        $httpClient = new GuzzleClient();

        // Membuat objek XmlRpcEncoder
        $encoder = new Encoder();

        // Membuat array data parameter untuk permintaan XML-RPC
        $params = [
            new Value(0, 'int'), // ArgComKey
            new Value('All', 'int'), // Arg->PIN
        ];

        // Mengubah array data parameter menjadi XML menggunakan XmlRpcEncoder
        $xmlParams = $encoder->encode($params)->serialize();

        // Membuat objek permintaan HTTP menggunakan Guzzle
        $response = $httpClient->post('http://hrms.test/api/absensi-response', [
            'headers' => [
                'Content-Type' => 'text/xml',
            ],
            'body' => $xmlParams,
        ]);
        // $client = new GuzzleClient();
        // $headers = [
        //     'Content-Type' => 'application/xml'
        // ];
        // $body = '<GetAttLog>
        // <ArgComKey xsi:type="xsd:integer">0</ArgComKey>
        // <Arg><PIN xsi:type="xsd:integer">All</PIN></Arg>
        // </GetAttLog>';
        
        // $response = $client->post('http://hrms.test/api/absensi-response', [
        //     'headers' => $headers,
        //     'body' => $body,
        // ]);

        // Mendapatkan konten respons XML
        $xmlResponse = trim($response->getBody()->getContents());
        $xmlResponse = preg_replace('/[^\x{9}\x{A}\x{D}\x{20}-\x{D7FF}\x{E000}-\x{FFFD}\x{10000}-\x{10FFFF}]/u', '', $xmlResponse);
        $xmlRespons = str_replace('◀', '', $xmlResponse);
        $xmlRes = str_replace('▶', '', $xmlRespons);

        // Konversi menjadi objek SimpleXMLElement
        $xmlObject = simplexml_load_string($xmlRes);

        // Konversi objek SimpleXMLElement menjadi array
        $xmlArray = json_decode(json_encode($xmlObject), true);
        return $xmlArray;
    }

    public function xmlRpcResponse()
    {
        $results = Dummy::all()->toArray();
        $processedResults = [];
    
        foreach ($results as $row) {
            $PIN = (string) $row['noid'];
            $dateTime = (string) $row['tanggal'];
            $verified = (string) $row['scan_masuk'];
            $status = (string) $row['scan_keluar'];
            $workCode = (string) $row['nama'];
    
            // Menyimpan hasil pemrosesan dalam array
            $data = [
                'PIN' => $PIN,
                'DateTime' => $dateTime,
                'Verified' => $verified,
                'Status' => $status,
                'WorkCode' => $workCode,
            ];
            $processedResults[] = $data;
        }
    
        // Membuat array response
        $response = [
            'GetAttLogResponse' => [
                'Row' => $processedResults,
            ],
        ];
    
        // Membuat objek SimpleXMLElement untuk XML response
        $xmlResponse = new SimpleXMLElement('<methodResponse></methodResponse>');
        $this->arrayToXml($response, $xmlResponse);
        
        // Mengirim respons XML-RPC
        return response($xmlResponse->asXML(), 200, ['Content-Type' => 'text/xml']);

    }
    
    private function arrayToXml($data, &$xmlData)
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                if (!is_numeric($key)) {
                    $subnode = $xmlData->addChild("$key");
                    $this->arrayToXml($value, $subnode);
                } else {
                    $subnode = $xmlData->addChild("item$key");
                    $this->arrayToXml($value, $subnode);
                }
            } else {
                $xmlData->addChild("$key", htmlspecialchars("$value"));
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