<?php

namespace App\Http\Controllers\API;

use PhpXmlRpc\Value;
use App\Models\Absensis;
use PhpXmlRpc\Client;
use PhpXmlRpc\Request;
use PhpXmlRpc\Response;
use App\Http\Controllers\Controller;
 
class AbsensiRequest extends Controller
{
    public function xmlRpcRequest() 
    {
        $IP = '192.168.10.217';
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
        if(isset($xmlResponse))
        {
                $PIN = (integer) $xmlResponse->PIN;
                $dateTime = (string) $xmlResponse->DateTime;
                $verified = (string) $xmlResponse->Verified;
                $status = (string)   $xmlResponse->Status;
                $workCode = (string) $xmlResponse->WorkCode;
        
                // Menyimpan hasil pemrosesan dalam array
                $results[] = [
                    'PIN' => $PIN,
                    'dateTime' => $dateTime,
                    'verified' => $verified,
                    'status' => $status,
                    'workCode' => $workCode,
                ];

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
        }
        
        // Menggunakan hasil pemrosesan sesuai kebutuhan Anda
        $results = $this->xmlRpcResponse($xmlResponse);
        return $results;

    } 

    public function xmlRpcResponse()
    {
        $results = [];

        foreach ($results as $row) {
            $PIN = (string) $row->PIN;
            $dateTime = (string) $row->DateTime;
            $verified = (string) $row->Verified;
            $status = (string) $row->Status;
            $workCode = (string) $row->WorkCode;
            // Menyimpan hasil pemrosesan dalam array
            $data = [
                new Value($PIN, 'string'),
                new Value($dateTime, 'string'),
                new Value($verified, 'string'),
                new Value($status, 'string'),
                new Value($workCode, 'string'),
            ];
            $results[] = new Value($data, 'array');
        }

        // Membuat objek response dengan hasil query sebagai argumen
        $response = new Response(new Value($results, 'array'));

        // Mengirim respons XML-RPC
        return response($response->serialize(), 200, ['Content-Type' => 'text/xml']);
    }

}