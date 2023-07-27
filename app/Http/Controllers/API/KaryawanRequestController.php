<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class KaryawanRequestController extends Controller
{
    public function getDataFromApi()
    {
        $client = new Client();
        $response = $client->request('GET', 'http://localhost:8000/api/karyawanResponse');

        $data = json_decode($response->getBody(), true);

        return view('api.karyawanRequest', ['data' => $data['data']]);
    }
}
