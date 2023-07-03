<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AbsensiClients
{
    public function downloadLogData($ip, $key)
    {
        $soapRequest = "<GetAttLog><ArgComKey xsi:type=\"xsd:integer\">$key</ArgComKey><Arg><PIN xsi:type=\"xsd:integer\">All</PIN></Arg></GetAttLog>";
        $newLine = "\r\n";
        $port = 80;

        $response = Http::withHeaders([
            'Content-Type' => 'text/xml',
        ])->post("http://$ip:$port/iWsService", ['params' => $soapRequest]);        
        
        // dd($response);

        if ($response->successful()) {
            $buffer = $response->body();
            $parsedData = $this->parseData($buffer);
            return $parsedData;
        }

        return null;
    }

    private function parseData($data)
    {
        $data = " " . $data;
        $hasil = "";
        $awal = strpos($data, "<GetAttLogResponse>");
        if ($awal !== false) {
            $akhir = strpos(strstr($data, "<GetAttLogResponse>"), "</GetAttLogResponse>");
            if ($akhir !== false) {
                $hasil = substr($data, $awal + strlen("<GetAttLogResponse>"), $akhir - strlen("<GetAttLogResponse>"));
            }
        }
        $xmlResponse = simplexml_load_string($hasil);
        dd($xmlResponse);
    }

}
