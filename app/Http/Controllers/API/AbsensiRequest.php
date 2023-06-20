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
use App\Helpers\AbsensiHelper;
 
class AbsensiRequest extends Controller
{

    //xmlrpcrequest ke localhost
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

    //xmlrpc response untuk localhost
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

    //xmlrpc request ke IP lain
    public function amlrpcRequest($IP,$Key)
    {
        $absensiHelper = new AbsensiHelper();
        $isConnected = $absensiHelper->connectToIP($IP);

        if ($isConnected) {
            // Koneksi berhasil terbentuk
            echo "Terhubung ke alamat IP: $IP";

            // Lanjutkan dengan pemrosesan XML-RPC menggunakan $IP dan $Key
            $httpClient = new GuzzleClient();

            // Membuat objek XmlRpcEncoder
            $encoder = new Encoder();

            // Membuat array data parameter untuk permintaan XML-RPC
            // $params = [
            //     new Value(0, 'int'), // ArgComKey
            //     new Value('All', 'int'), // Arg->PIN
            // ];
            // $params = [
            //     new Value(0, 'integer'), // ArgComKey
            //     [
            //         'PIN' => new Value('All', 'integer') // Arg->PIN
            //     ]
            // ];

            $params = '<GetAttLog>
                <ArgComKey xsi:type=\\"xsd:integer\\">0</ArgComKey>
                <Arg><PIN xsi:type=\\"xsd:integer\\">All</PIN></Arg>
            </GetAttLog>';

            // Mengubah array data parameter menjadi XML menggunakan XmlRpcEncoder
            $xmlParams = $encoder->encode($params)->serialize();

            // Membuat objek permintaan HTTP menggunakan Guzzle
            // $port = 4370;
            $headers = [
                'Content-Type' => 'application/xml'
                ];
            $port = 80;
            $response = $httpClient->post("http://$IP:$port/iWsService", [
                'headers' => $headers,
                'body' => $xmlParams,
            ]);
            dd($response->getHeaders(),$response->getBody()->getContents());
            
            // Mendapatkan konten respons XML
            $xmlResponse = trim($response->getBody()->getContents());
            $xmlResponse = preg_replace('/[^\x{9}\x{A}\x{D}\x{20}-\x{D7FF}\x{E000}-\x{FFFD}\x{10000}-\x{10FFFF}]/u', '', $xmlResponse);
            $xmlRespons = str_replace('◀', '', $xmlResponse);
            $xmlRes = str_replace('▶', '', $xmlRespons);

            dd($xmlRes);
            // Konversi menjadi objek SimpleXMLElement
            $xmlObject = simplexml_load_string($xmlRes);

            // Konversi objek SimpleXMLElement menjadi array
            $xmlArray = json_decode(json_encode($xmlObject), true);
            return $xmlArray;

        } else {
            echo "Gagal terhubung ke alamat IP: $IP";
        }
    }

    //xmlrpc response ke IP lain
    public function amlRpcResponse($xmlArray)
    {
        $results = json_decode($xmlArray, true);
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

 