<?php

namespace App\Http\Controllers\admin;

use PhpXmlRpc\Value;
use PhpXmlRpc\Client;
use SimpleXMLElement;
use PhpXmlRpc\Encoder;
use PhpXmlRpc\Decoder;
use App\Models\Absensi;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use PhpXmlRpc\Request as XmlRpcRequest;
use Illuminate\Support\Facades\Response;

class XmlController extends Controller
{
    public function index(Request $request)
    {
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->first();
        return view('php.tarik-data',compact('row'));
    }
    public function download(Request $request)
    {
        // $IP = $request->input('ip', '192.168.1.47');
        // $Key = $request->input('key', '0');

        // $client = new Client('http://' . $IP . '/iWsService');
        $client = new Client('http://hrms.test/api/getabsensi-response');

        $encoder = new Encoder();

        $headers = [
            'Content-Type' => 'application/xml'
            ];
        $body = '<GetAttLog>
                <ArgComKey xsi:type=\\"xsd:integer\\">0</ArgComKey>
                <Arg><PIN xsi:type=\\"xsd:integer\\">All</PIN></Arg>
            </GetAttLog>';

        // $request = new XmlRpcRequest('GetAttLog', [
        //     new Value(0, 'int'), // ArgComKey
        //     new Value(['PIN' => 'All'], 'struct'), // Arg
        // ]);
        $request = new XmlRpcRequest('POST',$headers,$client,$body);
        $response = $client->send($request);
        dd($response);
        $decodedResponse = $encoder->decode($response->value());

        if ($decodedResponse->faultCode()) 
        {
            return null;
        }
    
        return $this->xmlResponse($response);
    }


    // public function download(Request $request)
    // {
    //     $IP = $request->input('ip', '192.168.1.47');
    //     $Key = $request->input('key', '0');

    //     $client = new Client('http://' . $IP . '/iWsService');

    //     if (!$this->checkConnection($client)) {
    //         $response = [
    //             'status' => 'error',
    //             'message' => 'Gagal terkoneksi dengan mesin absensi.',
    //         ];
    //     }

    //     $response = [
    //         'status' => 'success',
    //         'message' => 'Berhasil terkoneksi dengan mesin absensi dan mengunduh data.',
    //         'IP' => $IP
    //     ];
    
    //     return $this->xmlResponse($response);
    // }

    // private function checkConnection($client)
    // {
    //     try {
    //         $method = new XmlRpcRequest('ping');
    //         $result = $client->send($method);

    //         if (!$result->faultCode()) {
    //             $IP = $client->server;
    //             $response = [
    //                 'status' => 'success',
    //                 'message' => 'Berhasil terkoneksi dengan mesin absensi.'
    //             ];
    //         } else {
    //             $response = [
    //                 'status' => 'error',
    //                 'message' => 'Gagal terkoneksi dengan mesin absensi.'
    //             ];
    //         }
    //     } catch (\Exception $e) {
    //         $response = [
    //             'status' => 'error',
    //             'message' => 'Gagal terkoneksi dengan mesin absensi.'
    //         ];
    //     }

    //     return $this->xmlResponse($response);
    // }


    // private function xmlResponse($data, $statusCode = 200)
    // {
    //     $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"><response></response>');
    //     $this->arrayToXml($data, $xml);

    //     return Response::make($xml->asXML(), $statusCode, [
    //         'Content-Type' => 'application/xml'
    //     ]);
    // }

    private function arrayToXml($data, &$xml)
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                if (is_numeric($key)) {
                    $key = 'item' . $key; // jika kunci array adalah angka, gunakan 'item' sebagai kunci
                }
                $subnode = $xml->addChild($key);
                $this->arrayToXml($value, $subnode);
            } else {
                $xml->addChild($key, htmlspecialchars($value));
            }
        }
    }

}
