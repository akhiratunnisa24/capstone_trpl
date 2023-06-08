<?php

namespace App\Helpers;

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
}
