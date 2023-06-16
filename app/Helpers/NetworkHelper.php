<?php

namespace App\Helpers;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class NetworkHelper
{
    public function connectToIP($ipAddress)
    {
        $client = new Client();
        try {
            $response = $client->request('GET', $ipAddress);

            if ($response->getStatusCode() === 200) {
                // Koneksi berhasil
                return true;
            } else {
                // Koneksi gagal
                return false;
            }
        } catch (\Exception $e) {
            // Tangani kesalahan jika terjadi
            return false;
        }
    }
    public static function testConnection($ipAddress)
    {
        $pingCommand = "ping -c 1 " . $ipAddress;
        exec($pingCommand, $output, $status);

        if ($status === 0) {
            return true;
        } else {
            return false;
        }
    }
    public function connectToIP2($IP)
    {
        $client = new Client();
        try {
            $response = $client->request('GET', $IP);

            if ($response->getStatusCode() === 200) {
                // Koneksi berhasil
                return true;
            } else {
                // Koneksi gagal
                return false;
            }
        } catch (\Exception $e) {
            // Tangani kesalahan jika terjadi
            return false;
        }
    }
}
