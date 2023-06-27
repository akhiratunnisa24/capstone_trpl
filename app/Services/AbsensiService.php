<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AbsensiService
{
    public function downloadLogData($ip, $key)
    {
        $soapRequest = "<GetAttLog><ArgComKey xsi:type=\"xsd:integer\">$key</ArgComKey><Arg><PIN xsi:type=\"xsd:integer\">All</PIN></Arg></GetAttLog>";
        $newLine = "\r\n";

        $response = Http::withHeaders([
            'Content-Type' => 'text/xml',
        ])->post("http://$ip/iWsService", ['param' => $soapRequest]);        
        

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
       return simplexml_load_string($hasil);
    }
}
