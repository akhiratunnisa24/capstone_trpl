<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AbsensiRequest;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); 

Route::get('karyawanResponse', 'API\KaryawanResponseController@all');
Route::get('karyawanRequest', 'API\KaryawanRequestController@getDataFromApi');
// Route::get('karyawan', [KaryawanController::class, 'all']);
Route::post('/absensi/request', 'API\AbsensiRequest@xmlRpcRequest');
Route::get('xmlrpc', 'API\AbsensiResponseController@index');
Route::get('xmlrpcRequest', 'API\AbsensiRequestController@makeRequest');


// Route::post('cutiRequest', 'API\CutiRequestController@index');
// Route::get('cutiResponse', 'API\CutiResponseController@all');


Route::get('/get-absensi', 'API\AbsensiRequest@xmlRpcRequest');
Route::post('/absensi-response', 'API\AbsensiRequest@xmlRpcResponse');
//untuk melihat data
// Route::get('/absensi-response', 'API\AbsensiRequest@xmlRpcResponse');



Route::get('/test-koneksi', 'API\TesKoneksiController@testConnection');
Route::get('/test-koneksi2', 'API\TesKoneksiController@testConnection2');
Route::get('/test-koneksi3', 'API\TesKoneksiController@testConnection3');
Route::get('/test-koneksi4', 'API\TesKoneksiController@testConnection4');
Route::get('/test-koneksi5', 'API\TesKoneksiController@testConnection5');


