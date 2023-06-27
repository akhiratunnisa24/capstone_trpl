<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Helpers\NetworkHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;
use GuzzleHttp\Client;


class TesKoneksiController extends Controller
{
    public function testConnection(Request $request)
    {
        // $ipAddress = $request->input('192.168.100.51');
        $ipAddress = $request->input('192.168.1.8');
        // $port = 4370; // Port yang akan diuji (misalnya, port 80 untuk HTTP)

        $connection = fsockopen($ipAddress, 5);

        if ($connection) {
            fclose($connection);
            return response()->json(['status' => 'success nihhh', 'message' => 'Koneksi berhasil banget pokoknya.']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Koneksi gagal: ' ]);
        }
    }

    public function testConnection2(Request $request)
    {
        $IP = $request->input("192.168.100.51");
        $Connect = fsockopen($IP, "4370", $errno, $errstr, 5);
        $Key = "0";

        if ($Connect) {
            $soap_request = "<GetAttLog><ArgComKey xsi:type=\"xsd:integer\">" . $Key . "</ArgComKey><Arg><PIN xsi:type=\"xsd:integer\">All</PIN></Arg></GetAttLog>";
            $newLine = "\r\n";
            fputs($Connect, "POST /iWsService HTTP/1.0" . $newLine);
            fputs($Connect, "Content-Type: text/xml" . $newLine);
            fputs($Connect, "Content-Length: " . strlen($soap_request) . $newLine . $newLine);
            fputs($Connect, $soap_request . $newLine);
            $buffer = "";
            while ($Response = fgets($Connect, 1024)) {
                $buffer = $buffer . $Response;
            }
        } else echo "Koneksi Gagal"; {
            include("parse.php");
            $buffer = Parse_Data($buffer, "<GetAttLogResponse>", "</GetAttLogResponse>");
            $buffer = explode("\r\n", $buffer);
            for ($a = 0; $a < count($buffer); $a++) {
                $data = Parse_Data($buffer[$a], "<Row>", "</Row>");
                $PIN = Parse_Data($data, "<PIN>", "</PIN>");
                $DateTime = Parse_Data($data, "<DateTime>", "</DateTime>");
                $Verified = Parse_Data($data, "<Verified>", "</Verified>");
                $Status = Parse_Data($data, "<Status>", "</Status>");
            }
        }
    }

    public function testConnection3()
    {
        $ipAddress = '192.168.100.51'; // IP MESIN GRM
        // $ipAddress = '192.168.1.8'; // Ganti dengan alamat IP perangkat yang ingin Anda tes

        if (NetworkHelper::testConnection($ipAddress)) {
            return "Koneksi berhasil, menggunakan ping -c1 !";
        } else {
            return "Koneksi gagal !";
        }
    }
    public function testConnection4()
    {
        $ipAddress = '192.168.1.8'; // Ganti dengan alamat IP perangkat yang ingin Anda tes
        if (NetworkHelper::testConnection($ipAddress)) {
            return view('konekip');
        } else {
            return view('tidakkonekip');
        }
    }
    public function testConnection5()
    {
        $ipAddress = '192.168.1.58'; // Ganti dengan alamat IP yang ingin Anda tuju

        try {
            $response = Http::timeout(10)->get("$ipAddress");
            // Lakukan sesuatu dengan $response
            return response('Connection successful');
        } catch (RequestException $e) {
            // Tangani jika terjadi kesalahan koneksi
            return response('Connection failed: ' . $e->getMessage(), 500);
        }
    }

    public function connectToIP($ipAddress)
    {
        $client = new Client();
        $url = 'http://' . $ipAddress;
        $response = $client->get($url);

        // Lakukan sesuatu dengan respons
        $statusCode = $response->getStatusCode();
        $content = $response->getBody()->getContents();

        // Contoh output
        echo 'Status Code: ' . $statusCode . PHP_EOL;
        echo 'Response Body: ' . $content . PHP_EOL;
    }
    public function testConnectionguzzle()
    {
        // $ipAddress = '192.168.100.51'; // Ganti dengan IP Address yang ingin Anda hubungi
        $ipAddress = '192.168.1.8'; // Ganti dengan IP Address yang ingin Anda hubungi
        $this->connectToIP($ipAddress);
    }
}
