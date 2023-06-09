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



Route::post('cutiRequest', 'API\CutiRequestController@index');
Route::get('cutiResponse', 'API\CutiResponseController@all');



Route::get('xmlrpc', 'API\AbsensiResponseController@index');


Route::get('/get-absensi', 'API\AbsensiRequest@xmlRpcRequest');
Route::get('/getabsensi-response', 'API\AbsensiRequest@xmlRpcResponse');



