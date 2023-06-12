<?php

namespace App\Http\Controllers\API;

use DOMDocument;
use PhpXmlRpc\Value;
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
        $IP = '192.168.10.205';
        $endpoint = 'http://'.$IP.'/xmlrpc';

        $client = new Client($endpoint);

        $argComKey = new Value(0, 'int');
        $argPIN = new Value('All', 'int');

        // Membuat permintaan XML-RPC
        $request = new Request('GetAttLog', [
            new Value([
                'ArgComKey' => $argComKey,
                'Arg' => new Value([
                    'PIN' => $argPIN
                ], 'struct')
            ], 'struct')
        ]);

        // dd($request);

        //Mengirim permintaan XML-RPC
        $response = $client->send($request);
        //dd($response);

        // Mendapatkan data dari respons XML-RPC
        $xmlResponse = $response->value();

        // Melakukan pemrosesan terhadap hasil respons
        $results = [];
        dd($results);
        if(isset($xmlResponse))
        {
            $PIN = (string) $xmlResponse->PIN;
            $dateTime = (string) $xmlResponse->DateTime;
            $verified = (string) $xmlResponse->Verified;
            $status = (string) $xmlResponse->Status;
            $workCode = (string) $xmlResponse->WorkCode;
    
            // Menyimpan hasil pemrosesan dalam array
            $results[] = [
                'PIN' => $PIN,
                'dateTime' => $dateTime,
                'verified' => $verified,
                'status' => $status,
                'workCode' => $workCode,
            ];
        }
        
        // Menggunakan hasil pemrosesan sesuai kebutuhan Anda
        $results = $this->xmlRpcResponse($xmlResponse->value());
        return $results;
    } 


    public function xmlRpcResponse()
    {
        $results = [];
        dd($results);

        foreach ($results as $row) {
            $PIN = (string) $row['PIN'];
            $dateTime = (string) $row['DateTime'];
            $verified = (string) $row['Verified'];
            $status = (string) $row['Status'];
            $workCode = (string) $row['WorkCode'];

            // Menyimpan hasil pemrosesan dalam array
            $data = [
                'PIN' => $PIN,
                'DateTime' => $dateTime,
                'Verified' => $verified,
                'Status' => $status,
                'WorkCode' => $workCode,
            ];
            $results[] = $data;
        }

        // Membuat objek response dengan hasil query sebagai argumen
        $response = [
            'GetAttLogResponse' => [
                'Row' => $results,
            ],
        ];

        // Mengubah array response menjadi XML
        $xml = new SimpleXMLElement('<root/>');
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