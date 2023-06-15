<?php

namespace App\Helpers;
use Illuminate\Support\Facades\Http;

class NetworkHelper
{
    public function connectToIP($ipAddress)
    {
        $response = Http::timeout(10)->get('http://' . $ipAddress);
        $statusCode = $response->status();

        if ($statusCode >= 200 && $statusCode < 300) {
            return true;
        } else {
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
}
