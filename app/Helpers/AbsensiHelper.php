<?php

namespace App\Helpers;

use GuzzleHttp\Client;

class AbsensiHelper
{
    public function connectToIP($IP)
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
